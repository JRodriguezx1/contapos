<?php
//$dias = facturacion::inner_join('SELECT COUNT(id) AS servicios, fecha_pago, SUM(total) AS totaldia FROM facturacion GROUP BY fecha_pago ORDER BY COUNT(id) DESC;');
namespace Controllers;

use MVC\Router;  //namespace\clase
 
class reportescontrolador{

    public static function index(Router $router){
        session_start();
        isadmin();
        $alertas = [];

        $router->render('admin/reportes/index', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    ///////////////////////// Reportes ///////////////////////////////////
    public static function ventasgenerales(Router $router){
        session_start();
        isadmin();
        $alertas = [];

        $router->render('admin/reportes/ventasgenerales', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }
    public static function cierrescaja(Router $router){
        session_start();
        isadmin();
        $alertas = [];

        $router->render('admin/reportes/cierrescaja', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    
    public static function zdiario(Router $router){
        session_start();
        isadmin();
        $alertas = [];

        $router->render('admin/reportes/zdiario', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function ventasxtransaccion(Router $router){
        session_start();
        isadmin();
        $alertas = [];

        $router->render('admin/reportes/ventasxtransaccion', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }


    //////////////////////////----    API      ----////////////////////////////////

  ///////////  API REST llamada desde cerrarcaja.ts cuando se declara dinero  ////////////
  public static function consultafechazetadiario(){
    $alertas = [];

    $cajas = $_POST['cajas'];
    $facturadores = $_POST['facturadores'];

    
    echo json_encode($alertas);
  }

}