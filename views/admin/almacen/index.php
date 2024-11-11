<div class="box tlg:h-full flex flex-col almacen">
  <h4 class="text-gray-600 mb-12">Almacen</h4>
  <div class="flex flex-wrap gap-4 mb-4">
        <a class="btn-command" href="/admin/almacen/categorias"><span class="material-symbols-outlined">tv_options_edit_channels</span>Categorias</a>
        <a class="btn-command" href="/admin/almacen/productos"><span class="material-symbols-outlined">grid_view</span>Productos</a>
        <button class="btn-command"><span class="material-symbols-outlined">attach_money</span>Ajustar costos</button>
        <button class="btn-command"><span class="material-symbols-outlined">pallet</span>Compras</button>
        <button class="btn-command"><span class="material-symbols-outlined">linked_services</span>Distribucion</button>
        <button class="btn-command"><span class="material-symbols-outlined">inventory</span>Inventariar</button>
  </div>

  <div class="tlg:flex flex-1 tlg:overflow-hidden accordion_inv">
    <input type="radio" name="radio" id="stockproducto" checked>
    <input type="radio" name="radio" id="utilidadproducto">

    <div class="text-center border border-gray-300 p-3 tlg:w-36 btn_inv_info_rapido">
      <span class="text-xl text-gray-600">Informacion Productos</span>
      <div>
        <label class="btn-xs btn-dark mt-4 btnstockproducto" for="stockproducto">Stock Rapido</label>
        <label class="btn-xs btn-dark mt-4 btnutilidadproducto" for="utilidadproducto">Utilidad Producto</label>
        <label class="btn-xs btn-dark mt-4 tlg:!w-full sedes" for="sedes">Sedes</label> 
      </div>
    </div>
    
    <div class="flex-1 tlg:overflow-y-scroll tlg:pl-4 tablas_inv_rapido">
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
                <tr> 
                    <td class=""><?php echo $index+1;?></td>        
                    <td class=""><?php echo $value->nombre;?></td> 
                    <td class="" ><?php echo $value->categoria;?></td> 
                    <td class=""><?php echo $value->stock;?></td>
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
                    <th>Porcentaje utilidad</th>
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
                    <td class="">$<?php echo $value->precio_venta;?><?php // echo $value->movil;?></td>
                    <td class="">$272000<?php // echo $value->movil;?></td>
                    <td class="">$66%<?php // echo $value->movil;?></td>
                    <td class="">101%<?php // echo $value->movil;?></td>
                    <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><button class="btn-xs btn-turquoise">Mas</button></div></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div> <!-- fin tablautilidad-->
    </div>

  </div> <!-- fin accordion_inv -->

</div>