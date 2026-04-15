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



    public function getWidgets(int $idsucursal):array{
        $comisiontotalgenerada = $this->repoComisiones->comisionTotalGeneradaBusiness($idsucursal)[0];
        $comisiontotalpagada = $this->repoPagosComisiones->totalPagadoAllUsers($idsucursal)[0];
        return ['0'=>$comisiontotalgenerada, '1'=>$comisiontotalpagada];
    }


    public function comisionesXUser(int $idsucursal, int $idusuario, string $fechainicio, string $fechafin):array{
       $comisionTotaluser = $this->repoComisiones->comisionTotalGeneradaUser($idsucursal, $idusuario)[0];
       $historialPagosXuser = $this->repoPagosComisiones->historialPagosXUser($idusuario, $fechainicio, $fechafin);
       return ['comisionTotaluser'=>$comisionTotaluser, 'historialPagos'=>$historialPagosXuser];
    }
    

    public function liquidarComision(array $data):void{
        $this->repoComisiones->insert(new comisiones());
    
    }


    public function eliminarMovimientoComision(int $id):void{
        $this->repoComisiones->insert(new comisiones());
    
    }

    
}