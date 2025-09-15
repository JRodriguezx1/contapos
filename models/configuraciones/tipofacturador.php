<?php

namespace Model\configuraciones;

class tipofacturador extends \Model\ActiveRecord{
    protected static $tabla = 'tipofacturador';
    protected static $columnasDB = ['id', 'nombre'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre']??'';
    }
}
