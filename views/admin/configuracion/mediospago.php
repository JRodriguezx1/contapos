<div class="mediosPagos">

  <div class="config-section-heading">
    <div class="config-section-heading__icon">
      <i class="fa-solid fa-credit-card"></i>
    </div>
    <div>
      <h4>Gestion de medios de pago</h4>
      <p>Administra los metodos disponibles para registrar pagos.</p>
    </div>
    <button id="crearMedioPago" class="btn-md btn-indigo config-section-heading__action" type="button">
      <i class="fa-solid fa-plus"></i>
      Crear medio
    </button>
  </div>
  <div class="config-table-card">
  <table id="tablamediosPagos" class="display responsive nowrap tabla config-data-table" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($mediospago as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td>
                <span class="config-payment-name">
                  <span class="config-payment-name__icon"><i class="fa-solid fa-credit-card"></i></span>
                  <span><?php echo $value->mediopago;?></span>
                </span>
              </td> 
              <td class="">
                <?php if($value->id != 1):?>
                    <button id="<?php echo $value->id;?>" data-state="<?php echo $value->estado;?>" class="statemediopago config-table-status <?php echo $value->estado==1?'config-table-status--active':'config-table-status--inactive';?>"><?php echo $value->estado==1?'Activo':'Inactivo';?></button>
                <?php endif;?>
            </td>
              <td class="accionestd">
                <?php if($value->id != 1):?>
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-mediopago="<?php echo $value->mediopago;?>">
                    <button class="btn-md btn-turquoise editarMedioPago"><i class="fa-solid fa-pen-to-square" title="Actualizar el mediopago"></i></button>
                    <button class="btn-md btn-red eliminarMedioPago" title="Eliminar mediopago"><i class="fa-solid fa-trash-can"></i></button>
                </div>
                <?php endif;?>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>
  </div>

  <dialog id="miDialogoMedioPago" class="midialog-sm config-caja-dialog config-param-dialog">
    <div class="config-caja-dialog__header">
      <span class="config-caja-dialog__icon">
        <i class="fa-solid fa-credit-card"></i>
      </span>
      <div>
        <span class="config-caja-dialog__eyebrow">Medio de pago</span>
        <h4 id="modalMedioPago">Crear medio de pago</h4>
        <p>Registra el metodo que estara disponible para recibir pagos.</p>
      </div>
    </div>

    <form id="formCrearUpdateMedioPago" class="config-caja-dialog__form" action="/admin/config/crear_MedioPago" method="POST">
        <div id="divmsjalertaMedioPago"></div>

        <div class="config-caja-dialog__field">
            <label for="nombreMedioPago">Nombre</label>
            <div class="config-caja-dialog__control">
              <span><i class="fa-solid fa-wallet"></i></span>
              <input id="nombreMedioPago" type="text" placeholder="Nombre del medio de pago" name="nombre" value="" required>
            </div>
        </div> 
        
        <div class="config-caja-dialog__actions">
            <button class="config-caja-dialog__button config-caja-dialog__button--ghost" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearMedioPago" class="config-caja-dialog__button config-caja-dialog__button--primary" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar medio de pago-->
  
</div>
