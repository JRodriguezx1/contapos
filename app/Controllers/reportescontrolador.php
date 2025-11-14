<?php
//$dias = facturacion::inner_join('SELECT COUNT(id) AS servicios, fecha_pago, SUM(total) AS totaldia FROM facturacion GROUP BY fecha_pago ORDER BY COUNT(id) DESC;');
namespace App\Controllers;

use App\Models\ActiveRecord;
use App\Models\caja\cierrescajas;
use App\Models\caja\ingresoscajas;
use App\Models\compras;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\usuarios;
use App\Models\detallecompra;
use App\Models\gastos;
use App\Models\inventario\productos;
use App\Models\inventario\proveedores;
use App\Models\inventario\stockinsumossucursal;
use App\Models\inventario\stockproductossucursal;
use App\Models\inventario\subproductos;
use App\Models\ventas\facturas;
use MVC\Router;  //namespace\clase
 
class reportescontrolador{

    public static function index(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/index', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    ///////////////////////// Reportes ///////////////////////////////////
    public static function ventasgenerales(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/ventasgenerales', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function ventasxtransaccion(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/ventasxtransaccion', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function vistaVentasxcliente(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/ventasxcliente', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function facturaspagas(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/facturas/facturaspagas', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }


    public static function creditos(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];
        $router->render('admin/reportes/facturas/creditos', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }
    
    public static function facturasanuladas(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/facturas/facturasanuladas', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function facturaselectronicas(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/facturas/facturaselectronicas', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    
    public static function facturaselectronicaspendientes(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/facturas/electronicaspendientes', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function inventarioxproducto(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];
        $sql = "SELECT sps.stock, p.nombre, p.unidadmedida, p.categoria, p.tipoproducto, p.stockminimo, p.fecha_ingreso
                FROM stockproductossucursal sps JOIN productos p ON sps.productoid = p.id
                WHERE p.estado = 1 AND p.visible = 1 AND sps.sucursalid = ".id_sucursal().";";
        $productos = productos::camposJoinObj($sql);

        $sql = "SELECT sis.stock, sp.nombre, sp.unidadmedida, sp.stockminimo, sp.fecha_ingreso
                FROM stockinsumossucursal sis JOIN subproductos sp ON sis.subproductoid = sp.id
                WHERE sis.sucursalid = ".id_sucursal().";";  
        $subproductos = subproductos::camposJoinObj($sql);

        $router->render('admin/reportes/inventario/inventarioxproducto', ['titulo'=>'Reportes', 'productos'=>$productos, 'subproductos'=>$subproductos, 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function movimientosinventarios(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/inventario/movimientosinventarios', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function compras(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/inventario/compras', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function detallecompra(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];
        $id=$_GET['id'];
        if(!is_numeric($id))return;

        $compra = compras::find('id', $id);
        $usuario = usuarios::find('id', $compra->idusuario);
        $proveedor = proveedores::find('id', $compra->idproveedor);
        $caja = caja::find('id', $compra->idorigencaja);
        $detallecompra = detallecompra::idregistros('idcompra', $compra->id);
        $router->render('admin/reportes/inventario/detallecompra', ['titulo'=>'Reportes', 'compra'=>$compra, 'usuario'=>$usuario, 'proveedor'=>$proveedor, 'caja'=>$caja, 'detallecompra'=>$detallecompra, 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function printDetalleCompra(Router $router){
        self::detallecompra($router);
    }

    public static function detalleInvoice(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];
        $id=$_GET['id'];
        if(!is_numeric($id))return;

        $router->render('admin/reportes/facturas/detalleinvoice', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }


    public static function utilidadxproducto(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];
        $productos = productos::whereArray(['visible'=>1]);
        $router->render('admin/reportes/utilidadgastoscrecimiento/utilidadxproducto', ['titulo'=>'Reportes', 'productos'=>$productos, 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function gastoseingresos(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/utilidadgastoscrecimiento/gastoseingresos', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function clientesnuevos(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/otros/clientesnuevos', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }

    public static function clientesrecurrentes(Router $router){
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de reportes')&&userPerfil()>=3)return;
        $alertas = [];

        $router->render('admin/reportes/otros/clientesrecurrentes', ['titulo'=>'Reportes', 'user'=>$_SESSION, 'alertas'=>$alertas]);
    }





  ////////////////////////////----    API      ----////////////////////////////////

  ///////////  API REST llamada desde reportes o fechazetadiario.ts  ////////////
  public static function consultafechazetadiario(){
    session_start();
    isadmin();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    $idcajas = json_decode($_POST['cajas']);
    $idconsecutivos = json_decode($_POST['facturadores']);
    $cajas = join(", ", array_values($idcajas));
    $consecutivos = join(", ", array_values($idconsecutivos));
    $datosventa = facturas::zDiarioTotalVentas($cajas, $consecutivos, id_sucursal(), $fechainicio, $fechafin);
    $datosmediospago = facturas::zDiarioMediosPago($cajas, $consecutivos, id_sucursal(), $fechainicio, $fechafin);
    $datos['datosventa'] = $datosventa;
    $datos['datosmediospago'] = $datosmediospago;
    echo json_encode($datos);
  }

  public static function reporteventamensual(){
    
  }

  //// grafica de ventas menusal año acutal de la vista principal de reportes index.php
  public static function ventasGraficaMensual(){
    session_start();
    isadmin();
    $data = facturas::ventasGraficaMensual(id_sucursal());
    $label = [];
    $datos = [];
    foreach($data as $value){
        $label[] = 'mes '.$value->mes;
        $datos[] = $value->total_venta;
    }
    echo json_encode(['label'=>$label, 'datos'=>$datos]);
  }


  //// grafica de ventas diarias mes acutal de la vista principal de reportes index.php
  public static function ventasGraficaDiario(){
    session_start();
    isadmin();
    $data = facturas::ventasGraficaDiario(id_sucursal());
    $label = [];
    $datos = [];
    foreach($data as $value){
        $label[] = 'dia '.$value->dia;
        $datos[] = $value->total_venta;
    }
    echo json_encode(['label'=>$label, 'datos'=>$datos]);
  }

  ///// grafica "Valor de los productos principales del inventario" vista principal de reportes index.php
  public static function graficaValorInventario(){
    session_start();
    isadmin();
    $sql = "SELECT SUM(sps.stock*p.precio_compra) AS costoinv, SUM(sps.stock*p.precio_venta) AS valorventa
    FROM stockproductossucursal sps JOIN productos p ON sps.productoid = p.id WHERE sps.sucursalid = ".id_sucursal().";";
    $datos = productos::camposJoinObj($sql);
    echo json_encode(array_shift($datos));
  }


  //transacciones acumuladas por mes durante año elegido
  public static function ventasxtransaccionanual(){
    session_start();
    isadmin();
    $datex = $_GET['x'];
    $idsucursal = id_sucursal();
    $sql = "SELECT DATE_FORMAT(fechapago, '%Y-%m') AS fecha, COUNT(*) AS num_transacciones,
            ROUND(AVG(total), 2) AS promedio_transaccion, SUM(total) AS total_venta,
            MAX(total) AS transaccion_mas_alta, MIN(total) AS transaccion_mas_baja
            FROM facturas WHERE fechapago >= CONCAT('$datex', '-01-01')
            AND fechapago < DATE_ADD(CONCAT('$datex', '-01-01'), INTERVAL 1 YEAR) AND estado = 'Paga' AND id_sucursal = $idsucursal
            GROUP BY DATE_FORMAT(fechapago, '%Y-%m') ORDER BY fecha;";
    $datos = productos::camposJoinObj($sql);
    echo json_encode($datos);
  }

  //transacciones acumuladas por dia durante mes y año elegido
  public static function ventasxtransaccionmes(){
    session_start();
    isadmin();
    $datex = $_GET['x'];
    $idsucursal = id_sucursal();
    $sql = "SELECT DATE(fechapago) AS fecha, COUNT(*) AS num_transacciones,
            ROUND(AVG(total), 2) AS promedio_transaccion, SUM(total) AS total_venta,
            MAX(total) AS transaccion_mas_alta, MIN(total) AS transaccion_mas_baja
            FROM facturas WHERE fechapago >= CONCAT('$datex', '-01')
            AND fechapago < DATE_ADD(CONCAT('$datex', '-01'), INTERVAL 1 MONTH) AND estado = 'Paga' AND id_sucursal = $idsucursal
            GROUP BY DATE(fechapago) ORDER BY fecha;";
    $datos = productos::camposJoinObj($sql);
    echo json_encode($datos);
  }

  //Ventas acumuladas por cliente en un periodo determinado
  public static function ventasxcliente(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $sql = "SELECT c.id, CONCAT(c.nombre,' ',c.apellido) AS nombre, COUNT(f.id) AS cantidad_facturas, SUM(f.total) AS total_ventas
              FROM facturas f JOIN clientes c ON f.idcliente = c.id
              WHERE f.fechapago BETWEEN '$fechainicio' AND '$fechafin' AND f.estado = 'Paga' AND f.id_sucursal = $idsucursal
              GROUP BY c.id, c.nombre;";
      $datos = productos::camposJoinObj($sql);
    }
    echo json_encode($datos);
  }


  //Facturas procesadas como pagas
  public static function apifacturaspagas(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $facturas = facturas::whereArrayBETWEEN('fechapago', $fechainicio, $fechafin, ['estado'=>'Paga', 'id_sucursal'=>$idsucursal]);
    }
    echo json_encode($facturas);
  }

  //Facturas procesadas que luego fueron anuladas
  public static function apifacturasanuladas(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $facturas = facturas::whereArrayBETWEEN('fechapago', $fechainicio, $fechafin, ['estado'=>'Eliminada', 'id_sucursal'=>$idsucursal]);
    }
    echo json_encode($facturas);
  }

  //Facturas electronicas aceptadas
  public static function apifacturaselectronicas(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $sql = "SELECT fe.id, fe.id_facturaid as orden, fe.prefijo, fe.numero, fe.cufe, fe.identificacion, fe.nombre, f.tipoventa, f.base, f.valorimpuestototal, f.total, fe.created_at
              FROM facturas_electronicas fe 
              JOIN facturas f ON fe.id_facturaid = f.id
              JOIN adquirientes a ON fe.id_adquiriente = a.id
              WHERE fe.created_at BETWEEN '$fechainicio' AND '$fechafin' AND fe.id_estadoelectronica = 2 AND f.id_sucursal = $idsucursal
              ORDER BY fe.created_at;";
      $datos = productos::camposJoinObj($sql);
    }
    echo json_encode($datos);
  }

  //Facturas electronicas pendientes
  public static function apielectronicaspendientes(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $sql = "SELECT fe.id, fe.id_facturaid as orden, fe.prefijo, fe.numero, fe.cufe, fe.identificacion, fe.nombre, f.tipoventa, f.base, f.valorimpuestototal, f.total, fe.created_at
              FROM facturas_electronicas fe 
              JOIN facturas f ON fe.id_facturaid = f.id
              JOIN adquirientes a ON fe.id_adquiriente = a.id
              WHERE fe.created_at BETWEEN '$fechainicio' AND '$fechafin' AND fe.id_estadoelectronica = 1 AND f.id_sucursal = $idsucursal
              ORDER BY fe.created_at;";
      $datos = productos::camposJoinObj($sql);
    }
    echo json_encode($datos);
  }

  //Reporte movimiento de inventarios
  public static function movimientoInventario(){
    session_start();
    isadmin();
    $datos = [];
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    $tipo = $_POST['tipo'];
    $iditem = $_POST['iditem'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      if($tipo == 0){ //productos
        $sql = "SELECT m.id, m.tipo, m.referencia, m.cantidad, m.stockanterior, m.stocknuevo, m.comentario, m.created_at,
                p.id as iditem, p.nombre, p.unidadmedida, CONCAT(u.nombre,' ',u.apellido) as usuario
                FROM movimientos_productos m
                JOIN productos p ON m.idproducto_id = p.id
                JOIN usuarios u ON m.id_usuarioid = u.id
                WHERE m.created_at BETWEEN '$fechainicio' AND '$fechafin' AND idproducto_id = $iditem AND idfksucursal = $idsucursal ORDER BY m.created_at DESC;";
      }else{  //subproductos - insumos
        $sql = "SELECT SELECT m.id, m.tipo, m.referencia, m.cantidad, m.stockanterior, m.stocknuevo, m.comentario, m.created_at,
                s.id as iditem, s.nombre, s.unidadmedida, CONCAT(u.nombre,' ',u.apellido) as usuario
                FROM movimientos_insumos m
                JOIN subproductos s ON m.id_subproductoid = s.id
                JOIN usuarios u ON m.idusuario_id = u.id
                WHERE m.created_at BETWEEN '$fechainicio' AND '$fechafin' AND id_subproductoid = $iditem AND fksucursal_id = $idsucursal ORDER BY m.created_at DESC;";
      }
      $datos = ActiveRecord::camposJoinObj($sql);
    }
    echo json_encode($datos);
  }

  //Reporte de compras
  public static function reportecompras(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $sql = "SELECT c.id, c.formapago, c.nfactura, c.impuesto, c.cantidaditems, c.observacion, c.estado, c.subtotal, c.valortotal, c.fechacompra,
              cc.estado AS estadocierrecaja, CONCAT(u.nombre,' ',u.apellido) as nombreusuario, p.nombre as nombreproveedor, cj.nombre as nombrecaja
              FROM compras c
              LEFT JOIN gastos g ON c.id = g.id_compra
              LEFT JOIN cierrescajas cc ON g.idg_cierrecaja = cc.id
              JOIN usuarios u ON c.idusuario = u.id 
              JOIN proveedores p ON c.idproveedor = p.id 
              JOIN caja cj ON c.idorigencaja = cj.id
              WHERE c.id_sucursal_id = $idsucursal AND c.fechacompra BETWEEN '$fechainicio' AND '$fechafin' ORDER BY c.fechacompra DESC;";
      $datos = productos::camposJoinObj($sql);
    }
    echo json_encode($datos);
  }

  public static function eliminarcompra(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $alertas = [];
    $compra = compras::uniquewhereArray(['id'=>$_POST['id'], 'id_sucursal_id'=>$idsucursal]);
    $detallecompra = detallecompra::idregistros('idcompra', $compra->id);
    $gasto = gastos::uniquewhereArray(['id_compra'=>$compra->id, 'id_sucursalfk'=>$idsucursal]);
    $rsps = true;
    $rsis = true;
    //////////  SEPARAR LOS ITEMS EN PRODUCTOS Y SUBPRODUCTOS  ////////////
    $resultArray = array_reduce($detallecompra, function($acumulador, $objeto){
      if($objeto->tipo == 0){
        $objeto->id = $objeto->idpx;
        $acumulador['productos'][] = $objeto; // puede ser producto compuesto o simple
      }
      else{
        $objeto->id = $objeto->idsx;
        $acumulador['subproductos'][] = $objeto;
      }
      return $acumulador;
    }, ['productos'=>[], 'subproductos'=>[]]);

    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $cierrecaja = cierrescajas::find('id', $gasto->idg_cierrecaja);
      if($cierrecaja->estado == 0){ //si cierre de caja esta abierto
        //eliminar compra 
        $rc = $compra->eliminar_registro(); // tambien se elimina el gasto por cascada de la tabla
        if($rc){
          if($gasto->id_banco!=null){ //ajustar gasto banco del cierre de caja
            $cierrecaja->gastosbanco -= $gasto->valor;
          }else{ //ajustar gasto caja efectivo del cierre de caja
            $cierrecaja->gastoscaja -= $gasto->valor;
          }
          $rcc = $cierrecaja->actualizar();
          if($rcc){
            //descontar del inventario
            if(!empty($resultArray['productos']))$rsps = stockproductossucursal::reduceinv1condicion($resultArray['productos'], 'stock', 'productoid', 'sucursalid = '.$idsucursal);
            if(!empty($resultArray['subproductos']))$rsis = stockinsumossucursal::reduceinv1condicion($resultArray['subproductos'], 'stock', 'subproductoid', 'sucursalid = '.$idsucursal);
            if($rsps&&$rsis){
              $alertas['exito'][] = "Compra eliminada correctamente";
            }else{
              $alertas['error'][] = "No se pudo eliminar la compra del cierre de caja";
              $compra->crear_guardar();
              $gasto->crear_guardar();
              //dejar el inventario original
            }
          }else{
            $alertas['error'][] = "No se pudo eliminar la compra del cierre de caja";
            $compra->crear_guardar();
            $gasto->crear_guardar();
          }
        }else{
          $alertas['error'][] = "No se pudo eliminar la compra";
        }
      }else{
        $alertas['error'][] = "Caja ya se encuentra cerrada";
      }
    }
    echo json_encode($alertas);
  }

  
  //Reporte de gastos e ingresos llamado desde gastoseingresos.ts
  public static function apigastoseingresos(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      //calculo de los gastos
      $sql = "SELECT g.id AS Id, g.fecha, CONCAT(u.nombre,' ',u.apellido) AS nombre, g.id_banco, b.nombre AS nombrebanco, g.idg_caja, c.nombre AS nombrecaja,
	            g.idg_cierrecaja, cj.estado, g.id_compra, g.operacion, g.idg_usuario, g.valor, g.imgcomprobante, cg.id , cg.nombre AS categoriagasto
              FROM gastos g JOIN categoriagastos cg ON g.idcategoriagastos = cg.id
              JOIN usuarios u ON g.idg_usuario = u.id
              JOIN cierrescajas cj ON g.idg_cierrecaja = cj.id
              LEFT JOIN bancos b ON g.id_banco = b.id
              JOIN caja c ON g.idg_caja = c.id
	            WHERE g.id_sucursalfk = $idsucursal AND g.fecha BETWEEN '$fechainicio' AND '$fechafin' ORDER BY g.fecha DESC;";
      $getgastos = gastos::camposJoinObj($sql);

      //calculo de los ingresos a caja
      $sql = "SELECT i.id, i.operacion, i.valor, i.fecha, c.nombre AS nombrecaja,
	            cj.estado, CONCAT(u.nombre,' ',u.apellido) AS nombreusuario
              FROM ingresoscajas i 
              JOIN usuarios u ON i.idusuario = u.id
              JOIN caja c ON i.id_caja = c.id
              JOIN cierrescajas cj ON i.id_cierrecaja = cj.id
              WHERE  i.idsucursal_idfk = 1 AND i.fecha BETWEEN '$fechainicio' AND '$fechafin' ORDER BY i.fecha DESC;";
      $getingresos = ingresoscajas::camposJoinObj($sql);
    }

    echo json_encode(['gastos'=>$getgastos, 'ingresos'=>$getingresos]);
  }


  //Reporte de gastos e ingresos llamado desde gastoseingresos.ts
  public static function eliminargasto(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $alertas = [];
    $gasto = gastos::uniquewhereArray(['id'=>$_POST['id'], 'id_sucursalfk'=>$idsucursal]);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $cierrecaja = cierrescajas::find('id', $gasto->idg_cierrecaja);
      if($cierrecaja->estado == 0){ //si cierre de caja esta abierto
        //eliminar gasto 
        $re = $gasto->eliminar_registro();
        //eliminar img comprobante del gasto
        $existe_archivo = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/".$gasto->imgcomprobante);
        if($existe_archivo && !empty($gasto->imgcomprobante))unlink($_SERVER['DOCUMENT_ROOT']."/build/img/".$gasto->imgcomprobante);
        if($re){
          if($gasto->id_banco!=null){ //ajustar gasto banco del cierre de caja
            $cierrecaja->gastosbanco -= $gasto->valor;
          }else{ //ajustar gasto caja efectivo del cierre de caja
            $cierrecaja->gastoscaja -= $gasto->valor;
          }
          $rc = $cierrecaja->actualizar();
          if($rc){
            $alertas['exito'][] = "Gasto eliminado correctamente";
          }else{
            $alertas['error'][] = "No se pudo eliminar el gasto del cierre de caja";
            $gasto->crear_guardar();
          }
        }else{
          $alertas['error'][] = "No se pudo eliminar el gasto";
        }
      }else{
        $alertas['error'][] = "Caja ya se encuentra cerrada";
      }
    }
    echo json_encode($alertas);
  }


  //Reporte de gastos e ingresos efectivos "base" llamado desde gastoseingresos.ts
  public static function eliminaringresocaja(){
    session_start();
    isadmin();
    $idsucursal = id_sucursal();
    $alertas = [];
    $ingresocaja = ingresoscajas::uniquewhereArray(['id'=>$_POST['id'], 'idsucursal_idfk'=>$idsucursal]);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $cierrecaja = cierrescajas::find('id', $ingresocaja->id_cierrecaja);
      if($cierrecaja->estado == 0){ //si cierre de caja esta abierto
        //eliminar ingreso efectivo "base" caja 
        $ri = $ingresocaja->eliminar_registro();
        if($ri){
          //ajustar ingreso efectivo "base" a caja efectivo del cierre de caja
          $cierrecaja->basecaja -= $ingresocaja->valor;
          $rc = $cierrecaja->actualizar();
          if($rc){
            $alertas['exito'][] = "Ingreso eliminado correctamente";
          }else{
            $alertas['error'][] = "No se pudo eliminar el ingreso del cierre de caja";
            $ingresocaja->crear_guardar();
          }
        }else{
          $alertas['error'][] = "No se pudo eliminar el ingreso";
        }
      }else{
        $alertas['error'][] = "Caja ya se encuentra cerrada";
      }
    }
    echo json_encode($alertas);
  }

}