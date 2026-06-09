<!-- MODAL OTROS PRODUCTOS -->
  <dialog id="miDialogoOtrosProductos" class="midialog-md p-12">
    <div class="text-center border-b border-slate-200 pb-6 mb-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-100 mb-4">
            <i class="fa-solid fa-box-open text-indigo-600 text-3xl"></i>
        </div>

        <h4 class="text-3xl font-bold text-indigo-700">
            Producto personalizado
        </h4>

        <p class="mt-2 text-lg text-slate-500">
            Agregue un producto o servicio que no exista en el catálogo.
        </p>
    </div>

    <form id="formOtrosProductos" class="formulario">  
      <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-6 mt-4">
        <div class="mt-6 grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-6">

          <div class="sm:col-span-6">
            <label for="nombreotros" class="block text-lg font-semibold text-slate-700">Nombre</label>
            <div class="mt-2">
              <input id="nombreotros" type="text" name="nombreotros" autocomplete="given-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" placeholder="Ej. Servicio técnico, Transporte, Instalación..." required>
            </div> 
          </div>

          <div class="sm:col-span-6 md:col-span-3">
            <label class="block text-lg font-semibold text-slate-700" for="impuesto">Impuesto</label>
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
            <div class="flex gap-5">
              <div class=" w-5/12">
                <label for="cantidadotros" class="block text-lg font-semibold text-slate-700">Cantidad</label>
                <input id="cantidadotros" type="number" name="cantidadotros" min="1" step="0.01"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
                  placeholder="" required>
              </div>

              <div class=" w-7/12">
                <label for="preciootros" class="block text-lg font-semibold text-slate-700">Precio total</label>
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