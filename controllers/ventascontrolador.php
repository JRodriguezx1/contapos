<?php

namespace Controllers;

use Classes\Email;
use Model\usuarios; //namespace\clase hija
use Model\productos;
use Model\categorias;
//use Model\negocio;
use MVC\Router;  //namespace\clase
 
class ventascontrolador{

  public static function index(Router $router):void{
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $productos = productos::all();
    $categorias = categorias::all();
    $router->render('admin/ventas/index', ['titulo'=>'Ventas', 'categorias'=>$categorias, 'productos'=>$productos, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);   //  'autenticacion/login' = carpeta/archivo
  }


}