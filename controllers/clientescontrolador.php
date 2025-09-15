<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use MVC\Router;  //namespace\clase
use Model\configuraciones\usuarios;
use Model\clientes\clientes;
use Model\empleados;
use Model\clientes\direcciones;
use Model\configuraciones\tarifas;

 
class clientescontrolador{

    public static function index(Router $router){
        session_start();
        isadmin();
        $alertas = [];
        $buscar = '';
        $clientes = clientes::all();
        $tarifas = tarifas::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
        }
        $router->render('admin/clientes/index', ['titulo'=>'Clientes', 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'alertas'=>$alertas, 'buscar'=>$buscar, 'user'=>$_SESSION]);
    }

    public static function crear(Router $router){
        /*$alertas = $usuario->validarEmail();    
        $usuarioexiste = $usuario->validar_registro();//retorna 1 si existe usuario(email), 0 si no existe
        $usuariotelexiste = $usuario->find('movil', $_POST['movil']);*/
        session_start();
        isadmin();
        $cliente = new clientes($_POST);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $cliente->validar_nuevo_cliente();
            $documentID = $cliente->validar_regDinamic('identificacion');
            //$alertas = $direccion->validarDireccion();
            if(empty($alertas) && !$documentID){ //si los campos cumplen los criterios y cliente no existe por documento    
                $resultado = $cliente->crear_guardar();  
                if($resultado[0]){
                    $alertas['exito'][] = 'Cliente Registrado correctamente'; 
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }else{
                if($documentID)$cliente::setAlerta('error', 'El cliente ya esta registrado');
                $alertas = $cliente::getAlertas();
            }
        }
        $clientes = clientes::all();
        $tarifas = tarifas::all();
        $router->render('admin/clientes/index', ['titulo'=>'clientes', 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'alertas'=>$alertas, 'user'=>$_SESSION]);
    }


    public static function actualizar(Router $router){
        session_start();
        isadmin();
        $alertas = [];  
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $cliente = usuarios::find('id', $_POST['id']);
            $cliente->compara_objetobd_post($_POST);
            $cliente->password2 = $cliente->password;
            $alertas = $cliente->validar_nueva_cuenta();
            $alertas = $cliente->validarEmail();
            if(empty($alertas)){
                $r = $cliente->actualizar();
                if($r)$alertas['exito'][] = 'Datos de cliente actualizados';
            }
        }
        $clientes = usuarios::whereArray(['confirmado'=>1, 'admin'=>0]);
        $router->render('admin/clientes/index', ['titulo'=>'clientes', 'clientes'=>$clientes, 'alertas'=>$alertas, 'user'=>$_SESSION]);
    }


    public static function hab_desh(Router $router){
        session_start();
        isadmin();
        $alertas = [];  
        $id = $_GET['id'];
        if(!is_numeric($id))return;

        $cliente = usuarios::find('id', $id);
        if($cliente){
            if($cliente->habilitar){
                $cliente->habilitar = 0;
                $alertas['exito'][] = 'Cliente bloqueado de la base de datos';
            }else{
                $cliente->habilitar = 1;
                $alertas['exito'][] = 'Cliente habilitado de la base de datos';
            }
            $r = $cliente->actualizar();
        }else{
            header('Location: /admin/clientes');
        }

        if(!$r)$alertas['exito'][] = 'hubo un error';
        
        $clientes = usuarios::whereArray(['confirmado'=>1, 'admin'=>0]);
        $router->render('admin/clientes/index', ['titulo'=>'clientes', 'clientes'=>$clientes, 'alertas'=>$alertas, 'user'=>$_SESSION]);
    }


    public static function detalle(Router $router){
        session_start();
        isadmin(); 
        $id = $_GET['id'];
        if(!is_numeric($id))return;

        $alertas = []; 
 
        $cliente = usuarios::find('id', $id);
        
        $router->render('admin/clientes/detalle', ['titulo'=>'clientes', 'cliente'=>$cliente, 'alertas'=>$alertas, 'user'=>$_SESSION]);
    }
     


    ///////////////////////////////////  Apis ////////////////////////////////////
    public static function allclientes(){  //api llamado desde citas.js
        $clientes = clientes::all();
        echo json_encode($clientes);
    }
    

    public static function apiCrearCliente(){ //api llamada desde el modulo de ventas.ts cuando se crea un cliente
        session_start();
        isadmin();
        $cliente = new clientes($_POST);
        $direccion = new direcciones($_POST);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $cliente->validar_nuevo_cliente();
            $documentID = $cliente->validar_regDinamic('identificacion');
            $alertas = $direccion->validarDireccion();
            if(empty($alertas) && !$documentID){ //si los campos cumplen los criterios y cliente no existe por documento   
                //guardar cliente recien creado en bd  
                $resultado = $cliente->crear_guardar();  
                if($resultado[0]){
                    $direccion->idcliente =  $resultado[1];
                    $r1 = $direccion->crear_guardar();
                    if($r1[0]){
                        $alertas['exito'][] = 'Cliente Registrado correctamente';
                        $alertas['nextID'] = $resultado[1];
                    }else{
                        $cliente->eliminar_idregistros('id', [$resultado[1]]);
                        $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                    }
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }else{
                if($documentID)$cliente::setAlerta('error', 'El cliente ya esta registrado');
                $alertas = $cliente::getAlertas();
            }
        }
        echo json_encode($alertas);
    }


    public static function apiActualizarcliente(){
        session_start();
        $alertas = []; 
        $cliente = clientes::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $cliente->compara_objetobd_post($_POST);
            $alertas = $cliente->validar_nuevo_cliente();
            if(empty($alertas)){
                $r = $cliente->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos del cliente actualizados";
                }else{
                    $alertas['error'][] = "Error al actualizar cliente";
                }
            }
        }
        $alertas['cliente'][] = $cliente;
        echo json_encode($alertas);  
    }


    public static function apiEliminarCliente(){
        session_start();
        $cliente = clientes::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($cliente)){
                $r = $cliente->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'Cliente eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'Cliente no encontrado');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }
}