<?php

namespace Model;

class sucursales extends ActiveRecord{
    protected static $tabla = 'sucursales';
    protected static $columnasDB = ['id', 'nombre', 'direccion', 'telefono', 'estado'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre']??'';
        $this->direccion = $args['direccion']??'';
        $this->telefono = $args['telefono']??'';
        $this->estado = $args['estado']??1;
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!$this->nombre)self::$alertas['error'][] = "Nombre de la sucursal no especificado";
        if(strlen($this->nombre)>20)self::$alertas['error'][] = "Has excecido el limite de caracteres del nombre de la sucursal";
        if(strlen($this->direccion)>60)self::$alertas['error'][] = "Has excecido el limite de caracteres para la direccion";
        if(strlen($this->telefono)>15)self::$alertas['error'][] = "Has excecido el limite de caracteres para el telefono";
        return self::$alertas;
    }

}