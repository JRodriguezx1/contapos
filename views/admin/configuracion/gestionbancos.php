<div class="gestionbancos">

  <h4 class="text-gray-600 mb-8 mt-12">Gestion de bancos</h4>
  <button id="crearBanco" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[144px]">Crear banco</button>
  <table class="display responsive nowrap tabla" width="100%" id="tablaBancos">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Numero de cuenta</th>
              <th>Fecha</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($bancos as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->numerocuenta;?></td>
              <td class=""><?php echo $value->created_at;?></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-banco="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarBanco"><i class="fa-solid fa-pen-to-square" title="Actualizar datos del banco"></i></button>
                    <button class="btn-md btn-red eliminarBanco" title="Eliminar banco"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog id="miDialogoBanco" class="midialog-sm rounded-lg shadow-lg p-12">
    <h4 id="modalBanco" class="font-semibold text-gray-700 mb-4 mt-10">Crear banco</h4>
    <div id="divmsjalertaBanco"></div>
    <form id="formCrearUpdateBanco" class="formulario" action="/admin/config/crear_Banco" method="POST">
        <div class="empleado-grid">
            <div class="formulario__campo">
                <label class="formulario__label" for="nombreBanco">Nombre</label>
                <input id="nombreBanco" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del banco" name="nombre" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="numeroCuenta">Numero de cuenta</label>
                <input id="numeroCuenta" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Numero de cuenta" name="numerocuenta" value="" required>
            </div>
        </div>  
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearBanco" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Banco-->
  
</div>