<div class="contenido9 configsuscripcion accordion_tab_content p-6 rounded-lg w-full space-y-6">

  <!-- Botón que abre el modal -->
  <div class="flex justify-end gap-4 items-center mb-6">
      
    <button id="btnDetalleSuscriptor" class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium rounded-lg shadow-sm flex items-center justify-center gap-2 px-6 py-4 w-[248px] bg-transparent">
      Información del suscriptor
    </button>
    <button id="btnRegistrarPago" class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium rounded-lg shadow-sm flex items-center justify-center gap-2 px-6 py-4 w-[248px] bg-transparent">
      Registrar pago
    </button>
  </div>


  <!-- Sección Suscripción -->
  <div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-3xl font-bold mb-6">Suscripción</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      <div>
        <p class="text-lg text-gray-700 font-medium">Cuenta</p>
        <p class="text-xl font-semibold"><?php echo $negocio->negocio??''; ?><small> - <?php echo $negocio->nombre??''; ?></small></p>
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
    <button class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium rounded-lg shadow-sm flex items-center justify-center gap-2 px-6 py-4 w-[248px] bg-transparent">
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


  <!-- MODAL DETALLE DE LA SUSCRIPCION -->
  <dialog id="miDialogoDetalleSuscripcion" class="rounded-2xl border border-gray-200 w-[95%] max-w-3xl p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">

      <!-- Encabezado -->
      <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
          <h4 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">Detalles de la Suscripción</h4>
          <button class="p-2 rounded-lg hover:bg-gray-100 transition btnXCerrarRegistroPago">
              <i class="fa-solid fa-xmark text-gray-600 text-3xl"></i>
          </button>
      </div>
      <div id="divmsjalerta1"></div>
      <form id="formDetalleSuscripcion" class="formulario space-y-6">
          <div class="formulario__campo">
              <label class="formulario__label text-lg font-medium text-gray-700" for="estado">Estado</label>
              <select id="estado" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 h-14 text-lg focus:outline-none focus:ring-1" name="estado" required>
                  <option value="1">Activa</option>
                  <option value="0">Suspendida</option>
              </select>
          </div>

          <div class="formulario__campo">
              <label class="formulario__label text-lg font-medium text-gray-700" for="id_plan">Plan</label>
              <select id="id_plan" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 h-14 text-lg focus:outline-none focus:ring-1" name="estado" required>
                  <option value="2">Plan mensual</option>
                  <option value="1">Plan anual</option>
                  <option value="2">Plan diario</option>
              </select>
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="fecha_corte">Fecha de corte</label>
              <input 
                  id="fecha_corte"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="date"  
                  name="fecha_corte" 
              >
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="valor">Valor del plan</label>
              <input 
                  id="valor"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" placeholder="Ingresa el monto" name="valor" value=""
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                  required>
          </div>


          <!-- Botones -->
          <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
              <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px]" value="Cancelar">Cancelar</button>
              <input id="btnEnviarDetalleSuscripcion" type="submit" value="Aplicar" class="btn-md btn-indigo !py-4 !px-6 !w-[135px]">
          </div>
      </form>
  </dialog>


  <!-- MODAL REGISTRAR EL PAGO -->
  <dialog id="miDialogoRegistrarPago" class="rounded-2xl border border-gray-200 w-[95%] max-w-3xl p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">

      <!-- Encabezado -->
      <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
          <h4 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">
              💰 Registrar pago de la suscripcion
          </h4>
          <button class="p-2 rounded-lg hover:bg-gray-100 transition btnXCerrarRegistroPago">
              <i class="fa-solid fa-xmark text-gray-600 text-3xl"></i>
          </button>
      </div>
      <div id="divmsjalerta1"></div>
      <form id="formRegistrarPago" class="formulario space-y-6">

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="valor_pagado">Valor a registrar</label>
              <input 
                  id="valor_pagado"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" placeholder="Ingresa el monto" name="valor_pagado" value=""
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                  required>
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="cantidad_plan">Cantidad del plan pago</label>
              <input 
                  id="cantidad_plan"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" placeholder="Ingresa el monto" name="cantidad_plan" value="1"
                  oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, ''); if(this.value === '' || this.value === '0'){this.value = '';}"
                  required>
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="medio_pago">Medio de pago</label>
              <input 
                  id="medio_pago"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" placeholder="Descripcion del medio de pago" name="medio_pago" value=""
                  required>
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="descuento">Descuento</label>
              <input 
                  id="descuento"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" placeholder="Ingresa monto de descuento" name="descuento" value=""
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
              >
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="detalle_descuento">Detalle descuento</label>
              <input 
                  id="detalle_descuento"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" 
                  placeholder="Descripcion del descuento" 
                  name="detalle_descuento" 
                  value="" 
              >
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="cargo">Cargo</label>
              <input 
                  id="cargo"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" placeholder="Ingresa monto de cargo" name="cargo" value=""
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
              >
          </div>

          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="detalle_cargo">Detalle cargo</label>
              <input 
                  id="detalle_cargo"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                  type="text" 
                  placeholder="Descripcion del cargo" 
                  name="detalle_cargo" 
                  value="" 
              >
          </div>

          <!-- Descripción -->
          <div>
              <label class="formulario__label text-lg font-medium text-gray-700" for="descripcion">Observacion</label>
              <textarea id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-40 text-lg focus:outline-none focus:ring-1" name="descripcion" rows="4"></textarea>
          </div>

          <!-- Botones -->
          <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
              <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px]" value="Cancelar">Cancelar</button>
              <input id="btnEnviarRegistrarPago" type="submit" value="Aplicar" class="btn-md btn-indigo !py-4 !px-6 !w-[135px]">
          </div>
      </form>
  </dialog>
  
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


