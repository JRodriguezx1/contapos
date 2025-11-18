<div class="mediosPagos">

  <h4 class="text-gray-600 mb-8 mt-12">Gestion de medios de pago</h4>
  <button id="crearMedioPago" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[144px]">Crear medio de pago</button>
  <table id="tablamediosPagos" class="display responsive nowrap tabla" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($mediospago as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->mediopago;?></td> 
              <td class=""><?php echo $value->estado==1?'Activo':'Inactivo';?></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-mediopago="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarMedioPago"><i class="fa-solid fa-pen-to-square" title="Actualizar el mediopago"></i></button>
                    <button class="btn-md btn-red eliminarMedioPago" title="Eliminar mediopago"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog id="miDialogoMedioPago" class="midialog-sm rounded-lg shadow-lg p-12">
    <h4 id="modalMedioPago" class="font-semibold text-gray-700 mb-4 mt-10">Crear medio de pago</h4>
    <div id="divmsjalertaMedioPago"></div>
    <form id="formCrearUpdateMedioPago" class="formulario" action="/admin/config/crear_MedioPago" method="POST">
        
            <div class="formulario__campo">
                <label class="formulario__label" for="nombreMedioPago">Nombre</label>
                <input id="nombreMedioPago" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del medio de pago" name="nombre" value="" required>
            </div> 
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearMedioPago" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar medio de pago-->
  
</div>