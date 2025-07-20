<div class="box productos">
  <a class="btn-xs btn-dark" href="/admin/almacen">Atras</a>
  <h4 class="text-gray-600 mb-12 mt-4">Productos</h4>
  <div class="divmsjalerta0"><?php include __DIR__. "/../../templates/alertas.php"; ?></div>
  <button id="crearProducto" class="btn-md btn-blueintense mb-4">Crear producto</button>
  <a class="btn-md btn-turquoise" href="/admin/almacen/categorias">Ir a categorias</a>
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
          <?php foreach($productos as $index => $value): ?>
          <tr>
              <td class=""><?php echo $index+1;?></td>
              <td class=""><div class=" text-center "><img class="inline" style="width: 50px;" src="/build/img/<?php echo $value->foto;?>" alt=""></div></td>
              <td class=""><div class="w-80 whitespace-normal"><?php echo $value->nombre;?></div></td> 
              <td class="" ><?php echo $value->categoria;?></td>
              <td class=""><?php echo $value->marca;?></td>
              <td class=""><?php echo $value->sku;?></td>
              <td class="">$<?php echo number_format($value->precio_venta, "0", ",", ".");?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                    <button class="btn-md btn-turquoise editarProductos"><i class="fa-solid fa-pen-to-square"></i></button>
                    <?php if($value->tipoproducto == '1'): //0=simple,   1=compuesto ?> 
                        <a class="btn-md btn-blue" href="/admin/almacen/componer?id=<?php echo $value->id;?>"><i class="fa-solid fa-subscript"></i></a>
                    <?php endif; ?>
                    <button class="btn-xs btn-lima ">Mas</button>
                    <button class="btn-md btn-red eliminarProductos"><i class="fa-solid fa-trash-can"></i></button>
              </div></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <!-- MODAL PARA CREAR/ACTUALIZAR PRODUCTOS-->
  <dialog class="midialog-sm p-5" id="miDialogoProducto">
    <h4 id="modalProducto" class="font-semibold text-gray-700 mb-4">Crear producto</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateProducto" class="formulario" action="/admin/almacen/crear_producto" enctype="multipart/form-data" method="POST">
        
        <div class="formulario__campo">
            <label class="formulario__label" for="categoria">Categoria</label>
            <select class="formulario__select" name="idcategoria" id="categoria" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($categorias as $categoria): ?>
                <option value="<?php echo $categoria->id;?>" <?php echo $categoria->id==$producto->idcategoria?'selected':'';?>><?php echo $categoria->nombre;?></option>
                <?php endforeach; ?>
            </select>             
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <div class="formulario__dato">
                <input class="formulario__input" type="text" placeholder="Nombre del producto" id="nombre" name="nombre" value="<?php echo $producto->nombre??'';?>" required>
                <label data-num="46" class="count-charts" for="">46</label>
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="tipoproducto">Tipo de producto</label>
            <select class="formulario__select" id="tipoproducto" name="tipoproducto" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="0">Simple</option>
                <option value="1">Compuesto</option>
            </select>          
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="idunidadmedida">Unidad de medida</label>
            <select class="formulario__select" id="idunidadmedida" name="idunidadmedida" required>
                <?php foreach($unidadesmedida as $unidadmedida): ?>
                <option value="<?php echo $unidadmedida->id;?>" <?php echo $unidadmedida->id==$producto->idunidadmedida?'selected':'';?>><?php echo $unidadmedida->nombre;?></option>
                <?php endforeach; ?>
            </select>       
        </div>

        <div class="formulario__campo stock">
            <label class="formulario__label" for="stock">Cantidad</label>
            <div class="formulario__dato">
                <input class="formulario__input" id="stock" type="number" min="0" placeholder="Precio de venta" name="stock" value="<?php echo $producto->stock??'';?>">
            </div>
        </div>

        <div class="">
            <div class="formulario__campo preciocompra">
                <label class="formulario__label" for="preciocompra">Precio Compra</label>
                <div class="formulario__dato">
                    <input class="formulario__input" id="preciocompra" type="number" min="0" placeholder="Precio de venta" name="precio_compra" value="<?php echo $producto->precio_compra??'';?>">
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="precioventa">Precio venta</label>
                <input class="formulario__input" type="number" min="0" placeholder="Precio de venta" id="precioventa" name="precio_venta" value="<?php echo $producto->precio_venta??'';?>" required>
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="sku">SKU Producto</label>
            <div class="formulario__dato">
                <input class="formulario__input" type="text" placeholder="Codigo del producto" id="sku" name="sku" value="<?php echo $producto->sku??'';?>">
                <label data-num="36" class="count-charts" for="">36</label>
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contentinputfile formulario__contentinputfile--sm">
                <div class="formulario__imginputfile"><img id="imginputfile" src="" alt=""></div>
                <p class="text-greymouse">Subir imagen</p>
            </div>
            <input id="upImage" class="formulario__inputfile" type="file" name="foto" hidden>
            <button id="customUpImage" class="btn-xs btn-blue self-center !rounded-3xl !px-8 !py-4" type="button">Cargar Imagen</button>
        </div>
        
        <div class="accordion md:px-12 !mt-4">
            <input type="checkbox" id="first">
            <label class="etiqueta text-gray-500" for="first">Mostrar/Ocultar mas opciones</label>
            <div class="wrapper">
              <div class="wrapper-content">
                <div id="mediospagos" class="content flex flex-col w-full mx-auto">
                  
                    <div class="mb-4">
                      <div class="formulario__campo">
                        <label class="formulario__label" for="tipoproducccion">Tipo de produccion</label>
                        <select class="formulario__select" id="tipoproducccion" name="tipoproducccion" required>
                            <option value="" disabled selected>-Seleccionar-</option>
                            <option value="0">Inmediato</option>
                            <option value="1">Construccion</option>
                        </select>          
                      </div>
                      <p class="text-gray-700 text-xl">Opcion 2</p>
                      <p class="text-gray-700 text-xl">Opcion 3</p>
                      <p class="text-gray-700 text-xl">Opcion 4</p>
                      <p class="text-gray-700 text-xl">Opcion 5</p>
                    </div>
                  
                </div>
              </div>
            </div>
          </div> <!-- fin accordion  -->
        
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearProducto" class="btn-md btn-blue" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar producto-->
</div>