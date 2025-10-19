<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use Model\configuraciones\usuarios; //namespace\clase hija
use Model\inventario\productos;
use Model\inventario\subproductos;
use Model\inventario\productos_sub;
use Model\inventario\categorias;
Use Model\inventario\unidadesmedida;
use Model\inventario\conversionunidades;
use Model\inventario\detalletrasladoinv;
use Model\inventario\proveedores;
use Model\inventario\stockinsumossucursal;
use Model\inventario\stockproductossucursal;
use Model\inventario\traslado_inv;
use Model\parametrizacion\config_local;
use Model\sucursales;
use MVC\Router;  //namespace\clase
use stdClass;

class trasladosinvcontrolador{


//VER DETALLE DE SOLICITUDES RECIBIDAS DE QUE VIENE MERCANCIA O DE QUE DEBO DESPACHAR
  public static function solicitudesrecibidas(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    $pendientes = 0;
    $aprobadas = 0;
    $rechazadas = 0;
    $entregadas = 0;
    $entransito = 0;

    $sucursales = sucursales::idregistros('estado', 1);
    $solicitudesrecividas = traslado_inv::idregistros('id_sucursaldestino', id_sucursal());
    foreach($solicitudesrecividas as $value){
      //$value->sucursalorigen = sucursales::uncampo('id', $value->id_sucursalorigen, 'nombre');
      foreach($sucursales as $s){
        if($value->id_sucursalorigen == $s->id){
          $value->sucursalorigen = $s->nombre;
          break;
        }
      }
      $nombreusuario = usuarios::find('id', $value->fkusuario);
      $value->usuario = $nombreusuario->nombre.' '.$nombreusuario->apellido;
      $pendientes += $value->estado == 'pendiente'?1:0;
      $aprobadas += $value->estado == 'aprobada'?1:0;
      $rechazadas += $value->estado == 'rechazada'?1:0;
      $entregadas += $value->estado == 'entregada'?1:0;
      $entransito += $value->estado == 'entransito'?1:0;
    }
    
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/trasladosinventarios/solicitudesrecibidas', ['titulo'=>'Almacen', 'solicitudesrecividas'=>$solicitudesrecividas, 'unidadesmedida'=>$unidadesmedida, 'pendientes'=>$pendientes, 'aprobadas'=>$aprobadas, 'rechazadas'=>$rechazadas, 'entregadas'=>$entregadas, 'entransito'=>$entransito, 'sucursales'=>$sucursales, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

//TABLA DONDE VEO LOS TRASLADOS O SALIDAS QUE HAGO O SOLICITUDES QUE HAGO A OTRAS SUCURSALES
  public static function trasladarinventario(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    $pendientes = 0;
    $aprobadas = 0;
    $rechazadas = 0;
    $entregadas = 0;
    $entransito = 0;

    $sucursales = sucursales::idregistros('estado', 1);
    $transferirinventario = traslado_inv::idregistros('id_sucursalorigen', id_sucursal());
    foreach($transferirinventario as $value){
      //$value->sucursaldestino = sucursales::uncampo('id', $value->id_sucursaldestino, 'nombre');
      foreach($sucursales as $s){
        if($value->id_sucursaldestino == $s->id){
          $value->sucursaldestino = $s->nombre;
          break;
        }
      }
      $nombreusuario = usuarios::find('id', $value->fkusuario);
      $value->usuario = $nombreusuario->nombre.' '.$nombreusuario->apellido;
      $pendientes += $value->estado == 'pendiente'?1:0;
      $aprobadas += $value->estado == 'aprobada'?1:0;
      $rechazadas += $value->estado == 'rechazada'?1:0;
      $entregadas += $value->estado == 'entregada'?1:0;
      $entransito += $value->estado == 'entransito'?1:0;
    }
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/trasladosinventarios/trasladarinventario', ['titulo'=>'Almacen', 'transferirinventario'=>$transferirinventario, 'unidadesmedida'=>$unidadesmedida, 'pendientes'=>$pendientes, 'aprobadas'=>$aprobadas, 'rechazadas'=>$rechazadas, 'entregadas'=>$entregadas, 'entransito'=>$entransito, 'sucursales'=>$sucursales, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  //REALIZAR ORDEN TRASLADO DE MERCANCIA
  public static function nuevotrasladoinv(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    $sucursalorigen = sucursales::find('id', id_sucursal());
    $sucursales = sucursales::all();
    $unidadesmedida = unidadesmedida::all();
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/almacen/trasladosinventarios/nuevotrasladoinv', ['titulo'=>'Almacen', 'sucursalorigen'=>$sucursalorigen, 'sucursales'=>$sucursales, 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }

  //REALIZAR ORDEN DE SOLICITUD A OTRA SEDE DE MERCANCIA PARA QUE ME DESPACHEN
  public static function solicitarinventario(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    $sucursalorigen = sucursales::find('id', id_sucursal());
    $sucursales = sucursales::all();
    $unidadesmedida = unidadesmedida::all();
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/almacen/trasladosinventarios/solicitarinventario', ['titulo'=>'Almacen', 'sucursalorigen'=>$sucursalorigen, 'sucursales'=>$sucursales, 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }


  //EDITAR LOS PRODUCTOS A TRASLADAR A OTRA SEDE
  public static function editartrasladoinv(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $id=$_GET['id'];
    if(!is_numeric($id))return;
    $alertas = [];
    $sucursales = sucursales::all();
    $unidadesmedida = unidadesmedida::all();
    $sql = "SELECT CONCAT(u.nombre,' ',u.apellido) as nombreusuario, td.id, td.tipo, td.fkusuario, td.estado, td.observacion, s_origen.nombre AS sucursal_origen, s_destino.nombre AS sucursal_destino
                FROM traslado_inv td 
                INNER JOIN sucursales s_origen ON td.id_sucursalorigen = s_origen.id
                INNER JOIN sucursales s_destino ON td.id_sucursaldestino = s_destino.id
                INNER JOIN usuarios u ON td.fkusuario = u.id WHERE td.id = $id;";
    $ordentraslado = traslado_inv::camposJoinObj($sql);
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/almacen/trasladosinventarios/editartrasladoinv', ['titulo'=>'Almacen', 'ordentraslado'=>array_shift($ordentraslado), 'sucursales'=>$sucursales, 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }


  //---------------------  API  -----------------------//
    /*public static function allordenestrasladoinv(){
        session_start();
        isadmin();
        $alertas = [];
        $ordenes = traslado_inv::

        echo json_encode();
    }*/

    //metodo llamado desde trasladarinv.ts para el detalle de la orden trasnaldo/solicitud
    public static function idOrdenTrasladoSolicitudInv(){
        session_start();
        isadmin();
        $alertas = [];
        $id=$_GET['id'];
        if(!is_numeric($id)){
            $alertas['error'][] = "Error al procesar orden.";
            echo json_encode($alertas);
            return;
        }
        //$orden = traslado_inv::find('id', $id);
        $sql = "SELECT CONCAT(u.nombre,' ',u.apellido) as nombreusuario, td.id, td.tipo, td.fkusuario, td.estado, s_origen.nombre AS sucursal_origen, s_destino.nombre AS sucursal_destino
                FROM traslado_inv td 
                INNER JOIN sucursales s_origen ON td.id_sucursalorigen = s_origen.id
                INNER JOIN sucursales s_destino ON td.id_sucursaldestino = s_destino.id
                INNER JOIN usuarios u ON td.fkusuario = u.id WHERE td.id = $id;";
        $orden = traslado_inv::camposJoinObj($sql);
        if($orden){
            $sql = "SELECT td.id, td.id_trasladoinv, td.fkproducto, td.idsubproducto_id,
                    COALESCE(p.nombre, sp.nombre) AS nombre, td.cantidad
                    FROM detalletrasladoinv td
                    LEFT JOIN productos p ON td.fkproducto = p.id
                    LEFT JOIN subproductos sp ON td.idsubproducto_id = sp.id
                    WHERE td.id_trasladoinv = $id;";
            $orden[0]->detalletrasladoinv = detalletrasladoinv::camposJoinObj($sql); 
            $alertas['exito'][] = "Consulta procesada";
            $alertas['orden'] = $orden;
        }else{
            $alertas['error'][] = "Orden no existe";
        }
        echo json_encode($alertas);
    }

  ///////  generar orden de solicitar inventario  //////////
    public static function apisolicitarinventario(){
        session_start();
        isadmin();
        $alertas = [];
        $idsucursalorigen = $_POST['idsucursalorigen'];
        $idsucursaldestino = $_POST['idsucursaldestino'];
        $carrito = json_decode($_POST['productos']);

        $trasladoinv = new traslado_inv([
          'id_sucursalorigen'=>$idsucursalorigen,
          'id_sucursaldestino'=>$idsucursaldestino,
          'fkusuario'=>$_SESSION['id'],
          'tipo'=>'Solicitud',
          'estado'=>'pendiente'
        ]);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $rt = $trasladoinv->crear_guardar();
            if($rt[0]){
              //////////  SEPARAR LOS ITEMS EN PRODUCTOS Y SUBPRODUCTOS  ////////////
              $resultArray = array_reduce($carrito, function($acumulador, $objeto) use ($rt){
                $objeto->id_trasladoinv = $rt[1];
                $objeto->cantidadrecibida = 0;
                $objeto->cantidadrechazada = 0;
                if($objeto->tipo == 0){
                  $objeto->fkproducto = $objeto->iditem;
                  $objeto->idsubproducto_id = 'NULL';
                  $acumulador['productos'][] = $objeto; // puede ser producto compuesto o simple
                }
                else{
                  $objeto->fkproducto = 'NULL';
                  $objeto->idsubproducto_id = $objeto->iditem;
                  $acumulador['subproductos'][] = $objeto;
                }
                return $acumulador;
              }, ['productos'=>[], 'subproductos'=>[]]);

              $detalletrasladoinv = new detalletrasladoinv;
              if(!empty($resultArray['productos']))$detalletrasladoinv->crear_varios_reg_arrayobj($resultArray['productos']);
              if(!empty($resultArray['subproductos']))$detalletrasladoinv->crear_varios_reg_arrayobj($resultArray['subproductos']);
              $alertas['exito'][] = "Solicitud de mercancia enviada correctamente";
            }
        }
        //$alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }


  //////  generar orden de traslado de inventario /////////
    public static function apinuevotrasladoinv(){
        session_start();
        isadmin();
        $alertas = [];
        $idsucursalorigen = $_POST['idsucursalorigen'];
        $idsucursaldestino = $_POST['idsucursaldestino'];
        $carrito = json_decode($_POST['productos']);

        $trasladoinv = new traslado_inv([
          'id_sucursalorigen'=>$idsucursalorigen,
          'id_sucursaldestino'=>$idsucursaldestino,
          'fkusuario'=>$_SESSION['id'],
          'tipo'=>'Salida',
          'estado'=>'pendiente'
        ]);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $rt = $trasladoinv->crear_guardar();
            if($rt[0]){
              //////////  SEPARAR LOS ITEMS EN PRODUCTOS Y SUBPRODUCTOS  ////////////
              $resultArray = array_reduce($carrito, function($acumulador, $objeto) use ($rt){
                $objeto->id_trasladoinv = $rt[1];
                $objeto->cantidadrecibida = 0;
                $objeto->cantidadrechazada = 0;
                if($objeto->tipo == 0){
                  $objeto->fkproducto = $objeto->iditem;
                  $objeto->idsubproducto_id = 'NULL';
                  $acumulador['productos'][] = $objeto; // puede ser producto compuesto o simple
                }
                else{
                  $objeto->fkproducto = 'NULL';
                  $objeto->idsubproducto_id = $objeto->iditem;
                  $acumulador['subproductos'][] = $objeto;
                }
                return $acumulador;
              }, ['productos'=>[], 'subproductos'=>[]]);

              $detalletrasladoinv = new detalletrasladoinv;
              if(!empty($resultArray['productos']))$detalletrasladoinv->crear_varios_reg_arrayobj($resultArray['productos']);
              if(!empty($resultArray['subproductos']))$detalletrasladoinv->crear_varios_reg_arrayobj($resultArray['subproductos']);
              $alertas['exito'][] = "Solicitud de transferencia enviada correctamente";
            }
        }
        //$alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas);
    }


    public static function editarOrdenTransferencia(){
        session_start();
        isadmin();
        $alertas = [];
        $addproductos = new detalletrasladoinv;
        $trasladoinv = traslado_inv::find('id', $_POST['id_trasladoinv']);
        $detalletrasladoDB = detalletrasladoinv::idregistros('id_trasladoinv', $_POST['id_trasladoinv']);
        $idsdetalleproductos = json_decode($_POST['ids']);
        $nuevosproductosFront = json_decode($_POST['nuevosproductos']);

        $r1 = true; $r2 = true; $r3 = true;
        $arrayIdeliminar = []; $nuevosproductos = []; $arrayactualizar = [];
        
        //Sincronizar id de la DB y del front si coinciden en el id de detalle_traslado i id de fkprpoducto o idsubproducto
        foreach($nuevosproductosFront as $itemfront){
          foreach($detalletrasladoDB as $itemDB){
            if($itemfront->id_trasladoinv == $itemDB->id_trasladoinv){
              if($itemfront->fkproducto == $itemDB->fkproducto || $itemfront->idsubproducto_id == $itemDB->idsubproducto_id){
                $itemfront->id = $itemDB->id;
                $idsdetalleproductos[] = $itemDB->id;
                break;
              }
            }
          }
        }
        
        if($trasladoinv->estado == 'pendiente'){
          ///IDs a eliminar de la DB
          foreach($detalletrasladoDB as $key => $value)
            if(!in_array($value->id, $idsdetalleproductos))$arrayIdeliminar[] = $value->id;
          //registros a insertar
          foreach ($nuevosproductosFront as $value){
            $value->cantidadrecibida = 0;
            $value->cantidadrechazada = 0;
            if(is_numeric($value->id))$arrayactualizar[] = $value;
            if($value->id=='') $nuevosproductos[] = $value;
          }
          
          if($arrayIdeliminar)$r1 = detalletrasladoinv::eliminar_idregistros('id', $arrayIdeliminar);
          if($nuevosproductos)$r2 = $addproductos->crear_varios_reg_arrayobj($nuevosproductos);
          if($nuevosproductosFront) $r3 = detalletrasladoinv::updatemultiregobj($arrayactualizar, ['cantidad']);
          if($r1&&$r2&&$r3){
            $alertas['exito'][] = "$trasladoinv->tipo de transferencia actualizada correctamente";
          }else{
            $alertas['error'][] = "Error, intenta actualizar la orden nuevamnete";
          }
        }else{
          $alertas['exito'][] = "La orden dbe estar en estado 'pendiente'";
        }
        echo json_encode($alertas);
    }


    public static function confirmarnuevotrasladoinv(){
        session_start();
        isadmin();
        $alertas = [];
        $rsps = true;
        $rsis = true;

        $id = $_POST['id'];
        $trasladoinv = traslado_inv::find('id', $id);
        $listaproductos = detalletrasladoinv::idregistros('id_trasladoinv', $trasladoinv->id);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
          if(($trasladoinv->tipo == 'Salida' || $trasladoinv->tipo == 'Solicitud') && $trasladoinv->estado == 'pendiente'){
            $trasladoinv->estado = 'entransito';
            $ra = $trasladoinv->actualizar();

            if($ra){
              //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
              $resultArray = array_reduce($listaproductos, function($acumulador, $objeto){
                  if(isset($objeto->fkproducto)){
                    $objeto->id = $objeto->fkproducto;
                    $acumulador['productos'][] = $objeto; // puede ser producto compuesto o simple
                  }
                  else{
                    $objeto->id = $objeto->idsubproducto_id;
                    $acumulador['subproductos'][] = $objeto;
                  }
                  return $acumulador;
              }, ['productos'=>[], 'subproductos'=>[]]);

              //descontar de inventario de la sucursal de origen
              if(!empty($resultArray['productos']))$rsps = stockproductossucursal::reduceinv1condicion($resultArray['productos'], 'stock', 'productoid', 'sucursalid ='.$trasladoinv->tipo == 'Salida'?$trasladoinv->id_sucursalorigen:$trasladoinv->id_sucursaldestino);
              if(!empty($resultArray['subproductos']))$rsis = stockinsumossucursal::reduceinv1condicion($resultArray['subproductos'], 'stock', 'subproductoid', 'sucursalid ='.$trasladoinv->tipo == 'Salida'?$trasladoinv->id_sucursalorigen:$trasladoinv->id_sucursaldestino);

              if($rsps&&$rsis){
                $alertas['exito'][] = "Orden procesada en transito e inventario descontado";
              }else{
                $trasladoinv->estado = 'pendiente';
                $ra = $trasladoinv->actualizar();
                $alertas['error'][] = "Error al descontar del inventario, ajustar inventario";
              }

            }else{
               $alertas['error'][] = "No se puedo actualizar el estado en transito, intentalo nuevamente";
            }
          }else{
            $alertas['error'][] = "La orden debe estar como pendiente y ser de tipo salida";
          }
        }
        echo json_encode($alertas);
    }


    public static function confirmaringresoinv(){
        session_start();
        isadmin();
        $alertas = [];
        $rsps = true;
        $rsis = true;

        $id = $_POST['id'];
        $trasladoinv = traslado_inv::find('id', $id);
        $listaproductos = detalletrasladoinv::idregistros('id_trasladoinv', $trasladoinv->id);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
          if(($trasladoinv->tipo == 'Salida' || $trasladoinv->tipo == 'Solicitud') && $trasladoinv->estado == 'entransito'){ //solicitud de ingreso
            $trasladoinv->estado = 'entregada';
            $ra = $trasladoinv->actualizar();

            if($ra){
              //////////  SEPARAR LOS PRODUCTOS DE SUBPRODUCTOS  ////////////
              $resultArray = array_reduce($listaproductos, function($acumulador, $objeto){
                  if(isset($objeto->fkproducto)){
                    $objeto->id = $objeto->fkproducto;
                    $acumulador['productos'][] = $objeto; // puede ser producto compuesto o simple
                  }
                  else{
                    $objeto->id = $objeto->idsubproducto_id;
                    $acumulador['subproductos'][] = $objeto;
                  }
                  return $acumulador;
              }, ['productos'=>[], 'subproductos'=>[]]);

              //sumar a inventario de la sucursal de destino
              if(!empty($resultArray['productos']))$rsps = stockproductossucursal::addinv1condicion($resultArray['productos'], 'stock', 'productoid', 'sucursalid ='.$trasladoinv->id_sucursaldestino);
              if(!empty($resultArray['subproductos']))$rsis = stockinsumossucursal::addinv1condicion($resultArray['subproductos'], 'stock', 'subproductoid', 'sucursalid ='.$trasladoinv->id_sucursaldestino);

              if($rsps&&$rsis){
                $alertas['exito'][] = "Orden procesada, mercancia recibida e ingresada a inventario";
              }else{
                $trasladoinv->estado = 'entransito';
                $ra = $trasladoinv->actualizar();
                $alertas['error'][] = "Error al ingresar al inventario, ajustar inventario";
              }

            }else{
               $alertas['error'][] = "No se puedo actualizar el estado 'entregado', intentalo nuevamente";
            }
          }else{
            if($trasladoinv->tipo == 'Solicitud'){
              $alertas['error'][] = "La orden debe estar como 'entransito' y ser de tipo Solicitud";
            }else{
              $alertas['error'][] = "La orden debe estar como 'entransito' y ser de tipo Ingreso";
            }
          }
        }
        echo json_encode($alertas);
    }



    //llamada desde trasladarinv.ts / trasladarinventario para anular envio o solicitud de que me despachen
    public static function anularnuevotrasladoinv(){
        session_start();
        isadmin();
        $alertas = [];
        
        //validar que la orden esta en estado pendiente para eliminar
        $id = $_POST['id'];
        $trasladoinv = traslado_inv::find('id', $id);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
          if($trasladoinv->estado = 'pendiente'){
            $r = $trasladoinv->eliminar_registro();
            if($r){
              $alertas['exito'][] = "$trasladoinv->tipo eliminada";
            }else{
              $alertas['error'][] = "No se pudo eliminar el registro, verifica nuevamente";
            }
          }
        }
        echo json_encode($alertas);
    }

}
