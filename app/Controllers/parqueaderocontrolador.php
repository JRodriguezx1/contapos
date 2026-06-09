<?php

namespace App\Controllers;

use App\classes\Traits\DocumentTrait;
use App\Models\ActiveRecord;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use MVC\Router;  //namespace\clase
use stdClass;

class parqueaderocontrolador{

  use DocumentTrait;

  public static function index(Router $router):void{
    //session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de venta')&&userPerfil()>3)return;
    $alertas = [];
    $idsucursal = id_sucursal();
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/parqueadero/index', ['titulo'=>'Parqueadero', 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
  }
}