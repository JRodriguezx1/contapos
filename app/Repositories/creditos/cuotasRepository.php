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


    public function obtenerPorCredito_Mediopago(int $id):array{
        $sql = "SELECT c.*, JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', mp.id,
                        'idcuota', sm.idcuota,
                        'idmediopago', sm.mediopago_id,
                        'valor', sm.valor,
                        'mediopago', mp.mediopago,
                        'estado', mp.estado
                    )
                ) AS mediosdepago FROM cuotas c
                LEFT JOIN separadomediopago sm ON sm.idcuota = c.id
                LEFT JOIN mediospago mp ON mp.id = sm.mediopago_id
                WHERE c.id_credito = {$id} GROUP BY c.id;";
        $rows = $this->fetchAllStd($sql);

        foreach ($rows as &$row)
            $row->mediosdepago = $row->mediosdepago?json_decode($row->mediosdepago, false):[];
        //debuguear($rows);
        return $rows;
    }


    public function obtenerPorSeparado_cierracajaAbierto(int $id):array{
        $sql = "SELECT smp.id as idseparadomediopago, c.id_sucursal_idfk, c.id_credito, c.cierrecaja_id, c.valorpagado as cuotapagada, c.fechapagado, cc.estado as estadoCierreCaja, cc.ventasenefectivo as ventasEfectivo_caja,
                cc.abonosseparados as abonosSeparados_caja, cc.ingresoventas as ingresoventas_caja, cc.abonostotales as abonostotales_caja, cc.abonosenefectivo as abonosenefectivo_caja,
                COALESCE(SUM(CASE WHEN smp.mediopago_id = 1 THEN smp.valor ELSE 0 END), 0) AS valorcuota_efectivo
                FROM cuotas c JOIN cierrescajas cc ON c.cierrecaja_id = cc.id
                LEFT JOIN separadomediopago smp ON smp.idcuota = c.id
                WHERE c.id_credito = {$id} AND cc.estado = 0 
                GROUP BY smp.id, c.id_sucursal_idfk, c.id_credito, c.cierrecaja_id, c.valorpagado, c.fechapagado, cc.estado, cc.ventasenefectivo, cc.abonosseparados, cc.ingresoventas;";
        $rows = $this->fetchAllStd($sql);

        //foreach ($rows as &$row)
          //  $row->mediosdepago = $row->mediosdepago?json_decode($row->mediosdepago, false):[];
        //debuguear($rows);
        return $rows;
    }


    public function obtenerPorCredito_cierracajaAbierto(int $id):array{
        $sql = "SELECT c.id_sucursal_idfk, c.id_credito, c.cierrecaja_id, c.valorpagado as cuotapagada, c.fechapagado, cc.estado as estadoCierreCaja, 
                cc.abonoscreditos as abonosCreditos_caja, cc.abonostotales as abonostotales_caja, cc.abonosenefectivo as abonosenefectivo_caja,
                COALESCE(SUM(CASE WHEN fmp.idmediopago = 1 THEN fmp.valor ELSE 0 END), 0) AS valorcuota_efectivo
                FROM cuotas c JOIN creditos cr ON c.id_credito = cr.id
                JOIN cierrescajas cc ON c.cierrecaja_id = cc.id
                LEFT JOIN factmediospago fmp ON fmp.id_factura = cr.factura_id
                WHERE c.id_credito = $id AND fmp.cierrecajaid = c.cierrecaja_id AND cc.estado = 0
                GROUP BY c.id_sucursal_idfk, c.id_credito, c.cierrecaja_id, c.valorpagado, c.fechapagado, cc.estado, cc.ventasenefectivo, cc.abonosseparados, cc.ingresoventas;";
        $rows = $this->fetchAllStd($sql);

        //foreach ($rows as &$row)
          //  $row->mediosdepago = $row->mediosdepago?json_decode($row->mediosdepago, false):[];
        //debuguear($rows);
        return $rows;
    }
    
}