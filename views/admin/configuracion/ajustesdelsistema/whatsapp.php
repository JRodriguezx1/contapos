<div class="contenido9 configNotificationWS config-whatsapp accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6 mt-6">

  <div class="config-whatsapp__hero">
    <div class="config-whatsapp__title">
      <span><i class="fa-brands fa-whatsapp"></i></span>
      <div>
        <p>Notificaciones</p>
        <h1>WhatsApp</h1>
        <small>Configura destinos y alertas automaticas del sistema.</small>
      </div>
    </div>
  </div>

  <section class="config-whatsapp__section">
    <div class="config-whatsapp__section-header">
      <div>
        <h2>Destinos de notificaci&oacute;n</h2>
        <p>Registra los contactos o grupos que recibir&aacute;n los avisos.</p>
      </div>
      <span><?php echo count($contactsNotificationWS);?> <?php echo count($contactsNotificationWS)>1?' Registros':' Registro';?></span>
    </div>

    <div class="config-whatsapp__destinations">
      <form id="formCreateContactNotifcationWs" class="config-whatsapp-form">
        <div class="config-whatsapp-form__header">
          <span><i class="fa-solid fa-user-plus"></i></span>
          <div>
            <h3>Agregar destino</h3>
            <p>Contacto individual o grupo.</p>
          </div>
        </div>

        <div class="formulario__campo">
          <label class="formulario__label" for="nombreWS">Nombre</label>
          <input id="nombreWS" class="formulario__input" type="text" placeholder="Nombre del destino" required>
        </div>

        <div class="formulario__campo">
          <label class="formulario__label" for="movilWS">Tel&eacute;fono</label>
          <input id="movilWS" class="formulario__input" type="text" placeholder="Ej: 573001234567" required>
        </div>

        <div class="formulario__campo">
          <label class="formulario__label" for="tipoWS">Tipo</label>
          <select id="tipoWS" class="formulario__select" required>
            <option value="individual">Individual</option>
            <option value="grupo">Grupo</option>
          </select>
        </div>

        <button type="submit" class="config-whatsapp-form__submit">
          <i class="fa-solid fa-plus"></i>
          Agregar destino
        </button>
      </form>

      <div class="config-whatsapp-table">
        <div class="config-whatsapp-table__header">
          <div>
            <h3>Destinos configurados</h3>
            <p>Prueba o elimina los destinos activos.</p>
          </div>
        </div>

        <div class="config-whatsapp-table__scroll">
          <table id="tablaNumbersWS">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Tel&eacute;fono</th>
                <th>Tipo</th>
                <th>Enviar test</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($contactsNotificationWS as $index => $value): ?>
              <tr id="<?php echo $value->id;?>">
                <td>
                  <span class="config-whatsapp-contact">
                    <i class="fa-brands fa-whatsapp"></i>
                    <?php echo $value->nombre;?>
                  </span>
                </td>
                <td><span class="config-whatsapp-pill config-whatsapp-pill--phone"><?php echo $value->movil;?></span></td>
                <td><span class="config-whatsapp-pill"><?php echo $value->tipo;?></span></td>
                <td><button class="test config-whatsapp-action config-whatsapp-action--test" type="button">Test</button></td>
                <td><span class="config-whatsapp-status">Activo</span></td>
                <td>
                  <button class="config-whatsapp-icon-button eliminarContacto" type="button" title="Eliminar contacto">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <section class="config-whatsapp__section">
    <div class="config-whatsapp__section-header">
      <div>
        <h2>Eventos del sistema</h2>
        <p>Activa los avisos que quieres enviar por WhatsApp API.</p>
      </div>
    </div>

    <div class="config-whatsapp-events">
      <div class="config-whatsapp-event">
        <div class="config-whatsapp-event__copy">
          <span><i class="fa-solid fa-file-circle-xmark"></i></span>
          <div>
            <h3>Factura eliminada</h3>
            <p>Notifica cuando se elimina una factura.</p>
          </div>
        </div>

        <div class="config-whatsapp-options">
          <label for="notificacion_por_whatsApp_eliminacion_de_factura_si">
            <input id="notificacion_por_whatsApp_eliminacion_de_factura_si" type="radio" name="notificacion_por_whatsApp_eliminacion_de_factura" class="hidden peer" value="1" <?php echo $conflocal['notificacion_por_whatsApp_eliminacion_de_factura']->valor_final == 1?'checked':'';?>>
            <div></div>
            <span>S&iacute;</span>
          </label>

          <label for="notificacion_por_whatsApp_eliminacion_de_factura_no">
            <input id="notificacion_por_whatsApp_eliminacion_de_factura_no" type="radio" name="notificacion_por_whatsApp_eliminacion_de_factura" class="hidden peer" value="0" <?php echo $conflocal['notificacion_por_whatsApp_eliminacion_de_factura']->valor_final == 0?'checked':'';?>>
            <div></div>
            <span>No</span>
          </label>
        </div>
      </div>

      <div class="config-whatsapp-event">
        <div class="config-whatsapp-event__copy">
          <span><i class="fa-solid fa-cash-register"></i></span>
          <div>
            <h3>Cierre de caja</h3>
            <p>Envia el resumen al cerrar caja.</p>
          </div>
        </div>

        <div class="config-whatsapp-options">
          <label for="notificacion_por_whatsApp_cierre_caja_si">
            <input id="notificacion_por_whatsApp_cierre_caja_si" type="radio" name="notificacion_por_whatsApp_cierre_caja" class="hidden peer" value="1" <?php echo $conflocal['notificacion_por_whatsApp_cierre_caja']->valor_final == 1?'checked':'';?>>
            <div></div>
            <span>S&iacute;</span>
          </label>

          <label for="notificacion_por_whatsApp_cierre_caja_no">
            <input id="notificacion_por_whatsApp_cierre_caja_no" type="radio" name="notificacion_por_whatsApp_cierre_caja" class="hidden peer" value="0" <?php echo $conflocal['notificacion_por_whatsApp_cierre_caja']->valor_final == 0?'checked':'';?>>
            <div></div>
            <span>No</span>
          </label>
        </div>
      </div>

      <div class="config-whatsapp-event">
        <div class="config-whatsapp-event__copy">
          <span><i class="fa-solid fa-boxes-stacked"></i></span>
          <div>
            <h3>Stock m&iacute;nimo</h3>
            <p>Alerta cuando el inventario est&aacute; bajo.</p>
          </div>
        </div>

        <div class="config-whatsapp-options">
          <label for="notificacion_por_whatsApp_sotck_bajo_si">
            <input id="notificacion_por_whatsApp_sotck_bajo_si" type="radio" name="notificacion_por_whatsApp_sotck_bajo" class="hidden peer" value="1" <?php echo $conflocal['notificacion_por_whatsApp_sotck_bajo']->valor_final == 1?'checked':'';?>>
            <div></div>
            <span>S&iacute;</span>
          </label>

          <label for="notificacion_por_whatsApp_sotck_bajo_no">
            <input id="notificacion_por_whatsApp_sotck_bajo_no" type="radio" name="notificacion_por_whatsApp_sotck_bajo" class="hidden peer" value="0" <?php echo $conflocal['notificacion_por_whatsApp_sotck_bajo']->valor_final == 0?'checked':'';?>>
            <div></div>
            <span>No</span>
          </label>
        </div>
      </div>

      <div class="config-whatsapp-event">
        <div class="config-whatsapp-event__copy">
          <span><i class="fa-solid fa-truck-fast"></i></span>
          <div>
            <h3>Env&iacute;o de mercanc&iacute;a</h3>
            <p>Alerta traslados o envios entre sucursales.</p>
          </div>
        </div>

        <div class="config-whatsapp-options">
          <label for="notificacion_por_whatsApp_envio_mercancia_si">
            <input id="notificacion_por_whatsApp_envio_mercancia_si" type="radio" name="notificacion_por_whatsApp_envio_mercancia" class="hidden peer" value="1" <?php echo $conflocal['notificacion_por_whatsApp_envio_mercancia']->valor_final == 1?'checked':'';?>>
            <div></div>
            <span>S&iacute;</span>
          </label>

          <label for="notificacion_por_whatsApp_envio_mercancia_no">
            <input id="notificacion_por_whatsApp_envio_mercancia_no" type="radio" name="notificacion_por_whatsApp_envio_mercancia" class="hidden peer" value="0" <?php echo $conflocal['notificacion_por_whatsApp_envio_mercancia']->valor_final == 0?'checked':'';?>>
            <div></div>
            <span>No</span>
          </label>
        </div>
      </div>
    </div>
  </section>

</div>
