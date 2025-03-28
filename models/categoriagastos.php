<?php

namespace Model;

class categoriagastos extends ActiveRecord {
    
    protected static $tabla = 'categoriagastos';
    protected static $columnasDB = ['id', 'nombre'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}