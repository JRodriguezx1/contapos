<!-- VISTA: TRASLADO DE INVENTARIO (SEDE ORIGEN) -->
<section class="box trasladoinventario p-10 !pb-20 rounded-lg mb-4">
    <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-6">
        <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <span class="sr-only">Atrás</span>
        </a>
    <!-- Título principal -->
    <h4 class="text-gray-600 mb-5 mt-6 font-bold uppercase">
        Traslado de inventario
    </h4>

    <!-- Descripción -->
    <p class="text-gray-600 mb-6">
        Registra y gestiona el envío de productos o materia prima hacia otras sedes.
    </p>

    <!-- Cards de resumen de traslados -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Pendientes -->
        <div class="grid grid-cols-2 items-center bg-indigo-50 rounded-2xl shadow-md p-4 flex-col justify-center hover:scale-105 hover:shadow-lg transition">
            <div>
            <p class="text-gray-700 text-base font-semibold">Pendientes</p>
            <h3 class="text-3xl font-extrabold text-indigo-700 leading-tight">12</h3>
            </div>
            <div class="flex justify-end">
            <i class="fa-solid fa-clock text-indigo-500 text-4xl"></i>
            </div>
        </div>

        <!-- En tránsito -->
        <div class="grid grid-cols-2 items-center bg-indigo-50 rounded-2xl shadow-md p-4 flex-col justify-center hover:scale-105 hover:shadow-lg transition">
            <div>
            <p class="text-gray-700 text-base font-semibold">En tránsito</p>
            <h3 class="text-3xl font-extrabold text-yellow-600 leading-tight">8</h3>
            </div>
            <div class="flex justify-end">
            <i class="fa-solid fa-truck text-yellow-500 text-4xl"></i>
            </div>
        </div>

        <!-- Completados -->
        <div class="grid grid-cols-2 items-center bg-indigo-50 rounded-2xl shadow-md p-4 flex-col justify-center hover:scale-105 hover:shadow-lg transition">
            <div>
            <p class="text-gray-700 text-base font-semibold">Completados</p>
            <h3 class="text-3xl font-extrabold text-green-600 leading-tight">25</h3>
            </div>
            <div class="flex justify-end">
            <i class="fa-solid fa-circle-check text-green-500 text-4xl"></i>
            </div>
        </div>

        <!-- Cancelados -->
        <div class="grid grid-cols-2 items-center bg-indigo-50 rounded-2xl shadow-md p-4 flex-col justify-center hover:scale-105 hover:shadow-lg transition">
            <div>
            <p class="text-gray-700 text-base font-semibold">Cancelados</p>
            <h3 class="text-3xl font-extrabold text-red-600 leading-tight">3</h3>
            </div>
            <div class="flex justify-end">
            <i class="fa-solid fa-ban text-red-500 text-4xl"></i>
            </div>
        </div>
    </section>


  <!-- Filtros -->
  <div class="flex gap-3 mb-6 w-full flex-col md:flex-row p-2">
    <input type="text" placeholder="Buscar por #, producto o sede..."
      class="bg-gray-50 w-full border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block md:w-1/2 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
    <select
      class="bg-gray-50 w-full border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block md:w-1/4 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
      <option>Todas las sedes destino</option>
      <option>Sede Norte</option>
      <option>Sede Sur</option>
      <option>Sede Centro</option>
    </select>
    <select
      class="bg-gray-50 border w-full border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block md:w-1/4 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
      <option>Todos los estados</option>
      <option>Pendiente</option>
      <option>En tránsito</option>
      <option>Entregado</option>
      <option>Rechazado</option>
    </select>
  </div>

  <!-- Tabla de traslados -->
  <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
    <table id="tablaTraslados" class="w-full text-left border-collapse">
      <thead class="bg-gray-50 text-gray-600 text-base font-semibold uppercase tracking-wide">
        <tr>
          <th class="p-4"># TRASLADO</th>
          <th class="p-4">Sede destino</th>
          <th class="p-4">Usuario</th>
          <th class="p-4">Fecha envío</th>
          <th class="p-4">Tipo</th>
          <th class="p-4">Estado</th>
          <th class="p-4">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-lg divide-y divide-gray-100">
        <?php foreach($transferirinventario as $value): ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3"><?php echo $value->id;?></td>
                <td class="px-6 py-3"><?php echo $value->sucursaldestino;?></td>
                <td class="px-6 py-3"><?php echo $value->usuario;?></td>
                <td class="px-6 py-3 text-center"><?php echo $value->created_at;?></td>
                <td class="px-6 py-3"><?php echo $value->tipo;?></td>
                <td class="px-6 py-3 text-center">
                  <span class="px-3 py-1 text-base font-semibold rounded-full bg-yellow-100 text-yellow-700"><?php echo $value->estado;?></span>
                </td>
                <td id="<?php echo $value->id;?>" class="px-6 py-3 text-center flex justify-center gap-2">
                  <button class="enviar w-11 h-11 flex items-center justify-center text-blue-600 border border-blue-200 rounded-full hover:bg-blue-50 text-xl">✅</button>
                  <button class="detalle bg-indigo-100 text-indigo-600 hover:bg-indigo-200 p-2 rounded-full" title="Ver detalles">
                    👁️
                  </button>
                  <a href="/admin/almacen/editartrasladoinv?id=<?php echo $value->id;?>" class="bg-green-100 text-green-600 hover:bg-green-200 p-2 rounded-full" title="Editar traslado">
                    ✏️
                  </a>
                  <button class="cancelar w-11 h-11 flex items-center justify-center text-rose-600 border border-rose-200 rounded-full hover:bg-rose-50 text-xl">
                    ❌
                  </button>
                </td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Botón crear traslado -->
  <div class="flex justify-end mt-6">
    <a href="/admin/almacen/nuevotrasladoinv"
      class="flex items-center gap-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition px-4 h-14 py-2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
        class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      Nuevo traslado
    </a>
  </div>

  <!-- MODAL DE DETALLE DE TRASLADO SALIDA O SOLICITUD -->
<dialog id="miDialogoDetalleTrasladoSolicitud" class="rounded-2xl border border-gray-200 dark:border-neutral-700 w-[95%] max-w-4xl p-8 bg-white dark:bg-neutral-900 backdrop:bg-black/40">
  <!-- Encabezado -->
  <div class="flex justify-between items-center border-b border-gray-200 dark:border-neutral-700 pb-4 mb-6">
    <h4 id="modalDetalleTrasladoSolicitud" class="text-2xl font-bold text-gray-900 dark:text-gray-100">
      Detalle Traslado/Solicutd de mercancia
    </h4>
    <button id="btnXCerrarDetalleTrasladoSolicitud" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 transition">
      <i class="fa-solid fa-xmark text-gray-600 dark:text-gray-300 text-2xl"></i>
    </button>
  </div>

  <div id="contenidodetalle" class="">
    <div>
      <p id="sedeorigen"></p>
      <p id="sededestino"></p>
      <p id="tipo"></p>
    </div>
    <table id="tabladetalleorden" class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-2 border">Producto</th>
          <th class="px-4 py-2 border">Cantidad</th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>

  </div>
  
</dialog>

</section>