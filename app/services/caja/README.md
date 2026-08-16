# Inventario y plan de extracción de `cajacontrolador`

## Alcance de esta estructura

Esta carpeta prepara la separación de responsabilidades de
`App\Controllers\cajacontrolador` sin cambiar todavía su comportamiento.

En esta fase:

- `cajacontrolador.php` continúa siendo el único controlador de caja.
- No se modifican rutas ni archivos de entrada.
- `CajaConsultasService` ya está implementado y conectado a las acciones de
  lectura inventariadas.
- `app/services/cajaService.php` conserva su API pública y delega temporalmente
  la consulta de impresión del cierre al servicio nuevo.
- Las demás clases de esta carpeta siguen siendo scaffolds deliberadamente
  vacíos y todavía no están conectadas al controlador.
- La migración continúa método por método, conservando las firmas y respuestas
  HTTP existentes mientras se extrae la lógica.

## Responsabilidades encontradas

El controlador contiene 29 acciones distribuidas en siete grupos de lógica:

| Grupo | Responsabilidad | Servicio futuro |
|---|---|---|
| Consultas | Preparar panel, cierres, discriminaciones y detalle de caja | `CajaConsultasService` |
| Cierre | Declaración, arqueo y confirmación del cierre | `CajaCierreService` |
| Movimientos | Apertura por ingreso, ingresos, gastos, retiros y traslados | `CajaMovimientosService` |
| Categorías | Crear, editar, listar y eliminar categorías de gasto | `CategoriasGastoService` |
| Reportes | Z diario y consultas por fecha | `CajaReportesService` |
| Órdenes | Pedidos, pagos, despachos y cambio de emisor | `CajaOrdenesService` |
| Documentos | Impresión, formato de factura y correo | `CajaDocumentosService` |

## Estado de migración

### `CajaConsultasService` — completado

| Método del servicio | Consumidor actual | Origen HTTP |
|---|---|---|
| `obtenerPanelCaja` | `cajacontrolador::index` | `GET /admin/caja` |
| `obtenerCierrePrincipal` | `cajacontrolador::cerrarcaja` | `GET /admin/caja/cerrarcaja` |
| `listarCierresFinalizados` | `cajacontrolador::ultimoscierres` | `GET /admin/caja/ultimoscierres` |
| `obtenerDetalleCierreFinalizado` | `cajacontrolador::detallecierrecaja` | `GET /admin/caja/detallecierrecaja` |
| `obtenerCajaSeleccionada` | `cajacontrolador::datoscajaseleccionada` | `POST /admin/api/datoscajaseleccionada` |
| `obtenerCierreParaImpresion` | `cajaService::printdetallecierre` | `GET /printdetallecierre` |

Los métodos privados `construirResumenCierre`, `agruparMediosPago`,
`calcularDiferencial` y `cruzarDeclaraciones` concentran el cálculo que estaba
repetido en cuatro lugares. El controlador conserva autenticación, entrada HTTP,
render de vistas y serialización JSON.

## Inventario de acciones

| Línea | Acción actual | Tipo | Destino propuesto | Observación de migración |
|---:|---|---|---|---|
| 41 | `index` | Consulta/vista | `CajaConsultasService` | Extraer la preparación del panel y facturas de cierres abiertos. |
| 79 | `cerrarcaja` | Consulta/vista | `CajaConsultasService` | Reutilizar un único resumen de cierre; hoy repite cálculos de otros métodos. |
| 161 | `ingresoGastoCaja` | Comando + vista | `CajaMovimientosService` | Separar el comando de ingreso/gasto de la reconstrucción posterior del panel. |
| 278 | `categoriaGasto` | Consulta + eliminación | `CategoriasGastoService` | Separar listar de eliminar. |
| 303 | `crear_categoriaGasto` | Comando | `CategoriasGastoService` | Crear categoría y devolver un resultado independiente de la vista. |
| 325 | `editarcategoriagasto` | Comando | `CategoriasGastoService` | Validar pertenencia y actualizar. |
| 348 | `zetadiario` | Consulta/vista | `CajaReportesService` | Listado de cierres para el reporte Z. |
| 366 | `fechazetadiario` | Consulta/vista | `CajaReportesService` | Consolidación del reporte Z actual o por cierres. |
| 421 | `ultimoscierres` | Consulta/vista | `CajaConsultasService` | Listado de cierres finalizados. |
| 431 | `detallecierrecaja` | Consulta/vista | `CajaConsultasService` | Compartir el constructor del resumen con `cerrarcaja` y `datoscajaseleccionada`. |
| 496 | `pedidosguardados` | Consulta/vista | `CajaOrdenesService` | Consultar cotizaciones guardadas por sucursal. |
| 506 | `trasladosRetirosDinero` | Solo vista | Controlador por ahora | No contiene todavía un caso de uso que extraer. |
| 514 | `despachosPendientes` | Consulta/vista | `CajaOrdenesService` | Obtener órdenes pendientes por sucursal. |
| 523 | `ordenresumen` | Consulta/vista | `CajaOrdenesService` | Construir el detalle operativo completo de una orden. |
| 564 | `detalleorden` | Solo vista | Controlador por ahora | Es un placeholder sin lógica de aplicación. |
| 576 | `printfacturacarta` | Documento/vista | `CajaDocumentosService` | Preparar datos de factura y medios de pago. |
| 588 | `printcotizacion` | Documento/vista | `CajaDocumentosService` | Preparar datos de cotización. |
| 597 | `printdetallecierre` | Documento/vista | `CajaDocumentosService` | Consumirá el resumen generado por consultas. |
| 614 | `declaracionDinero` | Comando/API | `CajaCierreService` | Crear, actualizar o eliminar la declaración por medio de pago. |
| 647 | `arqueocaja` | Comando/API | `CajaCierreService` | Crear o actualizar el arqueo del cierre abierto. |
| 680 | `cierrecajaconfirmado` | Comando/API | `CajaCierreService` | Operación crítica; debe quedar transaccional antes de restaurante. |
| 747 | `datoscajaseleccionada` | Consulta/API | `CajaConsultasService` | Tercera variante del mismo resumen financiero de cierre. |
| 817 | `mediospagoXfactura` | Consulta/API | `CajaOrdenesService` | Añadir autenticación, sucursal y validación de factura al migrar. |
| 824 | `cambioMedioPago` | Comando/API | `CajaOrdenesService` | Debe ser transaccional y recalcular el efectivo desde datos persistidos. |
| 917 | `eliminarPedidoGuardado` | Comando/API | `CajaOrdenesService` | Validar autenticación, sucursal y estado antes de eliminar. |
| 939 | `sendOrdenEmailToCustemer` | Integración/API | `CajaDocumentosService` | Separar consulta, render de plantilla y envío de correo. |
| 977 | `getInvoice` | Consulta/API | `CajaDocumentosService` | Construir el DTO de impresión sin conocer HTTP. |
| 988 | `despacharOrden` | Comando/API | `CajaOrdenesService` | Ya delega parcialmente; absorberá `cajaService::despacharOrden`. |
| 998 | `cambiarEmisor` | Comando/API | `CajaOrdenesService` | Ya delega parcialmente; requiere una única transacción consistente. |

Las líneas corresponden al estado de `cajacontrolador.php` al crear este
inventario y pueden desplazarse durante migraciones posteriores.

## Destino del `cajaService` actual

| Método actual | Destino futuro |
|---|---|
| `printdetallecierre` | Ya delega a `CajaConsultasService`; posteriormente pasará por `CajaDocumentosService` |
| `detalleVenta` | `CajaDocumentosService` |
| `despacharOrden` | `CajaOrdenesService` |
| `cambiarEmisor` | `CajaOrdenesService` |

El archivo existente no debe eliminarse hasta que cada consumidor haya sido
migrado y cubierto por pruebas.

## Hallazgos que deben conservarse como tareas

1. `cerrarcaja`, `detallecierrecaja`, `datoscajaseleccionada` y
   `cajaService::printdetallecierre` duplican el armado del resumen de medios de
   pago, declaraciones y sobrante/faltante.
2. `ingresoGastoCaja` mezcla escritura, carga de archivos y render de vista;
   además contiene un `debuguear($facturas)` que interrumpe el flujo.
3. `cierrecajaconfirmado` crea el siguiente cierre y luego actualiza el actual
   mediante compensaciones manuales; debe migrarse a una transacción.
4. `cambioMedioPago` actualiza múltiples tablas sin una frontera transaccional.
5. `mediospagoXfactura`, `cambioMedioPago` y `eliminarPedidoGuardado` no aplican
   actualmente el mismo guard de autenticación que el resto del controlador.
6. `despacharOrden` modifica estado mediante una ruta GET; deberá convertirse a
   POST cuando se autorice modificar las rutas.
7. Los servicios futuros deben comprobar siempre la pertenencia de caja,
   cierre, factura y orden a la sucursal activa.

## Reglas para la extracción

- El controlador conserva `Router`, `$_GET`, `$_POST`, `$_FILES`, `$_SESSION`,
  `echo`, `json_encode`, `header` y selección de vistas.
- Los servicios no pueden depender de esas variables o funciones HTTP.
- Cada comando recibe datos normalizados más el identificador de sucursal y
  usuario necesarios.
- Los servicios devuelven resultados PHP; el controlador decide el formato
  HTTP.
- Toda operación que modifica más de una tabla debe tener una sola transacción.
- Los repositorios y ActiveRecord quedan como infraestructura de persistencia.
- La extracción debe mantener la respuesta actual antes de corregir reglas o
  rutas; los cambios funcionales se realizan en una fase posterior.

## Orden sugerido de migración

1. Crear pruebas de caracterización para cierre, movimientos y cambio de pago.
2. ~~Extraer el resumen duplicado a `CajaConsultasService`.~~ Completado.
3. Extraer `declaracionDinero`, `arqueocaja` y `cierrecajaconfirmado`.
4. Extraer ingresos y gastos.
5. Absorber gradualmente los métodos operativos del `cajaService` actual.
6. Extraer categorías, reportes y documentos.
7. Cuando todos los métodos estén estables, evaluar dividir el controlador y
   las rutas; esa decisión queda fuera de esta fase.
