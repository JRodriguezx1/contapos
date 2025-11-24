<?php

namespace App\Controllers;

use App\classes\Email;
use App\classes\Traits\DocumentTrait;
use App\Models\ActiveRecord;
use App\Models\configuraciones\usuarios; //namespace\clase hija
use App\Models\inventario\productos;
use App\Models\inventario\categorias;
use App\Models\configuraciones\mediospago;
use App\Models\caja\factmediospago;
use App\Models\clientes\clientes;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
use App\Models\configuraciones\tarifas;
use App\Models\caja\cierrescajas;
use App\Models\clientes\departments;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\tipofacturador;
use App\Models\factimpuestos;
use App\Models\impuestos;
use App\Models\parametrizacion\config_local;
use App\Models\inventario\productos_sub;
use App\Models\inventario\stockinsumossucursal;
use App\Models\inventario\stockproductossucursal;
use App\Models\inventario\subproductos;
use App\Models\sucursales;
use App\services\stockService;
//use App\Models\configuraciones\negocio;
use MVC\Router;  //namespace\clase
use stdClass;

class ventascontrolador{

  use DocumentTrait;

  public static function index(Router $router):void{
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de venta')&&userPerfil()>3)return;
    $alertas = [];
    $idsucursal = id_sucursal();

    $facturacotz = [];
    $productoscotz = [];
    $num_orden = facturas::calcularNumOrden(id_sucursal());

    if(isset($_GET['id'])){
      $id = $_GET['id'];
      if(!is_numeric($id))return;
      //obtener datos de la factura guardada o cotizacion
      $facturacotz = facturas::find('id', $id);
      if($facturacotz->cotizacion == 1 && $facturacotz->cambioaventa == 0 && $facturacotz->id_sucursal == $idsucursal){
        $productoscotz = ventas::idregistros('idfactura', $id);
        $num_orden = $facturacotz->num_orden;
      }else{ return;}
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    //$productos = productos::all();
    $productos = productos::unJoinWhereArrayObj(stockproductossucursal::class, 'id', 'productoid', ['sucursalid'=>id_sucursal(), 'habilitarventa'=>1]);
    $categorias = categorias::all();
    $mediospago = mediospago::whereArray(['estado'=>1]);
    $clientes = clientes::all();
    $tarifas = tarifas::all();
    $cajas = caja::whereArray(['idsucursalid'=>$idsucursal, 'estado'=>1]);
    $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
    $departments = departments::all();

    $conflocal = config_local::getParamCaja();

    $router->render('admin/ventas/index', ['titulo'=>'Ventas', 'num_orden'=>$num_orden, 'facturacotz'=>$facturacotz, 'productoscotz'=>$productoscotz, 'categorias'=>$categorias, 'productos'=>$productos, 'mediospago'=>$mediospago, 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'departments'=>$departments, 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
  }


  ///////////  API REST llamada desde ventas.ts cuando se procesa un pago  ////////////
  public static function facturar(){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de venta')&&userPerfil()>3)return;
    date_default_timezone_set('America/Bogota');
    $getDB = facturas::getDB();
    $carrito = json_decode($_POST['carrito']); //[{id: "1", idcategoria: "3", nombre: "xxx", cantidad: "4"}, {}]
    $mediospago = json_decode($_POST['mediosPago']); //[{id: "1", id_factura: "3", idmediopago: "1", valor: "400050"}, {}]
    $factimpuestos = json_decode($_POST['factimpuestos']);
    $datosAdquiriente = json_decode($_POST['datosAdquiriente']);
    $factura = new facturas($_POST);
    $factura->id_sucursal = id_sucursal();
    $venta = new ventas();
    $factmediospago = new factmediospago();
    $detalleimpuestos = new factimpuestos();
    $alertas = [];
    $invSub = true;
    $invPro = true;
    $c = true;

    
    //////// EXTRAER LOS PRODUCTOS ACTUALIZADOS, ELIMINADOS O NUEVOS DEL CARRITO POR SI SE ACTUALIZA LA COTIZACION ////////
    $carritoupdate=[];
    $carritoinsert=[];
    $idsProductsupdate=[];
    $idsProductos = [];
    foreach($carrito as $value){ //si en carrito un id, viene vacio o null es porque desde el front se agrego y el front no save el id de la tabla venta
      $idsProductos[] = $value->idproducto; //obtener los ids de los productos enviados desde el front
      $mapCarrito[$value->idproducto] = $value->cantidad;
      if(!empty($value->id)){
        $carritoupdate[] = clone $value;
        $idsProductsupdate[] = $value->id;
      }else{
        $carritoinsert[] = $value;
      }
    }


    $conflocal = config_local::getParamCaja();
    //////// CALCULAR PRODUCTOS AGOTADOS /////////
    if($conflocal['permitir_venta_de_productos_sin_stock']->valor_final == 0){ //no permitir vender sin stock
      $productosDB = stockproductossucursal::IN_Where('productoid', $idsProductos, ['sucursalid', id_sucursal()]);
      foreach($productosDB as $item){
        if(($item->stock - $mapCarrito[$item->productoid])<=0){
          $alertas['error'][] = "Productos agotados, no es posible vender";
          echo json_encode($alertas);
          return;
        }
      }
    }
    

    //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
    $resultArray = array_reduce($carrito, function($acumulador, $objeto){
      $obj = clone $objeto;
      $obj->id = $objeto->idproducto;
      //unset($objeto->iditem);
      if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){  //producto simple o producto compuesto de tipo produccion construccion, solo se descuenta sus cantidades, y sus insumos cuando se hace produccion en almacen del producto compuesto
        if(!isset($acumulador['productosSimples'][$objeto->id])){
          $acumulador['productosSimples'][$objeto->id] = $obj;
          $acumulador['soloIdproductos'][] = $obj->id;
        }else{
          $acumulador['productosSimples'][$objeto->id]->cantidad += $obj->cantidad;
        }
      }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){  //producto compuesto e inmediato es decir por cada venta se descuenta sus insumos
        if(!isset($acumulador['productosCompuestos'][$objeto->id])){
          $acumulador['productosCompuestos'][$objeto->id] = $obj;
        }else{
          $acumulador['productosCompuestos'][$objeto->id]->cantidad += $obj->cantidad;
        }
        $acumulador['productosCompuestos'][$objeto->id]->porcion = round((float)$acumulador['productosCompuestos'][$objeto->id]->cantidad/(float)$objeto->rendimientoestandar, 4);
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


    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      //////////validar datos de factura, de ventas y medios de pago
      
      //si viene id, es cotizacion cargada en modulo de venta
      if(!empty($_POST['id'])){
        if(!is_numeric($_POST['id']))return;  //validar que el id de la cotizacion sea numero
        $factura = facturas::find('id', $_POST['id']);
        $ultimocierre = cierrescajas::find('id', $factura->idcierrecaja);
        if($factura->cotizacion == 1 && $factura->cambioaventa == 0){ //validar que la cotizacion aun se encuentre en estado de cotizacion
          if($ultimocierre->estado==1 || $factura->idcaja != $_POST['idcaja'] && $_POST['estado']=='Paga'){ //si la cotizacion que se va a pagar, cambio de caja o si su cierre caja esta cerrado
            $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idcaja'], 'idsucursal_id'=>id_sucursal()]);
          }
          if($_POST['estado']=='Paga'){  //si es una cotizacion que se va a pagar
            //$factura->compara_objetobd_post($_POST);
            $factura->cotizacion = 1;
            $factura->cambioaventa = 1;
            $factura->estado = 'Aceptada';
            $idctz = $factura->id;
          }else{
            $factura->compara_objetobd_post($_POST);
          }
        
          $Ctz = $factura->actualizar();
          $r[0] = 1;
        }else{
          return;
        }
      }else{
        $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idcaja'], 'idsucursal_id'=>id_sucursal()]);
      }
      
      if(!isset($ultimocierre) && $_POST['estado']=='Paga' || !isset($ultimocierre)&&empty($_POST['id'])&&$_POST['estado']=='Guardado'){ // si la caja esta cerrada y se hace apertura con la venta o cotizacion
        $ultimocierre = new cierrescajas(['idcaja'=>$_POST['idcaja'], 'nombrecaja'=>caja::find('id', $_POST['idcaja'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
        $ruc = $ultimocierre->crear_guardar();
        if(!$ruc[0])$ultimocierre->estado = 1;
        $ultimocierre->id = $ruc[1];
      }


      $tempultimocierre = clone $ultimocierre;
      if($ultimocierre->estado == 0){ //si cierre de caja esta abierto
        
        if(!empty($_POST['id'])&&$_POST['estado']=='Paga'){ //crear nuevo registro para cotizacion que se va a facturar
          $factura->compara_objetobd_post($_POST);
          //$factura->cotizacion = 1;
          $factura->cambioaventa = 1;
          $factura->referencia = $factura->num_orden;  //numero de orden de la cotizacion, que toma ya la factura como referencia
          $factura->estado =  'Paga';
          $ultimocierre->ncambiosaventa = $ultimocierre->ncambiosaventa +1;
        }

        if($_POST['estado']=='Paga' || empty($_POST['id'])&&$_POST['estado']=='Guardado'){
          $factura->idcierrecaja = $ultimocierre->id;
          //calcular ultimo num_orden
          $factura->num_orden = facturas::calcularNumOrden(id_sucursal());
          //calcular siguiente consecutivo solo para facturas que se paguen
          if($_POST['estado']=='Paga'){
            $getDB->begin_transaction();
            try {
              $consecutivo = consecutivos::findForUpdate('id', $_POST['idconsecutivo']);
              $numConsecutivo = $consecutivo->siguientevalor;
              $factura->num_consecutivo = $numConsecutivo;
              $factura->prefijo = $consecutivo->prefijo;
              $r = $factura->crear_guardar();
              $consecutivo->siguientevalor = $numConsecutivo + 1;
              $c = $consecutivo->actualizar();
              $fe = self::createInvoiceElectronic($carrito, $datosAdquiriente, $factura->idconsecutivo, $r[1], $factura->num_consecutivo, $mediospago, $factura->descuento);  //llamada al trait para crear el json y guardar la FE en DB
              //....
            
              $getDB->commit();
            } catch (\Throwable $th) {
              $getDB->rollback();
              $alerta['error'][] = "Error al procesar el pago, y al obtener el consecutivo.";
              $alerta['error'][] = $th->getMessage();
            }
          }
          if($_POST['estado']=='Guardado')$r = $factura->crear_guardar();  //crear factura o cotizacion segun estado que se envia desde ventas.ts
        }

        if($r[0]&&$c || $Ctz){
          /////////   si se pago   ////////////////
          if($factura->estado == "Paga"){
            if(!empty($_POST['id'])){
              //obtener la factura cotizacion para establecer la referencia con la factura
              $facturacotizacion = facturas::find('id', $idctz);
              $facturacotizacion->referencia = $factura->num_orden;
              $rctz = $facturacotizacion->actualizar();
            }
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
              if($obj->idmediopago == 1){
                $ultimocierre->ventasenefectivo =  $ultimocierre->ventasenefectivo + $obj->valor;
              }
            }
            //////// establecer el id de factura para factimpuestos ////////////
            foreach($factimpuestos as $obj)$obj->facturaid = $r[1];

            $ultimocierre->domicilios = $ultimocierre->domicilios + $factura->valortarifa;
            //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
            $ultimocierre->ingresoventas =  $ultimocierre->ingresoventas + $factura->total;
            $ultimocierre->totaldescuentos = $ultimocierre->totaldescuentos + $factura->descuento;
            $ultimocierre->valorimpuestototal = $ultimocierre->valorimpuestototal + $factura->valorimpuestototal;
            $ultimocierre->basegravable += $factura->base;
            //////////// Guardar los productos de la venta en tabla ventas //////////////
            foreach($carrito as $obj){
              $obj->dato1 = '';
              $obj->dato2 = '';
              $obj->idfactura = $r[1];
              if($obj->idproducto<0&&$obj->idcategoria<0&&$obj->id==''){ //para productos "Otros"
                $obj->id = 1;
                $obj->idproducto = 1;
                $obj->idcategoria = 1;
              }
            }

            $r3[0] = true;
            $r1 = $venta->crear_varios_reg_arrayobj($carrito);  //crear los productos de la factura en tabla venta (detalle de los productos de la factura de venta)
            $r2 = $factmediospago->crear_varios_reg_arrayobj($mediospago); //crear los distintos metodos de pago en tabla factmediospago
            if(!empty($factimpuestos))$r3 = $detalleimpuestos->crear_varios_reg_arrayobj($factimpuestos);

            if($r1[0] && $r2[0] && $r3[0]){
              $ru = $ultimocierre->actualizar();
              if($ru){

                //////// descontar del inventario los productos simples ////////
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
                if($invPro){
                  if($invSub){

                    $alertas['exito'][] = "Pago procesado con exito";
                    $alertas['idfactura'] = $r[1];
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
            if($factura->cotizacion == 1 && $factura->cambioaventa == 0 && !empty($_POST['id']) && is_numeric($_POST['id']) && $_POST['estado']=='Guardado'){
              //algoritmo si se cambia la cotizacion como productos, cantidades valores etc.
              $idsExistentes = ventas::multicampos('idfactura', $factura->id, 'id');
              /*$carritoupdate=[];
              $carritoinsert=[];
              $idsProductsupdate=[];
              foreach($carrito as $value){
                if(!empty($value->id)){
                  $carritoupdate[] = $value;
                  $idsProductsupdate[] = $value->id;
                }else{
                  $carritoinsert[] = $value;
                }
              }*/
              foreach($carritoinsert as $obj){
                $obj->dato1 = '';
                $obj->dato2 = '';
                $obj->idfactura = $factura->id;
                if($obj->id<0&&$obj->id!=''){  //para productos "Otros"
                  $obj->id = 1;  //este es el id de Otros.
                  $obj->idproducto = 1;
                  $obj->idcategoria = 1;
                }
              }  
              $idseliminar = array_diff($idsExistentes, $idsProductsupdate);

              ventas::updatemultiregobj($carritoupdate, ['valorunidad', 'cantidad', 'subtotal', 'base', 'impuesto', 'valorimp', 'descuento', 'total']);
              if(!empty($carritoinsert))$venta->crear_varios_reg_arrayobj($carritoinsert);
               if(!empty($idseliminar))ventas::eliminar_idregistros('id', $idseliminar);

              $alertas['exito'][] = "Cotizacion actualizada con exito";
              echo json_encode($alertas);
              return;

            }else{
              $ultimocierre->totalcotizaciones = $ultimocierre->totalcotizaciones + 1;
              //////////// Guardar los productos de la venta en tabla ventas //////////////
              foreach($carrito as $obj){
                $obj->dato1 = '';
                $obj->dato2 = '';
                $obj->idfactura = $r[1];
                if($obj->id<0&&$obj->id!=''){  //para productos "Otros"
                  $obj->id = 1;  //este es el id de Otros.
                  $obj->idproducto = 1;
                  $obj->idcategoria = 1;
                }
              }
              
              $rc = $venta->crear_varios_reg_arrayobj($carrito);  //crear los productos de la factura guardada o cotizacion en tabla venta
            }

            if($rc[0]){
              $ru = $ultimocierre->actualizar();
              if($ru){
                $alertas['exito'][] = "Cotizacion guardada con exito";
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



 //////////////// cuando de cotizacion o guardada pasa a orden pagada sin modificar la factura o sus productos /////////////////
  public static function facturarCotizacion(){
    session_start();
    isadmin();
    $getDB = facturas::getDB();
    $factura = facturas::find('id', $_POST['id']);
    $ultimocierre = cierrescajas::find('id', $factura->idcierrecaja);
    
    if($ultimocierre->estado==1 || $factura->idcaja != $_POST['idcaja']){ //1 = cerrado, 0 = abierto
      //validar si la caja seleccionada a facturar esta abierta.
      $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idcaja'], 'idsucursal_id'=>id_sucursal()]); //ultimo cierre por caja
      if(!isset($ultimocierre)){ // si la caja esta cerrada, y se hace apertura con la venta
        $ultimocierre = new cierrescajas(['idcaja'=>$_POST['idcaja'], 'nombrecaja'=>caja::find('id', $_POST['idcaja'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
        $r = $ultimocierre->crear_guardar();
        if(!$r[0])$ultimocierre->estado = 1;
        $ultimocierre->id = $r[1];
      }
    }

    $productos = ventas::idregistros('idfactura', $factura->id);
    $mediospago = json_decode($_POST['mediosPago']);
    //$datosAdquiriente = json_decode($_POST['datosAdquiriente']);
    $factmediospago = new factmediospago();
    $detalleimpuestos = new factimpuestos();
    $alertas = [];
    $invPro = true;
    $invSub = true;
    $tempfactura = clone $factura;
    $tempultimocierre = clone $ultimocierre;
   
    //CAMBIA EL id POR EL idproducto
    foreach($productos as $value)$value->id = $value->idproducto;

    //////////  SEPARAR LOS PRODUCTOS COMPUESTOS DE PRODUCTOS SIMPLES  ////////////
      $resultArray = array_reduce($productos, function($acumulador, $objeto){
      //$objeto->id = $objeto->iditem;
      //unset($objeto->iditem);
        if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){
          $acumulador['productosSimples'][] = $objeto;
          $acumulador['soloIdproductos'][] = $objeto->id;
        }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){
          $objeto->porcion = round((float)$objeto->cantidad/(float)$objeto->rendimientoestandar, 4);
          $acumulador['productosCompuestos'][] = $objeto;
        }
        return $acumulador;
      }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);

    
    //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
    $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
    //////// sumar los subproductos repetidos
    $reduceSub = [];
    $soloIdInsumos = [];
    foreach($descontarSubproductos as $idx => $obj){
      if(!isset($reduceSub[$obj->id_subproducto])){
        $obj->id = $obj->id_subproducto;
        $reduceSub[$obj->id_subproducto] = $obj;
        $soloIdInsumos[] = $obj->id;
      }else{
      $reduceSub[$obj->id_subproducto]->cantidad += $obj->cantidad;
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      
      if($ultimocierre->estado == 0){ //si cierre de caja esta abierto

        if($factura && $factura->estado == "Guardado"){  // si la factura guardada existe
            $factura->compara_objetobd_post($_POST);
            $factura->estado = 'Aceptada';
            $r = $factura->actualizar();
            $idctz = $factura->id;
          
            //$factura->cotizacion = 1;
            $factura->cambioaventa = 1;
            $factura->referencia = $factura->num_orden;  //numero de orden de la cotizacion, que toma ya la factura como referencia
            $factura->estado = 'Paga';
            //calcular ultimo num_orden
            $factura->num_orden = facturas::calcularNumOrden(id_sucursal());
            
            //calcular siguiente consecutivo
            $getDB->begin_transaction();
            try {
              $consecutivo = consecutivos::findForUpdate('id', $_POST['idconsecutivo']);
              $numConsecutivo = $consecutivo->siguientevalor;
              $factura->num_consecutivo = $numConsecutivo;
              $factura->prefijo = $consecutivo->prefijo;
              $r = $factura->crear_guardar();
              $consecutivo->siguientevalor = $numConsecutivo + 1;
              $c = $consecutivo->actualizar();
              //$fe = self::createInvoiceElectronic($productos, $datosAdquiriente, $factura->idconsecutivo, $r[1]);  //llamada al trait para crear el json y guardar la FE en DB
              //....
              $getDB->commit();
            } catch (\Throwable $th) {
              $getDB->rollback();
              $alerta['error'][] = "Error al procesar el pago, y al obtener el consecutivo.";
              $alerta['error'][] = $th->getMessage();
            }
          
            $factura->id = $r[1];
            
            //obtener la factura cotizacion para establecer la referencia con la factura
            $facturacotizacion = facturas::find('id', $idctz);
            $facturacotizacion->referencia = $factura->num_orden;
            $rctz = $facturacotizacion->actualizar();
            //CAMBIA al nuevo idfactura
            foreach($productos as $value)$value->idfactura = $r[1];
            $venta = new ventas();
            $venta->crear_varios_reg_arrayobj($productos);
          
          if($r){
            /////////// calcular cantidad de cotizaciones a ventas, facturas y discriminar por tipo
            $ultimocierre->ncambiosaventa = $ultimocierre->ncambiosaventa +1;
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
              $obj->id_factura = $factura->id;
              if($obj->idmediopago == 1){
                $ultimocierre->ventasenefectivo =  $ultimocierre->ventasenefectivo + $obj->valor;
              }
            }
            $ultimocierre->domicilios = $ultimocierre->domicilios + $factura->valortarifa;
            //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
            $ultimocierre->ingresoventas =  $ultimocierre->ingresoventas + $factura->total;
            $ultimocierre->totaldescuentos = $ultimocierre->totaldescuentos + $factura->descuento;
            $ultimocierre->valorimpuestototal = $ultimocierre->valorimpuestototal + $factura->valorimpuestototal;
            $ultimocierre->basegravable += $factura->base;


            
            // calcular impuestos de la cotizacion que se paga directamente en ordenresumen.ts
            $factimpuestos = [];
            $arrayImp = ['0'=>1, '5'=>2, '16'=>3, '19'=>4, 'excluido'=>5, '8'=>6];
            foreach($productos as $value){
              $id_impuesto = $arrayImp[$value->impuesto];
              if(!isset($factimpuestos[$value->impuesto])){
                $factimpuestos[$value->impuesto] = (object)[
                    "id_impuesto"   => $id_impuesto,
                    "facturaid"     => $factura->id,
                    "basegravable"  => 0,
                    "valorimpuesto" => 0,
                ];
              }
              $factimpuestos[$value->impuesto]->basegravable += $value->base;
              $factimpuestos[$value->impuesto]->valorimpuesto += $value->valorimp;
            }


            /// productos ya estan en tabla ventas
             $r3[0] = true;
            $r1 = $factmediospago->crear_varios_reg_arrayobj($mediospago); //crear los distintos metodos de pago en tabla factmediospago
            if(!empty($factimpuestos))$r3 = $detalleimpuestos->crear_varios_reg_arrayobj($factimpuestos);
            
            if($r1[0] && $r3[0]){
              $ru = $ultimocierre->actualizar();
              if($ru){
                //////// descontar del inventario los productos simples ////////
                if(!empty($resultArray['productosSimples'])){
                  $invPro = stockproductossucursal::reduceinv1condicion($resultArray['productosSimples'], 'stock', 'productoid', "sucursalid = ".id_sucursal());
                  //registrar descuento de movimiento de invnetario
                  $query = "SELECT * FROM stockproductossucursal WHERE productoid IN(".join(', ', $resultArray['soloIdproductos']).") AND sucursalid = ".id_sucursal().";";
                  $returnProductos = stockproductossucursal::camposJoinObj($query);
                  stockService::downStock_movimientoProductos($resultArray['productosSimples'], $returnProductos, 'venta', 'descuento de unidades por venta');
                }
                  //////// descontar del inventario la variable reduceSub que es el total de subproductos a descontar
                if($invPro && !empty($reduceSub)){
                  $invSub = stockinsumossucursal::reduceinv1condicion($reduceSub, 'stock', 'subproductoid', "sucursalid = ".id_sucursal());
                  //registrar descuento de movimiento de invnetario
                  $query = "SELECT * FROM stockinsumossucursal WHERE subproductoid IN(".join(', ', $soloIdInsumos).") AND sucursalid = ".id_sucursal().";";
                  $returnInsumos = stockinsumossucursal::camposJoinObj($query);
                  stockService::downStock_movimientoInsumos($reduceSub, $returnInsumos, 'venta', 'descuento de unidades por venta');
                }
                if($invPro){
                  if($invSub){
                    $alertas['idfactura'] = $factura->id;
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



  public static function eliminarOrden(){  //llamada dedse ordenresumen.ts
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
        if($objeto->tipoproducto == 0 || ($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 1)){
          $acumulador['productosSimples'][] = $objeto;
          $acumulador['soloIdproductos'][] = $objeto->id;
        }elseif($objeto->tipoproducto == 1 && $objeto->tipoproduccion == 0){
          $objeto->porcion = round((float)$objeto->cantidad/(float)$objeto->rendimientoestandar, 4);
          $acumulador['productosCompuestos'][] = $objeto;
        }
        return $acumulador;
      }, ['productosSimples'=>[], 'productosCompuestos'=>[]]);
    //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
    $descontarSubproductos = productos_sub::cantidadSubproductosXventa($resultArray['productosCompuestos']);
    //////// sumar los subproductos repetidos
    $reduceSub = [];
    $soloIdInsumos = [];
    foreach($descontarSubproductos as $idx => $obj){
      if(!isset($reduceSub[$obj->id_subproducto])){
        $obj->id = $obj->id_subproducto;
        $reduceSub[$obj->id_subproducto] = $obj;
        $soloIdInsumos[] = $obj->id;
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
      
      if($cierrecaja->estado == 0 &&  $factura->estado == 'Paga'){ //si cierre de caja esta abierto y factura paga
        $factura->estado = "Eliminada";

        /////////// calcular cantidad de facturas y discriminar por tipo
        $cierrecaja->totalfacturaseliminadas += 1;
        if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
          $cierrecaja->facturaselectronicaselimnadas += -1;
          $cierrecaja->valorfe -= $factura->total;
          $cierrecaja->descuentofe -= $factura->descuento;
        }else{
          $cierrecaja->facturasposeliminadas += -1;
          $cierrecaja->valorpos -= $factura->total;
          $cierrecaja->descuentopos += $factura->descuento;
        }
        ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
        $cierrecaja->ventasenefectivo =  $cierrecaja->ventasenefectivo - $mediospago;
        //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
        $cierrecaja->ingresoventas =  $cierrecaja->ingresoventas - $factura->total;
        $cierrecaja->totaldescuentos = $cierrecaja->totaldescuentos - $factura->descuento;
        $cierrecaja->valorimpuestototal -= $factura->valorimpuestototal;
        $cierrecaja->basegravable -= $factura->base;

        $r = $factura->actualizar();
        if($r){
            $r1 = $cierrecaja->actualizar();
            if($r1){
              //eliminar detalle impuesto
              $detallefacturaimp = factimpuestos::find('facturaid', $factura->id);
              $detallefacturaimp->eliminar_registro();
              if($_POST['devolverinv'] == '1'){  //si se desea devolver a inventario
                

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
        }else{
          $alertas['error'][] = "Error, intenta nuevamente";
        }

      }else{
        $alertas['error'][] = "Cierre de caja ya se encuentra cerrado";
      }
    }

    echo json_encode($alertas);
  }


  public static function getcotizacion_venta(){
    session_start();
    isadmin();
    $alertas = [];
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      if(!is_numeric($id))return;
      //obtener datos de la factura guardada o cotizacion
      $facturacotz = facturas::uniquewhereArray(['id'=>$id, 'id_sucursal'=>id_sucursal()]);
      if($facturacotz->cotizacion == 1 && $facturacotz->cambioaventa == 0){
        $productoscotz = ventas::idregistros('idfactura', $id);
        foreach($productoscotz as $value){ //convertir a tipo de dato numero
          $value->valorunidad = (int)$value->valorunidad;
          $value->cantidad = (float)$value->cantidad;
          $value->subtotal = (float)$value->subtotal;
          $value->base = (float)$value->base;
          $value->impuesto = (int)$value->impuesto;
          $value->valorimp = (float)$value->valorimp;
          $value->descuento = (int)$value->descuento;
          $value->total = (float)$value->total;
        }
        $alertas['exito'][] = "Cotizacion cargada con exito";
        $alertas['factura'] = $facturacotz;
        $alertas['productos'] = $productoscotz;
      }else{ 
        $alertas['error'][] = "No es posible obtener datos de factura";
      }
    }
    echo json_encode($alertas);
  }

}