<?php 

namespace App\services;

use App\Models\comisiones\comisiones;
use App\Models\comisiones\pagos_comisiones;
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


    public function crearComision(int $idfacturaid, int $idusuariofk, float $valorfactura, float $percentcomision, float $valorcomision):void{
        $this->repoComisiones->insert(new comisiones(['idfacturaid'=>$idfacturaid, 'idusuariofk'=>$idusuariofk, 'valorfactura'=>$valorfactura, 'percentcomision'=>$percentcomision, 'valorcomision'=>$valorcomision]));
    }



    public function getWidgets(int $idsucursal):array{
        $comisiontotalgenerada = $this->repoComisiones->comisionTotalGeneradaBusiness($idsucursal)[0];
        $comisiontotalpagada = $this->repoPagosComisiones->totalPagadoAllUsers($idsucursal)[0];
        return ['0'=>$comisiontotalgenerada, '1'=>$comisiontotalpagada];
    }


    public function comisionesXUser(int $idsucursal, int $idusuario, string $fechainicio, string $fechafin):array{
       $comisionTotaluser = $this->repoComisiones->comisionTotalGeneradaUser($idsucursal, $idusuario, $fechainicio, $fechafin)[0];
       $historialPagosXuser = $this->repoPagosComisiones->historialPagosXUser($idusuario, $fechainicio, $fechafin);
       return ['comisionTotaluser'=>$comisionTotaluser, 'historialPagos'=>$historialPagosXuser];
    }
    

    public function liquidarComision(array $data):array{
        $alertas = [];
        $getDB = $this->repoPagosComisiones->getConexion();
        $liquidar = new pagos_comisiones($data);
        $alertas = $liquidar->validar();
        if(!empty($alertas)){
            return $alertas;
        }

        $getDB->begin_transaction();
        try {
            $r = $this->repoPagosComisiones->insert($liquidar);
            $getDB->commit();
            return $r;
        } catch (\Throwable $th) {
            $getDB->rollback();
            throw $th;
        }
    }


    public function eliminarMovimientoComision(int $id):array{
        $entityPago = $this->repoPagosComisiones->find($id);
        if(!$entityPago)return ['error'=>['Pago de comision ya no existe']];
         $r = $this->repoPagosComisiones->delete($id);
        if($r){
            return ['exito'=>['pago de comision eliminada'], 'valor'=>$entityPago->valor];
        }else{
            return ['error'=>['error al eliminar pago de comision']];
        }
    }

    
}