<div class="box pendienteDespacho">
  <button onclick="history.back()"  class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </button>
  <h4 class="text-gray-600 mb-8 mt-6">Ordenes pendientes de despacho</h4>
  
  <table id="tabladespachosPendientes" class="display responsive nowrap tabla" width="100%">
      <thead>
          <tr>
              <th>Fecha</th>
              <th>Orden</th>
              <th>Factura</th>
              <th>Cliente</th>
              <th>Zona</th>
              <th>Vendedor</th>
              <th>Observacion</th>
              <th>Estado</th>
              <th>Total</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($despachosPendientes as $index => $value): ?>
          <tr class="text-xl">       
              <td><div class="w-32 whitespace-normal"><?php echo $value->fechacreacion; ?></div></td> 
              <td><div class="w-16 whitespace-normal"><?php echo $value->num_orden;?></div></td>
              <td><?php echo $value->prefijo.''.$value->num_consecutivo;?></td>
              <td><div class="w-40 whitespace-normal"><?php echo $value->cliente;?></div></td>
              <td><?php echo $value->direccion;?></td>
              <td><div class="w-44 whitespace-normal"><?php echo $value->vendedor;?></div></td>
              <td><?php echo $value->observacion;?></td>
              <td>
                <div data-estado="<?php echo $value->estado;?>" id="<?php echo $value->id;?>" class="max-w-full flex flex-wrap gap-2 justify-center">
                    <button class="btn-xs <?php echo $value->estado=='Paga'?'btn-lima':'btn-indigo';?>"><?php echo $value->estado;?></button>
                </div>
              </td>
              <td>$<?php echo number_format($value->total, '0', ',', '.');?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                      <a class="btn-xs btn-turquoise" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">Abrir</a>
                  </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  
</div>