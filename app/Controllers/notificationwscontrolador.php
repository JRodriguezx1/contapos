<?php

namespace App\Controllers;


use App\Models\felectronicas\facturas_electronicas;
use App\Models\sucursales;

use App\services\facturaElectronicaService;
use GreenApi\RestApi\GreenApiClient;
use MVC\Router;  //namespace\clase
use stdClass;

class notificationwscontrolador{
    

  public static function editarResolutionFE():void{
    isadmin();
    //new GreenApiClient()
    //header('Content-Type: application/json');
    $alertas = [];
    $getDB = facturas_electronicas::getDB();

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'JSON inválido']);
        exit;
    }
    $getDB->begin_transaction();
    try {
      $alertas['prefijoNum'] = facturaElectronicaService::actualizarResolutionFE($data);
      $getDB->commit();
      $alertas['exito'][] = 'Cambio de datos de resolucion de factura electronica.';
    } catch (\Throwable $th) {
      $getDB->rollback();
      $alertas['error'][] = "Error al actualizar los datos de la resolucion de la factura electronica. ".$th->getMessage();
    }
    echo json_encode($alertas);
    return;
  }
}