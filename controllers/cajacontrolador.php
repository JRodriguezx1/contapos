<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use Model\usuarios; //namespace\clase hija
//use Model\negocio;
use Model\facturas;
use Model\cierrescajas;
use Model\ingresoscajas;
use Model\gastos;
use Model\caja;
use Model\declaracionesdineros;
use Model\mediospago;
use Model\factmediospago;
use Model\arqueoscajas;
use Model\bancos;
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

    $mediospago = mediospago::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }

    $ultimoscierres = cierrescajas::whereArray(['estado'=>0]);
    $datacierrescajas['ingresoventas'][] = 0;
    foreach($ultimoscierres as $value){
      $datacierrescajas['ids'][] = $value->id;
      $datacierrescajas['ingresoventas'][0] += $value->ingresoventas; 
    }

    $facturas = facturas::paginarwhere(' ', ' ', 'idcierrecaja', $datacierrescajas['ids']);
    //debuguear($facturas);
    $bancos = bancos::all();
    foreach($facturas as $value)
      $value->mediosdepago = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = $value->id;"); 
    

    $cajas = caja::all();
    $router->render('admin/caja/index', ['titulo'=>'Caja', 'datacierrescajas'=>$datacierrescajas['ingresoventas'][0], 'cajas'=>$cajas, 'bancos'=>$bancos, 'facturas'=>$facturas, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function cerrarcaja(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){  ///if se puede eliminar
            
    }
  
    $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>1]); //ultimo cierre por caja
    $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
    $discriminarmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);
    $ventasxusuarios = cierrescajas::ventasXusuario($ultimocierre->id);
    $mediospagos = mediospago::all();  //se usa para la declaracion de valores.
    $declaracion = declaracionesdineros::idregistros('idcierrecajaid', $ultimocierre->id);
    //////////// mapeo de arreglo de valores declarados con el arreglo de los pagos discriminados /////////////
    $sobrantefaltante = $declaracion;
    foreach($discriminarmediospagos as $i => $dis){
      if($dis['idmediopago'] == 1)$dis['valor'] += ($ultimocierre->basecaja - $ultimocierre->gastoscaja);
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
        $newobj->valordeclarado = 0;   // si no coincide el medio de pago del sistema con el declarado coloca 0
        $newobj->valorsistema = $dis['valor']; // si no coincide el medio de pago del sistema con el declarado coloca 0
        $sobrantefaltante[] = $newobj;
      }
    }
    foreach($facturas as $value)
      $value->mediosdepago = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = $value->id;");
    $cajas = caja::all();
    $router->render('admin/caja/cerrarcaja', ['titulo'=>'Caja', 'cajas'=>$cajas, 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'ultimocierre'=>$ultimocierre, 'facturas'=>$facturas, 'ventasxusuarios'=>$ventasxusuarios, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  
//////// ingreso de base o gasto de caja tambien como apertura /////////
  public static function ingresoGastoCaja(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $mediospago = mediospago::all();
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      //$ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
      $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['id_caja']]); //ultimo cierre por caja
      if(!isset($ultimocierre)){ // si la caja esta cerrada y luego aqui se hace apertura
        $ultimocierre = new cierrescajas(['idcaja'=>$_POST['id_caja'], 'nombrecaja'=>caja::find('id', $_POST['id_caja'])->nombre, 'estado'=>0]);
        $r = $ultimocierre->crear_guardar();
        if(!$r[0])$ultimocierre->estado = 1;
        $ultimocierre->id = $r[1];
      }

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
          $ingresoGasto->idg_cierrecaja = $ultimocierre->id;
          if($_POST['origengasto'] == 'gastocaja'){
            $ingresoGasto->idg_caja = $_POST['id_caja'];
            $ultimocierre->gastoscaja = $ultimocierre->gastoscaja + $ingresoGasto->valor;
          }else{ //si el gasto sale de un banco
            $ingresoGasto->idg_caja = $_POST['id_caja'];
            $ingresoGasto->id_banco = $_POST['id_banco'];
            $ultimocierre->gastosbanco = $ultimocierre->gastosbanco + $ingresoGasto->valor;
            $ingresoGasto->tipo_origen = 1; //1 = banco. origen del gasto es banco
          }
          ///// validar gastos en el modelo
          $alertas = $ingresoGasto->validar();
          if(empty($alertas)){
            $r = $ingresoGasto->crear_guardar();
            if($r[0]){
              $r1 = $ultimocierre->actualizar();
              if($r1){
                $alertas['exito'][] = "El gasto fue registrado correctamente";
              }else{
                $alertas['error'][] = "error al actualizar los gastos en el cierre de caja actual";
                /// borrar ultimo registro guardado de $ingresocaja
                $ingresoGasto->eliminar_idregistros('id', [$r[1]]);
              }
            }else{
              $alertas['error'][] = "Error al guardar el gasto de dinero";
            }
          }
        }
      }else{
        $alertas['error'][] = "Error al obtener el id del cierre de caja";
      }      
    }
    $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
    foreach($facturas as $value)
      $value->mediosdepago = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = $value->id;"); 
    $cajas = caja::all();
    $bancos = bancos::all();
    $router->render('admin/caja/index', ['titulo'=>'Caja', 'cajas'=>$cajas, 'bancos'=>$bancos, 'facturas'=>$facturas, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function zetadiario(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $ultimoscierres = cierrescajas::whereArray(['estado'=>1]);
    $idultimocierreabierto = cierrescajas::uncampo('estado', 0, 'id');
    $router->render('admin/caja/zetadiario', ['titulo'=>'Caja', 'ultimoscierres'=>$ultimoscierres, 'idultimocierreabierto'=>$idultimocierreabierto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function fechazetadiario(Router $router){
    session_start();
    isadmin();
    $id = $_GET['id'];
    if(!is_numeric($id))return;

    $alertas = [];
    $discriminarmediospagos = [];
    $cajas = caja::all();
    $consecutivos = consecutivos::all();
    $cajaselected = '';
    
    $cierreselected = cierrescajas::find('id', $id);
    if($cierreselected != null){
      $discriminarmediospagos = cierrescajas::discriminarmediospagos($cierreselected->id);
      $cajaselected = caja::find('id', $cierreselected->idcaja)->nombre; 
    }else{
      foreach($cajas as $index => $value){
        if(array_key_last($cajas) == $index){
          $cajaselected .= $value->nombre;
        }else{
          $cajaselected .= $value->nombre.' - ';
        }
      }
    }
    $router->render('admin/caja/fechazetadiario', ['titulo'=>'Caja', 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'cierreselected'=>$cierreselected, 'cajaselected'=>$cajaselected, 'discriminarmediospagos'=>$discriminarmediospagos, 'alertas'=>$alertas, 'user'=>$_SESSION]);
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
    $ventasxusuarios = cierrescajas::ventasXusuario($cierreselected->id);
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
    $router->render('admin/caja/detallecierrecaja', ['titulo'=>'Caja', 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'ultimocierre'=>$cierreselected, 'ventasxusuarios'=>$ventasxusuarios, 'facturas'=>$facturas, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function pedidosguardados(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $pedidosguardados = facturas::whereArray(['cotizacion'=>1, 'estado'=>'guardado']);
    $router->render('admin/caja/pedidosguardados', ['titulo'=>'Caja', 'pedidosguardados'=>$pedidosguardados, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
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
    if($factura->iddireccion){
      $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
    }else{
      $direccion = direcciones::find('id', 1);
    }
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
    $factura = facturas::find('id', $id);
     $productos = ventas::idregistros('idfactura', $id);
    $cliente = clientes::find('id', $factura->idcliente);
    $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
    $tarifa = tarifas::find('id', $direccion->idtarifa);
    $vendedor = usuarios::find('id', $factura->idvendedor);

    $router->render('admin/caja/printFacturaCarta', ['titulo'=>'Impresion factura', 'factura'=>$factura, 'productos'=>$productos, 'cliente'=>$cliente, 'tarifa'=>$tarifa, 'direccion'=>$direccion, 'vendedor'=>$vendedor, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }

  public static function printcotizacion(Router $router){
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

    $router->render('admin/caja/printcotizacion', ['titulo'=>'Impresion cotizacion', 'factura'=>$factura, 'productos'=>$productos, 'cliente'=>$cliente, 'tarifa'=>$tarifa, 'direccion'=>$direccion, 'vendedor'=>$vendedor, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }

  public static function printdetallecierre(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();
    
    $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>1]); //ultimo cierre por caja
    $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
    $discriminarmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);
    $ventasxusuarios = cierrescajas::ventasXusuario($ultimocierre->id);
    $mediospagos = mediospago::all();  //se usa para la declaracion de valores.
    $declaracion = declaracionesdineros::idregistros('idcierrecajaid', $ultimocierre->id);
    //////////// mapeo de arreglo de valores declarados con el arreglo de los pagos discriminados /////////////
    $sobrantefaltante = $declaracion;
    foreach($discriminarmediospagos as $i => $dis){
      if($dis['idmediopago'] == 1)$dis['valor'] += ($ultimocierre->basecaja - $ultimocierre->gastoscaja);
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
        $newobj->valordeclarado = 0;   // si no coincide el medio de pago del sistema con el declarado coloca 0
        $newobj->valorsistema = $dis['valor']; // si no coincide el medio de pago del sistema con el declarado coloca 0
        $sobrantefaltante[] = $newobj;
      }
    }
    
    
    $router->render('admin/caja/printdetallecierre', ['titulo'=>'detalle cierre Caja', 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'ultimocierre'=>$ultimocierre, 'facturas'=>$facturas, 'ventasxusuarios'=>$ventasxusuarios, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }


  //////////////////////////----    API      ----////////////////////////////////

  ///////////  API REST llamada desde cerrarcaja.ts cuando se declara dinero  ////////////
  public static function declaracionDinero(){
    $alertas = [];
    $ax = false;
    $bx = false;
    $declaraciondinero = new declaracionesdineros($_POST);
    $ultimocierre = cierrescajas::find('id', $_POST['idcierrecaja']); ////// ultimo registro de cierrescajas validar si esta abierto
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $declaraciondinero->idcierrecajaid = $ultimocierre->id;
      $alertas = $declaraciondinero->validar();
      if($ultimocierre->estado == 1)$alertas['error'][] = "Error!, ingresa nuevamente al modulo de caja para validar que la caja este ya cerrada.";
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
    $ultimocierre = cierrescajas::find('id', $_POST['idcierrecaja']); ////// ultimo registro de cierrescajas validar si esta abierto
    $arqueocaja->id_cierrecajaid = $ultimocierre->id;
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      if($ultimocierre->estado == 1){
        $alertas['error'][] = "Error!, ingresa nuevamente al modulo de caja para validar que la caja este ya cerrada.";
      }else{
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
    }
    echo json_encode($alertas);
  }


  public static function cierrecajaconfirmado(){  //// Api llamada desde cerrarcaja.ts
    session_start();
    isauth();
    $idcierrecaja = $_POST['idcierrecaja'];
    $ultimocierre = cierrescajas::find('id', $idcierrecaja);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      if($ultimocierre->estado == 0){
        $ultimocierre->id_usuario = $_SESSION['id'];
        $ultimocierre->nombreusuario = $_SESSION['nombre'];
        $ultimocierre->fechacierre = date('Y-m-d H:i:s');
        $ultimocierre->dineroencaja = $ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja;
        $ultimocierre->realcaja = $ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja-$ultimocierre->domicilios;
        $ultimocierre->realventas = $ultimocierre->ingresoventas-$ultimocierre->totaldescuentos;
        $ultimocierre->totalbruto = $ultimocierre->ingresoventas;
        $ultimocierre->estado = 1; //cerrar caja
        // crear el siguiente cierre de caja
        $crearcierrecaja = new cierrescajas(['idcaja'=>$ultimocierre->idcaja, 'nombrecaja'=>$ultimocierre->nombrecaja, 'fechacierre'=>$ultimocierre->fechacierre]);
        $r = $crearcierrecaja->crear_guardar();
        if($r[0]){
          $r = $ultimocierre->actualizar();
          if($r){
            $alertas['exito'][] = "Cierre de caja realizado correctamente $ultimocierre->fechacierre";
            $alertas['ultimocierre'][] = $ultimocierre->id;
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


  // cuando se cambia la caja para ver y cerrar la caja
  public static function datoscajaseleccionada(){ //llamado desde cerrarcaja.ts
    $alertas = [];

    $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idcaja']]); //ultimo cierre por caja
    $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
    $discriminarmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);  //lo que el sistema registra
    $ventasxusuarios = cierrescajas::ventasXusuario($ultimocierre->id);
    //$mediospagos = mediospago::all();
    $declaracion = declaracionesdineros::idregistros('idcierrecajaid', $ultimocierre->id);  //lo que el usuario declara de forma manual.
    //////////// mapeo de arreglo de valores declarados con el arreglo de los pagos discriminados /////////////
    
    $sobrantefaltante = $declaracion;
    foreach($discriminarmediospagos as $i => $dis){
      if($dis['idmediopago'] == 1)$dis['valor'] += ($ultimocierre->basecaja - $ultimocierre->gastoscaja);
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
        $newobj->valordeclarado = 0;   // si no coincide el medio de pago del sistema con el declarado coloca 0
        $newobj->valorsistema = $dis['valor']; // si no coincide el medio de pago del sistema con el declarado coloca 0
        $sobrantefaltante[] = $newobj;
      }
    }

    foreach($facturas as $value)
      $value->mediosdepago = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = $value->id;");
    
    //$cajas = caja::all();
    $alertas['exito'][] = "Cambio de caja.";
    $alertas['ultimocierre'] = $ultimocierre;
    $alertas['discriminarmediospagos'] = $discriminarmediospagos;
    $alertas['facturas'] = $facturas;
    $alertas['ventasxusuarios'] = $ventasxusuarios;
    //$alertas['mediospagos'] = $mediospagos;
    $alertas['sobrantefaltante'] = $sobrantefaltante;
    echo json_encode($alertas);
  }

  public static function mediospagoXfactura(){  //api llamado desde caja.js me trae los medios de pago segun factura
    $id = $_GET['id'];
    $factmediospago = factmediospago::idregistros('id_factura', $id);
    echo json_encode($factmediospago);
  }


  public static function cambioMedioPago(){  //api llamado desde caja.js me actualiza los medios de pago
    $alertas = [];
    $idfactura = $_POST['id_factura'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $ultimocierre = cierrescajas::find('id', facturas::find('id', $idfactura)->idcierrecaja); ////// ultimo registro de cierrescajas validar si esta abierto
      if($ultimocierre->estado == 0){  //validar que el ultimo cierre de caja este abierto

        $nuevosmediospago = json_decode($_POST['nuevosMediosPago']);
        //// obtener los medios de pago de la base de datos segun factura
        ////cruzar con los nuevos medios de pago
        //// si los medios de pagos son iguales actualizar

        //// si los nuevos medios de pago no estan en la base de datos, crearlos
        //// si los medios de pago de la DB no estan en los nuevos medios de pago, elminarlos
        //// Obtener los muevos medios de pago de la factura y enviarla como respuesta

        $mediospagoDB = factmediospago::idregistros('id_factura', $idfactura);

        if(count($nuevosmediospago) >= count($mediospagoDB)){
          foreach($mediospagoDB as $index => $value){
            $value->idmediopago = $nuevosmediospago[$index]->idmediopago;
            $value->valor = $nuevosmediospago[$index]->valor;
          }
          //actualizar $mediospagoDB
          $ac = factmediospago::updatemultiregobj($mediospagoDB, ['idmediopago', 'valor']);
          if($ac){
            $alertas['exito'][] = "Cambio de medios de pago aplicados.";
          }else{
            $alertas['error'][] = "Error al cambiar los medios de pago, intenta nuevamente.";
          }
        }
      
        if(count($nuevosmediospago)>count($mediospagoDB)){
          $crearMP=[];
          $j=0;
          for($i = count($mediospagoDB); $i<count($nuevosmediospago); $i++){
            $crearMP[$j]['id_factura'] = $mediospagoDB[0]->id_factura;
            $crearMP[$j]['idmediopago'] = $nuevosmediospago[$i]->idmediopago;
            $crearMP[$j]['valor'] = $nuevosmediospago[$i]->valor;
            $j++;
          }
          //// crear $crearMP
          if($ac){
            $crearMediosPago = new factmediospago();
            $cmp = $crearMediosPago->crear_varios_reg($crearMP);
            if(!$cmp){
              /// revertir la actualizacion
              $alertas['error'][] = "Error al cambiar los medios de pago, intenta nuevamente.";
            }
          }
        }

        if(count($nuevosmediospago)<count($mediospagoDB)){
          foreach($mediospagoDB as $index => $value){
            if($index < count($nuevosmediospago)){
              $value->idmediopago = $nuevosmediospago[$index]->idmediopago;
              $value->valor = $nuevosmediospago[$index]->valor;
            }
            if($index>=count($nuevosmediospago))$arrayeliminar[] = $value->id;
          }
          //actualizar $mediospagoDB
          //eliminar los medios de pago sobrantes de la DB $arrayeliminar
          $ac = factmediospago::updatemultiregobj($mediospagoDB, ['idmediopago', 'valor']);
          if($ac){
            $elminarMP = factmediospago::eliminar_idregistros('id', $arrayeliminar);
            if($elminarMP){
              $alertas['exito'][] = "Cambio de medios de pago aplicados.";
            }else{
              /// revertir la actualizacion
              $alertas['error'][] = "Error al cambiar los medios de pago, intenta nuevamente.";
            }
          }else{
            $alertas['error'][] = "Error al cambiar los medios de pago, intenta nuevamente.";
          }
        }

        /////////// Recalcular el efectivo del cierre de caja /////////////
        if((int)$_POST['efectivoDB']!=(int)$_POST['nuevoEfectivo']){ //
          $efectivo = (int)$_POST['nuevoEfectivo'] - (int)$_POST['efectivoDB'];
          $ultimocierre->ventasenefectivo = $ultimocierre->ventasenefectivo + $efectivo;
          $ru = $ultimocierre->actualizar();
        }

        $alertas['mediosPagoUpdate'] = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = $idfactura;");
      } //fin cierradecaja abierto
    } //fin SERVER == $_POS

    echo json_encode($alertas);
  }

  public static function eliminarPedidoGuardado(){
    session_start();
      $pedidoguardado = facturas::find('id', $_POST['id']);
      if($_SERVER['REQUEST_METHOD'] === 'POST' ){
          if(!empty($pedidoguardado)){
            $pedidoguardado->estado = "Eliminada";
              $r = $pedidoguardado->actualizar();
              if($r){
                  ActiveRecord::setAlerta('exito', 'Cotizacion eliminada correctamente');
              }else{
                  ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
              }
          }else{
              ActiveRecord::setAlerta('error', 'Cotizacion no encontrado');
          }
      }
      $alertas = ActiveRecord::getAlertas();
      echo json_encode($alertas); 
  }

}