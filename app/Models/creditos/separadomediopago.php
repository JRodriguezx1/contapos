<?php

namespace App\Models\creditos;
use App\Models\contracts\mediosPagoContract;

class separadomediopago extends \App\Models\ActiveRecord implements mediosPagoContract{
    protected static $tabla = 'separadomediopago';
    protected static $columnasDB = ['id', 'idcuota', 'mediopago_id', 'valor'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idcuota = $args['idcuota']??'';
        $this->mediopago_id = $args['mediopago_id']??'';
        $this->valor = $args['valor']??'';
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!$this->idcuota)self::$alertas['error'][] = "Error intenta nuevamnete";
        if(!$this->mediopago_id)self::$alertas['error'][] = "Error intenta nuevamnete";
        return self::$alertas;
    }
    

    public function pagoDestino(int $id):void{
        $this->idcuota = $id;
    }
}