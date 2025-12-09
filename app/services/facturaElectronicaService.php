<?php 

namespace App\services;

use App\Models\felectronicas\adquirientes;
use App\Models\felectronicas\facturas_electronicas;
use App\Models\ventas\facturas;
use stdClass;

//**SERVICIO DE FACTURA ELECTRONICA, ADQUIRIENTES Y NOTA CREDITO - DIAN

class facturaElectronicaService {

    public static function createUpDateAdquiriente(array $datosadquiriente): array{
       $alertas = []; 
       $existeAdquiriente = adquirientes::find('identification_number', $datosadquiriente['identification_number']);
      if($existeAdquiriente){
        $existeAdquiriente->compara_objetobd_post($datosadquiriente);
        $r = $existeAdquiriente->actualizar();
        $alertas['tipo'] = "actualizar";
        $alertas['response'] = $r;
        $alertas['obj'] = $existeAdquiriente;
        $alertas['id'] = $existeAdquiriente->id;
      }else{
        $adquiriente = new adquirientes($datosadquiriente);
        $r = $adquiriente->crear_guardar();
        $alertas['tipo'] = "crear";
        $alertas['response'] = $r[0];
        $alertas['obj'] = $adquiriente;
        $alertas['id'] = $r[1];
      }
      return $alertas;
    }

    public static function reciclarFacturaElectronica($value){

      $previasAceptadas  = facturas_electronicas::whereArray(['id_sucursalidfk'=>id_sucursal(), 'id_estadoelectronica'=>2, 'id_facturaid'=>$value->id_facturaid], 'DESC');
      if(!empty($previasAceptadas )){
        $last  = reset($previasAceptadas );
        $facturageneral = facturas::find('id', $last ->id_facturaid); //obtener la factura POS anterior
        $facturageneral->idconsecutivo =  $last ->consecutivo_id;
        $facturageneral->prefijo =  $last ->prefijo;
        $facturageneral->num_consecutivo =  $last ->numero;
        $facturageneral->actualizar();
      }else{
        // no hay factura electronica previa, tomar el prefojo y numero POS que tenia originalmente
      }
    }

    public static function actualizarFacturaConsecutivo($factura, $consecutivo, $numConsecutivo){
      $factura->num_consecutivo = $numConsecutivo;
      $factura->prefijo = $consecutivo->prefijo;
      $factura->idconsecutivo = $consecutivo->id;
      $r = $factura->actualizar();
      $c = $consecutivo->actualizar();
    }
}