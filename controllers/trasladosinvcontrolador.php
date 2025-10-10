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

    $solicitudesrecividas = traslado_inv::idregistros('id_sucursaldestino', id_sucursal());
    foreach($solicitudesrecividas as $value){
      $value->sucursalorigen = sucursales::uncampo('id', $value->id_sucursalorigen, 'nombre');
      $nombreusuario = usuarios::find('id', $value->fkusuario);
      $value->usuario = $nombreusuario->nombre.' '.$nombreusuario->apellido;
    }
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/trasladosinventarios/solicitudesrecibidas', ['titulo'=>'Almacen', 'solicitudesrecividas'=>$solicitudesrecividas, 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

//TABLA DONDE VEO LOS TRASLADOS O SALIDAS QUE HAGO O SOLICITUDES QUE HAGO A OTRAS SUCURSALES
  public static function trasladarinventario(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
     $transferirinventario = traslado_inv::idregistros('id_sucursalorigen', id_sucursal());
    foreach($transferirinventario as $value){
      $value->sucursaldestino = sucursales::uncampo('id', $value->id_sucursaldestino, 'nombre');
      $nombreusuario = usuarios::find('id', $value->fkusuario);
      $value->usuario = $nombreusuario->nombre.' '.$nombreusuario->apellido;
    }
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/trasladosinventarios/trasladarinventario', ['titulo'=>'Almacen', 'transferirinventario'=>$transferirinventario, 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
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
    $alertas = [];
    $sucursalorigen = sucursales::find('id', id_sucursal());
    $sucursales = sucursales::all();
    $unidadesmedida = unidadesmedida::all();
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/almacen/trasladosinventarios/editartrasladoinv', ['titulo'=>'Almacen', 'sucursalorigen'=>$sucursalorigen, 'sucursales'=>$sucursales, 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }


  //---------------------  API  -----------------------//
    /*public static function allordenestrasladoinv(){
        session_start();
        isadmin();
        $alertas = [];
        $ordenes = traslado_inv::

        echo json_encode();
    }*/

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
                INNER JOIN usuarios u ON td.fkusuario = u.id WHERE td.id = 1;";
        $orden = traslado_inv::camposJoinObj($sql);
        if($orden){
            $sql = "SELECT td.id, td.id_trasladoinv, td.fkproducto, td.idsubproducto_id,
                    COALESCE(p.nombre, sp.nombre) AS nombre, td.cantidad
                    FROM detalletrasladoinv td
                    LEFT JOIN productos p ON td.fkproducto = p.id
                    LEFT JOIN subproductos sp ON td.idsubproducto_id = sp.id
                    WHERE td.id_trasladoinv = 1;";
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

}
