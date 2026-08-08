<!-- Reportes Generales -->
<div class="box ventasgenerales grid gap-6">
    <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>

    <header class="grid grid-cols-1 items-center gap-5 rounded-lg border border-slate-200 bg-gradient-to-br from-indigo-50 to-cyan-50 p-4 md:grid-cols-[auto_minmax(0,1fr)_auto] md:p-6">
      <a href="/admin/reportes" class="inline-flex size-16 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-700 text-2xl text-white shadow-lg transition hover:-translate-y-0.5 hover:text-white" aria-label="Volver a reportes">
        <i class="fa-solid fa-arrow-left"></i>
      </a>

      <div class="min-w-0">
        <span class="mb-1 text-base font-extrabold uppercase text-indigo-600">Ventas</span>
        <h1 class="m-0 text-3xl font-extrabold leading-tight text-slate-900 md:text-4xl">Reportes generales</h1>
        <p class="mt-1 text-lg leading-snug text-slate-500">Consulta productos, medios de pago, cartera, canales y resumen financiero por periodo.</p>
      </div>

      <div class="inline-flex w-full min-w-0 items-center gap-4 rounded-lg border border-slate-200 bg-white/90 p-4 md:w-auto md:min-w-80">
        <span class="inline-flex size-16 items-center justify-center rounded-lg bg-gradient-to-br from-cyan-400 to-cyan-600 text-3xl text-white"><i class="fa-solid fa-calendar-check"></i></span>
        <div>
          <strong class="block text-2xl font-black leading-none text-slate-900">Periodo activo</strong>
          <small class="mt-1 block text-base font-bold text-slate-500"><span id="fecha1">-</span> al <span id="fecha2">-</span></small>
        </div>
      </div>
    </header>

    <section class="ventas-generales__filters">
      <div class="flex items-center gap-4 border-b border-slate-200 pb-4">
        <span class="material-symbols-outlined inline-flex size-16 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-2xl text-indigo-600 font-medium"><i class="fa-solid fa-calendar-days"></i></span>
        <div>
          <h2 class="text-slate-900 text-2xl font-bold">Periodo de consulta</h2>
          <p class="my-0 text-lg leading-snug text-slate-500">Elige un atajo o define un rango personalizado.</p>
        </div>
      </div>

      <div class="ventas-generales__quick-actions">
        <button id="btnmesactual" class="inline-flex min-h-16 items-center justify-center gap-2 rounded-lg border border-indigo-600 bg-indigo-600 px-5 text-lg font-extrabold text-white shadow-md shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700" type="button">
          <i class="fa-regular fa-calendar-check"></i> Mes actual
        </button>
        <button id="btnmesanterior" class="inline-flex min-h-16 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 text-lg font-extrabold text-slate-700 transition hover:-translate-y-0.5 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600" type="button">
          <i class="fa-solid fa-calendar-minus text-indigo-600"></i> Mes anterior
        </button>
        <button id="btnhoy" class="inline-flex min-h-16 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 text-lg font-extrabold text-slate-700 transition hover:-translate-y-0.5 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600" type="button">
          <i class="fa-regular fa-sun text-indigo-600"></i> Hoy
        </button>
        <button id="btnayer" class="inline-flex min-h-16 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 text-lg font-extrabold text-slate-700 transition hover:-translate-y-0.5 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600" type="button">
          <i class="fa-solid fa-clock-rotate-left text-indigo-600"></i> Ayer
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
      <div class="flex items-center gap-4 border-b border-slate-200 pb-4">
        <span class="material-symbols-outlined inline-flex size-16 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-2xl text-indigo-600 font-medium"><i class="fa-solid fa-chart-simple"></i></span>
        <div>
          <h2 class="text-slate-900 text-2xl font-bold">Detalle de reportes</h2>
          <p class="my-0 text-lg leading-snug text-slate-500">Alterna entre vistas para revisar el comportamiento de ventas.</p>
        </div>
      </div>

      <!-- <div class="w-full overflow-x-auto lg:overflow-visible mb-6">
          <div class="flex w-max lg:w-auto lg:inline-flex rounded-2xl shadow-md border border-gray-300">

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-indigo-600 text-white transition" data-tab="productos">
                Productos
              </button>

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition" data-tab="medios">
                Medios de Pago
              </button>

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition" data-tab="creditosSeparados">
                Creditos/Separados
              </button>

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition" data-tab="ingresoCanalventa">
                Ingreso canal de venta
              </button>

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition" data-tab="categorias">
                Categorías
              </button>

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition" data-tab="empleados">
                Empleados
              </button>

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition" data-tab="gastos">
                Gastos
              </button>

              <button class="tab-btn shrink-0 px-5 py-3 text-sm md:text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 transition" data-tab="resumen">
                Resumen
              </button>
          </div>
        </div>
      -->

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
          <h3 class="text-slate-900 border border-b-slate-200 font-semibold text-2xl"><i class="fa-solid fa-boxes-stacked text-indigo-600"></i> Ventas por productos</h3>
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
          <h3 class="text-slate-900 border border-b-slate-200 font-semibold text-2xl"><i class="fa-solid fa-credit-card"></i> Ventas por medio de pago</h3>
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
          <h3 class="text-slate-900 border border-b-slate-200 font-semibold text-2xl"><i class="fa-solid fa-handshake"></i> Creditos/Separados</h3>
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
          <h3 class="text-slate-900 border border-b-slate-200 font-semibold text-2xl"><i class="fa-solid fa-route"></i> Ingresos por canal de venta</h3>
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
          <h3 class="text-slate-900 border border-b-slate-200 font-semibold text-2xl"><i class="fa-solid fa-folder-tree"></i> Ventas por categoria</h3>
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
          <h3 class="text-slate-900 border border-b-slate-200 font-semibold text-2xl"><i class="fa-solid fa-user-tie"></i> Ventas por empleados</h3>
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
          <h3 class="text-slate-900 border border-b-slate-200 font-semibold text-2xl"><i class="fa-solid fa-arrow-trend-down"></i> Gastos</h3>
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



