<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\clientes\clientes;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\creditos\productosseparados;
use App\Models\inventario\productos_sub;
use App\Models\ventas\facturas;
use stdClass;

//**SERVICIO DE CREDITOS

class creditosService {

    public static function registrarAbono($datosCuota):array{
        
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
    }


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
        $getDB->begin_transaction();
        try {
            $r = $separado->crear_guardar();
            //registrar medios de pago del abono inicial
            
            //registrar los productos separados
            $r1 = $productosseparados->crear_varios_reg_arrayobj($carrito);

            //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
            $resultArray = array_reduce($carrito, function($acumulador, $objeto){
                $obj = clone $objeto;
                $obj->id = $objeto->idproducto;
                //unset($objeto->iditem);
                if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){  //producto simple o producto compuesto de tipo produccion construccion, solo se descuenta sus cantidades, y sus insumos cuando se hace produccion en almacen del producto compuesto
                    if(!isset($acumulador['productosSimples'][$objeto->id])){
                    $acumulador['productosSimples'][$objeto->id] = $obj;
                    $acumulador['soloIdproductos'][] = $obj->id;
                    }else{
                    $acumulador['productosSimples'][$objeto->id]->cantidad += $obj->cantidad;
                    }
                }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){  //producto compuesto e inmediato es decir por cada venta se descuenta sus insumos
                    if(!isset($acumulador['productosCompuestos'][$objeto->id])){
                    $acumulador['productosCompuestos'][$objeto->id] = $obj;
                    }else{
                    $acumulador['productosCompuestos'][$objeto->id]->cantidad += $obj->cantidad;
                    }
                    $acumulador['productosCompuestos'][$objeto->id]->porcion = round((float)$acumulador['productosCompuestos'][$objeto->id]->cantidad/(float)$objeto->rendimientoestandar, 4);
                }
                return $acumulador;
            }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);
            

            //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
            $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
            //////// sumar los subproductos repetidos
            $reduceSub = [];
            $soloIdInsumos =[];
            foreach($descontarSubproductos as $idx => $obj){
                if(!isset($reduceSub[$obj->id_subproducto])){
                    $obj->id = $obj->id_subproducto;
                    $reduceSub[$obj->id_subproducto] = $obj;
                    $soloIdInsumos[] = $obj->id;
                }else{
                $reduceSub[$obj->id_subproducto]->cantidad += $obj->cantidad;
                }
            }
            
            //descontar de inventario
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