<?php

namespace App\Controllers;
require __DIR__ . '/../classes/RECEIPT-main/ticket.php';

use App\classes\Email;
use App\Models\ActiveRecord;
use App\Models\configuraciones\mediospago;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\compras;
use App\Models\configuraciones\consecutivos;
use App\Models\ventas\facturas;
use App\Models\configuraciones\negocio;
use App\Models\ventas\ventas;
use App\Models\configuraciones\tarifas;
use App\Models\configuraciones\usuarios;
use App\Models\creditos\cuotas;
use App\Models\detallecompra;
use App\Models\felectronicas\facturas_electronicas;
use App\Models\inventario\proveedores;
use App\Models\sucursales;
use App\Repositories\comisiones\pagosComisionesRepository;
use App\Repositories\creditos\creditosRepository;
use App\Repositories\creditos\cuotasRepository;
use App\Repositories\creditos\productsSeparadosRepository;
use App\services\cajaService;
use App\services\creditosService;
use MVC\Router;  //namespace\clase
use ticketPOS;

class printcontrolador{
    
  public static function printPDFPOS():void{
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $datos = cajaService::detalleVenta($id);
    $facturaElectronica = facturas_electronicas::find('id_facturaid', $datos['factura']->id);
    if($facturaElectronica)$facturaElectronica->consecutivo = consecutivos::find('id', $facturaElectronica->consecutivo_id);
    $datos['factura']->mediosdepago = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = ".$datos['factura']->id.";");
    $print = new ticketPOS();
    $print->generar($datos['sucursal'], $datos['factura'], $facturaElectronica, $datos['cliente'], $datos['direccion'], $datos['productos'], $datos['emisor']);
  }


  ////////////  print del credito/separado  ///////////////
  public static function printPDFPOSSeparado():void{
    //session_start();
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $sucursal = sucursales::find('id', id_sucursal());
    $datos = creditosService::detallecredito($id);
    [
      'credito'=>$credito,
      'cuotas'=>$cuotas,
      'productos'=>$productos,
      'cliente'=>$cliente,
      'direccion'=>$direccion,
      'usuario'=>$usuario,
      'factura'=>$factura
    ] = $datos;

    $print = new ticketPOS();
    $print->generarCredito($sucursal, $credito, $usuario, $cliente, $direccion, $productos, $cuotas);
  }


  //////////////  print del abono ////////////////////
  public static function printPDFAbonoCredito():void{
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $sucursal = sucursales::find('id', id_sucursal());
    $repoCuota = new cuotasRepository();
    $cuota = $repoCuota->find($id);
    $repoCredito = new creditosRepository();
    $credito = $repoCredito->find($cuota->id_credito);
    $cliente = clientes::find('id', $credito->cliente_id);
    if($credito->idtipofinanciacion){
      $productos = ventas::idregistros('idfactura', $credito->factura_id);
    }else{
      $repoProductsSep = new productsSeparadosRepository();
      $productos = $repoProductsSep->findAll('idcredito', $credito->id);
    }
    $print = new ticketPOS();
    $print->generarComptobanteAbono($sucursal, $credito, $cuota, $cliente, $productos);
  }


  //cuando se realiza una compra por el modulo de inventario
  public static function printComprobanteCompraPDF():void{
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $sucursal = sucursales::find('id', id_sucursal());
    $compra = compras::find('id', $id);
    $proveedor = proveedores::find('id', $compra->idproveedor);
    $productos = detallecompra::idregistros('idcompra', $compra->id);
    $print = new ticketPOS();
    $print->generarComprobanteCompra($sucursal, $compra, $proveedor, $productos);
  }


  public static function printPDFPOSPagoComision():void{
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    $sucursal = sucursales::find('id', id_sucursal());
    $repoPagoComision = new pagosComisionesRepository();
    $x = $repoPagoComision->find($id);
    $usuario = usuarios::find('id', $x->fkusuarioid);
    $print = new ticketPOS();
    $print->generarComprobantePagoComision($sucursal, $usuario, $x);
  }

}