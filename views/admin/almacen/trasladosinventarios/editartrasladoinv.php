<div class="editartrasladoinv box !pb-16">
    <a href="/admin/almacen/trasladarinventario" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <span class="sr-only">Atrás</span>
    </a>
    <section class="space-y-4 mt-8">
      <div>
        <p id="sedeorigen"></p>
        <p id="sededestino"></p>
        <p id="tipo"></p>
        <p id="estado"></p>
      </div>
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

      <div class="flex justify-end mt-6">
        
        <button id="btnUpdateTrasladoInv" class="px-6 py-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Actualizar</button>
      </div>
    </section>
    
</div>