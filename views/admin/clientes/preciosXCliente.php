<div class="box preciosXCliente">
  <div class="cliente-prices-shell">
    <header class="cliente-prices-hero">
      <a href="/admin/clientes" class="cliente-prices-back" title="Volver a clientes">
        <i class="fa-solid fa-arrow-left"></i>
      </a>

      <div class="cliente-prices-hero__content">
        <p class="cliente-prices-eyebrow">Precios personalizados</p>
        <h1><?php echo $cliente->nombre.' '.$cliente->apellido;?></h1>
        <p>Define precios especiales por producto para este cliente.</p>
      </div>

      <div class="cliente-prices-hero__badge">
        <span><i class="fa-solid fa-user-tag"></i></span>
        <div>
          <strong><?php echo count($arrayPreciosPorCliente); ?></strong>
          <small>precios activos</small>
        </div>
      </div>
    </header>

    <form id="formAddProducto" class="formulario cliente-prices-layout" action="/" method="POST">
      <input id="idcliente" type="hidden" value="<?php echo $cliente->id;?>">

      <section class="cliente-prices-card cliente-prices-card--form">
        <div class="cliente-prices-card__header">
          <span class="cliente-prices-card__icon"><i class="fa-solid fa-tags"></i></span>
          <div>
            <h2>Asociar producto</h2>
            <p>Selecciona un producto y registra el precio de venta especial.</p>
          </div>
        </div>

        <div class="cliente-prices-form-grid">
          <div class="cliente-prices-field cliente-prices-field--product">
            <label for="productos">Producto</label>
            <div class="cliente-prices-select">
              <select id="productos" name="productos" autocomplete="productos-name" multiple="multiple" required>
                <?php foreach($productos as $value): ?>
                  <option
                    value="<?php echo $value->id;?>"
                    data-producto="<?php echo $value->nombre;?>"
                  >
                    <?php echo $value->nombre.', Unidad: '.$value->unidadmedida;?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="cliente-prices-field">
            <label for="precioPersonalizado">Precio de venta</label>
            <div class="cliente-prices-control">
              <span><i class="fa-solid fa-dollar-sign"></i></span>
              <input id="precioPersonalizado"
                     name="precioPersonalizado"
                     type="text"
                     autocomplete="precioPersonalizado ID"
                     maxlength="7"
                     inputmode="numeric"
                     oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                     placeholder="Ej: 25000"
                     required>
            </div>
          </div>
        </div>

        <div class="cliente-prices-actions">
          <a href="/admin/clientes" class="cliente-prices-button cliente-prices-button--ghost salir">
            <i class="fa-solid fa-arrow-left"></i>
            Salir
          </a>
          <input id="btnCrearAddProducto" class="cliente-prices-button cliente-prices-button--primary crearAddSubproducto" type="submit" value="Asociar">
        </div>
      </section>

      <section class="cliente-prices-card cliente-prices-card--list">
        <div class="cliente-prices-card__header">
          <span class="cliente-prices-card__icon"><i class="fa-solid fa-list-check"></i></span>
          <div>
            <h2>Lista de precios personalizados</h2>
            <p>Productos con precio especial asignado para este cliente.</p>
          </div>
        </div>

        <div class="listaProductos cliente-prices-list">
          <?php foreach($arrayPreciosPorCliente as $value): ?>
            <div id="<?php echo $value->idproducto;?>" class="cliente-price-item" role="alert">
              <span class="cliente-price-item__icon"><i class="fa-solid fa-box"></i></span>
              <div class="cliente-price-item__content">
                <strong>$<?php echo number_format($value->precioxcliente ?? 0, 0, ',', '.');?></strong>
                <p><?php echo $value->nombre;?></p>
              </div>
              <button type="button" class="cliente-price-item__remove" title="Eliminar precio personalizado">
                <span id="<?php echo $value->idproducto;?>" class="material-symbols-outlined">cancel</span>
              </button>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </form>
  </div>
</div>
