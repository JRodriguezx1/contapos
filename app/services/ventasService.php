<?php 

namespace App\services;

use App\Models\clientes\clientes;
use App\Models\configuraciones\consecutivos;
use App\Models\inventario\productos_sub;
use App\Models\inventario\stockinsumossucursal;
use App\Models\inventario\stockproductossucursal;


//**SERVICIO DE VENTAS

class ventasService {

    public static function reducirIventarioXVenta($carrito):array{
        //$invSub = true;
        $invPro = true;
        //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
        $resultArray = array_reduce($carrito, function($acumulador, $objeto){
            $obj = clone $objeto;
            $obj->id = $objeto->idproducto;
            //unset($objeto->iditem);
            if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){  //producto simple o producto compuesto de tipo produccion construccion, solo se descuenta sus cantidades, y sus insumos cuando se hace produccion en almacen del producto compuesto
                if(!isset($acumulador['productosSimples'][$objeto->idproducto])){
                $acumulador['productosSimples'][$objeto->idproducto] = $obj;
                $acumulador['soloIdproductos'][] = $obj->id;
                }else{
                $acumulador['productosSimples'][$objeto->idproducto]->cantidad += $obj->cantidad;
                }
            }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){  //producto compuesto e inmediato es decir por cada venta se descuenta sus insumos
                if(!isset($acumulador['productosCompuestos'][$objeto->idproducto])){
                $acumulador['productosCompuestos'][$objeto->idproducto] = $obj;
                }else{
                $acumulador['productosCompuestos'][$objeto->idproducto]->cantidad += $obj->cantidad;
                }
                $acumulador['productosCompuestos'][$objeto->idproducto]->porcion = round((float)$acumulador['productosCompuestos'][$objeto->idproducto]->cantidad/(float)$objeto->rendimientoestandar, 4);
            }
            return $acumulador;
        }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);

        
        //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
        $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
        //////// sumar los subproductos repetidos
        $reduceSub = [];
        $soloIdInsumos =[];
        foreach($descontarSubproductos as $idx => $obj){
            if(!isset($reduceSub[$obj->id_subproducto])){
                $obj->id = $obj->id_subproducto;
                $reduceSub[$obj->id_subproducto] = $obj;
                $soloIdInsumos[] = $obj->id;
            }else{
            $reduceSub[$obj->id_subproducto]->cantidad += $obj->cantidad;
            }
        }

        if(!empty($resultArray['productosSimples'])){
            $invPro = stockproductossucursal::reduceinv1condicion($resultArray['productosSimples'], 'stock', 'productoid', "sucursalid = ".id_sucursal());
            //registrar descuento de movimiento de invnetario
            $query = "SELECT * FROM stockproductossucursal WHERE productoid IN(".join(', ', $resultArray['soloIdproductos']).") AND sucursalid = ".id_sucursal().";";
            $returnProductos = stockproductossucursal::camposJoinObj($query);
            stockService::downStock_movimientoProductos($resultArray['productosSimples'], $returnProductos, 'venta', 'descuento de unidades por venta');
        }
        //////// descontar del inventario la variable reduceSub que es el total de subproductos a descontar
        if($invPro && !empty($reduceSub)){
            //$invSub = subproductos::updatereduceinv($reduceSub, 'stock');
            $invSub = stockinsumossucursal::reduceinv1condicion($reduceSub, 'stock', 'subproductoid', "sucursalid = ".id_sucursal());
            //registrar descuento de movimiento de invnetario
            $query = "SELECT * FROM stockinsumossucursal WHERE subproductoid IN(".join(', ', $soloIdInsumos).") AND sucursalid = ".id_sucursal().";";
            $returnInsumos = stockinsumossucursal::camposJoinObj($query);
            stockService::downStock_movimientoInsumos($reduceSub, $returnInsumos, 'venta', 'descuento de unidades por venta');
        }

        return $resultArray;
    }
    

    public static function addIventarioXVenta($carrito):array{
        //$invSub = true;
        $invPro = true;
        //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
        $resultArray = array_reduce($carrito, function($acumulador, $objeto){
            $obj = clone $objeto;
            $obj->id = $objeto->idproducto;
            //unset($objeto->iditem);
            if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){  //producto simple o producto compuesto de tipo produccion construccion, solo se descuenta sus cantidades, y sus insumos cuando se hace produccion en almacen del producto compuesto
                if(!isset($acumulador['productosSimples'][$objeto->idproducto])){
                $acumulador['productosSimples'][$objeto->idproducto] = $obj;
                $acumulador['soloIdproductos'][] = $obj->id;
                }else{
                $acumulador['productosSimples'][$objeto->idproducto]->cantidad += $obj->cantidad;
                }
            }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){  //producto compuesto e inmediato es decir por cada venta se descuenta sus insumos
                if(!isset($acumulador['productosCompuestos'][$objeto->idproducto])){
                $acumulador['productosCompuestos'][$objeto->idproducto] = $obj;
                }else{
                $acumulador['productosCompuestos'][$objeto->idproducto]->cantidad += $obj->cantidad;
                }
                $acumulador['productosCompuestos'][$objeto->idproducto]->porcion = round((float)$acumulador['productosCompuestos'][$objeto->idproducto]->cantidad/(float)$objeto->rendimientoestandar, 4);
            }
            return $acumulador;
        }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);

        
        //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
        $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
        //////// sumar los subproductos repetidos
        $reduceSub = [];
        $soloIdInsumos =[];
        foreach($descontarSubproductos as $idx => $obj){
            if(!isset($reduceSub[$obj->id_subproducto])){
                $obj->id = $obj->id_subproducto;
                $reduceSub[$obj->id_subproducto] = $obj;
                $soloIdInsumos[] = $obj->id;
            }else{
            $reduceSub[$obj->id_subproducto]->cantidad += $obj->cantidad;
            }
        }

        //////// sumar del inventario los productos simples ////////
        if(!empty($resultArray['productosSimples'])){//$invPro = productos::addinv($resultArray['productosSimples'], 'stock');
            $invPro = stockproductossucursal::addinv1condicion($resultArray['productosSimples'], 'stock', 'productoid', "sucursalid = ".id_sucursal());
        //registrar suma de movimiento de invnetario
            $query = "SELECT * FROM stockproductossucursal WHERE productoid IN(".join(', ', $resultArray['soloIdproductos']).") AND sucursalid = ".id_sucursal().";";
            $returnProductos = stockproductossucursal::camposJoinObj($query);
            stockService::upStock_movimientoProductos($resultArray['productosSimples'], $returnProductos, 'devolucion', 'retorno de unidades por anulacion de venta');
        }
            //////// sumar del inventario la variable reduceSub que es el total de subproductos a descontar
        if($invPro && !empty($reduceSub)){//$invSub = subproductos::addinv($reduceSub, 'stock');
            $invSub = stockinsumossucursal::addinv1condicion($reduceSub, 'stock', 'subproductoid', "sucursalid = ".id_sucursal());
            //registrar suma de movimiento de invnetario
            $query = "SELECT * FROM stockinsumossucursal WHERE subproductoid IN(".join(', ', $soloIdInsumos).") AND sucursalid = ".id_sucursal().";";
            $returnInsumos = stockinsumossucursal::camposJoinObj($query);
            stockService::upStock_movimientoInsumos($reduceSub, $returnInsumos, 'devolucion', 'retorno de unidades por anulacion de venta');
        }


        return $resultArray;
    }


    public static function datosDelCierreCajaXVenta($ultimocierre, $factura, $mediospago, $factimpuestos, $r, $valoresCredito):bool{
        /////////// calcular cantidad de facturas y discriminar por tipo
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
        ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
        foreach($mediospago as $obj){
          $obj->id_factura = $r[1];
          $obj->cierrecajaid = $ultimocierre->id;
          if($obj->idmediopago == 1){
            $ultimocierre->ventasenefectivo +=  ($_POST['tipoventa']=='Contado'?$obj->valor:0);
            $ultimocierre->abonosenefectivo += ($_POST['tipoventa']=='Credito'?$obj->valor:0);
          }
        }
        //////// establecer el id de factura para factimpuestos ////////////
        foreach($factimpuestos as $obj)$obj->facturaid = $r[1];

        $ultimocierre->creditocapital += $valoresCredito->capital;  //acumulado de los creditos total
        $ultimocierre->creditos += $valoresCredito->capital-$valoresCredito->abonoinicial;  //acumulados de los creditos menos el abono incial
        $ultimocierre->abonoscreditos += $valoresCredito->abonoinicial; //acumulado de los abonos de solo creditos
        $ultimocierre->abonostotales += $valoresCredito->abonoinicial;
        $ultimocierre->domicilios = $ultimocierre->domicilios + $factura->valortarifa;
        //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
        
        $ultimocierre->ingresoventas =  $ultimocierre->ingresoventas + ($_POST['tipoventa']=='Credito'?0:$factura->total);
        $ultimocierre->totaldescuentos = $ultimocierre->totaldescuentos + $factura->descuento;
        $ultimocierre->valorimpuestototal = $ultimocierre->valorimpuestototal + $factura->valorimpuestototal;
        $ultimocierre->basegravable += $factura->base;
        $r = $ultimocierre->actualizar();
        return $r;
    }


    public static function dataInvoiceForPrinterServer($datosAdquiriente, $factura, $consecutivo):array{
        $customer = [
            "identification_number" => $datosAdquiriente->identification_number??"222222222222",  //obligatorio
            "name" => $datosAdquiriente->business_name??"Consumidor Final",  //obligatorio
            "phone" => $datosAdquiriente->phone??null,
            "address" => $datosAdquiriente->address??null,
            "email" => $datosAdquiriente->email??null,
            "municipality_id" => $datosAdquiriente->municipality_id??null
        ];

        return $dataInvoice['dataInvoice'] = [
            'negocio' => negocionSucursal()->negocio,
            'nit' => negocionSucursal()->nit,
            'direccion' => negocionSucursal()->direccion.' - '.negocionSucursal()->ciudad,
            'telefono' => negocionSucursal()->telefono.' '.negocionSucursal()->movil,
            'email' => negocionSucursal()->email,
            'num_orden' => $factura->num_orden,
            'tipoFactura' => $consecutivo->idtipofacturador,
            'textFactura' => $consecutivo->idtipofacturador == 1?'FACTURA ELECTRONICA DE VENTA':'COMPROBANTE DE VENTA',
            'prefijo' => $factura->prefijo,
            'consecutivo' => $factura->num_consecutivo,
            'fechaPago' => $factura->fechapago,
            'caja' => $factura->caja,
            'vendedor' => $factura->vendedor,
            'consumidorFinal' => $customer,
            'cliente' =>clientes::find('id', $factura->idcliente),
            'tipoventa' =>$factura->tipoventa,
            'subtotal' =>$factura->subtotal,
            'base' => $factura->base,
            'valorimpuestototal' =>$factura->valorimpuestototal,
            'descuento' =>$factura->descuento,
            'total' =>$factura->total,
            'observacion' =>$factura->observacion,
            'resolucion' => $consecutivo,
        ];
    }
}