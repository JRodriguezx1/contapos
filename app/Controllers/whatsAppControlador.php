<?php

namespace App\Controllers;

use App\Models\configuraciones\notificacionesws;
use App\Models\felectronicas\facturas_electronicas;
use App\Models\sucursales;
use App\services\cajaService;
use App\services\facturaElectronicaService;
use App\services\whatsAppService;
use MVC\Router;  //namespace\clase
use stdClass;

class whatsAppControlador{
  
  public static function crearContacto():void{
    isadmin();
    $alertas = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $ws = new whatsAppService();
      try {
        $r = $ws->crearContactoWS($_POST);
        if(isset($r['error'])){
          echo json_encode($r);
          return;
        }
        $alertas['exito'][] = "Contacto creado con exito";
        $alertas['data'] = $r;
      } catch (\Throwable $th) {
        $alertas['error'][] = "Error al crear contacto {$th->getMessage()}";
      }
    }
    echo json_encode($alertas);
    return;
  }


  public static function sendTest():void{
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $ws = new whatsAppService();
    $msg = "*Test de notificacion*\n";
    $msg .= "Este es un mensaje de prueba de notificaciones por whatsapp enviado desde:";
    $msg .= "\n*J2 SOFTWARE POS*\n";
    $msg .= "www.j2softwarepos.com\n";
    $r = $ws->sendMessage($msg);
    echo json_encode($r);
    return;
  }

  
  public static function eliminarContacto():void{
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $ws = new whatsAppService();
    try {
      $r = $ws->eliminarContacto($id);
      if($r)$alertas['exito'][] = "Contacto de notificaciones eliminado correctamente";
    } catch (\Throwable $th) {
      $alertas['error'][] = "Error al eliminar contacto de notificaciones >>{$th->getMessage()}";
    }
    echo json_encode($alertas);
    return;
    
  }


  public static function sendtextDetalleCierreCaja():void{
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //header('Content-Type: application/json');
    $ws = new whatsAppService();
    $r = $ws->sendtextDetalleCierreCaja($id);
    echo json_encode($r);
    return;
  }
}