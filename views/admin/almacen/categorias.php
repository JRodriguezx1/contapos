<div class="box categorias">
  <!-- <a class="btn-xs btn-dark" href="/admin/almacen">Atras</a> -->

  <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>


  <h4 class="text-gray-600 mb-12 mt-4">Categorias</h4>
  <button id="crearCategoria" class="btn-md btn-blueintense !mb-4 !py-4 px-6 !bg-indigo-600">Crear categoria</button>
  <a class="btn-md btn-turquoise !py-4 !px-6" href="/admin/almacen/productos">Ir a productos</a>
  <table class="display responsive nowrap tabla" width="100%" id="tablaCategorias">
      <thead>
          <tr>
              <th>Nº</th>
              <th>Categoria</th>
              <th>N. productos</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($categorias as $index => $value): 
            if($value->visible == 1):?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->totalproductos;?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-categoria="<?php echo $value->nombre;?>"><button class="btn-md btn-turquoise editarCategoria"><i class="fa-solid fa-pen-to-square"></i></button><button class="btn-md btn-red eliminarCategoria"><i class="fa-solid fa-trash-can"></i></button></div></td>
          </tr>
          <?php endif; endforeach; ?>
      </tbody>
  </table>

  <dialog class="w-[500px] h-[195px] py-6 px-12 rounded-lg shadow-lg" id="miDialogoCategoria" id="miDialogoCategoria">
    <h4 id="modalCategoria" class="font-semibold text-gray-700 mb-4 mt-10">Crear categoria</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateCategoria" class="formulario" action="/admin/almacen/crear_categoria" method="POST">
        <input type="hidden" id="idcategoria" value="0">
        <div class="formulario__campo">
            <!-- <label class="formulario__label" for="categoria">Categoria</label> -->
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input class="formulario__input !border-0" type="text" placeholder="Categoria" id="categoria" name="nombre"  required>
                <!-- <label data-num="24" class="count-charts" for="">24</label> -->
            </div>
        </div>
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[100px]" type="button" value="Salir">Salir</button>
            <input  class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[100px]" type="submit" value="Crear" id="btnEditarCrearCategoria">
        </div>
    </form>
  </dialog><!--fin crear/editar categoria-->
</div>