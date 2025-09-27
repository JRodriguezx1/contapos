<?php


namespace Controllers;
//require __DIR__ . '/../classes/dompdf/autoload.inc.php';
//require __DIR__ . '/../classes/twilio-php-main/src/Twilio/autoload.php';
//require __DIR__ . '/../classes/aws/aws-autoloader.php';
//require __DIR__ . '/../classes/RECEIPT-main/ticket.php';

use Model\caja\cierrescajas;
use MVC\Router;
use Model\configuraciones\usuarios;
//use ticketPOS;


//use Dompdf\Dompdf;
use Twilio\Rest\Client;
//use Aws\Sns\SnsClient;


class dashboardcontrolador{

    public static function index(Router $router) {
        session_start();
        isadmin();
        date_default_timezone_set('America/Bogota');
        
        $idsucursal = id_sucursal();
        /*
        $dompdf = new Dompdf();
        ...
        ...
        ...
        */
        //$pos = new ticketPOS();
        //$pos->generar();


        //$totalempleados = empleados::numregistros();
        //$totalclientes = usuarios::numreg_multicolum(['confirmado'=>1, 'admin'=>0]);


        $sql = "SELECT SUM(ventasenefectivo) AS efectivofacturado, SUM(ingresoventas) AS totalingreso, 
                SUM(totalfacturas), SUM(gastoscaja), SUM(descuentofe+descuentopos)
                FROM cierrescajas WHERE idsucursal_id = $idsucursal AND estado = 0;";

        $sql = "SELECT SUM(v.cantidad) AS totalvendido, p.nombre, p.id AS idproducto, SUM(SUM(v.cantidad)) OVER () AS total_general
                FROM ventas v
                INNER JOIN facturas f ON f.id = v.idfactura
                INNER JOIN productos p ON p.id = v.idproducto
                WHERE f.id_sucursal = $idsucursal
                GROUP BY p.id, p.nombre ORDER BY totalvendido DESC LIMIT 8;";
        
        $router->render('admin/dashboard/index', ['titulo'=>'Inicio', 'day'=>1, 'totalclientes'=>1, 'totalempleados'=>1, 'user'=>$_SESSION]);
    }

    public static function perfil(Router $router) {
        $alertas = [];
        session_start();
        isadmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $usuario = usuarios::find('id', $_SESSION['id']);
            $hashpass = $usuario->password;
            $x = $usuario->comprobar_password($_POST['password']);
            $usuario->compara_objetobd_post($_POST);
            $alertas = $usuario->validarEmail();
            $usuario->password = $hashpass;
            if(empty($alertas)){
                //////// validar el password principal
                if($x){
                    //////// validar si hubo cambio de passoword y que no se vacio el nuevo password
                    if(isset($_POST['password2'])&&!empty(trim($_POST['password2']))){
                        $usuario->password = $usuario->password2;
                        $usuario->hashPassword();
                    }
                    $r = $usuario->actualizar();
                    if($r){
                        $alertas['exito'][] = "Datos actualizados";
                    }else{ $alertas['error'][] = "Hubo un error al actualizar los datos de usuario"; }
                }else{
                    $alertas['error'][] = "Password incorrecto";
                }
            }
        }
        $usuario = usuarios::find('id', $_SESSION['id']);
        $router->render('admin/dashboard/perfil', ['titulo'=>'Perfil', 'usuario'=>$usuario, 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function actualizaremail(Router $router) {
        $alertas = [];
        session_start();
        isadmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $usuario = usuarios::find('id', $_SESSION['id']);
            $usuario->compara_objetobd_post($_POST);
            $r = $usuario->actualizar();
            if($r){
                $alertas['exito'][] = "Email actualizado";
            }else{ $alertas['error'][] = "Hubo un error al actualizar el email"; }
        }
        $usuario = usuarios::find('id', $_SESSION['id']);
        $router->render('admin/dashboard/perfil', ['titulo'=>'Perfil', 'usuario'=>$usuario, 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }
    

    public static function alldays(){  //api
        $alldays = pagosxdia::ordenarlimite('id', 'DESC', 8);
        echo json_encode($alldays);
    }

    public static function totalcitas(){  //api
        date_default_timezone_set('America/Bogota');
        $fecha = date('Y-m-d'); //dia actual hoy
        $citasxdia = citas::idregistros('start', $fecha);
        //$citasxdia = citas::whereArray(['start'=>$fecha]);
        foreach($citasxdia as $value){
           // $value->idservicio = empserv::uncampo('id', $value->id_empserv, 'idservicio');
            $value->facturacion = facturacion::find('idcita', $value->id);
        }
        echo json_encode($citasxdia);
    }
}

?>