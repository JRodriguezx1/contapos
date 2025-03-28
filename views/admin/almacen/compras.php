<div class="box compras">
    <div>
        <a class="btn-xs btn-dark" href="/admin/almacen">Atras</a>
        <h4 class="text-gray-600 mb-12 mt-4">Compras</h4>
        <?php include __DIR__. "/../../templates/alertas.php"; ?>
        <form id="formComprar" action="">
            <div class="border-b border-gray-900/10 pb-10 mb-3">
            
                <p class="mt-2 text-xl text-gray-600">Ingreso Almacen.</p>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-7">

                    <div class="sm:col-span-3">
                        <label for="proveedor" class="block text-2xl font-medium text-gray-600">Proveedor</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="proveedor" name="proveedor" autocomplete="proveedor-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <option value="1">Predeterminado</option>
                                <option value="2">Makro tech</option>
                                <option value="3">CelMax</option>
                                <option value="4">Argos</option>
                                <option value="5">Electro house</option>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-1 md:col-span-2 tlg:col-span-1">
                        <label for="impuesto" class="block text-2xl font-medium text-gray-600">Impuesto</label>
                        <div class="mt-2">
                        <input id="inputimpuesto" name="impuesto" type="text" autocomplete="impuesto ID" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
                        </div>
                    </div>

                    <div class="sm:col-span-1 md:col-span-2 tlg:col-span-1">
                        <label for="factura" class="block text-2xl font-medium text-gray-600">N° Factura</label>
                        <div class="mt-2">
                            <input type="text" name="factura" id="nfactura" autocomplete="family-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="fecha" class="block text-2xl font-medium text-gray-600">Fecha</label>
                        <div class="mt-2">
                            <input type="date" name="fecha" id="fecha" autocomplete="family-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="origen" class="block text-2xl font-medium text-gray-600">Origen</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="origenPago" name="origen" autocomplete="origen-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <?php foreach($cajas as $value): ?>
                                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                                <?php endforeach; ?>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-2 md:col-span-3 tlg:col-span-2">
                        <label for="formapago" class="block text-2xl font-medium text-gray-600">Forma de pago</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="formapago" name="formapago" autocomplete="formapago-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
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
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-3 md:col-span-7 tlg:col-span-3">
                        <label for="observacion" class="block text-2xl font-medium text-gray-600">Observacion</label>
                        <div class="mt-2">
                        <input id="observacion" name="observacion" type="text" autocomplete="observacion ID" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="mb-4 md:w-1/2">
                <label for="articulo" class="block text-2xl font-medium text-gray-600">Articulo</label>
                <div class="mt-2 grid grid-cols-1">
                    <select id="articulo" name="articulo" autocomplete="articulo-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" multiple="multiple" required>
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
                <button id="btnvaciar" class="btn-md btn-red vaciar" type="button" value="vaciar">Vaciar</button>
                <input id="btnRegistrarCompra" class="btn-md btn-blue registrarCompra" type="submit" value="Regsitrar">
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