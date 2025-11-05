<div class="tarifas">

  <h4 class="text-gray-600 mb-8 mt-12">Gestion de tarifas</h4>
  <button id="crearTarifa" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[144px]">Crear tarifa</button>
  <table id="tablaTarifas" class="display responsive nowrap tabla" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Valor tarifa</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($tarifas as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class="">$<?php echo number_format($value->valor??0, '2', ',', '.');?></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-tarifa="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarTarifa"><i class="fa-solid fa-pen-to-square" title="Actualizar datos del tarifa"></i></button>
                    <button class="btn-md btn-red eliminarTarifa" title="Eliminar tarifa"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog id="miDialogoTarifa" class="midialog-sm rounded-lg shadow-lg p-12">
    <h4 id="modalTarifa" class="font-semibold text-gray-700 mb-4 mt-10">Crear tarifa</h4>
    <div id="divmsjalertaTarifa"></div>
    <form id="formCrearUpdateTarifa" class="formulario" action="/admin/config/crear_Tarifa" method="POST">
        <div class="empleado-grid">
            <div class="formulario__campo">
                <label class="formulario__label" for="nombreTarifa">Nombre</label>
                <input id="nombreTarifa" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del tarifa" name="nombre" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="valorTarifa">Valor tarifa</label>
                <input id="valorTarifa" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Valor de la tarifa" name="valor" value="" required>
            </div>
        </div>  
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearTarifa" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Tarifa-->
  
</div>