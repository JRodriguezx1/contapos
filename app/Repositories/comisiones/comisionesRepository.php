<?php

namespace App\Repositories\comisiones;

use App\Models\comisiones\comisiones;
use App\Repositories\operationRepository;

class comisionesRepository extends operationRepository{

    //private $db;
    protected string $table = 'comisiones';
    protected string $entityClass = comisiones::class;
    protected array $allowedColumns = [];

    public function __construct(/*$conexion*/)
    {
        //$this->db = $conexion;
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
        
    }

    
    public function getConexion(){ return self::getDB(); }


    public function getWidgets($idsucursal):array{
        $sql = "SELECT 
                    COALESCE(SUM(c.valorcomision), 0) as comisiontotal, 
                    COALESCE(SUM(c.valorentregado), 0) as comisionentregada,
                    COALESCE(SUM(c.valorcomision)-SUM(c.valorentregado), 0) as comisionpendiente
                FROM comisiones c WHERE c.fk_idsucursal = $idsucursal;";
        $rows = $this->fetchAllStd($sql);
        return $rows;
    }

    
    
}