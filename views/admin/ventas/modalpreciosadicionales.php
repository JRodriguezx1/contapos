<!-- MODAL SELECCIÓN DE PRECIOS ADICIONALES -->
<dialog id="miDialogoPreciosAdicionales"
    class="rounded-2xl border border-gray-200 dark:border-neutral-700 w-[95%] max-w-3xl p-8 bg-white dark:bg-neutral-900 backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">

    <!-- Encabezado -->
    <div class="flex justify-between items-center border-b border-gray-200 dark:border-neutral-700 pb-4 mb-6">
        <h4 class="text-2xl font-bold text-indigo-700 dark:text-indigo-400 flex items-center gap-2">
            💰 Seleccionar precio adicional
        </h4>
        <button id="btnCerrarPreciosAdicionales" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 transition">
            <i class="fa-solid fa-xmark text-gray-600 dark:text-gray-300 text-2xl btnCerrarPreciosAdicionales"></i>
        </button>
    </div>

    <!-- Contenido -->
    <form id="formPreciosAdicioanles" class="space-y-6">

        <!-- Lista de precios -->
        <div id="listaPrecios" class="space-y-3"> </div>

        <!-- Botón agregar precio -->
        <div class="text-center mt-3">
            <button type="button" id="btnMostrarNuevoPrecio"
                class="flex items-center justify-center gap-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium text-base mx-auto transition">
                <i class="fa-solid fa-plus"></i> Agregar precio personalizado
            </button>
        </div>

        <!-- Nuevo precio -->
        <div id="nuevoPrecioContainer" class="hidden mt-6 border-t border-gray-300 dark:border-neutral-700 pt-6 animate-fadeIn">
            <!--<h5 class="text-gray-700 dark:text-gray-200 font-medium text-lg mb-3">Nuevo precio personalizado</h5>

            <div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
                <div class="sm:col-span-4">
                    <label for="aaaaa" class="block text-base font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                    <input id="aaaaa" type="text" name="aaaaa" autocomplete="off"
                        placeholder="Ej: Precio cliente VIP, combo especial..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 dark:bg-gray-600 dark:border-gray-500 dark:text-white h-14 text-lg focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>

                <div class="sm:col-span-2">
                    <label for="precioAdicional" class="block text-base font-medium text-gray-700 dark:text-gray-300">Precio</label>
                    <input id="precioAdicional" type="number" name="precioAdicional" placeholder="Ej: 25000"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 dark:bg-gray-600 dark:border-gray-500 dark:text-white h-14 text-lg focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>

            <div id="autorizacionSupervisor" class="mt-6 bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-800 p-4 rounded-xl">
                <h6 class="text-base font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-lock text-indigo-600"></i> Autorización requerida
                </h6>
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                    Ingresa la clave del supervisor para aplicar el precio personalizado.
                </p>
                <input type="password" id="claveSupervisor" placeholder="Clave de supervisor"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-base focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>-->

            <!-- Botón usar precio -->
            <!--<div class="mt-6">
                <button type="button" id="btnUsarPrecioPersonalizado"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-lg transition-all shadow-md hover:shadow-lg focus:ring-2 focus:ring-indigo-500 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check text-white text-lg"></i>
                    Usar este precio
                </button>
            </div>-->
        </div>

        <!-- Botones inferiores -->
        <div class="text-right pt-6 border-t border-gray-200 dark:border-neutral-700 flex justify-end gap-3">
            <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px]" value="Cancelar">Cancelar</button>
            <button id="aplicarprecioadicional" type="button" class="btn-md btn-indigo !py-4 !px-6 !w-[135px]" value="Seleccionar">Seleccionar</button>
        </div>
    </form>

    <script>
        document.getElementById('btnMostrarNuevoPrecio').addEventListener('click', () => {
            document.getElementById('nuevoPrecioContainer').classList.toggle('hidden');
        });
    </script>
</dialog>
