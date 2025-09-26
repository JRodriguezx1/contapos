<div class="configinventario contenido2 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6 mt-6">
                 
                        <div class="flex flex-wrap gap-10">
                            <p class="text-indigo-600 font-bold">Inventario</p>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        
                        
                        <div class="flex flex-col gap-2">
                            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Tipo costo inventario</label>
                            <label for="costopromedio" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <input id="costopromedio" type="radio" name="tipo_costo_inventario" class="hidden peer" value="costo_promedio">
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                                <span class="ms-3 text-xl font-medium text-gray-900">Costo promedio</span>
                            </label>

                            <label for="ultimocosto" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <input id="ultimocosto" type="radio" name="tipo_costo_inventario" class="hidden peer" value="ultimo_costo" checked>
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                                <span class="ms-3 text-xl font-medium text-gray-900">Último costo</span>
                            </label>
                        </div> 
        
                        
                        
                    </div>
                </div> <!-- fin INVENTARIO -->