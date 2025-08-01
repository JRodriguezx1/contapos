<p class="text-xl mt-0 text-gray-600">Stock de productos</p>
<button id="reinciarinv" class="btn-md btn-turquoise !py-4 !px-6">Reiniciar inventario</button>
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
                <td class="flex items-center justify-center text-xl px-3 py-1.5 tracking-wide rounded-lg <?php echo $value->stock<=$value->stockminimo?'bg-red-300 text-white':'text-cyan-600 bg-cyan-50';?>"><?php echo $value->stock;?></td>
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
                <td class="flex items-center justify-center px-3 py-1.5 tracking-wide rounded-lg <?php echo $value->stock<=$value->stockminimo?'bg-red-300 text-white':'bg-cyan-50 text-cyan-600';?>"><?php echo $value->stock;?></td>
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
  <dialog class="midialog-sm p-5" id="miDialogoStock">
      <h4 id="modalStock" class="font-semibold text-gray-600 mb-4">Ingreasar cantidad a inventario</h4>
      <div id="divmsjalertaStock"></div>
      <form id="formStock" class="formulario" action="/" method="POST">

          
          <p id="nombreItemstockrapido" class="inline-block mt-2 px-4 py-2 text-gray-900 text-2xl font-bold self-center rounded-lg shadow-lg"></p>

          <div class="formulario__campo">
              <label class="formulario__label" for="selectStockRapidoUndmedida">Unidad de medida</label>
              <select class="formulario__select" id="selectStockRapidoUndmedida" name="selectStockRapidoUndmedida" required>
                  <option value="" disabled selected>-Seleccionar-</option>
                    <!-- se inserta por ts en almacen.ts -->
              </select>
          </div>

          <div class="formulario__campo">
              <label class="formulario__label" for="cantidadStockRapido">Cantidad</label>
              <div class="formulario__dato">
                  <input class="formulario__input" id="cantidadStockRapido" type="number" min="0" placeholder="Precio de venta" name="cantidadStockRapido" value="" required>
              </div>
          </div>

          <div class="text-right">
              <button class="btn-md btn-red" type="button" value="salir">Salir</button>
              <input id="btnAjusteStock" class="btn-md btn-blue" type="submit" value="Confirmar">
          </div>
      </form>
  </dialog>