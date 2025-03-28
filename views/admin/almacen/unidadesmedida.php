<div class="box unidadesmedida">
<a class="btn-xs btn-dark" href="/admin/almacen">Atras</a>
  <h4 class="text-gray-600 mb-12 mt-4">Unidades de medida</h4>
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <button id="btnCrearUnidadMedida" class="btn-md btn-blueintense mb-4">Crear unidad</button>
  <table class="display responsive nowrap tabla" width="100%" id="tablaUnidadesMedida">
      <thead>
          <tr>
              <th>Nº</th>
              <th>Unidad</th>
              <th>Fecha creacion</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($unidadesmedida as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>
              <td class=""><?php echo $value->nombre;?></td>
              <td class=""><?php echo $value->fechacreacion??'';?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-unidadmedida="<?php echo $value->nombre;?>">
                <?php if($value->editable == '1'){ ?>
                <button class="btn-md btn-turquoise editarUnidadMedida"><i class="fa-solid fa-pen-to-square"></i></button>
                <!--<button class="btn-md btn-red eliminarUnidadMedida"><i class="fa-solid fa-trash-can"></i></button></div>-->
                <form method="POST" class="formEliminarUnidadMedida" action="/admin/almacen/unidadesmedida">
                    <input type="hidden" name="id" value="<?php echo $value->id;?>"> 
                    <button class="btn-md btn-red eliminarUnidadMedida" type="button">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
                <?php }else{ echo "No Action"; } ?>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>


  <dialog class="midialog-sm p-5" id="miDialogoUnidadMedida">
    <h4 id="modalUnidadMedida" class="font-semibold text-gray-700 mb-4">Crear unidad de medida</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateUnidad" class="formulario" action="/admin/almacen/crear_unidadmedida" enctype="multipart/form-data" method="POST">
        <input type="hidden" id="idunidadmedida" name="idunidad" value="">
        <div class="formulario__campo">
            <label class="formulario__label" for="unidad">Unidad</label>
            <div class="formulario__dato">
                <input class="formulario__input" type="text" placeholder="Nombre de la unidad de medida" id="unidad" name="nombre" value="<?php echo $unidadmedida->nombre??'';?>" required>
                <label data-num="28" class="count-charts" for="">28</label>
            </div>
        </div>
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearUnidadMedida" class="btn-md btn-blue" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar unidad-->
</div>