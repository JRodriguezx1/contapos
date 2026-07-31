<div class="box crearseparado">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>

  <div class="separado-shell">
    <section class="separado-hero">
      <a href="/admin/creditos" class="separado-back" aria-label="Volver a creditos">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
      <div class="separado-hero__content">
        <p class="separado-eyebrow">Cartera</p>
        <h1>Crear separado</h1>
        <p>Selecciona cliente, productos, abono inicial y plazo para generar el separado.</p>
      </div>
      <div class="separado-hero__badge">
        <span class="material-symbols-outlined">inventory_2</span>
        <div>
          <strong>Nuevo</strong>
          <small>registro de separado</small>
        </div>
      </div>
    </section>

    <div id="divmsjalerta"></div>

    <form id="formCrearUpdateCredito" class="separado-form" action="" method="POST">
      <section class="separado-card separado-card--form">
        <div class="separado-card__header">
          <span class="material-symbols-outlined">person_add</span>
          <div>
            <h2>Datos del separado</h2>
            <p>Informacion del cliente, abono inicial y condiciones de pago.</p>
          </div>
        </div>

        <div class="separado-fields">
          <div class="separado-field--full cliente-prices-field">
            <label for="cliente">Cliente</label>
            <div class="cliente-prices-select">
              <select id="cliente" name="cliente_id" multiple="multiple" required>
                <option></option>
                <?php foreach($clientes as $cliente): ?>
                  <?php if($cliente->id>1): ?>
                    <option value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre.' '.$cliente->apellido;?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="separado-field">
            <label for="abonoinicial">Abono inicial</label>
            <div class="separado-input">
              <span><i class="fa-solid fa-dollar-sign"></i></span>
              <input
                id="abonoinicial"
                type="text"
                placeholder="Abono inicial al capital"
                name="abonoinicial"
                value="<?php echo $credito->abonoinicial??'0';?>"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '';"
                required
              >
            </div>
          </div>

          <div class="separado-field">
            <label for="cantidadcuotas">Cantidad de cuotas</label>
            <div class="separado-input">
              <span><i class="fa-solid fa-calendar-check"></i></span>
              <input
                id="cantidadcuotas"
                type="text"
                placeholder="Cantidad de cuotas"
                name="cantidadcuotas"
                value="<?php echo $credito->cantidadcuotas??'1';?>"
                oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, ''); if(this.value === '' || this.value === '0'){this.value = '';}"
                required
              >
            </div>
          </div>

          <div class="separado-field">
            <label for="montocuota">Valor de la cuota</label>
            <div class="separado-input separado-input--readonly">
              <span><i class="fa-solid fa-receipt"></i></span>
              <input id="montocuota" type="text" placeholder="Valor de la cuota" name="montocuota" value="<?php echo $credito->montocuota??'';?>" readonly required>
            </div>
          </div>

          <div class="separado-field">
            <label for="frecuenciapago">Dia de pago</label>
            <div class="separado-input separado-input--select2">
              <span><i class="fa-solid fa-calendar-day"></i></span>
              <select id="frecuenciapago" name="frecuenciapago" required>
                <option></option>
                <?php for($dia = 1; $dia <= 30; $dia++): ?>
                  <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>

          <div class="separado-field separado-field--full">
            <label for="nota">Nota</label>
            <div class="separado-input">
              <span><i class="fa-regular fa-note-sticky"></i></span>
              <input
                id="nota"
                type="text"
                placeholder="Nota del separado"
                name="nota"
                value="Plazo maximo de entrega: 1 mes"
              >
            </div>
          </div>
        </div>
      </section>

      <section class="separado-card separado-card--products">
        <div class="separado-card__header">
          <span class="material-symbols-outlined">shopping_bag</span>
          <div>
            <h2>Productos</h2>
            <p>Agrega los articulos que quedaran reservados en el separado.</p>
          </div>
        </div>

        <div class="separado-field--full">
          <label for="articulo">Articulo</label>
          <div class="cliente-prices-select">
            <span><i class="fa-solid fa-magnifying-glass"></i></span>
            <select id="articulo" name="articulo" autocomplete="articulo-name" multiple="multiple" required></select>
          </div>
        </div>

        <div class="separado-products-table">
          <table class="tabla separado-data-table" width="100%" id="tablaSeparado">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Unidad</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th class="accionesth"><i class="fa-solid fa-x"></i></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <div class="separado-summary">
          <button id="btndescuento" class="separado-discount" type="button">
            <i class="fa-solid fa-tag"></i>
            Descuento
          </button>

          <div class="separado-totals">
            <div>
              <span>Sub total</span>
              <strong id="subTotal">$ 0</strong>
            </div>
            <div>
              <span>Impuesto</span>
              <strong id="impuesto">% 0</strong>
            </div>
            <div>
              <span>Descuento</span>
              <strong id="descuento">$ 0</strong>
            </div>
            <div class="separado-total">
              <span>Total</span>
              <strong id="total">$ 0</strong>
            </div>
          </div>
        </div>

        <div class="separado-actions">
          <button class="separado-button separado-button--secondary" type="button" value="salir">
            Salir
          </button>
          <input id="btnCrearSeparado" class="separado-button separado-button--primary" type="submit" value="Crear">
        </div>
      </section>
    </form>
  </div>

  <dialog id="miDialogoDescuento" class="separado-dialog">
    <div class="separado-dialog__header">
      <span class="material-symbols-outlined">sell</span>
      <div>
        <p>Descuento</p>
        <h3>Aplicar descuento</h3>
        <small>Define un valor o porcentaje para descontar del separado.</small>
      </div>
    </div>

    <form id="formDescuento" class="separado-dialog__body">
      <div class="separado-segmented">
        <label>
          <input type="radio" name="tipodescuento" value="valor" checked>
          <span>Valor</span>
        </label>
        <label>
          <input type="radio" name="tipodescuento" value="porcentaje">
          <span>Porcentaje</span>
        </label>
      </div>

      <div class="separado-field">
        <label for="inputDescuento">Descuento</label>
        <div class="separado-input">
          <span><i class="fa-solid fa-percent"></i></span>
          <input id="inputDescuento" type="number" min="0" name="descuento" data-descuento="" required>
        </div>
      </div>

      <div class="separado-field">
        <label for="inputDescuentoClave">Ingresar clave</label>
        <div class="separado-input">
          <span><i class="fa-solid fa-key"></i></span>
          <input id="inputDescuentoClave" type="password" name="descuentoclave">
        </div>
        <div id="divmsjalertaClaveDcto"></div>
      </div>

      <div class="separado-dialog__actions">
        <button type="button" class="separado-button separado-button--secondary salir">Salir</button>
        <button id="btnCrearAddDir" type="submit" class="separado-button separado-button--primary crearAddDir">Aplicar</button>
      </div>
    </form>
  </dialog>

  <?php include __DIR__. "/../ventas/modalprocesarpago.php"; ?>

  <script>
    const getParam = <?= json_encode($conflocal) ?>;
  </script>
</div>
