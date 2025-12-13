<?php

namespace App\Controllers;

use App\Models\ActiveRecord;
use MVC\Router;  //namespace\clase
use App\Models\clientes\clientes;
use App\Models\sucursales;

class creditoscontrolador{

    public static function index(Router $router){
        session_start();
        isadmin();
        $alertas = [];
        $clientes = clientes::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
        }
        $router->render('admin/creditos/index', ['titulo'=>'Creditos', 'clientes'=>$clientes, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }
}