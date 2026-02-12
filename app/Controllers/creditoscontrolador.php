<?php

namespace App\Controllers;

use App\Models\ActiveRecord;
use MVC\Router;  //namespace\clase
use App\Models\clientes\clientes;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\creditos\productosseparados;
use App\Models\inventario\productos;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Models\ventas\facturas;
use App\Repositories\creditos\creditosRepository;
use App\Repositories\creditos\cuotasRepository;
use App\Repositories\creditos\productsSeparadosRepository;
use App\Repositories\creditos\separadomediopagoRepository;
use App\Request\separadoRequest;
use App\services\creditosService;
use App\services\paymentService;

class creditoscontrolador{

    public static function index(Router $router){
        //session_start();
        isadmin();
        $alertas = [];
        $clientes = clientes::all();
        $creditos = new creditosRepository();
        $creditos = $creditos->unJoinWhereArrayObj('clientes', 'cliente_id', 'id', ['id_fksucursal'=>id_sucursal(), 'idestadocreditos'=>2]);
        $router->render('admin/creditos/index', ['titulo'=>'Creditos', 'creditos'=>$creditos, 'clientes'=>$clientes, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function separado(Router $router){
        //session_start();
        isadmin();
        $alertas = [];
        $idsucursal = id_sucursal();
        $clientes = clientes::all();
        $mediospago = mediospago::whereArray(['estado'=>1]);
        $cajas = caja::whereArray(['idsucursalid'=>$idsucursal, 'estado'=>1]);
        $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
        $conflocal = config_local::getParamCaja();
        $router->render('admin/creditos/separado', ['titulo'=>'Creditos', 'clientes'=>$clientes, 'mediospago'=>$mediospago, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function detallecredito(Router $router){
        //session_start();
        isadmin();
        //if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
        $alertas = [];
        $id = $_GET['id'];  //id del credito
        if(!is_numeric($id))return;

        $conflocal = config_local::getParamGlobal();
        $datos = creditosService::detallecredito($id);
        
        $viewData = array_merge($datos, ['conflocal'=>$conflocal, 'alertas' => $alertas, 'sucursales' => sucursales::all(), 'user' => $_SESSION ]);
        $router->render('admin/creditos/detallecredito', $viewData);
    }


    public static function adicionarProducto(Router $router){
        //session_start();
        isadmin();
        //if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
        $alertas = [];
        $id = $_GET['id'];  //id del credito
        if(!is_numeric($id))return;

        $conflocal = config_local::getParamGlobal();
        $datos = creditosService::detallecredito($id);
        
        $viewData = array_merge($datos, ['conflocal'=>$conflocal, 'alertas' => $alertas, 'sucursales' => sucursales::all(), 'user' => $_SESSION ]);
        $router->render('admin/creditos/adicionarProducto', $viewData);
    }


    public static function registrarAbono(Router $router){
        date_default_timezone_set('America/Bogota');
        //session_start();
        isadmin();

        $conflocal = config_local::getParamGlobal();
        $factura = null;
        if(isset($credito->factura_id))$factura = facturas::find('id', $credito->factura_id);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = creditosService::registrarAbono($_POST);   // crear factory de repositorios
        }
        $datos = creditosService::detallecredito($_POST['id_credito']);  //// crear factory de repositorios
        $viewData = array_merge($datos, ['conflocal'=>$conflocal, 'alertas' => $alertas, 'sucursales' => sucursales::all(), 'user' => $_SESSION ]);
        
        $router->render('admin/creditos/detallecredito', $viewData);
    }


    public static function pagoTotal(Router $router){
        date_default_timezone_set('America/Bogota');
        //session_start();
        isadmin();
        $conflocal = config_local::getParamGlobal();
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = creditosService::registrarAbono($_POST);   // crear factory de repositorios
        }
        $datos = creditosService::detallecredito($_POST['id_credito']);  //// crear factory de repositorios
        $viewData = array_merge($datos, ['conflocal'=>$conflocal, 'alertas' => $alertas, 'sucursales' => sucursales::all(), 'user' => $_SESSION ]);
        
        $router->render('admin/creditos/detallecredito', $viewData);
    }



    /////////      API      ///////////

    public static function allcredits(){
        //session_start();
        isadmin();
        $creditos = new creditosRepository();
        $creditos = $creditos->unJoinWhereArrayObj('clientes', 'cliente_id', 'id', ['id_fksucursal'=>id_sucursal()]);
        echo json_encode($creditos);
    }

    
    public static function crearSeparado(){  //llamada desde separado.ts
        //session_start();
        isadmin();
        $alertas = [];
        $valoresCredito = (array)json_decode($_POST['valoresCredito']);
        $carrito = json_decode($_POST['carrito']);
        $mediospago = json_decode($_POST['mediospago']);
        $factimpuestos = json_decode($_POST['factimpuestos']);
        $valorefectivo = $_POST['valorefectivo']??0;
        $valoresCredito = ['usuariofk'=>$_SESSION['id'],'idtipofinanciacion' => 2]+$valoresCredito;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $validate = new separadoRequest($valoresCredito);
            $alertas = $validate->validate();
            if(empty($alertas)){
                $alertas = creditosService::ejecutarCrearSeparado($valoresCredito, $carrito, $mediospago, $valorefectivo);
            }
        }
        echo json_encode($alertas);
    }


    public static function cambioMedioPagoSeparado(){
        //session_start();
        isadmin();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST' )$alertas = creditosService::cambioMedioPagoSeparado($_POST);
        echo json_encode($alertas);
    }


    public static function anularSeparado(){
        //session_start();
        isadmin();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST' )$alertas = creditosService::anularSeparado($_POST['id']);
        echo json_encode($alertas);
    }


    public static function ajustarCreditoAntiguo(){
        //session_start();
        isadmin();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST' )$alertas = creditosService::ajustarCreditoAntiguo($_POST);
        echo json_encode($alertas);
    }

    public static function detalleProductosCredito(){
        isadmin();
        $alertas = [];
        $id=$_GET['id'];
        if(!is_numeric($id)){
            $alertas['error'][] = "Error al procesar orden.";
            echo json_encode($alertas);
            return;
        }
        $alertas = creditosService::detalleProductosCredito($id);
        echo json_encode($alertas);
    }


    public static function editarOrdenCreditoSeparado(){
        isadmin();
        $alertas = [];
        $idcredito = $_POST['idcredito'];
        $idsdetalleproductos = json_decode($_POST['ids']);
        $nuevosproductosFront = json_decode($_POST['nuevosproductos']);

        $capital = json_decode($_POST['capital']);
        $saldopendiente = json_decode($_POST['saldopendiente']);
        $montocuota = json_decode($_POST['montocuota']);
        $montototal = json_decode($_POST['montototal']);
        $totalunidades = json_decode($_POST['totalunidades']);
        $dataCredit = ['capital'=>$capital, 'saldopendiente'=>$saldopendiente, 'montocuota'=>$montocuota, 'montototal'=>$montototal, 'totalunidades'=>$totalunidades];
        //debuguear($dataCredit);
        if($_SERVER['REQUEST_METHOD'] === 'POST' )
            $alertas = creditosService::editarOrdenCreditoSeparado($idcredito, $idsdetalleproductos, $nuevosproductosFront, $dataCredit);
        echo json_encode($alertas);
    }
}