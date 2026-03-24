<?php

namespace App\Controllers;

use App\Classes\Traits\DocumentTrait;
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
use App\Models\factimpuestos;
use App\Models\felectronicas\adquirientes;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Repositories\ventas\canalVentaRepository;
use App\Models\inventario\stockproductossucursal;
use App\services\ventasService;
use MVC\Router;  //namespace\clase
 
class modorapidocontrolador{

    use DocumentTrait;

    public static function index(Router $router){
        isadmin();
        if(!tienePermiso('Habilitar modulo de venta')&&userPerfil()>3)return;
        $alertas = [];
        $idsucursal = id_sucursal();
        $num_orden = facturas::calcularNumOrden(id_sucursal());
        $categorias = categorias::all();
        $mediospago = mediospago::whereArray(['estado'=>1]);
        $clientes = clientes::all();
        $tarifas = tarifas::all();
        $cajas = caja::whereArray(['idsucursalid'=>$idsucursal, 'estado'=>1]);
        $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
        $departments = departments::all();

        $conflocal = config_local::getParamCaja();

        $canalesVentaRepo = new canalVentaRepository();
        $canalesVenta = $canalesVentaRepo->all();

        $router->render('admin/modorapido/index', ['titulo'=>'Ventas', 'num_orden'=>$num_orden, 'categorias'=>$categorias, 'mediospago'=>$mediospago, 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'canalesVenta'=>$canalesVenta, 'departments'=>$departments, 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


  ///////////  API REST llamada desde ventas.ts cuando se procesa un pago  ////////////
  public static function facturarModorapido(){
    isadmin();
    if(!tienePermiso('Habilitar modulo de venta')&&userPerfil()>3)return;
    date_default_timezone_set('America/Bogota');
    $getDB = facturas::getDB();
    $carrito = json_decode($_POST['carrito']); //[{id: "1", idcategoria: "3", nombre: "xxx", cantidad: "4"}, {}]
    $mediospago = json_decode($_POST['mediosPago']); //[{id: "1", id_factura: "3", idmediopago: "1", valor: "400050"}, {}]
    $factimpuestos = json_decode($_POST['factimpuestos']);
    $valoresCredito = json_decode($_POST['valoresCredito']);
    $datosAdquiriente = json_decode($_POST['datosAdquiriente']);
    $factura = new facturas($_POST);
    $factura->id_sucursal = id_sucursal();
    $venta = new ventas();
    $factmediospago = new factmediospago();
    $detalleimpuestos = new factimpuestos();
    $alertas = [];


    
    //////// EXTRAER LOS PRODUCTOS ACTUALIZADOS, ELIMINADOS O NUEVOS DEL CARRITO POR SI SE ACTUALIZA LA COTIZACION ////////
    $carritoupdate=[];
    $carritoinsert=[];
    $idsProductsupdate=[];
    $idsProductos = [];
    foreach($carrito as $value){ //si en carrito un id, viene vacio o null es porque desde el front se agrego y el front no save el id de la tabla venta
      $idsProductos[] = $value->idproducto; //obtener los ids de los productos enviados desde el front
      $mapCarrito[$value->idproducto] = $value->cantidad;  //se usa para saber si se vende sin stock
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
    

    if($_SERVER['REQUEST_METHOD'] !== 'POST' ){
      $alertas['error'][] = "Metodo del Endpoint no es valido";
      echo json_encode($alertas);
      return;
    }

    //obtener el ultimo cierre de caja abierto segun caja seleccionada
    $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idcaja'], 'idsucursal_id'=>id_sucursal()]);

    $getDB->begin_transaction();
    try {
      // si la caja esta cerrada y se hace apertura con la venta o cotizacion
      if(!isset($ultimocierre) && $_POST['estado']=='Paga' /*|| !isset($ultimocierre)&&empty($_POST['id'])&&$_POST['estado']=='Guardado'*/){
          $ultimocierre = new cierrescajas(['idcaja'=>$_POST['idcaja'], 'nombrecaja'=>caja::find('id', $_POST['idcaja'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
          $ruc = $ultimocierre->crear_guardar();
          $ultimocierre->id = $ruc[1];
      }
      $factura->idcierrecaja = $ultimocierre->id;
      //calcular ultimo num_orden
      $factura->num_orden = facturas::calcularNumOrden(id_sucursal());
      //calcular siguiente consecutivo solo para facturas que se paguen
      if($_POST['estado']=='Paga'){
        $consecutivo = consecutivos::findForUpdate('id', $_POST['idconsecutivo']);
        $factura->num_consecutivo = $consecutivo->siguientevalor;
        $factura->prefijo = $consecutivo->prefijo;
        $factura->abono = $valoresCredito->abonoinicial??0;
        $factura->habilitada = 1;
        $r = $factura->crear_guardar();
        $consecutivo->siguientevalor += 1;
        $c = $consecutivo->actualizar();
        $fe = self::createInvoiceElectronic($carrito, $datosAdquiriente, $factura->idconsecutivo, $r[1], $factura->num_consecutivo, $mediospago, $factura->descuento, $factura->valortarifa);  //llamada al trait para crear el json y guardar la FE en DB

        /////////// calcular cantidad de facturas y discriminar por tipo
        // Y
        ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas
        ventasService::datosDelCierreCajaXVenta($ultimocierre, $factura, $mediospago, $factimpuestos, $r, $valoresCredito);
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

        $venta->crear_varios_reg_arrayobj($carrito);  //crear los productos de la factura en tabla venta (detalle de los productos de la factura de venta)
        if(!empty($mediospago))$factmediospago->crear_varios_reg_arrayobj($mediospago); //crear los distintos metodos de pago en tabla factmediospago
        if(!empty($factimpuestos))$detalleimpuestos->crear_varios_reg_arrayobj($factimpuestos);

        $resultArray = ventasService::reducirIventarioXVenta($carrito);  //$resultArray['productosSimples'] y $resultArray['productosCompuestos']
        $alertas['exito'][] = "Pago procesado con exito";
        $alertas['idfactura'] = $r[1];
        $alertas['dataInvoice'] = ventasService::dataInvoiceForPrinterServer($datosAdquiriente, $factura, $consecutivo);

      //Si es cotizacion
      }else{
        
        $alertas['exito'][] = "Cotizacion guardada con exito";
      }

      $getDB->commit();
      echo json_encode($alertas);
      return;
    } catch (\Throwable $th) {
      $getDB->rollback();
      $alerta['error'][] = "Error al procesar el pago. >>{$th->getMessage()}";
      echo json_encode($alertas);
      return;
    }


  }


}