<div class="box movimientosinventarios relative">
  <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>
  <a href="/admin/reportes" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2   ">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>
  
  <h4 class="text-gray-600 mb-8 mt-4">Movimientos de inventarios</h4>
  
  <div class="flex flex-col gap-4">

    <!-- Input y botón consultar -->
    <div class="flex items-center gap-3">
      <input 
        id="item"
        type="text" 
        name="item" 
        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-indigo-600 block w-80 p-3 text-base focus:outline-none focus:ring-2 focus:ring-indigo-500"
        placeholder="Seleccionar item"
        multiple="multiple"
      />

      <input 
        type="text" 
        name="datetimes" 
        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-indigo-600 block w-60 p-3 text-base focus:outline-none focus:ring-2 focus:ring-indigo-500"
        placeholder="Seleccionar fecha"
      />
      <button id="consultarFechaPersonalizada" class="px-6 py-3 text-base font-medium bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-md transition">
        Consultar
      </button>
    </div>
  </div>


  <div class="mt-4">
    <p class="text-gray-500 text-xl">Octubre 2025</p>
    <table id="tablaMovimientosInventarios" class="display responsive nowrap tabla" width="100%">
        <thead>
          <tr>
              <th>Nº</th>
              <th>Usuario</th>
              <th>Origen</th>
              <th>Proveedor</th>
              <th>N° Factura</th>
              <th>V. Total</th>
              <th>Fecha</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          
      </tbody>
    </table>
  </div>
</div>