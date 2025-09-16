<?php

namespace Model;

class factimpuestos extends ActiveRecord{
    protected static $tabla = 'factimpuestos';
    protected static $columnasDB = ['id', 'id_impuesto', 'facturaid', 'valor'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->id_impuesto = $args['id_impuesto']??'';
        $this->facturaid = $args['facturaid']??'';
        $this->valor = $args['valor']??'';
    }


    public function validar():array
    {
        if(!$this->id_impuesto)self::$alertas['error'][] = "Error intenta nuevamnete";
        return self::$alertas;
    }
    
}