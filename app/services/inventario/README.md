# Inventario y auditoría de `almacencontrolador`

## Alcance

Este documento registra el estado de `App\Controllers\almacencontrolador` antes
de extraer lógica. En esta etapa no se modifica el controlador, las rutas, las
vistas, TypeScript ni `public/index.php`.

La fotografía auditada contiene:

- 1.597 líneas;
- 54 métodos públicos;
- 55 rutas, porque `unidadesmedida` atiende GET y POST;
- 25 acciones que invocan `isadmin()`;
- 21 acciones que verifican el permiso `Habilitar modulo de inventario`;
- responsabilidades de consultas, catálogos, productos, insumos, fórmulas,
  costos, precios, compras, stock, proveedores, Excel y código de barras.

## Conclusión

Se debe seguir el mismo proceso incremental usado en `cajacontrolador`: primero
caracterizar contratos y consumidores, después extraer consultas y finalmente
migrar comandos uno por uno. Inventario necesita una fase previa de seguridad,
porque actualmente hay acciones sin guard y `isadmin()` no detiene la ejecución
después de enviar la redirección.

No se recomienda crear un único servicio grande. La separación propuesta es:

| Responsabilidad | Destino propuesto |
|---|---|
| Panel, listados y consultas por sucursal | `InventarioConsultasService` |
| Categorías | `CategoriasInventarioService` |
| Productos, precios personalizados e imagen | `ProductosInventarioService` |
| Insumos | `InsumosInventarioService` |
| Unidades y conversiones | `UnidadesInventarioService` |
| Fórmulas, rendimiento y producción | `FormulasProduccionService` |
| Costos y precios de venta | `CostosInventarioService` |
| Compras, detalle, stock, movimientos y gasto | `ComprasInventarioService` |
| Entradas, salidas, ajustes y reinicio | `StockInventarioService` |
| Proveedores | `ProveedoresService` |
| Importación y exportación | adaptar `inventarioService` y `exportService` |

Los nombres son provisionales. Cada clase debe nacer únicamente cuando se migre
su primer caso de uso.

## Inventario de acciones

### Consultas y vistas

| Método | Ruta | Consumidor principal | Destino |
|---|---|---|---|
| `index` | GET `/admin/almacen` | navegación principal | `InventarioConsultasService` |
| `categorias` | GET `/admin/almacen/categorias` | `categorias.php` | `CategoriasInventarioService` |
| `productos` | GET `/admin/almacen/productos` | `productos.php` | `InventarioConsultasService` |
| `subproductos` | GET `/admin/almacen/subproductos` | `subproductos.php` | `InventarioConsultasService` |
| `componer` | GET `/admin/almacen/componer` | `productos.ts` | `FormulasProduccionService` |
| `ajustarcostos` | GET `/admin/almacen/ajustarcostos` | panel de almacén | `CostosInventarioService` |
| `compras` | GET `/admin/almacen/compras` | panel de almacén | `ComprasInventarioService` |
| `distribucion` | GET `/admin/almacen/distribucion` | vista actualmente oculta | revisar antes de migrar |
| `inventariar` | GET `/admin/almacen/inventariar` | vista actualmente oculta | revisar antes de migrar |
| `unidadesmedida` | GET/POST `/admin/almacen/unidadesmedida` | `unidadesmedida.ts` | `UnidadesInventarioService` |
| `cambioPrecios` | GET `/admin/almacen/cambioPrecios` | panel de almacén | `CostosInventarioService` |
| `estadisticas` | GET `/admin/almacen/estadisticas` | panel de almacén | `InventarioConsultasService` |
| `productosParaFormulas` | GET `/admin/almacen/productosParaFormulas` | panel de almacén | `FormulasProduccionService` |
| `conversionUnidades` | GET `/admin/almacen/conversionUnidades` | `conversionUnidades.ts` | `UnidadesInventarioService` |

### Categorías, unidades y conversiones

| Método | Ruta | Tipo | Destino |
|---|---|---|---|
| `crear_categoria` | POST `/admin/almacen/crear_categoria` | comando + render | `CategoriasInventarioService` |
| `actualizar_categoria` | POST `/admin/api/actualizar_categoria` | comando JSON | `CategoriasInventarioService` |
| `eliminarCategoria` | POST `/admin/api/eliminarCategoria` | comando JSON | `CategoriasInventarioService` |
| `crear_unidadmedida` | POST `/admin/almacen/crear_unidadmedida` | comando + render | `UnidadesInventarioService` |
| `editarunidademedida` | POST `/admin/almacen/editarunidademedida` | comando + render | `UnidadesInventarioService` |
| `allUnidadesMedida` | GET `/admin/api/almacen/allUnidadesMedida` | consulta JSON | `UnidadesInventarioService` |
| `allConversionesUnidades` | GET `/admin/api/allConversionesUnidades` | consulta compartida | `UnidadesInventarioService` |
| `crearNuevaConversionUnidad` | POST `/admin/api/almacen/crearNuevaConversionUnidad` | comando JSON | `UnidadesInventarioService` |
| `eliminarConversionUnidad` | GET `/admin/api/almacen/eliminarConversionUnidad` | comando mediante GET | `UnidadesInventarioService` |

`unidadesmedida` mezcla consulta y eliminación. Debe separarse internamente en
dos casos de uso aunque se conserve temporalmente la firma del controlador.

### Productos e insumos

| Método | Ruta | Consumidor | Destino |
|---|---|---|---|
| `crear_producto` | POST `/admin/almacen/crear_producto` | formulario de productos | `ProductosInventarioService` |
| `allproducts` | GET `/admin/api/allproducts` | ventas, créditos, modo rápido y productos | `InventarioConsultasService` |
| `actualizarproducto` | POST `/admin/api/actualizarproducto` | `productos.ts` | `ProductosInventarioService` |
| `eliminarProducto` | POST `/admin/api/eliminarProducto` | `productos.ts` y `unidadesmedida.ts` | `ProductosInventarioService` |
| `cambiarestadoproducto` | POST `/admin/api/cambiarestadoproducto` | `productos.ts` | `ProductosInventarioService` |
| `generarBarCode` | POST `/admin/api/generarBarCode` | consumidor no localizado | revisar/eliminar |
| `crear_subproducto` | POST `/admin/almacen/crear_subproducto` | formulario de insumos | `InsumosInventarioService` |
| `allsubproducts` | GET `/admin/api/allsubproducts` | insumos y conversiones | `InventarioConsultasService` |
| `actualizarsubproducto` | POST `/admin/api/actualizarsubproducto` | `subproductos.ts` | `InsumosInventarioService` |
| `eliminarSubProducto` | POST `/admin/api/eliminarSubProducto` | `subproductos.ts` | `InsumosInventarioService` |

### Fórmulas, costos y precios

| Método | Ruta | Consumidor | Destino |
|---|---|---|---|
| `setrendimientoestandar` | POST `/admin/api/setrendimientoestandar` | `ensamblaje.ts` | `FormulasProduccionService` |
| `ensamblar` | POST `/admin/api/ensamblar` | `ensamblaje.ts` | `FormulasProduccionService` |
| `desasociarsubproducto` | GET `/admin/api/desasociarsubproducto` | `ensamblaje.ts` | `FormulasProduccionService` |
| `actualizarcostos` | POST `/admin/api/actualizarcostos` | `ajustarcostos.ts` | `CostosInventarioService` |
| `actualizarPreciosVenta` | POST `/admin/api/actualizarPreciosVenta` | `ajustarprecios.ts` | `CostosInventarioService` |

### Compras y stock

| Método | Ruta | Consumidor | Destino |
|---|---|---|---|
| `totalitems` | GET `/admin/api/totalitems` | compras, traslados y reportes | `InventarioConsultasService` |
| `registrarCompra` | POST `/admin/api/registrarCompra` | `compras.ts` | `ComprasInventarioService` |
| `descontarstock` | POST `/admin/api/descontarstock` | `almacen.ts` | `StockInventarioService` |
| `aumentarstock` | POST `/admin/api/aumentarstock` | `almacen.ts`, incluye producción | `StockInventarioService` + `FormulasProduccionService` |
| `ajustarstock` | POST `/admin/api/ajustarstock` | `almacen.ts` | `StockInventarioService` |
| `reiniciarinv` | GET `/admin/api/reiniciarinv` | `almacen.ts` | `StockInventarioService` |
| `getStockproductosXsucursal` | GET `/admin/api/getStockproductosXsucursal` | `almacen.ts` | `InventarioConsultasService` |
| `getItemsBajoStock` | GET `/admin/api/getItemsBajoStock` | `almacen.ts` | `InventarioConsultasService` |

### Proveedores e intercambio de archivos

| Método | Ruta | Consumidor | Destino |
|---|---|---|---|
| `allproveedores` | GET `/admin/api/allproveedores` | `gestionproveedores.ts` | `ProveedoresService` |
| `crearProveedor` | POST `/admin/api/crearProveedor` | `gestionproveedores.ts` | `ProveedoresService` |
| `actualizarProveedor` | POST `/admin/api/actualizarProveedor` | `gestionproveedores.ts` | `ProveedoresService` |
| `eliminarProveedor` | POST `/admin/api/eliminarProveedor` | `gestionproveedores.ts` | `ProveedoresService` |
| `downexcelproducts` | POST `/admin/almacen/downexcelproducts` | formulario de productos | `exportService` |
| `uploadExcel` | POST `/admin/almacen/uploadExcel` | formulario de productos | adaptar `inventarioService` |
| `uploadInsumosExcel` | POST `/admin/almacen/uploadInsumosExcel` | formulario de insumos | adaptar `inventarioService` |
| `downexcelinsumos` | POST `/admin/almacen/downexcelinsumos` | formulario de insumos | `exportService` |

## Consumidores frontend compartidos

| Archivo | Responsabilidad |
|---|---|
| `src/ts/almacen/almacen.ts` | stock rápido, producción, reinicio, bajo stock y existencias por sede |
| `src/ts/almacen/productos.ts` | consulta, edición, estado y eliminación de productos |
| `src/ts/almacen/subproductos.ts` | consulta, edición y eliminación de insumos |
| `src/ts/almacen/categoria.ts` | crear, editar y eliminar categorías |
| `src/ts/almacen/ensamblaje.ts` | rendimiento y composición de fórmulas |
| `src/ts/almacen/compras.ts` | catálogo de ítems y registro de compras |
| `src/ts/almacen/ajustarcostos.ts` | costos de productos e insumos |
| `src/ts/almacen/ajustarprecios.ts` | precios de venta |
| `src/ts/almacen/conversionUnidades.ts` | equivalencias y conversiones |
| `src/ts/almacen/gestionproveedores.ts` | CRUD de proveedores |
| `src/ts/ventas/ventas.apiproductos.ts` | catálogo de productos para ventas |
| `src/ts/creditos/*.ts` y `src/ts/modorapido/modorapido.ts` | catálogo compartido |
| traslados y reportes de inventario | consumen `totalitems` |

`allproducts`, `allConversionesUnidades` y `totalitems` son contratos
compartidos fuera de Almacén. Su respuesta debe caracterizarse antes de
modificarla.

## Hallazgos de auditoría

### Prioridad crítica

1. **El guard no detiene la ejecución.** `isauth()` e `isadmin()` envían
   `Location: /`, pero no ejecutan `exit` ni retornan un resultado que el
   controlador compruebe. Una acción puede continuar leyendo o escribiendo.
2. **29 de 54 acciones ni siquiera invocan `isadmin()`.** Sólo 21 verifican el
   permiso específico del módulo y esas verificaciones se concentran en vistas.
3. Se comprobó sin sesión que `allsubproducts`, `allConversionesUnidades`,
   `totalitems`, `getStockproductosXsucursal` y `allproveedores` responden datos
   con estado 200. Los endpoints que sí llaman `isadmin()` responden 302, pero
   continúan generando cuerpo porque el guard no finaliza el proceso.
4. `registrarCompra` modifica costos, compra, detalle, dos inventarios,
   movimientos, gasto y cierre sin una transacción única. Las compensaciones
   están incompletas y en la rama de error se intenta eliminar un gasto usando
   `$r[1]`, que corresponde al id de compra, no `$rig[1]` del gasto.
5. `descontarstock`, `aumentarstock` y `ajustarstock` separan la actualización
   del stock y la creación del movimiento, sin transacción ni bloqueo. Dos
   solicitudes concurrentes pueden perder actualizaciones y una falla puede
   dejar stock sin movimiento o movimiento sin operación completa.
6. `reiniciarinv` modifica masivamente productos e insumos mediante GET, sin
   transacción y sin registrar movimientos. Si la segunda consulta falla, sólo
   una familia de existencias queda reiniciada.

### Prioridad alta

1. `crear_producto` y `crear_subproducto` escriben entidad, equivalencias,
   stock de todas las sucursales, precios y contadores sin transacción. Las
   eliminaciones compensatorias no restauran todas las escrituras.
2. `actualizarproducto` crea historial, actualiza producto, precios, stock
   mínimo y conversiones sin transacción. Además elimina la imagen anterior
   antes de terminar validación y persistencia.
3. `actualizarsubproducto`, `eliminarSubProducto`, `ensamblar`,
   `desasociarsubproducto` y `actualizarcostos` recalculan fórmulas e históricos
   mediante varias escrituras no atómicas.
4. En `actualizarsubproducto`, el precio del modelo se reemplaza desde POST
   antes de compararlo con `$_POST['precio_compra']`; por ello la condición que
   debería propagar un cambio de costo normalmente queda falsa.
5. Hay tres mutaciones expuestas mediante GET:
   `desasociarsubproducto`, `reiniciarinv` y `eliminarConversionUnidad`.
6. `getStockproductosXsucursal` devuelve existencias de todas las sucursales y
   no tiene guard propio. Debe existir una regla explícita de perfil antes de
   conservar ese alcance.

### Prioridad media

1. `allproducts` ejecuta consultas adicionales por cada producto para categoría,
   precios e insumos; es un patrón N+1 usado también por Ventas y Créditos.
2. `uploadExcel` y `uploadInsumosExcel` delegan en un servicio transaccional,
   pero éste depende de sesión mediante `id_sucursal()` y `stockService`.
3. Las importaciones calculan ids nuevos suponiendo autoincrementos contiguos.
4. Cuando una importación finaliza sin alertas, el controlador agrega el mensaje
   de éxito `Extension del archivo no valido`, que contradice el resultado.
5. `generarBarCode` delega a un método vacío de `inventarioService` y no se
   encontró consumidor frontend directo.
6. `Email`, `usuarios`, `detalletrasladoinv` y `traslado_inv` son imports sin uso
   operativo; `usuarios` sólo aparece en comentarios.
7. Varias vistas contienen bloques POST vacíos y comentarios de código muerto.
8. Las APIs no fijan de forma consistente `Content-Type`, códigos HTTP ni una
   estructura uniforme para errores.

## Reglas para la extracción

- El controlador conserva HTTP, sesión, permisos, archivos, render y JSON.
- Los servicios reciben `sucursalId` y `usuarioId`; no llaman `id_sucursal()` ni
  leen `$_SESSION`, `$_POST`, `$_GET` o `$_FILES`.
- Toda operación de stock bloquea la fila de la sucursal antes de leerla.
- Stock y movimiento se guardan en la misma transacción.
- Compra, detalle, costos, inventario, movimientos, gasto y cierre forman una
  sola unidad transaccional.
- Las imágenes se sustituyen después de validar; si la persistencia falla, se
  limpia sólo el archivo nuevo y se conserva el anterior.
- Las consultas deben declarar si su alcance es la sucursal activa o todas las
  sucursales.
- No se cambia el contrato de `allproducts`, `totalitems` o conversiones sin
  revisar primero todos sus consumidores externos.

## Orden recomendado

0. Corregir la frontera de autenticación/autorización y convertir las tres
   mutaciones GET a POST en un cambio coordinado con TypeScript.
1. Crear `InventarioConsultasService` para panel, listados por sucursal, bajo
   stock y catálogos compartidos. Es el inicio de menor riesgo, equivalente a
   `CajaConsultasService`.
2. Crear `StockInventarioService` y migrar, uno por uno, `descontarstock`,
   `ajustarstock`, `aumentarstock` y `reiniciarinv` con bloqueo, movimiento y
   transacción.
3. Extraer `registrarCompra` a `ComprasInventarioService` como una única
   transacción coordinada con Caja.
4. Migrar creación y edición de productos e insumos, incluyendo imágenes,
   equivalencias, precios y stock inicial.
5. Migrar fórmulas, rendimiento, producción y propagación de costos.
6. Migrar categorías, unidades, conversiones y proveedores.
7. Revisar importaciones Excel y contratos compartidos con Ventas, Créditos,
   traslados y reportes.
8. Eliminar código muerto únicamente después de confirmar rutas y consumidores.

## Estado

Inventario auditado; ninguna migración iniciada. El primer caso de uso sugerido
es el panel de almacén, pero la corrección del guard de autenticación debe
tratarse antes o como cambio independiente de prioridad crítica.
