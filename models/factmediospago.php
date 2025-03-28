<?php

namespace Model;

class factmediospago extends ActiveRecord{
    protected static $tabla = 'factmediospago';
    protected static $columnasDB = ['id', 'idmediopago', 'id_factura', 'valor'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idmediopago = $args['idmediopago']??'';
        $this->id_factura = $args['id_factura']??'';
        $this->valor = $args['valor']??'';
    }


    public function validar():array
    {
        if(!$this->idmediopago)self::$alertas['error'][] = "Error intenta nuevamnete";
        if(strlen($this->id_factura)>31)self::$alertas['error'][] = "Error intenta nuevamnete";
        return self::$alertas;
    }
    
}

?>