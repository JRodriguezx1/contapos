<?php

namespace Model\configuraciones;

class tarifas extends \Model\ActiveRecord{
    protected static $tabla = 'tarifas';
    protected static $columnasDB = ['id', 'nombre', 'valor'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre']??'';
        $this->valor = $args['valor']??'';
    }


    public function validarTarifa(){
        if(!$this->nombre)self::$alertas['error'][] = "Nombre de tarifa no ingresada";
        if(!$this->valor)self::$alertas['error'][] = "Valor de la tarifa no ingresada";
        if(!is_numeric($this->valor))self::$alertas['error'][] = 'Valor de la tarifa es incorrecto debe ser numerico';
        return self::$alertas;
    }
}

?>