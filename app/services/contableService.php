<?php 

namespace App\services;


use App\Models\configuraciones\usuarios;
use App\Models\contable\movimientos_caja;
use App\Models\sucursales;
use App\Repositories\contable\movimientos_cajaRepository;
use stdClass;


class contableService{

    private $repoMovimientocaja;
    
    public function __construct()
    {
        $this->repoMovimientocaja = new movimientos_cajaRepository();
    }


    public function createMovimiento(array $data):array{
        $data['num_orden'] = $this->repoMovimientocaja->getNumOrden(id_sucursal());
        return $this->repoMovimientocaja->insert(new movimientos_caja($data));
    }


    /*public function createUpdateTarifa(array $data):array{
        return $this->repoMovimientocaja->upsert(new movimientos_caja($data));
    }


    public function allTarifas():array{
        return $this->repoMovimientocaja->allActive();
    }*/
    

    
}