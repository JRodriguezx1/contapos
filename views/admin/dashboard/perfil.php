<div class="perfil">
  <div class="perfil-shell">
    <header class="perfil-hero">
      <div class="perfil-hero__content">
        <p class="perfil-eyebrow">Mi cuenta</p>
        <h1>Perfil de usuario</h1>
        <p>Actualiza tu informaci&oacute;n de contacto, correo electr&oacute;nico y contrase&ntilde;a de acceso.</p>
      </div>

      <div class="perfil-hero__identity">
        <div class="perfil-avatar">
          <span><?php echo strtoupper(substr($usuario->nombre ?? $user['nombre'] ?? 'U', 0, 1)); ?></span>
        </div>
        <div>
          <strong><?php echo $usuario->nombre ?? $user['nombre'] ?? 'Usuario'; ?></strong>
          <small><?php echo $usuario->email ?? 'No tiene email'; ?></small>
        </div>
      </div>
    </header>

    <?php include __DIR__. "/../../templates/alertas.php"; ?>

    <div class="perfil-grid">
      <aside class="perfil-summary">
        <div class="perfil-summary__avatar">
          <span><?php echo strtoupper(substr($usuario->nombre ?? $user['nombre'] ?? 'U', 0, 1)); ?></span>
        </div>

        <h2><?php echo $usuario->nombre ?? $user['nombre'] ?? 'Usuario'; ?></h2>
        <p>Datos principales de la cuenta activa.</p>

        <div class="perfil-summary__list">
          <div>
            <span><i class="fa-solid fa-envelope"></i></span>
            <div>
              <small>Correo</small>
              <strong><?php echo $usuario->email ?? 'No tiene email'; ?></strong>
            </div>
          </div>
          <div>
            <span><i class="fa-solid fa-mobile-screen-button"></i></span>
            <div>
              <small>Celular</small>
              <strong><?php echo $usuario->movil ?? 'Sin registrar'; ?></strong>
            </div>
          </div>
          <div>
            <span><i class="fa-solid fa-location-dot"></i></span>
            <div>
              <small>Ciudad</small>
              <strong><?php echo $usuario->ciudad ?? 'Sin registrar'; ?></strong>
            </div>
          </div>
        </div>
      </aside>

      <main class="perfil-content">
        <section class="perfil-card">
          <div class="perfil-card__header">
            <span class="perfil-card__icon"><i class="fa-solid fa-at"></i></span>
            <div>
              <h2>Correo electr&oacute;nico</h2>
              <p>Este correo se usa para notificaciones y recuperaci&oacute;n de cuenta.</p>
            </div>
          </div>

          <div class="perfil-email">
            <div>
              <small>Correo actual</small>
              <strong><?php echo $usuario->email ?? 'No tiene email'; ?></strong>
            </div>
            <button id="btnCambiarEmail" class="perfil-button perfil-button--secondary" type="button">
              <i class="fa-solid fa-pen-to-square"></i>
              Cambiar
            </button>
          </div>
        </section>

        <form class="perfil-form" action="/admin/perfil" method="POST">
          <section class="perfil-card">
            <div class="perfil-card__header">
              <span class="perfil-card__icon"><i class="fa-solid fa-address-card"></i></span>
              <div>
                <h2>Informaci&oacute;n personal</h2>
                <p>Mant&eacute;n actualizados tus datos de contacto y ubicaci&oacute;n.</p>
              </div>
            </div>

            <div class="perfil-form__grid">
              <div class="perfil-field">
                <label for="movil">Celular actual</label>
                <div class="perfil-control">
                  <span><i class="fa-solid fa-mobile-screen-button"></i></span>
                  <input type="number" id="movil" name="movil" placeholder="Tu celular" value="<?php echo $usuario->movil ?? ''; ?>" required>
                </div>
              </div>

              <div class="perfil-field">
                <label for="ciudad">Ciudad</label>
                <div class="perfil-control">
                  <span><i class="fa-solid fa-city"></i></span>
                  <input type="text" id="ciudad" name="ciudad" placeholder="Ciudad de residencia" value="<?php echo $usuario->ciudad ?? ''; ?>" required>
                </div>
              </div>

              <div class="perfil-field perfil-field--wide">
                <label for="direccion">Direcci&oacute;n</label>
                <div class="perfil-control">
                  <span><i class="fa-solid fa-location-dot"></i></span>
                  <input type="text" id="direccion" name="direccion" placeholder="Direcci&oacute;n de residencia" value="<?php echo $usuario->direccion ?? ''; ?>" required>
                </div>
              </div>
            </div>
          </section>

          <section class="perfil-card">
            <div class="perfil-card__header">
              <span class="perfil-card__icon"><i class="fa-solid fa-lock"></i></span>
              <div>
                <h2>Contrase&ntilde;a</h2>
                <p>Ingresa tu contrase&ntilde;a actual para confirmar cambios.</p>
              </div>
            </div>

            <div class="perfil-form__grid">
              <div class="perfil-field">
                <label for="password">Contrase&ntilde;a actual</label>
                <div class="perfil-control">
                  <span><i class="fa-solid fa-key"></i></span>
                  <input type="password" id="password" name="password" placeholder="***********" required>
                </div>
              </div>

              <div class="perfil-field">
                <label for="password2">Nueva contrase&ntilde;a</label>
                <div class="perfil-control">
                  <span><i class="fa-solid fa-shield-halved"></i></span>
                  <input type="password" id="password2" name="password2" placeholder="***********">
                </div>
              </div>
            </div>

            <div class="perfil-help">
              <i class="fa-solid fa-circle-info"></i>
              <p>No puedes recordar tu contrase&ntilde;a actual. <a href="#">Recuperar cuenta</a></p>
            </div>
          </section>

          <div class="perfil-actions">
            <input class="perfil-button perfil-button--primary" type="submit" value="Guardar cambios">
          </div>
        </form>

        <section class="perfil-card perfil-card--danger">
          <div class="perfil-card__header">
            <span class="perfil-card__icon perfil-card__icon--danger"><i class="fa-solid fa-triangle-exclamation"></i></span>
            <div>
              <h2>Eliminar cuenta</h2>
              <p>Borraremos completamente tus datos. No podr&aacute;s acceder a tu cuenta despu&eacute;s de esta acci&oacute;n.</p>
            </div>
          </div>

          <div class="perfil-danger">
            <span><i class="fa-solid fa-circle-exclamation"></i> Procede con precauci&oacute;n</span>
            <button class="perfil-danger__button" type="button">Continuar con la eliminaci&oacute;n</button>
          </div>
        </section>
      </main>
    </div>
  </div>

  <dialog class="midialog-sm perfil-email-dialog" id="miDialogoUpEmail">
    <div class="perfil-email-dialog__header">
      <span><i class="fa-solid fa-envelope-open-text"></i></span>
      <div>
        <p>Correo</p>
        <h4 id="modalUpEmail">Actualizar correo electr&oacute;nico</h4>
        <small>Registra el nuevo correo asociado a tu cuenta.</small>
      </div>
    </div>

    <div id="divmsjalerta1"></div>

    <form id="formUpEmail" class="formulario perfil-email-dialog__form" action="/admin/actualizaremail" method="POST">
      <div class="perfil-field">
        <label for="email">Email</label>
        <div class="perfil-control">
          <span><i class="fa-solid fa-at"></i></span>
          <input type="text" placeholder="Tu email actual" id="email" name="email" value="">
        </div>
      </div>

      <div class="perfil-email-dialog__actions">
        <button class="perfil-button perfil-button--ghost" type="button" value="salir">Salir</button>
        <input id="btnUpEmail" class="perfil-button perfil-button--primary" type="submit" value="Actualizar">
      </div>
    </form>
  </dialog>
</div>
