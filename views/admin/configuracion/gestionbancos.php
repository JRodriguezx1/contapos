<div class="gestionbancos">

  <div class="config-section-heading">
    <div class="config-section-heading__icon">
      <i class="fa-solid fa-building-columns"></i>
    </div>
    <div>
      <h4>Gestion de bancos</h4>
      <p>Administra cuentas bancarias disponibles para pagos y movimientos.</p>
    </div>
    <button id="crearBanco" class="btn-md btn-indigo config-section-heading__action" type="button">
      <i class="fa-solid fa-plus"></i>
      Crear banco
    </button>
  </div>
  <div class="config-table-card">
  <table id="tablaBancos" class="display responsive nowrap tabla config-data-table" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Numero de cuenta</th>
              <th>Fecha</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($bancos as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td>
                <span class="config-bank-name">
                  <span class="config-bank-name__icon"><i class="fa-solid fa-building-columns"></i></span>
                  <span><?php echo $value->nombre; ?></span>
                </span>
              </td> 
              <td><span class="config-table-pill config-table-pill--account"><?php echo $value->numerocuenta;?></span></td>
              <td><span class="config-table-pill config-table-pill--date"><?php echo $value->created_at;?></span></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-banco="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarBanco"><i class="fa-solid fa-pen-to-square" title="Actualizar datos del banco"></i></button>
                    <button class="btn-md btn-red eliminarBanco" title="Eliminar banco"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>
  </div>

  <dialog id="miDialogoBanco" class="midialog-sm config-caja-dialog config-banco-dialog">
    <div class="config-caja-dialog__header">
      <span class="config-caja-dialog__icon">
        <i class="fa-solid fa-building-columns"></i>
      </span>
      <div>
        <span class="config-caja-dialog__eyebrow">Banco</span>
        <h4 id="modalBanco">Crear banco</h4>
        <p>Registra la cuenta bancaria disponible para pagos y movimientos.</p>
      </div>
    </div>

    <form id="formCrearUpdateBanco" class="config-caja-dialog__form" action="/admin/config/crear_Banco" method="POST">
        <div id="divmsjalertaBanco"></div>

        <div class="config-caja-dialog__grid">
            <div class="config-caja-dialog__field">
                <label for="nombreBanco">Nombre</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-building-columns"></i></span>
                  <input id="nombreBanco" type="text" placeholder="Nombre del banco" name="nombre" value="" required>
                </div>
            </div>
            <div class="config-caja-dialog__field">
                <label for="numeroCuenta">Numero de cuenta</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-credit-card"></i></span>
                  <input id="numeroCuenta" type="text" placeholder="Numero de cuenta" name="numerocuenta" value="">
                </div>
            </div>
        </div>
        
        <div class="config-caja-dialog__actions">
            <button class="config-caja-dialog__button config-caja-dialog__button--ghost" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearBanco" class="config-caja-dialog__button config-caja-dialog__button--primary" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Banco-->
  
</div>
