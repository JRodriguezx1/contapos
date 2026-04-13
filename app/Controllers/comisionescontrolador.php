<?php

namespace App\Controllers;

use App\classes\Email;
use App\Models\ActiveRecord;
use App\Models\configuraciones\usuarios; //namespace\clase hija
use App\Models\inventario\productos;
use App\Models\inventario\categorias;
use App\Models\configuraciones\mediospago;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
use App\Models\configuraciones\tarifas;
use App\Models\caja\cierrescajas;
use App\Models\clientes\departments;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\tipofacturador;
use App\Models\factimpuestos;
use App\Models\felectronicas\adquirientes;
use App\Models\impuestos;
use App\Models\parametrizacion\config_local;
use App\Models\inventario\productos_sub;
use App\Models\inventario\stockinsumossucursal;
use App\Models\inventario\stockproductossucursal;
use App\Models\inventario\subproductos;
use App\Models\sucursales;
use App\Repositories\ventas\canalVentaRepository;
use App\services\comisionesService;
use App\services\creditosService;
use App\services\stockService;
use App\services\whatsAppService;
//use App\Models\configuraciones\negocio;
use MVC\Router;  //namespace\clase
use stdClass;

class comisionescontrolador{


  public static function index(Router $router):void{
    $comisionServicio = new comisionesService();
    isadmin();
    $idsucursal = id_sucursal();
    $usuarios = usuarios::whereArray(['idsucursal'=>$idsucursal]);
    $widgets = $comisionServicio->getWidgets($idsucursal);
    $router->render('admin/comisiones/index', ['titulo'=>'Comisiones', 'widgets'=>$widgets, 'usuarios'=>$usuarios, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
  }


  //////////////////////    API     /////////////////////
  public static function comisionesXUser():void{
    $comisionServicio = new comisionesService();
    isadmin();
    $fechainicio = $_POST['fechainicio']; 
    $fechafin = $_POST['fechafin'];
    $idempleado = $_POST['idempleado'];

    $comisionesUser = $comisionServicio->comisionesXUser(id_sucursal(), $idempleado);

  }

}