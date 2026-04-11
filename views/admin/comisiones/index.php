<div class="box comisiones">
    <h1>Comisiones</h1>

    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6 flex flex-wrap items-end gap-4">
      <div class="flex-1 min-w-[200px]">
          <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Empleado</label>
          <select class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
              <option value="">Seleccionar empleado...</option>
              <option value="1">Juan Pérez (Vendedor)</option>
              <option value="2">María García (Cajera)</option>
          </select>
      </div>

      <div class="flex-1 min-w-[200px]">
          <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Periodo</label>
          <div class="flex items-center gap-2">
              <input type="date" class="p-2 bg-slate-50 border border-slate-300 rounded-lg text-sm w-full">
              <span class="text-slate-400">-</span>
              <input type="date" class="p-2 bg-slate-50 border border-slate-300 rounded-lg text-sm w-full">
          </div>
      </div>

      <button class="bg-indigo-500 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-900 transition-all">
          Consultar
      </button>
    </div>

    <div class="p-6 space-y-6">

  <!-- HEADER -->
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Comisiones</h1>

    <div class="flex gap-2">
      <input type="date" class="border rounded px-3 py-2">
      <input type="date" class="border rounded px-3 py-2">
      <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Filtrar
      </button>
    </div>
  </div>

  <!-- CARDS -->
  <div class="grid grid-cols-3 gap-4">
    
    <div class="bg-white shadow rounded p-4">
      <p class="text-gray-500 text-sm">Total Comisiones</p>
      <h2 class="text-xl font-bold">$1.200.000</h2>
    </div>

    <div class="bg-white shadow rounded p-4">
      <p class="text-gray-500 text-sm">Total Pagado</p>
      <h2 class="text-green-600 text-xl font-bold">$800.000</h2>
    </div>

    <div class="bg-white shadow rounded p-4">
      <p class="text-gray-500 text-sm">Saldo Pendiente</p>
      <h2 class="text-red-600 text-xl font-bold">$400.000</h2>
    </div>

  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-sm font-medium text-slate-500 uppercase">Comisiones Totales</p>
        <p class="text-2xl font-bold text-slate-900">$1,250.00</p>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-sm font-medium text-slate-500 uppercase">Anticipos Entregados</p>
        <p class="text-2xl font-bold text-red-600">-$450.00</p>
    </div>

    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm">
        <p class="text-sm font-medium text-blue-600 uppercase">Saldo a Liquidar</p>
        <p class="text-2xl font-bold text-blue-900">$800.00</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
        <h3 class="font-semibold text-slate-700">Detalle de Movimientos - Juan Pérez</h3>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            Registrar Anticipo / Pago
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Concepto</th>
                    <th class="px-6 py-3 text-right">Crédito (+)</th>
                    <th class="px-6 py-3 text-right">Débito (-)</th>
                    <th class="px-6 py-3">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr>
                    <td class="px-6 py-4">10 Abr 2026</td>
                    <td class="px-6 py-4">
                        <span class="block font-medium text-slate-900">Venta #FAC-1025</span>
                        <span class="text-xs text-slate-400">Cliente: Empresa ABC</span>
                    </td>
                    <td class="px-6 py-4 text-right text-green-600 font-medium">+$45.00</td>
                    <td class="px-6 py-4 text-right">-</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase">Pendiente</span>
                    </td>
                </tr>

                <tr>
                    <td class="px-6 py-4">08 Abr 2026</td>
                    <td class="px-6 py-4">
                        <span class="block font-medium text-slate-900">Anticipo de Quincena</span>
                        <span class="text-xs text-slate-400">Ref: Transf. 9982</span>
                    </td>
                    <td class="px-6 py-4 text-right">-</td>
                    <td class="px-6 py-4 text-right text-red-600 font-medium">-$100.00</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase">Entregado</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <div class="lg:col-span-3 bg-white p-6 rounded-xl border-l-4 border-l-blue-600 border border-slate-200 shadow-sm flex justify-between items-center">
        <div>
            <h4 class="text-sm text-slate-500 font-medium">Saldo por Liquidar</h4>
            <p class="text-3xl font-bold text-slate-900 leading-none mt-1">$1,240.00</p>
            <p class="text-xs text-slate-400 mt-2 italic">* Incluye comisiones del mes menos anticipos.</p>
        </div>
        
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg hover:bg-amber-100 transition-colors font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dar Anticipo
            </button>

            <button class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md shadow-green-100 transition-all font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Liquidar Saldo
            </button>
        </div>
    </div>

    <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Rendimiento</h4>
        <div class="space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-slate-600">Ventas Realizadas:</span>
                <span class="font-bold text-slate-800">24</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-600">Tasa de Comisión:</span>
                <span class="font-bold text-slate-800">5%</span>
            </div>
        </div>
    </div>
</div>
</div>