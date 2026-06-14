<div class="gestionimpresoras">

  <h4 class="text-gray-600 mb-8 mt-12">Gestion de impresoras</h4>
  <button id="crearImpresora" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[144px]">Crear punto</button>
  <table id="tablaImpresoras" class="display responsive nowrap tabla" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Nombre compartido</th>
              <th>Estacion</th>
              <th>Mm</th>
              <th>Estado</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($impresoras as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->nombrecompartido;?></td>
              <td class=""><?php echo $value->estacion;?></td>
              <td class=""><?php echo $value->estacion;?></td>
              <td class=""><?php echo $value->estado;?></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-impresora="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarImpresora"><i class="fa-solid fa-pen-to-square" title="Actualizar punto de impresion"></i></button>
                    <button class="btn-md btn-red eliminarImpresora" title="Eliminar Impresora"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog id="miDialogoIMpresora" class="midialog-sm rounded-lg shadow-lg p-12">
    <h4 id="modalIMpresora" class="font-semibold text-gray-700 mb-4 mt-10">Crear punto de impresora</h4>
    <div id="divmsjalertaIMpresora"></div>
    <form id="formCrearUpdateIMpresora" class="formulario" action="/admin/config/crear_IMpresora" method="POST">
        <div class="empleado-grid">
            <div class="formulario__campo">
                <label class="formulario__label" for="nombreImpresora">Nombre de la impresora</label>
                <input id="nombreImpresora" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del espacio de trabajo" name="nombre" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="nombrecompartido">Nombre compartido</label>
                <input id="nombreCompartido" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre compartido de la impresora" name="nombrecompartido" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="anchoPapel">Ancho del papel (mm)</label>
                <input id="anchoPapel" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="ejemplo: 58" name="anchoPapel" value="" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0)" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="estacion">Estacion</label>
                <input id="estacion" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Estacion de trabajo" name="estacion" value="" required>
            </div>
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearImpresora" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Impresora-->
  
</div>