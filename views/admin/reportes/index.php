<div class="box reportes">
    <h4 class="text-gray-600 mb-8">Reportes</h4>
    <div class="w-full min-h-80 grid grid-cols-2 tlg:grid-cols-3 gap-4 ">
        <div class="col-span-2 tlg:col-span-2">
            <p class="text-gray-500 text-xl mt-0 mb-2">Representacion grafica de ventas</p>
            <button class="btn-xs btn-light">Mensual</button>
            <button class="btn-xs btn-light">Semanal</button>
            <button class="btn-xs btn-light">Diario</button>
            <div class="max-h-96"><canvas class="max-h-96" id="chartventas"></canvas></div>
        </div>
        <div class="col-span-2 xxs:col-span-1">
            <div class=" px-4">
                <div class="flex justify-between mb-3">
                    <div class="border border-gray-300 w-56 text-center px-4 py-8 text-white bg-purple-700 rounded-lg"><span class="text-4xl font-medium">9</span><p class="m-0 mt-1 font-light text-xl leading-4">N. de clientes</p></div>
                    <div class="border border-gray-300 w-56 text-center px-4 py-8 text-white bg-purple-700 rounded-lg"><span class="text-4xl font-medium">4</span><p class="m-0 mt-1 font-light text-xl leading-4">Productos sin stock</p></div>
                </div>
                <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg mb-3"><p class="m-0 font-medium text-green-500 text-3xl">$8.000</p>This month</div>
                <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg mb-3"><p class="m-0 font-medium text-3xl text-amber-500">$8.000</p>This month</div>
                <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-3xl text-purple-600">$8.000</p>This month</div>
            </div>
        </div>
        <div class="col-span-2 xxs:col-span-1 tlg:col-start-3 tlg:col-end-4">
            <p class="text-gray-500 text-xl mt-0 mb-2">Representacion grafica de utilidad</p>
            <button class="btn-xs btn-light">Mensual</button>
            <button class="btn-xs btn-light">Semanal</button>
            <button class="btn-xs btn-light">Diario</button>
            <div class="max-h-96"><canvas class="max-h-96" id="chartutilidad"></canvas></div>
        </div>
        <div class="tlg:row-start-2 tlg:row-end-3 col-start-1 col-end-3">
            <h5 class="mb-5">Reportes de Ventas</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" id="ventasgenerales"><span class="material-symbols-outlined">payments</span>Ventas generales</button> 
                <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" id="cierrescaja"><span class="material-symbols-outlined">attach_money</span>Cierres de caja</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><i class="mb-1 text-3xl fa-solid fa-z"></i>Zeta diario</button>
                <a href="/admin/reportes/ventasxtransaccion" class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">speaker_notes</span>Ventas por transaccion</a>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">speaker_notes</span>Ventas por cliente</button> 
            </div>
            <h5 class="mb-5 mt-14">Reportes de Facturas</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">request_quote</span>Facturas pagas</button>
                <a class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600" href="/admin/caja/pedidosguardados"><span class="material-symbols-outlined">speaker_notes</span>Facturas no pagas</a>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">receipt_long</span>Cotizaciones</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">contract_delete</span>Facturas anuladas</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">speaker_notes</span>Electronicas generadas</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">speaker_notes</span>Electronicas Pendientes</button>
            </div>
            <h5 class="mb-5 mt-14">Reportes de Inventario</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">category</span>Inventario por producto</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">splitscreen_bottom</span>Inventario por categoria</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">speaker_notes</span>Movimientos inventario</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"><span class="material-symbols-outlined">speaker_notes</span>Compras</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"><span class="material-symbols-outlined">move_up</span>Rotacion de inventario</button>
            </div>
        </div>

        <div class="col-span-2">
            <h5 class="mb-5 mt-14">Utilidad Gastos y Crecimiento</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">monitoring</span>Utilidad Rentabilidad</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">chart_data</span>Utilidad por producto</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">chart_data</span>Utilidad por categoria</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">fact_check</span>Gastos e ingresos</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">query_stats</span>Comparación interanual</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">deployed_code_update</span>Tasa de retorno</button>
            </div>
        </div>
        <div class="col-span-2 tlg:col-span-1">
            <h5 class="mb-5 mt-14">Otros</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="flex flex-col items-center w-[120px] p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center text-slate-600"><span class="material-symbols-outlined">person_add</span>Clientes nuevos</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"><span class="material-symbols-outlined">person_check</span>Clientes recurrentes</button>
                <button class="flex flex-col items-center w-[120px] p-6 bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl !text-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"><span class="material-symbols-outlined">vpn_key_alert</span>Registro de actividad</button>
            </div>
        </div>
    </div>

</div>