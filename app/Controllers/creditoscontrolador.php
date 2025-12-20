<?php

namespace App\Controllers;

use App\Models\ActiveRecord;
use MVC\Router;  //namespace\clase
use App\Models\clientes\clientes;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Models\ventas\facturas;
use App\services\creditosService;

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
                $credito->idtipofinanciacion = 2;
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
        //if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
        $alertas = [];
        $id = $_GET['id'];
        if(!is_numeric($id))return;

        $credito = creditos::find('id', $id);
        $cuotas = cuotas::idregistros('id_credito', $credito->id);
        $cliente = clientes::find('id', $credito->cliente_id);
        $cajas = caja::whereArray(['idsucursalid'=>id_sucursal(), 'estado'=>1]);
        $factura =null;
        if(is_null($credito->factura_id))
            $factura = facturas::find('id', $credito->factura_id);

        foreach($cuotas as $value){
            $value->mediopago = mediospago::find('id', $value->mediopagoid)->mediopago;

        }

        $mediospago = mediospago::whereArray(['estado'=>1]);
        
        $router->render('admin/creditos/detallecredito', ['titulo'=>'Creditos', 'credito'=>$credito, 'cuotas'=>$cuotas, 'cliente'=>$cliente, 'cajas'=>$cajas, 'factura'=>$factura, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function registrarAbono(Router $router){
        date_default_timezone_set('America/Bogota');
        session_start();
        isadmin();
        $alertas = [];
        $credito = creditos::find('id', $_POST['id_credito']);
        $cliente = clientes::find('id', $credito->cliente_id);
        $cajas = caja::whereArray(['idsucursalid'=>id_sucursal(), 'estado'=>1]);
        $factura = null;
        if(is_null($credito->factura_id))$factura = facturas::find('id', $credito->factura_id);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if($credito->estado == 0){
                $cuota = new cuotas($_POST);
                $credito->numcuota += 1;
                $cuota->numerocuota = $credito->numcuota;
                $cuota->montocuota = $credito->montocuota;
                $alertas = $cuota->validar();
                if(empty($alertas)){
                    $r = $cuota->crear_guardar();
                    if($r[0]){
                        $alertas['exito'][] = "Cuota procesada";
                        $credito->saldopendiente -= $cuota->valorpagado;
                        if($credito->saldopendiente<=0)$credito->estado = 1;  //credito cerrado
                        $ra = $credito->actualizar();
                        
                    }
                }
            }else{
                $alertas['error'][] = "Credito finalizado, no se puede abonar mas";
            }
        }
        $mediospago = mediospago::whereArray(['estado'=>1]);
        $cuotas = cuotas::idregistros('id_credito', $credito->id);
        foreach($cuotas as $value){
            $value->mediopago = mediospago::find('id', $value->mediopagoid)->mediopago;
            
        }
        
        $router->render('admin/creditos/detallecredito', ['titulo'=>'Creditos', 'credito'=>$credito, 'cuotas'=>$cuotas, 'cliente'=>$cliente, 'cajas'=>$cajas, 'factura'=>$factura, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
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