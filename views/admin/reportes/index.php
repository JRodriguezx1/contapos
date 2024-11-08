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
            <h5 class="mb-2 text-slate-600">Reportes de ventas</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="btn-command" id="ventasgenerales"><span class="material-symbols-outlined">payments</span>Ventas generales</button>
                <button class="btn-command" id="cierrescaja"><span class="material-symbols-outlined">attach_money</span>Cierres de caja</button>
                <button class="btn-command"><i class="mb-1 text-3xl fa-solid fa-z"></i>Zeta diario</button>
                <a href="/admin/reportes/ventasxtransaccion" class="btn-command text-center"><span class="material-symbols-outlined">speaker_notes</span>Ventas por transaccion</a>
                <button class="btn-command"><span class="material-symbols-outlined">speaker_notes</span>Ventas por cliente</button>
            </div>
            <h5 class="mb-2 text-slate-600">Reportes de facturas</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="btn-command"><span class="material-symbols-outlined">request_quote</span>Facturas pagas</button>
                <button class="btn-command"><span class="material-symbols-outlined">speaker_notes</span>Facturas no pagas</button>
                <button class="btn-command"><span class="material-symbols-outlined">receipt_long</span>Cotizaciones</button>
                <button class="btn-command"><span class="material-symbols-outlined">contract_delete</span>Facturas anuladas</button>
                <button class="btn-command"><span class="material-symbols-outlined">speaker_notes</span>Electronicas generadas</button>
                <button class="btn-command"><span class="material-symbols-outlined">speaker_notes</span>Electronicas Pendientes</button>
            </div>
            <h5 class="mb-2 text-slate-600">reportes de inventario</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="btn-command"><span class="material-symbols-outlined">category</span>Iventario por producto</button>
                <button class="btn-command"><span class="material-symbols-outlined">splitscreen_bottom</span>Iventario por categoria</button>
                <button class="btn-command"><span class="material-symbols-outlined">speaker_notes</span>Movimientos inventario</button>
                <button class="btn-command"><span class="material-symbols-outlined">speaker_notes</span>Compras</button>
                <button class="btn-command"><span class="material-symbols-outlined">move_up</span>Rotacion de inventario</button>
            </div>
        </div>

        <div class="col-span-2">
            <h5 class="mb-2 text-slate-600">Utilidad, gastos y crecimiento</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="btn-command"><span class="material-symbols-outlined">monitoring</span>Utilidad Rentabilidad</button>
                <button class="btn-command"><span class="material-symbols-outlined">chart_data</span>Utilidad por producto</button>
                <button class="btn-command"><span class="material-symbols-outlined">chart_data</span>Utilidad por categoria</button>
                <button class="btn-command"><span class="material-symbols-outlined">fact_check</span>Gastos e ingresos</button>
                <button class="btn-command"><span class="material-symbols-outlined">query_stats</span>Comparación interanual</button>
                <button class="btn-command"><span class="material-symbols-outlined">deployed_code_update</span>Tasa de retorno</button>
            </div>
        </div>
        <div class="col-span-2 tlg:col-span-1">
            <h5 class="mb-2 text-slate-600">Otros</h5>
            <div class="flex flex-wrap gap-4 mb-4">
                <button class="btn-command"><span class="material-symbols-outlined">person_add</span>Clientes nuevos</button>
                <button class="btn-command"><span class="material-symbols-outlined">person_check</span>Clientes recurrentes</button>
                <button class="btn-command"><span class="material-symbols-outlined">vpn_key_alert</span>Registro de actividad</button>
            </div>
        </div>

    </div>

</div>