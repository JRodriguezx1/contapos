<?php

namespace App\Models\configuraciones;

class deviceprinter extends \App\Models\ActiveRecord{
    protected static $tabla = 'deviceprinter';
    protected static $columnasDB = ['id', 'nombre', 'nombrecompartido', 'estacion', 'estado'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre']??'';
        $this->nombrecompartido = $args['nombrecompartido']??'';
        $this->estacion = $args['estacion']??1;
        $this->estado = $args['estado']??1;
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!$this->nombre)self::$alertas['error'][] = "Nombre de la impresora no especificado";
        if(strlen($this->nombre)>20)self::$alertas['error'][] = "Has excecido el limite de caracteres del nombre compartido";
        if(strlen($this->nombrecompartido)>20)self::$alertas['error'][] = "Has excecido el limite para el nombre compartido de la impresora";
        if($this->estacion>200)self::$alertas['error'][] = "Numero de estacion no permitido";
        return self::$alertas;
    }

}