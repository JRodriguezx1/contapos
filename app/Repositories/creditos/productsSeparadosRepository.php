<?php

namespace App\Repositories\creditos;

use App\Models\creditos\productosseparados;
use App\Repositories\operationRepository;

class productsSeparadosRepository extends operationRepository{

    //private $db;
    protected string $table = 'productosseparados';
    protected string $entityClass = productosseparados::class;
    protected array $allowedColumns = [];

    public function __construct(/*$conexion*/)
    {
        //$this->db = $conexion;
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
    }

    
    /*public function obtenerPorCredito(int $id):array{

        $sql = "SELECT *FROM productosseparados WHERE idcredito = $id;";
        $resultado = $this->db->query($sql);
        while($row = $resultado->fetch_assoc()){ 
            $array[] = new productosseparados($row);   
        }
        $resultado->free();
        return $array;

    }*/

    public function obtenerPorCredito(int $id):array{
        $sql = "SELECT *FROM productosseparados WHERE idcredito = $id;";
        $rows = $this->fetchAll($sql);
        $array = array_map(fn($v) => new productosseparados($v), $rows);
        return $array;
    }

    /*public function crear_guardar():array{

        return [];
    }*/

    /*public function allowedColumns():void{
        $model = new $this->entityClass();
        $this->allowedColumns = array_keys($model->toArray());
    }*/
    
}