<div class="contenido9 accordion_tab_content p-6 rounded-lg w-full space-y-6">

<!-- Botón que abre el modal -->
 <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800 "></h2>
   <button onclick="document.getElementById('modal-suscripcion').classList.remove('hidden')" 
           class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium rounded-lg shadow-sm flex items-center justify-center gap-2 px-6 py-4 w-[248px] bg-transparent">
     Información del suscriptor
   </button>
 </div>

<!-- Modal de suscripción -->
<div id="modal-suscripcion" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 !mt-0 px-4">
  <div class="bg-white  rounded-2xl shadow-lg w-full max-w-md md:max-w-2xl p-4 md:p-8 max-h-[90vh] overflow-y-auto">
    
    <h3 class="text-2xl font-semibold text-gray-800  mb-6">Detalles de la Suscripción</h3>
    
    <div class="grid grid-cols-1 gap-6">
      <div>
        <label class="block text-xl font-medium text-gray-700  mb-1">Estado</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
          <option>Activa</option>
          <option>Inactiva</option>
          <option>Suspendida</option>
        </select>
      </div>

      <div>
        <label class="block text-xl font-medium text-gray-700  mb-1">Monto</label>
        <input type="number" placeholder="Ingresar monto de suscripción"
               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-lg focus:outline-none focus:ring-1">
      </div>

      <div>
        <label class="block text-xl font-medium text-gray-700  mb-1">Día de pago</label>
        <input type="number" placeholder="Ingresar día de pago" min="1" max="31"
               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-lg focus:outline-none focus:ring-1">
      </div>

      <div>
        <label class="block text-xl font-medium text-gray-700  mb-1">Mes siguiente</label>
        <input type="text" placeholder="Ingresar mes de suscripción"
               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-lg focus:outline-none focus:ring-1">
      </div>

      <div>
        <label class="block text-xl font-medium text-gray-700  mb-1">Año</label>
        <input type="number" placeholder="Ingresar año de suscripción"
               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-lg focus:outline-none focus:ring-1">
      </div>

      <div>
        <label class="block text-xl font-medium text-gray-700  mb-1">Suscripción automática</label>
        <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
          <option>Sí</option>
          <option>No</option>
        </select>
      </div>
    </div>

    <div class="flex justify-end gap-4 mt-8">
      <button onclick="document.getElementById('modal-suscripcion').classList.add('hidden')" 
              class="px-8 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-xl uppercase">
        Cancelar
      </button>
      <button class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-xl uppercase">
        Guardar
      </button>
    </div>

  </div>
</div>

  <!-- Sección Suscripción -->
  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-3xl font-bold mb-6">Suscripción</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      <div>
        <p class="text-lg text-gray-700 font-medium">Cuenta</p>
        <p class="text-xl font-semibold">MegaTecho SAS</p>
      </div>

      <div>
        <p class="text-lg text-gray-700 font-medium">Estado</p>
        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-base font-medium">Activo</span>
      </div>

      <div>
        <p class="text-lg text-gray-700 font-medium">Fecha de inicio</p>
        <p class="text-xl font-semibold">01/09/2025</p>
      </div>

      <div>
        <p class="text-lg text-gray-700 font-medium">Próximo pago</p>
        <p class="text-xl font-semibold">01/10/2025</p>
      </div>

      <div>
        <p class="text-lg text-gray-700 font-medium">Monto mensual</p>
        <p class="text-xl font-semibold">$100.000</p>
      </div>

      <div>
        <p class="text-lg text-gray-700 font-medium">Días restantes</p>
        <p class="text-xl font-semibold text-indigo-600">12 días</p>
      </div>
    </div>
  </div>

<div class="flex justify-between items-center mb-4">
  <h2 class="text-lg font-semibold text-gray-800"></h2>
  <button 
    class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium rounded-lg shadow-sm flex items-center justify-center gap-2 px-6 py-4 w-[248px] bg-transparent"
    onclick="document.getElementById('modal-ajustes').classList.remove('hidden')">
    Aplicar Descuento/Cargo
  </button>
</div>

  <!-- Sección Resumen -->
  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-3xl font-bold mb-4">Resumen de cobros</h2>
    <div class="space-y-2 text-lg">
      <div class="flex justify-between">
        <span class="font-medium text-gray-700">Valor base</span><span class="text-gray-800">$100.000</span>
      </div>
      <div class="flex justify-between">
        <span class="font-medium text-green-600">Descuento aplicado</span><span class="text-green-600">- $10.000</span>
      </div>
      <div class="flex justify-between">
        <span class="font-medium text-red-600">Cargo adicional</span><span class="text-red-600">+ $5.000</span>
      </div>
    </div>

    <div class="flex justify-between items-center border-t pt-4 mt-4">
      <span class="text-xl font-bold">Total a pagar</span>
      <span class="text-xl font-bold text-indigo-700">$95.000</span>
    </div>

    <div class="mt-6 flex gap-3">
      <!-- Botón principal: Renovar Suscripción -->
      <!--<button class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow flex items-center justify-center gap-2 px-6 py-4 w-[248px]">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 flex-none"
            viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 8v4l3 3m6-7a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="leading-none">Renovar Suscripción</span>
      </button> -->
    </div>
  </div>

  <!-- Sección Historial -->
  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-3xl font-bold mb-4">Historial de pagos</h2>
    <table class="w-full text-left border-collapse">
      <thead>
        <tr class="text-gray-700 text-lg font-medium border-b">
          <th class="pb-2">Fecha</th>
          <th class="pb-2">Monto</th>
          <th class="pb-2">Método</th>
        </tr>
      </thead>
      <tbody class="text-base">
        <tr class="border-b">
          <td class="py-2">01/09/2025</td>
          <td class="py-2 font-semibold">$100.000</td>
          <td class="py-2">Tarjeta</td>
        </tr>
        <tr>
          <td class="py-2">01/08/2025</td>
          <td class="py-2 font-semibold">$100.000</td>
          <td class="py-2">Transferencia</td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <!-- //------------Información del botón descuento/cargos--------------// -->
  <!-- Modal Ajustes -->
  <div id="modal-ajustes" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 !mt-0 px-4">
    <div class="bg-white  rounded-2xl shadow-lg w-full max-w-md md:max-w-2xl p-4 md:p-8 max-h-[90vh] overflow-y-auto">
      <!-- Título -->
      <h3 class="text-2xl font-semibold text-gray-800  mb-6">Aplicar Ajustes</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tipo de ajuste -->
        <div>
          <label class="block text-xl font-medium text-gray-700 ">Tipo de ajuste</label>
          <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1">
            <option value="descuento">Descuento</option>
            <option value="cargo">Cargo</option>
          </select>
        </div>
  
        <!-- Monto -->
        <div>
          <label class="block text-xl font-medium text-gray-700 ">Monto</label>
          <input type="number" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1">
        </div>
      </div>
  
      <!-- Detalle -->
      <div class="mt-6">
        <label class="block text-xl font-medium text-gray-700 ">Detalle</label>
        <textarea rows="3" 
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-32 text-xl focus:outline-none focus:ring-1"></textarea>
      </div>
  
      <!-- Acciones -->
      <div class="flex justify-end gap-4 mt-8">
        <!-- Botón cancelar que cierra el modal -->
        <button onclick="document.getElementById('modal-ajustes').classList.add('hidden')" 
                class="px-8 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg    text-xl uppercase">
          Cancelar
        </button>
        <button class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-xl uppercase">
          Guardar
        </button>
      </div>
    </div>
  </div>
</div>


