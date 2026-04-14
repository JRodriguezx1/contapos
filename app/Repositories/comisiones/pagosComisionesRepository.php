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


    public function historialPagosXUser(int $idusuario, string $fechainicio, string $fechafin):array{
        $sql = "SELECT *FROM $this->table WHERE fkusuarioid = $idusuario AND fecha BETWEEN '$fechainicio' AND '$fechafin';";
        $rows = $this->fetchAllStd($sql);

        $totalPagado = 0;
        foreach ($rows as $obj)$totalPagado += $obj->valor;

        return ['pagos'=>$rows, 'totalPagado'=>$totalPagado];
    }


    public function totalPagadoAllUsers(int $idsucursal):array{
        $sql = "SELECT 
                    COALESCE(SUM(pc.valor), 0) as comisiontotalpagada
                FROM $this->table pc WHERE pc.fksucursalid = $idsucursal;";
        $rows = $this->fetchAllStd($sql);
        return $rows;
    }
    
    
}