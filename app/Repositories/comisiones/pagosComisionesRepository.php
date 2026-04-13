<?php

namespace App\Repositories\comisiones;

use App\Models\comisiones\pagos_comisiones;
use App\Repositories\operationRepository;

class pagosComisionesRepository extends operationRepository{

    //private $db;
    protected string $table = 'pagos_comisiones';
    protected string $entityClass = pagos_comisiones::class;
    protected array $allowedColumns = [];

    public function __construct(/*$conexion*/)
    {
        //$this->db = $conexion;
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
        
    }

    
    public function getConexion(){ return self::getDB(); }

    
    
}