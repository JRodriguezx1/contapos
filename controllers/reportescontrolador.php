<?php
//$dias = facturacion::inner_join('SELECT COUNT(id) AS servicios, fecha_pago, SUM(total) AS totaldia FROM facturacion GROUP BY fecha_pago ORDER BY COUNT(id) DESC;');
namespace Controllers;

use Model\inventario\productos;
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

  public static function reporteventamensual(){
    
  }

  //// grafica de ventas menusal año acutal de la vista principal de reportes index.php
  public static function ventasGraficaMensual(){
    session_start();
    isadmin();
    $data = facturas::ventasGraficaMensual();
    $label = [];
    $datos = [];
    foreach($data as $value){
        $label[] = 'mes '.$value->mes;
        $datos[] = $value->total_venta;
    }
    echo json_encode(['label'=>$label, 'datos'=>$datos]);
  }


  //// grafica de ventas diarias mes acutal de la vista principal de reportes index.php
  public static function ventasGraficaDiario(){
    session_start();
    isadmin();
    $data = facturas::ventasGraficaDiario();
    $label = [];
    $datos = [];
    foreach($data as $value){
        $label[] = 'dia '.$value->dia;
        $datos[] = $value->total_venta;
    }
    echo json_encode(['label'=>$label, 'datos'=>$datos]);
  }

    ///// grafica "Valor de los productos principales del inventario" vista principal de reportes index.php
  public static function graficaValorInventario(){
    session_start();
    isadmin();
    $sql = "SELECT SUM(sps.stock*p.precio_compra) AS costoinv, SUM(sps.stock*p.precio_venta) AS valorventa
    FROM stockproductossucursal sps JOIN productos p ON sps.productoid = p.id WHERE sps.sucursalid = 1;";
    $datos = productos::camposJoinObj($sql);
    echo json_encode(array_shift($datos));
  }


  //transacciones acumuladas por mes durante año elegido
  public static function ventasxtransaccionanual(){
    session_start();
    isadmin();
    $sql = "SELECT DATE_FORMAT(fechapago, '%Y-%m') AS fecha, COUNT(*) AS num_transacciones,
            AVG(total) AS promedio_transaccion, SUM(total) AS total_venta,
            MAX(total) AS transaccion_mas_alta, MIN(total) AS transaccion_mas_baja
            FROM facturas WHERE fechapago >= CONCAT('2025', '-01-01')
            AND fechapago < DATE_ADD(CONCAT('2025', '-01-01'), INTERVAL 1 YEAR)
            GROUP BY DATE_FORMAT(fechapago, '%Y-%m') ORDER BY fecha;";
    $datos = productos::camposJoinObj($sql);
    echo json_encode($datos);
  }

  //transacciones acumuladas por dia durante mes elegido
  public static function ventasxtransaccionmes(){
    session_start();
    isadmin();
    $sql = "SELECT DATE(fechapago) AS fecha, COUNT(*) AS num_transacciones,
            ROUND(AVG(total), 2) AS promedio_transaccion, SUM(total) AS total_venta,
            MAX(total) AS transaccion_mas_alta, MIN(total) AS transaccion_mas_baja
            FROM facturas WHERE fechapago >= CONCAT('2025-09', '-01')
            AND fechapago < DATE_ADD(CONCAT('2025-09', '-01'), INTERVAL 1 MONTH)
            GROUP BY DATE(fechapago) ORDER BY fecha;";
    $datos = productos::camposJoinObj($sql);
    echo json_encode($datos);
  }



}