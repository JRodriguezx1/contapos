<?php

namespace App\Repositories\suscripcioncuenta;

use App\Models\suscripcioncuenta\suscripcion_sucursal;
use App\Repositories\operationRepository;

class suscripcionSucursalRepository extends operationRepository{

    //private $db;
    protected string $table = 'suscripcion_sucursal';
    protected string $entityClass = suscripcion_sucursal::class;
    protected array $allowedColumns = [];  //es la misma propiedad heredada del padre, pero se redefine en el constructor de la clase hija.

    public function __construct(/*$conexion*/)
    {
        //$this->db = $conexion;
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
        
    }

    
    public function getConexion(){ return self::getDB(); }


    /*public function suspendido() {
        $this->estado = 'suspendido';
         $entity = new $this->entityClass($array);
        $entity->usuariofk = $idvendedor;
        $entity->idtipofinanciacion = 1;
    }

    public function activar() {
        $this->estado = 'activo';
    }

    public function actualizarFechaCorte($cantidad, $tipo = 'mes') {
        $this->fecha_corte = date('Y-m-d', strtotime("+$cantidad $tipo"));
    }*/
    
    public function getEntityClass():string{
        return $this->entityClass;
    }
    
    
    
}