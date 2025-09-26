<div class="box ventasxtransaccion">
  <a class="btn-xs btn-dark" href="/admin/reportes">Atras</a>
  <h4 class="text-gray-600 mb-8 mt-4">Ventas por transaccion</h4>
  
  <div class="">
    <button id="btnanual" class="btn-xs btn-light">Anual</button>
    <button id="btnmensual" class="btn-xs btn-light">Mensual</button>
    <button id="btndiario" class="btn-xs btn-light">Diario</button>
  </div>

  <div class="mt-4">
    <p class="text-gray-500 text-xl">Septiembre 2024</p>
    <!--<table class="display responsive nowrap tabla" width="100%" id="">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Fecha</th>
                <th>Total Venta</th>
                <th>Numero de Transacciones</th>
                <th>Promedio por Transacción</th>
                <th>Transacción mas alta</th>
                <th>Transacción mas baja</th>
            </tr>
        </thead>
    </table>-->
    <table id="tablaTransaccioneXVenta" class="display responsive nowrap tabla" width="100%"></table>
  </div>

  <dialog id="miDialogoMes" class="midialog-xs p-8">
    <h4 class=" text-gray-700 font-semibold">Aplicar cambios</h4>
    <form id="formMes" class=" border-b border-gray-900/10 pb-6 text-center">
        <p class="mt-2 text-xl text-gray-600">Seleccionar año.</p>
        <input id="inputselectaño" type="number" name="año" min="2000" max="2100" step="1" value="2025" required>
        <div class="grid grid-cols-2 gap-3 mt-6">
            <button type="button" class="btn-md btn-turquoise !py-4 !px-6 w-full salir">Salir</button>
            <button id="btnaplicaraño" type="submit"class="btn-md btn-indigo !py-4 !px-6 w-full crearAddDir">Aplicar</button>
        </div>
    </form>

  </dialog>

  <dialog id="miDialogoDiario" class="midialog-xs p-8">
    <h4 class=" text-gray-700 font-semibold">Aplicar cambios</h4>
    <form id="formDiario" class=" border-b border-gray-900/10 pb-6 text-center">
        <p class="mt-2 text-xl text-gray-600">Seleccionar mes.</p>
        <input id="inputselectmesyaño" type="month" name="mes" required>
        <div class="grid grid-cols-2 gap-3 mt-6">
            <button type="button" class="btn-md btn-turquoise !py-4 !px-6 w-full salir">Salir</button>
            <button id="btnaplicarmes" type="submit"class="btn-md btn-indigo !py-4 !px-6 w-full crearAddDir">Aplicar</button>
        </div>
    </form>
  </dialog>

</div>