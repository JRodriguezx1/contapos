<!-- MODAL PARA ELIMINAR LA ORDEN-->
    <dialog class="midialog-sm px-8 pb-8" id="miDialogoEliminarOrden">
        <div class="text-center border-b border-gray-200 pb-6 mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 my-4">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-3xl"></i>
            </div>

            <h2 class="text-3xl font-bold text-red-600">
                Eliminar Orden de Venta
            </h2>

            <p class="mt-2 text-lg text-gray-500">
                Esta acción no se puede deshacer.
            </p>
        </div>

        <div id="divmsjalerta1"></div>

        <div class="text-center mb-4">
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5 mb-6">
                <h3 class="text-xl font-semibold text-indigo-700 mb-3">
                    Inventario
                </h3>

                <p class="text-gray-600 mb-4">
                    ¿Desea devolver los productos al inventario?
                </p>

                <div class="inline-flex border-[3px] border-indigo-600 rounded-xl select-none">

                    <label class="flex p-1 cursor-pointer">
                        <input type="radio" name="devolverinventario" value="1" class="peer hidden"/>
                        <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 px-6 py-3 rounded-lg transition duration-300 ease-in-out text-xl">
                            Si
                        </span>
                    </label>

                    <label class="flex p-1 cursor-pointer">
                        <input type="radio" name="devolverinventario" value="0" class="peer hidden" checked />
                        <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 px-6 py-3 rounded-lg transition duration-300 ease-in-out text-xl">
                            No
                        </span>
                    </label>
                </div>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-6">
                <label
                    for="observacionEliminacion"
                    class="block text-xl font-semibold text-slate-700 mb-3">

                    Motivo de la eliminación
                </label>

                <textarea
                    id="observacionEliminacion"
                    class="bg-white border border-slate-300 text-gray-900 rounded-xl focus:border-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-200 p-3 w-full"
                    name="observacionEliminacion"
                    placeholder="Indique el motivo por el cual se elimina la orden"
                    rows="4"></textarea>
            </div>

            <div class="bg-red-50 border border-red-100 rounded-2xl p-5 mb-6">
                <label
                    for="inputEliminarClave"
                    class="block text-xl font-semibold text-red-700 mb-3">

                    Confirmación de seguridad
                </label>

                <p class="text-gray-500 mb-4">
                    Ingrese la clave para confirmar la eliminación de la orden.
                </p>

                <input
                    id="inputEliminarClave"
                    type="password"
                    min="0"
                    class="bg-white border border-red-200 text-gray-900 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 block w-full p-3 h-14 text-xl focus:outline-none"
                    placeholder="Ingrese la clave"
                    required>
            </div>
        </div>

        <div id="productsInv" class="rounded-2xl border border-slate-200 overflow-hidden shadow-sm mt-6 hidden animate-fadeIn">
            <div class="bg-slate-50 px-5 py-4 border-b border-slate-200">
                <h3 class="text-xl font-semibold text-slate-700">
                    Productos a devolver
                </h3>
            </div>

            <table id="" class="w-full text-xl text-left rtl:text-right text-gray-500">

                <thead class="bg-slate-50 text-slate-700 uppercase">
                    <tr>
                        <th scope="col" class="px-6 py-4">
                            Nombre producto
                        </th>

                        <th scope="col" class="px-6 py-4 text-center">
                            Qty
                        </th>

                        <th scope="col" class="px-6 py-4 text-center">
                            Devolver
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($productos as $index=>$value): ?>
                        <tr class="bg-white border-t border-slate-100 hover:bg-slate-50 transition-colors">

                            <td class="px-6 py-3 font-medium text-slate-700">
                                <?php echo $value->nombreproducto??'';?>
                            </td>

                            <td class="px-6 py-3 text-center font-semibold text-indigo-600">
                                <?php echo $value->cantidad??0;?>
                            </td>

                            <td class="px-6 py-3" data-qty="<?php echo $value->cantidad??0;?>">

                                <input
                                    id="<?php echo $value->idproducto;?>"
                                    data-nombre="<?php echo $value->nombreproducto??'';?>"
                                    data-tipoproducto="<?php echo $value->tipoproducto;?>"
                                    data-tipoproduccion="<?php echo $value->tipoproduccion;?>"
                                    data-rendimientoestandar="<?php echo $value->rendimientoestandar;?>"
                                    data-promediostock="<?php echo $value->promediostock;?>"
                                    class="inputInv block w-full rounded-xl px-3 py-2 text-lg text-gray-700 border border-slate-300 bg-white focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 focus:outline-none"
                                    type="text"
                                    name=""
                                    value="<?php echo $value->cantidad??0;?>"
                                    oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||0)"
                                    required>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <button
                type="button"
                class="noeliminar btn-md btn-md btn-indigo !py-4 !px-6 !w-[140px]">
                Cancelar
            </button>

            <button
                type="button"
                class="sieliminar btn-md bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl !py-4 !px-6 !w-[140px] transition">
                <i class="fa-solid fa-trash mr-2"></i>
                Eliminar
            </button>
        </div>
    </dialog>