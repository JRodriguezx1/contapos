<?php
namespace Model;

class consecutivos extends ActiveRecord {
    protected static $tabla = 'consecutivos';
    protected static $columnasDB = ['id', 'idtipofacturador', 'idnegocio', 'nombre', 'rangoinicial', 'rangofinal', 'siguientevalor', 'fechainicio', 'fechafin', 'resolucion', 'consecutivoremplazo', 'prefijo', 'mostrarresolucion', 'mostrarimpuestodiscriminado', 'tokenfacturaelectronica'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idtipofacturador = $args['idtipofacturador'] ?? 1;
        $this->idnegocio = $args['idnegocio'] ?? 1; 
        $this->nombre = $args['nombre'] ?? 1;
        $this->rangoinicial = $args['rangoinicial'] ?? 1;
        $this->rangofinal = $args['rangofinal'] ?? 1;
        $this->siguientevalor = $args['siguientevalor'] ?? 1;
        $this->fechainicio = $args['fechainicio'] ?? '';  
        $this->fechafin = $args['fechafin'] ?? '';  
        $this->resolucion = $args['resolucion'] ?? '';   
        $this->consecutivoremplazo = $args['consecutivoremplazo'] ?? '';  
        $this->prefijo = $args['prefijo'] ?? '';  
        $this->mostrarresolucion = $args['mostrarresolucion'] ?? '';  
        $this->mostrarimpuestodiscriminado = $args['mostrarimpuestodiscriminado'] ?? 0;
        $this->tokenfacturaelectronica = $args['tokenfacturaelectronica'] ?? 0;
    }

    // Validación para clientes nuevos
    public function validar_nueva_consecutivo():array {
        if(!$this->idtipofacturador)self::$alertas['error'][] = 'Id tipofacturador no encontrado';
        if(!$this->nombre)self::$alertas['error'][] = 'nombre del consecutivo no especificado';
        return self::$alertas;
    }
}