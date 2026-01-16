<!-- MODAL DATOS DEL ADQUIRIENTE -->
<dialog id="miDialogoFacturarA" class="midialog-sm !p-12">

    <div class="flex items-start gap-3 mb-4">
      <div class="text-indigo-600 mt-1">
        <i class="fas fa-user-circle text-[4rem] leading-[2.5rem]"></i> <!-- Ícono más grande -->
      </div>
      <div>
        <h2 class="text-3xl font-semibold text-gray-900">Datos Factura Electrónica</h2>
        <p class="text-lg text-gray-600">Ingresar datos del adquiriente</p>
      </div>
    </div>

    <!-- <h4 class="text-gray-700 font-semibold">Facturar A:</h4> -->
    <form id="formFacturarA" class="formulario">
      <div class="border-b border-gray-900/10 pb-10 mb-3">
        <!-- <p class="mt-2 text-xl text-gray-600">Información del adquiriente.</p> -->

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8">
          <!-- Tipo de Documento -->
          <div>
            <label for="type_document_identification_id" class="block text-2xl font-medium text-gray-600">Tipo Documento</label>
            <div class="mt-2">
              <select id="type_document_identification_id" name="type_document_identification_id" required
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1">
                <option value="" disabled selected>Seleccione tipo de documento</option>
                <option value="1">Registro civil</option>
                <option value="2">Tarjeta de identidad</option>
                <option value="3">Cédula de ciudadanía</option>
                <option value="4">Tarjeta de extranjería</option>
                <option value="5">Cédula de extranjería</option>
                <option value="6">NIT</option>
                <option value="7">Pasaporte</option>
                <option value="8">Documento de identificación extranjero</option>
                <option value="9">NIT de otro país</option>
                <option value="10">NUIP *</option>
                <option value="11">PEP (Permiso Especial de Permanencia)</option>
                <option value="12">PPT (Permiso Protección Temporal)</option>
              </select>
            </div>
          </div>

          <!-- Número de Documento + Botón Buscar -->
          <div>
            <label for="identification_number" class="block text-2xl font-medium text-gray-600">Número de Documento</label>
            <div class="mt-2 flex flex-wrap gap-2 items-center">
              <input id="identification_number" type="text" name="identification_number" required
                class="flex-1 min-w-[200px] bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                placeholder="Número sin dígito de verificación"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
              >

              <button id="btnBuscarAdquiriente" type="button"
                class="flex items-center gap-2 text-indigo-600 border border-indigo-600 hover:bg-indigo-50 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg px-4 py-2.5 h-14 text-xl    focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
                Buscar
              </button>
            </div>
          </div>

          <!-- Nombre o Razón Social -->
          <div>
            <label for="business_name" class="block text-2xl font-medium text-gray-600">Nombre o Razón Social</label>
            <div class="mt-2">
              <input id="business_name" type="text" name="business_name" required
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
                placeholder="Nombre del cliente o empresa">
            </div>
          </div>

          <!-- Correo Electrónico -->
          <div>
            <label for="email" class="block text-2xl font-medium text-gray-600">Correo Electrónico</label>
            <div class="mt-2">
              <input id="email" type="email" name="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
                placeholder="correo@ejemplo.com">
            </div>
          </div>
        </div>
      </div>
      
      <!-- Botón para mostrar/ocultar -->
      <div class="accordion md:px-12 !mt-4">
        <!-- ID ÚNICO -->
        <input id="toggleOpcionesAdq" type="checkbox" class="peer sr-only">
        
        <label for="toggleOpcionesAdq" class="flex items-center justify-center gap-2 cursor-pointer text-gray-500 hover:text-indigo-600 select-none">
            <span>Mostrar/Ocultar más opciones</span>
            <span class="text-xl peer-checked:hidden">+</span>
            <span class="text-xl hidden peer-checked:inline">–</span>
        </label>
      <!-- Contenido oculto -->
      <div class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out peer-checked:max-h-[120rem]">
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8">
          
          <!-- Dirección -->
          <div>
            <label for="address" class="block text-2xl font-medium text-gray-600">Dirección</label>
            <input id="address" type="text" name="address" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" placeholder="Dirección del adquiriente">
          </div>

          <!-- Departamento -->
          <div>
            <label for="department_id" class="block text-2xl font-medium text-gray-600">Departamento</label>
            <select id="department_id" name="department_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
              <option value="" disabled selected>Seleccionar departamento</option>
              <?php foreach($departments as $value): ?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Ciudad o Municipio -->
          <div>
            <label for="municipality_id" class="block text-2xl font-medium text-gray-600">Ciudad / Municipio</label>
            <select id="municipality_id" name="municipality_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
              <option value="" disabled selected>Seleccionar ciudad o municipio</option>
            </select>
          </div>

          <!-- Tipo de Organización -->
          <div>
            <label for="type_organization_id" class="block text-2xl font-medium text-gray-600">Tipo de Organización</label>
            <select id="type_organization_id" name="type_organization_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
              <option value="" disabled selected>Seleccione tipo de organización</option>
              <option value="1">Persona Jurídica y asimiladas</option>
              <option value="2">Persona Natural y asimiladas</option>
            </select>
          </div>

          <!-- Tipo Régimen -->
          <div>
            <label for="type_regime_id" class="block text-2xl font-medium text-gray-600">Tipo Régimen</label>
            <select id="type_regime_id" name="type_regime_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
              <option value="" disabled selected>Seleccione tipo de régimen</option>
              <option value="1">Responsable de IVA</option>
              <option value="2">No responsable de IVA</option>
            </select>
          </div>

          <!-- Teléfono -->
          <div>
            <label for="phone" class="block text-2xl font-medium text-gray-600">Teléfono</label>
            <input id="phone" type="tel" name="phone"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1"
              placeholder="Teléfono de contacto">
          </div>
        </div>
      </div>
      <!-- Botones -->
      <div class="text-right mt-6">
        <button class="btn-md btn-turquoise !py-4 !px-6 !w-[125px] md:!w-[145px] !mr-3" type="button" value="Cancelar">Cancelar</button>
        <input class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[125px] md:!w-[145px]" type="submit" value="Confirmar">
      </div>

    </div>
  </form>
</dialog>