<?php

namespace App\Controllers;

use App\Models\ActiveRecord;
use MVC\Router;  //namespace\clase
use App\Models\clientes\clientes;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Models\ventas\facturas;

class creditoscontrolador{

    public static function index(Router $router){
        session_start();
        isadmin();
        $alertas = [];
        $clientes = clientes::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
        }
        $creditos = creditos::unJoinWhereArrayObj(clientes::class, 'cliente_id', 'id', ['id_fksucursal'=>id_sucursal()]);

        $router->render('admin/creditos/index', ['titulo'=>'Creditos', 'creditos'=>$creditos, 'clientes'=>$clientes, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function crearCredito(Router $router){
        date_default_timezone_set('America/Bogota');
        session_start();
        isadmin();
        $alertas = [];
        $clientes = clientes::all();
        $credito = new creditos($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $credito->validar();
            if(empty($alertas)){
                $credito->id_fksucursal = id_sucursal();
                $credito->saldopendiente = str_replace('.', '', $credito->montototal);
                $credito->valorinteresxcuota = str_replace('.', '', $credito->valorinteresxcuota);
                $credito->valorinterestotal = str_replace('.', '', $credito->valorinterestotal);
                $credito->montototal = str_replace('.', '', $credito->montototal);
                $r = $credito->crear_guardar();
                if($r[0]){
                    $alertas['exito'][] = "Credito realizado correctamente"; 
                }
            }
        }
        $creditos = creditos::unJoinWhereArrayObj(clientes::class, 'cliente_id', 'id', ['id_fksucursal'=>id_sucursal()]);

        

        $router->render('admin/creditos/index', ['titulo'=>'Creditos', 'creditos'=>$creditos, 'clientes'=>$clientes, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function detallecredito(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
        $alertas = [];
        $id = $_GET['id'];
        if(!is_numeric($id))return;

        $credito = creditos::find('id', $id);
        $cuotas = cuotas::idregistros('id_credito', $credito->id);
        $factura = [];
        if(is_null($credito->factura_id))
            $factura = facturas::find('id', $credito->factura_id);


        
        $router->render('admin/creditos/detallecredito', ['titulo'=>'Detalle Credito', 'credito'=>$credito, 'cuotas'=>$cuotas, '$factura'=>$factura, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
    }



    /////////      API      ///////////

    public static function allcredits(){
        session_start();
        isadmin();
        $creditos = creditos::unJoinWhereArrayObj(clientes::class, 'cliente_id', 'id', ['id_fksucursal'=>id_sucursal()]);
        ////////////// calcular el impuesto como global o como discriminado por producto /////////////////////
        //$conflocal = config_local::getParamGlobal();
        /*foreach($productos as $index=>$producto){
        $producto->id = $producto->ID; //esto se hace por la union de las tablas con unJoinWhereArrayObj
        }*/
    echo json_encode($creditos);
    }


     public static function actualizarCredito(){
        session_start();
        isadmin();
        $creditos = creditos::unJoinWhereArrayObj(clientes::class, 'cliente_id', 'id', ['id_fksucursal'=>id_sucursal()]);
        ////////////// calcular el impuesto como global o como discriminado por producto /////////////////////
        //$conflocal = config_local::getParamGlobal();
        /*foreach($productos as $index=>$producto){
        $producto->id = $producto->ID; //esto se hace por la union de las tablas con unJoinWhereArrayObj
        }*/
        echo json_encode($creditos);
        }
}