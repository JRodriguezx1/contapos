<?php

namespace App\Controllers;

use App\Models\configuraciones\notificacionesWS;
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
    //obtener numero de DB
    $contactWS = notificacionesWS::find('id', $id);
    if(!$contactWS){
      echo json_encode(null);
      return;
    }
    $ws = new whatsAppService();
    $msg = "*Test de notificacion*\n";
    $msg .= "Este es un mensaje de prueba de notificaciones por whatsapp enviado desde:";
    $msg .= "\n*J2 SOFTWARE POS*\n";
    $msg .= "www.j2softwarepos.com\n";
    $r = $ws->sendMessage($contactWS->movil, $msg);
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
    $number = notificacionesWS::find('sucursal_idfk', id_sucursal());
    if(!$number){
      echo json_encode(NULL);
      return;
    }
    $alertas = [];
    $data = cajaService::printdetallecierre($id);
    $sucursal = sucursales::find('id', id_sucursal());

    $msg = "";
    // 🔹 Encabezado
    $estado = $data['ultimocierre']->estado == 1 ? 'CIERRE DE CAJA' : 'CIERRE PARCIAL';
    $msg .= "🔹*$estado*\n\n";
    $msg .= "Sucursal: " . (($sucursal ?? null)->nombre ?? '') . "\n";
    $msg .= "Caja: {$data['ultimocierre']->nombrecaja}\n";
    $msg .= "Cajero: {$data['ultimocierre']->nombreusuario}\n";
    $msg .= "Inicio: {$data['ultimocierre']->fechainicio}\n";
    $msg .= "*Fin: {$data['ultimocierre']->fechacierre}*\n\n";
    // 🔹 Cuadre de caja
    $base = $data['ultimocierre']->basecaja ?? 0;
    $ventas = $data['ultimocierre']->ventasenefectivo ?? 0;
    $abonos = $data['ultimocierre']->abonosenefectivo ?? 0;
    $gastos = $data['ultimocierre']->gastoscaja ?? 0;
    $domicilios = $data['ultimocierre']->domicilios ?? 0;
    $dineroCaja = $base + $ventas + $abonos - $gastos;
    $realCaja = $dineroCaja - $domicilios;

    $msg .= "*CUADRE DE CAJA*\n";
    $msg .= "Efectivo Inicial: + $" . number_format($base, 0, ',', '.') . "\n";
    $msg .= "Ventas en Efectivo: + $" . number_format($ventas, 0, ',', '.') . "\n";
    $msg .= "Abonos: + $" . number_format($abonos, 0, ',', '.') . "\n";
    $msg .= "Gastos: - $" . number_format($gastos, 0, ',', '.') . "\n";
    $msg .= "*Dinero en caja: $" . number_format($dineroCaja, 0, ',', '.') . "*\n";
    $msg .= "Domicilios: - $" . number_format($domicilios, 0, ',', '.') . "\n";
    $msg .= "*Real en caja: $" . number_format($realCaja, 0, ',', '.') . "*\n\n";
    // 🔹 Medios de pago
    $msg .= "💳 *MEDIOS DE PAGO*\n";
    foreach ($data['discriminarmediospagos'] as $value) {
        $msg .= "{$value['mediopago']}: $" . number_format($value['valor'], 0, ',', '.') . "\n";
    }
    // 🔹 Datos de venta
    $msg .= "\n*DATOS DE VENTA*\n";
    $msg .= "💰Ingreso Total de ventas: + *$" . number_format($data['ultimocierre']->ingresoventas ?? 0, 0, ',', '.') . "*\n";
    $msg .= "Abonos totales: + $" . number_format($data['ultimocierre']->abonostotales??0, 0, ',', '.') . "\n";
    $msg .= "Total gastos de caja: - $" . number_format($data['ultimocierre']->gastoscaja??0, 0, ',', '.') . "\n";
    $msg .= "Gastos otros/bancarios: - $" . number_format($data['ultimocierre']->gastosbanco??0, 0, ',', '.') . "\n";
    $msg .= "Total Descuentos: - $" . number_format($data['ultimocierre']->totaldescuentos??0, 0, ',', '.') . "\n";
    $msg .= "Total Domicilios: - $" . number_format($data['ultimocierre']->domicilios??0, 0, ',', '.') . "\n";
    $msg .= "📌*Ganancia hoy: = $" . number_format(($data['ultimocierre']->ingresoventas??0)+($data['ultimocierre']->abonostotales??0)-($data['ultimocierre']->totaldescuentos??0)-($data['ultimocierre']->domicilios??0)-($data['ultimocierre']->gastoscaja??0)-($data['ultimocierre']->gastosbanco??0), 0, ',', '.') . "*\n";
    $msg .= "Base grabable: = $" . number_format($data['ultimocierre']->basegravable??0, 0, ',', '.') . "\n";
    $msg .= "Impuesto Total: - $" . number_format($data['ultimocierre']->valorimpuestototal??0, 0, ',', '.') . "\n\n";
    /*// 🔹 Detalle impuesto
    $msg .= "*DETALLE IMPUESTO*\n";
    // 🔹 Tipo de facturas
    $msg .= "*TIPO DE FACTURAS*\n";*/
    // 🔹 Sobrante y faltante
    $msg .= "📊*SOBRANTE Y FALTANTE*\n";
    foreach ($data['sobrantefaltante'] as $value) {
        $msg .= "Medio de pago: *{$value->nombremediopago}*" . "\n";
        $msg .= "Sisitema: $" . number_format($value->valorsistema, 0, ',', '.') . " - Declarado: $" . number_format($value->valordeclarado??0, 0, ',', '.') . " => " . number_format($value->valordeclarado-$value->valorsistema, 0, ',', '.') . "\n";
    }
    /*// 🔹 Ventas por usuario
    $msg .= "*VENTAS POR USUARIO*\n";*/

    // 🔹 Pie de pagina
    $msg .= "\n*J2 SOFTWARE POS*\n";
    $msg .= "www.j2softwarepos.com\n";

    $ws = new whatsAppService();
    $r = $ws->sendMessage($number->movil, $msg);
    echo json_encode($r);
    return;
  }
}