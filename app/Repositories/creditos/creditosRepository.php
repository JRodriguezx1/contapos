<?php

namespace App\Repositories\creditos;

use App\Models\creditos\creditos;
use App\Repositories\operationRepository;

class creditosRepository extends operationRepository{

    //private $db;
    protected string $table = 'creditos';
    protected string $entityClass = creditos::class;
    protected array $allowedColumns = [];

    public function __construct(/*$conexion*/)
    {
        //$this->db = $conexion;
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
        
    }

    
    public function getConexion(){ return self::getDB(); }


    public function generarSeparado(object $entity):array{
        if(!isset($entity->frecuenciapago))$entity->frecuenciapago = date('j');
        $entity->saldopendiente = $entity->montototal;
        $array = $this->insert($entity);
        return $array;
    }
    

    public function generarCredito(array $array, int $idfactura, int $idcliente):creditos{
        $entity = new $this->entityClass($array);
        $entity->idtipofinanciacion = 1;
        $entity->factura_id = $idfactura;
        $entity->cliente_id = $idcliente;
        $entity->frecuenciapago = date('j');
        $entity->saldopendiente = $entity->montototal;
        $entity->productoentregado = 1;
        //$array = $this->insert($entity);
        return $entity;
    }
    
}