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


}
