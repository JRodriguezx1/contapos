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
                <?php foreach($productos as $index => $value):
                    if($value->visible == 1): ?>
                <tr> 
                    <td class=""><?php echo $index+1;?></td>        
                    <td class=""><?php echo $value->nombre;?></td> 
                    <td class=""><?php echo $value->impuesto;?>%</td>
                    <td class="" ><strong>$ </strong><?php echo $value->precio_compra;?></td> 
                    <td class=""><strong>$ </strong><?php echo number_format($value->precio_venta, '0', ',', '.');?></td>
                    <td class="text-blue-600 text-xl bg-blue-50 px-3 py-1.5 tracking-wide rounded-lg">$<?php echo number_format($value->precio_venta - $value->precio_compra, '0', ',', '.');?></td>
                    <td class=" flex items-center justify-center text-purple-600 text-xl bg-purple-50 px-3 py-1.5 tracking-wide rounded-lg">%<?php echo number_format((($value->precio_venta - $value->precio_compra)/$value->precio_venta)*100, '1', ',', '.')?></td>
                    <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><button class="btn-xs btn-turquoise">Mas</button></div></td>
                </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>