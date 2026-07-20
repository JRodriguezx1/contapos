<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\caja\declaracionesdineros;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\emisores;
use App\Models\configuraciones\mediospago;
use App\Models\configuraciones\tarifas;
use App\Models\configuraciones\usuarios;
use App\Models\factimpuestos;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
use App\Repositories\contable\movimientos_cajaRepository;
use App\Repositories\creditos\creditosRepository;
use App\Repositories\creditos\separadoMediopagoRepository;
use stdClass;

class cajaService {

    public static function printdetallecierre(int $id):?array{
        
        $discriminarmediospagos = [];
        $conflocal = config_local::getParamGlobal();
        $indicadorCaja = $conflocal['indicador_caja']->valor_final;

        $separadomediospagoRepo = new separadoMediopagoRepository();
        $ultimocierre = cierrescajas::find('id', $id);
        $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);

        $factmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);
        $sepMediosPago = $separadomediospagoRepo->allMediospagoXCierrecaja($ultimocierre->id);
        foreach (array_merge($factmediospagos, $sepMediosPago) as $item) {
            $id = $item['idmediopago'];
            if (!isset($discriminarmediospagos[$id])) {
                $discriminarmediospagos[$id] = $item;
                $discriminarmediospagos[$id]['valor'] = (float)$item['valor'];
            } else {
                $discriminarmediospagos[$id]['valor'] += (float)$item['valor'];
            }
        }

        $discriminarimpuesto = cierrescajas::discriminarimpuesto($ultimocierre->id);
        $ventasxusuarios = cierrescajas::ventasXusuario($ultimocierre->id);
        $mediospagos = mediospago::all();  //se usa para la declaracion de valores.
        $declaracion = declaracionesdineros::idregistros('idcierrecajaid', $ultimocierre->id);
        //////////// Indicador de caja //////////////////
        $diferencial = $indicadorCaja == 1?($ultimocierre->basecaja - $ultimocierre->gastoscaja):($indicadorCaja == 2?(-$ultimocierre->gastoscaja):($indicadorCaja == 3?($ultimocierre->basecaja - $ultimocierre->gastoscaja - $ultimocierre->domicilios):(- $ultimocierre->gastoscaja - $ultimocierre->domicilios)));
        //////////// mapeo de arreglo de valores declarados con el arreglo de los pagos discriminados /////////////
        $sobrantefaltante = $declaracion;
        foreach($discriminarmediospagos as $i => $dis){
            if($dis['idmediopago'] == 1)$dis['valor'] += $diferencial;
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

        return compact('sobrantefaltante', 'mediospagos', 'discriminarmediospagos', 'discriminarimpuesto', 'ultimocierre', 'facturas', 'ventasxusuarios');
        //return ['sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'discriminarimpuesto'=>$discriminarimpuesto, 'ultimocierre'=>$ultimocierre, 'facturas'=>$facturas, 'ventasxusuarios'=>$ventasxusuarios];

    }



    public static function detalleVenta(int $id):?array{
        $factura = facturas::find('id', $id);
        $productos = ventas::idregistros('idfactura', $id);
        $cliente = clientes::find('id', $factura->idcliente);
        $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
        if(!$direccion)$direccion = direcciones::find('id', 1);
        $tarifa = tarifas::find('id', $direccion->idtarifa);
        $vendedor = usuarios::find('id', $factura->idvendedor);
        $sucursal = sucursales::find('id', id_sucursal());

        $lineasencabezado = explode("\n", $sucursal->datosencabezados??'');
        $emisor = null;
        if($factura->idemisor){
            $emisor = emisores::find('id', $factura->idemisor);
            $lineasencabezado = $emisor->datosencabezados?explode("\n", $emisor->datosencabezados??''):[];
        }
        
        return compact('factura', 'productos', 'cliente', 'direccion', 'tarifa', 'vendedor', 'lineasencabezado', 'sucursal', 'emisor');
    }


    public static function despacharOrden(int $id):array{
        date_default_timezone_set('America/Bogota');
        $alertas = [];
        $factura = facturas::find('id', $id);
        $productos = ventas::idregistros('idfactura', $factura->id);

        /*
        $conflocal = config_local::getParamCaja();
        //////// CALCULAR PRODUCTOS AGOTADOS /////////
        if($conflocal['permitir_venta_de_productos_sin_stock']->valor_final == 0){ //no permitir vender sin stock
            $productosDB = stockproductossucursal::IN_Where('productoid', $idsProductos, ['sucursalid', id_sucursal()]);
            foreach($productosDB as $item){
                if(($item->stock - $mapCarrito[$item->productoid])<0){
                $alertas['error'][] = "Productos agotados, no es posible vender";
                echo json_encode($alertas);
                return;
                }
            }
        }*/

        $getDB = facturas::getDB();
        if($factura->entregado == 0 && ($factura->estado == 'Paga' || $factura->estado == 'Remision')){
            $factura->entregado = 1;
            $factura->fechaentrega = date('Y-m-d H:i:s');
            $getDB->begin_transaction();
            try {
                $inventarioVenta = ventasService::prepararInventarioPersistido($productos, id_sucursal());
                $conflocal = config_local::getParamCaja();
                if($conflocal['permitir_venta_de_productos_sin_stock']->valor_final == 0){
                    $erroresStock = ventasService::validarDisponibilidadInventario($inventarioVenta, id_sucursal());
                    if(!empty($erroresStock)){
                        throw new \RuntimeException(implode(' | ', $erroresStock));
                    }
                }
                $inventarioActualizado = ventasService::descontarInventarioXVenta(
                    $inventarioVenta,
                    id_sucursal(),
                    'venta',
                    'descuento de unidades por despacho de venta',
                    false
                );
                if(!$inventarioActualizado){
                    throw new \RuntimeException('No fue posible actualizar el inventario de la orden.');
                }
                $factura->actualizar();
                $getDB->commit();
                $alertas['exito'][] = "Orden despachada.";
                return $alertas;
            } catch (\Throwable $th) {
                $getDB->rollback();
                $alertas['error'][] = "Error al procesar solicitud >>".$th->getMessage();
                return $alertas;
            }
        }else{
            $alertas['error'][] = "Error, verificar si ya se despacho como domicilio";
            return $alertas;
        }
        
    }


    public static function cambiarEmisor(array $data):array{
        $repoMovimientocaja = new movimientos_cajaRepository();
        $creditoRepo = new creditosRepository();
        $idfactura = $data['id'];
        $idemisor = $data['idemisor'];
        $idNewCaja = $data['idcaja'];
        $factura = facturas::find('id', $idfactura);
        $credito = $creditoRepo->uniqueWhere(['factura_id'=>$factura->id]);
        if($factura->idcaja == $idNewCaja)return ['error'=>['Debes elegir un emisor distinto al inicial']];
        if(!$factura)return ['error'=>['No se encontro factura']];
        //actualizar valores de la caja actual
        $mediospago = factmediospago::uniquewhereArray(['id_factura'=>$factura->id, 'idmediopago'=>1])->valor??0; //me trae la factura que pago en efectivo
        $factMP = factmediospago::idregistros('id_factura', $factura->id);
        $cierrecajafactura = cierrescajas::find('id', $factura->idcierrecaja);
        $tempcierrecaja = clone $cierrecajafactura;

        ///// ACTUALIZAR CAJA ACTUAL
        /////////// calcular cantidad de facturas y discriminar por tipo
        $cierrecajafactura->totalfacturaseliminadas += 1;
        if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
          $cierrecajafactura->facturaselectronicaselimnadas += 1;
          $cierrecajafactura->facturaselectronicas -= 1;
          $cierrecajafactura->valorfe -= $factura->total;
          $cierrecajafactura->descuentofe -= $factura->descuento;
        }else{
          $cierrecajafactura->facturasposeliminadas += 1;
          $cierrecajafactura->facturaspos -= 1;
          $cierrecajafactura->valorpos -= $factura->total;
          $cierrecajafactura->descuentopos += $factura->descuento;
        }

        ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
        if($factura->tipoventa=='Contado'){
          $cierrecajafactura->ventasenefectivo -= $mediospago;
          $cierrecajafactura->ingresoventas -= $factura->total;
        }else{
          $cierrecajafactura->creditocapital -= $factura->total;
          $cierrecajafactura->creditos -= ($factura->total-$factura->abono);
        }

        $cierrecajafactura->domicilios -= $factura->valortarifa;
        $cierrecajafactura->totaldescuentos -= $factura->descuento;
        $cierrecajafactura->valorimpuestototal -= $factura->valorimpuestototal;
        $cierrecajafactura->basegravable -= $factura->base;


        $r1 = $cierrecajafactura->actualizar();
        if(!$r1)return ['error'=>['Error al actualizar el emisor en la factura en el cierre de caja actual']];
        
        ///descuenta los abonos de creditos por caja 
        if($factura->tipoventa=='Credito')$anularCredito = creditosService::descontarAbonosCreditosXCierresCaja($credito->id);  //me vuelve a actualizar el cierre de caja
        if(isset($anularCredito['error'])){
            $tempcierrecaja->actualizar();
            return ['error'=>['Error al actualizar los abonos del emisor de la factura en los cierre de caja']];
        }
        

        //ACTUALIZAR VALORES DE LA NUEVA CAJA
        $ultimocierre = cierrescajas::uniquewhereArray(['idcaja' => $idNewCaja, 'estado'=>0]);
        $ultimocierre->totalfacturas = $ultimocierre->totalfacturas + 1;  //total de facturas
        if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
            $ultimocierre->facturaselectronicas = $ultimocierre->facturaselectronicas + 1;  //total de facturas electronicas
            $ultimocierre->valorfe += $factura->total;
            $ultimocierre->descuentofe += $factura->descuento;
        }else{
            $ultimocierre->facturaspos = $ultimocierre->facturaspos + 1;   //total de facturas pos
            $ultimocierre->valorpos += $factura->total;
            $ultimocierre->descuentopos += $factura->descuento;
        }
        $ultimocierre->ventasenefectivo += $factura->tipoventa=='Contado'?$factura->total:0; 
        ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
        //////// establecer el id del  nuevo cierre de caja para las factmediospago ////////////
        foreach($factMP as $obj){
            $obj->cierrecajaid = $ultimocierre->id;
            if($obj->idmediopago == 1)$ultimocierre->abonosenefectivo += ($credito?$obj->valor:0);
        }

        $ultimocierre->creditocapital += $credito?->capital??0;
        $ultimocierre->creditos += ($credito?->capital??0)-($credito?->abonoinicial??0);  
        $ultimocierre->abonoscreditos += $credito?->abonodecuotas??0;
        $ultimocierre->abonostotales += $credito?->abonodecuotas??0;
        $ultimocierre->domicilios += $factura->valortarifa;
        
        $ultimocierre->ingresoventas += ($credito?0:$factura->total);
        $ultimocierre->totaldescuentos += $factura->descuento;
        $ultimocierre->realventas += $factura->total; 
        $ultimocierre->valorimpuestototal += $factura->valorimpuestototal;
        $ultimocierre->basegravable += $factura->base;

        //ACTUALIZAR FACTURA
        $factura->idemisor = $idemisor==0?NULL:$idemisor;
        $factura->idcaja = $idNewCaja;
        $factura->idcierrecaja = $ultimocierre->id;
        $credito && $credito->idemisor = $idemisor==0?NULL:$idemisor;

        $r2 = $factura->actualizar();
        if($r2){
            $ultimocierre->actualizar();
            if($factMP)factmediospago::updatemultiregobj($factMP, ['cierrecajaid']);
            if($credito)$creditoRepo->update($credito);
            
            //actualizar movimiento de caja
            $movCaja = $repoMovimientocaja->uniqueWhere(['fk_tipo_documento'=>1, 'id_documento'=>$credito->id]);
            $movCaja->fk_caja = $idNewCaja;
            $repoMovimientocaja->update($movCaja);
        }else{
            $tempcierrecaja->actualizar();
            return ['error'=>['Error al actualizar el emisor en la factura']];
        }
        return ['exito'=>['Emisor actualizado en factura'], 'emisor'=>$idemisor==0?sucursales::find('id', id_sucursal()):emisores::find('id', $factura->idemisor)];
    }


}
