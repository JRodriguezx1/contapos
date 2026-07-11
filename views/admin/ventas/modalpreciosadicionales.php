<!-- MODAL SELECCIÓN DE PRECIOS ADICIONALES -->
<dialog id="miDialogoPreciosAdicionales"
    class="rounded-2xl border border-gray-200  w-[96%] max-w-4xl p-8 bg-white  backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">


    <div class="accordion_inv relative">
        <input id="btn1" name="config" type="radio" checked>
        <input id="btn2" name="config" type="radio">
        <input id="btn3" name="config" type="radio">
        <?php if($user['perfil']<4):  ?>
            <input id="btn4" name="config" type="radio">
        <?php endif;  ?>

            <div class="flex justify-center mb-6">
                <div class="inline-flex rounded-xl shadow-sm overflow-hidden border border-slate-200 bg-slate-50 btnsetup btnsetup-precios p-1">
                    <label class="px-5 py-2.5 text-base font-medium text-gray-600 bg-white hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300 cursor-pointer btn1" for="btn1">Precios adicionales</label>
                    <label class="px-5 py-2.5 text-base font-medium text-gray-600 bg-white hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300 cursor-pointer btn2" for="btn2">Variacion</label>
                    <label class="px-5 py-2.5 text-base font-medium text-gray-600 bg-white hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300 cursor-pointer btn3" for="btn3">Anotacion</label>
                    <?php if($user['perfil']<4):  ?>
                        <label class="px-5 py-2.5 text-base font-medium text-gray-600 bg-white hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300 cursor-pointer btn4" for="btn4">Comisión</label>
                    <?php endif;  ?>
                </div>
            </div>

            <!-- Encabezado del modal -->
            <div class="relative mb-8 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                <div class="flex items-center gap-4">
                    <!-- Icono -->
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-100 via-white to-indigo-50 border border-indigo-100 shadow-md">

                        <span
                            class="material-symbols-outlined text-[34px] text-indigo-600">
                            inventory_2
                        </span>
                    </div>

                    <!-- Información -->
                    <div class="flex-1">
                        <!-- <p
                            class="uppercase tracking-[0.25em] text-xs font-bold text-indigo-600">
                            Configuración
                        </p> -->

                        <h3
                            class="mt-1 text-3xl font-bold text-slate-800">
                            Configurar producto
                        </h3>

                        <p
                            id="textCardProduct"
                            class="mt-2 text-lg text-slate-500 font-medium">
                        </p>
                    </div>
                </div>
                <button id="btnCerrarPreciosAdicionales" class="absolute top-4 right-4 h-10 w-10 rounded-full flex items-center justify-center text-slate-500  hover:bg-red-50  hover:text-red-600 transition">
                    <i class="fa-solid fa-xmark text-2xl text-slate-60 btnCerrarPreciosAdicionales"></i>
                </button>
            </div>
        

        <div class="contenedorsetup mb-4">
            
            <div class="contenido1 accordion_tab_content">
                <!-- Encabezado -->
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-200">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">
                        payments
                    </span>

                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">
                            Seleccionar precio
                        </h4>

                        <p class="text-slate-500 text-base">
                            Elija uno de los precios disponibles o registre un precio libre.
                        </p>
                    </div>
                </div>

                <!-- Contenido -->
                <form id="formPreciosAdicioanles" class="space-y-6">
                    <!-- Lista de precios -->
                    <div id="listaPrecios" class="space-y-3 blockInputRadio"> </div>

                    <!-- Botón agregar precio -->
                    <div class="flex justify-center my-6">
                        <button
                            type="button"
                            id="btnMostrarNuevoPrecio"
                            class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-indigo-50 px-5 py-3 text-indigo-700 font-semibold transition hover:bg-indigo-100 hover:border-indigo-300">

                            <i
                                id="iconPrecioLibre"
                                class="fa-solid fa-plus">
                            </i>

                            <span id="textoPrecioLibre">
                                Definir precio manual
                            </span>
                        </button>
                    </div>

                    <!-- Nuevo precio -->
                    <div
                        id="nuevoPrecioContainer"
                        class="overflow-hidden max-h-0 opacity-0 -translate-y-2 transition-all duration-500 ease-in-out">
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6">
                            <!-- Encabezado -->
                            <div class="flex items-center gap-3 mb-5">
                                <span class="material-symbols-outlined text-emerald-600 text-4xl">
                                    attach_money
                                </span>

                                <div>
                                    <h5 class="text-2xl font-bold text-slate-800">
                                        Precio personalizado
                                    </h5>

                                    <p class="text-slate-500 text-base">
                                        Registre un precio diferente para este producto.
                                    </p>
                                </div>
                            </div>

                            <!-- Campo -->
                            <div class="max-w-sm mx-auto">
                                <label
                                    for="precioLibre"
                                    class="block text-base font-semibold text-slate-700 mb-3 text-center">
                                    Precio libre
                                </label>

                                <input
                                    id="precioLibre"
                                    type="text"
                                    name="precioLibre"
                                    placeholder="Ingrese el valor"
                                    class="bg-white
                                        border
                                        border-slate-300
                                        rounded-2xl
                                        block
                                        w-full
                                        h-16
                                        px-4
                                        text-center
                                        text-3xl
                                        font-bold
                                        text-emerald-700
                                        placeholder:text-slate-400
                                        focus:border-emerald-500
                                        focus:outline-none
                                        focus:ring-2
                                        focus:ring-emerald-200
                                        transition"
                                    oninput="formatearMoneda(this)">

                                <p class="mt-3 text-center text-sm text-slate-500">
                                    Este valor reemplazará el precio seleccionado.
                                </p>
                            </div>
                        </div>

                        <!--
                        <div id="autorizacionSupervisor" class="mt-6 bg-indigo-50 border border-indigo-200 p-4 rounded-xl">
                            <h6 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-lock text-indigo-600"></i> Autorización requerida
                            </h6>

                            <p class="text-gray-600 text-sm mb-3">
                                Ingresa la clave del supervisor para aplicar el precio personalizado.
                            </p>

                            <input
                                type="password"
                                id="claveSupervisor"
                                placeholder="Clave de supervisor"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 text-base focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        </div>
                        -->

                        <!--
                        <div class="mt-6">
                            <button
                                type="button"
                                id="btnUsarPrecioPersonalizado"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 rounded-lg transition-all shadow-md hover:shadow-lg focus:ring-2 focus:ring-indigo-500 flex items-center justify-center gap-2">

                                <i class="fa-solid fa-check text-white text-lg"></i>

                                Usar este precio

                            </button>
                        </div>
                        -->
                    </div>

                    <!-- Calculadora -->
                    <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                        <!-- Encabezado -->
                        <div class="flex items-center gap-3 mb-5">
                            <span class="material-symbols-outlined text-indigo-600 text-4xl">
                                calculate
                            </span>

                            <div>
                                <h5 class="text-2xl font-bold text-slate-800">
                                    Calculadora de cantidades
                                </h5>

                                <p class="text-slate-500 text-base">
                                    Sume o reste cantidades antes de agregarlas al producto.
                                </p>
                            </div>
                        </div>

                        <!-- Entrada -->
                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <label
                                    for="inputCantidadCalculada"
                                    class="block text-base font-semibold text-slate-700 mb-2">
                                    Cantidad
                                </label>

                                <input
                                    id="inputCantidadCalculada"
                                    class="w-full bg-white border border-slate-300 rounded-2xl h-16 px-4 text-center text-2xl font-bold text-slate-800 focus:border-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-200 transition"
                                    type="text"
                                    placeholder="0"
                                    value=""
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                            <!-- Botones -->
                            <div class="flex gap-2">
                                <button
                                    id="operationSum"
                                    type="button"
                                    class="w-14 h-14 rounded-xl border border-slate-300 bg-white hover:bg-indigo-50 hover:border-indigo-400 transition">

                                    <i class="fa-solid fa-plus text-xl text-indigo-600"></i>
                                </button>

                                <button
                                    id="operationLess"
                                    type="button"
                                    class="w-14 h-14 rounded-xl border border-slate-300 bg-white hover:bg-indigo-50 hover:border-indigo-400 transition">

                                    <i class="fa-solid fa-minus text-xl text-indigo-600"></i>
                                </button>

                                <button
                                    id="reset"
                                    type="button"
                                    class="w-14 h-14 rounded-xl border border-red-200 bg-white hover:bg-red-50 transition">

                                    <i class="fa-solid fa-power-off text-xl text-red-500"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Historial -->
                        <div class="mt-6">
                            <p class="text-sm uppercase tracking-widest font-semibold text-slate-500 text-center">
                                Operaciones
                            </p>

                            <p
                                id="lastOperation"
                                class="mt-2 text-center text-lg text-slate-600 min-h-[28px]">
                                0
                            </p>
                        </div>

                        <!-- Resultado -->
                        <div class="mt-6 rounded-xl bg-emerald-50 border border-emerald-200 p-5">
                            <p class="text-center uppercase tracking-[0.25em] text-sm font-semibold text-emerald-700">
                                Resultado
                            </p>

                            <p
                                id="textCantidadCalculada"
                                class="mt-2 text-center text-6xl font-bold text-emerald-700">

                                0
                            </p>
                        </div>
                    </div>

                </form>
            </div>

            <div class="contenido2 accordion_tab_content">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-200">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">
                        inventory
                    </span>

                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">
                            Configurar variaciones
                        </h4>

                        <p class="text-slate-500 text-base">
                            Personalice los insumos incluidos y seleccione las variaciones del producto.
                        </p>
                    </div>
                </div>
                <!-- Lista de precios -->
                <div id="listaInsumos" class="space-y-3 blockInputRadio"> </div>
            </div>

            <div class="contenido3 accordion_tab_content">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-200">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">
                        edit_note
                    </span>

                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">
                            Anotación del producto
                        </h4>

                        <p class="text-slate-500 text-base">
                            Agregue información adicional si es necesario.
                        </p>
                    </div>
                </div>

                <!-- NUEVA TARJETA -->
                <div class="rounded-2xl border border-yellow-300 bg-amber-50 bg-gradient-to-br from-amber-50 to-white p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="material-symbols-outlined text-amber-600 text-4xl">
                            sticky_note_2
                        </span>

                        <div>

                            <h5 class="text-2xl font-bold text-slate-800">
                                Detalle
                            </h5>
                        </div>
                    </div>

                    <!-- AQUÍ VA EL TEXTAREA -->
                    <textarea
                        id="anotacion"
                        rows="5"
                        placeholder="Escriba una nota para este producto"
                        class="
                            w-full
                            rounded-2xl
                            border
                            border-slate-300
                            bg-white/90
                            px-5
                            py-4
                            text-lg
                            text-slate-700
                            leading-7
                            placeholder:text-slate-500
                            resize-none
                            outline-none
                            transition-all
                            duration-300
                            focus:border-indigo-500
                            focus:ring-2
                            focus:ring-indigo-200
                        "></textarea>

                    <p class="mt-3 text-base text-slate-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-amber-500">
                            tips_and_updates
                        </span>
                        La nota solo se aplicará a este producto durante la venta.
                    </p>
                </div>
            </div>

            <div class="contenido4 accordion_tab_content">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-200">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">
                        payments
                    </span>

                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">
                            Comisión del producto
                        </h4>

                        <p class="text-slate-500 text-base">
                            Defina el porcentaje de comisión que se aplicará para este producto.
                        </p>
                    </div>
                </div>

                <div class="
                    rounded-2xl
                    border
                    border-sky-200
                    bg-sky-50
                    p-6
                ">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-sky-600 text-4xl">
                            percent
                        </span>

                        <div>
                            <h5 class="text-2xl font-bold text-slate-800">
                                Comisión
                            </h5>
                        </div>
                    </div>

                    <!-- ========================= -->
                    <!-- INPUT -->
                    <!-- ========================= -->
                    <div class="w-full max-w-lg mx-auto">
                        <label
                            class="block mb-3 text-center text-lg font-semibold text-slate-700">
                            Ingresar porcentaje
                        </label>

                        <div class="flex">
                            <input
                                id="comisionproducto"
                                type="text"
                                placeholder="0"
                                value=""
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'); if(parseFloat(this.value) > 100){this.value = 100;}"

                                class="
                                    flex-1
                                    h-14
                                    rounded-l-xl
                                    border
                                    border-slate-300
                                    border-r-0
                                    bg-white/90
                                    px-5
                                    text-center
                                    text-2xl
                                    font-bold
                                    text-slate-700
                                    outline-none
                                    transition-all
                                    duration-300
                                    focus:border-sky-500
                                    focus:ring-2
                                    focus:ring-sky-200
                                "
                                required
                            >

                            <div
                                class="
                                    flex
                                    items-center
                                    justify-center
                                    w-16
                                    h-14
                                    rounded-r-xl
                                    border
                                    border-slate-300
                                    bg-slate-100
                                    text-2xl
                                    font-bold
                                    text-slate-600
                                ">
                                <i class="fa-solid fa-percent"></i>
                            </div>
                        </div>
                    </div>

                    <!-- ========================= -->
                    <!-- TEXTO DE AYUDA -->
                    <!-- ========================= -->
                    <div class="max-w-md mx-auto mt-5">
                        <p class="
                            text-base
                            text-slate-500
                            flex
                            items-center
                            justify-center
                            gap-2
                            text-center
                        ">
                            <span class="material-symbols-outlined text-base text-sky-500">
                                info
                            </span>
                            La comisión se calculará automáticamente al realizar la venta.
                        </p>
                    </div>

                    <!-- ========================= -->
                    <!-- RESUMEN -->
                    <!-- ========================= -->
                    <div
                        class="
                            mt-8
                            rounded-2xl
                            border
                            border-slate-200
                            bg-white/80
                            p-6
                        ">

                        <div class="flex items-center gap-3 mb-5">
                            <span class="material-symbols-outlined text-emerald-600 text-3xl">
                                paid
                            </span>

                            <div>
                                <h6 class="text-xl font-bold text-slate-800">
                                    Cálculo de comisión
                                </h6>

                                <p class="text-base text-slate-500">
                                    Así se calculará la comisión de este producto.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">
                                    Venta del producto
                                </span>

                                <span
                                    id="vistaPreviaVenta"
                                    class="font-semibold text-slate-800">
                                    $0
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">
                                    Comisión
                                </span>

                                <span
                                    id="vistaPreviaPorcentaje"
                                    class="text-xl font-bold text-sky-700">
                                    0%
                                </span>
                            </div>

                            <hr class="border-slate-200">

                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-slate-700">
                                    El vendedor recibirá
                                </span>

                                <span
                                    id="vistaPreviaComision"
                                    class="text-4xl font-bold text-emerald-600">
                                    $0
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones inferiores -->
        <div class="text-right pt-6 border-t border-gray-200  flex justify-end gap-3">
            <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px]" value="Cancelar">Cancelar</button>
            <button id="aplicarOpcionesProducto" type="button" class="btn-md btn-indigo !py-4 !px-6 !w-[135px]" value="Seleccionar">Seleccionar</button>
        </div>
    </div>



    <script>
        const btnPrecioLibre = document.getElementById('btnMostrarNuevoPrecio');
        const contenedorPrecioLibre = document.getElementById('nuevoPrecioContainer');
        const inputPrecioLibre = document.getElementById('precioLibre');

        const textoPrecioLibre = document.getElementById('textoPrecioLibre');
        const iconPrecioLibre = document.getElementById('iconPrecioLibre');

        btnPrecioLibre.addEventListener('click', () => {
            const abierto = contenedorPrecioLibre.classList.contains('max-h-[600px]');

            if (abierto) {

                contenedorPrecioLibre.classList.remove(
                    'max-h-[600px]',
                    'opacity-100',
                    'translate-y-0'
                );

                contenedorPrecioLibre.classList.add(
                    'max-h-0',
                    'opacity-0',
                    '-translate-y-2'
                );

                textoPrecioLibre.textContent = 'Definir precio manual';

                iconPrecioLibre.classList.remove('fa-minus');
                iconPrecioLibre.classList.add('fa-plus');

            } else {

                contenedorPrecioLibre.classList.remove(
                    'max-h-0',
                    'opacity-0',
                    '-translate-y-2'
                );

                contenedorPrecioLibre.classList.add(
                    'max-h-[600px]',
                    'opacity-100',
                    'translate-y-0'
                );

                textoPrecioLibre.textContent = 'Ocultar precio manual';

                iconPrecioLibre.classList.remove('fa-plus');
                iconPrecioLibre.classList.add('fa-minus');

                setTimeout(() => {
                    inputPrecioLibre.focus();
                }, 300);
            }
        });
    </script>
</dialog>
