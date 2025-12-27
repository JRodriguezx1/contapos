<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\clientes\clientes;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\creditos\productosseparados;
use App\Models\creditos\separadomediopago;
use App\Models\inventario\productos_sub;
use App\Models\ventas\facturas;
use stdClass;

//**SERVICIO DE CREDITOS

class creditosService {

    /*public static function registrarAbono($datosCuota):array{
        
            if($credito->estado == 0){
                $cuota = new cuotas($datosCuota);
                $credito->numcuota += 1;
                $cuota->numerocuota = $credito->numcuota;
                $cuota->montocuota = $credito->montocuota;
                $alertas = $cuota->validar();
                if(empty($alertas)){
                    $r = $cuota->crear_guardar();
                    if($r[0]){
                        $alertas['exito'][] = "Cuota procesada";
                        $credito->saldopendiente -= $cuota->valorpagado;
                        if($credito->saldopendiente<=0)$credito->estado = 1;  //credito cerrado
                        $ra = $credito->actualizar();
                        
                    }
                }
            }else{
                $alertas['error'][] = "Credito finalizado, no se puede abonar mas";
            }
        
        return $alertas;
    }*/


    public static function crearCredito(stdClass $valoresCredito, $idfactura, $idcliente){
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $array = (array)$valoresCredito;
        $credito = new creditos($array);
        $credito->idtipofinanciacion = 1;
        $credito->factura_id = $idfactura;
        $credito->cliente_id = $idcliente;
        $credito->saldopendiente = $credito->montototal;
        $credito->frecuenciapago = date('j');
        $alertas = $credito->validar();
        if(empty($alertas)){
            $r = $credito->crear_guardar();
        }
    }


    public static function ejecutarCrearSeparado(array $valoresCredito, array $carrito, array $mediospago):array{
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $separado = new creditos($valoresCredito);
        $productosseparados = new productosseparados;
        $getDB = creditos::getDB();
        if(!isset($separado->frecuenciapago))$separado->frecuenciapago = date('j');
        //$alertas = $separado->validar();
        //if(empty($alertas)){

        $cuota = new cuotas($valoresCredito);
        debuguear($cuota);
        
        $getDB->begin_transaction();
        try {
            $r = $separado->crear_guardar();
            // registrar abono inicial en tabla cuotas
            if($separado->abonoinicial > 0){
                $cuota = new cuotas($valoresCredito);
            }
            //registrar medios de pago del abono inicial si aplica
            $payment = new paymentService(separadomediopago::class);  //separadomediopago::class = a nombre de la clase como string
            $payment->registrarPagos($mediospago, 1);
           
            //registrar los productos
            foreach($carrito as $obj){
              $obj->idcredito = $r[1];
              $obj->idproducto = $obj->fk_producto;
            }
            $r1 = $productosseparados->crear_varios_reg_arrayobj($carrito);
            //descontar de inventario
            $a = ventasService::ajustarIventarioXVenta($carrito);
            //ajustar abono o pagos en caja
            
            $getDB->commit();
            $alertas['exito'][] = "Credito de tipo separado creado correctamente.";
        } catch (\Throwable $th) {
            $getDB->rollback();
            $alertas['error'][] = "Error al generar el credito de tipo separado. ".$th->getMessage();
        }
        //}
        return $alertas;
    }


}