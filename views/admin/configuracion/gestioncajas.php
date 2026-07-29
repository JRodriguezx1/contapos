<div class="gestioncajas">

  <div class="config-section-heading">
    <div class="config-section-heading__icon">
      <i class="fa-solid fa-cash-register"></i>
    </div>
    <div>
      <h4>Gestion de cajas facturadoras</h4>
      <p>Administra las cajas, facturadores y emisores asociados a la operacion.</p>
    </div>
    <button id="crearCaja" class="btn-md btn-indigo config-section-heading__action" type="button">
      <i class="fa-solid fa-plus"></i>
      Crear caja
    </button>
  </div>

  <div class="config-table-card">
    <table id="tablaCajas" class="display responsive nowrap tabla config-data-table" width="100%">
      <thead>
        <tr>
          <th>N.</th>
          <th>Caja</th>
          <th>Facturador automatico</th>
          <th>Sede</th>
          <th>Emisor</th>
          <th class="accionesth">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($cajas as $index => $value): ?>
          <tr>
            <td><?php echo $index+1;?></td>
            <td>
              <span class="config-caja-name">
                <span class="config-caja-name__icon"><i class="fa-solid fa-cash-register"></i></span>
                <span><?php echo $value->nombre; ?></span>
              </span>
            </td>
            <td>
              <span class="config-table-pill config-table-pill--invoice"><?php echo $value->nombreconsecutivo->nombre;?></span>
            </td>
            <td>
              <span class="config-table-pill config-table-pill--branch"><?php echo $value->negocio;?></span>
            </td>
            <td>
              <span class="config-table-pill config-table-pill--issuer"><?php echo isset($nombreEmisores[$value->idemisor])? $nombreEmisores[$value->idemisor]: $negocio->negocio;?></span>
            </td>
            <td class="accionestd">
              <div class="acciones-btns" id="<?php echo $value->id;?>" data-caja="<?php echo $value->nombre;?>">
                <button class="btn-md btn-turquoise editarCaja"><i class="fa-solid fa-pen-to-square" title="Actualizar datos de caja"></i></button>
                <?php if($value->editable == 1): ?>
                  <button class="btn-md btn-red eliminarCaja" title="Eliminar caja"><i class="fa-solid fa-trash-can"></i></button>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <dialog id="miDialogoCaja" class="midialog-sm config-caja-dialog">
    <div class="config-caja-dialog__header">
      <span class="config-caja-dialog__icon"><i class="fa-solid fa-cash-register"></i></span>
      <div>
        <span class="config-caja-dialog__eyebrow">Caja</span>
        <h4 id="modalCaja">Crear caja</h4>
        <p>Configura la caja, su facturador automatico, sede y emisor asociado.</p>
      </div>
    </div>

    <form id="formCrearUpdateCaja" class="config-caja-dialog__form" action="/admin/config/crear_caja" method="POST">
      <div id="divmsjalertacaja"></div>

      <div class="config-caja-dialog__grid">
        <div class="config-caja-dialog__field config-caja-dialog__field--wide">
          <label for="nombrecaja">Nombre</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-cash-register"></i></span>
            <input id="nombrecaja" type="text" placeholder="Nombre de la caja" name="nombre" value="" required>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="idtipoconsecutivo">Facturador automatico</label>
          <div class="config-caja-dialog__select">
            <span><i class="fa-solid fa-receipt"></i></span>
            <select id="idtipoconsecutivo" name="idtipoconsecutivo" required>
              <option value="" disabled selected>-Seleccionar-</option>
              <?php foreach($facturadores as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="negociogestioncaja">Sede</label>
          <div class="config-caja-dialog__select">
            <span><i class="fa-solid fa-store"></i></span>
            <select id="negociogestioncaja" name="negocio" required>
              <option value="" disabled selected>-Seleccionar-</option>
              <option value="<?php echo $negocio->id;?>"><?php echo $negocio->nombre;?></option>
            </select>
          </div>
        </div>

        <div class="config-caja-dialog__field config-caja-dialog__field--wide">
          <label for="idEmisorCaja">Emisor</label>
          <div class="config-caja-dialog__select">
            <span><i class="fa-solid fa-id-card-clip"></i></span>
            <select id="idEmisorCaja" name="idEmisorCaja">
              <option value="" selected> <?php echo $negocio->negocio;?> </option>
              <?php foreach($emisores as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="config-caja-dialog__actions">
        <button class="config-caja-dialog__button config-caja-dialog__button--ghost" type="button" value="Salir">Salir</button>
        <input id="btnEditarCrearCaja" class="config-caja-dialog__button config-caja-dialog__button--primary" type="submit" value="Crear">
      </div>
    </form>
  </dialog><!--fin crear/editar caja-->
</div>
