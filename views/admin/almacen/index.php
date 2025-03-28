<div class="box tlg:h-full flex flex-col almacen">
  <h4 class="text-gray-600 mb-12">Almacen</h4>
  <div class="flex flex-wrap gap-4 mb-4">
        <a class="btn-command" href="/admin/almacen/categorias"><span class="material-symbols-outlined">tv_options_edit_channels</span>Categorias</a>
        <a class="btn-command" href="/admin/almacen/productos"><span class="material-symbols-outlined">grid_view</span>Productos</a>
        <a class="btn-command text-center" href="/admin/almacen/subproductos"><span class="material-symbols-outlined">landscape</span>Sub Productos</a>
        <!--<a class="btn-command" href="/admin/almacen/componer"><span class="material-symbols-outlined">precision_manufacturing</span>Componer</a>-->
        <a class="btn-command text-center" href="/admin/almacen/ajustarcostos"><span class="material-symbols-outlined">attach_money</span>Ajustar costos</a>
        <a class="btn-command" href="/admin/almacen/compras"><span class="material-symbols-outlined">pallet</span>Compras</a>
        <!--<a class="btn-command" href="/admin/almacen/distribucion"><span class="material-symbols-outlined">linked_services</span>Distribucion</a>-->
        <a class="btn-command" href="/admin/almacen/inventariar"><span class="material-symbols-outlined">inventory</span>Inventariar</a>
        <a class="btn-command text-center" href="/admin/almacen/unidadesmedida"><span class="material-symbols-outlined">square_foot</span>Unidades de medida</a>
  </div>

  <div class="tlg:flex flex-1 tlg:overflow-hidden accordion_inv">
    <input type="radio" name="radio" id="infoalmacen" checked>
    <input type="radio" name="radio" id="stockproducto">
    <input type="radio" name="radio" id="utilidadproducto">

    <div class="text-center border border-gray-300 p-3 tlg:w-40 btn_inv_info_rapido">
      <span class="text-xl text-gray-600">Informacion Inventario</span>
      <div>
        <label class="btn-xs btn-dark mt-4 btninfoalmacen" for="infoalmacen">Inform... Almacen</label>
        <label class="btn-xs btn-dark mt-4 btnstockproducto" for="stockproducto">Stock Rapido</label>
        <label class="btn-xs btn-dark mt-4 btnutilidadproducto" for="utilidadproducto">Utilidad Producto</label>
        <label class="btn-xs btn-dark mt-4 tlg:!w-full sedes" for="sedes">Sedes</label>
        <label class="btn-xs btn-dark mt-4 tlg:!w-full proveedores" for="proveedores">Proveedores</label> 
      </div>
    </div>
    
    <div class="flex-1 tlg:overflow-y-scroll tlg:pl-4 tablas_inv_rapido">
      
      <div class="infoalmacen accordion_tab_content py-4">
        <!--<div class="flex flex-wrap gap-10">
          <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">$25.180.460</p>Valor inventario</div>
          <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">621</p>Total de productos</div>
          <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">62</p>Total de referencias</div>
          <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">8</p>Categorias</div>
          <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">14</p>Productos con bajo stock</div>
          <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">9</p>Productos agotados</div>
        </div> -->
        
          <div class="pt-12 bg-gray-50 dark:bg-gray-900 sm:pt-20">
            
            <div class="max-w-4xl mx-auto text-center">
              <h2 class="text-3xl font-extrabold leading-9 text-gray-900 dark:text-white sm:text-4xl sm:leading-10">
                Tablero de indicadores
              </h2>
              <p class="mt-3 text-xl leading-7 text-gray-600 dark:text-gray-400 sm:mt-4">
                Informacion de los principales indicadores de inventario del almacen.
              </p>
            </div>
            
            <div class="pb-12 mt-10 bg-gray-50 dark:bg-gray-900 sm:pb-16">
               
              <div class="max-w-6xl mx-auto">
                <dl class="bg-white dark:bg-gray-800 rounded-lg shadow-lg sm:grid sm:grid-cols-3">
                  <div class="flex flex-col p-6 text-center border-b border-gray-100 dark:border-gray-700 sm:border-0 sm:border-r">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400" id="item-1">
                      Valor inventario
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      aria-describedby="item-1" id="starsCount">
                      $<?php echo $valorInv;?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-b border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l sm:border-r">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Cantidad de productos
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="downloadsCount">
                      <?php echo number_format($cantidadProductos??0, "0", ",", ".");?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Cantidad de referencias
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      <?php echo number_format($cantidadReferencias??0, "0", ",", ".");?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Categorias
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      0.5
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Productos con bajo stock
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      <?php echo number_format($bajoStock??0, "0", ",", ".");?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Productos agotados
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      <?php echo number_format($productosAgotados??0, "0", ",", ".");?>
                    </dd>
                  </div>
                </dl>
              </div>
                 
            </div>
          </div>
      </div>  <!-- fin tablero indicaderos -->

      <div class="tablastock accordion_tab_content">
        <p class="text-xl mt-0 text-gray-600">Stock de productos</p>
        <table class="display responsive nowrap tabla" width="100%" id="">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Producto</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Agregado</th>
                    <th class="accionesth">Acciones</th>
                </tr>
                
            </thead>
            <tbody>
                <?php foreach($productos as $index => $value): ?>
                  <?php if($value->tipoproducto == '0'): ?>  <!-- productos simple -->
                  <tr> 
                      <td class=""><?php echo $index+1;?></td>        
                      <td class=""><?php echo $value->nombre;?></td> 
                      <td class="" ><?php echo $value->categoria;?></td> 
                      <td class="flex items-center justify-center text-cyan-600 text-xl bg-cyan-50 px-3 py-1.5 tracking-wide rounded-lg"><?php echo $value->stock;?></td>
                      <td class=""><?php echo $value->fecha_ingreso;?></td>
                      <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><button class="btn-xs btn-turquoise">Ver</button></div></td>
                  </tr>
                  <?php endif; ?>
                <?php endforeach; ?>

                <!-- subproductos -->
                <?php foreach($subproductos as $index => $value): ?>  
                  <tr> 
                      <td class=""><?php echo $index+1;?></td>        
                      <td class="">* <?php echo $value->nombre;?></td> 
                      <td class="" ><?php echo $value->categoria??'';?></td> 
                      <td class="flex items-center justify-center text-cyan-600 text-xl bg-cyan-50 px-3 py-1.5 tracking-wide rounded-lg"><?php echo $value->stock;?></td>
                      <td class=""><?php echo $value->fecha_ingreso;?></td>
                      <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><button class="btn-xs btn-turquoise">Ver</button></div></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div> <!-- fin <div class="stockproductos"> -->

      <!-- utilidad -->
      <div class="tablautilidad accordion_tab_content">
        <p class="text-xl mt-0 text-gray-600">Utilidad de los productos</p>
        <table class="display responsive nowrap tabla" width="100%" id="">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Producto</th>
                    <th>impuesto</th>
                    <th>Costo</th>
                    <th>Precio venta</th>
                    <th>Utilidad</th>
                    <th>Rentabilidad</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $index => $value): ?>
                <tr> 
                    <td class=""><?php echo $index+1;?></td>        
                    <td class=""><?php echo $value->nombre;?></td> 
                    <td class=""><?php echo $value->impuesto;?>%</td>
                    <td class="" >$<?php echo $value->precio_compra;?></td> 
                    <td class="">$<?php echo number_format($value->precio_venta, '0', ',', '.');?></td>
                    <td class="text-blue-600 text-xl bg-blue-50 px-3 py-1.5 tracking-wide rounded-lg">$<?php echo number_format($value->precio_venta - $value->precio_compra, '0', ',', '.');?></td>
                    <td class=" flex items-center justify-center text-purple-600 text-xl bg-purple-50 px-3 py-1.5 tracking-wide rounded-lg">%<?php echo number_format((($value->precio_venta - $value->precio_compra)/$value->precio_venta)*100, '1', ',', '.')?></td>
                    <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><button class="btn-xs btn-turquoise">Mas</button></div></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div> <!-- fin tablautilidad-->
    </div>

  </div> <!-- fin accordion_inv -->

</div>