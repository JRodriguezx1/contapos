<div class="box reportes mb-20">
  <h4 class="text-gray-600 mb-8">Reportes</h4>
  <div class="w-full min-h-80 grid grid-cols-2 tlg:grid-cols-3 gap-4">
    <!-- Gráfica de barras -->
    <div class="col-span-2 tlg:col-span-2 flex flex-col">
        <p class="text-gray-500 text-xl mb-2">Representacion grafica de ventas</p>
    
        <!-- Botones ajustados al texto -->
        <div class="inline-flex self-start rounded-2xl shadow-md overflow-hidden border border-gray-300">
            <button id="graficaVentaMensual" 
                class="graficaventa px-6 py-3 text-base font-medium text-gray-600 bg-white 
                    hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none 
                    focus:ring-2 focus:ring-indigo-500 transition">
                Mensual
            </button>
            <button id="graficaVentaDiario" 
                class="graficaventa px-6 py-3 text-base font-medium text-gray-600 bg-white 
                    hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none 
                    focus:ring-2 focus:ring-indigo-500 border-l border-gray-300 transition">
                Diario
            </button>
        </div>


        <!-- Gráfica -->
        <div class="flex-1 h-[390px]">
            <canvas id="chartventas" class="h-full w-full"></canvas>
        </div>
    </div>


    <!-- Gráfica circular -->
    <div class="col-span-2 xxs:col-span-1 tlg:col-start-3 tlg:col-end-4 flex flex-col">
      <p class="text-gray-500 text-xl mb-2">Valor de los productos principales del inventario</p>
      <div class="flex-1 h-[390px]">
        <canvas id="chartutilidad" class="h-full w-full"></canvas>
      </div>
    </div>

    <!-- Reportes de Ventas -->
    <div class="tlg:row-start-2 tlg:row-end-3 col-start-1 col-end-3">
      <h5 class="mb-5">Reportes de Ventas</h5>
      <div class="flex flex-wrap gap-4 mb-4">
        <a href="/admin/reportes/ventasgenerales" class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white text-center border border-gray-200 rounded-lg shadow-md   ">
          <span class="material-symbols-outlined">payments</span>Ventas generales
        </a>
        <a href="/admin/caja/ultimoscierres" class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white text-center border border-gray-200 rounded-lg shadow-md   ">
          <span class="material-symbols-outlined">attach_money</span>Cierres de caja
        </a>
        <a href="/admin/caja/zetadiario" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <i class="mb-1 text-3xl fa-solid fa-z"></i>Zeta diario
        </a>
        <a href="/admin/reportes/ventasxtransaccion" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">speaker_notes</span>Ventas por transaccion
        </a>
        <a href="/admin/reportes/ventasxcliente" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">speaker_notes</span>Ventas por cliente
        </a>
      </div>

      <h5 class="mb-5 mt-14">Reportes de Facturas</h5>
      <div class="flex flex-wrap gap-4 mb-4">
        <a href="/admin/reportes/facturaspagas" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">request_quote</span>Facturas pagas
        </a>
        <a href="/admin/caja/pedidosguardados" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">receipt_long</span>Cotizaciones
        </a>
        <a href="/admin/reportes/creditos" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">speaker_notes</span>Creditos
        </a>
        <a href="/admin/reportes/facturasanuladas" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">contract_delete</span>Facturas anuladas
        </a>
        <a href="/admin/reportes/facturaselectronicas" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">speaker_notes</span>Electronicas generadas
        </a>
        <a href="/admin/reportes/facturaselectronicaspendientes" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">speaker_notes</span>Electronicas Pendientes
        </a>
      </div>

      <h5 class="mb-5 mt-14">Reportes de Inventario</h5>
      <div class="flex flex-wrap gap-4 mb-4">
        <a href="/admin/reportes/inventarioxproducto" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">category</span>Inventario por producto
        </a>
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">splitscreen_bottom</span>Inventario por categoria
        </button>
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">inventory</span>Inventario por sede
        </button>
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">inventory_2</span>Inventario general
        </button>
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">speaker_notes</span>Movimientos inventario
        </button>
        <a href="/admin/reportes/compras" class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md   ">
          <span class="material-symbols-outlined">speaker_notes</span>Compras
        </a>
        <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md   ">
          <span class="material-symbols-outlined">move_up</span>Rotacion de inventario
        </button>
      </div>
    </div>

    <!-- Utilidad Gastos y Crecimiento -->
    <div class="col-span-2">
      <h5 class="mb-5 mt-14">Utilidad Gastos y Crecimiento</h5>
      <div class="flex flex-wrap gap-4 mb-4">
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">monitoring</span>Utilidad Rentabilidad
        </button>
        <a href="/admin/reportes/utilidadxproducto" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">chart_data</span>Utilidad por producto
        </a>
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">chart_data</span>Utilidad por categoria
        </button>
        <a href="/admin/reportes/gastoseingresos" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">fact_check</span>Gastos e ingresos
        </a>
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">query_stats</span>Comparación interanual
        </button>
        <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">deployed_code_update</span>Tasa de retorno
        </button>
      </div>
    </div>

    <!-- Otros -->
    <div class="col-span-2 tlg:col-span-1">
      <h5 class="mb-5 mt-14">Otros</h5>
      <div class="flex flex-wrap gap-4 mb-4">
        <a href="/admin/reportes/clientesnuevos" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100    text-center text-slate-600">
          <span class="material-symbols-outlined">person_add</span>Clientes nuevos
        </a>
        <a href="/admin/reportes/clientesrecurrentes" class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md   ">
          <span class="material-symbols-outlined">person_check</span>Clientes recurrentes
        </a>
        <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md   ">
          <span class="material-symbols-outlined">vpn_key_alert</span>Registro de actividad
        </button>
      </div>
    </div>
  </div>
</div>
