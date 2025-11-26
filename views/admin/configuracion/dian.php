<div class="gestionDian">
    <h4 class="text-gray-600 mb-12 mt-4">Gestionar Dian</h4>
    <div class="flex flex-wrap gap-2 mt-4 mb-4 pb-4">
        <button id="btnAdquirirCompañia" class="btn-command text-center"><span class="material-symbols-outlined">arrow_and_edge</span>Adquirir compañia</button>
        <button id="btnCrearCompañia" class="btn-command text-center"><span class="material-symbols-outlined">data_saver_on</span>Crear compañia</button>
        <button id="btnObtenerresolucion" class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">install_desktop</span>Obtener resolucion</button>
        <button id="BtnSetpruebas" class="btn-command text-center"><span class="material-symbols-outlined">component_exchange</span>Set pruebas</button>  
        <button id="btnDocumentos" class="btn-command text-center"><span class="material-symbols-outlined">inbox</span>Recepción documentos</button>  
    </div>

    <div class="h-8 bg-slate-100"></div>

    <h5 class="text-gray-600 mt-8 mb-3">Lista de compañias: <?php //echo OPENSSL_VERSION_TEXT; ?></h5>
    <table class="display responsive nowrap tabla" width="100%" id="tablaCompañias">
      <thead>
          <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>Documento</th>
              <th>software</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($companias as $index => $value): ?>
          <tr id="company<?php echo $value->identification_number;?>"> 
              <td class=""><?php echo $value->id;?></td>        
              <td class="" ><?php echo $value->business_name; ?></td> 
              <td class=""><?php echo $value->identification_number;?></td>
              <td class="" ><?php echo $value->idsoftware; ?></td> 
              <td class="accionestd"><div class="acciones-btns"> <button id="<?php echo $value->id;?>"><span class="material-symbols-outlined eliminarcompañia">delete</span></button></div></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>

    <dialog id="miDialogoCompañia" class="midialog-sm p-12 rounded-lg shadow-lg">
        <h4 id="modalCompañia" class="font-semibold text-gray-700 mb-4 mt-10">Crear compañia</h4>
        <div id="divmsjalertaCompañia"></div>
        <form id="formCrearUpdateCompañia" class="formulario" method="POST">

            <div class="formulario__campo">
                <label class="formulario__label" for="type_document_identification_id">Tipo Documento</label>
                <select id="type_document_identification_id" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="type_document_identification_id" required>
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
                    <input id="identification_number" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Numerodel documento" name="identification_number" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="certificate">Certificado Digital .p12</label>
                <input type="file" id="certificate" name="certificate" accept=".p12" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required />      
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="password">Contraseña</label>
                <div class="formulario__dato">
                    <input id="password" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Contraseña del certificaod digital" name="password" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="idsoftware">ID Software</label>
                <div class="formulario__dato">
                    <input id="idsoftware" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="ID del Software" name="idsoftware" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="pinsoftware">Pin Software</label>
                <div class="formulario__dato">
                    <input id="pinsoftware" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Pin del Software" name="pinsoftware" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="nombrerazonsocial">Nombre/Razón Social</label>
                <div class="formulario__dato">
                    <input id="business_name" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre/Razon Social" name="business_name" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="tipoorganizacion">Tipo de Organización</label>
                <select id="type_organization_id" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="type_organization_id" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1">Persona Juridica</option>
                    <option value="2">Persona Natural</option>
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="obligaciones">Obligaciones</label>
                <select id="type_liability_id" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="type_liability_id" required>
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
                <select id="tax_id" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="tax_id" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="">Ninguno</option>
                    <option value="1">IVA</option>
                    <option value="4">Impuesto Nacional al consumo</option>
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="regimen">Régimen</label>
                <select id="type_regime_id" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="type_regime_id" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1">Responsable de IVA</option>
                    <option value="2">No Responsable de IVA</option>
                </select>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="email">Correo electrónico</label>
                <div class="formulario__dato">
                    <input id="email" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="email" placeholder="Email que aparece en el RUT" name="email" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="telefono">Teléfono</label>
                <div class="formulario__dato">
                    <input id="phone" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Telefono de contacto" name="phone" value="" required>
                    <!-- <label data-num="16" class="count-charts" for="">16</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="departamento">Departamento</label>
                <div class="formulario__dato">
                    <select id="department_id" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="department_id">
                        <option value="" disabled selected>-Seleccionar-</option>
                        <?php foreach($departments as $value): ?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                        <?php endforeach; ?>   
                    </select>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="ciudad">Ciudad</label>
                <div class="formulario__dato">
                    <select id="municipality_id" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="municipality_id" required>
                        <option value="" disabled selected>-Seleccionar-</option>
                    </select>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="direccion">Dirección</label>
                <div class="formulario__dato">
                    <input id="address" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Direccion comercial o de residencia" name="address" value="" required>
                    <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                </div>
            </div>
        
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
                <input id="btnEditarCrearCompañia" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
            </div>
        </form>
    </dialog><!--fin crear/editar compañia-->

    <dialog id="miDialogoAdquirirCompañia" class="midialog-sm p-12">
        <h4 class="font-semibold text-gray-700 mb-4">Aquirir compañia</h4>
        <div id="divmsjalertaAdquirirCompañia"></div>
        <form id="formAdquirirCompañia" class="formulario" action="/admin/config/AdquirirCompañia" method="POST">
            
            <div class="formulario__campo">
                <label class="formulario__label" for="nitcompany">Numero de RUT</label>
                <div class="formulario__dato">
                    <input id="nitcompany" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nit sin digito de verificacion" name="nitcompany" value="" required>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="adquirirCompañiaPassword">Contraseña</label>
                <input id="adquirirCompañiaPassword" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Contraseña del certificaod digital" name="adquirirCompañiaPassword" value="" required>
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarAdquirirCompañia" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Enviar">
            </div>
        </form>
    </dialog><!--fin adquirir compañia-->

    <dialog id="miDialogoGetResolucion" class="midialog-sm p-12">
        <h4 class="font-semibold text-gray-700 mb-4">Obtener resolución</h4>
        <div id="divmsjalertaGetResolucion"></div>
        <form id="formGetResolucion" class="formulario relative" action="/admin/config/GetResolucion" method="POST">
            <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>    
            <div class="formulario__campo">
                <label class="formulario__label" for="selectResolucioncompañia">Seleccionar compañia</label>
                <select id="selectResolucioncompañia" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="getresolucioncompañia" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($companias as $value): ?>
                        <option data-token="" value="<?php echo $value->id;?>"><?php echo $value->business_name;?></option>
                    <?php endforeach; ?>                 
                </select>
            </div>
            <div class="mb-4 listResolutions"><!--lista de resoluciones-->
                <h3 class="text-lg font-semibold ">📃 Lista de resoluciones</h3>
                <table id="tablaListResolutions" class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700 text-xl">
                        <tr>
                            <th class="px-4 py-2 border">Prefijo</th>
                            <th class="px-4 py-2 border">N° Resolucion</th>
                            <th class="px-4 py-2 border">Rango</th>
                            <th class="px-4 py-2 border">Fecha fin</th>
                            <th class="px-4 py-2 border">Descargar</th>
                        </tr>
                    </thead>
                    <tbody class="text-lg text-center">
                        
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarGetResolucion" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Consultar">
            </div>
        </form>
    </dialog><!--fin obtener resolucion-->

    <dialog id="miDialogosetpruebas" class="midialog-sm p-12">
        <h4 class="font-semibold text-gray-700 mb-4">Set de pruebas</h4>
        <div id="divmsjalertasetpruebas"></div>
        <form id="formSetPruebas" class="formulario" action="/admin/config/setpruebas" method="POST">
            <div class="formulario__campo">
                <label class="formulario__label" for="selectSetCompañia">Seleccionar compañia</label>
                <select id="selectSetCompañia" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="setcompañia" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($companias as $value): ?>
                        <option data-token="" value="<?php echo $value->id;?>"><?php echo $value->business_name;?></option>
                    <?php endforeach; ?>
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