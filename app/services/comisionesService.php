<?php 

namespace App\services;

use App\Models\comisiones\comisiones;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\usuarios;
use App\Models\sucursales;
use App\Repositories\comisiones\comisionesRepository;
use stdClass;

class comisionesService{

    private $repoComisiones;
    
    public function __construct()
    {
        $this->repoComisiones = new comisionesRepository();

    }


    public function crearComision(int $idfacturaid, int $idusuariofk, float $percentcomision, float $valorcomision):void{
        $this->repoComisiones->insert(new comisiones(['idfacturaid'=>$idfacturaid, 'idusuariofk'=>$idusuariofk, 'percentcomision'=>$percentcomision, 'valorcomision'=>$valorcomision]));
    
    }



    public function getWidgets(int $idsucursal):stdClass{
       return $this->repoComisiones->getWidgets($idsucursal)[0];
    }
    

    
}