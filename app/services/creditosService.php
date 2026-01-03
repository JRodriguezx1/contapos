<?php 

namespace App\services;

use App\classes\serviceLocatorApp;
use App\Models\caja\cierrescajas;
use App\Models\clientes\clientes;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\creditos\productosseparados;
use App\Models\creditos\separadomediopago;
use App\Models\inventario\productos_sub;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
use App\Repositories\creditos\creditosRepository;
use App\Repositories\creditos\cuotasRepository;
use App\Repositories\creditos\productsSeparadosRepository;
use App\Repositories\creditos\separadoMediopagoRepository;
use stdClass;

//**SERVICIO DE CREDITOS

class creditosService {

    //metodo llamado desde ventascontrolador.php
    public static function crearCredito(stdClass $valoresCredito, $idfactura, $idcliente){
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $credito = new creditosRepository();
        $entity = $credito->generarCredito((array)$valoresCredito, $idfactura, $idcliente); //llama metodo del repositorio
        $alertas = $entity->validar();
        if(empty($alertas)){
            $r = $credito->insert($entity);
            if($r[0]){
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
            $r = $separado->generarSeparado(new creditos($valoresCredito));
            // registrar abono inicial en tabla cuotas
            if($valoresCredito['abonoinicial'] > 0){
                $valoresCredito = [ 'id_credito'=>$r['1'] ] + $valoresCredito;
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
            
            //ajustar abono o pagos en caja
            $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$cuota->cajaid, 'idsucursal_id'=>id_sucursal()]);
            if(!isset($ultimocierre)){ // si la caja esta cerrada y se hace apertura con el registro del abono
                $ultimocierre = new cierrescajas(['idcaja'=>$cuota->cajaid, 'nombrecaja'=>caja::find('id', $cuota->cajaid)->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
                $ultimocierre->crear_guardar();
            }

            $ultimocierre->creditos += $valoresCredito['capital']-$valoresCredito['abonoinicial'];
            $ultimocierre->abonos += $valoresCredito['abonoinicial'];
            $ultimocierre->ventasenefectivo += $valorefectivo;
            $ultimocierre->actualizar();

            $getDB->commit();
            $alertas['exito'][] = "Credito de tipo separado creado correctamente.";
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
            'cuotas' => $cuotasRepo->unJoinWhereArrayObj('mediospago', 'mediopagoid', 'id', ['id_credito' => $credito->id]),
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
        if($credito->estado == 0){
            $cuota = new cuotas($datos);
            $cuota->prepararSegunCredito($credito);
            $alertas = $cuota->validar();
            if(empty($alertas)){
                $cuotaRepo = new cuotasRepository();
                $getDB = $cuotaRepo::getDB();
                $getDB->begin_transaction();
                try {
                    $r = $cuotaRepo->insert($cuota);
                    $objMedioPago = new separadomediopago(['idcuota'=>$r[1], 'mediopago_id'=>$datos['mediopagoid'], 'valor'=>$datos['valorpagado']]);
                    $credito->actualizarCredito($cuota->valorpagado);
                    $ra = $creditoRepo->update($credito);
                    $payment = new paymentService(new separadoMediopagoRepository());
                    $payment->registrarPagos([$objMedioPago], $r[1]);
                    
                    //si es abono en efectivo, registrar al efectivo del cierre de caja y en el abono del cierre de caja
                    $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$cuota->cajaid, 'idsucursal_id'=>id_sucursal()]);
                    if(!isset($ultimocierre)){ // si la caja esta cerrada y se hace apertura con el registro del abono
                        $ultimocierre = new cierrescajas(['idcaja'=>$cuota->cajaid, 'nombrecaja'=>caja::find('id', $cuota->cajaid)->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
                        $ultimocierre->crear_guardar();
                    }

                    $ultimocierre->abonos += $objMedioPago->valor;
                    if($objMedioPago->mediopago_id == 1)
                        $ultimocierre->ventasenefectivo += $objMedioPago->valor;
                    $ultimocierre->actualizar();

                    //**generar factura cuando se termine de pagar el separado
                    //creditosService::registrarFactura($credito, $ultimocierre);
                    //**los productos llevarlos a la tabla ventas

                    $getDB->commit();
                    $alertas['exito'][] = "Cuota procesada";
                } catch (\Throwable $th) {
                    $getDB->rollback();
                    $alertas['error'][] = "Error al procesar el abono {$th->getMessage()}";
                }
            }
        }else{
            $alertas['error'][] = "Credito finalizado, no se puede abonar mas.";
        }
        return $alertas;

    }


    public static function pagoTotal(){
        
    }


    public static function registrarFactura(object $credito, $ultimocierre, $carrito){
        session_start();
        $venta = new ventas();
        $array = [
                    'id_sucursal' => id_sucursal(), 
                    'idcliente' => $credito->cliente_id, 
                    'idvendedor' => $_SESSION['id'], 
                    'idcaja' => $ultimocierre->idcaja, 
                    'idconsecutivo' =>1,
                    'iddireccion' => 1,
                    'idtarifazona' => 1,
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
                    'totalunidades' => 1,
                    'recibido' => 0,
                    'cambio' => 0,
                    'transaccion' => 0,
                    'tipoventa' => 'credito',
                    'cotizacion' => 0,
                    'estado' => 'paga',
                    'cambioaventa' => 0, 
                    'referencia' => $credito->id,
                    'subtotal' => $credito->montototal,
                    'base' => $credito->montototal,
                    'valorimpuestototal' => 0,
                    'dctox100' => 0,
                    'descuento' => 0,
                    'total' => $credito->montototal,
                    'observacion' => '',
                    'departamento' => '',
                    'ciudad' => '',
                    'entrega' => 'Presencial',
                    'valortarifa' => 0,
                    'fechacreacion' => date('Y-m-d H:i:s'),
                    'fechapago' => date('Y-m-d H:i:s'),
                    'opc1' => '',
                    'opc2' =>  '',
                ];
        $factura = new facturas($array);
        $factura->num_orden = facturas::calcularNumOrden(id_sucursal());
        $consecutivo = consecutivos::findForUpdate('id', $_POST['idconsecutivo']);
        $numConsecutivo = $consecutivo->siguientevalor;
        $factura->num_consecutivo = $numConsecutivo;
        $factura->prefijo = $consecutivo->prefijo;
        $r = $factura->crear_guardar();
        $consecutivo->siguientevalor = $numConsecutivo + 1;
        $c = $consecutivo->actualizar();
        $factura->crear_guardar();

        $venta->crear_varios_reg_arrayobj($carrito);
    }
}