<div class="box categorias">
  <a class="btn-xs btn-dark" href="/admin/almacen">Atras</a>
  <h4 class="text-gray-600 mb-12 mt-4">Categorias</h4>
  <button id="crearCategoria" class="btn-md btn-blueintense mb-4">Crear categoria</button>
  <a class="btn-md btn-lima" href="/admin/almacen/productos">Ir a productos</a>
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
          <?php foreach($categorias as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td class="" ><?php echo $value->nombre; ?></td> 
              <td class=""><?php echo $value->totalproductos;?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-categoria="<?php echo $value->nombre;?>"><button class="btn-md btn-turquoise editarCategoria"><i class="fa-solid fa-pen-to-square"></i></button><button class="btn-md btn-red eliminarCategoria"><i class="fa-solid fa-trash-can"></i></button></div></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  <dialog class="midialog-xs p-5" id="miDialogoCategoria">
    <h4 id="modalCategoria" class="font-semibold text-gray-700 mb-4">Crear categoria</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateCategoria" class="formulario" action="/admin/almacen/crear_categoria" method="POST">
        <input type="hidden" id="idcategoria" value="0">
        <div class="formulario__campo">
            <label class="formulario__label" for="categoria">Categoria</label>
            <div class="formulario__dato">
                <input class="formulario__input" type="text" placeholder="Categoria" id="categoria" name="nombre"  required>
                <label data-num="24" class="count-charts" for="">24</label>
            </div>
        </div>
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="Salir">Salir</button>
            <input  class="btn-md btn-blue" type="submit" value="Crear" id="btnEditarCrearCategoria">
        </div>
    </form>
  </dialog><!--fin crear/editar categoria-->
</div>