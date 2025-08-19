<?php
//$dias = facturacion::inner_join('SELECT COUNT(id) AS servicios, fecha_pago, SUM(total) AS totaldia FROM facturacion GROUP BY fecha_pago ORDER BY COUNT(id) DESC;');
namespace Controllers;

use Model\facturas;
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

  ///////////  API REST llamada desde reportes o fechazetadiario.ts  ////////////
  public static function consultafechazetadiario(){
    $alertas = [];

    $idcajas = json_decode($_POST['cajas']);
    $idconsecutivos = json_decode($_POST['facturadores']);

    /*
    SELECT fact.ELECTRONICAS, fact.POS, fact.total_ELECTRONICAS, fact.total_POS, fact.totalventa, mp.EFECTIVO, mp.DAVIPLATA, mp.NEQUI, mp.CODIGOQR, mp.TARJETA_CREDITO, MP.TARJETA_DEBITO, MP.TRANSFERENCIA_BANCARIA
FROM(
  SELECT SUM(total) as totalventa, 
  SUM(CASE WHEN consecutivos.idtipofacturador = 1 THEN 1 ELSE 0 END) AS ELECTRONICAS, 
  SUM(CASE WHEN consecutivos.idtipofacturador = 2 THEN 1 ELSE 0 END) AS POS,          
  SUM(CASE WHEN consecutivos.idtipofacturador = 1 THEN total ELSE 0 END) AS total_ELECTRONICAS,
  SUM(CASE WHEN consecutivos.idtipofacturador = 2 THEN total ELSE 0 END) AS total_POS
                
  FROM facturas
  JOIN consecutivos ON facturas.idconsecutivo = consecutivos.id
  WHERE idconsecutivo IN(2, 3) AND idcaja IN(1, 2) AND facturas.estado = 'Paga'
) fact CROSS JOIN (
  SELECT
  SUM(CASE WHEN mediospago.nick = 'EF' THEN factmediospago.valor ELSE 0 END) as EFECTIVO,
  SUM(CASE WHEN mediospago.nick = 'DV' THEN factmediospago.valor ELSE 0 END) as DAVIPLATA,
  SUM(CASE WHEN mediospago.nick = 'NQ' THEN factmediospago.valor ELSE 0 END) as NEQUI,
  SUM(CASE WHEN mediospago.nick = 'QR' THEN factmediospago.valor ELSE 0 END) as CODIGOQR,
  SUM(CASE WHEN mediospago.nick = 'TC' THEN factmediospago.valor ELSE 0 END) as TARJETA_CREDITO,
  SUM(CASE WHEN mediospago.nick = 'TD' THEN factmediospago.valor ELSE 0 END) as TARJETA_DEBITO,
  SUM(CASE WHEN mediospago.nick = 'TB' THEN factmediospago.valor ELSE 0 END) as TRANSFERENCIA_BANCARIA
  FROM mediospago
  JOIN factmediospago ON mediospago.id = factmediospago.idmediopago
  JOIN facturas ON factmediospago.id_factura = facturas.id
  WHERE idconsecutivo IN(2, 3) AND idcaja IN(1, 2) AND facturas.estado = 'Paga'
)mp;
    */

    facturas::zDiarioPorFecha(" ", " ", $idconsecutivos, $idcajas, 'ASC');
    echo json_encode($alertas);
  }

}