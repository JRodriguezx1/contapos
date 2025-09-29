<?php

namespace Model\felectronicas;

class estados_electronicas extends \Model\ActiveRecord{
    protected static $tabla = 'estados_electronicas';
    protected static $columnasDB = ['id', 'descripcion'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->descripcion = $args['descripcion']??'';
        $this->created_at = $args['created_at']??'';
    }


}