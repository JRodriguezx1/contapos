<div class="p-6 space-y-8">

  <!-- HEADER -->
  <div class="flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Notificaciones WhatsApp</h1>
    <span class="text-sm text-gray-500">Configura alertas automáticas del sistema</span>
  </div>


  <!-- GRID PRINCIPAL -->
  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- ===================== -->
    <!-- 🔹 FORM AGREGAR -->
    <!-- ===================== -->
    <div class="bg-white p-6 rounded-2xl shadow-md">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">Agregar destino</h2>

      <form id="formDestino" class="space-y-4">

        <div>
          <label class="text-sm text-gray-600">Nombre</label>
          <input type="text" id="nombre" class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>

        <div>
          <label class="text-sm text-gray-600">Teléfono</label>
          <input type="text" id="telefono" placeholder="Ej: 573001234567" class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>

        <div>
          <label class="text-sm text-gray-600">Tipo</label>
          <select id="tipo" class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="individual">Individual</option>
            <option value="grupo">Grupo</option>
          </select>
        </div>

        <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-medium transition">
          + Agregar destino
        </button>

      </form>
    </div>


    <!-- ===================== -->
    <!-- 🔹 LISTADO -->
    <!-- ===================== -->
    <div class="xl:col-span-2 bg-white p-6 rounded-2xl shadow-md">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">Destinos configurados</h2>

      <div class="overflow-x-auto">
        <table class="w-full text-left">

          <thead>
            <tr class="border-b text-gray-600 text-sm">
              <th class="py-2">Nombre</th>
              <th>Teléfono</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>

          <tbody id="tablaDestinos" class="text-sm">

            <!-- EJEMPLO -->
            <tr class="border-b">
              <td class="py-2 font-medium">Administrador</td>
              <td>573001234567</td>
              <td>
                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">Individual</span>
              </td>
              <td>
                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Activo</span>
              </td>
              <td class="text-right">
                <button class="text-red-500 hover:underline text-xs">Eliminar</button>
              </td>
            </tr>

          </tbody>

        </table>
      </div>
    </div>

  </div>


  <!-- ===================== -->
  <!-- 🔹 CONFIG EVENTOS -->
  <!-- ===================== -->
  <div class="bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-xl font-semibold mb-6 text-gray-800">Eventos del sistema</h2>

    <div class="space-y-6">

      <!-- EVENTO -->
      <div class="border rounded-xl p-4">
        
        <div class="flex justify-between items-center mb-3">
          <div>
            <h3 class="font-semibold text-gray-800">Factura eliminada</h3>
            <p class="text-sm text-gray-500">Notifica cuando se elimina una factura</p>
          </div>

          <!-- SWITCH -->
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer" checked>
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600"></div>
          </label>
        </div>

        <!-- DESTINOS -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">

          <label class="flex items-center gap-2">
            <input type="checkbox" checked>
            Administrador
          </label>

          <label class="flex items-center gap-2">
            <input type="checkbox">
            Cajero
          </label>

        </div>

      </div>


      <!-- EVENTO -->
      <div class="border rounded-xl p-4">
        
        <div class="flex justify-between items-center mb-3">
          <div>
            <h3 class="font-semibold text-gray-800">Cierre de caja</h3>
            <p class="text-sm text-gray-500">Resumen al cerrar caja</p>
          </div>

          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer" checked>
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600"></div>
          </label>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">

          <label class="flex items-center gap-2">
            <input type="checkbox" checked>
            Administrador
          </label>

        </div>

      </div>


      <!-- EVENTO -->
      <div class="border rounded-xl p-4">
        
        <div class="flex justify-between items-center mb-3">
          <div>
            <h3 class="font-semibold text-gray-800">Stock mínimo</h3>
            <p class="text-sm text-gray-500">Alerta de inventario bajo</p>
          </div>

          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600"></div>
          </label>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">

          <label class="flex items-center gap-2">
            <input type="checkbox">
            Administrador
          </label>

        </div>

      </div>

    </div>
  </div>


  <!-- ===================== -->
  <!-- 🔹 BOTÓN GUARDAR -->
  <!-- ===================== -->
  <div class="flex justify-end">
    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium shadow">
      Guardar configuración
    </button>
  </div>

</div>