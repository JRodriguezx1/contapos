<div class="contenido4 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6">
    <div class="flex flex-wrap gap-10">
        <p class="text-indigo-600 font-bold">Permisos</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 gap-y-10">
        <!-- Permitir ver cierres de cajas anteriores -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Permitir ver cierres de cajas anteriores</label>
            <label for="cierrecajasi" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cierrecajasi" type="radio" name="permitir_ver_cierres_de_cajas_anteriores" class="hidden peer" value="1" <?php echo $conflocal['permitir_ver_cierres_de_cajas_anteriores']->valor_final == 1?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="cierrecajano" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cierrecajano" type="radio" name="permitir_ver_cierres_de_cajas_anteriores" class="hidden peer" value="0" <?php echo $conflocal['permitir_ver_cierres_de_cajas_anteriores']->valor_final == 1?'checked':'';?>>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Cantidad de cierres de cajas permitidos -->
        <div class="flex flex-col gap-2">
            <label for="limite-descuento" class="block text-xl font-medium text-gray-700 mb-1 mt-5">
                Cantidad de cierres de cajas permitidos
            </label>
            <div class="flex items-center gap-3">
                <input 
                    type="number" 
                    id="cantidad_de_cierres_de_cajas_permitidos" 
                    name="cantidad_de_cierres_de_cajas_permitidos" 
                    min="0" max="100"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 
                        block w-28 p-2.5 h-14 text-xl focus:outline-none focus:ring-1 
                        dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="0"
                >
            </div>
            <p class="mt-1 text-sm text-gray-500">Indica los cierres de cajas permitidos.</p>
        </div>
        <!-- Permitir ver zeta diario-->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Permitir ver zeta diario</label>
            <label for="zetadiariosi" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="zetadiariosi" type="radio" name="permitir_ver_zeta_diario" value="1" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="zetadiariono" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="zetadiariono" type="radio" name="permitir_ver_zeta_diario" value="0" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Permitir ver resum cierre de caja-->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Permitir ver resumen cierre de caja</label>
            <label for="vercierrecajasi" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="vercierrecajasi" type="radio" name="permitir_ver_resumen_cierre_de_caja" value="1" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="vercierrecajano" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="vercierrecajano" type="radio" name="permitir_ver_resumen_cierre_de_caja" value="0" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Cantidad de zeta diario permitidos -->
        <div class="flex flex-col gap-2">
            <label for="cantidad_de_zeta_diarios_permitidos" class="block text-xl font-medium text-gray-700 mb-1 mt-5">
                Cantidad de zeta diarios permitidos
            </label>
            <div class="flex items-center gap-3">
                <input 
                    type="number" 
                    id="cantidad_de_zeta_diarios_permitidos" 
                    name="cantidad_de_zeta_diarios_permitidos" 
                    min="0" max="100"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 
                        block w-28 p-2.5 h-14 text-xl focus:outline-none focus:ring-1 
                        dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="0"
                >
            </div>
            <p class="mt-1 text-sm text-gray-500">Indica cantidad zeta diario permitidos.</p>
        </div>
    </div>
</div> <!-- fin Permisos -->
