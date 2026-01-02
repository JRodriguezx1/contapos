<?php 

namespace App\services;

use App\classes\serviceLocatorApp;
use App\Models\caja\cierrescajas;
use App\Models\clientes\clientes;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\mediospago;
use App\Models\creditos\creditos;
use App\Models\creditos\cuotas;
use App\Models\creditos\productosseparados;
use App\Models\creditos\separadomediopago;
use App\Models\inventario\productos_sub;
use App\Models\ventas\facturas;
use App\Repositories\creditos\creditosRepository;
use App\Repositories\creditos\cuotasRepository;
use App\Repositories\creditos\productsSeparadosRepository;
use App\Repositories\creditos\separadoMediopagoRepository;
use stdClass;

//**SERVICIO DE CREDITOS

class creditosService {
    //metodo llamado desde ventascontrolador.php
    public static function crearCredito(stdClass $valoresCredito, $idfactura, $idcliente){
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $credito = new creditosRepository();
        $entity = $credito->generarCredito((array)$valoresCredito, $idfactura, $idcliente);
        $alertas = $entity->validar();
        if(empty($alertas)){
            $r = $credito->insert($entity);
            if($r[0]){
                $alertas['exito'][] = "Credito creado con exito";
            }else{
                $alertas['error'][] = "Credito creado con exito";
            }
        }
        return $alertas;
    }


    public static function ejecutarCrearSeparado(array $valoresCredito, array $carrito, array $mediospago):array{
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $separado = new creditosRepository();
        $getDB = $separado->getConexion();
        //$alertas = $separado->validar();
        //if(empty($alertas)){
        $getDB->begin_transaction();
        try {
            $r = $separado->generarSeparado(new creditos($valoresCredito));
            // registrar abono inicial en tabla cuotas
            if($valoresCredito['abonoinicial'] > 0){
                $valoresCredito = [ 'id_credito'=>$r['1'] ] + $valoresCredito;
                //crear cuota con repositorio
                $cuotasRepo = new cuotasRepository();
                $rc = $cuotasRepo->insert(new cuotas($valoresCredito));
                //registrar medios de pago del abono inicial si aplica
                $payment = new paymentService(new separadoMediopagoRepository());  //separadomediopago::class = a nombre de la clase como string
                $payment->registrarPagos($mediospago, $rc[1]);
            }
            //registrar los productos
            foreach($carrito as $obj){
              $obj->idcredito = $r[1];
              $obj->idproducto = $obj->fk_producto;
            }
            $repo = new productsSeparadosRepository();
            $repo->crear_varios_reg_arrayobj($carrito);
            //descontar de inventario
            $a = ventasService::ajustarIventarioXVenta($carrito);
            //ajustar abono o pagos en caja
            $getDB->commit();
            $alertas['exito'][] = "Credito de tipo separado creado correctamente.";
        } catch (\Throwable $th) {
            $getDB->rollback();
            $alertas['error'][] = "Error al generar el credito de tipo separado. ".$th->getMessage();
        }
        //}
        return $alertas;
    }


    public static function detallecredito($id):array{
        $credito = new creditosRepository();
        $cuotasRepo = new cuotasRepository();
        $productos = new productsSeparadosRepository();
        $credito = $credito->find($id);
        $detalle = [
            'titulo' => 'Creditos',
            'credito' => $credito,
            'cuotas' => $cuotasRepo->unJoinWhereArrayObj('mediospago', 'mediopagoid', 'id', ['id_credito' => $credito->id]),
            'productos' => $productos->obtenerPorCredito($credito->id),
            'cliente' => clientes::find('id', $credito->cliente_id),  //$credito->cliente_id
            'cajas' => caja::whereArray(['idsucursalid'=>id_sucursal(), 'estado'=>1]),
            'factura' => facturas::find('id', $credito->factura_id),
            'mediospago' => mediospago::whereArray(['estado'=>1])
        ];
        return $detalle;
    }


    public static function registrarAbono($datos){
        $alertas = [];
        $creditoRepo = new creditosRepository();
        $credito = $creditoRepo->find($datos['id_credito']);
        if($credito->estado == 0){
            $cuota = new cuotas($datos);
            $cuota->prepararSegunCredito($credito);
            $alertas = $cuota->validar();
            if(empty($alertas)){
                $cuotaRepo = new cuotasRepository();
                $getDB = $cuotaRepo::getDB();
                $getDB->begin_transaction();
                try {
                    $r = $cuotaRepo->insert($cuota);
                    $objMedioPago = new separadomediopago(['idcuota'=>$r[1], 'mediopago_id'=>$datos['mediopagoid'], 'valor'=>$datos['valorpagado']]);
                    $credito->actualizarCredito($cuota->valorpagado);
                    $ra = $creditoRepo->update($credito);
                    $payment = new paymentService(new separadoMediopagoRepository());
                    $payment->registrarPagos([$objMedioPago], $r[1]);
                    $getDB->commit();
                    $alertas['exito'][] = "Cuota procesada";
                } catch (\Throwable $th) {
                    $getDB->rollback();
                    $alertas['error'][] = "Error al procesar el abono {$th->getMessage()}";
                }
            }
        }else{
            $alertas['error'][] = "Credito finalizado, no se puede abonar mas.";
        }
        return $alertas;

    }


    public static function pagoTotal(){
        
    }
}