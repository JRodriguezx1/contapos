<div class="box pedidosguardados">
  <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>
  <h4 class="text-gray-600 mb-8 mt-6">Cotizaciones o pedidos guardados</h4>
  
  <table class="display responsive nowrap tabla" width="100%" id="tablaPedidosGuardados">
      <thead>
          <tr>
              <th>N.</th>
              <th>Fecha</th>
              <th>Orden</th>
              <th>Cliente</th>
              <th>Zona</th>
              <th>Vendedor</th>
              <th>Estado</th>
              <th>Subtotal</th>
              <th>Total</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($pedidosguardados as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->fechacreacion; ?></td> 
              <td class=""><?php echo $value->num_orden;?></td>
              <td class=""><?php echo $value->cliente;?></td>
              <td class="">Direccion - zona</td>
              <td class=""><?php echo $value->vendedor;?></td>
              <td>
                <div data-estado="<?php echo $value->estado;?>" id="<?php echo $value->id;?>" class="max-w-full flex flex-wrap gap-2 justify-center">
                    <button class="btn-xs btn-lima"><?php echo $value->estado;?></button>
                </div>
              </td>
              <td class="">$<?php echo number_format($value->subtotal, '0', ',', '.');?></td>
              <td class="">$<?php echo number_format($value->total, '0', ',', '.');?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                      <a class="btn-xs btn-turquoise" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">Ver</a> <button class="btn-xs btn-red eliminarPedidoGuardado"><i class="fa-solid fa-trash-can"></i></button>
                  </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  
</div>