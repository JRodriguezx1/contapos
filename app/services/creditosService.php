<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\clientes\clientes;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\ventas\facturas;
use stdClass;

//**SERVICIO DE CREDITOS

class creditosService {

    public static function registrarAbono($datosCuota):array{
        
            if($credito->estado == 0){
                $cuota = new cuotas($datosCuota);
                $credito->numcuota += 1;
                $cuota->numerocuota = $credito->numcuota;
                $cuota->montocuota = $credito->montocuota;
                $alertas = $cuota->validar();
                if(empty($alertas)){
                    $r = $cuota->crear_guardar();
                    if($r[0]){
                        $alertas['exito'][] = "Cuota procesada";
                        $credito->saldopendiente -= $cuota->valorpagado;
                        if($credito->saldopendiente<=0)$credito->estado = 1;  //credito cerrado
                        $ra = $credito->actualizar();
                        
                    }
                }
            }else{
                $alertas['error'][] = "Credito finalizado, no se puede abonar mas";
            }
        
        return $alertas;
    }


    public static function crearCredito(stdClass $valoresCredito, $idfactura, $idcliente){
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $array = (array)$valoresCredito;
        $credito = new creditos($array);
        $credito->idtipofinanciacion = 1;
        $credito->factura_id = $idfactura;
        $credito->cliente_id = $idcliente;
        $credito->saldopendiente = $credito->montototal;
        $credito->frecuenciapago = date('j');
        $alertas = $credito->validar();
        if(empty($alertas)){
            $r = $credito->crear_guardar();
        }
    }
}