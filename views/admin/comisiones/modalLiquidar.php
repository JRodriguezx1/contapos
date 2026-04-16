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
            <label class="formulario__label" for="tipo">Concepto</label>
            <select id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-indigo-600 block p-3 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="pago">Pago</option>
                <option value="anticipo">Anticipo</option>
            </select>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="valorLiquidar">Valor a liquidar</label>
            <input 
                id="valorLiquidar" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                type="text"
                placeholder="Introducir valor a liquidar, parcial o total" 
                value=""
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                required
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="mediopago">Medio de pago</label>
            <input 
                id="mediopago" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                type="text"
                placeholder="descripcion del medio de pago" 
                required
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="observacion">Observacion</label>
            <input 
                id="observacion" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                type="text"
                placeholder="Observaciones del pago" 
            >
        </div>

        <label for="printComprobante" class="flex flex-col items-center cursor-pointer">
            <span class="text-gray-600 mb-4 text-xl">Imprimir comprobante?</span>
            <input 
                id="printComprobante" 
                name="printComprobante" 
                value="1" 
                type="checkbox" 
                class="sr-only peer"
                <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?>
                >
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
            </div>
        </label>

        <div class="text-right border-t border-gray-200 pt-12 mt-8">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearLiquidar" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal Liquidar-->