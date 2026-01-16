<?php 

namespace App\services;

use App\classes\serviceLocatorApp;
use App\Models\caja\cierrescajas;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\creditos\productosseparados;
use App\Models\creditos\separadomediopago;
use App\Models\factimpuestos;
use App\Models\inventario\productos_sub;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
use App\Repositories\creditos\creditosRepository;
use App\Repositories\creditos\cuotasRepository;
use App\Repositories\creditos\productsSeparadosRepository;
use App\Repositories\creditos\separadoMediopagoRepository;
use stdClass;

//**SERVICIO DE CREDITOS**//

class creditosService {

    //metodo llamado desde ventascontrolador.php
    public static function crearCredito(stdClass $valoresCredito, int $idfactura, int $idcliente, $totalunidades, $base, $valorimpuestototal, int $dctox100, $descuento, int $idcierrecaja, int $idcaja, int $idvendedor){
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $credito = new creditosRepository();
        $entity = $credito->generarCredito((array)$valoresCredito, $idfactura, $idcliente, $totalunidades, $base, $valorimpuestototal, $dctox100, $descuento, $idvendedor); //llama metodo del repositorio
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
                $rc = $cuotasRepo->insert(new cuotas((array)$valoresCredito));
                $alertas['exito'][] = "Credito creado con exito";
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
            
            $r = $separado->generarSeparado(new creditos($valoresCredito));
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
              $obj->idproducto = $obj->fk_producto;
            }
            $repo = new productsSeparadosRepository();
            $repo->crear_varios_reg_arrayobj($carrito);
            //descontar de inventario
            $a = ventasService::ajustarIventarioXVenta($carrito); //no se ha convertido a repositorio los metodos internos

            //$ultimocierre->ventasenefectivo += $valorefectivo;
            $ultimocierre->creditocapital += $valoresCredito['capital'];
            $ultimocierre->creditos += $valoresCredito['capital']-$valoresCredito['abonoinicial'];
            $ultimocierre->abonostotales += $valoresCredito['abonoinicial']; 
            $ultimocierre->abonosenefectivo += $valorefectivo;
            $ultimocierre->abonosseparados += $valoresCredito['abonoinicial'];
            //$ultimocierre->ingresoventas =  $ultimocierre->ingresoventas + $valoresCredito['abonoinicial'];
            $ultimocierre->actualizar();

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


    public static function detallecredito($id):array{
        $credito = new creditosRepository();
        $cuotasRepo = new cuotasRepository();
        $productos = new productsSeparadosRepository();
        $credito = $credito->find($id);
        $detalle = [
            'titulo' => 'Creditos',
            'credito' => $credito,
            'cuotas' => $cuotasRepo->obtenerPorCredito_Mediopago($credito->id),
            'productos' => $productos->obtenerPorCredito($credito->id),
            'cliente' => clientes::find('id', $credito->cliente_id),  //$credito->cliente_id
            'cajas' => caja::whereArray(['idsucursalid'=>id_sucursal(), 'estado'=>1]),
            'factura' => facturas::find('id', $credito->factura_id),
            'mediospago' => mediospago::whereArray(['estado'=>1])
        ];
        return $detalle;
    }


    public static function registrarAbono($datos){
        $alertas = [];
        $creditoRepo = new creditosRepository();
        $credito = $creditoRepo->find($datos['id_credito']);
        if($credito->idestadocreditos == 2){

            //si es abono en efectivo, registrar al efectivo del cierre de caja y en el abono del cierre de caja
            $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$datos['cajaid'], 'idsucursal_id'=>id_sucursal()]);
            if(!isset($ultimocierre)){ // si la caja esta cerrada y se hace apertura con el registro del abono
                $ultimocierre = new cierrescajas(['idcaja'=>$datos['cajaid'], 'nombrecaja'=>caja::uncampo('id', $ultimocierre->idcaja, 'nombre'), 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
                $ruc = $ultimocierre->crear_guardar();
                $ultimocierre->id = $ruc[1];
            }

            $cuota = new cuotas($datos+['cierrecaja_id' => $ultimocierre->id]);
            $cuota->preparar($credito);
            $alertas = $cuota->validar();
            //validar que la cuota no supera al saldo pendiente
            if($cuota->valorpagado>$credito->saldopendiente)return ['error'=>['Valor de la cuota supera al saldo pendiente']];
            
            if(empty($alertas)){
                $cuotaRepo = new cuotasRepository();
                $getDB = $cuotaRepo::getDB();
                $getDB->begin_transaction();
                try {
                    $r = $cuotaRepo->insert($cuota);
                    $objMedioPago = new separadomediopago(['idcuota'=>$r[1], 'mediopago_id'=>$datos['mediopagoid'], 'valor'=>$datos['valorpagado']]);

                    if(isset($credito->factura_id)){ //si es credito abonado
                        $factmediospago = new factmediospago(['cierrecajaid'=>$ultimocierre->id, 'id_factura'=>$credito->factura_id, 'idmediopago'=>$datos['mediopagoid'], 'valor'=>$datos['valorpagado']]);
                        $factmediospago->crear_varios_reg_arrayobj([$factmediospago]);
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
                    if($credito->saldopendiente <= 0 && $credito->factura_id == null)
                        $idf = creditosService::registrarFactura($credito, $ultimocierre, $cuota->valorpagado);

                    $credito->actualizarCredito($cuota->valorpagado, isset($idf)?$idf:null);
                    $creditoRepo->update($credito);

                    $getDB->commit();
                    $alertas['exito'][] = "Cuota procesada";
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
                    'tipoventa' => 'credito',
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
            $value->idproducto = $value->fk_producto;
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

        $repo = new separadoMediopagoRepository();
        $mediospago = $repo->uniqueWhere(['idcuota'=>$datos['id'], 'mediopago_id'=>$datos['idmediopago']]);
        
        $cuotaRepo = new cuotasRepository();
        $cuota = $cuotaRepo->find($datos['id']);
        
        $ultimocierre = cierrescajas::uniquewhereArray(['id'=>$cuota->cierrecaja_id, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
        if(!isset($ultimocierre))
            return ['error'=>['Cierre de caja realizado para la cuota pagada']];


        $mediospago->mediopago_id = $idnuevomediopago;
        $r = $repo->update($mediospago);
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
        $credito = $creditoRepo->find($idcredito);
        if($credito->idestadocreditos != 2 )return ['error'=>['El separado debe estar abierto para anular.']];
        
        try {
            //cambiar estado del separado
            $creditoRepo->anularCredito($credito->id);
            //Anular valores de la cuota de caja abierta
            $cuotasRepo = new cuotasRepository();
            $cuotas = $cuotasRepo->obtenerPorSeparado_cierracajaAbierto($credito->id);
            
            $arrayCierresCaja = [];
            foreach($cuotas as $cuota){
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
            $r = cierrescajas::updatemultiregobj($arrayCierresCaja, ['abonostotales', 'abonosenefectivo', 'abonosseparados']);
            //eliminar los medios de pago de las cuotas relacionadas donde el cierre de caja este abierto

            $alertas['exito'][] = "Separado anulado correctamente";
        } catch (\Throwable $th) {
           $alertas['error'][] = "Error al anular el separado. {$th->getMessage()}"; 
        }

        return $alertas;
    }


    //llamado desde ventascontrolador cuando se elimina o anula una factura tipo credito
    public static function anularCredito(int $idfactura):array{
        $alertas = [];

        $creditoRepo = new creditosRepository();
        $credito = $creditoRepo->uniqueWhere(['factura_id'=>$idfactura]);
        if($credito->idestadocreditos != 2 )return ['error'=>['El credito debe estar abierto para anular.']];

        //$getDB = $creditoRepo->getConexion();
        //$getDB->begin_transaction();
        //try {
            //cambiar estado del credito
            $creditoRepo->anularCredito($credito->id);

            $cuotasRepo = new cuotasRepository();
            $cuotas = $cuotasRepo->obtenerPorCredito_cierracajaAbierto($credito->id);
            
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

           // debuguear($arrayCierresCaja);
            //descontar los abonos de los separados en cierre de caja si esta abierta
            $r = cierrescajas::updatemultiregobj($arrayCierresCaja, ['abonostotales', 'abonosenefectivo', 'abonoscreditos']);
            //debuguear($r);
            if($r){
                $alertas['exito'][] = "Credito anulado correctamente";
            }else{
                $alertas['error'][] = "Error al anular el credito.";
            }
            //$getDB->commit();
        //} catch (\Throwable $th) {
            //$alertas['error'][] = "Error al anular el credito. {$th->getMessage()}";
            //$getDB->rollback();
        //}
        return $alertas;
    }
}