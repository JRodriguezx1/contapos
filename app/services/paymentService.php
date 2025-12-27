<?php 

namespace App\services;

use App\Models\caja\factmediospago;
use App\Models\creditos\separadomediopago;

class paymentService {

    private string $modelomediopago;

    public function __construct(string $modelomediopago){
        $this->modelomediopago = $modelomediopago;
    }
    

    public function registrarPagos(array $mediospago, int $id){
        $modelo = $this->modelomediopago;
        $instance = [];
        foreach($mediospago as $objStd){
            /*if($obj->mediopago_id == 1){
            $ultimocierre->ventasenefectivo =  $ultimocierre->ventasenefectivo + $obj->valor;
            }*/
            $objStd = new $modelo((array)$objStd);
            $objStd->pagoDestino($id);
            $instance[] = $objStd;
        }

        $registro = new $modelo();
        $registro->crear_varios_reg_arrayobj($instance);
        
    }
}