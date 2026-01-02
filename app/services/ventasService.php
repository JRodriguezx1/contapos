<?php 

namespace App\services;

use App\Models\inventario\productos_sub;
use App\Models\inventario\stockinsumossucursal;
use App\Models\inventario\stockproductossucursal;


//**SERVICIO DE VENTAS

class ventasService {

    public static function ajustarIventarioXVenta($carrito):array{
        //$invSub = true;
        //$invPro = true;
        //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
        $resultArray = array_reduce($carrito, function($acumulador, $objeto){
            $obj = clone $objeto;
            $obj->id = $objeto->idproducto;
            //unset($objeto->iditem);
            if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){  //producto simple o producto compuesto de tipo produccion construccion, solo se descuenta sus cantidades, y sus insumos cuando se hace produccion en almacen del producto compuesto
                if(!isset($acumulador['productosSimples'][$objeto->idproducto])){
                $acumulador['productosSimples'][$objeto->idproducto] = $obj;
                $acumulador['soloIdproductos'][] = $obj->id;
                }else{
                $acumulador['productosSimples'][$objeto->idproducto]->cantidad += $obj->cantidad;
                }
            }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){  //producto compuesto e inmediato es decir por cada venta se descuenta sus insumos
                if(!isset($acumulador['productosCompuestos'][$objeto->idproducto])){
                $acumulador['productosCompuestos'][$objeto->idproducto] = $obj;
                }else{
                $acumulador['productosCompuestos'][$objeto->idproducto]->cantidad += $obj->cantidad;
                }
                $acumulador['productosCompuestos'][$objeto->idproducto]->porcion = round((float)$acumulador['productosCompuestos'][$objeto->idproducto]->cantidad/(float)$objeto->rendimientoestandar, 4);
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

        if(!empty($resultArray['productosSimples'])){
            $invPro = stockproductossucursal::reduceinv1condicion($resultArray['productosSimples'], 'stock', 'productoid', "sucursalid = ".id_sucursal());
            //registrar descuento de movimiento de invnetario
            $query = "SELECT * FROM stockproductossucursal WHERE productoid IN(".join(', ', $resultArray['soloIdproductos']).") AND sucursalid = ".id_sucursal().";";
            $returnProductos = stockproductossucursal::camposJoinObj($query);
            stockService::downStock_movimientoProductos($resultArray['productosSimples'], $returnProductos, 'venta', 'descuento de unidades por venta');
        }
        //////// descontar del inventario la variable reduceSub que es el total de subproductos a descontar
        if($invPro && !empty($reduceSub)){
            //$invSub = subproductos::updatereduceinv($reduceSub, 'stock');
            $invSub = stockinsumossucursal::reduceinv1condicion($reduceSub, 'stock', 'subproductoid', "sucursalid = ".id_sucursal());
            //registrar descuento de movimiento de invnetario
            $query = "SELECT * FROM stockinsumossucursal WHERE subproductoid IN(".join(', ', $soloIdInsumos).") AND sucursalid = ".id_sucursal().";";
            $returnInsumos = stockinsumossucursal::camposJoinObj($query);
            stockService::downStock_movimientoInsumos($reduceSub, $returnInsumos, 'venta', 'descuento de unidades por venta');
        }


        return $resultArray;
    }
}