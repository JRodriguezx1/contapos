<div class="gestionimpresoras">

  <div class="config-section-heading">
    <div class="config-section-heading__icon">
      <i class="fa-solid fa-print"></i>
    </div>
    <div>
      <h4>Gestion de impresoras</h4>
      <p>Administra puntos de impresion, estaciones y ancho de papel.</p>
    </div>
    <button id="crearImpresora" class="btn-md btn-indigo config-section-heading__action" type="button">
      <i class="fa-solid fa-plus"></i>
      Crear punto
    </button>
  </div>
  <div class="config-table-card">
  <table id="tablaImpresoras" class="display responsive nowrap tabla config-data-table" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th>Nombre</th>
              <th>Nombre compartido</th>
              <th>Estacion</th>
              <th>Mm</th>
              <th>Estado</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($impresoras as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>        
              <td>
                <span class="config-printer-name">
                  <span class="config-printer-name__icon"><i class="fa-solid fa-print"></i></span>
                  <span><?php echo $value->nombre; ?></span>
                </span>
              </td> 
              <td><span class="config-table-pill config-table-pill--shared"><?php echo $value->nombrecompartido;?></span></td>
              <td><span class="config-table-pill config-table-pill--station"><?php echo $value->estacion;?></span></td>
              <td><span class="config-table-pill config-table-pill--paper"><?php echo $value->mm;?> mm</span></td>
              <td><span class="config-table-status <?php echo $value->estado==1?'config-table-status--active':'config-table-status--inactive';?>"><?php echo $value->estado==1?'Activa':'Inactiva';?></span></td>
              <td class="accionestd">
                <div class="acciones-btns" id="<?php echo $value->id;?>" data-impresora="<?php echo $value->nombre;?>">
                    <button class="btn-md btn-turquoise editarImpresora"><i class="fa-solid fa-pen-to-square" title="Actualizar punto de impresion"></i></button>
                    <button class="btn-md btn-red eliminarImpresora" title="Eliminar Impresora"><i class="fa-solid fa-trash-can"></i></button>
                </div>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>
  </div>

  <dialog id="miDialogoIMpresora" class="midialog-sm config-caja-dialog config-impresora-dialog">
    <div class="config-caja-dialog__header">
      <span class="config-caja-dialog__icon">
        <i class="fa-solid fa-print"></i>
      </span>
      <div>
        <span class="config-caja-dialog__eyebrow">Impresora</span>
        <h4 id="modalIMpresora">Crear punto de impresora</h4>
        <p>Configura el punto de impresion, nombre compartido y ancho del papel.</p>
      </div>
    </div>

    <form id="formCrearUpdateIMpresora" class="config-caja-dialog__form" action="/admin/config/crear_IMpresora" method="POST">
        <div id="divmsjalertaIMpresora"></div>

        <div class="config-caja-dialog__grid">
            <div class="config-caja-dialog__field">
                <label for="nombreImpresora">Nombre de la impresora</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-print"></i></span>
                  <input id="nombreImpresora" type="text" placeholder="Nombre del espacio de trabajo" name="nombre" value="" required>
                </div>
            </div>
            <div class="config-caja-dialog__field">
                <label for="nombreCompartido">Nombre compartido</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-share-nodes"></i></span>
                  <input id="nombreCompartido" type="text" placeholder="Nombre compartido de la impresora" name="nombrecompartido" value="" required>
                </div>
            </div>
            <div class="config-caja-dialog__field">
                <label for="anchoPapel">Ancho del papel (mm)</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-ruler-horizontal"></i></span>
                  <input id="anchoPapel" type="text" placeholder="Ejemplo: 58" name="anchoPapel" value="" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0)" required>
                </div>
            </div>
            <div class="config-caja-dialog__field">
                <label for="estacion">Estacion</label>
                <div class="config-caja-dialog__control">
                  <span><i class="fa-solid fa-desktop"></i></span>
                  <input id="estacion" type="text" placeholder="Estacion de trabajo" name="estacion" value="" required>
                </div>
            </div>
        </div>
        
        <div class="config-caja-dialog__actions">
            <button class="config-caja-dialog__button config-caja-dialog__button--ghost" type="button" value="Salir">Salir</button>
            <input id="btnEditarCrearImpresora" class="config-caja-dialog__button config-caja-dialog__button--primary" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Impresora-->
  
</div>
