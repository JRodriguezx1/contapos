<div class="configcaja contenido1 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6">
    <div class="flex flex-wrap gap-10">
        <p class="text-indigo-600 font-bold">Caja</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>
            <label class="block text-xl font-medium text-gray-700 mb-1">Mensaje para factura</label>
            <textarea class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 h-40 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white text-xl focus:outline-none focus:ring-1" rows="3" placeholder="Escribe el mensaje que aparecerá en la factura"></textarea>
        </div>

        <!-- Imprimir factura automaticamente-->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Imprimir factura automaticamente</label>
            <label for="imprimirfacturasi" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="imprimirfacturasi" type="radio" name="imprimir_factura_automaticamente" class="hidden peer" value="1" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?> >
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="imprimirfacturano" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="imprimirfacturano" type="radio" name="imprimir_factura_automaticamente" class="hidden peer" value="0" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 0?'checked':'';?> >
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>

        <!-- Límite de descuento permitido -->
        <div class="flex flex-col gap-2">
            <label for="limite-descuento" class="block text-xl font-medium text-gray-700 mb-1 mt-5">
                Límite de descuento permitido
            </label>
            <div class="flex items-center gap-3">
                <input 
                    type="number" 
                    id="limite-descuento" 
                    name="limite-descuento" 
                    min="0" max="100"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 
                        block w-28 p-2.5 h-14 text-xl focus:outline-none focus:ring-1 
                        dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="0"
                >
                <span class="text-lg font-medium text-gray-700">%</span>
            </div>
            <p class="mt-1 text-sm text-gray-500">Indica el porcentaje máximo que se puede aplicar en descuentos.</p>
        </div>

        <!-- Permitir cierre de caja con pedidos sin facturar -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5">Permitir cierre de caja con ordenes sin facturar</label>
            <!-- Opción Sí -->
            <label for="cierre-sin-facturar-si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cierre-sin-facturar-si" type="radio" name="permitir_cierre_de_caja_con_ordenes_sin_pagar" class="hidden peer" value="1" <?php echo $conflocal['permitir_cierre_de_caja_con_ordenes_sin_pagar']->valor_final == 1?'checked':'';?> >
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900 dark:text-white">Sí</span>
            </label>

            <!-- Opción No -->
            <label for="cierre-sin-facturar-no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cierre-sin-facturar-no" type="radio" name="permitir_cierre_de_caja_con_ordenes_sin_pagar" class="hidden peer" value="0" <?php echo $conflocal['permitir_cierre_de_caja_con_ordenes_sin_pagar']->valor_final == 0?'checked':'';?> >
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900 dark:text-white">No</span>
            </label>
        </div>
        
        <!-- Permitir venta de productos sin stock -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Permitir venta de productos sin stock</label>
            <label for="productosinstocksi" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="productosinstocksi" type="radio" name="permitir_venta_de_productos_sin_stock" class="hidden peer" value="1" <?php echo $conflocal['permitir_venta_de_productos_sin_stock']->valor_final == 1?'checked':'';?> >
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="productosinstockno" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="productosinstockno" type="radio" name="permitir_venta_de_productos_sin_stock" class="hidden peer" value="0" <?php echo $conflocal['permitir_venta_de_productos_sin_stock']->valor_final == 0?'checked':'';?> >
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
    </div>
</div> <!-- End Caja -->