<?php 

namespace App\services;

use App\Models\inventario\movimientos_insumos;
use App\Models\inventario\movimientos_productos;
use App\Models\inventario\stockinsumossucursal;
use App\Models\inventario\stockproductossucursal;
use stdClass;

class stockService {

    public static function upStock_movimientoInv(){

    }


    //registrar descuento de movimiento de inventario de insumos de forma masiva
    public static function downStock_movimientoInv(array $descontarSubproductos, array $returnInsumos){
        
        $movInv = new movimientos_insumos;
        //registrar descuento de movimiento de inventario de insumos de forma masiva
        $arrayMovInv = [];
        $cantidadxitem = array_column($descontarSubproductos, 'cantidad', 'id');
        foreach($returnInsumos as $value){
            $obj = new stdClass();
            $obj->fksucursal_id = id_sucursal();
            $obj->id_subproductoid = $value->subproductoid;
            $obj->idusuario_id = $_SESSION['id'];
            $obj->nombreusuario = $_SESSION['nombre'];
            $obj->tipo = 'descuento por produccion';
            $obj->referencia = 'Descuento de insumos por produccion';
            $obj->cantidad = $cantidadxitem[$value->subproductoid];
            $obj->stockanterior = $value->stock + $cantidadxitem[$value->subproductoid];
            $obj->stocknuevo = $value->stock;
            $obj->comentario = '';
            $arrayMovInv[] = $obj;
        }
        $rmov = $movInv->crear_varios_reg_arrayobj($arrayMovInv);
        
    }
    
}