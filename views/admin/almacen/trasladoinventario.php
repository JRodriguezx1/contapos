<div class="box trasladoinventario p-10 !pb-20 rounded-lg mb-4">
    <div>
        <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <span class="sr-only">Atrás</span>
        </a>
        <h4 class="text-gray-600 mb-12 mt-4">Traslado de inventario</h4>
        <?php include __DIR__. "/../../templates/alertas.php"; ?>
        <form id="formComprar" action="">
            <div class="border-b border-gray-900/10 pb-10 mb-3">
            
                <p class="mt-2 text-xl text-gray-600">Traslado de inventario entre sucursales.</p>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8">
                
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
                            <th>V. total</th>
                            <th class="accionesth text-red-500"><i class="fa-solid fa-x"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div> <!-- FIn Apilamiento de productos -->

            <div class="text-right">
                <button id="btnvaciar" class="btn-md btn-turquoise !py-4 !px-6 !w-[136px] vaciar" type="button" value="vaciar">Vaciar</button>
                <input id="btnRegistrarCompra" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px] registrarCompra" type="submit" value="Trasladar">
            </div>
        </form>

        <!-- INFORMACION FINAL DE LA COMPRA-->
        <div>
            <div class="flex justify-start gap-4 mt-6">
                <div class="text-end">
                    <p class="m-0 mb-2 text-slate-600 text-3xl font-semibold">Total:</p>
                </div>
                <div>
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