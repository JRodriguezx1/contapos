<?php

namespace Controllers;

use Model\configuraciones\consecutivos;
use Model\configuraciones\usuarios; //namespace\clase hija
use Model\ActiveRecord;
use Model\clientes\departments;
use Model\clientes\municipalities;
use Model\parametrizacion\config_local;
use Model\configuraciones\tipofacturador;
use Model\felectronicas\diancompanias;
use Model\sucursales;
use MVC\Router;  //namespace\clase
 
class apidiancontrolador{


  //////////////---------   API   ----------///////////////////
  public static function citiesXdepartments(){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de configuracion')&&userPerfil()>=3)return;
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id)){
        $alertas['error'][] = "Hubo un error el id del departamento no es valido";
        echo json_encode($alertas);
        return;
    }
    $idsucursal = id_sucursal();
    $dapartments = departments::all();
    $conflocal = config_local::getParamGlobal();

    $municipios = municipalities::idregistros('department_id', $id);
    echo json_encode($municipios);
  }


  public static function crearCompanyJ2(){
    session_start();
    isadmin();
    $alertas = [];
    if(userPerfil()>1){
      $alertas['error'][] = "No tienes permisos";
      return;
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }

    $compañia = json_decode(file_get_contents('php://input'), true);
    $diancompanias = new diancompanias($compañia);
    $r = $diancompanias->crear_guardar();
    if($r[0]){
      $alertas['exito'][] = "Compañia guardada localmente";
      $alertas['id'] = $r[1];
    }else{
      $alertas['error'][] = "No se guardo la configuracion de la compañia";
    }
    echo json_encode($alertas);
  }


  public static function getCompaniesAll(){
    session_start();
    isadmin();
    $alertas = [];
    $compañias = diancompanias::all();
    echo json_encode($compañias);
  }

  public static function eliminarCompanyLocal(){
    session_start();
    isadmin();
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id)){
        $alertas['error'][] = "Hubo un error, el id de la compañia no es valido";
        echo json_encode($alertas);
        return;
    }
    $compañia = diancompanias::find('identification_number', $id);
    if($compañia){
      $r = $compañia->eliminar_registro();
      if($r){
        $alertas['exito'][] = "Compañia eliminada";
      }else{
        $alertas['error'][] = "No fue posible eliminar compañia";
      }
    }
    echo json_encode($alertas);
  }


  public static function guardarResolutionJ2(){
    session_start();
    isadmin();
    $alertas = [];
    
    if(userPerfil()>1){
      $alertas['error'][] = "No tienes permisos";
      return;
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }

    $resolution = json_decode(file_get_contents('php://input'), true);
    $existeResolution = consecutivos::uniquewhereArray(['resolucion'=>$resolution['ResolutionNumber'], 'prefijo'=>$resolution['Prefix']]);
    if($existeResolution){
      $existeResolution->estado = 1;
      $alertas['exito'][] = "Resolucion descargada en sistema.";
      $existeResolution->nombretipofacturador = tipofacturador::find('id', $existeResolution->idtipofacturador);
      $alertas['facturador'] = $existeResolution;
    }else{
      $facturador = new consecutivos([
                                      'id_sucursalid'=>id_sucursal(), 
                                      'idtipofacturador'=>1, 
                                      'nombre'=>'Electronica '.$resolution['Prefix'], 
                                      'rangoinicial'=>$resolution['FromNumber'],
                                      'rangofinal'=>$resolution['ToNumber'],
                                      'siguientevalor'=>1,
                                      'fechainicio'=>$resolution['ValidDateFrom'],
                                      'fechafin'=>$resolution['ValidDateTo'],
                                      'resolucion'=>$resolution['ResolutionNumber'],
                                      'prefijo'=>$resolution['Prefix'],
                                      'mostrarresolucion'=>1,
                                      'mostrarimpuestodiscriminado'=>0,
                                      'electronica'=>1,
                                      'estado'=>1
                                    ]);
      //debuguear($facturador);
      $r = $facturador->crear_guardar();
      if($r[0]){
        $alertas['exito'][] = "Resolucion descargada en sistema.";
        $facturador->nombretipofacturador = tipofacturador::find('id', $facturador->idtipofacturador);
        $facturador->id = $r[1];
        $alertas['facturador'] = $facturador;
      }else{
        $alertas['error'][] = "Error al descargar resolucion, intentalo de nuevo";
      }
    }

    echo json_encode($alertas);
  }


  public static function guardarAdquiriente(){
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }

    $adquiriente = json_decode(file_get_contents('php://input'), true);

  }

}
