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
        $entity->num_orden = $this->calcularNumOrden($entity->id_fksucursal);
        $array = $this->insert($entity);
        return $array;
    }
    

    //metodo llamado desde el ventascontrolador.php y a su vez servicio creditosService y su metodo: crearCredito
    public function generarCredito(array $array, int $idfactura, int $idcliente, $totalunidades, $base, $valorimpuestototal, int $dctox100, $descuento, int $idvendedor):creditos{
        $entity = new $this->entityClass($array);
        $entity->usuariofk = $idvendedor;
        $entity->idtipofinanciacion = 1;
        $entity->factura_id = $idfactura;
        $entity->cliente_id = $idcliente;
        $entity->idestadocreditos = 2;  //credito abierto
        $entity->num_orden = $this->calcularNumOrden($entity->id_fksucursal);
        $entity->frecuenciapago = date('j');
        $entity->saldopendiente = $entity->montototal;
        $entity->productoentregado = 1;
        $entity->totalunidades = $totalunidades;
        $entity->base = $base;
        $entity->valorimpuestototal = $valorimpuestototal;
        $entity->dctox100 = $dctox100;
        $entity->descuento = $descuento;
        //$array = $this->insert($entity);
        return $entity;
    }

    public function calcularNumOrden(int $idsucursal): int {
        $sql = "SELECT COALESCE(MAX(num_orden), 0)+1 AS next_num FROM creditos WHERE id_fksucursal = $idsucursal;";
        $resultado = self::$db->query($sql);
        $r = $resultado->fetch_assoc();
        $resultado->free();
        return array_shift($r);
    }


    public function anularCredito(int $id){
        $sql = "UPDATE {$this->table} SET idestadocreditos = 3 WHERE id = {$id} LIMIT 1";
        $resultado = self::$db->query($sql);
        return $resultado;
    }
    
}