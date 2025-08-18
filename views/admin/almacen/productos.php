<div class="box productos">
  
  <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>

  <h4 class="text-gray-600 mb-12 mt-4">Productos</h4>
  <div class="divmsjalerta0"><?php include __DIR__. "/../../templates/alertas.php"; ?></div>
  
  <div class="flex flex-wrap gap-2">
    <button id="crearProducto" class="btn-md btn-blueintense mb-4 !py-4 px-6 !bg-indigo-600">Crear producto</button>
    <a class="btn-md btn-turquoise mb-4 !py-4 !px-6" href="/admin/almacen/categorias">Ir a categorias</a>
    <form action="/admin/almacen/downexcelproducts" method="POST">
        <button class="btn-md btn-light mb-4 !py-2 !px-4" name="downexcel" title="Descargar en excel"><span class="material-symbols-outlined text-[24px] leading-none">download</span></button>
    </form>
  </div>

  <table class="display responsive nowrap tabla" width="100%" id="tablaProductos">
      <thead>
          <tr>
              <th>Nº</th>
              <th>Imagen</th>
              <th>Producto</th>
              <th>Categoria</th>
              <th>Marca</th>
              <th>Codigo</th>
              <th>Precio venta</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($productos as $index => $value): 
            if($value->visible == 1):?>
          <tr>
              <td class=""><?php echo $index+1;?></td>
              <td class=""><div class=" text-center "><img class="inline" style="width: 50px;" src="/build/img/<?php echo $value->foto;?>" alt=""></div></td>
              <td class=""><div class="w-80 whitespace-normal"><?php echo $value->nombre;?></div></td> 
              <td class="" ><?php echo $value->categoria;?></td>
              <td class=""><?php echo $value->marca;?></td>
              <td class=""><?php echo $value->sku;?></td>
              <td class="">$<?php echo number_format($value->precio_venta, "0", ",", ".");?></td>
              <td class="accionestd"><div class="acciones-btns my-[0.7rem]" id="<?php echo $value->id;?>">
                    <?php if($value->tipoproducto == '1'): //0=simple,   1=compuesto ?> 
                        <a class="btn-xs btn-blue" title="Agregar Materia Prima" href="/admin/almacen/componer?id=<?php echo $value->id;?>"><i class="fa-solid fa-subscript text-[17px] leading-none"></i></a>
                    <?php endif; ?>
                    <button class="btn-xs btn-lima" title="Más opciones"><i class="fa-solid fa-circle-plus text-[17px] leading-none"></i></button>
                    <button class="btn-xs btn-turquoise editarProductos" title="Actualizar Producto"><i class="fa-solid fa-pen-to-square text-[17px] leading-none"></i></button>
                    <button class="btn-xs <?php echo $value->estado?'btn-light':'btn-orange';?> bloquearProductos" title="Bloquear Producto"><span class="material-symbols-outlined text-[18px] leading-none">hide_source</span></button>
                    <button class="btn-xs btn-red eliminarProductos" title="Eliminar Producto"><i class="fa-solid fa-trash-can text-[17px] leading-none"></i></button>
              </div></td>
          </tr>
          <?php endif; endforeach; ?>
      </tbody>
  </table>

  <!-- MODAL PARA CREAR/ACTUALIZAR PRODUCTOS-->
  <dialog id="miDialogoProducto" class="midialog-sm p-5">
    <h4 id="modalProducto" class="font-semibold text-gray-700 mb-4">Crear producto</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateProducto" class="formulario" action="/admin/almacen/crear_producto" enctype="multipart/form-data" method="POST">
        
        <div class="formulario__campo">
            <label class="formulario__label" for="categoria">Categoria</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="idcategoria" id="categoria" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($categorias as $categoria): ?>
                <option value="<?php echo $categoria->id;?>" <?php echo $categoria->id==$producto->idcategoria?'selected':'';?>><?php echo $categoria->nombre;?></option>
                <?php endforeach; ?>
            </select>             
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del producto" id="nombre" name="nombre" value="<?php echo $producto->nombre??'';?>" required>
                <!--<label data-num="46" class="count-charts" for="">46</label>-->
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="tipoproducto">Tipo de producto</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="tipoproducto" name="tipoproducto" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="0">Simple</option>
                <option value="1">Compuesto</option>
            </select>          
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="idunidadmedida">Unidad de medida</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="idunidadmedida" name="idunidadmedida" required>
                <?php foreach($unidadesmedida as $unidadmedida): ?>
                <option value="<?php echo $unidadmedida->id;?>" <?php echo $unidadmedida->id==$producto->idunidadmedida?'selected':'';?>><?php echo $unidadmedida->nombre;?></option>
                <?php endforeach; ?>
            </select>  
        </div>

        <div class="formulario__campo stock">
            <label class="formulario__label" for="stock">Cantidad</label>
            <div class="formulario__dato">
                <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="stock" type="number" min="0" step="0.01" placeholder="Precio de venta" name="stock" value="<?php echo $producto->stock??'';?>">
            </div>
        </div>

        <div class="formulario__campo preciocompra">
            <label class="formulario__label" for="preciocompra">Precio compra</label>
            <div class="formulario__dato">
                <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="preciocompra" type="number" min="0" step="0.01" placeholder="Precio de venta" name="precio_compra" value="<?php echo $producto->precio_compra??'';?>">
            </div>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="precioventa">Precio venta incluido impuesto</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" min="0" placeholder="Precio de venta incluido el impuesto" id="precioventa" name="precio_venta" value="<?php echo $producto->precio_venta??'';?>" required>
        </div>
        
        <div class="formulario__campo">
            <label class="formulario__label" for="sku">SKU Producto</label>
            <div class="formulario__dato">
                <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Codigo del producto" id="sku" name="sku" value="<?php echo $producto->sku??'';?>">
                <!--<label data-num="36" class="count-charts" for="">36</label>-->
            </div>
        </div>

        <div class="formulario__campo habtipoproduccion" style="display: none;">
            <label class="formulario__label" for="tipoproduccion">Tipo de produccion</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="tipoproduccion" name="tipoproduccion">
                <option disabled selected>-Seleccionar-</option>
                <option value="0">Inmediato</option>
                <option value="1">Construccion</option>
            </select>          
        </div>

         <div class="formulario__campo">
            <label class="formulario__label" for="impuesto">Impuesto</label>
            <div class="formulario__dato">
                <input 
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" 
                    type="text" placeholder="Impuesto del producto en %" 
                    id="impuesto" 
                    name="impuesto" 
                    value=""
                    oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, '')|| 0"
                >
            </div>
        </div>

        <div class="formulario__campo">
            <div class="formulario__contentinputfile formulario__contentinputfile--sm">
                <div class="formulario__imginputfile"><img id="imginputfile" src="" alt=""></div>
                <p class="text-greymouse">Subir imagen</p>
            </div>
            <input id="upImage" class="formulario__inputfile" type="file" name="foto" hidden>
            <button id="customUpImage" class="text-white bg-gradient-to-br from-indigo-700 to-[#00CFCF] hover:bg-gradient-to-bl hover:from-[#00CFCF] hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-[#99fafa] dark:focus:ring-[#0a8a8a] font-medium rounded-lg text-sm px-5 py-2.5 text-center !w-[23%] !mx-auto mb-2" type="button">Cargar Imagen</button>
        </div>
        
        <div class="accordion md:px-12 !mt-4">
            <input type="checkbox" id="first">
            <label class="etiqueta text-gray-500" for="first">Mostrar/Ocultar mas opciones</label>
            <div class="wrapper">
              <div class="wrapper-content">
                <div id="mediospagos" class="content flex flex-col w-full mx-auto">  
                    <div class="mb-4">
                      <div class="formulario__campo">
                        <label class="formulario__label" for="stockminimo">Stock minimo</label>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" min="0" step="0.01" placeholder="Establecer el stock minimo" id="stockminimo" name="stockminimo" value="<?php echo $producto->stockminimo??'';?>">      
                      </div>  
                    </div>
                </div>
              </div>
            </div>
        </div> <!-- fin accordion  -->
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[180px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearProducto" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[180px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar producto-->
</div>