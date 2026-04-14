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


    public function getWidgets(int $idsucursal):array{
        $sql = "SELECT 
                    COALESCE(SUM(c.valorcomision), 0) as comisiontotal, 
                    COALESCE(SUM(c.valorentregado), 0) as comisionentregada,
                    COALESCE(SUM(c.valorcomision)-SUM(c.valorentregado), 0) as comisionpendiente
                FROM $this->table c WHERE c.fk_idsucursal = $idsucursal;";
        $rows = $this->fetchAllStd($sql);
        return $rows;
    }

    public function comisionTotalUser(int $idsucursal, int $idusuario):array{
        $sql = "SELECT 
                    COALESCE(SUM(c.valorcomision), 0) as comisiontotal, 
                    COALESCE(SUM(c.valorentregado), 0) as totalpagado,
                    COALESCE(SUM(c.valorcomision)-SUM(c.valorentregado), 0) as saldoporliquidar
                FROM $this->table c WHERE c.fk_idsucursal = $idsucursal AND c.idusuariofk = $idusuario;";
        $rows = $this->fetchAllStd($sql);
        return $rows;
    }
    
}