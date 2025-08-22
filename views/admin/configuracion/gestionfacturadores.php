<div class="gestionfacturadores">

  <h4 class="text-gray-600 mb-12 mt-4">Gestion de facturadores</h4>
  <button id="crearFacturador" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-auto">Crear facturador</button>
  <table class="display responsive nowrap tabla" width="100%" id="tablaFacturadores">
      <thead>
          <tr>
              <th>Nº</th>
              <th>Nombre</th>
              <th>Tipo</th>
              <th>Rango</th>
              <th>Siguiente</th>
              <th>Expira</th>
              <th>Estado</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($facturadores as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->nombretipofacturador;?></td>
              <td class="" ><?php echo $value->rangoinicial; ?></td> 
              <td class=""><?php echo $value->siguientevalor;?></td>
              <td class="" ><?php echo $value->fechafin; ?></td> 
              <td class=""><?php echo $value->estado==1?'Activo':'Expirada';?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-facturador="<?php echo $value->nombre;?>"><button class="btn-md btn-turquoise editarFacturador"><i class="fa-solid fa-pen-to-square"></i></button><button class="btn-md btn-red eliminarFacturador"><i class="fa-solid fa-trash-can"></i></button></div></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog id="miDialogoFacturador" class="midialog-sm p-12 rounded-lg shadow-lg">
    <h4 id="modalFacturador" class="font-semibold text-gray-700 mb-4 mt-10">Crear facturador</h4>
    <div id="divmsjalertafacturador"></div>
    <form id="formCrearUpdateFacturador" class="formulario" action="/admin/config/crear_facturador" method="POST">
        
            <div class="formulario__campo">
                <label class="formulario__label" for="nombrefacturador">Nombre</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del facturador" id="nombrefacturador" name="nombre" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="idtipofacturador">Tipo facturador</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="idtipofacturador" name="idtipofacturador" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($tipofacturadores as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="rangoinicial">Consecutivo inicial</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Consecutivo inicial del consecutivo" id="rangoinicial" name="rangoinicial" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="rangofinal">Consecutivo final</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Consecutivo final del consecutivo" id="rangofinal" name="rangofinal" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="siguientevalor">Siguiente consecutivo</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Siguiente consecutivo" id="siguientevalor" name="siguientevalor" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="fechainicio">Fecha inicio</label>
                <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="date" placeholder="Siguiente consecutivo" id="fechainicio" name="fechainicio" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="fechafin">Fecha fin</label>
                <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="date" placeholder="Siguiente consecutivo" id="fechafin" name="fechafin" value="" required>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="resolucion">Número de resolución</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Numero de resolucion" id="resolucion" name="resolucion" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="prefijo">Prefijo</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Prefijo de la resolucion" id="prefijo" name="prefijo" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="negociofacturador">Negocio</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="negociofacturador" name="negocio" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($negocios as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>                   
            </div>
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearFacturador" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar facturador-->
</div>