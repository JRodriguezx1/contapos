<div class="contenido6 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6">
    <div class="flex flex-wrap gap-10">
        <p class="text-indigo-600 font-bold">Impuesto</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Porcentaje de impuesto -->
        <div>
            <label for="porcentaje_de_impuesto" class="block text-xl font-medium text-gray-700 mb-1">
                Tarifa del impuesto
            </label>
            <span class="block mb-1 text-sm text-gray-500">
                Seleccione el impuesto y tarifa correspondiente al negocio
            </span>
            <select
                id="porcentaje_de_impuesto"
                name="porcentaje_de_impuesto"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
            >
                <span class="text-indigo-600 font-bold">
                    <optgroup label="IVA">
                </span>
                <option value="0" <?php echo $conflocal['porcentaje_de_impuesto']->valor_final == 0?'selected':'';?> >Exento – 0%</option>
                <option value="5" <?php echo $conflocal['porcentaje_de_impuesto']->valor_final == 5?'selected':'';?> >Bienes / Servicios al 5%</option>
                <option value="16" <?php echo $conflocal['porcentaje_de_impuesto']->valor_final == 16?'selected':'';?> >Contratos antes Ley 1819 – 16%</option>
                <option value="19" <?php echo $conflocal['porcentaje_de_impuesto']->valor_final == 19?'selected':'';?> >Tarifa general – 19%</option>
                <option value="" <?php echo $conflocal['porcentaje_de_impuesto']->valor_final == null?'selected':'';?> >Excluido de IVA</option> <!-- valor por defecto -->
                </optgroup>
                <span class="text-indigo-600 font-bold">
                    <optgroup class="text-indigo-60" label="INC">
                </span>
                <option value="8" <?php echo $conflocal['porcentaje_de_impuesto']->valor_final == 8?'selected':'';?>>Impuesto Nacional al Consumo – 8%</option>
                </optgroup>
            </select>
        </div>
        <!-- Mostrar impuesto en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar impuesto en factura</label>
            <label for="impuesto_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="impuesto_factura_si" type="radio" name="mostrar_impuesto_en_factura" class="hidden peer" value="1" <?php echo $conflocal['mostrar_impuesto_en_factura']->valor_final == 1?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="impuesto_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="impuesto_factura_no" type="radio" name="mostrar_impuesto_en_factura" class="hidden peer" value="0" <?php echo $conflocal['mostrar_impuesto_en_factura']->valor_final == 0?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Discriminar impuesto por producto -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Discriminar impuesto por producto</label>
            <label for="discriminar_imp_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="discriminar_imp_si" type="radio" name="discriminar_impuesto_por_producto" class="hidden peer" value="1" <?php echo $conflocal['discriminar_impuesto_por_producto']->valor_final == 1?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="discriminar_imp_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="discriminar_imp_no" type="radio" name="discriminar_impuesto_por_producto" class="hidden peer" value="0" <?php echo $conflocal['discriminar_impuesto_por_producto']->valor_final == 0?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Mostrar subtotales en factura sin impuesto -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar subtotales en factura sin impuesto</label>
            <label for="subtotal_sin_imp_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="subtotal_sin_imp_si" type="radio" name="mostrar_subtotales_en_factura_sin_impuesto" class="hidden peer" value="1" <?php echo $conflocal['mostrar_subtotales_en_factura_sin_impuesto']->valor_final == 1?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="subtotal_sin_imp_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="subtotal_sin_imp_no" type="radio" name="mostrar_subtotales_en_factura_sin_impuesto" class="hidden peer" value="0" <?php echo $conflocal['mostrar_subtotales_en_factura_sin_impuesto']->valor_final == 0?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
    </div>
</div> <!-- fin Impuesto -->
