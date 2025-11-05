<!-- Reportes Generales -->
<div class="p-6 bg-white rounded-xl shadow-md m-6">
  <a href="/admin/reportes" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2    mb-6">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>
  <h2 class="text-2xl font-semibold mb-4">📊 Reportes Generales</h2>

  <!-- Tabs -->
  <div class="inline-flex rounded-2xl shadow-md overflow-hidden border border-gray-300 mb-6">
      <button class="tab-btn px-6 py-3 text-base font-medium bg-indigo-600 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" data-tab="productos">
        Productos
      </button>
      <button class="tab-btn px-6 py-3 text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" data-tab="medios">
        Medios de Pago
      </button>
      <button class="tab-btn px-6 py-3 text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" data-tab="categorias">
        Categorías
      </button>
      <button class="tab-btn px-6 py-3 text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" data-tab="empleados">
        Empleados
      </button>
      <button class="tab-btn px-6 py-3 text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" data-tab="gastos">
        Gastos
      </button>
      <button class="tab-btn px-6 py-3 text-base font-medium bg-white text-gray-600 border-l border-gray-300 hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" data-tab="resumen">
        Resumen
      </button>
    </div>

  <!-- Input y botón consultar -->
    <div class="flex items-center gap-3 mb-6">
      <input 
        type="text" 
        name="datetimes" 
        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-indigo-600 block w-60 p-3 text-base     focus:outline-none focus:ring-2 focus:ring-indigo-500"
        placeholder="Seleccionar fecha"
      />
      <button id="consultarFechaPersonalizada" class="px-6 py-3 text-base font-medium bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-md transition">
        Consultar
      </button>
    </div>

<!-- Botones de exportación estilo toolbar moderno -->
<div class="flex flex-wrap gap-2 mb-4">
  <button id="btnExcel" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-green-100 hover:text-green-700 px-4 py-2 rounded-lg shadow-sm transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3H8a2 2 0 00-2 2v14a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2z" />
    </svg>
    Excel
  </button>

  <button id="btnCopy" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-blue-100 hover:text-blue-700 px-4 py-2 rounded-lg shadow-sm transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8M8 8h8M4 4h16v16H4V4z" />
    </svg>
    Copiar
  </button>

  <button id="btnCSV" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-yellow-100 hover:text-yellow-700 px-4 py-2 rounded-lg shadow-sm transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4z" />
    </svg>
    CSV
  </button>

  <button id="btnPDF" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-red-100 hover:text-red-700 px-4 py-2 rounded-lg shadow-sm transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    PDF
  </button>

  <button id="btnPrint" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-gray-900 px-4 py-2 rounded-lg shadow-sm transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V4h12v5M6 14h12v6H6v-6z" />
    </svg>
    Imprimir
  </button>
</div>

    

  <!-- Tab content -->
  <div id="tab-content">

    <!-- Productos -->
    <div id="productos" class="tab-pane">
      <h3 class="text-lg font-semibold mb-4">📦 Ventas por Productos</h3>
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Producto</th>
            <th class="px-4 py-2 border">Cantidad Vendida</th>
            <th class="px-4 py-2 border">Total Ventas</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="px-4 py-2 border">Corte Cabello</td><td class="px-4 py-2 border">120</td><td class="px-4 py-2 border">$2,400,000</td></tr>
          <tr><td class="px-4 py-2 border">Manicure</td><td class="px-4 py-2 border">85</td><td class="px-4 py-2 border">$1,700,000</td></tr>
          <tr><td class="px-4 py-2 border">Pedicure</td><td class="px-4 py-2 border">60</td><td class="px-4 py-2 border">$1,200,000</td></tr>
          <tr><td class="px-4 py-2 border">Depilación</td><td class="px-4 py-2 border">45</td><td class="px-4 py-2 border">$900,000</td></tr>
          <tr><td class="px-4 py-2 border">Masaje</td><td class="px-4 py-2 border">30</td><td class="px-4 py-2 border">$600,000</td></tr>
          <tr><td class="px-4 py-2 border">Facial</td><td class="px-4 py-2 border">25</td><td class="px-4 py-2 border">$500,000</td></tr>
          <tr><td class="px-4 py-2 border">Tintura Cabello</td><td class="px-4 py-2 border">15</td><td class="px-4 py-2 border">$450,000</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Medios de Pago -->
    <div id="medios" class="tab-pane hidden">
      <h3 class="text-lg font-semibold mb-4">💳 Ventas por Medio de Pago</h3>
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Medio de Pago</th>
            <th class="px-4 py-2 border">Transacciones</th>
            <th class="px-4 py-2 border">Total Ventas</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="px-4 py-2 border">Efectivo</td><td class="px-4 py-2 border">90</td><td class="px-4 py-2 border">$3,000,000</td></tr>
          <tr><td class="px-4 py-2 border">Tarjeta</td><td class="px-4 py-2 border">50</td><td class="px-4 py-2 border">$2,500,000</td></tr>
          <tr><td class="px-4 py-2 border">Transferencia</td><td class="px-4 py-2 border">30</td><td class="px-4 py-2 border">$1,800,000</td></tr>
          <tr><td class="px-4 py-2 border">Nequi / Daviplata</td><td class="px-4 py-2 border">20</td><td class="px-4 py-2 border">$1,000,000</td></tr>
          <tr><td class="px-4 py-2 border">Cheque</td><td class="px-4 py-2 border">5</td><td class="px-4 py-2 border">$250,000</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Categorías -->
    <div id="categorias" class="tab-pane hidden">
      <h3 class="text-lg font-semibold mb-4">📂 Ventas por Categoría</h3>
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Categoría</th>
            <th class="px-4 py-2 border">Cantidad Vendida</th>
            <th class="px-4 py-2 border">Total Ventas</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="px-4 py-2 border">Servicios</td><td class="px-4 py-2 border">200</td><td class="px-4 py-2 border">$5,000,000</td></tr>
          <tr><td class="px-4 py-2 border">Productos</td><td class="px-4 py-2 border">80</td><td class="px-4 py-2 border">$1,800,000</td></tr>
          <tr><td class="px-4 py-2 border">Promociones</td><td class="px-4 py-2 border">50</td><td class="px-4 py-2 border">$1,200,000</td></tr>
          <tr><td class="px-4 py-2 border">Accesorios</td><td class="px-4 py-2 border">30</td><td class="px-4 py-2 border">$600,000</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Empleados -->
    <div id="empleados" class="tab-pane hidden">
      <h3 class="text-lg font-semibold mb-4">👨‍💼 Ventas por Empleados</h3>
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Empleado</th>
            <th class="px-4 py-2 border">Ventas Realizadas</th>
            <th class="px-4 py-2 border">Total Ventas</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="px-4 py-2 border">Carlos Pérez</td><td class="px-4 py-2 border">70</td><td class="px-4 py-2 border">$2,100,000</td></tr>
          <tr><td class="px-4 py-2 border">Ana López</td><td class="px-4 py-2 border">55</td><td class="px-4 py-2 border">$1,650,000</td></tr>
          <tr><td class="px-4 py-2 border">Jorge Ramírez</td><td class="px-4 py-2 border">40</td><td class="px-4 py-2 border">$1,200,000</td></tr>
          <tr><td class="px-4 py-2 border">Laura Gómez</td><td class="px-4 py-2 border">35</td><td class="px-4 py-2 border">$1,050,000</td></tr>
          <tr><td class="px-4 py-2 border">Pedro Sánchez</td><td class="px-4 py-2 border">25</td><td class="px-4 py-2 border">$750,000</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Gastos -->
    <div id="gastos" class="tab-pane hidden">
      <h3 class="text-lg font-semibold mb-4">💸 Gastos</h3>
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Fecha</th>
            <th class="px-4 py-2 border">Concepto</th>
            <th class="px-4 py-2 border">Monto</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="px-4 py-2 border">2025-09-01</td><td class="px-4 py-2 border">Compra insumos</td><td class="px-4 py-2 border">$450,000</td></tr>
          <tr><td class="px-4 py-2 border">2025-09-10</td><td class="px-4 py-2 border">Publicidad</td><td class="px-4 py-2 border">$300,000</td></tr>
          <tr><td class="px-4 py-2 border">2025-09-15</td><td class="px-4 py-2 border">Servicios públicos</td><td class="px-4 py-2 border">$200,000</td></tr>
          <tr><td class="px-4 py-2 border">2025-09-20</td><td class="px-4 py-2 border">Mantenimiento</td><td class="px-4 py-2 border">$150,000</td></tr>
          <tr><td class="px-4 py-2 border">2025-09-22</td><td class="px-4 py-2 border">Material oficina</td><td class="px-4 py-2 border">$120,000</td></tr>
          <tr><td class="px-4 py-2 border">2025-09-25</td><td class="px-4 py-2 border">Software</td><td class="px-4 py-2 border">$350,000</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Resumen -->
    <div id="resumen" class="tab-pane hidden">
      <h3 class="text-lg font-semibold mb-4">📈 Resumen General</h3>
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">Indicador</th>
            <th class="px-4 py-2 border">Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="px-4 py-2 border">Total Ventas</td><td class="px-4 py-2 border">$8,000,000</td></tr>
          <tr><td class="px-4 py-2 border">Total Gastos</td><td class="px-4 py-2 border">$1,570,000</td></tr>
          <tr><td class="px-4 py-2 border">Utilidad Neta</td><td class="px-4 py-2 border">$6,430,000</td></tr>
        </tbody>
      </table>
    </div>

  </div>
</div>

<script>
  const tabs = document.querySelectorAll('.tab-btn');
  const panes = document.querySelectorAll('.tab-pane');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Resetear todas las pestañas a estado inactivo
      tabs.forEach(t => {
        t.classList.remove('bg-indigo-600','text-white');
        t.classList.add('bg-white','text-gray-600');
      });

      // Ocultar todos los paneles
      panes.forEach(p => p.classList.add('hidden'));

      // Activar la pestaña clickeada
      tab.classList.add('bg-indigo-600','text-white');
      tab.classList.remove('bg-white','text-gray-600');

      // Mostrar el contenido correspondiente
      document.getElementById(tab.dataset.tab).classList.remove('hidden');
    });
  });
</script>
