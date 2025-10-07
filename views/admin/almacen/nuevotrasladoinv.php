<div class="nuevotrasladoinv box !pb-16">
  <!-- Botón atrás -->
  <a href="/admin/almacen/trasladarinventario" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>

  <div class="p-6 dark:bg-neutral-900 rounded-2xl">
    <!-- Barra de progreso -->
    <div class="flex items-center justify-between mb-6">
      <div class="flex items-center gap-2">
        <div class="step-circle w-10 h-10 rounded-full bg-indigo-600 text-white font-semibold flex items-center justify-center">1</div>
        <span class="text-sm font-medium text-gray-700">Datos</span>
      </div>
      <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-2">
        <div class="step-circle w-10 h-10 rounded-full border-2 border-gray-300 text-gray-400 font-semibold flex items-center justify-center">2</div>
        <span class="text-sm font-medium text-gray-500">Productos</span>
      </div>
      <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-2">
        <div class="step-circle w-10 h-10 rounded-full border-2 border-gray-300 text-gray-400 font-semibold flex items-center justify-center">3</div>
        <span class="text-sm font-medium text-gray-500">Resumen</span>
      </div>
    </div>

    <!-- Paso 1 -->
    <h4 class="text-gray-600 mb-5 mt-6">Traslado de Inventario</h4>
    <p class="text-gray-600 mb-5 mt-5">Registra el envío de productos hacia otra sede</p>
    <section class="space-y-4 step-section step-1">
      <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 pt-6">Datos del traslado</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6">
        <div>
          <label class="block text-lg font-medium mb-1 text-gray-600 dark:text-gray-300">Sede Origen</label>
          <select id="sucursalorigen" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
              <option value="<?php echo $sucursalorigen->id;?>"><?php echo $sucursalorigen->nombre;?></option>
          </select>
        </div>
        <div>
          <label class="block text-lg font-medium mb-1 text-gray-600 dark:text-gray-300">Sede Destino</label>
          <select id="sucursaldestino" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
              <?php foreach($sucursales as $value): 
                  if($value->id != id_sucursal()): ?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->nombre; ?></option>
              <?php endif; endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-lg font-medium mb-1 text-gray-600 dark:text-gray-300">Fecha de Envío</label>
          <input id="fecha" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" />
        </div>
        <div>
          <label class="block text-lg font-medium mb-1 text-gray-600 dark:text-gray-300">Observaciones</label>
          <textarea rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-32 text-xl focus:outline-none focus:ring-1" placeholder="Ejemplo: envío de reposición de stock..."></textarea>
        </div>
      </div>
    </section>

    <!-- Paso 2 -->
    <section class="space-y-4 mt-8 step-section step-2 hidden">
      <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 pt-6">Productos a enviar</h2>
      <div class="flex flex-col md:flex-row gap-2">
        <select id="articulo" name="" class="w-full" multiple="multiple">
          <?php foreach($totalitems as $value): ?>
            <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
          <?php endforeach; ?>  
        </select>
        <input
            id="cantidad"
            type="text" 
            class="w-full md:w-1/4 focus:border-indigo-600 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 border rounded-lg p-2.5 bg-gray-50 border-gray-300 text-gray-900"
            placeholder="Cant."
            value="1"
            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';"
        />
        <input id="unidadmedida" type="text" class="w-full md:w-1/4 focus:border-indigo-600 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 border rounded-lg p-2.5 bg-gray-50 border-gray-300 text-gray-900" value="" readonly>
        <button id="btnAddItem" class="px-4 h-14 py-2 w-full md:w-1/4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Agregar</button>
      </div>

      <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
        <table id="tablaItems" class="w-full text-left border-collapse">
          <thead class="bg-gray-50 text-gray-600 text-base font-semibold uppercase tracking-wide">
            <tr>
              <th class="text-left p-4">Producto</th>
              <th class="text-left p-4">Cantidad</th>
              <th class="text-center p-4">Acciones</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
    </section>

    <!-- Paso 3 -->
    <section class="space-y-4 mt-8 step-section step-3 hidden">
      <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Resumen del traslado</h2>
      <div class="border rounded-lg p-4 dark:border-neutral-700 dark:bg-neutral-800">
        <!--<p class="text-gray-700 dark:text-gray-300">Aquí se mostrará el resumen final del traslado antes de enviarlo.</p>-->
        <table id="tablaproductosresumen" class="tabla2" width="100%" id="tablaMediosPago">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>UND</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
      </div>
    </section>

    <!-- Navegación -->
    <div class="flex justify-between mt-6">
      <button id="btnAnteriorTrasladoInv" class="px-6 py-4 border rounded-lg hover:bg-gray-100 dark:border-neutral-700 dark:hover:bg-neutral-800">Anterior</button>
      <button id="btnSiguienteTrasladoInv" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Siguiente</button>
    </div>
  </div>
</div>


