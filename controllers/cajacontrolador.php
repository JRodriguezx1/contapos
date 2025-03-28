<?php

namespace Controllers;

use Classes\Email;
use Model\usuarios; //namespace\clase hija
//use Model\negocio;
use Model\facturas;
use Model\cierrescajas;
use Model\ingresoscajas;
use Model\gastos;
use Model\caja;
use Model\declaracionesdineros;
use Model\mediospago;
use Model\arqueoscajas;
use Model\clientes;
use Model\direcciones;
use Model\tarifas;
use Model\ventas;
use Model\consecutivos;
use MVC\Router;  //namespace\clase
use stdClass;

class cajacontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
    $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
    $cajas = caja::all();
    $router->render('admin/caja/index', ['titulo'=>'Caja', 'ultimocierre'=>$ultimocierre, 'cajas'=>$cajas, 'facturas'=>$facturas, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function cerrarcaja(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){  ///if se puede eliminar
            
    }
    $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
    $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
    $discriminarmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);
    $mediospagos = mediospago::all();
    $declaracion = declaracionesdineros::idregistros('idcierrecajaid', $ultimocierre->id);
    //////////// mapeo de arreglo de valores declarados con el arreglo de los pagos discriminados /////////////
    $sobrantefaltante = $declaracion;
    foreach($discriminarmediospagos as $i => $dis){
      $aux = 0;
      foreach($declaracion as $j => $dec){
        if($dis['idmediopago'] == $dec->id_mediopago){
          $sobrantefaltante[$j]->valorsistema = $dis['valor'];
          $aux = 1;
          break;
        }
      }
      if($aux == 0){
        $newobj = new stdClass();
        $newobj->id_mediopago = $dis['idmediopago'];
        $newobj->idcierrecajaid = $ultimocierre->id;
        $newobj->nombremediopago = $dis['mediopago'];
        $newobj->valordeclarado = 0;
        $newobj->valorsistema = $dis['valor'];
        $sobrantefaltante[] = $newobj;
      }
    }
    $router->render('admin/caja/cerrarcaja', ['titulo'=>'Caja', 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'ultimocierre'=>$ultimocierre, 'facturas'=>$facturas, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function ingresoGastoCaja(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
      if($ultimocierre->estado == 0){  // si es igual a cero esta abierto el cierre de caja
        if($_POST['operacion']=="ingreso"){
          $ingresocaja = new ingresoscajas($_POST);
          $ingresocaja->idusuario = $_SESSION['id'];
          $ingresocaja->id_cierrecaja = $ultimocierre->id;
          $ultimocierre->basecaja = $ultimocierre->basecaja + $ingresocaja->valor;
          $alertas = $ingresocaja->validar();
          if(empty($alertas)){
            $r = $ingresocaja->crear_guardar();
            if($r[0]){
              $r1 = $ultimocierre->actualizar();
              if($r1){
                $alertas['exito'][] = "Ingreso de dinero a caja es correcto";
              }else{
                $alertas['error'][] = "error al actualizar los ingresos en el cierre actual";
                /// borrar ultimo registro guardado de $ingresocaja
                $ingresocaja->eliminar_idregistros('id', [$r[1]]);
              }
            }else{
              $alertas['error'][] = "Error al guardar el ingreso de dinero a caja";
            }
          }
        }else{ // si la operacion es un gasto
          $ingresoGasto = new gastos($_POST);
          $ingresoGasto->idg_usuario = $_SESSION['id'];
          $ingresoGasto->idg_caja = $_POST['id_caja'];
          $ingresoGasto->idg_cierrecaja = $ultimocierre->id;
          $ultimocierre->gastoscaja = $ultimocierre->gastoscaja + $ingresoGasto->valor;
          ///// validar gastos de la caja en el modelo
          $alertas = $ingresoGasto->validar();
          if(empty($alertas)){
            $r = $ingresoGasto->crear_guardar();
            if($r[0]){
              $r1 = $ultimocierre->actualizar();
              if($r1){
                $alertas['exito'][] = "El gasto de la caja fue registrado correctamente";
              }else{
                $alertas['error'][] = "error al actualizar los gastos en el cierre de caja actual";
                /// borrar ultimo registro guardado de $ingresocaja
                $ingresoGasto->eliminar_idregistros('id', [$r[1]]);
              }
            }else{
              $alertas['error'][] = "Error al guardar el gasto de dinero de la caja";
            }
          }
        }

      }else{
        $alertas['error'][] = "Error al obtener el id del cierre de caja";
      }      
    }
    $facturas = facturas::all();
    $cajas = caja::all();
    $router->render('admin/caja/index', ['titulo'=>'Caja', 'cajas'=>$cajas, 'facturas'=>$facturas, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function zetadiario(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $ultimoscierres = cierrescajas::whereArray(['estado'=>1]);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    
    $router->render('admin/caja/zetadiario', ['titulo'=>'Caja', 'ultimoscierres'=>$ultimoscierres, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function ultimoscierres(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $ultimoscierres = cierrescajas::whereArray(['estado'=>1]);
    $router->render('admin/caja/ultimoscierres', ['titulo'=>'Caja', 'ultimoscierres'=>$ultimoscierres, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function detallecierrecaja(Router $router){
    session_start();
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;

    $alertas = [];
    $cierreselected = cierrescajas::uniquewhereArray(['id'=>$id, 'estado'=>1]);
    $facturas = facturas::idregistros('idcierrecaja', $cierreselected->id);
    $discriminarmediospagos = cierrescajas::discriminarmediospagos($cierreselected->id);
    $mediospagos = mediospago::all();
    $declaracion = declaracionesdineros::idregistros('idcierrecajaid', $cierreselected->id);
    //////////// mapeo de arreglo de valores declarados con el arreglo de los pagos discriminados /////////////
    $sobrantefaltante = $declaracion;
    foreach($discriminarmediospagos as $i => $dis){
      $aux = 0;
      foreach($declaracion as $j => $dec){
        if($dis['idmediopago'] == $dec->id_mediopago){
          $sobrantefaltante[$j]->valorsistema = $dis['valor'];
          $aux = 1;
          break;
        }
      }
      if($aux == 0){
        $newobj = new stdClass();
        $newobj->id_mediopago = $dis['idmediopago'];
        $newobj->idcierrecajaid = $cierreselected->id;
        $newobj->nombremediopago = $dis['mediopago'];
        $newobj->valordeclarado = 0;
        $newobj->valorsistema = $dis['valor'];
        $sobrantefaltante[] = $newobj;
      }
    }
    $router->render('admin/caja/detallecierrecaja', ['titulo'=>'Caja', 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'ultimocierre'=>$cierreselected, 'facturas'=>$facturas, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function ordenresumen(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();


    $factura = facturas::find('id', $id);
    $productos = ventas::idregistros('idfactura', $id);
    $cliente = clientes::find('id', $factura->idcliente);
    $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
    $tarifa = tarifas::find('id', $direccion->idtarifa);
    $vendedor = usuarios::find('id', $factura->idvendedor);

    $mediospago = mediospago::all();
    $cajas  = caja::all();
    $consecutivos = consecutivos::all();

    
    $router->render('admin/caja/ordenresumen', ['titulo'=>'Caja', 'factura'=>$factura, 'productos'=>$productos, 'cliente'=>$cliente, 'tarifa'=>$tarifa, 'direccion'=>$direccion, 'vendedor'=>$vendedor, 'mediospago'=>$mediospago, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function detalleorden(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();
    
    $router->render('admin/caja/detallepedidox', ['titulo'=>'Caja', 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function printfacturacarta(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();
    
    $router->render('admin/caja/printFacturaCarta', ['titulo'=>'Caja', 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }


  //////////////////////////----    API      ----////////////////////////////////

  ///////////  API REST llamada desde cerrarcaja.ts cuando se declara dinero  ////////////
  public static function declaracionDinero(){
    $alertas = [];
    $ax = false;
    $bx = false;
    $declaraciondinero = new declaracionesdineros($_POST);
    $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $declaraciondinero->idcierrecajaid = $ultimocierre->id;
      $alertas = $declaraciondinero->validar();
      if(empty($alertas)){
        $existevalor = $declaraciondinero::uniquewhereArray(['id_mediopago'=>$declaraciondinero->id_mediopago, 'idcierrecajaid'=>$ultimocierre->id]);
        if($existevalor){  //se actualiza el registro
          if($declaraciondinero->valordeclarado != 0){
            $existevalor->valordeclarado = $declaraciondinero->valordeclarado;
            $ax = $existevalor->actualizar();
          }else{ //si al declarar es cero
            $ax = $existevalor->eliminar_registro();
          }
        }else{   //crear registro
          $bx = $declaraciondinero->crear_guardar();
        }
        if($ax || $bx[0]){
          $alertas['exito'][] = "1";
        }
      }
    }
    echo json_encode($alertas);
  }


  public static function arqueocaja(){   
    $alertas = [];
    $arqueocaja = new arqueoscajas($_POST);
    $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
    $arqueocaja->id_cierrecajaid = $ultimocierre->id;
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $existe = arqueoscajas::uniquewhereArray(['id_cierrecajaid'=>$ultimocierre->id]);
      if(!$existe){ //si no existe arqueo
        $r = $arqueocaja->crear_guardar();
        if($r[0]){
          $alertas['exito'][] = "Arqueo de caja aplicado";
        }else{
          $alertas['error'][] = "Error intenta nuevamente";
        }
      }else{  //si ya existe arqueo actualizar
        $r1 = $existe->actualizar();
        if($r1){
          $alertas['exito'][] = "Arqueo de caja aplicado";
        }else{
          $alertas['error'][] = "Error intenta nuevamente";
        }
      }
    }
    echo json_encode($alertas);
  }


  public static function cierrecajaconfirmado(){  //// Api llamada desde cerrarcaja.ts
    session_start();
    isauth();
    $idcierrecaja = $_POST['idcierrecaja'];
    $nombrecaja = caja::uncampo('id', $idcierrecaja, 'nombre');
    $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      if($idcierrecaja == $ultimocierre->id && $ultimocierre->estado == 0){
        $ultimocierre->id_usuario = $_SESSION['id'];
        $ultimocierre->nombreusuario = $_SESSION['nombre'];
        $ultimocierre->fechacierre = date('Y-m-d H:i:s');
        $ultimocierre->dineroencaja = $ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja;
        $ultimocierre->realcaja = $ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja-$ultimocierre->domicilios;
        $ultimocierre->realventas = $ultimocierre->ingresoventas-$ultimocierre->totaldescuentos;
        $ultimocierre->totalbruto = $ultimocierre->ingresoventas;
        $ultimocierre->estado = 1;
        $crearcierrecaja = new cierrescajas(['idcaja'=>$idcierrecaja, 'nombrecaja'=>$nombrecaja, 'fechacierre'=>$ultimocierre->fechacierre]);
        $r = $crearcierrecaja->crear_guardar();
        if($r[0]){
          $r = $ultimocierre->actualizar();
          if($r){
            $alertas['exito'][] = "Cierre de caja realizado correctamente $ultimocierre->fechacierre";
          }else{
            $ultimocierrecaja = cierrescajas::find('id', $crearcierrecaja[1]);
            $ultimocierrecaja->eliminar_registro();
            $alertas['error'][] = "Error ingresa nuevamente al cierre de caja.";
          }
        }
      }else{
        $alertas['error'][] = "Error ingresa nuevamente al cierre de caja.";
      }
    }
    echo json_encode($alertas);
  }

}