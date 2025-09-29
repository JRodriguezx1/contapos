<div class="bg-gray-50 text-gray-800 inicio">

  <style>
    /* Pequeño ajuste para que los canvases se vean bien dentro de cards */
    .card-canvas { height: 220px; width: 100%; }
    @media (min-width: 1024px) { .card-canvas { height: 260px; } }
  </style>
  
  <div class="w-full px-4 lg:px-4">
    <!-- Header -->
    <header class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl md:text-3xl font-extrabold"><span id="usuarioNombre"></span></h1>
        <h1 class="text-xl text-gray-500">
          Resumen general del negocio • Última actualización: 
          <span id="ultimaActualizacion">--</span>
        </h1>
      </div>
      <div class="flex items-center gap-4">
        <!-- Botón Exportar -->
        <button 
          class="px-5 py-3 bg-white border rounded-lg shadow-sm text-base font-medium hover:bg-gray-100 hover:shadow-md transition duration-200">
          Exportar
        </button>
        
        <!-- Botón Actualizar -->
        <button 
          class="px-5 py-3 bg-indigo-600 text-white rounded-lg shadow-md text-base font-medium hover:bg-indigo-700 hover:shadow-lg transition duration-200">
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
              <h2 id="efectivoFacturado" class="text-4xl font-extrabold text-green-600 leading-tight">$<?php echo number_format($indicadoreseconomicos[0]->efectivofacturado??'0', '0', ',', '.');?></h2>
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
              <h2 id="totalIngresosFacturados" class="text-4xl font-extrabold text-indigo-600 leading-tight">$<?php echo number_format($indicadoreseconomicos[0]->totalingreso??'0', '0', ',', '.');?></h2>
              <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M4 4h16v4H4zm0 6h16v10H4z"/>
              </svg>
            </div>
            <p id="metaFacturado" class="text-sm text-gray-400 mt-1 leading-snug">Periodo: --</p>
        </div>

        <!-- Facturas emitidas / eliminadas -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-red-600">
            <p class="text-lg leading-relaxed text-gray-500">Facturas (emitidas / eliminadas)</p>
            <div class="flex items-center justify-between">
                <div>
                    <h2 id="facturasEmitidas" class="text-4xl font-extrabold leading-tight"><?php echo number_format($indicadoreseconomicos[0]->totalfacturas??'0', '0', ',', '.');?></h2>
                    <p class="text-sm text-gray-400 leading-snug mb-0">emitidas</p>
                </div>
                <div class="text-right">
                    <h2 id="facturasEliminadas" class="text-4xl font-extrabold text-red-500 leading-tight"><?php echo number_format($indicadoreseconomicos[0]->totalfacturaseliminadas??'0', '0', ',', '.');?></h2>
                    <p class="text-sm text-gray-400 leading-snug mb-0">eliminadas</p>
                </div>
            </div>
        </div>

         <!-- Descuentos aplicados -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-yellow-600">
            <p class="text-lg leading-relaxed text-gray-500">Descuentos aplicados</p>
            <div class="flex items-center justify-between">
                <h3 id="descuentosAplicados" class="text-4xl font-bold text-yellow-600 leading-tight">$<?php echo number_format($indicadoreseconomicos[0]->totaldescuentos??'0', '0', ',', '.');?></h3>
                <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v10m-3-3h6" />
                </svg>
            </div>
            <p class="text-sm text-gray-400 mt-1 leading-snug">Total descuentos</p>
        </div>
    </section>

    <!-- Secondary indicators -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Indicador de gastos -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-red-600">
            <p class="text-lg leading-relaxed text-gray-500">Indicador de gastos (hoy)</p>
            <div class="flex items-center justify-between">
              <h3 id="gastosHoy" class="text-4xl font-bold text-red-600 leading-tight">$<?php echo number_format($indicadoreseconomicos[0]->gastoscaja??'0', '0', ',', '.');?></h3>
              <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M12 8c-1.1 0-2 .9-2 2h4c0-1.1-.9-2-2-2Zm0 8c-4.418 0-8-1.79-8-4V8c0-2.21 3.582-4 8-4s8 1.79 8 4v4c0 2.21-3.582 4-8 4Z"/>
              </svg>
            </div>
            <p class="text-sm text-gray-400 mt-1 leading-snug">Gastos por transacción promedio: <span id="gastoPromedio">$0</span></p>
        </div>

        <!-- Productos vendidos -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-gray-300">
            <p class="text-lg leading-relaxed text-gray-500">Productos vendidos</p>
            <div class="flex items-center justify-between">
              <h2 id="productosVendidos" class="text-4xl font-extrabold leading-tight"><?php echo $cantidadesproductos[0]->totalproductosvendidos??'0';?></h2>
              <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3h18v4H3zm2 6h14v12H5z"/>
              </svg>
            </div>
            <p id="metaProductos" class="text-sm text-gray-400 mt-1 leading-snug">Periodo: ultimos 30 dias</p>
        </div>

        <!-- Producto más vendido -->
        <div class="bg-white rounded-2xl p-5 shadow-sm space-y-3 border-b-4 border-gray-600">
            <p class="text-lg leading-relaxed text-gray-500">Producto más vendido</p>
            <div class="flex items-center justify-between">
                <h3 id="productoMasVendido" class="text-3xl font-bold leading-tight"><?php echo $cantidadesproductos[0]->nombre??'--';?></h3>
                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
            </div>
            <p class="text-sm text-gray-400 mt-1 leading-snug">Ultimos 30 dias / Unidades: <?php echo $cantidadesproductos[0]->topunidadesvendidas??'0';?></p>
        </div>
    </section>

    <!-- Main charts area -->
    <section class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
      <!-- Large sales by hours (main) -->
      <!-- <div class="lg:col-span-2 bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Ventas por horas (hoy)</h3>
          <p class="text-sm text-gray-400">Hoy: <span id="ventasHoySummary">$0</span></p>
        </div>
        <div class="card-canvas">
          <canvas id="chartVentasHoras"></canvas>
        </div>
      </div>-->

      <div class="bg-white rounded-2xl p-5 shadow-sm lg:col-span-2">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Histórico: Ventas vs Gastos</h3>
          <p class="text-base text-gray-400">Últimos 6 meses</p>
        </div>
        <div class="card-canvas">
          <canvas id="chartVentasGastos"></canvas>
        </div>
      </div>
      <!-- Ingresos por día (últimos 7 días) -->
      <div class="bg-white rounded-2xl p-5 shadow-sm lg:col-span-2">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Ingresos por día (últimos 7)</h3>
          <p class="text-sm text-gray-400">Total: <span id="ingresos7diasTotal">ventas</span></p>
        </div>
        <div class="card-canvas">
          <canvas id="chartIngresosDias"></canvas>
        </div>
      </div>
    </section>

    <!-- Historical & small charts -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <!-- Ventas vs Gastos histórico (combinado) -->
      <!--<div class="bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Histórico: Ventas vs Gastos</h3>
          <p class="text-sm text-gray-400">Últimos 6 meses</p>
        </div>
        <div class="card-canvas">
          <canvas id="chartVentasGastos"></canvas>
        </div>
      </div>-->

      <!-- Gastos por transacción (doughnut) -->
      <!--<div class="bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-2xl font-semibold">Gastos por transacción</h3>
          <p class="text-sm text-gray-400">Distribución</p>
        </div>
        <div class="card-canvas flex items-center justify-center">
          <canvas id="chartGastosTransaccion" style="max-width:260px;"></canvas>
        </div>
      </div>-->
    </section>

    <!-- Bottom: Top products + Stock minimo -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-28 md:pb-4">
      <!-- Top productos (tabla) -->
      <div class="lg:col-span-2 bg-white rounded-2xl p-7 shadow-sm">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-2xl font-bold text-gray-700">Top 8 productos más vendidos</h3>
          <p class="text-lg text-gray-400">Periodo: <span id="periodoTop">Últimos 30 días</span></p>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="text-base text-gray-500 border-b">
              <tr>
                <th class="py-4">Producto</th>
                <th class="py-4">Unidades</th>
                <th class="py-4">Ingresos</th>
                <th class="py-4">Porcentaje</th>
              </tr>
            </thead>
            <tbody id="tablaTopProductos" class="text-lg">
              <?php foreach($cantidadesproductos as $value): ?>
                <tr class="border-b">
                  <td class="py-4"><?php echo $value->nombre??'';?></td>
                  <td class="py-4"><?php echo $value->topunidadesvendidas??0;?></td>
                  <td class="py-4">$ <?php echo number_format($value->totaldinero??0, '2', ',', '.');?></td>
                  <td class="py-4">% <?php echo $value->porcentaje??0;?></td>
                </tr>
              <?php endforeach; ?>
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
        <ul id="listaStockMinimo" class="text-lg">
          <?php foreach($productosSotckMin as $value): ?>
            <li class="flex items-center justify-between">
              <div>
                <p class="font-medium mb-0"><?php echo $value->nombre??'';?></p>
                <p class="text-base text-gray-400 mt-2">Min: <?php echo $value->stockminimo??'';?></p>
              </div>
              <div class="text-right">
                <p class="text-red-500 font-bold text-xl mb-0"><?php echo $value->stock??'';?></p>
                <p class="text-base text-gray-400 mt-2"><?php echo $value->unidadmedida??'';?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>

  </div>

</div>
