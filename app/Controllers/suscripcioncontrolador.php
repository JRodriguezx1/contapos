<?php
//$dias = facturacion::inner_join('SELECT COUNT(id) AS servicios, fecha_pago, SUM(total) AS totaldia FROM facturacion GROUP BY fecha_pago ORDER BY COUNT(id) DESC;');
namespace App\Controllers;

use App\Models\sucursales;
use MVC\Router;  //namespace\clase
 
class suscripcioncontrolador{

    public static function index(Router $router){
        //session_start();
        isadmin();
        //if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/modorapido/index', ['titulo'=>'Ventas', 'sucursales'=>sucursales::all(), 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }


    public static function registrarPago(){
        //session_start();
        isadmin();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(405); // Método no permitido
        echo json_encode(['error' => 'Método no permitido']);
        exit;
        }
        $idfactura = json_decode(file_get_contents('php://input'), true);
    
        $alertas['error'][] = "Error factura no se encuentra como pendiente de enviar a Dian o no esta paga.";
        echo json_encode($alertas);
        return;
    }
  
}