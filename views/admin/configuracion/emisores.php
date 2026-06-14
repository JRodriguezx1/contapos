<div class="gestionEmisores">

  <h4 class="text-gray-600 mb-8 mt-12">Gestion de emisores</h4>
  <button id="crearEmisor" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[144px]">Crear emisor</button>
  <table id="tablaEmisores" class="display responsive nowrap tabla" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>NIT</th>
              <th>Movil</th>
              <th>Estado</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($emisores as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class=""><?php echo $value->nombre;?></td>
              <td class=""><?php echo $value->nit;?></td>
              <td class=""><?php echo $value->telefono;?></td>
              <td class="">
                <button id="<?php echo $value->id;?>" data-state="<?php echo $value->estado;?>" class="stateEmisor btn-xs <?php echo $value->estado==1?'btn-lima':'btn-red';?>"><?php echo $value->estado==1?'Activo':'Inactivo';?></button>
              </td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-emisor="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarEmisor"><i class="fa-solid fa-pen-to-square" title="Actualizar datos del emisor"></i></button>
                    <button class="btn-md btn-red eliminarEmisor" title="Eliminar Emisor"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog id="miDialogoEmisor" class="midialog-sm rounded-lg shadow-lg p-12">
    <h4 id="modalEmisor" class="font-semibold text-gray-700 mb-4 mt-10">Crear emisor</h4>
    <div id="divmsjalertaEmisor"></div>
    <form id="formCrearUpdateEmisor" class="formulario" action="/admin/config/crear_Emisor" method="POST">
        <div class="empleado-grid">
            <div class="formulario__campo">
                <label class="formulario__label" for="sucursalEmisor">Sucursal</label>
                <select id="sucursalEmisor" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="sucursalEmisor" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($sucursales as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>    
                </select>                   
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="nombreEmisor">Nombre del emisor</label>
                <input id="nombreEmisor" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del emisor" name="nombreEmisor" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="nitEmisor">Nit</label>
                <input id="nitEmisor" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nit del emisor" name="nitEmisor" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="datosencabezadosEmisor">Datos del Rut</label>
                <div class="formulario__dato">
                    <textarea id="datosencabezadosEmisor" class="formulario__textarea w-full bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block p-2.5 text-xl focus:outline-none focus:ring-1 h-32" name="datosencabezadosEmisor" placeholder="datos de encabezado de la factura" rows="4"></textarea>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="movilEmisor">Movil</label>
                <input id="movilEmisor" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Contacto del emisor" name="movilEmisor" value="" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0)">
            </div>
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearEmisor" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Emisor-->
  
</div>