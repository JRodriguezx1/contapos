<div class="space-y-8">
    <!-- Información del cliente -->
    <div class="bg-white rounded-2xl p-8 shadow-md">
            <a href="/admin/clientes" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2    mb-6">
            <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
            <span class="sr-only">Atrás</span>
        </a>
        <!-- Título -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A11.955 11.955 0 0112 15c2.485 0 4.77.755 6.879 2.045M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Perfil del Cliente
        </h2>

        <!-- Grid con datos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">
            <!-- Columna izquierda -->
            <div class="space-y-5">
            <p class="flex items-center gap-3">
                <span class="font-semibold text-base text-gray-500">Nombre:</span>
                <span class="text-2xl font-bold text-gray-900">Juan Pérez</span>
            </p>
            <p class="flex items-center gap-3">
                <span class="font-semibold text-base text-gray-500">Correo:</span>
                <span class="text-lg font-medium text-indigo-600 underline">juanperez@email.com</span>
            </p>
            <p class="flex items-center gap-3">
                <span class="font-semibold text-base text-gray-500">Teléfono:</span>
                <span class="text-lg font-medium text-gray-900">+57 300 123 4567</span>
            </p>
            </div>

            <!-- Columna derecha -->
            <div class="space-y-5">
            <p class="flex items-center gap-3">
                <span class="font-semibold text-base text-gray-500">Última compra:</span>
                <span class="text-lg font-medium text-gray-900">20/09/2025</span>
            </p>
            <p class="flex items-center gap-3">
                <span class="font-semibold text-base text-gray-500">Cliente desde:</span>
                <span class="text-lg font-medium text-gray-900">15/03/2023</span>
            </p>
            <p class="flex items-center gap-3">
                <span class="font-semibold text-base text-gray-500">Estado:</span>
                <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700 font-semibold">
                Activo
                </span>
            </p>
            </div>
        </div>
    </div>

    <!-- Indicadores -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-5 shadow text-center border-b-4 border-green-600">
            <p class="text-base text-gray-500">🛒 Total de compras</p>
            <p class="text-3xl lg:text-5xl font-bold">35</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow text-center border-b-4 border-indigo-600">
            <p class="text-base text-gray-500">💰 Monto total gastado</p>
            <p class="text-3xl lg:text-5xl font-bold">$ 12.500.000</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow text-center border-b-4 border-yellow-600">
            <p class="text-base text-gray-500">📊 Ticket promedio</p>
            <p class="text-3xl lg:text-5xl font-bold">$ 357.000</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow text-center border-b-4 border-red-600">
            <p class="text-base text-gray-500">⏳ Frecuencia (días)</p>
            <p class="text-3xl lg:text-5xl font-bold">15</p>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ventas por meses -->
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold">Compras por Mes</h3>
            </div>
            <div class="card-canvas">
                <canvas id="chartComprasMes"></canvas>
            </div>
            </div>

            <!-- Categorías más compradas -->
            <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold">Categorías más compradas</h3>
            </div>
            <div class="card-canvas">
                <canvas id="chartCategorias"></canvas>
            </div>
        </div>
    </div>

    <!-- Historial de compras -->
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="text-2xl font-bold mb-4">Historial de Compras</h2>
        <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
            <th class="p-3">Fecha</th>
            <th class="p-3">Producto</th>
            <th class="p-3">Monto</th>
            <th class="p-3">Método de pago</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
            <td class="p-3">20/09/2025</td>
            <td class="p-3">Corte de cabello</td>
            <td class="p-3">$ 50.000</td>
            <td class="p-3">Efectivo</td>
            </tr>
            <tr class="border-b">
            <td class="p-3">15/09/2025</td>
            <td class="p-3">Tratamiento capilar</td>
            <td class="p-3">$ 120.000</td>
            <td class="p-3">Tarjeta</td>
            </tr>
            <tr>
            <td class="p-3">10/09/2025</td>
            <td class="p-3">Afeitado</td>
            <td class="p-3">$ 35.000</td>
            <td class="p-3">Nequi</td>
            </tr>
        </tbody>
        </table>
    </div>
</div>

<!-- Scripts de gráficas -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Compras por mes
  const ctxMes = document.getElementById("chartComprasMes");
  if (ctxMes) {
    new Chart(ctxMes, {
      type: "line",
      data: {
        labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep"],
        datasets: [{
          label: "Compras",
          data: [2, 4, 5, 6, 4, 7, 3, 8, 5],
          borderColor: "rgba(99, 102, 241, 1)",
          backgroundColor: "rgba(99, 102, 241, 0.2)",
          tension: 0.4,
          fill: true,
        }]
      },
      options: { responsive: true }
    });
  }

  // Categorías más compradas
  const ctxCat = document.getElementById("chartCategorias");
  if (ctxCat) {
    new Chart(ctxCat, {
      type: "doughnut",
      data: {
        labels: ["Corte", "Tratamiento", "Color", "Otros"],
        datasets: [{
          data: [12, 8, 5, 3],
          backgroundColor: [
            "rgba(99, 102, 241, 0.8)",   // Indigo
            "rgba(16, 185, 129, 0.8)",   // Emerald
            "rgba(249, 115, 22, 0.8)",   // Orange
            "rgba(107, 114, 128, 0.8)"   // Gray
          ],
        }]
      },
      options: { responsive: true }
    });
  }
});
</script>
