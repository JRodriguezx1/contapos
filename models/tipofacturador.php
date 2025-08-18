<?php

namespace Model;

class tipofacturador extends ActiveRecord{
    protected static $tabla = 'tipofacturador';
    protected static $columnasDB = ['id', 'nombre'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre']??'';
    }
}
