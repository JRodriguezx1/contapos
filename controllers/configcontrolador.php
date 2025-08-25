<?php

namespace Controllers;

use Classes\Email;
use Model\caja;
use Model\consecutivos;
use Model\usuarios; //namespace\clase hija
use Model\negocio;
use Model\mediospago;
use Model\ActiveRecord;
use Model\bancos;
use Model\tipofacturador;
use MVC\Router;  //namespace\clase
 
class configcontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $negocio = negocio::find('id', 1);
    $negocios[] = $negocio;
    $empleados = usuarios::all();
    //$servicios = servicios::all();
    //$empleados = empleados::all();
    $mediospago = mediospago::all();
    $cajas = caja::all();
    $consecutivos = consecutivos::all();
    $tipofacturadores = tipofacturador::all();
    $bancos = bancos::all();
    $compañias = [];
    $empleado = new \stdClass();
    $empleado->perfil = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    foreach($cajas as $caja)$caja->nombreconsecutivo = consecutivos::find('id', $caja->idtipoconsecutivo);
    foreach($consecutivos as $consecutivo)$consecutivo->nombretipofacturador = tipofacturador::find('id', $consecutivo->idtipofacturador)->nombre;
        
    $router->render('admin/configuracion/index', ['titulo'=>'Configuracion', 'paginanegocio'=>'checked', 'negocio'=>$negocio, 'negocios'=>$negocios, 'empleado'=>$empleado, 'empleados'=>$empleados, 'cajas'=>$cajas, 'facturadores'=>$consecutivos, 'tipofacturadores'=>$tipofacturadores, 'bancos'=>$bancos, 'compañias'=>$compañias, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);   //  'autenticacion/login' = carpeta/archivo
  }


  ///////////////////////////////////  Apis ////////////////////////////////////
  ///////////// procesando la gestion de la caja ////////////////
    public static function allcajas(){  //api llamado desde citas.js
      $cajas = caja::all();
      foreach($cajas as $caja)$caja->nombreconsecutivo = consecutivos::find('id', $caja->idtipoconsecutivo);
      echo json_encode($cajas);
    }
  
    public static function crearCaja(){ //api llamada desde el modulo de gestioncajas.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $caja = new caja($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
          $caja->negocio = negocio::find('id', $caja->negocio)->nombre;
            $alertas = $caja->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $caja->crear_guardar();
                if($r[0]){
                    $caja->nombreconsecutivo = consecutivos::find('id', $caja->idtipoconsecutivo);
                    $caja->id = $r[1];
                    $alertas['exito'][] = 'Caja creada correctamente';
                    $alertas['caja'] = $caja;
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarCaja(){
        session_start();
        $alertas = []; 
        $caja = caja::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $caja->compara_objetobd_post($_POST);
            $caja->negocio = negocio::find('id', $caja->negocio)->nombre;
            $alertas = $caja->validar();
            if(empty($alertas)){
                $r = $caja->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos de la caja actualizados";
                    $alertas['caja'][] = $caja;
                }else{
                    $alertas['error'][] = "Error al actualizar caja";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarCaja(){
        session_start();
        $caja = caja::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($caja)){
                $r = $caja->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'Caja eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'Caja no encontrada');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }

    
    ///////////////////procesando la gestion de los facturadores //////////////////////
    public static function allfacturadores(){  //api llamado desde citas.js
      $consecutivos = consecutivos::all();
      foreach($consecutivos as $consecutivo)$consecutivo->nombretipofacturador = tipofacturador::find('id', $consecutivo->idtipofacturador)->nombre;
      echo json_encode($consecutivos);
    }
  
    public static function crearFacturador(){ //api llamada desde el modulo de gestionfacturadoes.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $consecutivo = new consecutivos($_POST);
        debuguear($consecutivo);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
          $caja->negocio = negocio::find('id', $caja->negocio)->nombre;
            $alertas = $caja->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $caja->crear_guardar();
                if($r[0]){
                    $caja->nombreconsecutivo = consecutivos::find('id', $caja->idtipoconsecutivo);
                    $caja->id = $r[1];
                    $alertas['exito'][] = 'Caja creada correctamente';
                    $alertas['caja'] = $caja;
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarFacturador(){
        session_start();
        $alertas = []; 
        $consecutivo = consecutivos::find('id', $_POST['id']);
        debuguear($consecutivo);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $caja->compara_objetobd_post($_POST);
            $caja->negocio = negocio::find('id', $caja->negocio)->nombre;
            $alertas = $caja->validar();
            if(empty($alertas)){
                $r = $caja->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos de la caja actualizados";
                    $alertas['caja'][] = $caja;
                }else{
                    $alertas['error'][] = "Error al actualizar caja";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarFacturador(){
        session_start();
        $consecutivo = consecutivos::find('id', $_POST['id']);
        debuguear($consecutivo);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($caja)){
                $r = $caja->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'Caja eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'Caja no encontrada');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }


    ///////////// procesando la gestion de los bancos ////////////////
    public static function allbancos(){  //api llamado desde citas.js
      $bancos = bancos::all();
      echo json_encode($bancos);
    }

    public static function crearBanco(){ //api llamada desde el modulo de gestionbancos.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $banco = new bancos($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $banco->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $banco->crear_guardar();
                if($r[0]){
                    $banco->id = $r[1];
                    $banco->created_at = date('Y-m-d H:i:s');
                    $alertas['exito'][] = 'banco creada correctamente';
                    $alertas['banco'] = $banco;
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarBanco(){
        session_start();
        $alertas = []; 
        $banco = bancos::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $banco->compara_objetobd_post($_POST);
            $alertas = $banco->validar();
            if(empty($alertas)){
                $r = $banco->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos del banco actualizados";
                    $alertas['banco'][] = $banco;
                }else{
                    $alertas['error'][] = "Error al actualizar banco";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarBanco(){
        session_start();
        $banco = bancos::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($banco)){
                $r = $banco->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'banco eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'banco no encontrada');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }


}