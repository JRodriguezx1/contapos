<!-- MODAL PARA CREAR O AÑADIR CLIENTE -->
<dialog id="miDialogoAddCliente" class="midialog-sm rounded-2xl border border-gray-200 w-[95%] max-w-3xl p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">
    <!-- Encabezado -->
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-5">
        <h4 class="text-2xl font-bold text-indigo-700">👤 Cliente</h4>
        <button class="p-2 rounded-lg hover:bg-gray-100 transition salir"><i class="fa-solid fa-xmark text-gray-600 text-2xl"></i></button>
    </div>
    <!-- ================= BUSCAR CLIENTE EXISTENTE ================= -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-5">
        <h5 class="text-lg font-semibold text-gray-700 mb-3">🔎 Buscar cliente existente</h5>
        <select
        id="selectCliente"
        type="text"
        name="selectCliente"
        class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600"
        name="selectCliente" 
        multiple="multiple" 
        required
        >
        <?php foreach($clientes as $cliente): ?>
            <option data-tipoID="<?php echo $cliente->tipodocumento;?>" data-identidad="<?php echo $cliente->identificacion;?>" value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre.' '.$cliente->apellido;?></option> 
        <?php endforeach ?>
        </select>
        
    </div>


    <form id="formAddCliente" class="formulario space-y-6" action="/" method="POST">

        <!-- ================= CREAR NUEVO CLIENTE ================= -->
        <div class="border-t border-gray-200 pt-6">
        <h5 class="text-lg font-semibold text-gray-700 mb-6">➕ Crear nuevo cliente</h5>

        <div class="formulario__campo">
            <label class="formulario__label text-lg font-medium text-gray-700" for="nombreclientenuevo">* Nombre</label>
            <input id="nombreclientenuevo" type="text" name="nombreclientenuevo" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600" required>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label text-lg font-medium text-gray-700" for="clientenuevoapellido">Apellido</label>
            <input id="clientenuevoapellido" type="text" name="clientenuevoapellido" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label text-lg font-medium text-gray-700" for="identificacion">* Documento</label>
            <input id="identificacion" name="identificacion" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600" required>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label text-lg font-medium text-gray-700" for="telefono">* Teléfono</label>
            <input id="telefono" type="text" name="telefono" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600" required>
        </div>

        <div class="formulario__campo">
            <label class="formulario__label text-lg font-medium text-gray-700" for="direccionEntrega">Dirección</label>
            <select id="direccionEntrega" type="text"
            name="direccionEntrega"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600"
            >
            <option value="1" disabled selected>-Seleccionar-</option>
            </select>
        </div>

        </div>

        <!-- ================= MOSTRAR / OCULTAR MÁS OPCIONES ================= -->
        <div class="border-t border-gray-200 pt-2">
        <div class="accordion">

            <input type="checkbox" id="opcionesCliente">

            <label class="etiqueta flex items-center justify-center gap-2 cursor-pointer text-indigo-600 font-medium hover:text-indigo-800 select-none"for="opcionesCliente">Mostrar / Ocultar más opciones</label>

            <div class="wrapper">
            <div class="wrapper-content">
                <div class="content space-y-6 mt-6">

                <!-- Campos secundarios (los dejo igual que ya los tenías) -->

                <div class="formulario__campo">
                    <label class="formulario__label text-lg font-medium text-gray-700" for="tipodocumento">Tipo documento</label>
                    <select id="tipodocumento" name="tipodocumento" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                    <option value="1">Registro civil</option>
                    <option value="2">Tarjeta de identidad</option>
                    <option value="3" selected>Cedula de ciudadania</option>
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
                    <label class="formulario__label text-lg font-medium text-gray-700" for="clientenuevoemail">Email</label>
                    <input id="clientenuevoemail" name="clientenuevoemail" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label text-lg font-medium text-gray-700" for="departamento">Departamento</label>
                    <input id="departamento" type="text" name="departamento" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label text-lg font-medium text-gray-700" for="ciudad">Ciudad</label>
                    <input id="ciudad" type="text" name="ciudad" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label text-lg font-medium text-gray-700" for="clientenuevodireccion">Nueva direccion</label>
                    <input id="clientenuevodireccion" type="text" name="clientenuevodireccion" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Botones -->
        <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
        <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px] salir">Cancelar</button>
        <input id="btnCrearAddCliente" type="submit" value="Guardar" class="btn-md btn-indigo !py-4 !px-6 !w-[135px]">
        </div>

    </form>
</dialog>