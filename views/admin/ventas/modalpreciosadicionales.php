<!-- MODAL OTROS PRODUCTOS -->
  <dialog id="miDialogoPreciosAdicioanles" class="midialog-sm p-12">
    <h4 class=" text-gray-700 font-semibold">Precios adicionales:</h4>
    <form id="formPreciosAdicioanles" class="formulario">  
      <div class="border-b border-gray-900/10 pb-10 mb-3">
        
        <p class="mt-2 text-xl text-gray-600">Agregar precio adicional al producto.</p>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

          <div class="sm:col-span-6">
            <label for="aaaaa" class="block text-2xl font-medium text-gray-600">Nombre</label>
            <div class="mt-2">
              <input id="aaaaa" type="text" name="aaaaa" autocomplete="given-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" placeholder="aaaa" required>
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