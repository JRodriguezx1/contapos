<?php

namespace App\Controllers;


use App\Models\felectronicas\facturas_electronicas;
use App\Models\sucursales;
use App\services\cajaService;
use App\services\facturaElectronicaService;
use App\services\whatsAppService;
use MVC\Router;  //namespace\clase
use stdClass;

class whatsAppControlador{
  

  public static function sendtextDetalleCierreCaja():void{
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //new GreenApiClient()
    //header('Content-Type: application/json');
    $alertas = [];
    $data = cajaService::printdetallecierre($id);
    $sucursal = sucursales::find('id', id_sucursal());
    $lineasencabezado = explode("\n", $sucursal->datosencabezados??'');

    //PLANTILLA CIERRE DE CAJA
    /*$mensaje = "*CIERRE DE CAJA*\n";
    $mensaje .= "Caja: *{$data['ultimocierre']->nombrecaja}*\n";
    $mensaje .= "Usuario: {$data['ultimocierre']->nombreusuario}\n";
    $mensaje .= "Total: *$" . number_format($data['ultimocierre']->ingresoventas, 0, ',', '.') . "*\n";*/

    $msg = "";

    // 🔹 Encabezado
    $estado = $data['ultimocierre']->estado == 1 ? 'CIERRE CONFIRMADO' : 'CIERRE PARCIAL';

    $msg .= "*$estado*\n\n";
    $msg .= "Caja: {$data['ultimocierre']->nombrecaja}\n";
    $msg .= "Sucursal: " . (($sucursal ?? null)->nombre ?? '') . "\n";
    $msg .= "NIT: " . (($sucursal ?? null)->nit ?? '') . "\n";

    foreach ($lineasencabezado as $linea) {
        $msg .= "$linea\n";
    }

    $msg .= "\n";

    // 🔹 Información general
    $msg .= "*INFORMACIÓN GENERAL*\n";
    $msg .= "Caja: {$data['ultimocierre']->nombrecaja}\n";
    $msg .= "ID Cierre: {$data['ultimocierre']->id}\n";
    $msg .= "Usuario: {$data['ultimocierre']->nombreusuario}\n";
    $msg .= "Inicio: {$data['ultimocierre']->fechainicio}\n";
    $msg .= "Fin: {$data['ultimocierre']->fechacierre}\n";
    $msg .= "Reporte: " . date('d M Y H:i:s') . "\n\n";

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
    $msg .= "*DINERO EN CAJA: $" . number_format($dineroCaja, 0, ',', '.') . "*\n";
    $msg .= "Domicilios: - $" . number_format($domicilios, 0, ',', '.') . "\n";
    $msg .= "*REAL EN CAJA: $" . number_format($realCaja, 0, ',', '.') . "*\n\n";

    // 🔹 Medios de pago
    $msg .= "*MEDIOS DE PAGO*\n";

    foreach ($data['discriminarmediospagos'] as $value) {
        $msg .= "{$value['mediopago']}: $" . number_format($value['valor'], 0, ',', '.') . "\n";
    }

    // 🔹 Datos de venta
    $msg .= "*DATOS DE VENTA*\n";

    // 🔹 Detalle impuesto
    $msg .= "*DETALLE IMPUESTO*\n";

    // 🔹 Tipo de facturas
    $msg .= "*TIPO DE FACTURAS*\n";

    // 🔹 Sobrante y faltante
    $msg .= "*SOBRANTE Y FALTANTE*\n";

    // 🔹 Ventas por usuario
    $msg .= "*VENTAS POR USUARIO*\n";

    // 🔹 Pie de pagina
    $msg .= "*PIE DE PAGINA*\n";
    $msg .= "\n";




    $ws = new whatsAppService();
    $ws->sendMessage('', $msg);
    debuguear($ws);
  }
}