<?php

namespace App\Controllers;
require __DIR__ . '/../classes/RECEIPT-main/ticket.php';

use App\classes\Email;
use App\Models\ActiveRecord;
use App\Models\configuraciones\mediospago;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\configuraciones\consecutivos;
use App\Models\ventas\facturas;
use App\Models\configuraciones\negocio;
use App\Models\ventas\ventas;
use App\Models\configuraciones\tarifas;
use App\Models\felectronicas\facturas_electronicas;
use App\Models\sucursales;
use MVC\Router;  //namespace\clase
use ticketPOS;

class printcontrolador{
    
  public static function printPDFPOS():void{
    //session_start();
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $sucursal = sucursales::find('id', id_sucursal());
    $factura = facturas::find('id', $id);
    $facturaElectronica = facturas_electronicas::find('id_facturaid', $factura->id);
    if($facturaElectronica)$facturaElectronica->consecutivo = consecutivos::find('id', $facturaElectronica->consecutivo_id);
    //debuguear($facturaElectronica);
    $cliente = clientes::find('id', $factura->idcliente);
    $direccion = direcciones::find('id', $factura->iddireccion);
    if(!$direccion)$direccion = direcciones::find('id', 1);
    $productos = ventas::idregistros('idfactura', $factura->id);
    $print = new ticketPOS();
    $print->generar($sucursal, $factura, $facturaElectronica, $cliente, $direccion, $productos);
  }
}