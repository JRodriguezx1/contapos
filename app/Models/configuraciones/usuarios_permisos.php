<?php

namespace Model\configuraciones;

class usuarios_permisos extends \Model\ActiveRecord{
    protected static $tabla = 'usuarios_permisos';
    protected static $columnasDB = ['id', 'usuarioid', 'permisoid'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->usuarioid = $args['usuarioid']??'';
        $this->permisoid = $args['permisoid']??'';
        $this->created_at = $args['created_at']??'';
    }

}