<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use Model\negocio;
use Model\parametrizacion\config_global;
use Model\parametrizacion\config_local;
use Model\ventas\ventas;
use Model\tarifas;
use MVC\Router;  //namespace\clase

class parametroscontrolador{
    
  public static function parametrosSistemaCaja():void{
    session_start();
    isadmin();
    $alertas = [];
    $clave = array_key_first($_POST);
    $valorLocal = $_POST[$clave];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $valordeFault = config_global::uncampo('clave', $clave, 'valor_default');
        if($valorLocal != $valordeFault){  //registrar con parametros local por sucursal
            $parametroLocal = new config_local(['clave'=>$clave, 'valor'=>$valorLocal]);
            $r = $parametroLocal->crear_guardar();
            if($r[0]){
                $alertas['exito'][] = "Ajuste procesado";
            }else{
                $alertas['error'][] = "Error intentalo nuevamente";
            }
        }else{
            $parametroLocal = config_local::uniquewhereArray(['fk_sucursalid'=>id_sucursal(), 'clave'=>$clave]);
            if($parametroLocal){
                $r = $parametroLocal->eliminar_registro();
                if($r){
                    $alertas['exito'][] = "Ajuste procesado";
                }else{
                    $alertas['error'][] = "Error intentalo nuevamente";
                }
            }
        }
        echo json_encode($alertas);
    }
  }



}