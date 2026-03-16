<?php

namespace App\Models\inventario;

class costosinsumos extends \App\Models\ActiveRecord{
    protected static $tabla = 'costosinsumos';
    protected static $columnasDB = ['id', 'idsubproductoid', 'tipocosto', 'precio_compra', 'fechaajuste'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idsubproductoid = $args['idsubproductoid']??'';
        $this->tipocosto = $args['tipocosto']??'1';  //1 = compra, 0 = ajuste
        $this->precio_compra = $args['precio_compra']??1;
        $this->fechaajuste = $args['fechaajuste']??date('Y-m-d H:i:s');
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!is_numeric($this->precio_compra))self::$alertas['error'][] = "Costo no es correcto, verifica nuevamente.";
        return self::$alertas;
    }

}

?>