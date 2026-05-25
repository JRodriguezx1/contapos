<div class="box preciosXCliente !pb-10">
   <a href="/admin/clientes" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>
  <div class="w-full md:w-4/5 mx-auto rounded-lg shadow-lg px-6 pt-8">
    <h4 class=" text-gray-700 font-semibold"><?php echo $cliente->nombre.' '.$cliente->apellido;?></h4>

    <form id="formAddProducto" class="formulario" action="/" method="POST">
      <div class="border-b border-gray-900/10 pb-10 mb-3">
        <p class="mt-2 text-xl text-gray-600">Precios de venta personalizados por clinete</p>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          
          <input id="idcliente" type="hidden" value="<?php echo $cliente->id;?>">
          
          <div class="sm:col-span-4">
            <label for="productos" class="block text-2xl font-medium text-gray-600">Productos</label>
            <div class="mt-2">
              <select id="productos" name="productos" autocomplete="productos-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" multiple="multiple" required>
                <?php foreach($productos as $value): ?>
                  <option 
                    value="<?php echo $value->id;?>"
                    data-producto="<?php echo $value->nombre;?>" 
                  >
                    <?php echo $value->nombre.', Unidad: '.$value->unidadmedida;?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>


          <div class="sm:col-span-2">
            <label for="precioPersonalizado" class="block text-2xl font-medium text-gray-600">precio de venta</label>
            <div class="mt-2">
              <input id="precioPersonalizado"
                     name="precioPersonalizado"
                     type="text"
                     autocomplete="precioPersonalizado ID"
                     class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1"
                     maxlength="7"
                     oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                     required>
            </div>
          </div>
          
        </div>
      </div>

      <div class="text-right">
          <button class="btn-md btn-turquoise !py-4 !px-6 !w-[125px] salir" type="button" value="salir">Salir</button>
          <input id="btnCrearAddProducto" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[125px] crearAddSubproducto" type="submit" value="Asociar">
      </div>

      <div>
        <h5 class="mb-2 mt-4 text-slate-600 font-medium">Lista de precios personalizados</h5>
          <div class="w-full md:w-4/5 mx-auto bg-white md:px-14 pt-4 pb-14 listaProductos">
            <?php foreach($arrayPreciosPorCliente as $value): ?>
              <div id="<?php echo $value->idproducto;?>" class="mb-4 flex items-center justify-between p-4 text-blue-600 bg-blue-100 rounded-lg shadow-md shadow-blue-500/30" role="alert">
                <p class="m-0"><strong><?php echo number_format($value->precioxcliente??0, 0, ',', '.');?></strong>. - <?php echo $value->nombre;?></p>
                <button type="button"><span id="<?php echo $value->idproducto;?>" class="material-symbols-outlined">cancel</span></button>
              </div>
            <?php endforeach; ?>
          </div>
      </div>

    </form>
  </div> 

</div>