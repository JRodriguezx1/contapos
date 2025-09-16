<div class="box tlg:h-full flex flex-col almacen !pb-20">
  <h4 class="text-gray-600 mb-12">Almacen</h4>
  <div class="flex flex-wrap gap-4 mb-4">
        <a class="btn-command" href="/admin/almacen/categorias"><span class="material-symbols-outlined">tv_options_edit_channels</span>Categorias</a>
        <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/almacen/productos"><span class="material-symbols-outlined">grid_view</span>Productos</a> 
        <a class="btn-command text-center" href="/admin/almacen/subproductos"><span class="material-symbols-outlined">landscape</span>Sub Productos</a>
        <!--<a class="btn-command" href="/admin/almacen/componer"><span class="material-symbols-outlined">precision_manufacturing</span>Componer</a>-->
        <a class="btn-command text-center" href="/admin/almacen/ajustarcostos"><span class="material-symbols-outlined">attach_money</span>Ajustar Costos</a>
        <a class="btn-command" href="/admin/almacen/compras"><span class="material-symbols-outlined">pallet</span>Compras</a>
        <!--<a class="btn-command" href="/admin/almacen/distribucion"><span class="material-symbols-outlined">linked_services</span>Distribucion</a>-->
        <a class="btn-command" href="/admin/almacen/inventariar"><span class="material-symbols-outlined">inventory</span>Inventariar</a>
        <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/almacen/unidadesmedida"><span class="material-symbols-outlined">square_foot</span>Unidades de Medida</a>
        <!--<a class="btn-command text-center" href="/admin/almacen/trasladoinventario"><span class="material-symbols-outlined">switch_right</span>Traslado de inventario</a>-->
        <button id="btntrasladoinvnetario" class="btn-command text-center"><span class="material-symbols-outlined">switch_right</span>Traslado de inventario</button>
  </div>

  <div class="tlg:flex flex-1 tlg:overflow-hidden accordion_inv">
    <input type="radio" name="radio" id="infoalmacen" checked>
    <input type="radio" name="radio" id="stockproducto">
    <input type="radio" name="radio" id="utilidadproducto">
    <input type="radio" name="radio" id="sedes">
    <input type="radio" name="radio" id="ordenproduccion">

    <div class="text-center border border-gray-300 p-3 tlg:w-40 btn_inv_info_rapido">
      <span class="text-xl text-gray-600">Informacion Inventario</span>
      <div>
        <label class="btn-xs btn-indigo !py-4 mt-4 btninfoalmacen" for="infoalmacen">Inform... Almacen</label>
        <label class="btn-xs btn-indigo !py-4 mt-4 btnstockproducto" for="stockproducto">Stock Rapido</label>
        <label class="btn-xs btn-indigo !py-4 mt-4 btnutilidadproducto" for="utilidadproducto">Utilidad Producto</label>
        <label class="btn-xs btn-indigo !py-4 mt-4 tlg:!w-full btnsedes" for="sedes">Sedes</label>
        <label class="btn-xs btn-indigo !py-4 mt-4 tlg:!w-full btnproveedores" for="proveedores">Proveedores</label>
        <label class="btn-xs btn-indigo !py-4 mt-4 tlg:!w-full btnordenproduccion" for="ordenproduccion">Orden Produccion</label>
      </div>
    </div>
    
    <div class="flex-1 tlg:overflow-y-scroll tlg:pl-4 tablas_inv_rapido">
      
      <div class="infoalmacen accordion_tab_content py-4">
        <?php include __DIR__. "/tableroindicadores.php"; ?>
      </div>  <!-- fin tablero indicaderos -->

      <div class="tablastock accordion_tab_content">
        <?php include __DIR__. "/stockrapido.php"; ?>
      </div> <!-- fin <div class="stockproductos"> -->

      <!-- utilidad -->
      <div class="tablautilidad accordion_tab_content">
        <?php include __DIR__. "/utilidadproducto.php"; ?>
      </div> <!-- fin tablautilidad-->

      <!-- sedes -->
      <div class="sedes accordion_tab_content relative h-full">
        <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>
        <?php include __DIR__. "/sedes.php"; ?>
      </div> <!-- fin sedes-->

      <div class="ordenproduccion accordion_tab_content pt-12 bg-gray-50 dark:bg-gray-900 sm:pt-20 pb-12 sm:pb-16">
        <?php include __DIR__. "/ordenproduccion.php"; ?>
      </div>

  </div> <!-- fin accordion_inv -->

  <!-- MODAL DE OPCIONES DE TRASLADO DE INVENTARIOS -->
<dialog id="miDialogoTrasladoInvnetario" class="rounded-2xl border border-gray-200 dark:border-neutral-700 w-[95%] max-w-2xl p-8 bg-white dark:bg-neutral-900 backdrop:bg-black/40">
  <!-- Encabezado -->
  <div class="flex justify-between items-center border-b border-gray-200 dark:border-neutral-700 pb-4 mb-6">
    <h4 id="modalTrasladoInvnetario" class="text-2xl font-bold text-gray-900 dark:text-gray-100">
      Gestión de traslado de inventario
    </h4>
    <button id="btnXCerrarTrasladoInvnetario" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 transition">
      <i class="fa-solid fa-xmark text-gray-600 dark:text-gray-300 text-2xl"></i>
    </button>
  </div>

  <!-- Opciones -->
  <div class="grid gap-4">
    <a class="flex items-center justify-between px-6 py-5 rounded-xl border border-gray-200 dark:border-neutral-700 hover:bg-indigo-50 dark:hover:bg-neutral-800 transition"
       href="/admin/almacen/trasladoinventario">
       <span class="flex items-center gap-3 text-gray-900 dark:text-gray-100 text-lg font-medium">
         <span class="material-symbols-outlined text-indigo-600 text-3xl">switch_right</span>
         Traslado de inventario
       </span>
       <i class="fa-solid fa-chevron-right text-gray-400 text-xl"></i>
    </a>
    
    <a class="flex items-center justify-between px-6 py-5 rounded-xl border border-gray-200 dark:border-neutral-700 hover:bg-indigo-50 dark:hover:bg-neutral-800 transition"
       href="/admin/almacen/solicitarinventario">
       <span class="flex items-center gap-3 text-gray-900 dark:text-gray-100 text-lg font-medium">
         <span class="material-symbols-outlined text-indigo-600 text-3xl">switch_right</span>
         Solicitar inventario
       </span>
       <i class="fa-solid fa-chevron-right text-gray-400 text-xl"></i>
    </a>
  </div>
</dialog>


</div>