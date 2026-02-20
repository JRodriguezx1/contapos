<div class="contenido8 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6">
    <div class="flex flex-wrap gap-10">
        <p class="text-indigo-600 font-bold">Sistema</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <!-- convertir_a_pos_factura_no_impresa -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Convertir a POS factura no impresa</label>
            <label for="convertir_a_pos_factura_no_impresa_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1    ">
                <input id="convertir_a_pos_factura_no_impresa_si" type="radio" name="convertir_a_pos_factura_no_impresa" class="hidden peer" value="1" <?php //echo $conflocal['convertir_a_pos_factura_no_impresa']->valor_final == 1?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="convertir_a_pos_factura_no_impresa_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1    ">
                <input id="convertir_a_pos_factura_no_impresa_no" type="radio" name="convertir_a_pos_factura_no_impresa" class="hidden peer" value="0" <?php //echo $conflocal['convertir_a_pos_factura_no_impresa']->valor_final == 0?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>

        <!-- activar modo venta rapido -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Activar el modo rapido de ventas</label>
            <label for="Activar_el_modo_rapido_de_ventas_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1    ">
                <input id="Activar_el_modo_rapido_de_ventas_si" type="radio" name="convertir_a_pos_factura_no_impresa" class="hidden peer" value="1" <?php //echo $conflocal['convertir_a_pos_factura_no_impresa']->valor_final == 1?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="Activar_el_modo_rapido_de_ventas_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1    ">
                <input id="Activar_el_modo_rapido_de_ventas_no" type="radio" name="convertir_a_pos_factura_no_impresa" class="hidden peer" value="0" <?php //echo $conflocal['convertir_a_pos_factura_no_impresa']->valor_final == 0?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
    </div>
    
</div> <!-- fin Sistema -->