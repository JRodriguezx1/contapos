 <div class="contenido7 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6">
    <div class="flex flex-wrap gap-10">
        <p class="text-indigo-600 font-bold">Caja</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Proveedor factura electrónica -->
        <div>
            <label for="proveedor_fac_elect" class="block text-xl font-medium text-gray-700 mb-1">
                Proveedor factura electrónica
            </label>
            <input 
                type="text" 
                id="proveedor_fac_elect" 
                name="proveedor_fac_elect" 
                placeholder="Ejemplo: J2POS"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
        <!-- Texto factura electrónica QR -->
        <div>
            <label class="block text-xl font-medium text-gray-700 mb-1">Texto factura electrónica QR</label>
            <textarea class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 h-40 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white text-xl focus:outline-none focus:ring-1" rows="3" placeholder="Escribe el mensaje que aparecerá en la factura electrónica QR"></textarea>
        </div>
        <!-- Mostrar código QR en factura electrónica -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar código QR en factura electrónica</label>
            <label for="qr_fact_elect_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="qr_fact_elect_si" type="radio" name="qr_fact_elect" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="qr_fact_elect_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="qr_fact_elect_no" type="radio" name="qr_fact_elect" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Mostrar cufe en factura electrónica -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar cufe en factura electrónica</label>
            <label for="cufe_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cufe_si" type="radio" name="cufe" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="cufe_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cufe_no" type="radio" name="cufe" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
    </div>
</div> <!-- fin Consecutivos-->
