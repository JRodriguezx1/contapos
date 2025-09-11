<?php

namespace Model;

class permisos extends ActiveRecord{
    protected static $tabla = 'permisos';
    protected static $columnasDB = ['id', 'nombre', 'descripcion'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre']??'';
        $this->descripcion = $args['descripcion']??'';
        $this->created_at = $args['created_at']??'';
    }
}