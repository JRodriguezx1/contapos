<div class="box clientes">
  
    <?php include __DIR__. "/../../templates/alertas.php"; ?>

    <header class="flex flex-col items-stretch gap-5 rounded-lg border border-slate-200 bg-gradient-to-br from-violet-100 to-cyan-50 mb-6 p-4 sm:p-6 lg:flex-row lg:items-center lg:justify-between">
      <div>
        <p class="mb-1 text-base font-extrabold uppercase text-indigo-600">CRM</p>
        <h1 class="m-0 text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl">Gesti&oacute;n de clientes</h1>
        <p class="mt-1 text-lg leading-snug text-slate-500">Administra clientes, direcciones, estad&iacute;sticas y precios personalizados desde una vista m&aacute;s clara.</p>
      </div>

      <div class="flex justify-start gap-4 lg:justify-end rounded-lg border border-slate-200 bg-white/90 p-4">
        <span class="material-symbols-outlined inline-flex size-16 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-700 text-3xl text-white"><i class="fa-solid fa-users"></i></span>
        <div>
          <strong class="block whitespace-nowrap text-2xl font-black leading-none text-slate-900"><?php echo count($clientes); ?></strong>
          <small class="mt-1 block text-base font-bold text-slate-500">clientes registrados</small>
        </div>
      </div>
    </header>

    <section class="flex flex-wrap items-center gap-3 mb-6 rounded-lg border border-slate-200 bg-white p-4">
      <button id="crearCliente" class="btnDialog btnDialog_primary" type="button">
        <i class="fa-solid fa-user-plus"></i>
        Crear cliente
      </button>

      <button id="crearDireccion" class="btnDialog btnDialog_secondary" type="button">
        <i class="fa-solid fa-location-dot"></i>
        Crear direcci&oacute;n
      </button>

      <a id="marketing" href="/admin/clientes/marketing" class="btnDialog btnDialog_light">
        <i class="fa-solid fa-bullhorn"></i>
        Marketing
      </a>
    </section>

    <section class="clientes-table-card config-table-card">
      <div class="clientes-table-card__header">
        <div>
          <h2>Directorio de clientes</h2>
          <p>Consulta datos de contacto y gestiona acciones r&aacute;pidas por cliente.</p>
        </div>
      </div>

      <table class="display responsive nowrap tabla clientes-data-table" width="100%" id="tablaClientes">
        <thead>
          <tr>
            <th>id</th>
            <th>Documento</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tel&eacute;fono</th>
            <th>Email</th>
            <th class="accionesth">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($clientes as $cliente): ?>
            <?php if($cliente->id != 1): ?>
              <tr>
                <td><?php echo $cliente->id; ?></td>
                <td>
                  <span class="clientes-table-pill clientes-table-pill--document"><?php echo $cliente->identificacion; ?></span>
                </td>
                <td>
                  <span class="clientes-name">
                    <span class="clientes-name__icon"><i class="fa-solid fa-user"></i></span>
                    <span><?php echo $cliente->nombre; ?></span>
                  </span>
                </td>
                <td><?php echo $cliente->apellido; ?></td>
                <td>
                  <span class="clientes-table-pill clientes-table-pill--phone"><?php echo $cliente->telefono; ?></span>
                </td>
                <td>
                  <span class="clientes-table-pill clientes-table-pill--email"><?php echo $cliente->email; ?></span>
                </td>
                <td class="accionestd">
                  <div class="acciones-btns" id="<?php echo $cliente->id;?>">
                    <button class="btn-md btn-turquoise editarClientes" type="button" title="Actualizar datos del cliente"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn-md btn-light editarEliminarDireccion" type="button" title="Actualizar direcci&oacute;n del cliente"><i class="fa-solid fa-location-dot"></i></button>
                    <a class="btn-md btn-bluedark" href="/admin/clientes/detalle?id=<?php echo $cliente->id;?>" title="Ver estad&iacute;sticas del cliente"><i class="fa-solid fa-chart-simple"></i></a>
                    <a class="btn-md btn-blue" href="/admin/clientes/preciosXCliente?id=<?php echo $cliente->id;?>" title="Precios personalizados"><i class="fa-solid fa-dollar-sign"></i></a>
                    <button class="btn-md btn-red eliminarClientes" type="button" title="Eliminar cliente"><i class="fa-solid fa-trash-can"></i></button>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <dialog class="midialog-sm clientes-dialog clientes-dialog--client" id="miDialogoCliente">
      <div class="clientes-dialog__header">
        <span><i class="fa-solid fa-user-plus"></i></span>
        <div>
          <p>Cliente</p>
          <h4 id="modalCliente">Crear cliente</h4>
          <small>Registra los datos principales y de contacto del cliente.</small>
        </div>
      </div>

      <div id="divmsjalerta1"></div>

      <form id="formCrearUpdateCliente" class="formulario clientes-dialog__form" action="/admin/clientes/crear" method="POST">
        <div class="clientes-field">
          <label for="nombre">Nombre</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-user"></i></span>
            <input type="text" placeholder="Nombre del cliente" id="nombre" name="nombre" value="<?php echo $crearcliente->nombre ?? ''; ?>" required>
          </div>
        </div>

        <div class="clientes-field">
          <label for="apellido">Apellido</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-user-tag"></i></span>
            <input type="text" placeholder="Apellido del cliente" id="apellido" name="apellido" value="<?php echo $crearcliente->apellido ?? ''; ?>">
          </div>
        </div>

        <div class="clientes-field">
          <label for="tipodocumento">Tipo de documento</label>
          <div class="clientes-control clientes-control--select">
            <span><i class="fa-solid fa-id-card"></i></span>
            <select id="tipodocumento" name="tipodocumento" required>
              <option value="1">Registro civil</option>
              <option value="2">Tarjeta de identidad</option>
              <option value="3" selected>C&eacute;dula de ciudadan&iacute;a</option>
              <option value="4">Tarjeta de extranjer&iacute;a</option>
              <option value="5">C&eacute;dula de extranjer&iacute;a</option>
              <option value="6">NIT</option>
              <option value="7">Pasaporte</option>
              <option value="8">Documento de identificaci&oacute;n extranjero</option>
              <option value="9">NIT de otro pa&iacute;s</option>
              <option value="10">NUIP</option>
            </select>
          </div>
        </div>

        <div class="clientes-field">
          <label for="identificacion">Identificaci&oacute;n</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-fingerprint"></i></span>
            <input type="text" min="0" placeholder="Identificaci&oacute;n del cliente" id="identificacion" name="identificacion" value="<?php echo $crearcliente->identificacion ?? ''; ?>">
          </div>
        </div>

        <div class="clientes-field">
          <label for="telefono">Tel&eacute;fono</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-mobile-screen-button"></i></span>
            <input type="text" minlength="7" placeholder="Tel&eacute;fono del cliente" id="telefono" name="telefono" value="<?php echo $crearcliente->telefono ?? ''; ?>" required>
          </div>
        </div>

        <div class="clientes-field">
          <label for="email">Correo electr&oacute;nico</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-at"></i></span>
            <input type="email" placeholder="Ingresa correo electr&oacute;nico" id="email" name="email" value="<?php echo $crearcliente->email ?? ''; ?>">
          </div>
        </div>

        <div class="clientes-field clientes-field--wide">
          <label for="fecha_nacimiento">Fecha de nacimiento</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-cake-candles"></i></span>
            <input type="date" placeholder="Fecha de nacimiento del cliente" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $crearcliente->fecha_nacimiento ?? ''; ?>">
          </div>
        </div>

        <div class="masopciones"></div>

        <div class="clientes-dialog__actions">
          <button class="clientes-button clientes-button--ghost" type="button" value="salir">Salir</button>
          <input id="btnEditarCrearCliente" class="clientes-button clientes-button--primary" type="submit" value="Crear">
        </div>
      </form>
    </dialog>

    <dialog class="midialog-sm clientes-dialog clientes-dialog--address" id="miDialogoCrearDireccion">
      <div class="clientes-dialog__header">
        <span><i class="fa-solid fa-map-location-dot"></i></span>
        <div>
          <p>Direcci&oacute;n</p>
          <h4 id="modalDireccion">Crear direcci&oacute;n</h4>
          <small>Asocia una direcci&oacute;n, ciudad y tarifa a un cliente.</small>
        </div>
      </div>

      <div id="divmsjalerta2"></div>

      <form id="formCrearUpdateDireccion" class="formulario clientes-dialog__form" action="/admin/direcciones/crear" method="POST">
        <div class="clientes-field clientes-field--wide">
          <label for="selectcliente">Seleccionar cliente</label>
          <div class="clientes-control clientes-control--select clientes-control--bare">
            <select id="selectcliente" name="idcliente" required>
              <?php foreach($clientes as $cliente): ?>
                <?php if($cliente->id > 1): ?>
                  <option value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre.' '.$cliente->apellido;?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="clientes-field">
          <label for="tarifa">Tarifa</label>
          <div class="clientes-control clientes-control--select">
            <span><i class="fa-solid fa-tags"></i></span>
            <select id="tarifa" name="idtarifa" required>
              <?php foreach($tarifas as $tarifa): ?>
                <option value="<?php echo $tarifa->id;?>"><?php echo $tarifa->nombre;?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="clientes-field">
          <label for="departamento">Departamento</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-map"></i></span>
            <input type="text" placeholder="Departamento o regi&oacute;n" id="departamento" name="departamento" value="">
          </div>
        </div>

        <div class="clientes-field">
          <label for="ciudad">Ciudad</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-city"></i></span>
            <input type="text" placeholder="Ciudad de residencia" id="ciudad" name="ciudad" value="">
          </div>
        </div>

        <div class="clientes-field">
          <label for="direccion">Direcci&oacute;n</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-location-dot"></i></span>
            <input type="text" placeholder="Direcci&oacute;n de vivienda" id="direccion" name="direccion" value="">
          </div>
        </div>

        <div class="clientes-dialog__actions">
          <button class="clientes-button clientes-button--ghost" type="button" value="salir">Salir</button>
          <input id="btnEditarCrearDireccion" class="clientes-button clientes-button--primary" type="submit" value="Crear">
        </div>
      </form>
    </dialog>

    <dialog class="midialog-sm clientes-dialog clientes-dialog--address" id="miDialogoUpDireccion">
      <div class="clientes-dialog__header clientes-dialog__header--with-close">
        <span><i class="fa-solid fa-location-crosshairs"></i></span>
        <div>
          <p>Direcci&oacute;n</p>
          <h4 id="modalUpDireccion">Actualizar direcci&oacute;n</h4>
          <small>Edita o elimina una direcci&oacute;n asociada al cliente seleccionado.</small>
        </div>
        <button id="btnCerrarUpDireccion" class="clientes-dialog__close" type="button" title="Cerrar">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div id="divmsjalerta3"></div>

      <form id="formUpDireccion" class="formulario clientes-dialog__form" action="/admin/direccions/actualizar" method="POST">
        <div class="clientes-field clientes-field--wide">
          <label for="selectdirecciones">Seleccionar direcciones</label>
          <div class="clientes-control clientes-control--select">
            <span><i class="fa-solid fa-route"></i></span>
            <select id="selectdirecciones" name="direcciones" required>
              <option value="" disabled selected>-Seleccionar-</option>
            </select>
          </div>
        </div>

        <div class="clientes-field">
          <label for="uptarifa">Tarifa</label>
          <div class="clientes-control clientes-control--select">
            <span><i class="fa-solid fa-tags"></i></span>
            <select id="uptarifa" name="tarifa" required>
              <option value="" disabled selected>-Seleccionar-</option>
              <?php foreach($tarifas as $tarifa): ?>
                <option value="<?php echo $tarifa->id;?>"><?php echo $tarifa->nombre;?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="clientes-field">
          <label for="updepartamento">Departamento</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-map"></i></span>
            <input type="text" placeholder="Departamento o regi&oacute;n" id="updepartamento" name="departamento" value="">
          </div>
        </div>

        <div class="clientes-field">
          <label for="upciudad">Ciudad</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-city"></i></span>
            <input type="text" placeholder="Ciudad de residencia" id="upciudad" name="ciudad" value="">
          </div>
        </div>

        <div class="clientes-field">
          <label for="updireccion">Direcci&oacute;n</label>
          <div class="clientes-control">
            <span><i class="fa-solid fa-location-dot"></i></span>
            <input type="text" placeholder="Direcci&oacute;n de vivienda" id="updireccion" name="direccion" value="">
          </div>
        </div>

        <div class="clientes-dialog__actions">
          <button id="btnRemoveDireccion" class="clientes-button clientes-button--danger" type="submit" value="Eliminar">Eliminar</button>
          <input id="btnUpDireccion" class="clientes-button clientes-button--primary" type="submit" value="Actualizar">
        </div>
      </form>
    </dialog>

</div>
