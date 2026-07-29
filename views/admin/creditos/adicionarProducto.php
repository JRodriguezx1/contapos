<div class="adicionarProducto">
  <div class="adicionar-producto-shell">
    <section class="adicionar-producto-hero">
      <a href="/admin/creditos/detallecredito?id=<?php echo $credito->id;?>" class="adicionar-producto-back" aria-label="Volver al detalle">
        <i class="fa-solid fa-arrow-left"></i>
      </a>

      <div class="adicionar-producto-hero__content">
        <p class="adicionar-producto-eyebrow">Cartera</p>
        <h1>Adicionar productos</h1>
        <p>Agrega articulos al credito o separado y actualiza los valores asociados.</p>
      </div>

      <div class="adicionar-producto-hero__badge">
        <span><i class="fa-solid fa-file-invoice-dollar"></i></span>
        <div>
          <strong id="numOrden"><?php echo $credito->id;?></strong>
          <small>credito actual</small>
        </div>
      </div>
    </section>

    <section class="adicionar-producto-layout">
      <article class="adicionar-producto-card adicionar-producto-card--form">
        <header class="adicionar-producto-card__header">
          <span><i class="fa-solid fa-cart-plus"></i></span>
          <div>
            <h2>Nuevo articulo</h2>
            <p>Selecciona el producto, confirma cantidad y unidad para agregarlo al separado.</p>
          </div>
        </header>

        <div class="adicionar-producto-fields">
          <div class="adicionar-producto-field adicionar-producto-field--full">
            <label for="articulo">Articulo</label>
            <div class="adicionar-producto-input adicionar-producto-input--select2" data-placeholder="Buscar articulo">
              <span><i class="fa-solid fa-magnifying-glass"></i></span>
              <select id="articulo" multiple="multiple">
                <?php foreach($totalitems as $value): ?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="adicionar-producto-field">
            <label for="cantidad">Cantidad</label>
            <div class="adicionar-producto-input">
              <span><i class="fa-solid fa-hashtag"></i></span>
              <input id="cantidad" type="text" placeholder="Cantidad" value="1"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';">
            </div>
          </div>

          <div class="adicionar-producto-field">
            <label for="unidadmedida">Unidad</label>
            <div class="adicionar-producto-input">
              <span><i class="fa-solid fa-ruler-combined"></i></span>
              <input id="unidadmedida" type="text" placeholder="Unidad de medida" readonly>
            </div>
          </div>
        </div>

        <button id="btnAddItem" class="adicionar-producto-button adicionar-producto-button--secondary" type="button">
          <i class="fa-solid fa-plus"></i>
          Agregar articulo
        </button>

        <div class="adicionar-producto-totals">
          <div class="adicionar-producto-total">
            <span>Sub total</span>
            <strong id="subTotal">$ <?php echo number_format($credito->capital, 2, ',', '.');?></strong>
          </div>
          <div class="adicionar-producto-total">
            <span>Recargo interes</span>
            <strong id="interes">$ <?php echo number_format($credito->interes, 2, ',', '.');?></strong>
          </div>
          <div class="adicionar-producto-total">
            <span>Impuesto</span>
            <strong id="impuesto">$ <?php echo number_format($credito->valorimpuestototal,2, ',', '.');?></strong>
          </div>
          <div class="adicionar-producto-total">
            <span>Abono inicial</span>
            <strong id="abonoinicial">$ <?php echo number_format($credito->abonoinicial,2, ',', '.');?></strong>
          </div>
          <div class="adicionar-producto-total">
            <span>Descuento</span>
            <strong id="descuento">$ <?php echo number_format($credito->descuento,2, ',', '.');?></strong>
          </div>
          <div class="adicionar-producto-total adicionar-producto-total--grand">
            <span>Total</span>
            <strong id="total">$ <?php echo number_format($credito->montototal,2, ',', '.');?></strong>
          </div>
        </div>
      </article>

      <article class="adicionar-producto-card adicionar-producto-card--products">
        <header class="adicionar-producto-card__header">
          <span><i class="fa-solid fa-boxes-stacked"></i></span>
          <div>
            <h2>Productos del credito</h2>
            <p>Revisa los articulos incluidos antes de guardar los cambios.</p>
          </div>
        </header>

        <div class="adicionar-producto-table-wrap">
          <table id="tablaItems" class="adicionar-producto-table">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Valor</th>
                <th>Total</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <footer class="adicionar-producto-actions">
          <a href="/admin/creditos/detallecredito?id=<?php echo $credito->id;?>" class="adicionar-producto-button adicionar-producto-button--light">
            <i class="fa-solid fa-arrow-left"></i>
            Salir
          </a>
          <button id="btnUpdateCreditoSeparado" class="adicionar-producto-button adicionar-producto-button--primary" type="button">
            <i class="fa-solid fa-floppy-disk"></i>
            Actualizar
          </button>
        </footer>
      </article>
    </section>
  </div>
</div>
