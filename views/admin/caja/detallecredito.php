<div class="p-6 min-h-screen">
  <div class="max-w-auto mx-auto bg-white shadow-lg rounded-2xl p-8">
    <!-- Título principal -->
     <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-6">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      💳 Detalles del Crédito
    </h2>

    <!-- Información general del crédito -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
      <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-blue-700 mb-1 uppercase">🧾 Factura</h3>
        <p class="text-gray-800 text-lg">FAP1</p>
      </div>

      <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-green-700 mb-1 uppercase">💰 Monto Total</h3>
        <p class="text-gray-800 text-lg">$25.000</p>
      </div>

      <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-yellow-700 mb-1 uppercase">📅 Fecha Emisión</h3>
        <p class="text-gray-800 text-lg">2025-10-05</p>
      </div>
    </div>

    <!-- Detalles financieros -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
      <div class="bg-purple-50 border border-purple-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-purple-700 mb-1 uppercase">🔢 Plazo</h3>
        <p class="text-gray-800 text-lg">30 días</p>
      </div>

      <div class="bg-orange-50 border border-orange-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-orange-700 mb-1 uppercase">📆 Fecha Vencimiento</h3>
        <p class="text-gray-800 text-lg">2025-11-04</p>
      </div>

      <div class="bg-red-50 border border-red-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-red-700 mb-1 uppercase">💸 Abono Inicial</h3>
        <p class="text-gray-800 text-lg">$5.000</p>
      </div>
    </div>

    <!-- Estado actual -->
    <div class="bg-gray-100 border border-gray-300 rounded-xl p-5 mb-8">
      <h3 class="text-xl font-semibold text-gray-700 mb-3 uppercase">📊 Estado del Crédito</h3>
      <div class="flex items-center gap-4">
        <span class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-700">
          En curso
        </span>
        <span class="text-gray-600">Saldo pendiente: <strong>$20.000</strong></span>
      </div>
    </div>

    <!-- Historial de abonos -->
    <div class="mb-10">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">📚 Historial de Abonos</h3>
      <table class="w-full border border-gray-200 rounded-xl overflow-hidden">
        <thead class="bg-gray-100">
          <tr>
            <th class="text-left px-4 py-2 text-sm font-semibold text-gray-700">Fecha</th>
            <th class="text-left px-4 py-2 text-sm font-semibold text-gray-700">Monto</th>
            <th class="text-left px-4 py-2 text-sm font-semibold text-gray-700">Método</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-t">
            <td class="px-4 py-2 text-gray-800">2025-10-05</td>
            <td class="px-4 py-2 text-gray-800">$5.000</td>
            <td class="px-4 py-2 text-gray-800">Efectivo</td>
          </tr>
          <tr class="border-t">
            <td class="px-4 py-2 text-gray-800">2025-10-10</td>
            <td class="px-4 py-2 text-gray-800">$10.000</td>
            <td class="px-4 py-2 text-gray-800">Nequi</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Botones de acción -->
    <div class="flex justify-end gap-4">
      <button class="btn-md btn-blueintense mb-4 !py-4 px-6 !bg-indigo-600">
        ➕ Abonar
      </button>
      <button class="hover:bg-green-700 btn-turquoise text-white font-semibold  rounded-lg shadow flex items-center gap-2 mb-4 py-4 px-6">
        ✅ Pagar Todo
      </button>
      <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold  rounded-lg shadow flex items-center gap-2 mb-4 py-4 px-6">
        ⬅️ Volver
      </button>
    </div>
  </div>
</div>
