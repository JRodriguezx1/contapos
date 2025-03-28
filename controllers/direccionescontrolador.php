<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;  //namespace\clase
use Model\usuarios;
use Model\clientes;
use Model\empleados;
use Model\direcciones;
use Model\tarifas;

 
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
/*
            if($_POST['filtro'] == "cedula"){
                $registros_total = estudiantes::inner_join("SELECT COUNT(*) FROM estudiantes WHERE cedula LIKE '{$_POST['buscar']}%';");
                }else{
                    $registros_total = estudiantes::inner_join("SELECT COUNT(*) FROM estudiantes WHERE nombre LIKE '{$_POST['buscar']}%';");
                }*/
        }

        $router->render('admin/clientes/index', ['titulo'=>'Clientes', 'clientes'=>$clientes, 'alertas'=>$alertas, 'buscar'=>$buscar, 'user'=>$_SESSION]);
    }

    public static function crear(Router $router){
        session_start();
        isadmin();
        $usuario = new usuarios; //instancia el objeto vacio
        $alertas = [];  

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
            $usuario->compara_objetobd_post($_POST); //objeto instaciado toma los valores del $_POST
            $alertas = $usuario->validar_nueva_cuenta();
            $alertas = $usuario->validarEmail();
            
            if(empty($alertas)){ 
                
                $usuarioexiste = $usuario->validar_registro();//retorna 1 si existe usuario(email), 0 si no existe
                $usuariotelexiste = $usuario->find('movil', $_POST['movil']);

                if($usuarioexiste||$usuariotelexiste){ //si usuario ya existe
                    $usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = $usuario::getAlertas();
                }else{
                    //hashear pass
                    $usuario->hashPassword();
                    //eliminar pass2
                    unset($usuario->password2);
                    //generar token
                    //$usuario->creartoken();
                    $usuario->confirmado = '1';

                    //enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token, $_POST['password']);
                    $email->enviarConfirmacion();

                //guardar cliente recien creado en bd  
                    $resultado = $usuario->crear_guardar();  
                    if($resultado){
                        $alertas['exito'][] = 'Cliente Registrado correctamente';
                    }     
                }
            }
        }
        $clientes = usuarios::whereArray(['confirmado'=>1, 'admin'=>0]);
        $router->render('admin/clientes/index', ['titulo'=>'clientes', 'clientes'=>$clientes, 'alertas'=>$alertas, 'user'=>$_SESSION]);
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
                        $alertas['direcciones'] = direcciones::idregistros('idcliente', $_POST['idcliente']);
                        $alertas['exito'][] = 'Direccion Registrada correctamente';
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }
}