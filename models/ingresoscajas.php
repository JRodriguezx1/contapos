<?php

namespace Model;

class ingresoscajas extends ActiveRecord{
    protected static $tabla = 'ingresoscajas';
    protected static $columnasDB = ['id', 'idusuario', 'id_caja', 'id_cierrecaja', 'operacion', 'fecha', 'valor', 'descripcion'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idusuario = $args['idusuario']??'';
        $this->id_caja = $args['id_caja']??'';
        $this->id_cierrecaja = $args['id_cierrecaja']??'';
        $this->operacion = $args['operacion']??'';
        $this->fecha = $args['fecha']?? date('Y-m-d H:i:s');
        $this->valor = $args['valor']??'';
        $this->descripcion = $args['descripcion']??'';
    }


    public function validar():array
    {
        if(!$this->idusuario)self::$alertas['error'][] = "Error con usuario de sistema";
        if(!$this->id_caja)self::$alertas['error'][] = "Caja no seleccionada";
        if(!$this->id_cierrecaja)self::$alertas['error'][] = "Error con la apertura del dia de caja";
        if(!$this->operacion)self::$alertas['error'][] = "Error con la operacion de ingreso de caja";
        if(!$this->valor)self::$alertas['error'][] = "Valor de ingreso de caja no ingresado";
        if(strlen($this->descripcion)>244)self::$alertas['error'][] = "Has excecido el limite de caracteres de la descripcion";
        return self::$alertas;
    }

}

?>