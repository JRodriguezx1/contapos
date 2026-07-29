<div class="tarifas">

  <div class="config-section-heading">
    <div class="config-section-heading__icon">
      <i class="fa-solid fa-percent"></i>
    </div>
    <div>
      <h4>Gestion de tarifas</h4>
      <p>Administra valores de tarifas disponibles para ventas y operaciones.</p>
    </div>
    <button id="crearTarifa" class="btn-md btn-indigo config-section-heading__action" type="button">
      <i class="fa-solid fa-plus"></i>
      Crear tarifa
    </button>
  </div>
  <div class="config-table-card">
  <table id="tablaTarifas" class="display responsive nowrap tabla config-data-table" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Valor tarifa</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($tarifas as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td>
                <span class="config-tarifa-name">
                  <span class="config-tarifa-name__icon"><i class="fa-solid fa-percent"></i></span>
                  <span><?php echo $value->nombre; ?></span>
                </span>
              </td> 
              <td><span class="config-table-pill config-table-pill--money">$<?php echo number_format($value->valor??0, '2', ',', '.');?></span></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-tarifa="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarTarifa"><i class="fa-solid fa-pen-to-square" title="Actualizar datos del tarifa"></i></button>
                    <button class="btn-md btn-red eliminarTarifa" title="Eliminar tarifa"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>
  </div>

  <dialog id="miDialogoTarifa" class="midialog-sm config-caja-dialog config-param-dialog">
    <div class="config-caja-dialog__header">
      <span class="config-caja-dialog__icon">
        <i class="fa-solid fa-percent"></i>
      </span>
      <div>
        <span class="config-caja-dialog__eyebrow">Tarifa</span>
        <h4 id="modalTarifa">Crear tarifa</h4>
        <p>Define el nombre y valor que se usara en ventas y operaciones.</p>
      </div>
    </div>

    <form id="formCrearUpdateTarifa" class="config-caja-dialog__form" action="/admin/config/crear_Tarifa" method="POST">
        <div id="divmsjalertaTarifa"></div>

        <div class="config-caja-dialog__grid">
            <div class="config-caja-dialog__field">
                <label for="nombreTarifa">Nombre</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-tag"></i></span>
                  <input id="nombreTarifa" type="text" placeholder="Nombre de la tarifa" name="nombre" value="" required>
                </div>
            </div>
            <div class="config-caja-dialog__field">
                <label for="valorTarifa">Valor tarifa</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-dollar-sign"></i></span>
                  <input id="valorTarifa" type="text" placeholder="Valor de la tarifa" name="valor" value="" required>
                </div>
            </div>
        </div>  
        
        <div class="config-caja-dialog__actions">
            <button class="config-caja-dialog__button config-caja-dialog__button--ghost" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearTarifa" class="config-caja-dialog__button config-caja-dialog__button--primary" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Tarifa-->
  
</div>
