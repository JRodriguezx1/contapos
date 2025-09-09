<div class="box compras p-10 !pb-20 rounded-lg mb-4">
    <div>
        <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <span class="sr-only">Atrás</span>
        </a>
        <h4 class="text-gray-600 mb-12 mt-4">Compras</h4>
        <?php include __DIR__. "/../../templates/alertas.php"; ?>
        <form id="formComprar" action="">
            <div class="border-b border-gray-900/10 pb-10 mb-3">
            
                <p class="mt-2 text-xl text-gray-600">Ingreso Almacen.</p>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8">

                    <div class="sm:col-span-3">
                        <label for="proveedor" class="block text-2xl font-medium text-gray-600">Proveedor</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="proveedor" name="proveedor" autocomplete="proveedor-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <option value="1">Predeterminado</option>
                                <option value="2">Makro tech</option>
                                <option value="3">CelMax</option>
                                <option value="4">Argos</option>
                                <option value="5">Electro house</option>
                            </select>
                            <!-- <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg> -->
                        </div>
                    </div>

                    <!-- Porcentaje de impuesto -->
                    <div class="sm:col-span-3"> 
                        <label for="porcentaje_impuesto" class="block text-2xl font-medium text-gray-600">
                            Impuesto
                        </label>
                        <!-- <span class="block mb-1 text-sm text-gray-500">
                            Seleccione el impuesto y tarifa correspondiente al negocio
                        </span> -->
                        <select 
                            id="porcentaje_impuesto_compra" 
                            name="porcentaje_impuesto_compra"
                            class="bg-gray-50 border mt-2 border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                        >
                            <span class="text-indigo-600 font-bold">
                                <optgroup label="IVA">
                            </span>
                            <option value="0">Exento – 0%</option>
                            <option value="5">Bienes / Servicios al 5%</option>
                            <option value="16">Contratos antes Ley 1819 – 16%</option>
                            <option value="19">Tarifa general – 19%</option>
                            <option value="excluido">Excluido</option>
                            </optgroup>
                            <span class="text-indigo-600 font-bold">
                                <optgroup class="text-indigo-60" label="INC">
                            </span>
                            <option value="8">Impuesto Nacional al Consumo – 8%</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="sm:col-span-2 md:col-span-3 tlg:col-span-2">
                        <label for="factura" class="block text-2xl font-medium text-gray-600">N° Factura</label>
                        <div class="mt-2">
                            <input type="text" name="factura" id="nfactura" autocomplete="family-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="fecha" class="block text-2xl font-medium text-gray-600">Fecha</label>
                        <div class="mt-2">
                            <input type="date" name="fecha" id="fecha" autocomplete="family-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                        </div>
                    </div>

                    <div class="sm:col-span-2 md:col-span-2 tlg:col-span-3">
                        <label for="origenPago" class="block text-2xl font-medium text-gray-600">Origen</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="origenPago" name="origen" autocomplete="origen-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <option value="0">Caja</option>
                                <option value="1">Banco</option>
                            </select>
                        </div>
                    </div>

                    <div id="divCaja" class="sm:col-span-3 md:col-span-4 tlg:col-span-3">
                        <label for="origenCaja" class="block text-2xl font-medium text-gray-600">Caja</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="origenCaja" name="origencaja" autocomplete="origencaja-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <?php foreach($cajas as $value): ?>
                                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
            
                    <div class="sm:col-span-3 md:col-span-4 tlg:col-span-2">
                        <label for="simbolo_moneda" class="block text-2xl font-medium text-gray-600">
                            Sede
                        </label>
                        <!-- <span class="block mb-1 text-sm text-gray-500">
                            Seleccione una sede
                        </span> -->
                        <select 
                            id="simbolo_moneda" 
                            name="simbolo_moneda"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 mt-2"
                        >
                            <option value="$">Sede Norte</option>
                            <option value="USD">Sede Centro</option>
                            <option value="€">Sede Sur</option>
                            <!-- <option value="£">£ – Libra esterlina</option>
                            <option value="¥">¥ – Yen japonés</option>
                            <option value="₿">₿ – Bitcoin</option> -->
                        </select>
                    </div>  

                    <div id="divBanco" class="sm:col-span-3 md:col-span-4 tlg:col-span-2 hidden">
                        <label for="origenBanco" class="block text-2xl font-medium text-gray-600">Banco</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="origenBanco" name="origenbanco" autocomplete="origenbanco-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                                <option value="" disabled selected>-Seleccionar-</option>
                                <?php foreach($bancos as $value): ?>
                                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg> -->
                        </div>
                    </div>

                    <div class="sm:col-span-3 md:col-span-3 tlg:col-span-2">
                        <label for="formapago" class="block text-2xl font-medium text-gray-600">Forma de pago</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="formapago" name="formapago" autocomplete="formapago-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <option value="1">Contado</option>
                                <option value="2">Credito 1 mes</option>
                                <option value="3">Credito 2 mes</option>
                                <option value="4">Credito 3 mes</option>
                                <option value="5">Credito 4 mes</option>
                                <option value="6">Credito 6 mes</option>
                                <option value="7">Credito 10 mes</option>
                                <option value="8">Credito 12 mes</option>
                                <option value="9">Credito 15 mes</option>
                                <option value="10">Credito 18 mes</option>
                                <option value="11">Credito 24 mes</option>
                            </select>
                            <!-- <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg> -->
                        </div>
                    </div>

                    <div class="sm:col-span-8 md:col-span-5 tlg:col-span-3">
                        <label for="observacion" class="block text-2xl font-medium text-gray-600">Observacion</label>
                        <div class="mt-2">
                        <input id="observacion" name="observacion" type="text" autocomplete="observacion ID" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="mb-4 md:w-1/2">
                <label for="articulo" class="block text-2xl font-medium text-gray-600">Articulo</label>
                <div class="mt-2 grid grid-cols-1">
                    <select id="articulo" name="articulo" autocomplete="articulo-name" class="bg-gray-50 border !border-gray-300 text-gray-900 rounded-lg focus:!border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" multiple="multiple" required>
                        <?php foreach($totalitems as $value): ?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>


            <div class="border-solid border-t-2 border-blue-600 pt-4 mb-4">
                <table class=" tabla" width="100%" id="tablaCompras">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>V. Compra</th>
                            <th class="accionesth text-red-500"><i class="fa-solid fa-x"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- productos seleccionados a comprar-->
                         <!--
                        <tr class="">
                            <td class="!px-0 !py-2 text-xl text-gray-500 leading-5">Taladro percutor BLACK AND DECKER 550W 1/2</td>
                            <td class="!px-0 !py-2 text-xl text-gray-500 leading-5">Metros cubicos</td> 
                            <td class="!px-0 !py-2"><div class="flex justify-center"><button><span class="menos material-symbols-outlined">remove</span></button><input type="text" class=" w-20 px-2 text-center" value="11" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"><button><span class="mas material-symbols-outlined">add</span></button></div></td>
                            <td class="!p-2 text-xl text-gray-500 leading-5">56000</td>
                            <td class="!p-2 text-xl text-gray-500 leading-5">56880</td>
                            <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>
                        </tr>
                        <tr class="">
                            <td class="!px-0 !py-2 text-xl text-gray-500 leading-5">Taladro percutor BLACK AND DECKER 550W 1/2</td>
                            <td class="!px-0 !py-2 text-xl text-gray-500 leading-5">Metros cubicos</td>
                            <td class="!px-0 !py-2"><div class="flex justify-center"><button><span class="menos material-symbols-outlined">remove</span></button><input type="text" class=" w-20 px-2 text-center" value="11" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"><button><span class="mas material-symbols-outlined">add</span></button></div></td>
                            <td class="!p-2 text-xl text-gray-500 leading-5">56000</td>
                            <td class="!p-2 text-xl text-gray-500 leading-5">56880</td>
                            <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>
                        </tr>
                        <tr class="">
                            <td class="!px-0 !py-2 text-xl text-gray-500 leading-5">Atornillador Inalambrico Dewalt 12W de 1/2</td>
                            <td class="!px-0 !py-2 text-xl text-gray-500 leading-5">Metros cubicos</td>
                            <td class="!px-0 !py-2"><div class="flex justify-center"><button><span class="menos material-symbols-outlined">remove</span></button><input type="text" class=" w-20 px-2 text-center" value="11" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"><button><span class="mas material-symbols-outlined">add</span></button></div></td>
                            <td class="!p-2 text-xl text-gray-500 leading-5">56000</td>
                            <td class="!p-2 text-xl text-gray-500 leading-5">56880</td>
                            <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>
                        </tr>-->
                    </tbody>
                </table>
            </div> <!-- FIn Apilamiento de productos -->

            <div class="text-right">
                <button id="btnvaciar" class="btn-md btn-turquoise !py-4 !px-6 !w-[136px] vaciar" type="button" value="vaciar">Vaciar</button>
                <input id="btnRegistrarCompra" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px] registrarCompra" type="submit" value="Registrar">
            </div>
        </form>

        <!-- INFORMACION FINAL DE LA COMPRA-->
        <div>
            <div class="flex justify-start gap-4 mt-6">
                <div class="text-end">
                    <p class="m-0 mb-2 text-slate-500 text-3xl font-normal">Sub Total:</p>
                    <p class="m-0 mb-2 text-slate-500 text-3xl font-normal">Impuesto:</p>
                    <p class="m-0 mb-2 text-slate-500 text-3xl font-normal">Descuento:</p>
                    <p class="m-0 mb-2 text-slate-600 text-3xl font-semibold">Total:</p>
                </div>
                <div>
                    <p id="subTotal" class="m-0 mb-2 text-slate-600 text-3xl font-semibold">$ 0</p>
                    <p id="impuesto" class="m-0 mb-2 text-slate-600 text-3xl font-semibold">% 0</p>
                    <p id="descuento" class="m-0 mb-2 text-slate-600 text-3xl font-semibold">$ 0</p>
                    <p id="total" class="m-0 mb-2 text-indigo-600 text-4xl font-semibold" style="font-family: 'Tektur', serif;">$ 0</p>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL PARA VACIAR EL CARRITO DE COMPRAS-->
    <dialog class="midialog-xs px-8 pb-8" id="miDialogoVaciar">
        <div>
            <p class="text-2xl font-semibold text-gray-500">Desea vaciar la lista de compra?</p>
        </div>
        <div class="flex justify-around border-t-gray-300 pt-4">
            <div class="sivaciar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Si</p></div>
            <div class="novaciar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">No</p></div>
        </div>
    </dialog>

     <!-- MODAL PARA REGISTRAR LA COMPRA-->
    <dialog class="midialog-xs px-8 pb-8" id="miDialogoRegistrarcompra">
        <div>
            <p class="text-3xl font-semibold text-gray-500">Desea registrar la compra?</p>
            <p class="text-xl text-gray-500">El pedido de compra No: 34512 se guardara en sistema.</p>
        </div>
        <div id="" class="flex justify-around border-t-gray-300 pt-4">
            <div class="sicomprar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Si</p></div>
            <div class="nocomprar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">No</p></div>
        </div>
    </dialog>

</div>