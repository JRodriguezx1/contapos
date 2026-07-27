<div class="gestionDian">
    <div class="config-section-heading">
        <div class="config-section-heading__icon">
            <i class="fa-solid fa-file-invoice"></i>
        </div>
        <div>
            <h4>Gestionar DIAN</h4>
            <p>Administra companias, resoluciones y procesos de facturacion electronica.</p>
        </div>
    </div>
    <div class="config-dian-actions">
        <button id="btnAdquirirCompañia" class="config-dian-action" type="button"><span class="material-symbols-outlined">arrow_and_edge</span>Adquirir compañia</button>
        <button id="btnCrearCompañia" class="config-dian-action" type="button"><span class="material-symbols-outlined">data_saver_on</span>Crear compañia</button>
        <button id="btnObtenerresolucion" class="config-dian-action config-dian-action--primary" type="button"><span class="material-symbols-outlined">install_desktop</span>Obtener resolucion</button>
        <button id="BtnSetpruebas" class="config-dian-action" type="button"><span class="material-symbols-outlined">component_exchange</span>Set pruebas</button>
        <button id="btnDocumentos" class="config-dian-action" type="button"><span class="material-symbols-outlined">inbox</span>Recepción documentos</button>
    </div>

    

    <div class="config-table-card config-dian-card">
      <div class="config-dian-card__header">
          <div>
              <h5>Lista de compañias</h5>
              <p>Companias configuradas para procesos DIAN y resoluciones.</p>
          </div>
      </div>
    <table class="display responsive nowrap tabla config-data-table config-dian-table" width="100%" id="tablaCompañias">
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
              <td><?php echo $value->id;?></td>
              <td>
                <span class="config-dian-company-name">
                  <span class="config-dian-company-name__icon"><i class="fa-solid fa-building-user"></i></span>
                  <span><?php echo $value->business_name; ?></span>
                </span>
              </td>
              <td><span class="config-table-pill config-table-pill--document"><?php echo $value->identification_number;?></span></td>
              <td><span class="config-table-pill config-table-pill--software"><?php echo $value->idsoftware; ?></span></td>
              <td class="accionestd"><div class="acciones-btns"> <button id="<?php echo $value->id;?>" class="config-dian-delete" type="button" title="Eliminar compañia"><span class="material-symbols-outlined eliminarcompañia">delete</span></button></div></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
    </div>

    <dialog id="miDialogoCompañia" class="midialog-sm config-dian-company-dialog">
        <div class="config-dian-dialog__header">
            <div class="config-dian-dialog__icon">
                <i class="fa-solid fa-building-user"></i>
            </div>
            <div>
                <span>Compania</span>
                <h4 id="modalCompañia">Crear compañia</h4>
                <p>Registra la informacion fiscal y tecnica para facturacion electronica.</p>
            </div>
        </div>
        <div id="divmsjalertaCompañia"></div>
        <form id="formCrearUpdateCompañia" class="formulario config-dian-dialog__form config-dian-company-dialog__form" method="POST">

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
                    <input id="identification_number" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Numero del documento" name="identification_number" value="" required>
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
                    <input id="password" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="password" placeholder="Contraseña del certificado digital" name="password" value="" required>
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
        
            <div class="config-dian-dialog__actions">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
                <input id="btnEditarCrearCompañia" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
            </div>
        </form>
    </dialog><!--fin crear/editar compañia-->

    <dialog id="miDialogoAdquirirCompañia" class="midialog-sm config-dian-acquire-dialog">
        <div class="config-dian-dialog__header">
            <div class="config-dian-dialog__icon">
                <i class="fa-solid fa-building-circle-arrow-right"></i>
            </div>
            <div>
                <span>DIAN</span>
                <h4>Adquirir compañia</h4>
                <p>Consulta y vincula la informacion fiscal desde el certificado digital.</p>
            </div>
        </div>
        <div id="divmsjalertaAdquirirCompañia"></div>
        <form id="formAdquirirCompañia" class="formulario config-dian-dialog__form" action="/admin/config/AdquirirCompañia" method="POST">
            
            <div class="formulario__campo">
                <label class="formulario__label" for="nitcompany">Numero de RUT</label>
                <div class="formulario__dato">
                    <input id="nitcompany" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nit sin digito de verificacion" name="nitcompany" value="" required>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="adquirirCompañiaPassword">Contraseña</label>
                <input id="adquirirCompañiaPassword" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="password" placeholder="Contraseña del certificado digital" name="adquirirCompañiaPassword" value="" required>
            </div>
            <div class="config-dian-dialog__actions">
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
            <div class="listResolutions config-dian-resolution-card"><!--lista de resoluciones-->
                <h3><i class="fa-solid fa-file-signature"></i> Lista de resoluciones</h3>
                <table id="tablaListResolutions" class="config-data-table config-dian-resolution-table">
                    <thead>
                        <tr>
                            <th>Prefijo</th>
                            <th>N° Resolucion</th>
                            <th>Rango</th>
                            <th>Fecha fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarGetResolucion" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Consultar">
            </div>
        </form>
    </dialog><!--fin obtener resolucion-->

    <dialog id="miDialogosetpruebas" class="midialog-sm config-dian-test-dialog">
        <div class="config-dian-dialog__header">
            <div class="config-dian-dialog__icon">
                <i class="fa-solid fa-network-wired"></i>
            </div>
            <div>
                <span>DIAN</span>
                <h4>Set de pruebas</h4>
                <p>Asocia una compania al identificador de pruebas autorizado.</p>
            </div>
        </div>
        <div id="divmsjalertasetpruebas"></div>
        <form id="formSetPruebas" class="formulario config-dian-dialog__form" action="/admin/config/setpruebas" method="POST">
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
            <div class="config-dian-dialog__actions">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarSetPruebas" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Enviar">
            </div>
        </form>
    </dialog><!--fin set pruebas-->

    <dialog id="miDialogoRecepcionDocumentos" class="midialog-sm config-dian-documents-dialog">
        <div class="config-dian-dialog__header">
            <div class="config-dian-dialog__icon">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <div>
                <span>DIAN</span>
                <h4>Recepcion de documentos</h4>
                <p>Centraliza los soportes recibidos del cliente para el proceso de facturacion electronica.</p>
            </div>
        </div>
        <div id="divmsjalertaRecepcionDocumentos"></div>
        <form id="formRecepcionDocumentos" class="formulario config-dian-dialog__form config-dian-documents-dialog__form" method="POST" enctype="multipart/form-data">
            <div class="formulario__campo config-dian-documents-dialog__company">
                <label class="formulario__label" for="recepcionDocumentosCompania">Compania</label>
                <select id="recepcionDocumentosCompania" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="compania_id" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($companias as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->business_name;?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="config-dian-documents-dialog__section">
                <div>
                    <h5>Documentos fiscales</h5>
                    <p>Archivos base para validar la informacion tributaria y habilitacion DIAN.</p>
                </div>
                <div class="config-dian-documents-dialog__grid">
                    <label class="config-dian-document-upload" for="documentoRut">
                        <span><i class="fa-solid fa-file-invoice"></i></span>
                        <strong>RUT</strong>
                        <small>PDF o imagen</small>
                        <input id="documentoRut" type="file" name="documento_rut" accept=".pdf,.jpg,.jpeg,.png,.webp">
                    </label>
                    <label class="config-dian-document-upload" for="documentoResolucion">
                        <span><i class="fa-solid fa-file-signature"></i></span>
                        <strong>Resolucion FE</strong>
                        <small>Documento DIAN</small>
                        <input id="documentoResolucion" type="file" name="documento_resolucion" accept=".pdf,.jpg,.jpeg,.png,.webp">
                    </label>
                    <label class="config-dian-document-upload" for="documentoCamaraComercio">
                        <span><i class="fa-solid fa-building-columns"></i></span>
                        <strong>Camara de comercio</strong>
                        <small>Certificado vigente</small>
                        <input id="documentoCamaraComercio" type="file" name="documento_camara_comercio" accept=".pdf,.jpg,.jpeg,.png,.webp">
                    </label>
                </div>
            </div>

            <div class="config-dian-documents-dialog__section">
                <div>
                    <h5>Identidad y marca</h5>
                    <p>Soportes de contacto, representante y recursos graficos del cliente.</p>
                </div>
                <div class="config-dian-documents-dialog__grid">
                    <label class="config-dian-document-upload" for="documentoCedula">
                        <span><i class="fa-solid fa-id-card"></i></span>
                        <strong>Cedula</strong>
                        <small>Representante legal</small>
                        <input id="documentoCedula" type="file" name="documento_cedula" accept=".pdf,.jpg,.jpeg,.png,.webp">
                    </label>
                    <label class="config-dian-document-upload" for="documentoLogo">
                        <span><i class="fa-solid fa-image"></i></span>
                        <strong>Logo</strong>
                        <small>PNG, JPG o WEBP</small>
                        <input id="documentoLogo" type="file" name="documento_logo" accept=".jpg,.jpeg,.png,.webp,.svg">
                    </label>
                    <label class="config-dian-document-upload" for="documentoCartaProductos">
                        <span><i class="fa-solid fa-list-check"></i></span>
                        <strong>Carta productos/servicios</strong>
                        <small>PDF, Excel o Word</small>
                        <input id="documentoCartaProductos" type="file" name="documento_carta_productos" accept=".pdf,.xlsx,.xls,.doc,.docx,.jpg,.jpeg,.png,.webp">
                    </label>
                </div>
            </div>

            <div class="config-dian-documents-dialog__section">
                <div>
                    <h5>Anexos adicionales</h5>
                    <p>Incluye contrato, poder, cuenta bancaria, certificado de responsabilidad u otros soportes recibidos.</p>
                </div>
                <label class="config-dian-document-upload config-dian-document-upload--wide" for="documentosAdicionales">
                    <span><i class="fa-solid fa-paperclip"></i></span>
                    <strong>Otros documentos</strong>
                    <small>Seleccion multiple de archivos</small>
                    <input id="documentosAdicionales" type="file" name="documentos_adicionales[]" accept=".pdf,.jpg,.jpeg,.png,.webp,.xlsx,.xls,.doc,.docx,.zip,.rar" multiple>
                </label>
            </div>

            <div class="formulario__campo">
                <label class="formulario__label" for="observacionesRecepcionDocumentos">Observaciones</label>
                <textarea id="observacionesRecepcionDocumentos" class="formulario__input" name="observaciones" rows="3" placeholder="Notas internas sobre documentos pendientes, vigencias o aclaraciones del cliente."></textarea>
            </div>

            <div class="config-dian-dialog__actions">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <button id="btnGuardarRecepcionDocumentos" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit">Guardar documentos</button>
            </div>
        </form>
    </dialog><!--fin recepcion documentos-->

    
</div>
