<div class="gestionDian">
    <h4 class="text-gray-600 mb-12 mt-4">Gestionar Dian</h4>
    <div class="flex flex-wrap gap-2 mt-4 mb-4 pb-4">
        <button id="crearCompañia" class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">data_saver_on</span>Crear compañia</button>
        <button id="obtenerresolucion" class="btn-command"><span class="material-symbols-outlined">install_desktop</span>Obtener resolucion</button>
        <button id="setpruebas" class="btn-command text-center"><span class="material-symbols-outlined">component_exchange</span>Set pruebas</button>  
    </div>

    <div class="h-8 bg-slate-100"></div>

    <h5 class="text-gray-600 mt-8 mb-3">Lista de n configuradas</h5>
    <table class="display responsive nowrap tabla" width="100%" id="tablan">
      <thead>
          <tr>
              <th>Nº</th>
              <th>Nombre</th>
              <th>Documento</th>
              <th>software</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($companias as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->documento;?></td>
              <td class="" ><?php echo $value->software; ?></td> 
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-compañia="<?php echo $value->nombre;?>"><button class="btn-md btn-turquoise editarCompañia"><i class="fa-solid fa-pen-to-square" title="Actualizar facturador"></i></button><button class="btn-md btn-red eliminarCompañia"><i class="fa-solid fa-trash-can" title="Eliminar facturador"></i></button></div></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>

    <dialog id="miDialogoCompañia" class="midialog-sm p-12 rounded-lg shadow-lg">
        <h4 id="modalCompañia" class="font-semibold text-gray-700 mb-4 mt-10">Crear compañia</h4>
        <div id="divmsjalertaCompañia"></div>
        <form id="formCrearUpdateCompañia" class="formulario" action="/admin/config/crear_compañia" method="POST">

            <div class="formulario__campo">
                <label class="formulario__label" for="tipo_documento">Tipo Documento</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="tipo_documento" name="tipo_documento" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1">Registro civil</option>
                    <option value="2">Tarjeta de identidad</option>
                    <option value="3">Cedula de ciudadania</option>
                    <option value="4">Tarjeta de extranjeria</option>
                    <option value="5">Cedula de extrangeria</option>
                    <option value="6">NIT</option>
                    <option value="7">Pasaporte</option>
                    <option value="8">Documento de identificacion extranjero</option>
                    <option value="9">NIT de otro pais</option>
                    <option value="10">NUIP</option>
                </select>
            </div>  
            <div class="formulario__campo">
                <label class="formulario__label" for="numero_documento">Numero de Documento</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Numerodel documento" id="numero_documento" name="numero_documento" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="certificadoDigital">Certificado Digital .p12</label>
                <input type="file" id="certificadoDigital" name="certificadoDigital" accept=".p12" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required />      
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="Password">Contraseña</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Contraseña del certificaod digital" id="Password" name="Password" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="idsoftware">ID Software</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="ID del Software" id="idsoftware" name="idsoftware" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="pinsoftware">Pin Software</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Pin del Software" id="pinsoftware" name="pinsoftware" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="nombrerazonsocial">Nombre/Razón Social</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre/Razon Social" id="nombrerazonsocial" name="nombrerazonsocial" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="tipoorganizacion">Tipo Organización</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="tipoorganizacion" name="tipoorganizacion" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1">Persona Juridica</option>
                    <option value="2">Persona Natural</option>
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="obligaciones">Obligaciones</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="obligaciones" name="obligaciones" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="7">Gran contribuyente</option>
                    <option value="9">Autorretenedor</option>
                    <option value="14">Agente de retencion en el impuesto sobre las ventas</option>
                    <option value="112">Regimen simple de tributacion - Simple</option>
                    <option value="117">No Responsable</option>
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="impuesto">Impuesto</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="impuesto" name="impuesto" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1">Ninguno</option>
                    <option value="1">IVA</option>
                    <option value="4">Impuesto Nacional al consumo</option>
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="regimen">Régimen</label>
                <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="regimen" name="regimen" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1">Responsable de IVA</option>
                    <option value="2">No Responsable de IVA</option>
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="email">Correo electrónico</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="email" placeholder="Email que aparece en el RUT" id="email" name="email" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="telefono">Teléfono</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Telefono de contacto" id="telefono" name="telefono" value="" required>
                    <!-- <label data-num="16" class="count-charts" for="">16</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="departamento">Departamento</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Departamento o region" id="departamento" name="departamento" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="ciudad">Ciudad</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Ciudad" id="ciudad" name="ciudad" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="direccion">Dirección</label>
                <div class="formulario__dato">
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Direccion comercial o de residencia" id="direccion" name="direccion" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
        
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
                <input id="btnEditarCrearCompañia" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
            </div>
        </form>
    </dialog><!--fin crear/editar compañia-->

    <dialog id="miDialogoGetResolucion" class="midialog-sm p-12">
        <h4 class="font-semibold text-gray-700 mb-4">Obtener resolución</h4>
        <div id="divmsjalertaGetResolucion"></div>
        <form id="formGetResolucion" class="formulario" action="/admin/config/GetResolucion" method="POST">
            <div class="formulario__campo">
                <label class="formulario__label" for="getresolucioncompañia">Seleccionar compañia</label>
                <select id="getResolucioncompañia" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="getresolucioncompañia" required>
                    <option value="" disabled selected>-Seleccionar-</option>                   
                </select>
            </div>
            <div>
                <!--lista de resoluciones-->
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarGetResolucion" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Descargar">
            </div>
        </form>
    </dialog><!--fin obtener resolucion-->

    <dialog id="miDialogosetpruebas" class="midialog-sm p-12">
        <h4 class="font-semibold text-gray-700 mb-4">Set de pruebas</h4>
        <div id="divmsjalertasetpruebas"></div>
        <form id="formSetPruebas" class="formulario" action="/admin/config/setpruebas" method="POST">
            <div class="formulario__campo">
                <label class="formulario__label" for="setcompañia">Seleccionar compañia</label>
                <select id="setcompañia" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="setcompañia" required>
                    <option value="" disabled selected>-Seleccionar-</option>          
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="idsetpruebas">ID set de pruebas</label>
                <div class="formulario__dato">
                    <input id="idsetpruebas" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="ID del set de pruebas" name="idsetpruebas" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarSetPruebas" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Enviar">
            </div>
        </form>
    </dialog><!--fin set pruebas-->

    
</div>