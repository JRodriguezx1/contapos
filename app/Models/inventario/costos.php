<?php

namespace App\Models\inventario;

class costos extends \App\Models\ActiveRecord{
    protected static $tabla = 'costos';
    protected static $columnasDB = ['id', 'idproducto', 'tipocosto', 'costo', 'fechaajuste'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idproducto = $args['idproducto']??'';
        $this->tipocosto = $args['tipocosto']??'1';  //1 = compra, 0 = ajuste
        $this->costo = $args['costo']??1;
        $this->fechaajuste = $args['fechaajuste']??date('Y-m-d H:i:s');
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!is_numeric($this->costo))self::$alertas['error'][] = "Costo no es correcto, verifica nuevamente.";
        return self::$alertas;
    }

}

?>