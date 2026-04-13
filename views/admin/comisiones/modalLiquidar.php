<!-- MODAL PARA ABONAR-->
  <dialog id="miDialogoLiquidar" class="midialog-sm p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalLiquidar" class="font-semibold text-gray-700 mb-4">Liquidar comisiones</h4>
        <button class="rounded-lg hover:bg-gray-100 transition">
            <i id="btnXCerrarModalLiquidar" class="p-2 fa-solid fa-xmark text-gray-600 text-3xl"></i>
        </button>
    </div>
    <div id="divmsjalertaLiquidar"></div>
    <form id="formCrearUpdateLiquidar" class="formulario" method="POST">
        
        <div class="formulario__campo">
            <label class="formulario__label" for="liquidar">Usuario</label>
            <select id="liquidar" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" required>
                
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="percentComision">% Porcentaje de comision</label>
            <input id="percentComision" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" value="" required>
        </div>

        <div class="text-right border-t border-gray-200 pt-12 mt-8">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearLiquidar" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal Liquidar-->