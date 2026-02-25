<?php

namespace App\Repositories\creditos;

use App\Models\contracts\mediosPagoContract;
use App\Models\creditos\separadomediopago;
use App\Repositories\operationRepository;

class separadoMediopagoRepository extends operationRepository implements mediosPagoContract{

    //private $db;
    protected string $table = 'separadomediopago';
    protected string $entityClass = separadomediopago::class;
    protected array $allowedColumns = [];
    protected string $pagoDestino = 'idcuota';

    public function __construct(/*$conexion*/)
    {
        //$this->db = $conexion;
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
        
    }


    public function allMediospagoXCierrecaja(int $id):array{
        $sql = "SELECT m.id as idmediopago, m.mediopago, smp.valor FROM separadomediopago smp
                JOIN cuotas c ON smp.idcuota = c.id
                JOIN mediospago m ON smp.mediopago_id = m.id
                WHERE c.cierrecaja_id = $id;";
        $rows = $this->fetchAll($sql);
        return $rows;
    }

    public function getPagoDestino():string{
        return $this->pagoDestino;
    }

    public function getEntityClass():string{
        return $this->entityClass;
    }
    
}