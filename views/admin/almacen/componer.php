<div class="box ensamblaje !pb-10">
   <a href="/admin/almacen/productos" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>
  <div class="w-full md:w-4/5 mx-auto rounded-lg shadow-lg px-6 pt-8">
    <h4 class=" text-gray-700 font-semibold"><?php echo $producto->nombre;?> - "<?php echo $producto->unidadmedida;?>"</h4>

    <form id="formAddSubproducto" class="formulario" action="/" method="POST">
      <div class="border-b border-gray-900/10 pb-10 mb-3">
        <p class="mt-2 text-xl text-gray-600">Producto compuesto de materias primas para su ensamblaje o produccion.</p>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          
          <input id="idproducto" type="hidden" value="<?php echo $producto->id;?>">
          
          <div class="sm:col-span-6">
            <label for="subproducto" class="block text-2xl font-medium text-gray-600">Subproducto</label>
            <div class="mt-2">
              <select id="subproducto" name="subproducto" autocomplete="subproducto-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" multiple="multiple" required>
                <?php foreach($subproductos as $value): ?>
                  <option 
                    value="<?php echo $value->id;?>" 
                    data-subproducto="<?php echo $value->nombre;?>" 
                    data-costo="<?php echo $value->precio_compra;?>">
                    <?php echo $value->nombre.', Unidad: '.$value->unidadmedida;?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="sm:col-span-2 md:col-span-3 tlg:col-span-2">
            <label for="unidadmedida" class="block text-2xl font-medium text-gray-600">Unidad de medida</label>
            <div class="mt-2 grid grid-cols-1">
              <select id="unidadmedida" name="unidadmedida" autocomplete="unidadmedida-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                <!-- se carga las unidades de medida del subproducto en ensamblar.ts -->
              </select>
              <!-- <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg> -->
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="cantidad" class="block text-2xl font-medium text-gray-600">Cantidad</label>
            <div class="mt-2">
              <input id="cantidad"
                     name="cantidad"
                     type="text"
                     autocomplete="cantidad ID"
                     class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                     maxlength="7"
                     oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                     required>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="rendimientoestandar" class="block text-2xl font-medium text-gray-600">Rendimiento estandar</label>
            <div class="mt-2">
              <input id="rendimientoestandar"
                     type="text"
                     autocomplete="rendimientoestandar ID"
                     class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                     maxlength="7"
                     value="<?php echo $producto->rendimientoestandar;?>"
                     oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                     required>
            </div>
          </div>
          
        </div>
      </div>

      <div class="text-right">
          <button class="btn-md btn-turquoise !py-4 !px-6 !w-[125px] salir" type="button" value="salir">Salir</button>
          <input id="btnCrearAddSubproducto" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[125px] crearAddSubproducto" type="submit" value="Asociar">
      </div>

      <div>
        <h5 class="mb-2 mt-4 text-slate-600 font-medium">Lista de insumos de produccion</h5>
          <div class="w-full md:w-4/5 mx-auto bg-white md:px-14 pt-4 pb-14 listaSubproductos">
            <?php foreach($subproductosenlazados as $value): ?>
              <div id="<?php echo $value->id_subproducto;?>" class="mb-4 flex items-center justify-between p-4 text-blue-600 bg-blue-100 rounded-lg shadow-md shadow-blue-500/30" role="alert">
                <p class="m-0"><strong><?php echo $value->cantidadsubproducto." ".$value->unidadmedida;?></strong>.  <?php echo $value->nombresubproducto;?></p>
                <button type="button"><span id="<?php echo $value->id_subproducto;?>" class="material-symbols-outlined">cancel</span></button>
              </div>
            <?php endforeach; ?>
            <!--        
            <div class="flex items-center justify-between p-4 text-blue-600 bg-blue-100 rounded-lg shadow-md shadow-blue-500/30" role="alert">
              <p class="m-0"><strong>34 Kilogramos</strong>.  Arena media de rio</p>
              <button><span class="material-symbols-outlined">cancel</span></button>
            </div>
            <div class="mt-4 flex items-center justify-between p-4 text-blue-600 bg-blue-100 rounded-lg shadow-md shadow-blue-500/30" role="alert">
              <p class="m-0"><strong>34 Kilogramos</strong>.  Arena media de rio</p>
              <button><span class="material-symbols-outlined">cancel</span></button>
            </div>-->

          </div>

      </div>
    </form>
  </div> 

</div>