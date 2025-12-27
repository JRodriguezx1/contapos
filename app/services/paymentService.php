<?php 

namespace App\services;

use App\Models\caja\factmediospago;
use App\Models\creditos\separadomediopago;

class paymentService {

    private string $modelomediopago;

    public function __construct(string $modelomediopago)
    {
        $this->modelomediopago = $modelomediopago;
    }

    

    public function registrarPagos(array $mediospago){

        

        $registro = new $this->modelomediopago();
        $registro->crear_varios_reg_arrayobj($mediospago);
        
        //debuguear($registro);
        
    }
}