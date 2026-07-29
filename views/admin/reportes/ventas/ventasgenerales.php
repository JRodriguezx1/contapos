<!-- Reportes Generales -->
<div class="box ventasgenerales ventas-generales">
  <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>

  <section class="ventas-generales__shell">
    <header class="ventas-generales__hero">
      <a href="/admin/reportes" class="ventas-generales__back" aria-label="Volver a reportes">
        <i class="fa-solid fa-arrow-left"></i>
      </a>

      <div class="ventas-generales__title">
        <span>Ventas</span>
        <h1>Reportes generales</h1>
        <p>Consulta productos, medios de pago, cartera, canales y resumen financiero por periodo.</p>
      </div>

      <div class="ventas-generales__period-card">
        <span><i class="fa-solid fa-calendar-check"></i></span>
        <div>
          <strong>Periodo activo</strong>
          <small><span id="fecha1">-</span> al <span id="fecha2">-</span></small>
        </div>
      </div>
    </header>

    <section class="ventas-generales__filters">
      <div class="ventas-generales__section-heading">
        <span><i class="fa-solid fa-calendar-days"></i></span>
        <div>
          <h2>Periodo de consulta</h2>
          <p>Elige un atajo o define un rango personalizado.</p>
        </div>
      </div>

      <div class="ventas-generales__quick-actions">
        <button id="btnmesactual" class="ventas-generales__filter-btn ventas-generales__filter-btn--primary" type="button">
          <i class="fa-solid fa-calendar-check"></i> Mes actual
        </button>
        <button id="btnmesanterior" class="ventas-generales__filter-btn" type="button">
          <i class="fa-solid fa-calendar-minus"></i> Mes anterior
        </button>
        <button id="btnhoy" class="ventas-generales__filter-btn" type="button">
          <i class="fa-solid fa-sun"></i> Hoy
        </button>
        <button id="btnayer" class="ventas-generales__filter-btn" type="button">
          <i class="fa-solid fa-clock-rotate-left"></i> Ayer
        </button>
      </div>

      <div class="ventas-generales__range">
        <label for="ventasGeneralesRango">Rango personalizado</label>
        <div class="ventas-generales__date-field">
          <span><i class="fa-solid fa-calendar"></i></span>
          <input id="ventasGeneralesRango" type="text" name="datetimes" placeholder="Seleccionar fecha" autocomplete="off" readonly />
        </div>
        <button id="consultarFechaPersonalizada" class="ventas-generales__filter-btn ventas-generales__filter-btn--accent" type="button">
          <i class="fa-solid fa-magnifying-glass-chart"></i> Consultar
        </button>
      </div>
    </section>

    <section class="ventas-generales__content-card">
      <div class="ventas-generales__section-heading ventas-generales__section-heading--tabs">
        <span><i class="fa-solid fa-chart-simple"></i></span>
        <div>
          <h2>Detalle de reportes</h2>
          <p>Alterna entre vistas para revisar el comportamiento de ventas.</p>
        </div>
      </div>

      <div class="ventas-generales__tabs" role="tablist" aria-label="Reportes generales de ventas">
        <button class="tab-btn ventas-generales__tab is-active bg-indigo-600 text-white" data-tab="productos" type="button"><i class="fa-solid fa-boxes-stacked"></i> Productos</button>
        <button class="tab-btn ventas-generales__tab bg-white text-gray-600" data-tab="medios" type="button"><i class="fa-solid fa-credit-card"></i> Medios de pago</button>
        <button class="tab-btn ventas-generales__tab bg-white text-gray-600" data-tab="creditosSeparados" type="button"><i class="fa-solid fa-handshake"></i> Creditos/Separados</button>
        <button class="tab-btn ventas-generales__tab bg-white text-gray-600" data-tab="ingresoCanalventa" type="button"><i class="fa-solid fa-route"></i> Canal de venta</button>
        <button class="tab-btn ventas-generales__tab bg-white text-gray-600" data-tab="categorias" type="button"><i class="fa-solid fa-folder-tree"></i> Categorias</button>
        <button class="tab-btn ventas-generales__tab bg-white text-gray-600" data-tab="empleados" type="button"><i class="fa-solid fa-user-tie"></i> Empleados</button>
        <button class="tab-btn ventas-generales__tab bg-white text-gray-600" data-tab="gastos" type="button"><i class="fa-solid fa-arrow-trend-down"></i> Gastos</button>
        <button class="tab-btn ventas-generales__tab bg-white text-gray-600" data-tab="resumen" type="button"><i class="fa-solid fa-scale-balanced"></i> Resumen</button>
      </div>
      <!-- Tab content -->
      <div id="tab-content" class="ventas-generales__tab-content">

    <!-- Productos -->
    <div id="productos" class="tab-pane">
      <h3 class="ventas-generales__pane-title"><i class="fa-solid fa-boxes-stacked"></i> Ventas por productos</h3>
      <table id="tablaProductosVendidos" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Producto</th>
            <th class="px-4 py-2 border">Cantidad Vendida</th>
            <th class="px-4 py-2 border">Total Ventas</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- Medios de Pago -->
    <div id="medios" class="tab-pane hidden">
      <h3 class="ventas-generales__pane-title"><i class="fa-solid fa-credit-card"></i> Ventas por medio de pago</h3>
      <table id="tablaMediosPagos" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Medio de Pago</th>
            <th class="px-4 py-2 border">Transacciones</th>
            <th class="px-4 py-2 border">Total Ventas</th>
          </tr>
        </thead>
        <tfoot>
          <tr class="font-semibold text-gray-900">
            <td></td>
            <th class="px-6 py-3">Total Descuento:</th>
            <td id="totalDescto" class="px-4 py-2 border"> - </td>
          </tr>
        </tfoot>
      </table>
    </div>

    <!-- Creditos/Separados -->
    <div id="creditosSeparados" class="tab-pane hidden">
      <h3 class="ventas-generales__pane-title"><i class="fa-solid fa-handshake"></i> Creditos/Separados</h3>
      <table id="tablacreditosSeparados" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Estado</th>
            <th class="px-4 py-2 border">Cartera Total</th>
            <th class="px-4 py-2 border">Cartera por cobrar</th>
            <th class="px-4 py-2 border">Total Abonado</th>
            <th class="px-4 py-2 border">Total</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- Ingreso de canal de venta -->
    <div id="ingresoCanalventa" class="tab-pane hidden">
      <h3 class="ventas-generales__pane-title"><i class="fa-solid fa-route"></i> Ingresos por canal de venta</h3>
      <table id="tablaIngresoCanalventa" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Canal de venta</th>
            <th class="px-4 py-2 border">Transacciones</th>
            <th class="px-4 py-2 border">Valor</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- CategorÃ­as -->
    <div id="categorias" class="tab-pane hidden">
      <h3 class="ventas-generales__pane-title"><i class="fa-solid fa-folder-tree"></i> Ventas por categoria</h3>
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">CategorÃ­a</th>
            <th class="px-4 py-2 border">Cantidad Vendida</th>
            <th class="px-4 py-2 border">Total Ventas</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- Empleados -->
    <div id="empleados" class="tab-pane hidden">
      <h3 class="ventas-generales__pane-title"><i class="fa-solid fa-user-tie"></i> Ventas por empleados</h3>
      <table id="tablaVentasXUsuario" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Empleado</th>
            <th class="px-4 py-2 border">Ventas Realizadas</th>
            <th class="px-4 py-2 border">Total Ventas</th>
            <th class="px-4 py-2 border">Porcentaje</th>
            <th class="px-4 py-2 border">Valor comision</th>
          </tr>
        </thead>
        
      </table>
    </div>

    <!-- Gastos -->
    <div id="gastos" class="tab-pane hidden">
      <h3 class="ventas-generales__pane-title"><i class="fa-solid fa-arrow-trend-down"></i> Gastos</h3>
      <table id="tablaGastos" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Descripcion</th>
            <th class="px-4 py-2 border">Tipo Gasto</th>
            <th class="px-4 py-2 border">Valor</th>
          </tr>
        </thead>
        
      </table>
    </div>

    <!-- Resumen -->
    <div id="resumen" class="tab-pane hidden">

       <!-- tabla balance general -->
      <?php include __DIR__. "/balanceGeneral.php"; ?>

      <h3 class="ventas-generales__pane-title ventas-generales__pane-title--spaced"><i class="fa-solid fa-chart-line"></i> Resumen financiero de ventas</h3>
      <table id="tablaResumenVentas" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Ventas</th>
            <th class="px-4 py-2 border">Total Ventas Productos</th>
            <th class="px-4 py-2 border">Total Costo Productos</th>
            <th class="px-4 py-2 border">Ganancia</th>
            <th class="px-4 py-2 border">Margen Utilidad</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

      <h3 class="ventas-generales__pane-title ventas-generales__pane-title--spaced"><i class="fa-solid fa-wallet"></i> Resumen financiero de creditos</h3>
      <div class="w-full overflow-x-auto">
        <table id="tablaResumenCreditos" class="tabla">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-2 border">Creditos</th>
              <th class="px-4 py-2 border">Credito Total</th>
              <th class="px-4 py-2 border">Costo Total</th>
              <th class="px-4 py-2 border">Utilidad Comercial</th>
              <th class="px-4 py-2 border">Utilidad Proyectada</th>
              <th title="Abonos realizados a los creditos y separados de la fecha consultada" class="px-4 py-2 border">Pagos realizados</th>
              <th class="px-4 py-2 border">Utilidad Realizada</th>
            </tr>
          </thead>
          <tbody class="text-center text-gray-600"></tbody>
        </table>
      </div>

      
      
      <h3 class="ventas-generales__pane-title ventas-generales__pane-title--spaced"><i class="fa-solid fa-arrow-trend-up"></i> Rentabilidad</h3>
      <table id="tablaRentabilidad" class="display responsive nowrap tabla" width="100%">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Ingreso total</th>
            <th class="px-4 py-2 border">Egreso</th>
            <th class="px-4 py-2 border">Utilidad</th>
            <th class="px-4 py-2 border">Margen Utilidad</th>
            <th class="px-4 py-2 border">Rentabilidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td id="ingresoTotal" class=""></td>
            <td id="egreso" class=""></td>
            <td id="utilidadTotal" class=""></td>
            <td id="margenUtilidadTotal" class=""></td>
            <td id="rentabilidadTotal" class=""></td>
          </tr>
        </tbody>
      </table>

    </div> <!-- fin resumen -->

        </div>
    </section>
  </section>
</div>

<script>
  const tabs = document.querySelectorAll('.tab-btn');
  const panes = document.querySelectorAll('.tab-pane');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => {
        t.classList.remove('is-active', 'bg-indigo-600', 'text-white');
        t.classList.add('bg-white', 'text-gray-600');
      });

      panes.forEach(p => p.classList.add('hidden'));

      tab.classList.add('is-active', 'bg-indigo-600', 'text-white');
      tab.classList.remove('bg-white', 'text-gray-600');

      document.getElementById(tab.dataset.tab)?.classList.remove('hidden');
    });
  });
</script>



