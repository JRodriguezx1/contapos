<?php

namespace App\Models\inventario;

class movimientos_productos extends \App\Models\ActiveRecord{
    protected static $tabla = 'movimientos_productos';
    protected static $columnasDB = ['id', 'idfksucursal', 'idproducto_id', 'id_usuarioid', 'nombreusuario', 'tipo', 'referencia', 'stockanterior', 'stocknuevo', 'comentario'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idfksucursal = $args['idfksucursal']??'';
        $this->idproducto_id = $args['idproducto_id']??'';
        $this->id_usuarioid = $args['id_usuarioid']??'';
        $this->nombreusuario = $args['nombreusuario']??'';
        $this->tipo = $args['tipo']??'';
        $this->referencia = $args['referencia']??'';
        $this->stockanterior = $args['stockanterior']??'';
        $this->stocknuevo = $args['stocknuevo']??'';
        $this->comentario = $args['comentario']??'';
        $this->created_at = $args['created_at']??'';
    }

    public function validar():array
    {
        if(!$this->idfksucursal)self::$alertas['error'][] = "Sucursal no especificado";
        if(!$this->idproducto_id)self::$alertas['error'][] = "id del producto no especificado";
        if(!$this->id_usuarioid)self::$alertas['error'][] = "usuario no especificado";
        if(!$this->tipo)self::$alertas['error'][] = "Tipo de movimiento no especificado";
        return self::$alertas;
    }

}