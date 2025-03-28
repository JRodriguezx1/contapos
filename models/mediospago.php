<?php

namespace Model;

class mediospago extends ActiveRecord{
    protected static $tabla = 'mediospago';
    protected static $columnasDB = ['id', 'mediopago', 'estado', 'nick'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->mediopago = $args['mediopago']??'';
        $this->estado = $args['estado']??1;
        $this->nick = $args['nick']??'';
    }


    public function validar():array
    {
        if(!$this->mediopago)self::$alertas['error'][] = "Medio de pago no especificado";
        if(strlen($this->mediopago)>31)self::$alertas['error'][] = "Has excecido el limite de caracteres";
        return self::$alertas;
    }

}

?>