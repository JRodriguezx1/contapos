<div class="gestionfacturadores">

  <div class="config-section-heading">
    <div class="config-section-heading__icon">
      <i class="fa-solid fa-receipt"></i>
    </div>
    <div>
      <h4>Gestion de facturadores</h4>
      <p>Administra consecutivos, rangos, fechas y estado de facturacion.</p>
    </div>
    <button id="crearFacturador" class="btn-md btn-indigo config-section-heading__action" type="button">
      <i class="fa-solid fa-plus"></i>
      Crear facturador
    </button>
  </div>

  <div class="config-table-card">
    <table id="tablaFacturadores" class="display responsive nowrap tabla config-data-table" width="100%">
      <thead>
        <tr>
          <th>N.</th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Rango</th>
          <th>Siguiente</th>
          <th>Expira</th>
          <th>Estado</th>
          <th class="accionesth">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($facturadores as $index => $value): 
          if($value->estado==1)?>
        <tr>
          <td><?php echo $index+1;?></td>
          <td>
            <span class="config-facturador-name">
              <span class="config-facturador-name__icon"><i class="fa-solid fa-receipt"></i></span>
              <span><?php echo $value->nombre; ?></span>
            </span>
          </td>
          <td><span class="config-table-pill config-table-pill--type"><?php echo $value->nombretipofacturador;?></span></td>
          <td><span class="config-table-pill config-table-pill--range"><?php echo $value->rangoinicial.' - '.$value->rangofinal; ?></span></td>
          <td><span class="config-table-pill config-table-pill--next"><?php echo $value->siguientevalor;?></span></td>
          <td><span class="config-table-pill config-table-pill--date"><?php echo $value->fechafin; ?></span></td>
          <td><span class="config-table-status <?php echo $value->estado==1?'config-table-status--active':'config-table-status--expired';?>"><?php echo $value->estado==1?'Activo':'Expirada';?></span></td>
          <td class="accionestd">
            <div class="acciones-btns" id="<?php echo $value->id;?>" data-facturador="<?php echo $value->nombre;?>">
              <button class="btn-md btn-turquoise editarFacturador" title="Actualizar facturador"><i class="fa-solid fa-pen-to-square"></i></button>
              <?php if($value->id > 1): ?>
              <button class="btn-md btn-red eliminarFacturador" title="Eliminar facturador"><i class="fa-solid fa-trash-can"></i></button>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <dialog id="miDialogoFacturador" class="midialog-sm config-caja-dialog config-facturador-dialog">
    <div class="config-caja-dialog__header">
      <span class="config-caja-dialog__icon"><i class="fa-solid fa-receipt"></i></span>
      <div>
        <span class="config-caja-dialog__eyebrow">Facturador</span>
        <h4 id="modalFacturador">Crear facturador</h4>
        <p>Configura el consecutivo, rango, vigencia y negocio asociado.</p>
      </div>
    </div>

    <form id="formCrearUpdateFacturador" class="config-caja-dialog__form" action="/admin/config/crear_facturador" method="POST">
      <div id="divmsjalertafacturador"></div>

      <div class="config-caja-dialog__grid">
        <div class="config-caja-dialog__field">
          <label for="nombrefacturador">Nombre</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-file-lines"></i></span>
            <input id="nombrefacturador" type="text" placeholder="Nombre del facturador" name="nombre" value="" required>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="idtipofacturador">Tipo facturador</label>
          <div class="config-caja-dialog__select">
            <span><i class="fa-solid fa-layer-group"></i></span>
            <select id="idtipofacturador" name="idtipofacturador" required>
              <option value="" disabled selected>-Seleccionar-</option>
              <?php foreach($tipofacturadores as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="rangoinicial">Consecutivo inicial</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
            <input id="rangoinicial" type="text" placeholder="Consecutivo inicial" name="rangoinicial" value="" required>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="rangofinal">Consecutivo final</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-arrow-right-to-bracket"></i></span>
            <input id="rangofinal" type="text" placeholder="Consecutivo final" name="rangofinal" value="" required>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="siguientevalor">Siguiente consecutivo</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-hashtag"></i></span>
            <input id="siguientevalor" type="text" placeholder="Siguiente consecutivo" name="siguientevalor" value="" required>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="prefijo">Prefijo</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-tag"></i></span>
            <input id="prefijo" type="text" placeholder="Prefijo de la resolucion" name="prefijo" value="" required>
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="fechainicio">Fecha inicio</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-calendar-day"></i></span>
            <input id="fechainicio" type="date" name="fechainicio" value="">
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="fechafin">Fecha fin</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-calendar-check"></i></span>
            <input id="fechafin" type="date" name="fechafin" value="">
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="resolucion">Numero de resolucion</label>
          <div class="config-caja-dialog__control">
            <span><i class="fa-solid fa-certificate"></i></span>
            <input id="resolucion" type="text" placeholder="Numero de resolucion" name="resolucion" value="">
          </div>
        </div>

        <div class="config-caja-dialog__field">
          <label for="negociofacturador">Negocio</label>
          <div class="config-caja-dialog__select">
            <span><i class="fa-solid fa-store"></i></span>
            <select id="negociofacturador" name="negocio" required>
              <option value="" disabled selected>-Seleccionar-</option>
              <option value="<?php echo $negocio->id;?>"><?php echo $negocio->nombre;?></option>
            </select>
          </div>
        </div>
      </div>

      <div class="config-caja-dialog__actions">
        <button class="config-caja-dialog__button config-caja-dialog__button--ghost" type="button" value="Salir">Salir</button>
        <input id="btnEditarCrearFacturador" class="config-caja-dialog__button config-caja-dialog__button--primary" type="submit" value="Crear">
      </div>
    </form>
  </dialog><!--fin crear/editar facturador-->
</div>
