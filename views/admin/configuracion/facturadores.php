<div class="gestionfacturadores">

  <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>


  <h4 class="text-gray-600 mb-12 mt-4">Gestion de facturadoras</h4>
  <button id="crearCaja" class="btn-md btn-blueintense !mb-4 !py-4 px-6 !bg-indigo-600">Crear facturador</button>
  <table class="display responsive nowrap tabla" width="100%" id="tablaCajas">
      <thead>
          <tr>
              <th>Nº</th>
              <th>Caja</th>
              <th>Negocio</th>
              <th>Facturador automatico</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($cajas as $index => $value): 
            if($value->visible == 1):?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->totalproductos;?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-caja="<?php echo $value->nombre;?>"><button class="btn-md btn-turquoise editarCaja"><i class="fa-solid fa-pen-to-square"></i></button><button class="btn-md btn-red eliminarCaja"><i class="fa-solid fa-trash-can"></i></button></div></td>
          </tr>
          <?php endif; endforeach; ?>
      </tbody>
  </table>

  <dialog class="w-[500px] h-[195px] p-6 rounded-lg shadow-lg" id="miDialogoCaja" id="miDialogoCaja">
    <h4 id="modalCaja" class="font-semibold text-gray-700 mb-4 mt-10">Crear caja</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateCaja" class="formulario" action="/admin/almacen/crear_caja" method="POST">
        <input type="hidden" id="idcaja" value="0">
        <div class="formulario__campo">
            <!-- <label class="formulario__label" for="caja">Caja</label> -->
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input class="formulario__input !border-0" type="text" placeholder="Caja" id="caja" name="nombre"  required>
                <!-- <label data-num="24" class="count-charts" for="">24</label> -->
            </div>
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[100px]" type="button" value="Salir">Salir</button>
            <input  class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[100px]" type="submit" value="Crear" id="btnEditarCrearCaja">
        </div>
    </form>
  </dialog><!--fin crear/editar caja-->
</div>