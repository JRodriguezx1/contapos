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
use App\Models\felectronicas\adquirientes;
use App\Models\impuestos;
use App\Models\parametrizacion\config_local;
use App\Models\inventario\productos_sub;
use App\Models\sucursales;
use App\Repositories\ventas\canalVentaRepository;
use App\services\creditosService;
use App\services\ventasService;
use App\services\comisionesService;
use App\services\contableService;
use App\services\whatsAppService;
//use App\Models\configuraciones\negocio;
use MVC\Router;  //namespace\clase
use stdClass;

class ventascontrolador{

  use DocumentTrait;

  public static function index(Router $router):void{
    //session_start();
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
      if(($facturacotz->cotizacion == 1 || $facturacotz->remision == 1) && $facturacotz->cambioaventa == 0 && $facturacotz->id_sucursal == $idsucursal){
        $productoscotz = ventasService::adjuntarInsumos(ventas::idregistros('idfactura', $id));
        $num_orden = $facturacotz->num_orden;
      }else{ 
        return;
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    //$productos = productos::all();
    //$productos = productos::unJoinWhereArrayObj(stockproductossucursal::class, 'id', 'productoid', ['sucursalid'=>id_sucursal(), 'habilitarventa'=>1]);
    $productos = productos::SelectProducts_Category_StockXsucursal(); //filtra habilitarventa = 1
    $categorias = categorias::all();
    $mediospago = mediospago::whereArray(['estado'=>1]);
    $clientes = clientes::all();
    $tarifas = tarifas::all();
    $cajas = caja::whereArray(['idsucursalid'=>$idsucursal, 'estado'=>1]);
    $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
    $departments = departments::all();
    //$usuarios = usuarios::whereArray(['idsucursal'=>$idsucursal]);
    $usuarios = usuarios::camposJoinObj("SELECT * FROM usuarios WHERE idsucursal = $idsucursal OR perfil IN (1, 2, 3);");

    $conflocal = config_local::getParamCaja();

    $canalesVentaRepo = new canalVentaRepository();
    $canalesVenta = $canalesVentaRepo->all();
    
    //validar resoluciiones por rango y por fecha
    $hoy = new \DateTime();
    $resolucionesVencidas = [];
    foreach($consecutivos as $item){
      $diferencia = (int) $item->rangofinal - (int) $item->siguientevalor;
      $condicionRango = $diferencia <= 50;

      $fechaFin = new \DateTime($item->fechafin);
      $diasRestantes = (int) $hoy->diff($fechaFin)->format('%r%a');
      $condicionFecha = $diasRestantes <= 10;

      if($condicionRango || $condicionFecha){
        $resolucionesVencidas[] = $item;
        if($diferencia<=0 || $diasRestantes<=0)$item->vencido = 1;
      }
    }

    $router->render('admin/ventas/index', ['titulo'=>'Ventas', 'num_orden'=>$num_orden, 'facturacotz'=>$facturacotz, 'productoscotz'=>$productoscotz, 'categorias'=>$categorias, 'productos'=>$productos, 'mediospago'=>$mediospago, 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'cajas'=>$cajas, 'consecutivos'=>$consecutivos, 'canalesVenta'=>$canalesVenta, 'departments'=>$departments, 'usuarios'=>$usuarios, 'conflocal'=>$conflocal, 'resolucionesVencidas'=>$resolucionesVencidas, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
  }


  ///////////  API REST llamada desde ventas.ts cuando se procesa un pago  ////////////
  public static function facturar(){
    isadmin();
    if(!tienePermiso('Habilitar modulo de venta')&&userPerfil()>3)return;

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      echo json_encode(['error'=>['Metodo del endpoint no valido.']]);
      return;
    }

    date_default_timezone_set('America/Bogota');
    $getDB = facturas::getDB();
    $sucursalId = id_sucursal();
    $estado = (string)($_POST['estado'] ?? '');
    $tipoVenta = (string)($_POST['tipoventa'] ?? 'Contado');

    if(!in_array($estado, ['Paga', 'Guardado', 'Remision'], true)){
      echo json_encode(['error'=>['Estado de la solicitud no valido.']]);
      return;
    }
    if($estado === 'Paga' && !in_array($tipoVenta, ['Contado', 'Credito'], true)){
      echo json_encode(['error'=>['El tipo de venta no es valido.']]);
      return;
    }
    if(isset($_POST['id']) && $_POST['id'] !== '' && !is_numeric($_POST['id'])){
      echo json_encode(['error'=>['El identificador de la orden no es valido.']]);
      return;
    }

    // Todos los JSON del formulario se normalizan en un unico lugar. Esto evita
    // continuar con null cuando el navegador envia un cuerpo incompleto o invalido.
    try {
      $decodificarArray = static function(string $campo):array{
        $valor = json_decode($_POST[$campo] ?? '[]');
        if(json_last_error() !== JSON_ERROR_NONE || !is_array($valor))
          throw new \InvalidArgumentException("El campo {$campo} no contiene un arreglo JSON valido.");
        return $valor;
      };
      $decodificarObjeto = static function(string $campo):object{
        $valor = json_decode($_POST[$campo] ?? '{}');
        if(json_last_error() !== JSON_ERROR_NONE || !is_object($valor))
          throw new \InvalidArgumentException("El campo {$campo} no contiene un objeto JSON valido.");
        return $valor;
      };

      $carrito = $decodificarArray('carrito');
      $mediospago = $decodificarArray('mediosPago');
      $factimpuestos = $decodificarArray('factimpuestos');
      $valoresCredito = $decodificarObjeto('valoresCredito');
      $datosAdquiriente = $decodificarObjeto('datosAdquiriente');
    }catch(\Throwable $th){
      echo json_encode(['error'=>[$th->getMessage()]]);
      return;
    }

    if(empty($carrito)){
      echo json_encode(['error'=>['El carrito no contiene productos para procesar.']]);
      return;
    }

    $facturaSolicitud = new facturas($_POST);
    $facturaSolicitud->id_sucursal = $sucursalId;
    $alertasFactura = $facturaSolicitud->validar_nueva_factura();
    if(!empty($alertasFactura['error'])){
      echo json_encode($alertasFactura);
      return;
    }

    // Normalizar cantidades antes de resolver receta, variaciones e inventario.
    foreach($carrito as $linea){
      $linea->cantidad = (float)($linea->stock ?? $linea->cantidad ?? 0);
      $promedio = (float)($linea->promediostock ?? 0);
      $linea->stockaux = $promedio > 0 ? $linea->cantidad / $promedio : 0;
    }

    $inventarioVenta = ventasService::prepararInventarioXVenta($carrito, $sucursalId);
    $conflocal = config_local::getParamCaja();
    if(($conflocal['permitir_venta_de_productos_sin_stock']->valor_final ?? 0) == 0){
      $erroresStock = ventasService::validarDisponibilidadInventario($inventarioVenta, $sucursalId);
      if(!empty($erroresStock)){
        echo json_encode(['error'=>$erroresStock]);
        return;
      }
    }

    // Las lineas con id pertenecen a una cotizacion recuperada; las demas son
    // productos agregados durante su edicion.
    $lineasActualizar = [];
    $lineasInsertar = [];
    foreach($carrito as $linea){
      if(!empty($linea->id))$lineasActualizar[] = clone $linea;
      else $lineasInsertar[] = $linea;
    }

    $idOrdenOrigen = (int)($_POST['id'] ?? 0);
    $ordenOrigen = null;
    if($idOrdenOrigen > 0){
      $ordenOrigen = facturas::find('id', $idOrdenOrigen);
      $esCotizacionORemision = $ordenOrigen && ( (int)$ordenOrigen->cotizacion === 1 || (int)$ordenOrigen->remision === 1 || $ordenOrigen->estado === 'Remision' );

      if(!$ordenOrigen || (int)$ordenOrigen->id_sucursal !== $sucursalId || !$esCotizacionORemision || (int)$ordenOrigen->cambioaventa !== 0){
        echo json_encode(['error'=>['La cotizacion o remision no esta disponible para procesar.']]);
        return;
      }
    }

    // Editar una cotizacion/remision existente no genera factura, pagos ni
    // inventario. actualizarLineasCotizacion administra su propia transaccion.
    if($ordenOrigen && $estado !== 'Paga'){
      $tipoOrdenValido = ($estado === 'Guardado' && (int)$ordenOrigen->cotizacion === 1) || ($estado === 'Remision' && ((int)$ordenOrigen->remision === 1 || $ordenOrigen->estado === 'Remision'));
      if(!$tipoOrdenValido){
        echo json_encode(['error'=>['No es posible cambiar el tipo de la orden recuperada.']]);
        return;
      }

      $ordenAnterior = clone $ordenOrigen;
      try {
        $ordenOrigen->compara_objetobd_post($_POST);
        $ordenOrigen->id_sucursal = $sucursalId;
        $ordenOrigen->estado = $estado;
        $ordenOrigen->cotizacion = $estado === 'Guardado' ? 1 : 0;
        $ordenOrigen->remision = $estado === 'Remision' ? 1 : 0;
        $ordenOrigen->cambioaventa = 0;
        if(!$ordenOrigen->actualizar())
          throw new \RuntimeException('No fue posible actualizar el encabezado de la orden.');

        foreach($lineasInsertar as $linea){
          $linea->idfactura = $ordenOrigen->id;
          $linea->dato1 = '';
          $linea->dato2 = '';
          if((int)($linea->idproducto ?? 0) < 0 && (int)($linea->idcategoria ?? 0) < 0){
            $linea->idproducto = 1;
            $linea->idcategoria = 1;
          }
        }

        ventasService::actualizarLineasCotizacion($lineasActualizar,$lineasInsertar, (int)$ordenOrigen->id);
        echo json_encode(['exito'=>['Orden actualizada con exito.']]);
        return;
      }catch(\Throwable $th){
        // El servicio revierte sus lineas; se restaura tambien el encabezado.
        try {
          $ordenAnterior->actualizar();
        }catch(\Throwable $ignorado){}
        echo json_encode(['error'=>['Error al actualizar la orden. '.$th->getMessage()]]);
        return;
      }
    } //fin edicion cotizacion/remision

    $comisionServicio = new comisionesService();
    $contableService = new contableService();
    $factmediospago = new factmediospago();
    $detalleimpuestos = new factimpuestos();

    // Venta pagada, cotizacion nueva y remision nueva comparten una sola
    // transaccion. Los servicios internos reciben false para no abrir otra.
    $getDB->begin_transaction();
    try {
      $idCaja = (int)($_POST['idcaja'] ?? 0);
      if($idCaja <= 0)throw new \RuntimeException('Caja no valida.');
      $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$idCaja, 'idsucursal_id'=>$sucursalId,]);

      // El modulo de ventas conserva su comportamiento: si no existe cierre
      // abierto para la caja seleccionada, lo crea dentro de esta transaccion.
      if(!$ultimocierre){
        $cajaSeleccionada = caja::find('id', $idCaja);
        if(!$cajaSeleccionada)throw new \RuntimeException('La caja seleccionada no existe.');
        $ultimocierre = new cierrescajas(['idcaja'=>$idCaja, 'nombrecaja'=>$cajaSeleccionada->nombre, 'estado'=>0, 'idsucursal_id'=>$sucursalId,]);
        [$cierreCreado, $idCierre] = $ultimocierre->crear_guardar();
        if(!$cierreCreado)throw new \RuntimeException('No fue posible abrir el cierre de caja.');
        $ultimocierre->id = $idCierre;
      }

      // Al pagar una orden recuperada se conserva la original como Aceptada y
      // se crea una factura nueva relacionada por sus numeros de orden.
      if($ordenOrigen){
        $numeroOrdenOrigen = $ordenOrigen->num_orden;
        $factura = clone $ordenOrigen;
        $factura->compara_objetobd_post($_POST);
        $factura->id = null;
        $factura->referencia = $numeroOrdenOrigen;
        $factura->cambioaventa = 1;
      }else{
        $factura = $facturaSolicitud;
      }

      $factura->id_sucursal = $sucursalId;
      $factura->idcaja = $idCaja;
      $factura->idcierrecaja = $ultimocierre->id;
      $factura->num_orden = facturas::calcularNumOrden($sucursalId);

      // Cotizacion o remision nueva: solo encabezado, lineas e indicador de caja.
      if($estado !== 'Paga'){
        $factura->estado = $estado;
        $factura->cotizacion = $estado === 'Guardado' ? 1 : 0;
        $factura->remision = $estado === 'Remision' ? 1 : 0;
        $factura->cambioaventa = 0;
        [$facturaCreada, $idFactura] = $factura->crear_guardar();
        if(!$facturaCreada)throw new \RuntimeException('No fue posible guardar la orden.');

        foreach($carrito as $linea){
          $linea->idfactura = $idFactura;
          $linea->dato1 = '';
          $linea->dato2 = '';
          if((int)($linea->idproducto ?? 0) < 0 && (int)($linea->idcategoria ?? 0) < 0){
            $linea->idproducto = 1;
            $linea->idcategoria = 1;
          }
        }
        ventasService::guardarLineasVenta($carrito, false);

        if($estado === 'Guardado')$ultimocierre->totalcotizaciones += 1;
        if(!$ultimocierre->actualizar())
          throw new \RuntimeException('No fue posible actualizar el cierre de caja.');

        $getDB->commit();
        $mensaje = $estado === 'Guardado' ? 'Cotizacion guardada con exito.' : 'Remision generada con exito.';
        echo json_encode(['exito'=>[$mensaje]]);
        return;
      } //fin Cotizacion o remision nueva


      // A partir de aqui siempre se procesa una factura pagada.
      $idConsecutivo = (int)($_POST['idconsecutivo'] ?? 0);
      $consecutivo = consecutivos::findForUpdate('id', $idConsecutivo);
      if(!$consecutivo || (int)$consecutivo->id_sucursalid !== $sucursalId)
        throw new \RuntimeException('El consecutivo seleccionado no es valido.');

      $factura->estado = 'Paga';
      $factura->cotizacion = 0;
      $factura->remision = 0;
      $factura->fechapago = date('Y-m-d H:i:s');
      $factura->fechaentrega = (int)$factura->entregado === 1 ? date('Y-m-d H:i:s') : '';
      $factura->num_consecutivo = $consecutivo->siguientevalor;
      $factura->prefijo = $consecutivo->prefijo;
      $factura->abono = $valoresCredito->abonoinicial ?? 0;
      $factura->habilitada = 1;

      [$facturaCreada, $idFactura] = $factura->crear_guardar();
      if(!$facturaCreada)throw new \RuntimeException('No fue posible crear la factura.');

      $consecutivo->siguientevalor += 1;
      if(!$consecutivo->actualizar())
        throw new \RuntimeException('No fue posible actualizar el consecutivo.');

      if($ordenOrigen){
        $ordenOrigen->estado = 'Aceptada';
        $ordenOrigen->cambioaventa = 1;
        $ordenOrigen->referencia = $factura->num_orden;
        if(!$ordenOrigen->actualizar())
          throw new \RuntimeException('No fue posible relacionar la orden con la factura.');
        $ultimocierre->ncambiosaventa += 1;
      }

      // Guarda localmente el JSON de factura electronica cuando el consecutivo
      // seleccionado corresponde a este tipo de documento.
      self::createInvoiceElectronic($carrito, $datosAdquiriente, $factura->idconsecutivo, $idFactura, $factura->num_consecutivo, $mediospago, $factura->descuento, $factura->valortarifa, $factura->observacion);

      // El credito participa en la transaccion de la factura y entrega el id de
      // cuota que debe relacionarse con los medios de pago del abono inicial.
      $idCuota = 'NULL';
      if($tipoVenta === 'Credito'){
        $resultadoCredito = creditosService::crearCredito( $valoresCredito, $idFactura, (int)$factura->idcliente, $factura->totalunidades, $factura->base, $factura->valorimpuestototal, (int)$factura->dctox100, $factura->descuento, (int)$factura->idcierrecaja, (int)$factura->idcaja, (int)$factura->idvendedor, $factura->idemisor );
        if(!empty($resultadoCredito['error']))throw new \RuntimeException(implode(' ', $resultadoCredito['error']));
        $idCuota = $resultadoCredito['idcuota'] ?? 'NULL';
      }

      // Este servicio prepara los FK de pagos/impuestos y actualiza todos los
      // acumulados generales del cierre de caja.
      $ultimocierre->descuentocontado += $tipoVenta === 'Credito' ? 0 : $factura->descuento;
      $ultimocierre->descuentocredito += $tipoVenta === 'Contado' ? 0 : $factura->descuento;
      ventasService::datosDelCierreCajaXVenta($ultimocierre, $factura, $mediospago, $factimpuestos, [true, $idFactura], $valoresCredito );
      foreach($mediospago as $pago)$pago->idcuota = $idCuota;

      foreach($carrito as $linea){
        $linea->idfactura = $idFactura;
        $linea->dato1 = '';
        $linea->dato2 = '';
        if((int)($linea->idproducto ?? 0) < 0 && (int)($linea->idcategoria ?? 0) < 0){
          $linea->idproducto = 1;
          $linea->idcategoria = 1;
        }
      }
      ventasService::guardarLineasVenta($carrito, false);

      if(!empty($mediospago))$factmediospago->crear_varios_reg_arrayobj($mediospago);
      if(!empty($factimpuestos))$detalleimpuestos->crear_varios_reg_arrayobj($factimpuestos);

      // Una venta a domicilio pendiente de despacho descuenta inventario cuando
      // se marque como entregada; las ventas presenciales lo hacen de inmediato.
      if((int)$factura->entregado === 1 || $factura->entrega === 'Presencial'){
        ventasService::descontarInventarioXVenta($inventarioVenta, $sucursalId, 'venta', 'descuento de unidades por venta', false);
      }

      $numFactura = $factura->prefijo.$factura->num_consecutivo;
      $movimientoCaja = $contableService->createMovimiento([
        'fk_tipo_movimientocaja'=>$tipoVenta === 'Contado' ? 1 : 11,
        'fk_tipo_documento'=>1,
        'id_documento'=>$idFactura,
        'fk_tipo_tercero'=>1,
        'id_tercero'=>$factura->idcliente,
        'fk_caja'=>$factura->idcaja,
        'fk_usuario'=>$factura->idvendedor,
        'naturaleza'=>'I',
        'numero_documento'=>$numFactura,
        'num_orden'=>null,
        'valor'=>$tipoVenta === 'Contado' ? $factura->total : $factura->abono,
        'concepto'=>$tipoVenta === 'Contado' ? 'PAGO DE CONTADO' : 'ABONO INICIAL',
        'observacion'=>$tipoVenta === 'Contado' ? 'PAGO DE CONTADO A FACTURA' : 'ABONO INICIAL A FACTURA CREDITO',
      ]);
      if(!($movimientoCaja[0] ?? false))
        throw new \RuntimeException('No fue posible registrar el movimiento de caja.');

      if((float)$factura->valorgananciauser > 0){
        $comisionServicio->crearComision( $idFactura, (int)$factura->idvendedor, (float)$factura->total, (float)$factura->porcentgananciauser, (float)$factura->valorgananciauser );
      }

      $dataInvoice = ventasService::dataInvoiceForPrinterServer($datosAdquiriente, $factura, $consecutivo);

      $getDB->commit();
      $respuesta = [ 'exito'=>['Pago procesado con exito.'], 'idfactura'=>$idFactura, 'dataInvoice'=>$dataInvoice, ];
      if($tipoVenta === 'Credito' && $idCuota !== 'NULL')$respuesta['idcuota'] = $idCuota;
      echo json_encode($respuesta);
      return;
    }catch(\Throwable $th){
      $getDB->rollback();
      echo json_encode(['error'=>['Error al procesar la solicitud. '.$th->getMessage()]]);
      return;
    }
  }



 //////////////// cuando de cotizacion o guardada pasa a orden pagada sin modificar la factura o sus productos /////////////////
  public static function facturarCotizacion(){
    //session_start();
    isadmin();
    $comisionServicio = new comisionesService();
    $contableService = new contableService();
    $getDB = facturas::getDB();
    $factura = facturas::find('id', $_POST['id']);
    $ultimocierre = cierrescajas::find('id', $factura->idcierrecaja);
    
    if($ultimocierre->estado==1 || $factura->idcaja != $_POST['idcaja']){ //1 = cerrado, 0 = abierto
      //validar si la caja seleccionada a facturar esta abierta.
      $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idcaja'], 'idsucursal_id'=>id_sucursal()]); //ultimo cierre por caja
      /*if(!isset($ultimocierre)){ // si la caja esta cerrada, y se hace apertura con la venta
        $ultimocierre = new cierrescajas(['idcaja'=>$_POST['idcaja'], 'nombrecaja'=>caja::find('id', $_POST['idcaja'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
        $r = $ultimocierre->crear_guardar();
        if(!$r[0])$ultimocierre->estado = 1;
        $ultimocierre->id = $r[1];
      }*/
    }

    $productos = ventas::idregistros('idfactura', $factura->id);
    $inventarioVenta = ventasService::prepararInventarioPersistido($productos, id_sucursal());
    $mediospago = json_decode($_POST['mediosPago']);
    //$datosAdquiriente = json_decode($_POST['datosAdquiriente']);
    $datosAdquiriente = json_decode(json_encode(adquirientes::find('id', 1)));  //convierte el objeto de la clase adquitiente a stdclass
    //debuguear($datosAdquiriente);
    $factmediospago = new factmediospago();
    $detalleimpuestos = new factimpuestos();
    $alertas = [];
    $invPro = true;
    $invSub = true;
    $tempfactura = clone $factura;
    $tempultimocierre = clone $ultimocierre;
   
    //CAMBIA EL id POR EL idproducto
    foreach($productos as $value){
      $value->id = $value->idproducto;
      $value->stock = $value->cantidad;
      $value->stockaux = $value->promediostock>0?$value->stock/$value->promediostock:0;
    }

    $conflocal = config_local::getParamCaja();
    if($conflocal['permitir_venta_de_productos_sin_stock']->valor_final == 0){
      $erroresStock = ventasService::validarDisponibilidadInventario($inventarioVenta, id_sucursal());
      if(!empty($erroresStock)){
        $alertas['error'] = $erroresStock;
        echo json_encode($alertas);
        return;
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      
      if($ultimocierre->estado == 0){ //si cierre de caja esta abierto

        if($factura && ($factura->estado == "Guardado" || $factura->estado == "Remision")){  // si la factura guardada existe
            $factura->compara_objetobd_post($_POST);
            $factura->estado = 'Aceptada';
            $r = $factura->actualizar();
            $idctz = $factura->id;
          
            //$factura->cotizacion = 1;
            $factura->tipoventa = 'Contado';
            $factura->referencia = $factura->num_orden;  //numero de orden de la cotizacion, que toma ya la factura como referencia
            $factura->estado = 'Paga';
            $factura->entregado = 1;
            $factura->fechapago = date('Y-m-d H:i:s');
            //calcular ultimo num_orden
            $factura->num_orden = facturas::calcularNumOrden(id_sucursal());
            
            //calcular siguiente consecutivo
            $getDB->begin_transaction();
            try {
              $consecutivo = consecutivos::findForUpdate('id', $_POST['idconsecutivo']);
              $numConsecutivo = $consecutivo->siguientevalor;
              $factura->num_consecutivo = $numConsecutivo;
              $factura->prefijo = $consecutivo->prefijo;
              $factura->habilitada = 1;
              $r = $factura->crear_guardar();
              $consecutivo->siguientevalor = $numConsecutivo + 1;
              $c = $consecutivo->actualizar();
              $fe = self::createInvoiceElectronic($productos, $datosAdquiriente, $factura->idconsecutivo, $r[1], $factura->num_consecutivo, $mediospago, $factura->descuento, $factura->valortarifa, $factura->observacion);  //llamada al trait para crear el json y guardar la FE en DB
              //....
              if($factura->valorgananciauser>0)
                $comisionServicio->crearComision($r[1], $factura->idvendedor, $factura->total, $factura->porcentgananciauser, $factura->valorgananciauser);
              $getDB->commit();
            } catch (\Throwable $th) {
              $getDB->rollback();
              $alertas['error'][] = "Error al procesar el pago, y al obtener el consecutivo.";
              $alertas['error'][] = $th->getMessage();
            }
          
            $factura->id = $r[1];
            
            //obtener la factura cotizacion para establecer la referencia con la factura
            $facturacotizacion = facturas::find('id', $idctz);
            $facturacotizacion->referencia = $factura->num_orden;
            $rctz = $facturacotizacion->actualizar();
            //CAMBIA al nuevo idfactura
            foreach($productos as $value)$value->idfactura = $r[1];
            ventasService::guardarLineasVenta($productos, (int)$r[1]);
          
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
              $obj->cierrecajaid = $ultimocierre->id;
              $obj->idcuota = 'NULL';
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
                if($factura->cotizacion == 1){  //solo se descuenta de inventario cunado la cotizacion se paga.
                  $inventarioActualizado = ventasService::descontarInventarioXVenta(
                    $inventarioVenta,
                    id_sucursal()
                  );
                  $invPro = $inventarioActualizado;
                  $invSub = $inventarioActualizado;
                }
                  
                if($invPro){
                  if($invSub){
                    $numFactura = $factura->prefijo.$factura->num_consecutivo;
                    $contableService->createMovimiento([
                      'fk_tipo_movimientocaja'=>1,
                      'fk_tipo_documento'=>1,
                      'id_documento'=>$r[1],
                      'fk_tipo_tercero'=>$factura->idcliente,
                      'id_tercero'=>$factura->idcliente,
                      'fk_caja'=>$factura->idcaja,
                      'fk_usuario'=>$factura->idvendedor,
                      'naturaleza'=>'I',
                      'numero_documento'=>$numFactura,
                      'num_orden'=>null,
                      'valor'=>$factura->total,
                      'concepto'=>'PAGO DE CONTADO A FACTURA',
                      'observacion'=>$factura->tipoventa=='Contado'?'PAGO DE CONTADO A FACTURA':'ABONO INICIAL A FACTURA CREDITO'
                    ]);
                    
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
    //session_start();
    isadmin();
    $alertas = [];

    $contableService = new contableService();
    $factura = facturas::find('id', $_POST['id']);
    $cierrecaja = cierrescajas::find('id', $factura->idcierrecaja);
    $mediospago = factmediospago::uniquewhereArray(['id_factura'=>$factura->id, 'idmediopago'=>1])->valor??0; //me trae la factura que pago en efectivo
    $conflocal = config_local::getParamCaja();
    $tempfactura = clone $factura;
    $tempcierrecaja = clone $cierrecaja;
    $invSub = true;
    $invPro = true;

    $productosFactura = ventas::idregistros('idfactura', (int)$_POST['id']);
    $inventarioVenta = ventasService::prepararInventarioPersistido($productosFactura, id_sucursal());
    $resultArray = [
      'productosSimples' => $inventarioVenta['productosSimples'],
      'soloIdproductos' => $inventarioVenta['soloIdproductos'],
    ];


    if(!$factura){
      $alertas['error'][] = "Orden no se encuenta";
      echo json_encode($alertas);
      return;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      
      if($cierrecaja->estado == 0 && $factura->estado == 'Paga' || $factura->tipoventa == 'Credito'){ //si cierre de caja esta abierto y factura paga
        $factura->estado = "Eliminada";
        $factura->observacioneliminacion = $_POST['observacioneliminacion'];
        $factura->fechaanulacion = date('Y-m-d H:i:s');

        /////////// calcular cantidad de facturas y discriminar por tipo
        $cierrecaja->totalfacturaseliminadas += 1;
        if(consecutivos::uncampo('id', $factura->idconsecutivo, 'idtipofacturador')==1){
          $cierrecaja->facturaselectronicaselimnadas += 1;
          $cierrecaja->valorfe -= $factura->total;
          $cierrecaja->descuentofe -= $factura->descuento;
        }else{
          $cierrecaja->facturasposeliminadas += 1;
          $cierrecaja->valorpos -= $factura->total;
          $cierrecaja->descuentopos += $factura->descuento;
        }

        ///////// calcular ventas en efectivo, total descuentos, total ingreso de ventas

        if($factura->tipoventa=='Contado'){
          $cierrecaja->ventasenefectivo =  $cierrecaja->ventasenefectivo - $mediospago;
          //tarifas::tableAJoin2TablesWhereId('direcciones', 'idtarifa', $factura->iddireccion)->valor;
          $cierrecaja->ingresoventas =  $cierrecaja->ingresoventas - $factura->total;
        }else{
          $cierrecaja->creditocapital -= $factura->total;
          $cierrecaja->creditos -= ($factura->total-$factura->abono);
        }

        $cierrecaja->domicilios -= $factura->valortarifa;
        $cierrecaja->totaldescuentos = $cierrecaja->totaldescuentos - $factura->descuento;
        $cierrecaja->valorimpuestototal -= $factura->valorimpuestototal;
        $cierrecaja->basegravable -= $factura->base;

        $r = $factura->actualizar();
        if($r){
            //eliminar comision del empleado
            if($factura->porcentgananciauser>0 && $factura->valorgananciauser>0){
              $comisionServicio = new comisionesService();
              $comisionServicio->eliminarComisionXFactura($factura->id);
            }

            $r1 = $cierrecaja->actualizar();
            if($r1){
              ///descuenta los abonos de creditos por caja, si el cierre de caja no se ha cerrado 
              if($factura->tipoventa=='Credito')$anularCredito = creditosService::anularCredito($factura->id);  //me vuelve a actualizar el cierre de caja
              if(isset($anularCredito['error'])){
                $tempfactura->actualizar();
                $tempcierrecaja->actualizar();
                echo json_encode($anularCredito);
                return;
              }
              //eliminar detalle impuesto
              $detallefacturaimp = factimpuestos::find('facturaid', $factura->id);
              $contableService->anularMovimiento(1, $factura->id, $factura->observacioneliminacion);
              if($detallefacturaimp)$detallefacturaimp->eliminar_registro();
              if($_POST['devolverinv'] == '1'){  //si se desea devolver a inventario
                $inventarioDevuelto = ventasService::devolverInventarioXVenta(
                  $inventarioVenta,
                  id_sucursal()
                );
                $invPro = $inventarioDevuelto;
                $invSub = $inventarioDevuelto;
                if($invPro){
                  if($invSub){
                    $alertas['exito'][] = "Orden eliminada correctamente";
                    //enviar notificacion por ws
                    $ws = new whatsAppService();
                    if($conflocal['notificacion_por_whatsApp_eliminacion_de_factura']->valor_final == 1)
                      $ws->sendTextOrdenEliminada($factura, $cierrecaja->idcaja, true, $resultArray['productosSimples']);
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


              }else{
                $alertas['exito'][] = "Orden eliminada correctamente";
                //enviar notificacion por ws
                $ws = new whatsAppService();
                $ws->sendTextOrdenEliminada($factura, $cierrecaja->idcaja, false);
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
        $alertas['error'][] = "Cierre de caja ya se encuentra cerrado o orden ya esta eliminada";
      }
    }

    echo json_encode($alertas);
  }


  public static function getcotizacion_venta(){
    //session_start();
    isadmin();
    $alertas = [];
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      if(!is_numeric($id))return;
      //obtener datos de la factura guardada o cotizacion
      $facturacotz = facturas::uniquewhereArray(['id'=>$id, 'id_sucursal'=>id_sucursal()]);
      if(($facturacotz->cotizacion == 1 || $facturacotz->remision == 1) && $facturacotz->cambioaventa == 0){
        $productoscotz = ventasService::adjuntarInsumos(ventas::idregistros('idfactura', $id));
        foreach($productoscotz as $value){ //convertir a tipo de dato numero
          $value->valorunidad = (int)$value->valorunidad;
          $value->cantidad = (float)$value->cantidad;
          $value->stock = (float)$value->cantidad;
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



  public static function detalleProductoCompuesto(){
      isadmin();
      $idsucursal = id_sucursal();
      $idproducto = $_GET['idproducto'];
      $idfactura = $_GET['idfactura'];
      if(!is_numeric($idproducto) || !is_numeric($idfactura))return;
      $productoCompuesto = ventas::uniquewhereArray(['idfactura'=>$idfactura, 'idproducto'=>$idproducto, 'tipoproducto'=>1]);
      $sql = "SELECT x.id, x.id_producto, x.id_subproducto, TRUNCATE((x.cantidadsubproducto*$productoCompuesto->cantidad)/$productoCompuesto->rendimientoestandar, 3) as cantidadcalculada, 
              TRUNCATE((x.costo*$productoCompuesto->cantidad)/$productoCompuesto->rendimientoestandar, 3) as costo, sp.nombre, sp.sku, sp.precio_compra, u.nombre as unidadmedida, u.simbolo, si.stock as disponibilidad, si.stockminimo 
              FROM productos_sub x
              INNER JOIN subproductos sp ON x.id_subproducto = sp.id
              INNER JOIN unidadesmedida u ON sp.id_unidadmedida = u.id
              INNER JOIN stockinsumossucursal si ON sp.id = si.subproductoid
              WHERE x.id_producto = 2 AND si.sucursalid = $idsucursal;";
      $detalleProducto = productos_sub::camposJoinObj($sql);
      echo json_encode($detalleProducto);
      return;
    }

}
