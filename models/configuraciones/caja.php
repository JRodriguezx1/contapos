<?php

namespace Model\configuraciones;

class caja extends \Model\ActiveRecord{
    protected static $tabla = 'caja';
    protected static $columnasDB = ['id', 'idsucursalid', 'idtipoconsecutivo', 'nombre', 'negocio', 'editable', 'estado'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idsucursalid = id_sucursal();
        $this->idtipoconsecutivo = $args['idtipoconsecutivo']??'';
        $this->nombre = $args['nombre']??'';
        $this->negocio = $args['negocio']??'';
        $this->editable = $args['editable']??'1';
        $this->estado = $args['estado']??'1';
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!$this->idtipoconsecutivo)self::$alertas['error'][] = "Consecutivo de factura no especificado";
        if(!$this->nombre)self::$alertas['error'][] = "Nombre de caja no especificado";
        if(strlen($this->nombre)>26)self::$alertas['error'][] = "Has excecido el limite de caracteres del nombre de caja";
        if(strlen($this->nombre)<3)self::$alertas['error'][] = "Muy pocos caracteres dle nombre de caja";
        return self::$alertas;
    }

}

?>