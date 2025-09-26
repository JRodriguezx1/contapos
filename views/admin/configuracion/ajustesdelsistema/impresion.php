<div class="contenido5 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6 mt-6">
    <div class="flex flex-wrap gap-10">
        <p class="text-indigo-600 font-bold">Impresion</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 gap-y-10">
        <!-- Mostrar nombre del negocio en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar nombre del negocio en factura</label>
            <label for="nombrenegociosi" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="nombrenegociosi" type="radio" name="mostrar_nombre_del_negocio_en_factura" value="1" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="nombrenegociono" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="nombrenegociono" type="radio" name="mostrar_nombre_del_negocio_en_factura" value="0" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Mensaje final (Footer) -->
        <div>
            <label class="block text-xl font-medium text-gray-700 mb-1">Mensaje final en factura</label>
            <textarea class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 h-40 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white text-xl focus:outline-none focus:ring-1" rows="3" placeholder="Escribe el mensaje que al pie de la factura" neme="mensaje_final_en_factura"></textarea>
        </div>
        <!-- Titulo para el nombre del documento -->
        <div>
            <label for="nombre_impuesto" class="block text-xl font-medium text-gray-700 mb-1">
                Titulo para el nombre del documento
            </label>
            <input 
                type="text" 
                id="titulo_para_el_nombre_del_documento" 
                name="titulo_para_el_nombre_del_documento" 
                placeholder="Ejemplo: NIT"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>

        <!-- Habilitar subtotal en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Habilitar subtotal en factura</label>
            <label for="subtotal_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="subtotal_factura_si" type="radio" name="habilitar_subtotal_en_factura" value="1" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="subtotal_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="subtotal_factura_no" type="radio" name="habilitar_subtotal_en_factura" value="0" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>

        <!-- Mostrar número de factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar número de factura</label>
            <label for="numero_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="numero_factura_si" type="radio" name="mostrar_numero_de_factura" value="1" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="numero_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="numero_factura_no" type="radio" name="mostrar_numero_de_factura" value="0" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>

        <!-- Mostrar nombre del documento en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar nombre del documento en factura</label>
            <label for="nom_doc_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="nom_doc_factura_si" type="radio" name="mostrar_nombre_del_documento_en_factura" value="1" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="nom_doc_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="nom_doc_factura_no" type="radio" name="mostrar_nombre_del_documento_en_factura" value="0" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>

        <!-- Mostrar observación en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar observación en factura</label>
            <label for="observacion_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="observacion_factura_si" type="radio" name="mostrar_observacion_en_factura" value="1" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="observacion_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="observacion_factura_no" type="radio" name="mostrar_observacion_en_factura" value="0" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>

        <!-- Mostrar cambio de efectivo en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar cambio de efectivo en factura</label>
            <label for="cambioefectivo_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cambioefectivo_factura_si" type="radio" name="mostrar_cambio_de_efectivo_en_factura" value="1" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="cambioefectivo_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="cambioefectivo_factura_no" type="radio" name="mostrar_cambio_de_efectivo_en_factura" value="0" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Espaciado de papel en factura -->
        <div>
        <label for="espaciado_de_papel" class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">
            Espaciado de papel
        </label>
        <span class="block mb-1 text-sm text-gray-500">
            Ingrese el espaciado del papel (Ejemplo: POS 58 mm -- 22 / POS 80 mm -- 38 mm)
        </span>
        <input 
            type="number" 
            id="espaciado_de_papel" 
            name="espaciado_de_papel" 
            placeholder="Ingrese el espacio del papel"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
        >
        </div>
        <!-- Mostrar método de pago en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar método de pago en factura</label>
            <label for="met_pago_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="met_pago_factura_si" type="radio" name="mostrar_metodo_de_pago_en_factura" value="1" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="met_pago_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="met_pago_factura_no" type="radio" name="mostrar_metodo_de_pago_en_factura" value="0" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Mostrar logo en factura -->
        <div class="flex flex-col gap-2">
            <label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Mostrar logo en factura</label>
            <label for="logo_factura_si" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="logo_factura_si" type="radio" name="mostrar_logo_en_factura" value="1" class="hidden peer" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Si</span>
            </label>

            <label for="logo_factura_no" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <input id="logo_factura_no" type="radio" name="mostrar_logo_en_factura" value="0" class="hidden peer">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">No</span>
            </label>
        </div>
        <!-- Titulo para el nombre del documento -->
        <div>
            <label for="nombre_del_impuesto" class="block text-xl font-medium text-gray-700 mb-1">
                Nombre del impuesto
            </label>
            <input 
                type="text" 
                id="nombre_del_impuesto"
                name="nombre_del_impuesto" 
                placeholder="Ejemplo: impoconsumo"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
        <!-- Titulo para el nombre del cliente -->
        <div>
            <label for="titulo_para_el_nombre_del_cliente" class="block text-xl font-medium text-gray-700 mb-1">
                Titulo para el nombre del cliente
            </label>
            <input 
                type="text" 
                id="titulo_para_el_nombre_del_cliente" 
                name="titulo_para_el_nombre_del_cliente" 
                placeholder="Ejemplo: Razón Social"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
        <!-- Simbolo móneda -->
        <div>
            <label for="simbolo_moneda" class="block text-xl font-medium text-gray-700 mb-1">
                Símbolo moneda
            </label>
            <span class="block mb-1 text-sm text-gray-500">
                Seleccione el símbolo de la moneda que usará el sistema
            </span>
            <select 
                id="simbolo_moneda" 
                name="simbolo_moneda"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
            >
                <option value="$">Peso colombiano (COP) – $</option>
                <option value="USD">$ – Dólar estadounidense</option>
                <option value="€">€ – Euro</option>
                <!-- <option value="£">£ – Libra esterlina</option>
                <option value="¥">¥ – Yen japonés</option>
                <option value="₿">₿ – Bitcoin</option> -->
            </select>
        </div>

    </div>
</div>