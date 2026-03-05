<?php
//$dias = facturacion::inner_join('SELECT COUNT(id) AS servicios, fecha_pago, SUM(total) AS totaldia FROM facturacion GROUP BY fecha_pago ORDER BY COUNT(id) DESC;');
namespace App\Controllers;

use App\Models\sucursales;
use App\Models\suscripcioncuenta\suscripcion_pagos;
use App\Repositories\suscripcioncuenta\suscripcionPagosRepository;
use MVC\Router;  //namespace\clase
 
class suscripcioncontrolador{

    public static function registrarPago(){
        //session_start();
        isadmin();
        $alertas = [];
        $suscripcionRepo = new suscripcionPagosRepository(); 

        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405); // Método no permitido
            echo json_encode(['error' => 'Método no permitido']);
            exit;
        }
        $pago = json_decode(file_get_contents('php://input'), true);
        $entity = new suscripcion_pagos($pago);
        $alertas = $entity->validar();
        if(empty($alertas)){
            $r = $suscripcionRepo->insert($entity);
            if($r[0]){
                $alertas['exito'][] = "Pago registrado con exito";
            }else{
                $alertas['error'][] = "Error, intente nuevamente.";
            }
        }
        echo json_encode($alertas);
        return;
    }
  
}