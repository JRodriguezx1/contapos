<div class="contenido9 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6 mt-6">

  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Notificaciones WhatsApp</h1>
    <span class="text-sm text-gray-500">Configura alertas automáticas del sistema</span>
  </div>

  <!-- ===================== -->
  <!-- 🔹 DESTINOS (MEJORADO) -->
  <!-- ===================== -->
  <div class="bg-white rounded-2xl shadow-md p-6">

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
      <!-- FORM -->
      <div class="bg-gray-50 p-5 rounded-xl border">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Agregar destino</h2>

        <form class="space-y-4">
          <div>
            <label class="text-sm text-gray-600">Nombre</label>
            <input id="nombreWS" type="text" class="w-full mt-1 p-3 border rounded-lg focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 outline-none">
          </div>

          <div>
            <label class="text-sm text-gray-600">Teléfono</label>
            <input id="movilWS" type="text" placeholder="Ej: 573001234567" class="w-full mt-1 p-3 border rounded-lg focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 outline-none">
          </div>

          <div>
            <label class="text-sm text-gray-600">Tipo</label>
            <select class="w-full mt-1 p-3 border rounded-lg focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 outline-none">
              <option value="individual">Individual</option>
              <option value="grupo">Grupo</option>
            </select>
          </div>

          <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-medium transition shadow">
            + Agregar destino
          </button>
        </form>
      </div>

      <!-- TABLA -->
      <div class="xl:col-span-2">

        <div class="border rounded-xl overflow-hidden">
          <!-- HEADER TABLA -->
          <div class="bg-gray-50 px-5 py-4 flex justify-between items-center border-b">
            <h2 class="text-lg font-semibold text-gray-800">Destinos configurados</h2>
            <span class="text-sm text-gray-400">1 registro</span>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left">

              <thead class="text-sm text-gray-500 uppercase">
                <tr>
                  <th class="p-4">Nombre</th>
                  <th>Teléfono</th>
                  <th>Tipo</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>

              <tbody class="text-sm text-gray-700 divide-y">

                <tr class="hover:bg-gray-50 transition">
                  <td class="p-4 font-medium">Administrador</td>
                  <td>573001234567</td>
                  <td>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs">
                      Individual
                    </span>
                  </td>
                  <td>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                      Activo
                    </span>
                  </td>
                  <td class="text-right pr-4">
                    <button class="text-red-500 hover:text-red-700 text-xs font-medium">
                      Eliminar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- ===================== -->
  <!-- 🔹 EVENTOS DEL SISTEMA -->
  <!-- ===================== -->
  <div class="bg-white p-6 md:p-8 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-8 text-gray-800">Eventos del sistema</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <!-- EVENTO -->
      <div class="border rounded-2xl p-6 hover:shadow-md transition">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Factura eliminada</h3>
        <p class="text-base text-gray-500 mb-6">Notifica cuando se elimina una factura</p>

        <div class="grid gap-4">
          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="factura" class="hidden peer">
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">Sí</span>
          </label>

          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="factura" class="hidden peer" checked>
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">No</span>
          </label>
        </div>
      </div>

      <!-- EVENTO -->
      <div class="border rounded-2xl p-6 hover:shadow-md transition">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Cierre de caja</h3>
        <p class="text-base text-gray-500 mb-6">Resumen al cerrar caja</p>

        <div class="grid gap-4">
          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="cierre" class="hidden peer" checked>
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">Sí</span>
          </label>

          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="cierre" class="hidden peer">
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">No</span>
          </label>
        </div>
      </div>

      <!-- EVENTO -->
      <div class="border rounded-2xl p-6 hover:shadow-md transition">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Stock mínimo</h3>
        <p class="text-base text-gray-500 mb-6">Alerta de inventario bajo</p>

        <div class="grid gap-4">
          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="stock" class="hidden peer">
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">Sí</span>
          </label>

          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="stock" class="hidden peer" checked>
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">No</span>
          </label>
        </div>
      </div>

      <div class="border rounded-2xl p-6 hover:shadow-md transition">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Envio de mercancia</h3>
        <p class="text-base text-gray-500 mb-6">Alerta de envio de mercancia entre sucursales</p>

        <div class="grid gap-4">
          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="stock" class="hidden peer">
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">Sí</span>
          </label>

          <label class="flex items-center p-4 bg-gray-50 border rounded-xl cursor-pointer hover:border-indigo-500">
            <input type="radio" name="stock" class="hidden peer" checked>
            <div class="w-6 h-6 border-2 rounded-full mr-3 peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
            <span class="text-lg">No</span>
          </label>
        </div>
      </div>

    </div>
  </div>

  <!-- BOTÓN -->
  <div class="flex justify-end">
    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-xl text-lg font-medium shadow">
      Guardar configuración
    </button>
  </div>

</div>