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
        $entity->abonodecuotas = $entity->abonoinicial;
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
        $entity->abonodecuotas = $entity->abonoinicial;
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



    //estado financiero solo de separados
    public function estadosFinancierosCreditos(string $fechainicio, string $fechafin, int $idsucursal):array{

        $sql = "SELECT c.id, c.idestadocreditos as estado, c.num_orden, c.fechainicio, ps.costo_total, c.capital+c.valorinterestotal as capitalTotal,
                    c.capital - ps.costo_total AS utilidad_comercial,
                    c.capital - ps.costo_total + c.valorinterestotal AS utilidad_proyectada,
                    IFNULL(ct.pagado, 0)+ c.abonototalantiguo AS valor_pagado,
                    LEAST(
                        (c.capital - ps.costo_total + c.valorinterestotal),
                        GREATEST(0, IFNULL(ct.pagado,0)+ c.abonototalantiguo - ps.costo_total)
                    ) AS utilidad_realizada
                FROM $this->table c

                LEFT JOIN (
                    SELECT idcredito, SUM(costo * cantidad) AS costo_total
                    FROM productosseparados GROUP BY idcredito
                ) ps ON ps.idcredito = c.id

                LEFT JOIN (
                    SELECT id_credito, SUM(valorpagado) AS pagado
                    FROM cuotas GROUP BY id_credito
                ) ct ON ct.id_credito = c.id

                WHERE c.idtipofinanciacion = 2 AND c.idestadocreditos != 3 AND c.fechainicio >= '$fechainicio' AND c.fechainicio <= '$fechafin' AND c.id_fksucursal = $idsucursal;";
        $rows = $this->fetchAllStd($sql);
        return $rows;
    }


    public function estadosFinancierosCreditosTotalesFinalizados(string $fechainicio, string $fechafin, int $idsucursal):array{
        $sql = "SELECT COUNT(c.id) as creditos,
                    SUM(c.capital+c.valorinterestotal) as capitalTotal,
                    SUM(COALESCE(ps1.costo_total, ps2.costo_total, 0)) as costo_total,
                    SUM(c.capital - COALESCE(ps1.costo_total, ps2.costo_total, 0)) AS utilidad_comercial,
                    SUM(c.capital - COALESCE(ps1.costo_total, ps2.costo_total, 0) + c.valorinterestotal) AS utilidad_proyectada,
                    SUM(IFNULL(ct.pagado, 0) + c.abonototalantiguo) AS valor_pagado,
                    GREATEST(0, SUM(IFNULL(ct.pagado, 0) + c.abonototalantiguo) - SUM(COALESCE(ps1.costo_total, ps2.costo_total, 0)) ) AS utilidad_realizada
                FROM $this->table c

                LEFT JOIN (
                    SELECT idcredito, SUM(costo * cantidad) AS costo_total
                    FROM productosseparados GROUP BY idcredito
                ) ps1 ON ps1.idcredito = c.id

                -- ✅ créditos normales (1 fila por factura)
                LEFT JOIN (
                    SELECT dv.idfactura, SUM(dv.costo * dv.cantidad) AS costo_total
                    FROM ventas dv
                    GROUP BY dv.idfactura
                ) ps2 ON ps2.idfactura = c.factura_id

                LEFT JOIN (
                    SELECT id_credito, SUM(valorpagado) AS pagado
                    FROM cuotas GROUP BY id_credito
                ) ct ON ct.id_credito = c.id

                WHERE c.idestadocreditos != 3 AND c.fechainicio >= '$fechainicio' AND c.fechainicio <= '$fechafin' AND c.id_fksucursal = $idsucursal;";
        $rows = $this->fetchAllStd($sql);
        return $rows;
    }


    public function totalCuotasXcliente(int $idcliente, int $idsucursal):array{
        $sql = "SELECT cr.num_orden, cr.capital, cr.fechainicio, cr.fechafin, cr.interestotal, cr.idestadocreditos, cu.numerocuota, cu.valorpagado, cu.fechapagado FROM {$this->table} cr
                INNER JOIN cuotas cu ON cr.id = cu.id_credito
                WHERE cr.cliente_id = $idcliente AND cr.id_fksucursal = $idsucursal;";
        $rows = $this->fetchAllStd($sql);        
        return $rows;
    }
    
}