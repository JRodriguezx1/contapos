<!-- MODAL SELECCIÓN DE PRECIOS ADICIONALES -->
<dialog id="miDialogoPreciosAdicionales"
    class="rounded-2xl border border-gray-200  w-[95%] max-w-3xl p-8 bg-white  backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">


    <div class="accordion_inv relative">
        <input id="btn1" name="config" type="radio" checked>
        <input id="btn2" name="config" type="radio">
        <?php if($user['perfil']<4):  ?>
            <input id="btn3" name="config" type="radio">
        <?php endif;  ?>

            <div class="inline-flex rounded-2xl shadow-md overflow-hidden border border-gray-300 self-start mb-4 btnsetup">
                <label class="px-6 py-3 text-base font-medium text-gray-600 bg-white hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition cursor-pointer btn1" for="btn1">Precios adicionales</label>
                <label class="px-6 py-3 text-base font-medium text-gray-600 bg-white hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 border-l border-gray-300 transition cursor-pointer btn2" for="btn2">Anotacion</label>
                <?php if($user['perfil']<4):  ?>
                    <label class="px-6 py-3 text-base font-medium text-gray-600 bg-white hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 border-l border-gray-300 transition cursor-pointer btn3" for="btn3">Comision</label>
                <?php endif;  ?>
            </div>
            <button id="btnCerrarPreciosAdicionales" class="rounded-lg hover:bg-gray-100  transition absolute right-0">
                <i class="fa-solid fa-xmark px-2 text-gray-600  text-3xl btnCerrarPreciosAdicionales"></i>
            </button>
        

        <div class="contenedorsetup mb-4">
            <p id="textCardProduct" class="text-center text-xl text-slate-500 mt-0"></p>
            <div class="contenido1 accordion_tab_content">
                <!-- Encabezado -->
                <h4 class="pb-4 mb-6 text-2xl font-bold text-indigo-700 border-b border-gray-200">💰 Seleccionar precio adicional</h4>

                <!-- Contenido -->
                <form id="formPreciosAdicioanles" class="space-y-6">
                    <!-- Lista de precios -->
                    <div id="listaPrecios" class="space-y-3 blockInputRadio"> </div>

                    <!-- Botón agregar precio -->
                    <div class="text-center mt-3">
                        <button type="button" id="btnMostrarNuevoPrecio"
                            class="flex items-center justify-center gap-2 text-indigo-600  hover:text-indigo-800  font-medium text-base mx-auto transition">
                            <i class="fa-solid fa-plus"></i> Agregar precio personalizado
                        </button>
                    </div>

                    <!-- Nuevo precio -->
                    <div id="nuevoPrecioContainer" class="hidden mt-6 border-t border-gray-300  pt-6 animate-fadeIn">
                        <!--<h5 class="text-gray-700  font-medium text-lg mb-3">Nuevo precio personalizado</h5>

                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
                            <div class="sm:col-span-4">
                                <label for="aaaaa" class="block text-base font-medium text-gray-700 ">Descripción</label>
                                <input id="aaaaa" type="text" name="aaaaa" autocomplete="off"
                                    placeholder="Ej: Precio cliente VIP, combo especial..."
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3    h-14 text-lg focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="precioAdicional" class="block text-base font-medium text-gray-700 ">Precio</label>
                                <input id="precioAdicional" type="number" name="precioAdicional" placeholder="Ej: 25000"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3    h-14 text-lg focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div id="autorizacionSupervisor" class="mt-6 bg-indigo-50  border border-indigo-200  p-4 rounded-xl">
                            <h6 class="text-base font-semibold text-gray-800  flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-lock text-indigo-600"></i> Autorización requerida
                            </h6>
                            <p class="text-gray-600  text-sm mb-3">
                                Ingresa la clave del supervisor para aplicar el precio personalizado.
                            </p>
                            <input type="password" id="claveSupervisor" placeholder="Clave de supervisor"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3    text-base focus:outline-none focus:ring-1 focus:ring-indigo-500">
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

                    <div>
                        <p class="text-center text-slate-500 font-medium">Calculadora de cantidades</p>
                        <div class="flex items-center justify-center gap-4">
                            <p class="text-slate-600">Cantidad: </p>
                            <input 
                                id="inputCantidadCalculada"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                                type="text" 
                                placeholder="Ingresa cantidad"
                                value=""
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                
                            >
                            <div class="border border-gray-300 mt-2 h-14 rounded-lg text-gray-600 cursor-pointer">
                                <button id="operationSum" type="button"><i class="text-2xl fa-solid fa-plus pl-3 py-3 pr-4"></i></button>
                                <button id="operationLess" type="button"><i class="text-2xl fa-solid fa-minus pl-3 py-3 pr-4"></i></button>
                                <button id="reset" type="button"><i class="text-2xl fa-solid fa-power-off p-3"></i></button>
                            </div>
                        </div>
                        <p id="lastOperation" class="text-slate-600 text-xl text-center mb-0">0</p>
                        <p id="textCantidadCalculada" class="text-green-500 text-2xl text-center mt-0">0</p>
                    </div>

                </form>
            </div>

            <div class="contenido2 accordion_tab_content">
                <textarea 
                    id="anotacion"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-40 text-lg focus:outline-none focus:ring-1"
                    rows="4">Anotacion aqui.
                </textarea>
            </div>

            <div class="contenido3 accordion_tab_content">
                <h4 class="pb-4 mb-6 text-2xl font-bold text-indigo-700 border-b border-gray-200">❤️ Porcentaje de comision para el producto</h4>
                <div class="flex items-center gap-4">
                    <p>Porcentaje de comision: </p>
                    <input 
                        id="comisionproducto"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                        type="text" 
                        placeholder="Ingresa porcentaje"
                        value=""
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'); if(parseFloat(this.value) > 100){this.value = 100;}"
                        required
                    >
                    <div class="border border-gray-300 p-3 mt-2 h-14 rounded-lg text-gray-600"><i class=" text-2xl fa-solid fa-percent"></i></div>
                </div>
            </div>
        </div>
        <!-- Botones inferiores -->
        <div class="text-right pt-6 border-t border-gray-200  flex justify-end gap-3">
            <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px]" value="Cancelar">Cancelar</button>
            <button id="aplicarprecioadicional" type="button" class="btn-md btn-indigo !py-4 !px-6 !w-[135px]" value="Seleccionar">Seleccionar</button>
        </div>
    </div>



    <script>
        document.getElementById('btnMostrarNuevoPrecio').addEventListener('click', () => {
            document.getElementById('nuevoPrecioContainer').classList.toggle('hidden');
        });
    </script>
</dialog>
