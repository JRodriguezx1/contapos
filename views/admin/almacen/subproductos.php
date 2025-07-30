<div class="box subproductos">
  <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a> 
  <h4 class="text-gray-600 mb-12 mt-4">Sub Productos</h4>
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <button id="crearSubProducto" class="btn-md btn-turquoise !py-4 !px-6 !w-auto">Crear sub producto</button>
  
  <table class="display responsive nowrap tabla" width="100%" id="tablaSubProductos">
      <thead>
          <tr>
              <th>Nº</th>
              <th>Sub Producto</th>
              <th>proveedor</th>
              <th>Sku</th>
              <th>Unidad base</th>
              <th>Precio compra</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($subproductos as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>
              <td class=""><div class="w-80 whitespace-normal"><?php echo $value->nombre;?></div></td> 
              <td class=""><?php echo $value->proveedor;?></td>
              <td class=""><?php echo $value->sku;?></td>
              <td class=""><?php echo $value->unidadmedida;?></td>
              <td class="">$<?php echo number_format($value->precio_compra, "0", ",", ".");?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                <button class="btn-md btn-turquoise editarSubProductos"><i class="fa-solid fa-pen-to-square"></i></button>
                <?php if($value->insumoprocesado == '1'): //0=comprado,   1=creado ?> 
                    <a class="btn-md btn-blue" href="/admin/almacen/componer?id=frabricado<?php echo $value->id;?>"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                <?php endif; ?>
                <button class="btn-md btn-red eliminarSubProductos"><i class="fa-solid fa-trash-can"></i></button>
            </div></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>


  <dialog class="midialog-sm p-5" id="miDialogoSubProducto">
    <h4 id="modalSubProducto" class="font-semibold text-gray-700 mb-4">Crear Subproducto</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateSubProducto" class="formulario" action="/admin/almacen/crear_subproducto" method="POST">
        
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <div class="formulario__dato">
                <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del sub-producto" id="nombre" name="nombre" value="<?php echo $subproducto->nombre??'';?>" required>
                <!-- <label data-num="46" class="count-charts" for="">46</label> -->
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="unidadmedida">Unidad de medida</label>
            <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="id_unidadmedida" id="unidadmedida" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($unidadesmedida as $unidadmedida): ?>
                <option value="<?php echo $unidadmedida->id;?>" <?php //echo $unidadmedida->id==$subproducto->idunidadmedida?'selected':'';?>><?php echo $unidadmedida->nombre;?></option>
                <?php endforeach; ?>
            </select>             
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="insumoprocesado">Insumo fabricado</label>
            <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="insumoprocesado" id="insumoprocesado" required>
                <option value="0" selected> No </option>
                <option value="1"> Si </option>
            </select>             
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="sku">SKU subProducto</label>
            <div class="formulario__dato">
                <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Codigo del subproducto" id="sku" name="sku" value="<?php echo $subproducto->sku??'';?>">
                <!-- <label data-num="15" class="count-charts" for="">15</label> -->
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="preciocompra">Precio Compra</label>
            <div class="formulario__dato">
                <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" min="0" placeholder="Precio de compra" id="preciocompra" name="precio_compra" value="<?php echo $subproducto->precio_compra??'';?>">
            </div>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="stockminimo">Stock minimo</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" min="0" placeholder="Establecer el stock minimo" id="stockminimo" name="stockminimo" value="<?php echo $subproducto->stockminimo??'';?>">      
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[180px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearSubProducto" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[180px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar producto-->
</div>