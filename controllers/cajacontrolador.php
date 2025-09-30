<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use Model\configuraciones\usuarios; //namespace\clase hija
//use Model\configuraciones\negocio;
use Model\ventas\facturas;
use Model\caja\cierrescajas;
use Model\caja\ingresoscajas;
use Model\gastos;
use Model\configuraciones\caja;
use Model\caja\declaracionesdineros;
use Model\configuraciones\mediospago;
use Model\caja\factmediospago;
use Model\caja\arqueoscajas;
use Model\configuraciones\bancos;
use Model\clientes\clientes;
use Model\clientes\direcciones;
use Model\configuraciones\tarifas;
use Model\ventas\ventas;
use Model\configuraciones\consecutivos;
use Model\parametrizacion\config_local;
use Model\configuraciones\negocio;
use Model\sucursales;
use MVC\Router;  //namespace\clase
use stdClass;

class cajacontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];

    $mediospago = mediospago::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }

    $ultimoscierres = cierrescajas::whereArray(['idsucursal_id'=>id_sucursal(), 'estado'=>0]);
    $datacierrescajas['ingresoventas'][] = 0;
    foreach($ultimoscierres as $value){
      if($value->ingresoventas>0 || $value->totalcotizaciones>0){
        $datacierrescajas['ids'][] = $value->id;
        $datacierrescajas['ingresoventas'][0] += $value->ingresoventas;
      } 
    }

    
    $facturas = [];
    if(!empty($ultimoscierres)&&isset($datacierrescajas['ids']))$facturas = facturas::IN_Where('idcierrecaja', $datacierrescajas['ids'], ['id_sucursal', id_sucursal()]);
    //debuguear($facturas);
    $bancos = bancos::all();
    foreach($facturas as $value)
      $value->mediosdepago = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = $value->id;"); 
    

    $cajas = caja::idregistros('idsucursalid', id_sucursal());
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/caja/index', ['titulo'=>'Caja', 'conflocal'=>$conflocal, 'sucursal'=>nombreSucursal(), 'datacierrescajas'=>$datacierrescajas['ingresoventas'][0], 'cajas'=>$cajas, 'bancos'=>$bancos, 'facturas'=>$facturas, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function cerrarcaja(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $idsucursal = id_sucursal();
    $cajas = caja::idregistros('idsucursalid', $idsucursal);

    //calcular el id de la caja princial de la sucursal
    $idcajaprincipal = $cajas[0]->id;
    foreach($cajas as $value){
      if($value->editable == 0){
        $idcajaprincipal = $value->id;
        break;
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){  ///if se puede eliminar
            
    }
  
    $mediospagos = mediospago::all();  //se usa para la declaracion de valores.
    $facturas = []; $discriminarmediospagos=[]; $discriminarimpuesto=[]; $ventasxusuarios=[]; $sobrantefaltante=[];
    $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$idcajaprincipal, 'idsucursal_id'=>id_sucursal()]); //ultimo cierre por caja
    if(isset($ultimocierre)){
      $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
      $discriminarmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);
      $discriminarimpuesto = cierrescajas::discriminarimpuesto($ultimocierre->id);
      $ventasxusuarios = cierrescajas::ventasXusuario($ultimocierre->id);
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
    }
    
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/caja/cerrarcaja', ['titulo'=>'Caja', 'conflocal'=>$conflocal, 'cajas'=>$cajas, 'discriminarimpuesto'=>$discriminarimpuesto, 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'ultimocierre'=>$ultimocierre, 'facturas'=>$facturas, 'ventasxusuarios'=>$ventasxusuarios, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  
//////// ingreso de base o gasto de caja tambien como apertura /////////
  public static function ingresoGastoCaja(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $mediospago = mediospago::all();
    
    $valor = str_replace('.', '', $_POST['valor']); // quita los puntos
     $_POST['valor'] = (int)$valor;
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['id_caja'], 'idsucursal_id'=>id_sucursal()]); //ultimo cierre por caja
      if(!isset($ultimocierre)){ // si la caja esta cerrada y luego aqui se hace apertura
        $ultimocierre = new cierrescajas(['idcaja'=>$_POST['id_caja'], 'nombrecaja'=>caja::find('id', $_POST['id_caja'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
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
    //todas las facturas que pertenecen a la sede con los cierres de caja abierto
    
    $ultimoscierres = cierrescajas::whereArray(['idsucursal_id'=>id_sucursal(), 'estado'=>0]);
    $datacierrescajas['ingresoventas'][] = 0;
    foreach($ultimoscierres as $value){
      if($value->ingresoventas>0 || $value->totalcotizaciones>0){
        $datacierrescajas['ids'][] = $value->id;
        $datacierrescajas['ingresoventas'][0] += $value->ingresoventas;
      }
    }
    $facturas = [];
    if(!empty($ultimoscierres))$facturas = facturas::IN_Where('idcierrecaja', $datacierrescajas['ids'], ['id_sucursal', id_sucursal()]);

    foreach($facturas as $value)
      $value->mediosdepago = ActiveRecord::camposJoinObj("SELECT * FROM factmediospago JOIN mediospago ON factmediospago.idmediopago = mediospago.id WHERE id_factura = $value->id;"); 
    $cajas = caja::idregistros('idsucursalid', id_sucursal());
    $bancos = bancos::all();
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/caja/index', ['titulo'=>'Caja', 'conflocal'=>$conflocal, 'sucursal'=>nombreSucursal(), 'datacierrescajas'=>$datacierrescajas['ingresoventas'][0], 'cajas'=>$cajas, 'bancos'=>$bancos, 'facturas'=>$facturas, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function zetadiario(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $ultimoscierres = cierrescajas::whereArray(['estado'=>1, 'idsucursal_id'=>id_sucursal()]);
    //$idultimocierreabierto = cierrescajas::uniquewhereArray(['estado'=>0, 'idsucursal_id'=>id_sucursal()]);
    //if($idultimocierreabierto){
      //$idultimocierreabierto = $idultimocierreabierto->id;
    //}else{
      $idultimocierreabierto = -1;
    //}
    //Hay que sumar los ultimos cierres de caja abierto por sucursal = $idultimocierreabierto
    $router->render('admin/caja/zetadiario', ['titulo'=>'Caja', 'ultimoscierres'=>$ultimoscierres, 'idultimocierreabierto'=>$idultimocierreabierto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  //cuando se da clic en el btn "zeta diario de hoy" o en el btn "zeta diario por fecha"
  public static function fechazetadiario(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $id = $_GET['id'];
    if(!is_numeric($id))return;

    $alertas = [];
    $discriminarimpuestos = [];
    $discriminarmediospagos = [];
    $cajas = caja::idregistros('idsucursalid', id_sucursal());
    $consecutivos = consecutivos::whereArray(['id_sucursalid'=>id_sucursal(), 'estado'=>1]);
    $cajaselected = '';
    $cierreselected = new stdClass();
    $cierreselected->ingresoventas = 0;
    $cierreselected->valorimpuestototal = 0;
    $cierreselected->facturaselectronicas = 0;
    $cierreselected->facturaspos = 0;

    if($id == -1){ //-1 es para zeta diario de hoy
      // sumar todos los valores de las cajas abiertas
      $cierreselected = cierrescajas::whereArray(['estado'=>0, 'idsucursal_id'=>id_sucursal()]);
      $cierreselected = array_reduce($cierreselected, function($acumulador, $obj){
        $acumulador['ingresoventas'] += $obj->ingresoventas;
        $acumulador['valorimpuestototal'] += $obj->valorimpuestototal;
        $acumulador['totaldescuentos'] += $obj->totaldescuentos;
        $acumulador['realventas'] += $obj->realventas;
        $acumulador['facturaselectronicas'] += $obj->facturaselectronicas;
        $acumulador['facturaspos'] += $obj->facturaspos;
        $acumulador['valorfe'] += $obj->valorfe;
        $acumulador['valorpos'] += $obj->valorpos;
        $acumulador['id'][] = $obj->id;
        $acumulador['nombrecaja'] .= $obj->nombrecaja.' ';
        return $acumulador;
      }, ['id'=>[], 'nombrecaja'=>'', 'ingresoventas'=>0, 'valorimpuestototal'=>0, 'totaldescuentos'=>0, 'realventas'=>0, 'facturaselectronicas'=>0, 'facturaspos'=>0, 'valorfe'=>0, 'valorpos'=>0]);
      
      $cierreselected = (object)$cierreselected;
      if(!empty($cierreselected->id)){
        $discriminarmediospagos = cierrescajas::discriminarmediospagoscajas($cierreselected->id);
        $discriminarimpuestos = cierrescajas::discriminarimpuestocaja($cierreselected->id);
        $cajaselected = $cierreselected->nombrecaja;
      }else{
        foreach($cajas as $index => $value){
          if(array_key_last($cajas) == $index){
            $cajaselected .= $value->nombre;
          }else{
            $cajaselected .= $value->nombre.' - ';
          }
        }
      }
    }
    $router->render('admin/caja/fechazetadiario', ['titulo'=>'Caja', 'cajas'=>$cajas, 'discriminarimpuestos'=>$discriminarimpuestos, 'consecutivos'=>$consecutivos, 'cierreselected'=>$cierreselected, 'cajaselected'=>$cajaselected, 'discriminarmediospagos'=>$discriminarmediospagos, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }


  public static function ultimoscierres(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $ultimoscierres = cierrescajas::whereArray(['estado'=>1, 'idsucursal_id'=>id_sucursal()]);
    $router->render('admin/caja/ultimoscierres', ['titulo'=>'Caja', 'ultimoscierres'=>$ultimoscierres, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function detallecierrecaja(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $id = $_GET['id'];
    if(!is_numeric($id))return;

    $alertas = [];
    $cierreselected = cierrescajas::uniquewhereArray(['id'=>$id, 'estado'=>1]);
    $facturas = facturas::idregistros('idcierrecaja', $cierreselected->id);
    $discriminarmediospagos = cierrescajas::discriminarmediospagos($cierreselected->id);
    $discriminarimpuesto = cierrescajas::discriminarimpuesto($cierreselected->id);
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
    $router->render('admin/caja/detallecierrecaja', ['titulo'=>'Caja', 'discriminarimpuesto'=>$discriminarimpuesto, 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'ultimocierre'=>$cierreselected, 'ventasxusuarios'=>$ventasxusuarios, 'facturas'=>$facturas, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function pedidosguardados(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $pedidosguardados = facturas::whereArray(['cotizacion'=>1, 'estado'=>'guardado', 'id_sucursal'=>id_sucursal()]);
    $router->render('admin/caja/pedidosguardados', ['titulo'=>'Caja', 'pedidosguardados'=>$pedidosguardados, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function ordenresumen(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $id = $_GET['id']; //id de la cotizacion
    if(!is_numeric($id))return;
    $idsucursal = id_sucursal();
    //$alertas = usuarios::getAlertas();


    $factura = facturas::uniquewhereArray(['id'=>$id, 'id_sucursal'=>$idsucursal]);
    if($factura){
      $productos = ventas::idregistros('idfactura', $id);
      $cliente = clientes::find('id', $factura->idcliente);
      if($factura->iddireccion){
        $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
      }else{
        $direccion = direcciones::find('id', 1);
      }
      $tarifa = tarifas::find('id', $direccion->idtarifa);
      $vendedor = usuarios::find('id', $factura->idvendedor);
    }

    $mediospago = mediospago::all();
    $cajas = caja::idregistros('idsucursalid', $idsucursal);
    $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);

    $conflocal = config_local::getParamCaja();
    $router->render('admin/caja/ordenresumen', ['titulo'=>'Caja', 'factura'=>$factura, 'productos'=>$productos, 'cliente'=>$cliente, 'tarifa'=>$tarifa, 'direccion'=>$direccion, 'vendedor'=>$vendedor, 'mediospago'=>$mediospago, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function detalleorden(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();
    
    $router->render('admin/caja/detallepedidox', ['titulo'=>'Caja', 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function printfacturacarta(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();
    $factura = facturas::find('id', $id);
    $productos = ventas::idregistros('idfactura', $id);
    $cliente = clientes::find('id', $factura->idcliente);
    $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
    if(!$direccion)$direccion = direcciones::find('id', 1);
    $tarifa = tarifas::find('id', $direccion->idtarifa);
    $vendedor = usuarios::find('id', $factura->idvendedor);
    $negocio = negocio::get(1);
    $lineasencabezado = explode("\n", $negocio[0]->datosencabezados);
    $sucursal = sucursales::find('id', id_sucursal());
    $sql="SELECT mediospago.* FROM facturas JOIN factmediospago ON factmediospago.id_factura = facturas.id 
          JOIN mediospago ON mediospago.id = factmediospago.idmediopago WHERE facturas.id = {$factura->id};";
    $mediospago = ActiveRecord::camposJoinObj($sql);
    $router->render('admin/caja/printFacturaCarta', ['titulo'=>'Impresion factura', 'factura'=>$factura, 'productos'=>$productos, 'cliente'=>$cliente, 'tarifa'=>$tarifa, 'direccion'=>$direccion, 'vendedor'=>$vendedor, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'sucursal'=>$sucursal, 'negocio'=>$negocio, 'lineasencabezado'=>$lineasencabezado, 'user'=>$_SESSION]);
  }

  public static function printcotizacion(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();
    $factura = facturas::find('id', $id);
     $productos = ventas::idregistros('idfactura', $id);
    $cliente = clientes::find('id', $factura->idcliente);
    $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
    if(!$direccion)$direccion = direcciones::find('id', 1);
    $tarifa = tarifas::find('id', $direccion->idtarifa);
    $vendedor = usuarios::find('id', $factura->idvendedor);
    $negocio = negocio::get(1);
    $lineasencabezado = explode("\n", $negocio[0]->datosencabezados);
    $sucursal = sucursales::find('id', id_sucursal());
    $router->render('admin/caja/printcotizacion', ['titulo'=>'Impresion cotizacion', 'factura'=>$factura, 'productos'=>$productos, 'cliente'=>$cliente, 'tarifa'=>$tarifa, 'direccion'=>$direccion, 'vendedor'=>$vendedor, 'alertas'=>$alertas, 'sucursal'=>$sucursal, 'negocio'=>$negocio, 'lineasencabezado'=>$lineasencabezado, 'user'=>$_SESSION]);
  }

  public static function printdetallecierre(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de caja')&&userPerfil()>3)return;
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id))return;
    //$alertas = usuarios::getAlertas();
    
    $ultimocierre = cierrescajas::find('id', $id);
    $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
    $discriminarmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);
    $discriminarimpuesto = cierrescajas::discriminarimpuesto($ultimocierre->id);
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
    
    $negocio = negocio::get(1);
    $lineasencabezado = explode("\n", $negocio[0]->datosencabezados);
    
    $router->render('admin/caja/printdetallecierre', ['titulo'=>'detalle cierre Caja', 'sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'discriminarimpuesto'=>$discriminarimpuesto, 'ultimocierre'=>$ultimocierre, 'facturas'=>$facturas, 'ventasxusuarios'=>$ventasxusuarios, 'alertas'=>$alertas, 'negocio'=>$negocio, 'lineasencabezado'=>$lineasencabezado, 'user'=>$_SESSION]);
  }


  //////////////////////////----    API      ----////////////////////////////////

  ///////////  API REST llamada desde cerrarcaja.ts cuando se declara dinero  ////////////
  public static function declaracionDinero(){
    session_start();
    isadmin();
    $alertas = [];
    $ax = false;
    $bx = false;
    $declaraciondinero = new declaracionesdineros($_POST);
    $ultimocierre = cierrescajas::uniquewhereArray(['id'=>$_POST['idcierrecaja'], 'idsucursal_id'=>id_sucursal()]); ////// ultimo registro de cierrescajas validar si esta abierto
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
    session_start();
    isadmin();
    $alertas = [];
    $arqueocaja = new arqueoscajas($_POST);
    $ultimocierre = cierrescajas::uniquewhereArray(['id'=>$_POST['idcierrecaja'], 'idsucursal_id'=>id_sucursal()]); ////// ultimo registro de cierrescajas validar si esta abierto
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

    $conflocal = config_local::getParamCaja();
    $idcierrecaja = $_POST['idcierrecaja'];
    $ultimocierre = cierrescajas::find('id', $idcierrecaja);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      if($ultimocierre->estado == 0){

        //////// PERMISO DE CIERRE DE CAJA CON VENTAS PENDIENTES /////////
        if($conflocal['permitir_cierre_de_caja_con_ordenes_sin_pagar']->valor_final == 0){
          $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);
          foreach($facturas as $value){
            if($value->cotizacion == 1 && $value->cambioaventa == 0){
              $alertas['error'][] = "No se puede hacer cierre de caja con ventas pendientes.";
              echo json_encode($alertas);
              return;
            }
          }
        }

        $ultimocierre->id_usuario = $_SESSION['id'];
        $ultimocierre->nombreusuario = $_SESSION['nombre'];
        $ultimocierre->fechacierre = date('Y-m-d H:i:s');
        $ultimocierre->dineroencaja = $ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja;
        $ultimocierre->realcaja = $ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja-$ultimocierre->domicilios;
        $ultimocierre->realventas = $ultimocierre->ingresoventas-$ultimocierre->totaldescuentos;
        $ultimocierre->totalbruto = $ultimocierre->ingresoventas;
        $ultimocierre->estado = 1; //cerrar caja
        // crear el siguiente cierre de caja
        $crearcierrecaja = new cierrescajas(['idsucursal_id'=>id_sucursal(), 'idcaja'=>$ultimocierre->idcaja, 'nombrecaja'=>$ultimocierre->nombrecaja, 'fechacierre'=>$ultimocierre->fechacierre]);
        $r = $crearcierrecaja->crear_guardar();
        if($r[0]){
          $ra = $ultimocierre->actualizar();
          if($ra){
            $alertas['exito'][] = "Cierre de caja realizado correctamente $ultimocierre->fechacierre";
            $alertas['ultimocierre'][] = $ultimocierre->id;
          }else{
            $ultimocierrecaja = cierrescajas::find('id', $r[1]);
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
    session_start();
    isadmin();
    $alertas = [];

    $ultimocierre = cierrescajas::uniquewhereArray(['idsucursal_id'=>id_sucursal(), 'estado'=>0, 'idcaja'=>$_POST['idcaja']]); //ultimo cierre por caja
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