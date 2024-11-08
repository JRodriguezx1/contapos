<?php

namespace Controllers;

use Classes\Email;
use Model\usuarios; //namespace\clase hija
use Model\negocio;
use Model\mediospago;
use MVC\Router;  //namespace\clase
 
class configcontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $negocio = negocio::find('id', 1);
    $empleados = usuarios::all();
    //$servicios = servicios::all();
    //$empleados = empleados::all();
    $mediospago = mediospago::all();
    $empleado = new \stdClass();
    $empleado->perfil = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/configuracion/index', ['titulo'=>'Configuracion', 'paginanegocio'=>'checked', 'negocio'=>$negocio, 'empleado'=>$empleado, 'empleados'=>$empleados, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);   //  'autenticacion/login' = carpeta/archivo
  }


}