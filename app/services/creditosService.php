<?php 

namespace App\services;

use App\classes\serviceLocatorApp;
use App\Models\caja\cierrescajas;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\emisores;
use App\Models\configuraciones\mediospago;
use App\Models\configuraciones\usuarios;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\creditos\productosseparados;
use App\Models\creditos\separadomediopago;
use App\Models\factimpuestos;
use App\Models\inventario\productos_sub;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
use App\Repositories\contable\movimientos_cajaRepository;
use App\Repositories\creditos\creditosRepository;
use App\Repositories\creditos\cuotasRepository;
use App\Repositories\creditos\productsSeparadosRepository;
use App\Repositories\creditos\separadoMediopagoRepository;
use stdClass;

//**SERVICIO DE CREDITOS**//

class creditosService {

    //metodo llamado desde ventascontrolador.php
    public static function crearCredito(stdClass $valoresCredito, int $idfactura, int $idcliente, $totalunidades, $base, $valorimpuestototal, int $dctox100, $descuento, int $idcierrecaja, int $idcaja, int $idvendedor, int|string|null $idemisor = NULL){
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $credito = new creditosRepository();
        $entity = $credito->generarCredito((array)$valoresCredito, $idfactura, $idcliente, $totalunidades, $base, $valorimpuestototal, $dctox100, $descuento, $idvendedor, $idemisor); //llama metodo del repositorio
        $alertas = $entity->validar();
        if(empty($alertas)){
            $r = $credito->insert($entity);
            if($r[0]){
                $valoresCredito->id_credito = $r[1];
                $valoresCredito->cierrecaja_id = $idcierrecaja;
                $valoresCredito->cajaid = $idcaja;
                $valoresCredito->valorpagado = $valoresCredito->abonoinicial;
                //crear cuota con repositorio
                $cuotasRepo = new cuotasRepository();
                $valoresCredito->num_orden = $cuotasRepo->calcularNumOrden(id_sucursal());
                $rc = $cuotasRepo->insert(new cuotas((array)$valoresCredito));
                $alertas['exito'][] = "Credito creado con exito";
                $alertas['idcuota'] = $rc[1];
                //acatualizar deuda de cliente
                $cliente = clientes::find('id', $idcliente);
                $cliente->totaldebe += $valoresCredito->montototal;
                $cliente->actualizar();
            }else{
                $alertas['error'][] = "Credito creado con exito";
            }
        }
        return $alertas;
    }


    public static function ejecutarCrearSeparado(array $valoresCredito, array $carrito, array $mediospago, $valorefectivo):array{
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $separado = new creditosRepository();
        $getDB = $separado->getConexion();

        // Resolver en el servidor los productos e insumos que realmente se
        // descontaran, usando la configuracion predeterminada enviada por el front.
        $inventarioSeparado = ventasService::prepararInventarioXVenta($carrito, id_sucursal());
        $conflocal = config_local::getParamCaja();
        if($conflocal['permitir_venta_de_productos_sin_stock']->valor_final == 0){
            $erroresStock = ventasService::validarDisponibilidadInventario($inventarioSeparado, id_sucursal());
            if(!empty($erroresStock)){
                $alertas['error'] = $erroresStock;
                return $alertas;
            }
        }

        //$alertas = $separado->validar();
        //if(empty($alertas)){
        $getDB->begin_transaction();
        try {
            //ajustar abono o pagos en caja
            $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$valoresCredito['cajaid'], 'idsucursal_id'=>id_sucursal()]);
            if(!isset($ultimocierre)){ // si la caja esta cerrada y se hace apertura con el registro del abono
                $ultimocierre = new cierrescajas(['idcaja'=>$valoresCredito['cajaid'], 'nombrecaja'=>caja::find('id', $valoresCredito['cajaid'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
                $ruc = $ultimocierre->crear_guardar();
                $ultimocierre->id = $ruc[1];
            }
            
            $r = $separado->generarSeparado(new creditos($valoresCredito)); //internamente se realiza el insert en db
            // registrar abono inicial en tabla cuotas
            if($valoresCredito['abonoinicial'] > 0){
                $valoresCredito = [ 'id_credito'=>$r['1'], 'cierrecaja_id' => $ultimocierre->id ] + $valoresCredito;
                //crear cuota con repositorio
                $cuotasRepo = new cuotasRepository();
                $rc = $cuotasRepo->insert(new cuotas($valoresCredito));
                //registrar medios de pago del abono inicial si aplica
                $payment = new paymentService(new separadoMediopagoRepository());  //separadomediopago::class = a nombre de la clase como string
                $payment->registrarPagos($mediospago, $rc[1]);
            }
            //registrar los productos
            foreach($carrito as $obj){
              $obj->idcredito = $r[1];
              $obj->idproducto = $obj->idproducto;
              $obj->cantidad = $obj->stock; //para la tabla venta
              $obj->stockaux = $obj->promediostock>0?$obj->stock/$obj->promediostock:0;
            }
            $repo = new productsSeparadosRepository();
            [$productosCreados] = $repo->crear_varios_reg_arrayobj($carrito);
            if(!$productosCreados)
                throw new \RuntimeException('No fue posible guardar los productos del separado.');

            //descontar de inventario
            $inventarioActualizado = ventasService::descontarInventarioXVenta($inventarioSeparado,id_sucursal(),'separado','descuento de unidades por separado',false);
            if(!$inventarioActualizado)
                throw new \RuntimeException('No fue posible descontar el inventario del separado.');

            //$ultimocierre->ventasenefectivo += $valorefectivo;
            $ultimocierre->creditocapital += $valoresCredito['capital'];
            $ultimocierre->creditos += $valoresCredito['capital']-$valoresCredito['abonoinicial'];
            $ultimocierre->abonostotales += $valoresCredito['abonoinicial']; 
            $ultimocierre->abonosenefectivo += $valorefectivo;
            $ultimocierre->abonosseparados += $valoresCredito['abonoinicial'];
            //$ultimocierre->ingresoventas =  $ultimocierre->ingresoventas + $valoresCredito['abonoinicial'];
            $ultimocierre->actualizar();
            //actualizar deuda de cliente
            $cliente = clientes::find('id', $valoresCredito['cliente_id']);
            $cliente->totaldebe += $valoresCredito['montototal'];
            $cliente->actualizar();

            $getDB->commit();
            $alertas['exito'][] = "Credito de tipo separado creado correctamente.";
            $alertas['idcredito'][] = $r[1];
        } catch (\Throwable $th) {
            $getDB->rollback();
            $alertas['error'][] = "Error al generar el credito de tipo separado. ".$th->getMessage();
        }
        //}
        return $alertas;
    }


    public static function detallecredito(int $id):array{
        $sucursal = sucursales::find('id', id_sucursal());
        $credito = new creditosRepository();
        $cuotasRepo = new cuotasRepository();
        $productos = new productsSeparadosRepository();
        $credito = $credito->find($id);

        $lineasencabezado = explode("\n", $sucursal->datosencabezados??'');
        $emisor = null;
        if($credito->idemisor){
            $emisor = emisores::find('id', $credito->idemisor);
            $lineasencabezado = $emisor->datosencabezados?explode("\n", $emisor->datosencabezados??''):[];
        }

        $detalle = [
            'titulo' => 'Creditos',
            'sucursal' => $sucursal,
            'emisor' => $emisor,
            'lineasencabezado' => $lineasencabezado,
            'credito' => $credito,
            'cuotas' => $credito->idtipofinanciacion==1?$cuotasRepo->obtenerPorCredito_Mediopago($credito->id):$cuotasRepo->obtenerPorSeparado_Mediopago($credito->id),
            'productos' => $credito->idtipofinanciacion == 2 ? $productos->obtenerPorCredito($credito->id) : [ventas::find('idfactura', $credito->factura_id)],
            'cliente' => clientes::find('id', $credito->cliente_id),  //$credito->cliente_id
            'cajas' => caja::whereArray(['idsucursalid'=>id_sucursal(), 'estado'=>1]),
            'factura' => facturas::find('id', $credito->factura_id),
            'mediospago' => mediospago::whereArray(['estado'=>1]),
            'usuario' => usuarios::find('id', $credito->usuariofk)
        ];

        $direccion = direcciones::find('idcliente', $detalle['cliente']?->id);
        if(!$direccion)$direccion = direcciones::find('id', 1);
        $detalle['direccion'] = $direccion;
        return $detalle;
    }


    public static function registrarAbono(array $datos){
        $alertas = [];
        $idsucursal = id_sucursal();
        $contableService = new contableService();
        $creditoRepo = new creditosRepository();
        $credito = $creditoRepo->find($datos['id_credito']);
        if($credito->idestadocreditos == 2){

            //si es abono en efectivo, registrar al efectivo del cierre de caja y en el abono del cierre de caja
            $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$datos['cajaid'], 'idsucursal_id'=>$idsucursal]);
            if(!isset($ultimocierre)){ // si la caja esta cerrada y se hace apertura con el registro del abono
                $ultimocierre = new cierrescajas(['idcaja'=>$datos['cajaid'], 'nombrecaja'=>caja::uncampo('id', $ultimocierre->idcaja, 'nombre'), 'estado'=>0, 'idsucursal_id'=>$idsucursal]);
                $ruc = $ultimocierre->crear_guardar();
                $ultimocierre->id = $ruc[1];
            }

            $cuota = new cuotas($datos+['cierrecaja_id' => $ultimocierre->id, 'idusuario'=>$_SESSION['id']]);
            $cuota->preparar($credito);
            $alertas = $cuota->validar();
            //validar que la cuota no supera al saldo pendiente
            if($cuota->valorpagado>$credito->saldopendiente)return ['error'=>['Valor de la cuota supera al saldo pendiente']];
            
            if(empty($alertas)){
                $cuotaRepo = new cuotasRepository();
                $getDB = $cuotaRepo::getDB();
                $getDB->begin_transaction();
                try {
                    $cuota->num_orden = $cuotaRepo->calcularNumOrden($idsucursal);
                    $r = $cuotaRepo->insert($cuota);
                    $objMedioPago = new separadomediopago(['idcuota'=>$r[1], 'mediopago_id'=>$datos['mediopagoid'], 'valor'=>$datos['valorpagado']]);

                    if(isset($credito->factura_id)){ //si es credito abonado
                        $factmediospago = new factmediospago(['cierrecajaid'=>$ultimocierre->id, 'id_factura'=>$credito->factura_id, 'idcuota'=>$r[1], 'idmediopago'=>$datos['mediopagoid'], 'valor'=>$datos['valorpagado']]);
                        $factmediospago->crear_varios_reg_arrayobj([$factmediospago]);
                        
                        $contableService->createMovimiento([
                            'fk_tipo_movimientocaja'=>2,
                            'fk_tipo_documento'=>2,
                            'id_documento'=>$r[1],
                            'fk_tipo_tercero'=>1,
                            'id_tercero'=>$credito->cliente_id,
                            'fk_caja'=>$datos['cajaid'],
                            'fk_usuario'=>$cuota->idusuario,
                            'naturaleza'=>'I',
                            'numero_documento'=>'C'.$cuota->num_orden,
                            'num_orden'=>null,
                            'valor'=>$cuota->valorpagado,
                            'concepto'=>'ABONO A FACTURA',
                            'observacion'=>"PAGO N $cuota->numerocuota - ".$cuota->detalle
                        ]);

                    }else{
                        $payment = new paymentService(new separadoMediopagoRepository());
                        $payment->registrarPagos([$objMedioPago], $r[1]);
                    }
                    

                    if($objMedioPago->mediopago_id == 1)
                        $ultimocierre->abonosenefectivo += $objMedioPago->valor;

                    isset($credito->factura_id)?($ultimocierre->abonoscreditos += $objMedioPago->valor):($ultimocierre->abonosseparados += $objMedioPago->valor);

                    $ultimocierre->abonostotales =  $ultimocierre->abonostotales + $objMedioPago->valor; 
                    $ultimocierre->actualizar();

                    //**generar factura e impuestos cuando se termine de pagar el separado
                    if(($credito->saldopendiente-$cuota->valorpagado) <= 0 && $credito->factura_id == null)
                        $idf = creditosService::registrarFactura($credito, $ultimocierre, $cuota->valorpagado);

                    $credito->actualizarCredito($cuota->valorpagado, isset($idf)?$idf:null);
                    $creditoRepo->update($credito);

                    $getDB->commit();
                    $alertas['exito'][] = "Cuota procesada";
                    $alertas['idcuota'] = $r[1];
                    //acatualizar deuda de cliente
                    $cliente = clientes::find('id', $credito->cliente_id);
                    $cliente->totaldebe -= $cuota->valorpagado;
                    $cliente->actualizar();
                } catch (\Throwable $th) {
                    $getDB->rollback();
                    $alertas['error'][] = "Error al procesar el abono {$th->getMessage()}";
                }
            }
        }else{
            $alertas['error'][] = "Credito debe estar abierto para abonar.";
        }
        return $alertas;

    }


    public static function registrarFactura(object $credito, $ultimocierre, $ultimoValorPagado):int{
        
        $productos = new productsSeparadosRepository();
        $carrito = $productos->obtenerPorCredito($credito->id);
        $dircli =direcciones::find('idcliente', $credito->cliente_id);
        $venta = new ventas();
        $factimpuestos = new factimpuestos;
        $arrayfactura = [
                    'id_sucursal' => id_sucursal(), 
                    'idcliente' => $credito->cliente_id, 
                    'idvendedor' => $credito->usuariofk, 
                    'idcaja' => $ultimocierre->idcaja, 
                    'idconsecutivo' =>1,
                    'iddireccion' => $dircli->id??1,
                    'idtarifazona' => $dircli->idtarifa??1,
                    'idcierrecaja' => $ultimocierre->id, 
                    /*'num_orden' => 
                    'prefijo' => 
                    'num_consecutivo' => */
                    'cliente' => '',
                    'vendedor' => '',
                    'caja' => '',
                    'tipofacturador' => '', 
                    'propina' => 0,
                    'direccion' => 'Almacen',
                    'tarifazona' => '',
                    'totalunidades' => $credito->totalunidades,
                    'recibido' => 0,
                    'cambio' => 0,
                    'transaccion' => null,
                    'tipoventa' => 'Credito',
                    'cotizacion' => 0,
                    'estado' => 'Paga',
                    'cambioaventa' => 0,
                    'ref_creditoid' => $credito->id,
                    //'referencia' => $credito->id,
                    'abono' => $credito->abonoinicial,
                    'abonofinal' => $ultimoValorPagado,
                    'subtotal' => $credito->capital,
                    'base' => $credito->base,
                    'valorimpuestototal' => $credito->valorimpuestototal,
                    'dctox100' => $credito->dctox100,
                    'descuento' => $credito->descuento,
                    'total' => $credito->montototal,
                    'observacion' => '',
                    'departamento' => '',
                    'ciudad' => '',
                    'entrega' => 'Presencial',
                    'valortarifa' => 0,
                    'fechacreacion' => date('Y-m-d H:i:s'),
                    'fechapago' => date('Y-m-d H:i:s'),
                    'habilitada' => 1,
                    /*'opc1' => '',
                    'opc2' =>  '',*/
                ];
        $factura = new facturas($arrayfactura);
        $factura->num_orden = facturas::calcularNumOrden(id_sucursal());
        $consecutivo = consecutivos::findForUpdate('id', 1);
        $numConsecutivo = $consecutivo->siguientevalor;
        $factura->num_consecutivo = $numConsecutivo;
        $factura->prefijo = $consecutivo->prefijo;
        $r = $factura->crear_guardar();
        $consecutivo->siguientevalor = $numConsecutivo + 1;
        $consecutivo->actualizar();

        $mapMpuesto = ['0'=>1, '5'=>2, '16'=>3, '19'=>4, 'excluido'=>5, '8'=>6];
        $impuestos = [];
        foreach($carrito as $value){
            $value->idfactura = $r[1];
            $value->idproducto = $value->idproducto;
            $value->dato1 = '';
            $value->dato2 = '';

            $obj = new stdClass;
            $obj->id_impuesto = $mapMpuesto[$value->impuesto];
            $obj->facturaid = $r[1];
            $obj->basegravable = $value->base;
            $obj->valorimpuesto = $value->valorimp;
            $impuestos[] = $obj;
        }

        $venta->crear_varios_reg_arrayobj($carrito);
        $factimpuestos->crear_varios_reg_arrayobj($impuestos);
        return $r[1];
    }


    public static function cambioMedioPagoSeparado(array $datos):array{
        $alertas = [];
        $idnuevomediopago = $datos['idnuevomediopago'];
        $idcredito = $datos['id_credito'];
        $creditoRepo = new creditosRepository();
        $credito = $creditoRepo->find($idcredito);
        if($credito->idestadocreditos != 2 )return ['error'=>['El credito debe estar abierto para cambiar el medio de pago.']];


        $cuotaRepo = new cuotasRepository();
        $cuota = $cuotaRepo->find($datos['id']);
        
        $ultimocierre = cierrescajas::uniquewhereArray(['id'=>$cuota->cierrecaja_id, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
        if(!isset($ultimocierre))
            return ['error'=>['Cierre de caja realizado para la cuota pagada']];


        if($credito->idtipofinanciacion == 2){
            $repo = new separadoMediopagoRepository();
            $mediospago = $repo->uniqueWhere(['idcuota'=>$datos['id'], 'mediopago_id'=>$datos['idmediopago']]);
            $mediospago->mediopago_id = $idnuevomediopago;
            $r = $repo->update($mediospago);
        }else{
            $mediospago = factmediospago::uniquewhereArray(['id_factura'=>$credito->factura_id, 'idcuota'=>$datos['id'], 'idmediopago'=>$datos['idmediopago']]);
            $mediospago->idmediopago = $idnuevomediopago;
            $r = $mediospago->actualizar();
        }

        if($r){
            //actualizar efectivo en caja si corresponde
            if($datos['idmediopago'] == 1 && $idnuevomediopago!=1)
                $ultimocierre->abonosenefectivo -= $mediospago->valor;
            if($datos['idmediopago'] != 1 && $idnuevomediopago==1)
                $ultimocierre->abonosenefectivo += $mediospago->valor;
            $ultimocierre->actualizar();
            $alertas['exito'][] = "Medio de pago actualizado";
            $alertas['mediosPagoUpdate'] = $mediospago;
        }else{
            $alertas['error'][] = "Error al actualizar el medio de pago";
        }
        return $alertas;
    }

    
    //se llama desde creditoscontrolador cuando se anula un separado
    public static function anularSeparado(int $idcredito):array{
        $alertas = [];
        $creditoRepo = new creditosRepository();
        $separdoMediopago = new separadoMediopagoRepository();
        $productosRepo = new productsSeparadosRepository();
        
        $credito = $creditoRepo->find($idcredito);
        if(!$credito)return ['error'=>['El separado no existe.']];
        if($credito->idestadocreditos != 2 )return ['error'=>['El separado debe estar abierto para anular.']];

        $getDB = $creditoRepo->getConexion();
        $getDB->begin_transaction();
        try {
            //cambiar estado del separado
            if(!$creditoRepo->anularCredito($credito->id))
                throw new \RuntimeException('No fue posible cambiar el estado del separado.');
            //Anular valores de la cuota de caja abierta
            $cuotasRepo = new cuotasRepository();
            $cuotas = $cuotasRepo->obtenerPorSeparado_cierracajaAbierto($credito->id);
            
            $arrayCierresCaja = [];
            $idseparadomediopago = [];
            foreach($cuotas as $cuota){
                $idseparadomediopago[] = $cuota->idseparadomediopago;
                if(isset($arrayCierresCaja[$cuota->cierrecaja_id])){
                    $obj = $arrayCierresCaja[$cuota->cierrecaja_id];
                    //$obj->ventasenefectivo -= $cuota->valorcuota_efectivo;
                    $obj->abonostotales -= $cuota->cuotapagada;
                    $obj->abonosenefectivo -= $cuota->valorcuota_efectivo;
                    $obj->abonosseparados -= $cuota->cuotapagada;
                    //$obj->ingresoventas -= $cuota->cuotapagada;
                }else{
                    $obj = new stdClass;
                    $obj->id = $cuota->cierrecaja_id;
                    //$obj->ventasenefectivo = $cuota->ventasEfectivo_caja-$cuota->valorcuota_efectivo;
                    $obj->abonostotales = $cuota->abonostotales_caja-$cuota->cuotapagada;
                    $obj->abonosenefectivo = $cuota->abonosenefectivo_caja-$cuota->valorcuota_efectivo;
                    $obj->abonosseparados = $cuota->abonosSeparados_caja-$cuota->cuotapagada;
                    //$obj->ingresoventas = $cuota->ingresoventas_caja-$cuota->cuotapagada;
                    $arrayCierresCaja[$cuota->cierrecaja_id] = $obj;
                }
            }
            
            //descontar los abonos de los separados en cierre de caja si esta abierta
            if(!empty($arrayCierresCaja)){
                $r = cierrescajas::updatemultiregobj($arrayCierresCaja, ['abonostotales', 'abonosenefectivo', 'abonosseparados']);
                if(!$r)throw new \RuntimeException('No fue posible actualizar los cierres de caja.');
            }
            //eliminar los medios de pago de las cuotas relacionadas donde el cierre de caja este abierto
            if(!empty($idseparadomediopago) && !$separdoMediopago->delete_regs('id', $idseparadomediopago))
                throw new \RuntimeException('No fue posible eliminar los medios de pago del separado.');

            //devolver a inventario
            $productos = $productosRepo->obtenerPorCredito($credito->id);
            $inventarioSeparado = ventasService::prepararInventarioXVenta($productos, id_sucursal());
            $inventarioActualizado = ventasService::devolverInventarioXVenta($inventarioSeparado, id_sucursal(), 'devolucion', 'retorno de unidades por anulacion de separado', false);
            if(!$inventarioActualizado)
                throw new \RuntimeException('No fue posible devolver el inventario del separado.');

            //acatualizar deuda de cliente
            $cliente = clientes::find('id', $credito->cliente_id);
            $cliente->totaldebe -= $credito->saldopendiente;
            $cliente->actualizar();

            $getDB->commit();
            $alertas['exito'][] = "Separado anulado correctamente";
        } catch (\Throwable $th) {
           $getDB->rollback();
           $alertas['error'][] = "Error al anular el separado. {$th->getMessage()}";
        }

        return $alertas;
    }


    //llamado desde ventascontrolador cuando se elimina o anula una factura tipo credito
    public static function anularCredito(int $idfactura):array{
        $alertas = [];

        $repoMovimientocaja = new movimientos_cajaRepository();
        $creditoRepo = new creditosRepository();
        $credito = $creditoRepo->uniqueWhere(['factura_id'=>$idfactura]);
        if($credito->idestadocreditos != 2 )return ['error'=>['El credito debe estar abierto para anular.']];

        //acatualizar deuda de cliente
        $cliente = clientes::find('id', $credito->cliente_id);
        $cliente->totaldebe -= $credito->saldopendiente;
        $cli = $cliente->actualizar();
        if(!$cli){
            $alertas['error'][] = "No se puede eliminar el credito, intenta nuevamente";
            return $alertas;
        }

        //cambiar estado del credito en el movimiento de caja
        $movCaja = $repoMovimientocaja->uniqueWhere(['fk_tipo_documento'=>1, 'id_documento'=>$credito->id]);
        $movCaja->fecha_anulacion = date('Y-m-d H:i:s');
        $movCaja->estado = 0;

        //$getDB = $creditoRepo->getConexion();
        //$getDB->begin_transaction();
        //try {
            //cambiar estado del credito
            $creditoRepo->anularCredito($credito->id);

            $cuotasRepo = new cuotasRepository();
            $cuotas = $cuotasRepo->obtenerPorCredito_cierracajaAbierto($credito->id);
            $repoMovimientocaja->update($movCaja);
            
            $arrayCierresCaja = [];
            foreach($cuotas as $cuota){
                if(isset($arrayCierresCaja[$cuota->cierrecaja_id])){
                    $obj = $arrayCierresCaja[$cuota->cierrecaja_id];
                    $obj->abonostotales -= $cuota->cuotapagada;
                    $obj->abonosenefectivo -= $cuota->valorcuota_efectivo;
                    $obj->abonoscreditos -= $cuota->cuotapagada;
                }else{
                    $obj = new stdClass;
                    $obj->id = $cuota->cierrecaja_id;
                    $obj->abonostotales = $cuota->abonostotales_caja-$cuota->cuotapagada;
                    $obj->abonosenefectivo = $cuota->abonosenefectivo_caja-$cuota->valorcuota_efectivo;
                    $obj->abonoscreditos = $cuota->abonosCreditos_caja-$cuota->cuotapagada;
                    $arrayCierresCaja[$cuota->cierrecaja_id] = $obj;
                }
            }
            
            //descontar los abonos de los separados en cierre de caja si esta abierta
            if(empty($arrayCierresCaja)){
                $alertas['exito'][] = "Credito anulado correctamente";
                return $alertas;
            }
            cierrescajas::updatemultiregobj($arrayCierresCaja, ['abonostotales', 'abonosenefectivo', 'abonoscreditos']);
            //$getDB->commit();
        //} catch (\Throwable $th) {
            //$alertas['error'][] = "Error al anular el credito. {$th->getMessage()}";
            //$getDB->rollback();
        //}
        return $alertas;
    }


    public static function descontarAbonosCreditosXCierresCaja(int $idcredito):array{
        $alertas = [];
        $cuotasRepo = new cuotasRepository();
        $cuotas = $cuotasRepo->obtenerPorCredito_cierracaja($idcredito);
        $arrayCierresCaja = [];
        foreach($cuotas as $cuota){
            if(isset($arrayCierresCaja[$cuota->cierrecaja_id])){
                $obj = $arrayCierresCaja[$cuota->cierrecaja_id];
                $obj->abonostotales -= $cuota->cuotapagada;
                $obj->abonosenefectivo -= $cuota->valorcuota_efectivo;
                $obj->abonoscreditos -= $cuota->cuotapagada;
            }else{
                $obj = new stdClass;
                $obj->id = $cuota->cierrecaja_id;
                $obj->abonostotales = $cuota->abonostotales_caja-$cuota->cuotapagada;
                $obj->abonosenefectivo = $cuota->abonosenefectivo_caja-$cuota->valorcuota_efectivo;
                $obj->abonoscreditos = $cuota->abonosCreditos_caja-$cuota->cuotapagada;
                $arrayCierresCaja[$cuota->cierrecaja_id] = $obj;
            }
        }

        //descontar los abonos de los creditos en cierre de caja
        if(empty($arrayCierresCaja)){
            $alertas['exito'][] = "No hay abonos del credito registrado en cajas";
            return $alertas;
        }
        $rc = cierrescajas::updatemultiregobj($arrayCierresCaja, ['abonostotales', 'abonosenefectivo', 'abonoscreditos']);
        if($rc){
            $alertas['exito'][] = "Cierre de caja actualizado";
        }else{
            $alertas['error'][] = "Error al actualizar cierre de caja";
        }
        return $alertas;
    }


    public static function anularAbono(int $idabono):array{
        $alertas = [];
        $cs = true;
        $cc = true;
        $repoMovimientocaja = new movimientos_cajaRepository();
        $creditoRepo = new creditosRepository();
        $separdoMediopago = new separadoMediopagoRepository();
        $cuotaRepo = new cuotasRepository();
        $cuota = $cuotaRepo->find($idabono);
        $credito = $creditoRepo->find($cuota->id_credito);

        if($credito->idestadocreditos != 2 )return ['error'=>['El credito debe estar abierto para anular.']];

        $cierrecaja = cierrescajas::uniquewhereArray(['id'=>$cuota->cierrecaja_id, 'idsucursal_id'=>id_sucursal()]);
        if($cierrecaja->estado == 1)return ['error'=>['Caja se encuentra cerrada para esta cuota']];

        if($credito->idtipofinanciacion == 1){  //credito
            $cuotaMP = factmediospago::uniquewhereArray(['id_factura'=>$credito->factura_id, 'idcuota'=>$cuota->id]);
            if($cuotaMP)$cc = $cuotaMP->eliminar_registro();
            //buscar movimiento de caja y actualizar
            $movCaja = $repoMovimientocaja->uniqueWhere(['fk_tipo_documento'=>2, 'id_documento'=>$cuota->id]);
            $movCaja->fecha_anulacion = date('Y-m-d H:i:s');
            $movCaja->observacion .= ' - Cuota anulada manualmente';
            $movCaja->estado = 0;
            $repoMovimientocaja->update($movCaja);
            $cierrecaja->abonoscreditos -= $cuota->valorpagado;
        }else{  //separado
            $cs = $separdoMediopago->delete_regs('idcuota', [$cuota->id]);
            $cierrecaja->abonosseparados -= $cuota->valorpagado;
        }

        if($cc && $cs){
            $cuotaRepo->delete($cuota->id);
            $credito->abonodecuotas -= $cuota->valorpagado;
            $credito->saldopendiente += $cuota->valorpagado;
            $creditoRepo->update($credito);

            //acatualizar deuda de cliente
            $cliente = clientes::find('id', $credito->cliente_id);
            $cliente->totaldebe += $cuota->valorpagado;
            $cliente->actualizar();

            $cierrecaja->abonostotales -= $cuota->valorpagado;
            $cuota->mediopagoid == 1 ? ($cierrecaja->abonosenefectivo -= $cuota->valorpagado) : $cierrecaja->abonosenefectivo -= 0;
            $cierrecaja->actualizar();
            $alertas['exito'][] = "Cuota eliminada";
        }

        return $alertas;
    }


    public static function ajustarCreditoAntiguo(array $datos):array{
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $idcredito = $datos['id'];
        $recargo = $datos['recargo'];
        $abonototalantiguo = $datos['abonototalantiguo'];
        $ajustarFechaInicio = $datos['fechainicio'];
        $creditoRepo = new creditosRepository();
        $credito = $creditoRepo->find($idcredito);
        if($credito->idestadocreditos != 2 )return ['error'=>['El credito debe estar abierto para cambiar el medio de pago.']];

        $credito->saldopendiente = $credito->capital + $recargo - $credito->abonodecuotas - $abonototalantiguo;
        $credito->interes = 1;
        $credito->valorinterestotal = $recargo;
        $credito->montototal = $credito->capital - $credito->abonoinicial + $credito->valorinterestotal;
        $credito->abonototalantiguo = $abonototalantiguo;
        $credito->fechainicio = $ajustarFechaInicio;
        $credito->fechaultimoabonoantiguo = date('Y-m-d H:i:s');

        $getDB = $creditoRepo->getConexion();
        $getDB->begin_transaction();
        try {
            $creditoRepo->update($credito);
            $getDB->commit();
            $alertas['exito'][] = "Credito actualizado correctamente";

            //acatualizar deuda de cliente
            $cliente = clientes::find('id', $credito->cliente_id);
            $cliente->totaldebe += (-$abonototalantiguo+$recargo);
            $cliente->actualizar();
        } catch (\Throwable $th) {
            //throw $th;
            $getDB->rollback();
            $alertas['error'][] = "Error al actualizar el credito. {$th->getMessage()}";
        }
        
        return $alertas;
    }


    //metodo llamado desde adicionarProductos.ts para el detalle
    public static function detalleProductosCredito(int $id):array{
        $productosSeparados = new productsSeparadosRepository();
        return $productosSeparados->detalleProductosCredito($id);
    }


    //metodo llamado desde adicionarproducto.ts para editar los productos del credito/separado
    public static function editarOrdenCreditoSeparado(int $idcredito, $idsdetalleproductos, $nuevosproductosFront, $dataCredit){
        $alertas = [];
        $creditoRepo = new creditosRepository();
        $productosRepo = new productsSeparadosRepository();
        $getDB = $creditoRepo->getConexion();

        if(!is_array($nuevosproductosFront) || empty($nuevosproductosFront))
            return ['error'=>['El separado debe contener al menos un producto.']];

        $getDB->begin_transaction();
        try {
            $credito = $creditoRepo->find($idcredito);
            if(!$credito)throw new \RuntimeException('El separado no existe.');
            if((int)$credito->idtipofinanciacion !== 2)
                throw new \RuntimeException('El registro no corresponde a un separado.');
            if((int)$credito->idestadocreditos !== 2)
                throw new \RuntimeException('El separado debe estar abierto para editarse.');
        
            $totalPagado = (float)$credito->montototal - (float)$credito->saldopendiente;
            $nuevoMontoTotal = (float)$dataCredit['montototal'];
            $nuevoSaldo = (float)$dataCredit['saldopendiente'];
            if($nuevoMontoTotal + 0.001 < $totalPagado)
                throw new \RuntimeException('El nuevo total no puede ser inferior al valor abonado.');
            if(abs($nuevoSaldo - ($nuevoMontoTotal - $totalPagado)) > 0.01)
                throw new \RuntimeException('El saldo pendiente no corresponde al total y los abonos del separado.');

            $detalleProductosDB = $productosRepo->findAll('idcredito', $idcredito) ?? [];
            $detallePorId = [];
            foreach($detalleProductosDB as $itemDB)$detallePorId[(int)$itemDB->id] = $itemDB;

            $idsConservados = [];
            $productosVistos = [];
            $nuevosproductos = [];
            $arrayactualizar = [];
            $arrayDownInv = [];
            $arrayUpInv = [];

            foreach($nuevosproductosFront as $itemfront){
                $idProducto = (int)($itemfront->idproducto ?? 0);
                $cantidadNueva = (float)($itemfront->cantidad ?? 0);
                if($idProducto <= 0 || $cantidadNueva <= 0)
                    throw new \RuntimeException('El producto y su cantidad deben ser validos.');
                if(isset($productosVistos[$idProducto]))
                    throw new \RuntimeException("El producto #$idProducto esta repetido en el separado.");
                $productosVistos[$idProducto] = true;

                foreach(['subtotal', 'base', 'valorimp', 'descuento', 'total'] as $campo)
                    $itemfront->$campo = (float)$itemfront->$campo;

                $itemfront->cantidad = $cantidadNueva;
                $itemfront->stock = $cantidadNueva;
                $itemfront->idcredito = $idcredito;
                $idDetalle = (int)($itemfront->id ?? 0);

                if($idDetalle > 0){
                    if(!isset($detallePorId[$idDetalle]))
                        throw new \RuntimeException('Una linea no pertenece al separado.');

                    $itemDB = $detallePorId[$idDetalle];
                    if((int)$itemDB->idproducto !== $idProducto)
                        throw new \RuntimeException('El producto de una linea existente no puede cambiarse.');

                    $idsConservados[$idDetalle] = true;
                    $arrayactualizar[] = $itemfront;
                    $diferencia = $cantidadNueva - (float)$itemDB->cantidad;

                    if($diferencia != 0.0){
                        $itemInventario = clone $itemDB;
                        $itemInventario->cantidad = abs($diferencia);
                        $itemInventario->stock = abs($diferencia);
                        $promedioStock = (float)($itemInventario->promediostock ?? 0);
                        $itemInventario->stockaux = $promedioStock > 0 ? $itemInventario->stock / $promedioStock: 0;

                        if($diferencia > 0)$arrayDownInv[] = $itemInventario;
                        else $arrayUpInv[] = $itemInventario;
                    }
                }else{
                    $promedioStock = (float)($itemfront->promediostock ?? 0);
                    $itemfront->stockaux = $promedioStock > 0 ? $cantidadNueva / $promedioStock: 0;
                    $nuevosproductos[] = $itemfront;
                }
            }

            $arrayIdeliminar = [];
            $arrayProductsEliminar = [];
            foreach($detalleProductosDB as $itemDB){
                if(isset($idsConservados[(int)$itemDB->id]))continue;
                $itemDB->stock = (float)$itemDB->cantidad;
                $promedioStock = (float)($itemDB->promediostock ?? 0);
                $itemDB->stockaux = $promedioStock > 0 ? $itemDB->stock / $promedioStock: 0;
                $arrayIdeliminar[] = (int)$itemDB->id;
                $arrayProductsEliminar[] = $itemDB;
            }

            $lineasDescontar = array_merge($nuevosproductos, $arrayDownInv);
            $lineasDevolver = array_merge($arrayUpInv, $arrayProductsEliminar);
            $inventarioDescontar = ventasService::prepararInventarioXVenta($lineasDescontar, id_sucursal());
            $inventarioDevolver = ventasService::prepararInventarioXVenta($lineasDevolver, id_sucursal());

            // Primero se retorna lo reducido o eliminado para que ese stock pueda
            // cubrir los aumentos realizados dentro de la misma edicion.
            if(!empty($lineasDevolver)){
                $inventarioDevuelto = ventasService::devolverInventarioXVenta($inventarioDevolver, id_sucursal(), 'devolucion', 'retorno de unidades por edicion de separado', false);
                if(!$inventarioDevuelto)
                    throw new \RuntimeException('No fue posible devolver el inventario del separado.');
            }

            $conflocal = config_local::getParamCaja();
            if(!empty($lineasDescontar)&& (int)$conflocal['permitir_venta_de_productos_sin_stock']->valor_final === 0){
                $erroresStock = ventasService::validarDisponibilidadInventario($inventarioDescontar, id_sucursal());
                if(!empty($erroresStock))throw new \RuntimeException(implode(' ', $erroresStock));
            }

            if(!empty($arrayIdeliminar) && !$productosRepo->delete_regs('id', $arrayIdeliminar))
                throw new \RuntimeException('No fue posible eliminar los productos retirados del separado.');

            if(!empty($nuevosproductos)){
                [$productosInsertados] = $productosRepo->crear_varios_reg_arrayobj($nuevosproductos);
                if(!$productosInsertados)
                    throw new \RuntimeException('No fue posible agregar los productos al separado.');
            }

            if(!empty($arrayactualizar) && !$productosRepo->updatemultiregobj($arrayactualizar, ['cantidad', 'subtotal', 'base', 'valorimp', 'descuento', 'total']))
                throw new \RuntimeException('No fue posible actualizar los productos del separado.');

            $saldoAnterior = (float)$credito->saldopendiente;
            $credito->capital = (float)$dataCredit['capital'];
            $credito->saldopendiente = $nuevoSaldo;
            $credito->montocuota = (float)$dataCredit['montocuota'];
            $credito->montototal = $nuevoMontoTotal;
            $credito->totalunidades = (float)$dataCredit['totalunidades'];
            if(!$creditoRepo->update($credito))
                throw new \RuntimeException('No fue posible actualizar los valores del separado.');

            $cliente = clientes::find('id', $credito->cliente_id);
            if(!$cliente)throw new \RuntimeException('No fue posible encontrar el cliente del separado.');
            $cliente->totaldebe = (float)$cliente->totaldebe + ($nuevoSaldo - $saldoAnterior);
            if(!$cliente->actualizar())
                throw new \RuntimeException('No fue posible actualizar la deuda del cliente.');

            if(!empty($lineasDescontar)){
                $inventarioActualizado = ventasService::descontarInventarioXVenta($inventarioDescontar, id_sucursal(), 'separado', 'descuento de unidades por edicion de separado', false);
                if(!$inventarioActualizado)
                    throw new \RuntimeException('No fue posible descontar el inventario del separado.');
            }

            $getDB->commit();
            $alertas['exito'][] = "Credito Orden: $credito->num_orden, actualizada correctamente";
        } catch (\Throwable $th) {
            $getDB->rollback();
            $alertas['error'][] = 'Error al actualizar el separado. '.$th->getMessage();
        }

        return $alertas;
    }


    public static function pagarDeudaTotal(array $data):array{
        $alertas = [];
        $abonosSeparados = 0;
        $abonosCreditos = 0;
        $idcliente = $data['idcliente'];
        $idcaja = $data['idcaja'];
        $idmediodepago = $data['idmediodepago'];
        $valorDeudaTotal = $data['valorDeudaTotal'];
        $creditoRepo = new creditosRepository();
        $cuotaRepo = new cuotasRepository();
        $sepadoMPRepo = new separadoMediopagoRepository();
        $factmediospago = new factmediospago();
        $repoMovimientocaja = new movimientos_cajaRepository();
        $getDB = $creditoRepo->getConexion();
        
        $cierrecaja = cierrescajas::uniquewhereArray(['idcaja'=>$idcaja, 'idsucursal_id'=>id_sucursal(), 'estado'=>0]);
        if(!$cierrecaja)return ['error'=>['Caja se encuentra cerrada para esta cuota']];
        
        $creditosCliente = $creditoRepo->deudaTotalXcliente($idcliente, id_sucursal());
        $saldoPendiente = 0;
        $arrayCuotas = [];
        $arrayMPPendientes = [];
        $arrayFactMPPendientes = [];
        $arrayMovCajaPendientes = [];
        $num_orden = $cuotaRepo->calcularNumOrden(id_sucursal());
        foreach($creditosCliente as $index => $value){
            $value->numcuota+=1;
            // guardar saldo original
            $saldoCredito = $value->saldopendiente;
            // acumulador total
            $saldoPendiente += $value->saldopendiente;
            $value->abonodecuotas += $saldoPendiente;
            $value->saldopendiente = 0;
            $value->estado = 1;
            $value->idestadocreditos = 1;
            //armar array de las cuotas y medios de pago asociada a cada cuota para INSERT
            //cuotas
            $getModelCuota = $cuotaRepo->getModel();
            $getModelCuota->id_credito = $value->id;
            $getModelCuota->cierrecaja_id = $cierrecaja->id;
            $getModelCuota->cajaid = $idcaja;
            $getModelCuota->mediopagoid = $idmediodepago;
            $getModelCuota->idusuario = $_SESSION['id'];
            $getModelCuota->num_orden = $num_orden;
            $getModelCuota->numerocuota = $value->numcuota;
            $getModelCuota->montocuota = $value->montocuota;
            $getModelCuota->valorpagado = $saldoCredito;
            $getModelCuota->fechapagado = date('Y-m-d H:i:s');
            $getModelCuota->registrarencaja = 1;
            $getModelCuota->cuotaantigua = 0;
            $getModelCuota->fechacuotaantigua = 'NULL';
            $getModelCuota->concepto = 'PAGO DEUDA TOTAL A FACTURA';
            $getModelCuota->detalle = '';
            $getModelCuota->estado = 1;
            $arrayCuotas[] = $getModelCuota;

            if($value->idtipofinanciacion == 2){ //si es separado abonado
                $abonosSeparados += $saldoCredito; //para indicador cierre caja
                $arrayMPPendientes[$index] = [
                    'mediopago_id' => $idmediodepago,
                    'valor' => $saldoCredito,
                ];
            }

            if($value->idtipofinanciacion == 1){ //si es credito abonado
                $abonosCreditos += $saldoCredito; //para indicador cierre caja
                $arrayFactMPPendientes[$index] = [
                    'cierrecajaid' => $cierrecaja->id,
                    'id_factura' => $value->factura_id,
                    'idcuota'=>'NULL',
                    'idmediopago' => $idmediodepago,
                    'valor' => $saldoCredito
                ];
                //arreglo de movimientos de caja
                $arrayMovCajaPendientes[$index] = [
                    'fk_tipo_movimientocaja'=>2,
                    'fk_tipo_documento'=>2,
                    'id_documento'=>null,
                    'fk_tipo_tercero'=>1,
                    'id_tercero'=>$idcliente,
                    'fk_caja'=>$idcaja,
                    'fk_usuario'=>$_SESSION['id'],
                    'naturaleza'=>'I',
                    'numero_documento'=>'C'.$num_orden,
                    'num_orden'=>null,
                    'valor'=>$saldoCredito,
                    'concepto'=>'ABONO A FACTURA',
                    'observacion'=>"PAGO N $value->numcuota PAGO DEUDA TOTAL A FACTURA"
                ];

            }
            $num_orden++;
        }
        

        if($valorDeudaTotal != $saldoPendiente)return ['error' => ['Verificar saldo pendiente no corresponde']];        
        
        $getDB->begin_transaction();
        try {
            //actualizar creditos
            $creditoRepo->updatemultiregobj($creditosCliente, ['idestadocreditos', 'abonodecuotas', 'saldopendiente', 'estado']);
            //crear las cuotas para los creditos
            [$ok, $idsCuotas] = $cuotaRepo->crear_varios_reg_arrayobj($arrayCuotas);

            //crear los arreglos de objetos de medios de pago para separados y creditos para insertar los medios de pago asociados a las cuotas creadas
            $arraySeparadosMP=[];
            $arrayFactMediosPago = [];
            $arrayMovCaja = [];
            $numOrdenMovCaja = $repoMovimientocaja->getNumOrden(id_sucursal());

            foreach($idsCuotas as $key => $idcuota){
                if($creditosCliente[$key]->idtipofinanciacion == 2){ //si es separado abonado
                    $objMP = $sepadoMPRepo->getModel();
                    $objMP->idcuota = $idcuota;
                    $objMP->mediopago_id = $arrayMPPendientes[$key]['mediopago_id'];
                    $objMP->valor = $arrayMPPendientes[$key]['valor'];
                    $arraySeparadosMP[] = $objMP;
                }
                if($creditosCliente[$key]->idtipofinanciacion == 1){ //si es credito abonado
                    $objFactMP = new stdClass;
                    $objFactMP->cierrecajaid = $arrayFactMPPendientes[$key]['cierrecajaid'];
                    $objFactMP->id_factura = $arrayFactMPPendientes[$key]['id_factura'];
                    $objFactMP->idcuota = $idcuota;
                    $objFactMP->idmediopago = $arrayFactMPPendientes[$key]['idmediopago'];
                    $objFactMP->valor = $arrayFactMPPendientes[$key]['valor'];
                    $arrayFactMediosPago[] = $objFactMP;

                    //completar arreglo de movimiento de caja
                    $objMovCaja = new stdClass;
                    $objMovCaja->fk_tipo_movimientocaja = $arrayMovCajaPendientes[$key]['fk_tipo_movimientocaja'];
                    $objMovCaja->fk_tipo_documento = $arrayMovCajaPendientes[$key]['fk_tipo_documento'];
                    $objMovCaja->id_documento =  $idcuota;
                    $objMovCaja->fk_tipo_tercero = $arrayMovCajaPendientes[$key]['fk_tipo_tercero'];
                    $objMovCaja->id_tercero = $arrayMovCajaPendientes[$key]['id_tercero'];
                    $objMovCaja->fk_caja = $arrayMovCajaPendientes[$key]['fk_caja'];
                    $objMovCaja->fk_usuario = $arrayMovCajaPendientes[$key]['fk_usuario'];
                    $objMovCaja->naturaleza = $arrayMovCajaPendientes[$key]['naturaleza'];
                    $objMovCaja->numero_documento = $arrayMovCajaPendientes[$key]['numero_documento'];
                    $objMovCaja->num_orden = $numOrdenMovCaja++;
                    $objMovCaja->valor = $arrayMovCajaPendientes[$key]['valor'];
                    $objMovCaja->fecha_anulacion = 'NULL';
                    $objMovCaja->concepto = $arrayMovCajaPendientes[$key]['concepto'];
                    $objMovCaja->observacion = $arrayMovCajaPendientes[$key]['observacion'];
                    $arrayMovCaja[] = $objMovCaja;
                }
            }
            
            if($arraySeparadosMP)$sepadoMPRepo->crear_varios_reg_arrayobj($arraySeparadosMP);
            if($arrayMovCaja)$repoMovimientocaja->crear_varios_reg_arrayobj($arrayMovCaja);
            $getDB->commit();

            //crear las facturas para los separados

            if($arrayFactMediosPago)$fmp = $factmediospago->crear_varios_reg_arrayobj($arrayFactMediosPago);
            //actualizar el cierre de caja
            $cierrecaja->abonostotales += $valorDeudaTotal;
            $cierrecaja->abonosenefectivo += ($idmediodepago == 1) ? $valorDeudaTotal : 0;
            $cierrecaja->abonoscreditos += $abonosCreditos;
            $cierrecaja->abonosseparados += $abonosSeparados;
            $cierrecaja->actualizar();
            //acatualizar deuda de cliente
            $cliente = clientes::find('id', $idcliente);
            $cliente->totaldebe -= $valorDeudaTotal;
            $cliente->actualizar();
            return ['exito' => ['Deuda total pagada correctamente']];
        } catch (\Throwable $th) {
            $getDB->rollback();
            return ['error' => ['Error al procesar el pago de la deuda total, intenta nuevamente. Detalle: '.$th->getMessage()]];
        }

    }


}
