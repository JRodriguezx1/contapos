<p class="text-xl mt-0 text-gray-600">Stock de productos</p>
<div class="flex items-center gap-2 bg-white text-gray-800 font-semibold text-2xl rounded-md border border-gray-300 shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400 !mb-4 !py-4 px-6 !w-[200px]">
    <i class="fas fa-sync-alt text-2xl text-gray-600"></i>
    <button id="reinciarinv" class="text-2xl text-gray-600">Reiniciar Inventario</button>
</div>
<table id="tablaStockRapido" class="display responsive nowrap tabla" width="100%" id="">
    <thead>
        <tr>
            <th>Nº</th>
            <th>Producto</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Unidad</th>
            <th>Agregado</th>
            <th class="accionesth">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($productos as $index => $value): ?>
            <?php if($value->tipoproducto == '0'): ?>  <!-- productos simple -->
            <tr class="fila producto" data-idproducto="<?php echo $value->id;?>"> 
                <td class=""><?php echo $index+1;?></td>
                <td class=""><div class="w-96 whitespace-normal"><?php echo $value->nombre;?></div></td> 
                <td class="" ><?php echo $value->categoria;?></td>
                <td class="flex items-center justify-center text-xl px-3 !p-[1.2rem] tracking-wide rounded-lg <?php echo $value->stock<=$value->stockminimo?'p-4 mb-4 text-red-800 bg-red-50':'text-cyan-600 bg-cyan-50';?>"><?php echo $value->stock;?></td>
                <td class=""><?php echo $value->unidadmedida;?></td>
                <td class=""><?php echo $value->fecha_ingreso;?></td>
                <td class="accionestd">
                <div class="acciones-btns btnsproducto" id="<?php echo $value->id;?>" data-nombre="<?php echo $value->nombre;?>" data-stock="<?php echo $value->stock;?>">
                    <button class="btn-xs btn-bluelight descontarStock"><i class="fa-solid fa-minus"></i></button>
                    <button class="btn-xs btn-blue aumentarStock"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn-xs btn-turquoise ajustarStock"><i class="fa-solid fa-wrench"></i></button>
                </div></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- subproductos -->
        <?php foreach($subproductos as $index => $value): ?>  
            <tr class="fila subproducto" data-idsubproducto="<?php echo $value->id;?>"> 
                <td class=""><?php echo $index+1;?></td>
                <td class=""><div class="w-96 whitespace-normal">* <?php echo $value->nombre;?></div></td> 
                <td class="" ><?php echo $value->categoria??'';?></td> 
                <td class="flex items-center justify-center px-3 py-1.5 tracking-wide rounded-lg <?php echo $value->stock<=$value->stockminimo?'p-4 mb-4 text-red-800 bg-red-50':'text-cyan-600 bg-cyan-50';?>"><?php echo $value->stock;?></td>
                <td class=""><?php echo $value->unidadmedida;?></td>
                <td class=""><?php echo $value->fecha_ingreso;?></td>
                <td class="accionestd">
                <div class="acciones-btns btnssubproducto" id="<?php echo $value->id;?>" data-nombre="<?php echo $value->nombre;?>" data-stock="<?php echo $value->stock;?>">
                    <button class="btn-xs btn-bluelight descontarStock"><i class="fa-solid fa-minus"></i></button>
                    <button class="btn-xs btn-blue aumentarStock"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn-xs btn-turquoise ajustarStock"><i class="fa-solid fa-wrench"></i></button>
                </div></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- MODAL PARA AJUSTAR SUMAR, PRODUCIR O DESCONTAR UNUDADES-->
  <dialog class="midialog-sm !p-12" id="miDialogoStock">
      <h4 id="modalStock" class="font-semibold text-gray-600 mb-4">Ingreasar cantidad a inventario</h4>
      <div id="divmsjalertaStock"></div>
      <form id="formStock" class="formulario" action="/" method="POST">

          
          <p id="nombreItemstockrapido" class="inline-block mt-2 px-4 py-2 text-gray-900 text-2xl font-bold self-center rounded-lg shadow-lg"></p>

          <div class="formulario__campo">
              <label class="formulario__label" for="selectStockRapidoUndmedida">Unidad de medida</label>
              <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="selectStockRapidoUndmedida" name="selectStockRapidoUndmedida" required>
                  <option value="" disabled selected>-Seleccionar-</option>
                    <!-- se inserta por ts en almacen.ts -->
              </select>
          </div>

          <div class="formulario__campo">
              <label class="formulario__label" for="cantidadStockRapido">Cantidad</label>
              <div class="formulario__dato">
                  <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="cantidadStockRapido" type="number" min="0" placeholder="Precio de venta" name="cantidadStockRapido" value="" required>
              </div>
          </div>

          <div class="text-right">
              <button class="btn-md btn-turquoise !py-4 !px-6 !w-[140px]" type="button" value="salir">Salir</button>
              <input id="btnAjusteStock" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[140px]" type="submit" value="Confirmar">
          </div>
      </form>
  </dialog>