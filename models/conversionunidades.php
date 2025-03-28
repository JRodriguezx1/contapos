<?php

namespace Model;

class conversionunidades extends ActiveRecord{
    protected static $tabla = 'conversionunidades';
    protected static $columnasDB = ['id', 'idsubproducto', 'idunidadmedidabase', 'idunidadmedidadestino', 'nombreunidadbase', 'nombreunidaddestino', 'factorconversion'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idsubproducto = $args['idsubproducto']??'';
        $this->idunidadmedidabase = $args['idunidadmedidabase']??'';
        $this->idunidadmedidadestino = $args['idunidadmedidadestino']??'';
        $this->nombreunidadbase = $args['nombreunidadbase']??'';
        $this->nombreunidaddestino = $args['nombreunidaddestino']??'';
        $this->factorconversion = $args['factorconversion']??'';
    }

    public function validar():array
    {
        if(!$this->idsubproducto)self::$alertas['error'][] = "Error subproducto intenta nuevamnete";
        if(!$this->idunidadmedidabase)self::$alertas['error'][] = "Error unidad base intenta nuevamnete.";
        if(!$this->idunidadmedidadestino)self::$alertas['error'][] = "Error unidad destino intenta nuevamnete.";
        if(!$this->factorconversion)self::$alertas['error'][] = "Error factor de conversion intenta nuevamnete.";
        return self::$alertas;
    }  
}
?>