<?php

namespace App\Repositories\creditos;

use App\Models\creditos\cuotas;
use App\Repositories\operationRepository;

class cuotasRepository extends operationRepository{

    //private $db;
    protected string $table = 'cuotas';
    protected string $entityClass = cuotas::class;
    protected array $allowedColumns = [];

    public function __construct(/*$conexion*/)
    {
        //$this->db = $conexion;
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
        
    }


    public function obtenerPorCredito(int $id):array{
        $sql = "SELECT *FROM cuotas WHERE id_credito = $id;";
        $rows = $this->fetchAll($sql);
        $array = array_map(fn($v) => new cuotas($v), $rows);
        return $array;
    }
    
}