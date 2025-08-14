<div class="box tlg:h-full flex flex-col almacen">
  <h4 class="text-gray-600 mb-12">Almacen</h4>
  <div class="flex flex-wrap gap-4 mb-4">
        <a class="btn-command" href="/admin/almacen/categorias"><span class="material-symbols-outlined">tv_options_edit_channels</span>Categorias</a>
        <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/almacen/productos"><span class="material-symbols-outlined">grid_view</span>Productos</a> 
        <a class="btn-command text-center" href="/admin/almacen/subproductos"><span class="material-symbols-outlined">landscape</span>Sub Productos</a>
        <!--<a class="btn-command" href="/admin/almacen/componer"><span class="material-symbols-outlined">precision_manufacturing</span>Componer</a>-->
        <a class="btn-command text-center" href="/admin/almacen/ajustarcostos"><span class="material-symbols-outlined">attach_money</span>Ajustar costos</a>
        <a class="btn-command" href="/admin/almacen/compras"><span class="material-symbols-outlined">pallet</span>Compras</a>
        <!--<a class="btn-command" href="/admin/almacen/distribucion"><span class="material-symbols-outlined">linked_services</span>Distribucion</a>-->
        <a class="btn-command" href="/admin/almacen/inventariar"><span class="material-symbols-outlined">inventory</span>Inventariar</a>
        <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/almacen/unidadesmedida"><span class="material-symbols-outlined">square_foot</span>Unidades de medida</a>
  </div>

  <div class="tlg:flex flex-1 tlg:overflow-hidden accordion_inv">
    <input type="radio" name="radio" id="infoalmacen" checked>
    <input type="radio" name="radio" id="stockproducto">
    <input type="radio" name="radio" id="utilidadproducto">
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

      <div class="ordenproduccion accordion_tab_content pt-12 bg-gray-50 dark:bg-gray-900 sm:pt-20 pb-12 sm:pb-16">
        <?php include __DIR__. "/ordenproduccion.php"; ?>
      </div>

  </div> <!-- fin accordion_inv -->

</div>