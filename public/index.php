<?php 

require_once __DIR__ . '/../includes/app.php'; //apunta al directorio raiz y luego a app.php, el archivo app contiene: las variables de entorno para el deploy,
                    //la clase ActiveRecord, el autoload de composer = localizador de clases, archivo de funciones debuguear y sanitizar html
                    //archivo de conexion de bd mysql con variables de entorno y me establece la conexion mediante: ActiveRecord::setDB($db);

//me importa clases del controlador

use Controllers\logincontrolador; //clase para logueo, registro de usuario, recuperacion, deslogueo etc..
use Controllers\dashboardcontrolador;
use Controllers\contabilidadcontrolador;
use Controllers\almacencontrolador;
use Controllers\cajacontrolador;
use Controllers\ventascontrolador;
use Controllers\reportescontrolador;
use Controllers\clientescontrolador;
use Controllers\direccionescontrolador;
use Controllers\configcontrolador;
use Controllers\paginacontrolador;

// me importa la clase router
use MVC\Router;



$router = new Router();



// Login
$router->get('/loginauth', [logincontrolador::class, 'loginauth']);
$router->post('/loginauth', [logincontrolador::class, 'loginauth']);
$router->get('/login', [logincontrolador::class, 'login']);
$router->post('/login', [logincontrolador::class, 'login']);
$router->get('/logout', [logincontrolador::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [logincontrolador::class, 'registro']);
$router->post('/registro', [logincontrolador::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [logincontrolador::class, 'olvide']);
$router->post('/olvide', [logincontrolador::class, 'olvide']);

// Colocar el nuevo password
$router->get('/recuperarpass', [logincontrolador::class, 'recuperarpass']);
$router->post('/recuperarpass', [logincontrolador::class, 'recuperarpass']);

// Confirmación de Cuenta
$router->get('/mensaje', [logincontrolador::class, 'mensaje']);
$router->get('/confirmar-cuenta', [logincontrolador::class, 'confirmar_cuenta']);

//area publica
//$router->get('/', [paginacontrolador::class, 'index']);
$router->get('/', [logincontrolador::class, 'login']);
$router->get('/printfacturacarta', [cajacontrolador::class, 'printfacturacarta']); //llamado desde ordenresumen 


/////area dashboard/////
$router->get('/admin/dashboard', [dashboardcontrolador::class, 'index']);
$router->get('/admin/perfil', [dashboardcontrolador::class, 'perfil']);
$router->post('/admin/perfil', [dashboardcontrolador::class, 'perfil']);
$router->post('/admin/actualizaremail', [dashboardcontrolador::class, 'actualizaremail']);
///// area de contabilidad /////
$router->get('/admin/contabilidad', [contabilidadcontrolador::class, 'index']);
///// area de almacen categorias, productos, subproductos, compras etc /////
$router->get('/admin/almacen', [almacencontrolador::class, 'index']);
$router->get('/admin/almacen/categorias', [almacencontrolador::class, 'categorias']);
$router->post('/admin/almacen/crear_categoria', [almacencontrolador::class, 'crear_categoria']);
$router->get('/admin/almacen/productos', [almacencontrolador::class, 'productos']);
$router->post('/admin/almacen/crear_producto', [almacencontrolador::class, 'crear_producto']);
$router->get('/admin/almacen/subproductos', [almacencontrolador::class, 'subproductos']);
$router->post('/admin/almacen/crear_subproducto', [almacencontrolador::class, 'crear_subproducto']);
$router->get('/admin/almacen/componer', [almacencontrolador::class, 'componer']);
$router->get('/admin/almacen/ajustarcostos', [almacencontrolador::class, 'ajustarcostos']);
$router->get('/admin/almacen/compras', [almacencontrolador::class, 'compras']);
$router->get('/admin/almacen/distribucion', [almacencontrolador::class, 'distribucion']);
$router->get('/admin/almacen/inventariar', [almacencontrolador::class, 'inventariar']);
$router->get('/admin/almacen/unidadesmedida', [almacencontrolador::class, 'unidadesmedida']);
$router->post('/admin/almacen/unidadesmedida', [almacencontrolador::class, 'unidadesmedida']);
$router->post('/admin/almacen/crear_unidadmedida', [almacencontrolador::class, 'crear_unidadmedida']);
$router->post('/admin/almacen/editarunidademedida', [almacencontrolador::class, 'editarunidademedida']);

///// area de caja /////
$router->get('/admin/caja', [cajacontrolador::class, 'index']);
$router->get('/admin/caja/cerrarcaja', [cajacontrolador::class, 'cerrarcaja']);
$router->get('/admin/caja/zetadiario', [cajacontrolador::class, 'zetadiario']);
$router->get('/admin/caja/ultimoscierres', [cajacontrolador::class, 'ultimoscierres']);
$router->get('/admin/caja/detallecierrecaja', [cajacontrolador::class, 'detallecierrecaja']);
$router->post('/admin/caja/ingresoGastoCaja', [cajacontrolador::class, 'ingresoGastoCaja']);
$router->get('/admin/caja/ordenresumen', [cajacontrolador::class, 'ordenresumen']);  //resumen de la orden
//$router->get('/admin/caja/printfacturacarta', [cajacontrolador::class, 'printfacturacarta']);  //imprimir factura tipo carta
$router->get('/admin/caja/detalleorden', [cajacontrolador::class, 'detalleorden']); //detalle de la orden
///// area de ventas /////
$router->get('/admin/ventas', [ventascontrolador::class, 'index']);
///// area de reportes /////
$router->get('/admin/reportes', [reportescontrolador::class, 'index']);
$router->get('/admin/reportes/ventasgenerales', [reportescontrolador::class, 'ventasgenerales']);
$router->get('/admin/reportes/cierrescaja', [reportescontrolador::class, 'cierrescaja']);
$router->get('/admin/reportes/zdiario', [reportescontrolador::class, 'zdiario']);
$router->get('/admin/reportes/ventasxtransaccion', [reportescontrolador::class, 'ventasxtransaccion']);
///// area de clientes /////
$router->get('/admin/clientes', [clientescontrolador::class, 'index']);
$router->post('/admin/clientes', [clientescontrolador::class, 'index']); //filtro de busqueda
$router->post('/admin/clientes/crear', [clientescontrolador::class, 'crear']);  //crear cliente en vista de clientes
$router->post('/admin/clientes/actualizar', [clientescontrolador::class, 'actualizar']);
$router->get('/admin/clientes/detalle', [clientescontrolador::class, 'detalle']);
$router->get('/admin/clientes/hab_desh', [clientescontrolador::class, 'hab_desh']); //habilitar deshabilitar cliente
///// direcciones de los clientes /////
$router->post('/admin/direcciones/crear', [direccionescontrolador::class, 'crear']);  //crear direccion en vista de clientes

///// area de configuracion /////
$router->get('/admin/configuracion', [configcontrolador::class, 'index']);



/////////////////////////////////////--   API'S   --////////////////////////////////////////
$router->post('/admin/api/actualizar_categoria', [almacencontrolador::class, 'actualizar_categoria']);
$router->post('/admin/api/eliminarCategoria', [almacencontrolador::class, 'eliminarCategoria']);
$router->get('/admin/api/allproducts', [almacencontrolador::class, 'allproducts']); //trae todos los productos
$router->post('/admin/api/actualizarproducto', [almacencontrolador::class, 'actualizarproducto']);  //actualizar en general el producto
$router->post('/admin/api/eliminarProducto', [almacencontrolador::class, 'eliminarProducto']);
$router->get('/admin/api/allsubproducts', [almacencontrolador::class, 'allsubproducts']); //trae todos los sub-productos
$router->post('/admin/api/actualizarsubproducto', [almacencontrolador::class, 'actualizarsubproducto']);  //actualizar en general el producto
$router->post('/admin/api/eliminarSubProducto', [almacencontrolador::class, 'eliminarSubProducto']);
$router->post('/admin/api/setrendimientoestandar', [almacencontrolador::class, 'setrendimientoestandar']);  //establecer rendimiento estandar de la formula de salida
$router->post('/admin/api/ensamblar', [almacencontrolador::class, 'ensamblar']);  //asociar un o unos subproductos a un producto principal
$router->get('/admin/api/desasociarsubproducto', [almacencontrolador::class, 'desasociarsubproducto']);
$router->get('/admin/api/allConversionesUnidades', [almacencontrolador::class, 'allConversionesUnidades']); //trae todos los sub-productos con todas las unidades equivalentes
$router->post('/admin/api/actualizarcostos', [almacencontrolador::class, 'actualizarcostos']);  //actualizar costos, api llamada desde ajustarcostos.ts
$router->get('/admin/api/totalitems', [almacencontrolador::class, 'totalitems']);  //api llamada desde compras.ts para obtener los productos simples y subproductos
$router->post('/admin/api/registrarCompra', [almacencontrolador::class, 'registrarCompra']);  //actualizar costos, api llamada desde ajustarcostos.ts
$router->post('/admin/api/descontarstock', [almacencontrolador::class, 'descontarstock']);  //descontar unidades de inventario
$router->post('/admin/api/aumentarstock', [almacencontrolador::class, 'aumentarstock']);  //ingresar o aumentar unidades de inventario
$router->post('/admin/api/ajustarstock', [almacencontrolador::class, 'ajustarstock']);  //reiniciar o ajustar inventario

$router->post('/admin/api/facturar', [ventascontrolador::class, 'facturar']);  //aip llamada desde ventas.ts cuando se factura
$router->post('/admin/api/facturarCotizacion', [ventascontrolador::class, 'facturarCotizacion']);  //aip llamada desde ordenresumen.ts cuando se factura una cotizacion guardada
$router->post('/admin/api/eliminarOrden', [ventascontrolador::class, 'eliminarOrden']);  //aip llamada desde ordenresumen.ts cuando se se elimina orden ya sea cotizacion o factura paga


$router->post('/admin/api/declaracionDinero', [cajacontrolador::class, 'declaracionDinero']);  //aip llamada desde cerrarcaja.ts
$router->post('/admin/api/arqueocaja', [cajacontrolador::class, 'arqueocaja']);  //aip llamada desde cerrarcaja.ts
$router->post('/admin/api/cierrecajaconfirmado', [cajacontrolador::class, 'cierrecajaconfirmado']);  //aip llamada desde cerrarcaja.ts
$router->get('/admin/api/mediospagoXfactura', [cajacontrolador::class, 'mediospagoXfactura']); //obtener los medios de pago segun factura elegido en caja.ts
$router->post('/admin/api/cambioMedioPago', [cajacontrolador::class, 'cambioMedioPago']);  //aip llamada desde caja.ts

$router->post('/admin/api/apiCrearCliente', [clientescontrolador::class, 'apiCrearCliente']);  // crear cliente desde modulo de ventas.ts
$router->get('/admin/api/direccionesXcliente', [direccionescontrolador::class, 'direccionesXcliente']); //obtener direcciones segun cliente elegido en ventas.ts y en clientes.ts
$router->post('/admin/api/addDireccionCliente', [direccionescontrolador::class, 'addDireccionCliente']); //add direccion segun cliente elegido desde ventas.ts
$router->get('/admin/api/allclientes', [clientescontrolador::class, 'allclientes']); // me trae todos los clientes desde clientes.js
$router->post('/admin/api/actualizarCliente', [clientescontrolador::class, 'apiActualizarcliente']);  //actualizar cliente en clientes.ts
$router->post('/admin/api/eliminarCliente', [clientescontrolador::class, 'apiEliminarCliente']); //eliminar cliente en clientes.ts



//////***************************/***NO**************************//////
////// api de categorias y servicios //////
$router->post('/admin/api/updateStateCategoria', [servicioscontrolador::class ,'updateStateCategoria']); //fetch en servicios.js para cambiar estado categoria
$router->post('/admin/api/actualizarCategoria', [servicioscontrolador::class ,'actualizarCategoria']); //fetch en servicios.js para actualizar categoria
//$router->post('/admin/api/eliminarCategoria', [servicioscontrolador::class , 'eliminarCategoria']); //fetch en servicios.js para eliminar categoria
$router->post('/admin/api/actualizarServicio', [servicioscontrolador::class, 'actualizarServicio']); //fetch en editarservicos.js para actulaizar el servicio
$router->post('/admin/api/eliminarservicio', [servicioscontrolador::class, 'eliminar']); //fetch en servicios.js
$router->get('/admin/api/getservices', [servicioscontrolador::class, 'getservices']); //fetch en calendariocitas.js y 1app.js


////// api de configuracion //////
$router->get('/admin/api/getAllemployee', [adminconfigcontrolador::class, 'getAllemployee']); //fetch en empleados.js
$router->post('/admin/api/actualizarEmpleado', [adminconfigcontrolador::class, 'actualizarEmpleado']); //fetch llamado en empleados.js
$router->post('/admin/api/actualizarSkillsEmpleado', [adminconfigcontrolador::class, 'actualizarSkillsEmpleado']); //fetch llamado en empleados.js
$router->post('/admin/api/eliminarEmpleado', [adminconfigcontrolador::class, 'eliminarEmpleado']); //fetch llamado en empleados.js
$router->get('/admin/api/getmalla', [adminconfigcontrolador::class, 'getmalla']); //fetch en malla.js y en
$router->get('/admin/api/malla', [adminconfigcontrolador::class, 'malla']);
$router->get('/admin/api/getfechadesc', [adminconfigcontrolador::class, 'getfechadesc']);  //fetch en fechadesc.js y en 
$router->get('/admin/api/deletefechadesc', [adminconfigcontrolador::class, 'deletefechadesc']);  //metodo para eliminar fecha llamado desde fechadesc.js
$router->get('/admin/api/getemployee_services', [citascontrolador::class, 'getemployee_services']); //metodo llamado desde 

$router->get('/admin/api/allclientes', [clientescontrolador::class, 'allclientes']); // me trae todos los clientes o usuarios desde citas.js
$router->get('/admin/api/alldays', [dashboardcontrolador::class, 'alldays']); // me trae todos los dias desde graficas.js
$router->get('/admin/api/totalcitas', [dashboardcontrolador::class, 'totalcitas']); 
$router->get('/admin/api/detallepagoxcita', [factcontrolador::class, 'detallepagoxcita']); //api se ejecuta en el modulo de citas en admin
$router->get('/admin/api/anularpagoxcita', [factcontrolador::class, 'anularpagoxcita']); //api se ejecuta en el modulo de citas en admin
$router->get('/admin/api/getmediospago', [configcontrolador::class, 'getmediospago']); //api llamada desde configuracion.js
$router->post('/admin/api/setmediospago', [configcontrolador::class, 'setmediospago']); //api llamada desde configuracion.js para setear los medios de pago
$router->post('/admin/api/coloresapp', [configcontrolador::class, 'coloresapp']); //api establecer colores app
$router->post('/admin/api/tiemposervicio', [configcontrolador::class, 'tiemposervicio']); //api establecer tiempo de servicio
$router->get('/admin/api/gettimeservice', [configcontrolador::class, 'gettimeservice']); //api para traer el tiempo de duracion general del servicio


$router->comprobarRutas();
