<div class="box inventarioxproducto">
  <a class="btn-xs btn-" href="/admin/reportes">Atras</a>
  <h4 class="text-gray-600 mb-8 mt-4">Inventario por producto</h4>
  
  <div>
    <table id="tablaStockRapido" class="display responsive nowrap tabla" width="100%">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Producto</th>
                <th>Categoria</th>
                <th>tipo</th>
                <th>Stock</th>
                <th>Unidad</th>
                <th>Agregado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $index => $value): ?>
                
                <tr class="fila producto" data-idproducto="<?php echo $value->productoid;?>"> 
                    <td class=""><?php echo $index+1;?></td>
                    <td class=""><div class="w-80 whitespace-normal"><?php echo $value->nombre;?></div></td> 
                    <td class="" ><?php echo $value->categoria;?></td>
                    <td class="" ><?php echo $value->tipoproducto==1?'Compuesto':'Simple';?></td>
                    <td class=""><div class="text-center px-3 py-4 rounded-lg <?php echo $value->stock<=$value->stockminimo?'text-red-800 bg-red-50':'text-cyan-600 bg-cyan-50';?>"><?php echo $value->stock;?></div></td>
                    <td class=""><?php echo $value->unidadmedida;?></td>
                    <td class=""><?php echo $value->fecha_ingreso;?></td>
                </tr>
                
            <?php endforeach; ?>

            <!-- subproductos -->
            <?php foreach($subproductos as $index => $value): ?>  
                <tr class="fila subproducto" data-idsubproducto="<?php echo $value->subproductoid;?>"> 
                    <td class=""><?php echo $index+1;?></td>
                    <td class=""><div class="w-80 whitespace-normal">* <?php echo $value->nombre;?></div></td> 
                    <td class="" ><?php echo $value->categoria??'';?></td>
                    <td class="" >Insumo</td>
                    <td class=""><div class="text-center px-3 py-4 rounded-lg <?php echo $value->stock<=$value->stockminimo?'text-red-800 bg-red-50':'text-cyan-600 bg-cyan-50';?>"><?php echo $value->stock;?></div></td>
                    <td class=""><?php echo $value->unidadmedida;?></td>
                    <td class=""><?php echo $value->fecha_ingreso;?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  </div>

</div>