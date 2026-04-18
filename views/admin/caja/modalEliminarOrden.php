<!-- MODAL PARA ELIMINAR LA ORDEN-->
    <dialog class="midialog-sm px-8 pb-8" id="miDialogoEliminarOrden">
        <div>
            <p class="text-3xl font-semibold text-gray-500">Desea eliminar la orden de venta?</p>
        </div>

        <div id="divmsjalerta1"></div>

        <div class="text-center mb-4">
            <p class="mt-2 text-xl text-gray-600">Desea devolver los productos al inventario.</p>
            <div class="inline-flex border-[3px] border-indigo-600 rounded-xl select-none mb-6">  
                <label class="flex  p-1 cursor-pointer">
                    <input type="radio" name="devolverinventario" value="1" class="peer hidden"/>
                    <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 px-6 py-3 rounded-lg transition duration-300 ease-in-out text-xl"> Si </span>
                </label>
                <label class="flex  p-1 cursor-pointer">
                    <input type="radio" name="devolverinventario" value="0" class="peer hidden" checked />
                    <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 px-6 py-3 rounded-lg transition duration-300 ease-in-out text-xl"> No </span>
                </label>
            </div>

            <div class="formulario__campo md:px-12">
              <textarea 
                id="observacionEliminacion" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 focus:outline-none focus:ring-1 p-2" name="observacionEliminacion" placeholder="Observacion" rows="4"></textarea>
            </div>

            <div class="sm:col-start-2 col-span-4 mt-6">
              <label for="inputEliminarClave" class="block text-2xl font-medium text-gray-600">Ingresar Clave</label>
              <div class="mt-2">
                <input id="inputEliminarClave" type="password" min="0" class="miles bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-1/2 mx-auto p-2.5 h-14 text-xl focus:outline-none focus:ring-1" required>
              </div>
            </div>

        </div>

        <table id="productsInv" class="w-full text-xl text-left rtl:text-right text-gray-500 hidden">
            <thead class=" text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 rounded-s-lg">
                        Nombre producto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Qty
                    </th>
                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                        Devolver
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $index=>$value): ?>
                    <tr class="bg-white">
                        <td class="px-6 py-4">
                            <?php echo $value->nombreproducto??'';?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $value->cantidad??0;?>
                        </td>
                        <td class="px-6 py-4" data-qty="<?php echo $value->cantidad??0;?>">
                            <input 
                            id="<?php echo $value->idproducto;?>"
                            data-nombre="<?php echo $value->nombreproducto??'';?>"
                            data-tipoproducto = "<?php echo $value->tipoproducto;?>";
                            data-tipoproduccion = "<?php echo $value->tipoproduccion;?>";
                            data-rendimientoestandar = "<?php echo $value->rendimientoestandar;?>";
                            class="inputInv block w-full rounded-md px-3 py-1.5 text-xl text-gray-500 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600" 
                            type="text" 
                            name="" 
                            value="<?php echo $value->cantidad??0;?>" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||0)" 
                            required
                            >  
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="flex justify-around border-t-gray-300 pt-4">
            <div class="sieliminar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Confirmar</p></div>
            <div class="noeliminar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">Cancelar</p></div>
        </div>
    </dialog>