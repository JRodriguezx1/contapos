<div class="box ventasxcliente relative">
  <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>
  <a class="btn-xs btn-dark" href="/admin/reportes">Atras</a>
  <h4 class="text-gray-600 mb-8 mt-4">Ventas por cliente</h4>
  
  <div class="">
    <button id="btnmesactual" class="btn-xs btn-light">Mes actual</button>
    <button id="btnmesanterior" class="btn-xs btn-light">Mes anterior</button>
    <button id="btnhoy" class="btn-xs btn-light">Hoy</button>
    <button id="btnayer" class="btn-xs btn-light">Ayer</button>
    
    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-auto p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="datetimes" />
    <button id="consultarFechaPersonalizada" class="btn-md border border-gray-300 text-white !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 bg-indigo-600 hover:bg-indigo-800">Consultar</button>
  </div>

  <div class="mt-4">
    <p class="text-gray-500 text-xl">Septiembre 2025</p>
    <table id="tablaVentasXCliente" class="display responsive nowrap tabla" width="100%"></table>
  </div>

</div>