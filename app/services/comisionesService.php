<?php 

namespace App\services;

use App\Models\comisiones\comisiones;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\usuarios;
use App\Models\sucursales;
use App\Repositories\comisiones\comisionesRepository;
use App\Repositories\comisiones\pagosComisionesRepository;
use stdClass;

class comisionesService{

    private $repoComisiones;
    private $repoPagosComisiones;
    
    public function __construct()
    {
        $this->repoComisiones = new comisionesRepository();
        $this->repoPagosComisiones = new pagosComisionesRepository();
    }


    public function crearComision(int $idfacturaid, int $idusuariofk, float $percentcomision, float $valorcomision):void{
        $this->repoComisiones->insert(new comisiones(['idfacturaid'=>$idfacturaid, 'idusuariofk'=>$idusuariofk, 'percentcomision'=>$percentcomision, 'valorcomision'=>$valorcomision]));
    
    }



    public function getWidgets(int $idsucursal):stdClass{
       return $this->repoComisiones->getWidgets($idsucursal)[0];
    }


    public function comisionesXUser(int $idsucursal, int $idusuario, string $fechainicio, string $fechafin):array{
       $widgetsUser = $this->repoComisiones->comisionTotalUser($idsucursal, $idusuario)[0];
       $historialPagosXuser = $this->repoPagosComisiones->historialPagosXUser($idusuario, $fechainicio, $fechafin);
       return ['0'=>$widgetsUser, '1'=>$historialPagosXuser];
    }
    

    
}