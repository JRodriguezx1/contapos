<?php

namespace Model;

class productos_sub extends ActiveRecord{
    protected static $tabla = 'productos_sub';
    protected static $columnasDB = ['id', 'id_producto', 'id_subproducto', 'cantidadsubproducto', 'costo'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->id_producto = $args['id_producto']??'';
        $this->id_subproducto = $args['id_subproducto']??'';
        $this->cantidadsubproducto = $args['cantidadsubproducto']??'';
        $this->costo = $args['costo']??0;
    }

    public function validar():array
    {
        if(!$this->id_producto)self::$alertas['error'][] = "Error intenta nuevamnete";
        if(strlen($this->id_subproducto)>31)self::$alertas['error'][] = "Error intenta nuevamnete";
        if(!$this->cantidadsubproducto || !is_numeric($this->cantidadsubproducto))self::$alertas['error'][] = "cantidad del subproducto no especificado";
        return self::$alertas;
    }


    //////// SE UTILIZA ESTE METODO CUANDO SE REALIZA COMPRAS
    public static function actualizar_costos_de_prosub($array=[], $colums=[]):bool
    {
        $query = "UPDATE ".static::$tabla." SET ";          //$coums = ['stock', 'precio_compra',..]
        $in = "";
        $ctrl=1;
        foreach($colums as $idx => $col){
            $query .= $col." = CASE ";
                foreach($array as $index => $value){
                    $query .= "WHEN id = $value->id THEN cantidadsubproducto*{$value->$col} ";
                    if($ctrl){
                        if(array_key_last($array) === $index){
                            $in .= "$value->id";
                        }else{
                            $in .= "$value->id, ";
                        }
                    }
                }
                $ctrl=0;
            if(array_key_last($colums) === $idx){
                $query .= "ELSE $col END WHERE id IN ($in);";
            }else{
                $query .= "ELSE $col END, ";
            }
        }//UPDATE productos_sub SET costo = CASE WHEN id = 2 THEN cantidadsubproducto*20 WHEN id = 3 THEN cantidadsubproducto*100 WHEN id = 13 THEN cantidadsubproducto*100 ELSE costo END WHERE id IN (2, 3, 13);
        $resultado = self::$db->query($query);
        return $resultado;
    }

    
    //////////// SE UTILIZA ESTE METODO CUANDO SE REALIZA UNA VENTA DE PRODUCTOS COMPUESTOS, PARA CALCULUAR LA CANTIDAD DE SUBPRODUCTOS ASOCIADOS AL PRODUCTO COMPUESTO A DESCONTAR
    public static function cantidadSubproductosXventa($array=[]):array
    {
        $query = "SELECT *, CASE ";
        $in = "";
        foreach($array as $index => $value){
            $query .= "WHEN id_producto = $value->id THEN cantidadsubproducto*{$value->porcion} ";
            if(array_key_last($array) === $index){
                $in .= "$value->id";
            }else{
                $in .= "$value->id, ";
            }
        }   
        $query .= "ELSE cantidadsubproducto END AS cantidad FROM ".static::$tabla." WHERE id_producto IN ($in);";
        //SELECT *, CASE WHEN id_producto = 1 THEN cantidadsubproducto*3 WHEN id_producto = 2 THEN cantidadsubproducto*2 ELSE cantidadsubproducto END as x FROM productos_sub WHERE id_producto IN (1, 2);
        $arreglo = [];
        if(!empty($array)){
            $resultado = self::$db->query($query);
            while($row = $resultado->fetch_object()){  
                $arreglo[] = $row;
            }
        $resultado->free();  //[{'id':'1', 'costo':'23'}, {}]  cada obj es una fila de la tabla
        }
        return $arreglo;
    }
}
?>