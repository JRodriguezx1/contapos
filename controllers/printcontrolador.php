<?php

namespace Controllers;
require __DIR__ . '/../classes/RECEIPT-main/ticket.php';

use Classes\Email;
use Model\ActiveRecord;
use Model\mediospago;
use Model\factmediospago;
use Model\clientes;
use Model\direcciones;
use Model\facturas;
use Model\negocio;
use Model\ventas;
use Model\tarifas;
use MVC\Router;  //namespace\clase
use ticketPOS;

class printcontrolador{
    
  public static function printPDFPOS():void{
    session_start();
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $negocio = negocio::get(1);
    $factura = facturas::find('id', $id);
    $cliente = clientes::find('id', $factura->idcliente);
    $direccion = direcciones::find('id', $factura->iddireccion);
    $productos = ventas::idregistros('idfactura', $factura->id);
    $print = new ticketPOS();
    $print->generar($factura, $cliente, $direccion, $productos, $negocio);
  }
}