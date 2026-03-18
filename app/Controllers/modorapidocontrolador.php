<?php

namespace App\Controllers;

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
use App\Models\factimpuestos;
use App\Models\felectronicas\adquirientes;
use App\Models\impuestos;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Repositories\ventas\canalVentaRepository;
use MVC\Router;  //namespace\clase
 
class modorapidocontrolador{

    public static function index(Router $router){
        isadmin();
        //if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];
        $idsucursal = id_sucursal();
        $productos = productos::SelectProducts_Category_StockXsucursal(); //filtra habilitarventa = 1
        $categorias = categorias::all();
        $mediospago = mediospago::whereArray(['estado'=>1]);
        $clientes = clientes::all();
        $tarifas = tarifas::all();
        $cajas = caja::whereArray(['idsucursalid'=>$idsucursal, 'estado'=>1]);
        $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
        $departments = departments::all();

        $conflocal = config_local::getParamCaja();

        $canalesVentaRepo = new canalVentaRepository();
        $canalesVenta = $canalesVentaRepo->all();

        $router->render('admin/modorapido/index', ['titulo'=>'Ventas', 'categorias'=>$categorias, 'productos'=>$productos, 'mediospago'=>$mediospago, 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'canalesVenta'=>$canalesVenta, 'departments'=>$departments, 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }
}