<?php 

namespace App\services;

use App\Models\inventario\movimientos_insumos;
use App\Models\inventario\movimientos_productos;
use stdClass;

class stockService {

    public static function upDate_movimientoProductos(array $sumarSubproductos, array $returnInsumos, $tipo, $referencia){
        $movInv = new movimientos_productos;
        //registrar descuento de movimiento de inventario de insumos de forma masiva
        $arrayMovInv = [];
        $cantidadxitem = array_column($sumarSubproductos, 'cantidad', 'id');
        foreach($returnInsumos as $value){
            $obj = new stdClass();
            $obj->idfksucursal = id_sucursal();
            $obj->idproducto_id = $value->productoid;
            $obj->id_usuarioid = $_SESSION['id'];
            $obj->nombreusuario = $_SESSION['nombre'];
            $obj->tipo = $tipo;
            $obj->referencia = $referencia;
            $obj->cantidad = $cantidadxitem[$value->productoid];
            $obj->stockanterior = $value->stock;
            $obj->stocknuevo = $obj->cantidad;
            $obj->comentario = $referencia;
            $arrayMovInv[] = $obj;
        }
        $rmov = $movInv->crear_varios_reg_arrayobj($arrayMovInv);
    }


    public static function upStock_movimientoProductos(array $sumarSubproductos, array $returnInsumos, $tipo, $referencia){
        $movInv = new movimientos_productos;
        //registrar descuento de movimiento de inventario de insumos de forma masiva
        $arrayMovInv = [];
        $cantidadxitem = array_column($sumarSubproductos, 'cantidad', 'id');
        foreach($returnInsumos as $value){
            $obj = new stdClass();
            $obj->idfksucursal = id_sucursal();
            $obj->idproducto_id = $value->productoid;
            $obj->id_usuarioid = $_SESSION['id'];
            $obj->nombreusuario = $_SESSION['nombre'];
            $obj->tipo = $tipo;
            $obj->referencia = $referencia;
            $obj->cantidad = $cantidadxitem[$value->productoid];
            $obj->stockanterior = $value->stock - $cantidadxitem[$value->productoid];
            $obj->stocknuevo = $value->stock;
            $obj->comentario = $referencia;
            $arrayMovInv[] = $obj;
        }
        $rmov = $movInv->crear_varios_reg_arrayobj($arrayMovInv);
    }

    public static function downStock_movimientoProductos(array $sumarSubproductos, array $returnInsumos, $tipo, $referencia){
         $movInv = new movimientos_productos;
        //registrar descuento de movimiento de inventario de insumos de forma masiva
        $arrayMovInv = [];
        $cantidadxitem = array_column($sumarSubproductos, 'cantidad', 'id');
        foreach($returnInsumos as $value){
            $obj = new stdClass();
            $obj->idfksucursal = id_sucursal();
            $obj->idproducto_id = $value->productoid;
            $obj->id_usuarioid = $_SESSION['id'];
            $obj->nombreusuario = $_SESSION['nombre'];
            $obj->tipo = $tipo;
            $obj->referencia = $referencia;
            $obj->cantidad = $cantidadxitem[$value->productoid];
            $obj->stockanterior = $value->stock + $cantidadxitem[$value->productoid];
            $obj->stocknuevo = $value->stock;
            $obj->comentario = $referencia;
            $arrayMovInv[] = $obj;
        }
        $rmov = $movInv->crear_varios_reg_arrayobj($arrayMovInv);
    }


    public static function upStock_movimientoInsumos(array $sumarSubproductos, array $returnInsumos, $tipo, $referencia){
         $movInv = new movimientos_insumos;
        //registrar descuento de movimiento de inventario de insumos de forma masiva
        $arrayMovInv = [];
        $cantidadxitem = array_column($sumarSubproductos, 'cantidad', 'id');
        foreach($returnInsumos as $value){
            $obj = new stdClass();
            $obj->fksucursal_id = id_sucursal();
            $obj->id_subproductoid = $value->subproductoid;
            $obj->idusuario_id = $_SESSION['id'];
            $obj->nombreusuario = $_SESSION['nombre'];
            $obj->tipo = $tipo;
            $obj->referencia = $referencia;
            $obj->cantidad = $cantidadxitem[$value->subproductoid];
            $obj->stockanterior = $value->stock - $cantidadxitem[$value->subproductoid];
            $obj->stocknuevo = $value->stock;
            $obj->comentario = $referencia;
            $arrayMovInv[] = $obj;
        }
        $rmov = $movInv->crear_varios_reg_arrayobj($arrayMovInv);
    }


    //registrar descuento de movimiento de inventario de insumos de forma masiva
    public static function downStock_movimientoInsumos(array $descontarSubproductos, array $returnInsumos, $tipo, $referencia){
        
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
            $obj->tipo = $tipo;
            $obj->referencia = $referencia;
            $obj->cantidad = $cantidadxitem[$value->subproductoid];
            $obj->stockanterior = $value->stock + $cantidadxitem[$value->subproductoid];
            $obj->stocknuevo = $value->stock;
            $obj->comentario = $referencia;
            $arrayMovInv[] = $obj;
        }
        $rmov = $movInv->crear_varios_reg_arrayobj($arrayMovInv);
        
    }
    
}