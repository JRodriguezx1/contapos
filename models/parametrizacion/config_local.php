<?php

namespace Model\parametrizacion;

class config_local extends \Model\ActiveRecord{
    protected static $tabla = 'config_local';
    protected static $columnasDB = ['id', 'fk_sucursalid', 'clave', 'valor'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->fk_sucursalid = $args['fk_sucursalid']??'';
        $this->clave = $args['clave']??'';
        $this->valor = $args['valor']??'';
        $this->created_at = $args['created_at']??'';
    }


}