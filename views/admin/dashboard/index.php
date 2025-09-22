<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>J2 - Panel de Inicio</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* Pequeño ajuste para que los canvases se vean bien dentro de cards */
    .card-canvas { height: 220px; width: 100%; }
    @media (min-width: 1024px) { .card-canvas { height: 260px; } }
  </style>
</head>

<body class="bg-gray-50 text-gray-800">
  <div class="w-full px-6 lg:px-10">
    <!-- Header -->
    <header class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl md:text-3xl font-extrabold">
          <span id="usuarioNombre"></span>
        </h1>
        <h1 class="text-xl text-gray-500">
          Resumen general del negocio • Última actualización: 
          <span id="ultimaActualizacion">--</span>
        </h1>
      </div>
      <div class="flex items-center gap-4">
        <!-- Botón Exportar -->
        <button 
          class="px-5 py-3 bg-white border rounded-lg shadow-sm text-base font-medium 
                hover:bg-gray-100 hover:shadow-md transition duration-200">
          Exportar
        </button>
        
        <!-- Botón Actualizar -->
        <button 
          class="px-5 py-3 bg-indigo-600 text-white rounded-lg shadow-md text-base font-medium 
                hover:bg-indigo-700 hover:shadow-lg transition duration-200">
          Actualizar
        </button>
      </div>
    </header>

    <!-- Top metrics (grid) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 xl:grid-cols-4">
    <!-- Efectivo facturado (hoy) -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-green-600">
            <p class="text-lg leading-relaxed text-gray-500">Efectivo facturado (hoy)</p>
            <div class="flex items-center justify-between">
            <h2 id="efectivoFacturado" class="text-5xl font-extrabold text-green-600 leading-tight">$0</h2>
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2Zm0 10c-4.418 0-8-1.79-8-4V8c0-2.21 3.582-4 8-4s8 1.79 8 4v6c0 2.21-3.582 4-8 4Z"/>
            </svg>
            </div>
            <p id="metaEfectivo" class="text-sm text-gray-400 mt-1 leading-snug">Meta: --</p>
        </div>

        <!-- Total ingreso facturado -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-indigo-600">
            <p class="text-lg leading-relaxed text-gray-500">Total ingreso facturado</p>
            <div class="flex items-center justify-between">
            <h2 id="totalIngresosFacturados" class="text-5xl font-extrabold text-indigo-600 leading-tight">$0</h2>
            <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 4h16v4H4zm0 6h16v10H4z"/>
            </svg>
            </div>
            <p id="metaFacturado" class="text-sm text-gray-400 mt-1 leading-snug">Periodo: --</p>
        </div>

        <!-- Productos vendidos -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-gray-600">
            <p class="text-lg leading-relaxed text-gray-500">Productos vendidos</p>
            <div class="flex items-center justify-between">
            <h2 id="productosVendidos" class="text-5xl font-extrabold leading-tight">0</h2>
            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3h18v4H3zm2 6h14v12H5z"/>
            </svg>
            </div>
            <p id="metaProductos" class="text-sm text-gray-400 mt-1 leading-snug">Periodo: --</p>
        </div>

        <!-- Facturas emitidas / eliminadas -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-red-600">
            <p class="text-lg leading-relaxed text-gray-500">Facturas (emitidas / eliminadas)</p>
            <div class="flex items-center justify-between">
                <div>
                    <h2 id="facturasEmitidas" class="text-5xl font-extrabold leading-tight">0</h2>
                    <p class="text-sm text-gray-400 leading-snug">emitidas</p>
                </div>
                <div class="text-right">
                    <h2 id="facturasEliminadas" class="text-5xl font-extrabold text-red-500 leading-tight">0</h2>
                    <p class="text-sm text-gray-400 leading-snug">eliminadas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Secondary indicators -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Indicador de gastos -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-red-600">
            <p class="text-lg leading-relaxed text-gray-500">Indicador de gastos (hoy)</p>
            <div class="flex items-center justify-between">
            <h3 id="gastosHoy" class="text-5xl font-bold text-red-600 leading-tight">$0</h3>
            <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.1 0-2 .9-2 2h4c0-1.1-.9-2-2-2Zm0 8c-4.418 0-8-1.79-8-4V8c0-2.21 3.582-4 8-4s8 1.79 8 4v4c0 2.21-3.582 4-8 4Z"/>
            </svg>
            </div>
            <p class="text-sm text-gray-400 mt-1 leading-snug">Gastos por transacción promedio: <span id="gastoPromedio">$0</span></p>
        </div>

        <!-- Descuentos aplicados -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-yellow-600">
            <p class="text-lg leading-relaxed text-gray-500">Descuentos aplicados</p>
            <div class="flex items-center justify-between">
                <h3 id="descuentosAplicados" class="text-5xl font-bold text-yellow-600 leading-tight">$0</h3>
                <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v10m-3-3h6" />
                </svg>
            </div>
            <p class="text-sm text-gray-400 mt-1 leading-snug">Total descuentos</p>
        </div>

        <!-- Producto más vendido -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-gray-600">
            <p class="text-lg leading-relaxed text-gray-500">Producto más vendido</p>
            <div class="flex items-center justify-between">
                <h3 id="productoMasVendido" class="text-5xl font-bold leading-tight">-</h3>
                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
            </div>
            <p class="text-sm text-gray-400 mt-1 leading-snug">Unidades: <span id="unidadesPMV">0</span></p>
        </div>
    </section>

    <!-- Main charts area -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
      <!-- Large sales by hours (main) -->
      <div class="lg:col-span-2 bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Ventas por horas (hoy)</h3>
          <p class="text-sm text-gray-400">Hoy: <span id="ventasHoySummary">$0</span></p>
        </div>
        <div class="card-canvas">
          <canvas id="chartVentasHoras"></canvas>
        </div>
      </div>

      <!-- Ingresos por día (últimos 7 días) -->
      <div class="bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Ingresos por día (últimos 7)</h3>
          <p class="text-sm text-gray-400">Total: <span id="ingresos7diasTotal">$0</span></p>
        </div>
        <div class="card-canvas">
          <canvas id="chartIngresosDias"></canvas>
        </div>
      </div>
    </section>

    <!-- Historical & small charts -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <!-- Ventas vs Gastos histórico (combinado) -->
      <div class="bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Histórico: Ventas vs Gastos</h3>
          <p class="text-sm text-gray-400">Últimos 6 meses</p>
        </div>
        <div class="card-canvas">
          <canvas id="chartVentasGastos"></canvas>
        </div>
      </div>

      <!-- Gastos por transacción (doughnut) -->
      <div class="bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Gastos por transacción</h3>
          <p class="text-sm text-gray-400">Distribución</p>
        </div>
        <div class="card-canvas flex items-center justify-center">
          <canvas id="chartGastosTransaccion" style="max-width:260px;"></canvas>
        </div>
      </div>
    </section>

<!-- Bottom: Top products + Stock minimo -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-10 pb-28 md:pb-4">
  <!-- Top productos (tabla) -->
  <div class="lg:col-span-2 bg-white rounded-2xl p-7 shadow-sm">
    <div class="flex items-center justify-between mb-5">
      <h3 class="text-2xl font-bold text-gray-700">Top productos más vendidos</h3>
      <p class="text-lg text-gray-400">Periodo: <span id="periodoTop">Últimos 30 días</span></p>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead class="text-base text-gray-500 border-b">
          <tr>
            <th class="py-4">Producto</th>
            <th class="py-4">Unidades</th>
            <th class="py-4">Ingresos</th>
            <th class="py-4">%</th>
          </tr>
        </thead>
        <tbody id="tablaTopProductos" class="text-lg">
          <!-- Placeholder rows -->
          <tr class="border-b">
            <td class="py-4">Producto A</td>
            <td class="py-4">120</td>
            <td class="py-4">$1,200,000</td>
            <td class="py-4">25%</td>
          </tr>
          <tr class="border-b">
            <td class="py-4">Producto B</td>
            <td class="py-4">90</td>
            <td class="py-4">$810,000</td>
            <td class="py-4">17%</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Stock mínimo -->
  <div class="bg-white rounded-2xl p-7 shadow-sm">
    <div class="flex items-center justify-between mb-5">
      <h3 class="text-2xl font-bold text-gray-700">Productos con stock mínimo</h3>
      <p class="text-lg text-gray-400">Alerta</p>
    </div>

    <ul id="listaStockMinimo" class="space-y-5 text-lg">
      <!-- Placeholder items -->
      <li class="flex items-center justify-between">
        <div>
          <p class="font-semibold">Arroz 5kg</p>
          <p class="text-sm text-gray-400">Min: 5</p>
        </div>
        <div class="text-right">
          <p class="text-4xl font-extrabold text-red-500">2</p>
          <p class="text-sm text-gray-400">uds</p>
        </div>
      </li>
      <li class="flex items-center justify-between">
        <div>
          <p class="font-semibold">Harina</p>
          <p class="text-4xl text-gray-400">Min: 4</p>
        </div>
        <div class="text-right">
          <p class="text-4xl font-extrabold text-yellow-600">3</p>
          <p class="text-sm text-gray-400">uds</p>
        </div>
      </li>
    </ul>
  </div>
</section>


  </div>

  <!-- ====== SCRIPTS: Datos ejemplo y Charts ====== -->
  <script>
    // ---------- Placeholders / data example ----------
    // Estos arrays/de objetos los debe rellenar tu backend (o JS que consuma API)
    // Reemplaza las variables a continuación por llamadas fetch o por
    // valores PHP inyectados si trabajas con server rendering.

    // Ejemplo resumen:
    const resumen = {
      usuarioNombre: "",
      ultimaActualizacion: new Date().toLocaleString(),
      efectivoFacturado: 450000,
      totalIngresosFacturados: 8200000,
      productosVendidos: 320,
      facturasEmitidas: 58,
      facturasEliminadas: 1,
      gastosHoy: 120000,
      gastoPromedio: 3500,
      descuentosAplicados: 8000,
      productoMasVendido: "Pollo broaster",
      unidadesPMV: 120,
      ventasHoySummary: "$450.000",
      ingresos7diasTotal: "$8.200.000"
    };

    // Ventas por horas (hoy) - ejemplo 24 horas o por horas de apertura (aquí 10 valores)
    const ventasPorHoras = {
      labels: ["08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00"],
      data:    [5, 12, 20, 35, 60, 48, 30, 22, 15, 10]
    };

    // Ingresos últimos 7 días
    const ingresosDias = {
      labels: ["Lun","Mar","Mié","Jue","Vie","Sáb","Dom"],
      data:   [120000, 150000, 180000, 90000, 200000, 170000, 220000]
    };

    // Gastos por transacción (gráfico doughnut)
    const gastosTransaccion = {
      labels: ["Comisiones", "Materia Primas", "Servicios", "Otros"],
      data:   [15, 50, 25, 10] // porcentajes o montos relativos
    };

    // Histórico Ventas vs Gastos (últimos 6 meses)
    const historicoVG = {
      labels: ["Abr","May","Jun","Jul","Ago","Sep"],
      ventas: [1200000, 1500000, 1800000, 1400000, 2000000, 2200000],
      gastos: [700000, 800000, 850000, 780000, 900000, 980000]
    };

    // Top productos (tabla) - ejemplo
    const topProductos = [
      { nombre: "Taladro percutor BLACK AND DECKER 550W 1/2", unidades: 120, ingresos: 1200000, porcentaje: "25%" },
      { nombre: "Aspiradorax", unidades: 90, ingresos: 810000, porcentaje: "17%" },
      { nombre: "Bi-Pro Vainilla 5kg", unidades: 70, ingresos: 700000, porcentaje: "14%" }
    ];

    // Stock minimo - ejemplo
    const stockMinimo = [
      { nombre: "Vitamina women Blend", actual: 2, minimo: 5 },
      { nombre: "Aspiradorax", actual: 3, minimo: 4 },
      { nombre: "Bi-Pro Vainilla 5kg", actual: 6, minimo: 8 }
    ];

    // ---------- Rellenar valores en DOM ----------
    document.getElementById('usuarioNombre').innerText = resumen.usuarioNombre;
    document.getElementById('ultimaActualizacion').innerText = resumen.ultimaActualizacion;
    document.getElementById('efectivoFacturado').innerText = `$${Number(resumen.efectivoFacturado).toLocaleString('es-CO')}`;
    document.getElementById('totalIngresosFacturados').innerText = `$${Number(resumen.totalIngresosFacturados).toLocaleString('es-CO')}`;
    document.getElementById('productosVendidos').innerText = resumen.productosVendidos;
    document.getElementById('facturasEmitidas').innerText = resumen.facturasEmitidas;
    document.getElementById('facturasEliminadas').innerText = resumen.facturasEliminadas;
    document.getElementById('gastosHoy').innerText = `$${Number(resumen.gastosHoy).toLocaleString('es-CO')}`;
    document.getElementById('gastoPromedio').innerText = `$${Number(resumen.gastoPromedio).toLocaleString('es-CO')}`;
    document.getElementById('descuentosAplicados').innerText = `$${Number(resumen.descuentosAplicados).toLocaleString('es-CO')}`;
    document.getElementById('productoMasVendido').innerText = resumen.productoMasVendido;
    document.getElementById('unidadesPMV').innerText = resumen.unidadesPMV;
    document.getElementById('ventasHoySummary').innerText = resumen.ventasHoySummary;
    document.getElementById('ingresos7diasTotal').innerText = resumen.ingresos7diasTotal;

    // Rellenar tabla top productos
    const tbodyTop = document.getElementById('tablaTopProductos');
    tbodyTop.innerHTML = ""; // limpiar
    topProductos.forEach(p => {
      const tr = document.createElement('tr');
      tr.className = 'border-b';
      tr.innerHTML = `
        <td class="py-2">${p.nombre}</td>
        <td class="py-2">${p.unidades}</td>
        <td class="py-2">$${Number(p.ingresos).toLocaleString('es-CO')}</td>
        <td class="py-2">${p.porcentaje}</td>
      `;
      tbodyTop.appendChild(tr);
    });

    // Rellenar lista stock minimo
    const ulStock = document.getElementById('listaStockMinimo');
    ulStock.innerHTML = "";
    stockMinimo.forEach(item => {
      const li = document.createElement('li');
      const levelClass = item.actual <= item.minimo ? 'text-red-500 font-bold text-xl' : 'text-yellow-600 font-semibold';
      li.className = 'flex items-center justify-between';
      li.innerHTML = `
        <div>
          <p class="font-medium">${item.nombre}</p>
          <p class="text-xs text-gray-400">Min: ${item.minimo}</p>
        </div>
        <div class="text-right">
          <p class="${levelClass}">${item.actual}</p>
          <p class="text-xs text-gray-400">uds</p>
        </div>
      `;
      ulStock.appendChild(li);
    });

    // ---------- Charts ----------

    // Helper to format currency in tooltips
    const formatCOP = (value) => {
      if (typeof value === 'number') return `$${value.toLocaleString('es-CO')}`;
      return value;
    };

    // Ventas por horas (line)
    const ctxHoras = document.getElementById('chartVentasHoras').getContext('2d');
    new Chart(ctxHoras, {
      type: 'line',
      data: {
        labels: ventasPorHoras.labels,
        datasets: [{
          label: 'Ventas (unidades)',
          data: ventasPorHoras.data,
          borderColor: '#6366F1',
          backgroundColor: 'rgba(99,102,241,0.12)',
          fill: true,
          tension: 0.35,
          pointRadius: 3
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: (ctx) => ` ${ctx.parsed.y} unidades`
            }
          },
          legend: { display: false }
        }
      }
    });

    // Ingresos por día (bar)
    const ctxIngresosDias = document.getElementById('chartIngresosDias').getContext('2d');
    new Chart(ctxIngresosDias, {
      type: 'bar',
      data: {
        labels: ingresosDias.labels,
        datasets: [{
          label: 'Ingresos',
          data: ingresosDias.data,
          backgroundColor: '#10B981'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: (ctx) => formatCOP(ctx.parsed.y)
            }
          },
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { callback: (v) => (v >= 1000 ? `$${(v/1000)}k` : `$${v}`) }
          }
        }
      }
    });

    // Gastos por transacción (doughnut)
    const ctxGastos = document.getElementById('chartGastosTransaccion').getContext('2d');
    new Chart(ctxGastos, {
      type: 'doughnut',
      data: {
        labels: gastosTransaccion.labels,
        datasets: [{
          data: gastosTransaccion.data,
          backgroundColor: ['#EF4444','#F59E0B','#3B82F6','#6B7280']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });

    // Ventas vs Gastos (combinado: barras gastos + línea ventas)
    const ctxVG = document.getElementById('chartVentasGastos').getContext('2d');
    new Chart(ctxVG, {
      data: {
        labels: historicoVG.labels,
        datasets: [
          {
            type: 'bar',
            label: 'Gastos',
            data: historicoVG.gastos,
            backgroundColor: 'rgba(239,68,68,0.8)'
          },
          {
            type: 'line',
            label: 'Ventas',
            data: historicoVG.ventas,
            borderColor: '#4F46E5',
            backgroundColor: 'rgba(79,70,229,0.15)',
            tension: 0.3,
            fill: true,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } },
        scales: {
          y: {
            beginAtZero: true,
            position: 'left',
            title: { display: true, text: 'Gastos (COP)' }
          },
          y1: {
            beginAtZero: true,
            position: 'right',
            grid: { drawOnChartArea: false },
            title: { display: true, text: 'Ventas (COP)' }
          }
        },
      }
    });

    // ---------- FIN Charts ----------
  </script>
</body>
</html>