<!-- tabla balance general -->
    <!--
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur rounded-2xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition">
            <p class="text-sm text-gray-500">Ventas</p>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">$10.000.000</h2>
        </div>

        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur rounded-2xl p-5 shadow-sm border hover:shadow-md transition">
            <p class="text-sm text-gray-500">Utilidad</p>
            <h2 class="text-2xl font-bold text-green-600 mt-1">$2.500.000</h2>
        </div>

        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur rounded-2xl p-5 shadow-sm border hover:shadow-md transition">
            <p class="text-sm text-gray-500">Caja</p>
            <h2 class="text-2xl font-bold text-blue-600 mt-1">$6.500.000</h2>
        </div>

        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur rounded-2xl p-5 shadow-sm border hover:shadow-md transition">
            <p class="text-sm text-gray-500">Cartera</p>
            <h2 class="text-2xl font-bold text-yellow-500 mt-1">$2.000.000</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow border">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">
                Resumen Financiero
            </h3>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span>Ventas</span>
                    <span>$10.000.000</span>
                </div>

                <div class="flex justify-between">
                    <span>Costos</span>
                    <span>$6.000.000</span>
                </div>

                <div class="flex justify-between font-semibold border-t pt-2">
                    <span>Utilidad Bruta</span>
                    <span>$4.000.000</span>
                </div>

                <div class="flex justify-between">
                    <span>Gastos</span>
                    <span>$1.500.000</span>
                </div>

                <div class="flex justify-between font-bold text-green-600 text-base border-t pt-2">
                    <span>Utilidad Operativa</span>
                    <span>$2.500.000</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Créditos</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="opacity-80">Capital colocado</p>
                    <h4 class="text-xl font-bold">$3.000.000</h4>
                </div>

                <div>
                    <p class="opacity-80">Pendiente</p>
                    <h4 class="text-xl font-bold">$2.000.000</h4>
                </div>

                <div>
                    <p class="opacity-80">Abonos</p>
                    <h4 class="text-xl font-bold">$1.000.000</h4>
                </div>

                <div>
                    <p class="opacity-80">Intereses</p>
                    <h4 class="text-xl font-bold">$800.000</h4>
                </div>
            </div>
        </div>

    </div>-->
      
<!-- segundo diseño -->

<div class="mt-8 pb-12 border-b">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="group relative bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:border-indigo-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-base font-medium text-gray-500">Ingreso total</p>
            <h2 id="IngresoTotalCard" class="text-2xl font-semibold text-gray-900 mt-1 tracking-tight">$0</h2>
        </div>

        <div class="group bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:border-emerald-500/50 transition-all">
            <div class="flex items-center justify-between mb-4 text-emerald-600">
                <div class="p-2 bg-emerald-50 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <p class="text-base font-medium text-gray-500">Utilidad</p>
            <h2 id="utilidadCard" class="text-2xl font-semibold text-emerald-600 mt-1 tracking-tight">$0</h2>
        </div>

        <div class="group bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:border-blue-500/50 transition-all">
            <div class="flex items-center justify-between mb-4 text-blue-600">
                <div class="p-2 bg-blue-50 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
            </div>
            <p class="text-base font-medium text-gray-500">Abonos</p>
            <h2 id="totalAbonosCard" class="text-2xl font-semibold text-blue-600 mt-1 tracking-tight">$0</h2>
        </div>

        <div class="group bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:border-amber-500/50 transition-all">
            <div class="flex items-center justify-between mb-4 text-amber-600">
                <div class="p-2 bg-amber-50 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                    </svg>
                </div>
            </div>
            <p class="text-base font-medium text-gray-500">Cartera Pendiente</p>
            <h2 id="carteraPendienteCard" class="text-2xl font-semibold text-amber-500 mt-1 tracking-tight">$0</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mt-8 mb-8">
  
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Resumen Financiero</h3>
                <button class="text-indigo-600 text-sm font-semibold hover:underline">Ver reporte</button>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 rounded-2xl hover:bg-gray-50 transition">
                    <span class="text-gray-600 font-medium">Ventas Brutas</span>
                    <span id="ventaBrutaRF" class="font-semibold text-gray-900">$0</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-2xl hover:bg-gray-50 transition">
                    <span class="text-gray-600 font-medium">Descuentos</span>
                    <span id="descuentosRF" class="font-semibold text-gray-900">-$0</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                    <span class="font-bold text-gray-700">Venta Neta</span>
                    <span id="ventaNetaRF" class="text-xl font-extrabold text-gray-900">$0</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-2xl hover:bg-gray-50 transition">
                    <span class="text-indigo-600 font-medium">Abonos</span>
                    <span id="totalAbonosRF" class="font-semibold text-gray-900">$0</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                    <span class="font-bold text-gray-700">Ingreso Total</span>
                    <span id="ingresoTotalRF" class="text-xl font-extrabold text-gray-900">$0</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-2xl hover:bg-gray-50 transition">
                    <span class="font-medium text-red-500">Egresos</span>
                    <span id="egresosRF" class="font-semibold text-gray-900">-$0</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-2xl hover:bg-gray-50 transition">
                    <span class="text-gray-600 font-medium">Margen de utilidad</span>
                    <span id="margenUtilidadRF" class="font-semibold text-gray-900">0%</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl">
                    <span class="font-bold text-emerald-700">Utilidad</span>
                    <span id="utilidadRF" class="text-xl font-bold text-emerald-600">$0</span>
                </div>
            </div>
        </div>

        <!--<div class="relative overflow-hidden bg-slate-900 rounded-3xl p-8 shadow-xl">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>
    
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-white mb-8 flex items-center gap-2">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                    Estado de Créditos
                </h3>

                <div class="grid grid-cols-2 gap-8">
                    <div class="space-y-1 border-l-2 border-indigo-500/30 pl-4">
                        <p class="text-xs uppercase tracking-wider text-indigo-300 font-semibold">Capital Colocado</p>
                        <h4 class="text-3xl font-black text-white italic">$3.000.000</h4>
                    </div>

                    <div class="space-y-1 border-l-2 border-rose-500/30 pl-4">
                        <p class="text-xs uppercase tracking-wider text-rose-300 font-semibold">Saldo Pendiente</p>
                        <h4 class="text-3xl font-black text-white italic">$2.000.000</h4>
                    </div>

                    <div class="space-y-1 border-l-2 border-emerald-500/30 pl-4">
                        <p class="text-xs uppercase tracking-wider text-emerald-300 font-semibold">Abonos Recibidos</p>
                        <h4 class="text-3xl font-black text-white italic">$1.000.000</h4>
                    </div>

                    <div class="space-y-1 border-l-2 border-sky-500/30 pl-4">
                        <p class="text-xs uppercase tracking-wider text-sky-300 font-semibold">Intereses Generados</p>
                        <h4 class="text-3xl font-black text-white italic">$800.000</h4>
                    </div>
                </div>
    
                <div class="mt-10">
                    <button class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-indigo-500/20">
                    Gestionar Cartera
                    </button>
                </div>
            </div>
        </div>-->

    </div>
</div>