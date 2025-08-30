<div class="gestioncajas">

  <h4 class="text-gray-600 mb-8 mt-12">Gestion de cajas facturadoras</h4>
  <button id="crearCaja" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[144px]">Crear caja</button>
  <table class="display responsive nowrap tabla" width="100%" id="tablaCajas">
      <thead>
          <tr>
              <th>N.</th>
              <th>Caja</th>
              <th>Facturador automatico</th>
              <th>Negocio</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($cajas as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->nombreconsecutivo->nombre;?></td>
              <td class=""><?php echo $value->negocio;?></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-caja="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarCaja"><i class="fa-solid fa-pen-to-square" title="Actualizar datos de caja"></i></button>
                    <?php if($value->id>1){ ?>
                    <button class="btn-md btn-red eliminarCaja" title="Eliminar caja"><i class="fa-solid fa-trash-can"></i></button>
                    <?php } ?>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog id="miDialogoCaja" class="midialog-sm rounded-lg shadow-lg p-12">
    <h4 id="modalCaja" class="font-semibold text-gray-700 mb-4 mt-10">Crear caja</h4>
    <div id="divmsjalertacaja"></div>
    <form id="formCrearUpdateCaja" class="formulario" action="/admin/config/crear_caja" method="POST">
        <div class="empleado-grid">
            <div class="formulario__campo">
                <label class="formulario__label" for="nombrecaja">Nombre</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre de la caja" id="nombrecaja" name="nombre" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="idtipoconsecutivo">Facturador automático</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="idtipoconsecutivo" name="idtipoconsecutivo" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($facturadores as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="negociogestioncaja">Negocio</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="negociogestioncaja" name="negocio" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($negocios as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>                   
            </div>
        </div>  
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearCaja" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar caja-->
</div>