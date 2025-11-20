<!-- MODAL OTROS PRODUCTOS -->
  <dialog id="miDialogoOtrosProductos" class="midialog-sm p-12">
    <h4 class=" text-gray-700 font-semibold">Otros:</h4>
    <form id="formOtrosProductos" class="formulario">  
      <div class="border-b border-gray-900/10 pb-10 mb-3">
        
        <p class="mt-2 text-xl text-gray-600">Agregar producto/servicio personalizado.</p>

        <div class="mt-6 grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-6">

          <div class="sm:col-span-6">
            <label for="nombreotros" class="block text-2xl font-medium text-gray-600">Nombre</label>
            <div class="mt-2">
              <input id="nombreotros" type="text" name="nombreotros" autocomplete="given-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" placeholder="Nombre del producto/servicio" required>
            </div> 
          </div>

          <div class="sm:col-span-6 md:col-span-3">
            <label class="block text-2xl font-medium text-gray-600" for="impuesto">Impuesto</label>
                <select
                id="impuesto"
                name="porcentaje_de_impuesto"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1"
                >
                    <span class="text-indigo-600 font-bold">
                        <optgroup label="IVA">
                    </span>
                    <option value="0" >Exento – 0%</option>
                    <option value="5" >Bienes / Servicios al 5%</option>
                    <option value="16" >Contratos antes Ley 1819 – 16%</option>
                    <option value="19" >Tarifa general – 19%</option>
                    <option value="" >Excluido de IVA</option> <!-- valor por defecto -->
                    </optgroup>
                    <span class="text-indigo-600 font-bold">
                        <optgroup class="text-indigo-60" label="INC">
                    </span>
                    <option value="8">Impuesto Nacional al Consumo – 8%</option>
                    </optgroup>
                </select>
          </div>

          <div class="sm:col-span-3">
            <div class="flex gap-4">
              <div class=" w-5/12">
                <label for="cantidadotros" class="block text-2xl font-medium text-gray-600">Cantidad</label>
                <input id="cantidadotros" type="number" name="cantidadotros" min="1" step="0.01"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
                  placeholder="" required>
              </div>

              <div class=" w-7/12">
                <label for="preciootros" class="block text-2xl font-medium text-gray-600">Precio total</label>
                <input id="preciootros" type="number" name="preciootros" min="0"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
                  placeholder="Valor" required>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="text-right">
          <button class="btn-md btn-turquoise !py-4 !px-6 !w-[125px]" type="button" value="Cancelar">Cancelar</button>
          <input class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[125px]" type="submit" value="Agregar">
      </div>
    </form>
  </dialog>