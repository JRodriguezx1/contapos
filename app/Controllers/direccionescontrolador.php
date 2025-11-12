<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;  //namespace\clase
use Model\configuraciones\usuarios;
use Model\clientes\clientes;
use Model\empleados;
use Model\clientes\direcciones;
use Model\configuraciones\tarifas;

 
class direccionescontrolador{

    public static function index(Router $router){
        session_start();
        isadmin();
        $alertas = [];
        $buscar = '';
        $clientes = clientes::all(); //me trae los usuario que esten confirmados y no admin

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if($_POST['filtro']!='all')
                $clientes = usuarios::filtro_nombre($_POST['filtro'], $_POST['buscar'], 'id');
                $buscar = $_POST['buscar'];

        }

        $router->render('admin/clientes/index', ['titulo'=>'Clientes', 'clientes'=>$clientes, 'alertas'=>$alertas, 'buscar'=>$buscar, 'user'=>$_SESSION]);
    }

    public static function crear(Router $router){
        session_start();
        isadmin();
        $direccion = new direcciones($_POST);
        $alertas = [];  
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $direccion->validarDireccion();
            if(empty($alertas)){ 
                $resultado = $direccion->crear_guardar();
                if($resultado[0]){
                    $alertas['exito'][] = 'Direccion creada correctamente';
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        $clientes = clientes::all();
        $tarifas = tarifas::all();
        $router->render('admin/clientes/index', ['titulo'=>'clientes', 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'alertas'=>$alertas, 'user'=>$_SESSION]);
    }
     


    ///////////////////////////////////  Apis ////////////////////////////////////
    public static function direccionesXcliente(){  //api llamado desde ventas.js me trae todas las direcciones segun cliente elegido
        $id = $_GET['id'];
        $direcciones = direcciones::idregistros('idcliente', $id);
        foreach($direcciones as $direccion){
            $direccion->tarifa = tarifas::find('id', $direccion->idtarifa);
        }
        echo json_encode($direcciones);
    }
    

    public static function addDireccionCliente(){ //api llamada desde el modulo de ventas.ts cuando se crea una direccion
        session_start();
        isadmin();
        $direccion = new direcciones($_POST);
        $alertas = [];  
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $direccion->validarDireccion();
            if(empty($alertas)){ 
                $resultado = $direccion->crear_guardar();
                if($resultado){
                    $direcciones = direcciones::idregistros('idcliente', $_POST['idcliente']);
                    foreach($direcciones as $direccion)$direccion->tarifa = tarifas::find('id', $direccion->idtarifa);
                    $alertas['direcciones'] = $direcciones;
                    $alertas['exito'][] = 'Direccion Registrada correctamente';
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }
}