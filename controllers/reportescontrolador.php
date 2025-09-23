<?php
//$dias = facturacion::inner_join('SELECT COUNT(id) AS servicios, fecha_pago, SUM(total) AS totaldia FROM facturacion GROUP BY fecha_pago ORDER BY COUNT(id) DESC;');
namespace Controllers;

use Model\ventas\facturas;
use MVC\Router;  //namespace\clase
 
class reportescontrolador{

    public static function index(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/index', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    ///////////////////////// Reportes ///////////////////////////////////
    public static function ventasgenerales(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/ventasgenerales', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }
    public static function cierrescaja(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/cierrescaja', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    
    public static function zdiario(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/zdiario', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function ventasxtransaccion(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/ventasxtransaccion', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }


    //////////////////////////----    API      ----////////////////////////////////

  ///////////  API REST llamada desde reportes o fechazetadiario.ts  ////////////
  public static function consultafechazetadiario(){
    session_start();
    isadmin();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    $idcajas = json_decode($_POST['cajas']);
    $idconsecutivos = json_decode($_POST['facturadores']);
    $cajas = join(", ", array_values($idcajas));
    $consecutivos = join(", ", array_values($idconsecutivos));
    $datosventa = facturas::zDiarioTotalVentas($cajas, $consecutivos, id_sucursal(), $fechainicio, $fechafin);
    $datosmediospago = facturas::zDiarioMediosPago($cajas, $consecutivos, id_sucursal(), $fechainicio, $fechafin);
    $datos['datosventa'] = $datosventa;
    $datos['datosmediospago'] = $datosmediospago;
    echo json_encode($datos);
  }

}