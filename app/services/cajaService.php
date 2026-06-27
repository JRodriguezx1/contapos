<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\caja\declaracionesdineros;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\configuraciones\emisores;
use App\Models\configuraciones\mediospago;
use App\Models\configuraciones\tarifas;
use App\Models\configuraciones\usuarios;
use App\Models\factimpuestos;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
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

        //CAMBIA EL id POR EL idproducto
        $idsProductos = [];
        foreach($productos as $value){
        $value->id = $value->idproducto;
        $value->stock = $value->cantidad;
        $idsProductos[] = $value->idproducto;
        $mapCarrito[$value->idproducto] = $value->stock;
        $value->stockaux = $value->promediostock>0?$value->stock/$value->promediostock:0;
        }

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
                $resultArray = ventasService::reducirIventarioXVenta($productos);
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
        $creditoRepo = new creditosRepository();
        $idfactura = $data['id'];
        $idemisor = $data['idemisor'];
        $idcaja = $data['idcaja'];
        $factura = facturas::find('id', $idemisor);
        $credito = $creditoRepo->uniqueWhere(['factura_id'=>$factura->id]);

        if(!$factura) return ['error'=>'No se encontro factura'];
        //actualizar valores de la caja actual
        $factMP = factmediospago::idregistros('id_factura', $factura->id);
        $factImp = factimpuestos::idregistros('facturaid', $factura->id);
        $cierrecajafactura = cierrescajas::whereArray(['id'=>$factura->idcaja]);

        if($factura->tipo == 'Contado'){
            $valor = 0;
            foreach($mediosPago as $mp){
                if($mp->idmediopago == 1){
                    $valor = $mp->valor;
                    break;
                }
            }

            if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
            
            $cierrecajafactura->totalfacturas = 
            $cierrecajafactura->facturaselectronicas
            $cierrecajafactura->facturaspos
            $cierrecajafactura->valorfe
            $cierrecajafactura->valorpos
            $cierrecajafactura->descuentofe
            $cierrecajafactura->descuentopos
            $cierrecajafactura->ventasenefectivo
            $cierrecajafactura->ingresoventas = 
            $cierrecajafactura->totaldescuentos = 
            $cierrecajafactura->realventas = 
            $cierrecajafactura->valorimpuestototal = 
            $cierrecajafactura->basegravable = 
        }else{
            $cierrecajafactura

        }
        //actualizar valores de la nueva caja
        //buscar cierre de caja de la nueva con la fecha de la factura
        $cierrecaja = cierrescajas::findCierredecajaXidcajaXfactura($idcaja, $factura->fechapago);
        
        $factura->idemisor = $idemisor;
        $factura->idcaja = $idcaja;
        $factura->idcierrecaja = '';
        $credito->idemisor = $idemisor;
        $r1 = $factura->actualizar();
        if($r1){
            if($credito)$creditoRepo->update($credito);
        }else{
            return ['error'=>'Error al actualizar el emisor en la factura'];
        }
        return ['exito'=>'Emisor actualizado en factura'];
    }
    
}