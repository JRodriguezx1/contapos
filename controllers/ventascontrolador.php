<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use Model\usuarios; //namespace\clase hija
use Model\productos;
use Model\categorias;
use Model\mediospago;
use Model\factmediospago;
use Model\clientes;
use Model\facturas;
use Model\ventas;
use Model\tarifas;
use Model\cierrescajas;
use Model\consecutivos;
use Model\caja;
use Model\productos_sub;
use Model\subproductos;
//use Model\negocio;
use MVC\Router;  //namespace\clase
 
class ventascontrolador{

  public static function index(Router $router):void{
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $productos = productos::all();
    $categorias = categorias::all();
    $mediospago = mediospago::all();
    $clientes = clientes::all();
    $tarifas = tarifas::all();
    $cajas  = caja::all();
    $consecutivos = consecutivos::all();
    $router->render('admin/ventas/index', ['titulo'=>'Ventas', 'categorias'=>$categorias, 'productos'=>$productos, 'mediospago'=>$mediospago, 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);   //  'autenticacion/login' = carpeta/archivo
  }


  ///////////  API REST llamada desde ventas.ts cuando se procesa un pago  ////////////
  public static function facturar(){
    session_start();
    isadmin();
    $carrito = json_decode($_POST['carrito']); //[{id: "1", idcategoria: "3", nombre: "xxx", cantidad: "4"}, {}]
    $mediospago = json_decode($_POST['mediosPago']); //[{id: "1", id_factura: "3", idmediopago: "1", valor: "400050"}, {}]
    $factura = new facturas($_POST);
    $venta = new ventas();
    $factmediospago = new factmediospago();
    $alertas = [];
    $invSub = true;
    $invPro = true;

    //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
    $resultArray = array_reduce($carrito, function($acumulador, $objeto){
      //$objeto->id = $objeto->iditem;
      //unset($objeto->iditem);
      if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){  //producto simple o producto compuesto de tipo produccion construccion, solo se descuenta sus cantidades, y sus insumos cuando se hace produccion en almacen del producto compuesto
        $acumulador['productosSimples'][] = $objeto;
      }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){  //producto compuesto e inmediato es decir por cada venta se descuenta sus insumos
        $objeto->cantidad = round((float)$objeto->cantidad/(float)$objeto->rendimientoestandar, 4);
        $acumulador['productosCompuestos'][] = $objeto;
      }
      return $acumulador;
    }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);
    
    //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
    $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
    //////// sumar los subproductos repetidos
    $reduceSub = [];
    foreach($descontarSubproductos as $idx => $obj){
      if(!isset($reduceSub[$obj->id_subproducto])){
        $obj->id = $obj->id_subproducto;
        $reduceSub[$obj->id_subproducto] = $obj;
      }else{
      $reduceSub[$obj->id_subproducto]->cantidad += $obj->cantidad;
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      //////////validar datos de factura, de ventas y medios de pago
      $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
      $tempultimocierre = clone $ultimocierre;
      if($ultimocierre->estado == 0){ //si cierre de caja esta abierto
        $factura->idcierrecaja = $ultimocierre->id;
        $r = $factura->crear_guardar();  //crear factura
        if($r[0]){
          /////////   si se pago   ////////////////
          if($factura->estado == "Paga"){
            /////////// calcular cantidad de facturas y discriminar por tipo
            $ultimocierre->totalfacturas = $ultimocierre->totalfacturas + 1;  //total de facturas
            if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
              $ultimocierre->facturaselectronicas = $ultimocierre->facturaselectronicas + 1;  //total de facturas electronicas
            }else{
              $ultimocierre->facturaspos = $ultimocierre->facturaspos + 1;   //total de facturas pos
            }
            ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
            foreach($mediospago as $obj){
              $obj->id_factura = $r[1];
              if($obj->idmediopago == 1){
                $ultimocierre->ventasenefectivo =  $ultimocierre->ventasenefectivo + $obj->valor;
              }
            }
            $ultimocierre->domicilios = $ultimocierre->domicilios + $factura->valortarifa;
            //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
            $ultimocierre->ingresoventas =  $ultimocierre->ingresoventas + $factura->total;
            $ultimocierre->totaldescuentos = $ultimocierre->totaldescuentos + $factura->descuento;
            $ultimocierre->impuesto = $ultimocierre->impuesto + $factura->impuesto;
            //////////// Guardar los productos de la venta en tabla ventas //////////////
            foreach($carrito as $obj){
              $obj->dato1 = '';
              $obj->dato2 = '';
              $obj->idfactura = $r[1];
              if($obj->id<0){  //para productos "Otros"
                $obj->id = 1;
                $obj->idproducto = 1;
                $obj->idcategoria = 1;
              }
            }

            $r1 = $venta->crear_varios_reg_arrayobj($carrito);  //crear los productos de la factura en tabla venta
            $r2 = $factmediospago->crear_varios_reg_arrayobj($mediospago); //crear los distintos metodos de pago en tabla factmediospago
        
            if($r1[0] && $r2[0]){
              $ru = $ultimocierre->actualizar();
              if($ru){

                //////// descontar del inventario los productos simples ////////
                if(!empty($resultArray['productosSimples']))$invPro = productos::updatereduceinv($resultArray['productosSimples'], 'stock');
                //////// descontar del inventario la variable reduceSub que es el total de subproductos a descontar
                if($invPro && !empty($reduceSub))$invSub = subproductos::updatereduceinv($reduceSub, 'stock');

                if($invPro){
                  if($invSub){
                    $alertas['exito'][] = "Pago procesado con exito";
                  }else{
                    $alertas['error'][] = "Error en sistema intentalo nuevamente";
                    //ELIMINAR FACTURA por error en actualizar inventario
                    //revertir la ultima actualizacion de la tabla cierrecaja
                    $facturadelete = facturas::find('id', $r[1]);
                    $facturadelete->eliminar_registro();
                    $tempultimocierre->actualizar();
                    ///*revertir el inventario sumando lo que se desconto de productos simples
                  }
                }else{
                  $alertas['error'][] = "Error en sistema intentalo nuevamente";
                  //ELIMINAR FACTURA por error en actualizar inventario
                  //revertir la ultima actualizacion de la tabla cierrecaja
                  $facturadelete = facturas::find('id', $r[1]);
                  $facturadelete->eliminar_registro();
                  $tempultimocierre->actualizar();
                }
              }else{
                $alertas['error'][] = "Error en sistema intentalo nuevamente";
                //ELIMINAR FACTURA por error en actualizar tabla cierre caja
                $facturadelete = facturas::find('id', $r[1]);
                $facturadelete->eliminar_registro();
              }
            }else{
              $alertas['error'][] = "Error en sistema intentalo nuevamente";
              //ELIMINAR FACTURA por error al crear el detalle de productos y medios de pago
              $facturadelete = facturas::find('id', $r[1]);
              $facturadelete->eliminar_registro();
            }

          }else{  
    ////////////// SI ES COTIZACION O SI SE VA A GUARDAR LA FACTURA ///////////////
            $ultimocierre->totalcotizaciones = $ultimocierre->totalcotizaciones + 1;
            //////////// Guardar los productos de la venta en tabla ventas //////////////
            foreach($carrito as $obj){
              $obj->dato1 = '';
              $obj->dato2 = '';
              $obj->idfactura = $r[1];
            }
            $rc = $venta->crear_varios_reg_arrayobj($carrito);  //crear los productos de la factura guardada o cotizacion en tabla venta
            if($rc[0]){
              $ru = $ultimocierre->actualizar();
              if($ru){
                $alertas['exito'][] = "Pedido guardado con exito";
              }else{
                $alertas['error'][] = "Error en sistema intentalo nuevamente";
                //borrar la factura automaticamente tambien se borra los productos en la tabla venta
                $facturadelete = facturas::find('id', $r[1]);  //tomo la factura recien creada arriba
                $facturadelete->eliminar_registro();
              }
            }else{
              $alertas['error'][] = "Error en sistema intentalo nuevamente";
              //borrar la factura
              $facturadelete = facturas::find('id', $r[1]);
              $facturadelete->eliminar_registro();
            }
          }
        }else{
          $alertas['error'][] = "Error en sistema al guardar la venta, intenta nuevamente";
        } //Fin crear guardar
      }else{
        $alertas['error'][] = "Cierre de caja cerrado, verifica el estado de orden";
      }
    } // Fin POST
    echo json_encode($alertas);
  }


 //////////////// cuando de cotizacion o guardada pasa a orden pagada /////////////////
  public static function facturarCotizacion(){
    $invPro = true;
    $invSub = true;
    session_start();
    isadmin();
    $alertas = [];
    $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1); ////// ultimo registro de cierrescajas validar si esta abierto
    $mediospago = json_decode($_POST['mediosPago']);
    $factura = facturas::find('id', $_POST['id']);
    $factmediospago = new factmediospago();
    $productos = ventas::idregistros('idfactura', $factura->id);
    $tempfactura = clone $factura;
    $tempultimocierre = clone $ultimocierre;
   

    //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
      $resultArray = array_reduce($productos, function($acumulador, $objeto){
      //$objeto->id = $objeto->iditem;
      //unset($objeto->iditem);
        if($objeto->tipoproducto == 0){
          $acumulador['productosSimples'][] = $objeto;
        }
        else{
          $acumulador['productosCompuestos'][] = $objeto;
        }
        return $acumulador;
      }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);

    //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
    $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
    //////// sumar los subproductos repetidos
    $reduceSub = [];
    foreach($descontarSubproductos as $idx => $obj){
      if(!isset($reduceSub[$obj->id_subproducto])){
        $obj->id = $obj->id_subproducto;
        $reduceSub[$obj->id_subproducto] = $obj;
      }else{
      $reduceSub[$obj->id_subproducto]->cantidad += $obj->cantidad;
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      
      if($ultimocierre->estado == 0){ //si cierre de caja esta abierto

        if($factura && $factura->estado == "Guardado"){  // si la factura guardada existe
          $factura->compara_objetobd_post($_POST);
          $r = $factura->actualizar();
          if($r){
            /////////// calcular cantidad de cotizaciones a ventas, facturas y discriminar por tipo
            $ultimocierre->ncambiosaventa = $ultimocierre->ncambiosaventa +1;
            $ultimocierre->totalfacturas = $ultimocierre->totalfacturas + 1;  //total de facturas
            if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
              $ultimocierre->facturaselectronicas = $ultimocierre->facturaselectronicas + 1;  //total de facturas electronicas
            }else{
              $ultimocierre->facturaspos = $ultimocierre->facturaspos + 1;   //total de facturas pos
            }
            ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
            foreach($mediospago as $obj){
              $obj->id_factura = $factura->id;
              if($obj->idmediopago == 1){
                $ultimocierre->ventasenefectivo =  $ultimocierre->ventasenefectivo + $obj->valor;
              }
            }
            $ultimocierre->domicilios = $ultimocierre->domicilios + $factura->valortarifa;
            //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
            $ultimocierre->ingresoventas =  $ultimocierre->ingresoventas + $factura->total;
            $ultimocierre->totaldescuentos = $ultimocierre->totaldescuentos + $factura->descuento;
            
            $r1 = $factmediospago->crear_varios_reg_arrayobj($mediospago); //crear los distintos metodos de pago en tabla factmediospago
            if($r1[0]){
              $ru = $ultimocierre->actualizar();
              if($ru){

                //////// descontar del inventario los productos simples ////////
                if(!empty($resultArray['productosSimples']))$invPro = productos::updatereduceinv($resultArray['productosSimples'], 'stock');
                //////// descontar del inventario la variable reduceSub que es el total de subproductos a descontar
                if($invPro && !empty($reduceSub))$invSub = subproductos::updatereduceinv($reduceSub, 'stock');

                if($invPro){
                  if($invSub){
                    $alertas['exito'][] = "Pago procesado con exito";
                  }else{
                    $alertas['error'][] = "Error en sistema intentalo nuevamente";
                    //ELIMINAR FACTURA por error en actualizar inventario
                    //revertir la ultima actualizacion de la tabla cierrecaja
                    $tempfactura->actualizar();
                    $factmediospagodelete = factmediospago::eliminar_idregistros('id_factura', [$factura->id]);
                    $tempultimocierre->actualizar();
                    ///*revertir el inventario sumando lo que se desconto de productos simples
                  }
                }else{
                  $alertas['error'][] = "Error en sistema intentalo nuevamente";
                  //ELIMINAR FACTURA por error en actualizar inventario
                  //revertir la ultima actualizacion de la tabla cierrecaja
                  $tempfactura->actualizar();
                  $factmediospagodelete = factmediospago::eliminar_idregistros('id_factura', [$factura->id]);
                  $tempultimocierre->actualizar();
                }
                /*
                $inv = productos::updatereduceinv($productos, 'stock');
                if($inv){
                  $alertas['exito'][] = "Pago procesado con exito";
                }else{
                  //ACTUALIZAR FACTURA COMO ESTABA ANTES: por error en actualizar inventario
                  //eliminar los registros de fact mediospago
                  //revertir la ultima actualizacion de la tabla cierrecaja
                  $alertas['error'][] = "Error en sistema intentalo nuevamente";
                  $tempfactura->actualizar();
                  $factmediospagodelete = factmediospago::eliminar_idregistros('id_factura', [$factura->id]);
                  $tempultimocierre->actualizar();
                }
                */
              }else{ //Si al actualizar los datos de cierre de caja
                $alertas['error'][] = "Error en sistema al actualizar datos de cierre intentalo nuevamente";
                //ACTUALIZAR FACTURA COMO ESTABA ANTES: por error en actualizar cierrecaja
                //eliminar los registros de  factmediospago
                $alertas['error'][] = "Error en sistema intentalo nuevamente";
                  $tempfactura->actualizar();
                  $factmediospagodelete = factmediospago::eliminar_idregistros('id_factura', [$factura->id]);
              }
            }else{ //Si alguardar los medios de pago da error
              $alertas['error'][] = "Error en sistema intentalo nuevamente";
              //ACTUALIZAR FACTURA COMO ESTABA ANTES: por error en actualizar medios pago
              $tempfactura->actualizar();
            }

          }else{
            $alertas['error'][] = "Error en el proceso de pago Intenta nuevamnete";
          }
        }else{
          $alertas['error'][] = "Error verifica que la orden ya no este pagada";
        }

      }else{ //fin cierrecaja valida si esta abierto
        $alertas['error'][] = "Cierre de caja cerrado, verifica el estado de orden";
      }
      
    }
    echo json_encode($alertas);
  }



  public static function eliminarOrden(){
    session_start();
    isadmin();
    $alertas = [];

    $factura = facturas::find('id', $_POST['id']);
    $cierrecaja = cierrescajas::find('id', $factura->idcierrecaja);
    $mediospago = factmediospago::uniquewhereArray(['id_factura'=>$factura->id, 'idmediopago'=>1])->valor??0; //me trae la factura que pago en efectivo
    $tempfactura = clone $factura;
    $tempcierrecaja = clone $cierrecaja;
    $invSub = true;
    $invPro = true;

    //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
    $resultArray = array_reduce(json_decode($_POST['inv']), function($acumulador, $objeto){
      //$objeto->id = $objeto->iditem;
      //unset($objeto->iditem);
        if($objeto->tipoproducto == 0){
          $acumulador['productosSimples'][] = $objeto;
        }
        else{
          $acumulador['productosCompuestos'][] = $objeto;
        }
        return $acumulador;
      }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);
    //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
    $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
    //////// sumar los subproductos repetidos
    $reduceSub = [];
    foreach($descontarSubproductos as $idx => $obj){
      if(!isset($reduceSub[$obj->id_subproducto])){
        $obj->id = $obj->id_subproducto;
        $reduceSub[$obj->id_subproducto] = $obj;
      }else{
      $reduceSub[$obj->id_subproducto]->cantidad += $obj->cantidad;
      }
    }


    if(!$factura){
      $alertas['error'][] = "Orden no se encuenta";
      echo json_encode($alertas);
      return;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      
      if($cierrecaja->estado == 0){ //si cierre de caja esta abierto
        $factura->estado = "Eliminada";

        /////////// calcular cantidad de facturas y discriminar por tipo
        $cierrecaja->totalfacturas = $cierrecaja->totalfacturas - 1;  //total de facturas
        if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
          $cierrecaja->facturaselectronicas = $cierrecaja->facturaselectronicas - 1;  //total de facturas electronicas
        }else{
          $cierrecaja->facturaspos = $cierrecaja->facturaspos - 1;   //total de facturas pos
        }
        ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
        $cierrecaja->ventasenefectivo =  $cierrecaja->ventasenefectivo - $mediospago;
        //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
        $cierrecaja->ingresoventas =  $cierrecaja->ingresoventas - $factura->total;
        $cierrecaja->totaldescuentos = $cierrecaja->totaldescuentos - $factura->descuento;


        $r = $factura->actualizar();
        if($r){
          if(!$factura->cotizacion){ //0 = factura,   1 = cotizacion
            $r1 = $cierrecaja->actualizar();
            if($r1){
              if($_POST['devolverinv'] == '1'){  //si se desea devolver a inventario
                


                //////// descontar del inventario los productos simples ////////
                if(!empty($resultArray['productosSimples']))$invPro = productos::addinv($resultArray['productosSimples'], 'stock');
                //////// descontar del inventario la variable reduceSub que es el total de subproductos a descontar
                if($invPro && !empty($reduceSub))$invSub = subproductos::addinv($reduceSub, 'stock');

                if($invPro){
                  if($invSub){
                    $alertas['exito'][] = "Orden eliminada correctamente";
                  }else{
                    $alertas['error'][] = "Error, intenta nuevamente";
                    $tempfactura->actualizar();
                    $tempcierrecaja->actualizar();
                    ///*revertir el inventario sumando lo que se desconto de productos simples
                  }
                }else{
                  //revertir la actualizacion de la factura
                  //revertir la actualizacion de cierrecaja
                  $alertas['error'][] = "Error, intenta nuevamente";
                  $tempfactura->actualizar();
                  $tempcierrecaja->actualizar();
                }

                ///////////// devolver a inventario
                /*$inv = productos::updateaddinv(json_decode($_POST['inv']), 'stock');
                if($inv){
                  $alertas['exito'][] = "Orden eliminada correctamente";
                }else{
                  //revertir la actualizacion de la factura
                  //revertir la actualizacion de cierrecaja
                  $alertas['error'][] = "Error, intenta nuevamente";
                  $tempfactura->actualizar();
                  $tempcierrecaja->actualizar();
                }*/


              }else{
                $alertas['exito'][] = "Orden eliminada correctamente";
              }
            }else{
              $alertas['error'][] = "Error, intenta nuevamente";
              //revertir la actualizacion de la factura
              $tempfactura->actualizar();
            }
          }else{  //si cotizacion es igual 1, es o fue una cotizacion
            $alertas['exito'][] = "Cotizacion Eliminada";
          }
        }else{
          $alertas['error'][] = "Error, intenta nuevamente";
        }

      }else{
        $alertas['error'][] = "Cierre de caja ya se encuentra cerrado";
      }
    }

    echo json_encode($alertas);
  }

}