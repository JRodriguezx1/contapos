<?php
  $valorPlan = (float)($negocio->valorplan ?? 0);
  $descuento = (float)($negocio->descuento ?? 0);
  $cargo = (float)($negocio->cargo ?? 0);
  $totalSuscripcion = $valorPlan + $cargo - $descuento;
  $estadoActivo = (int)($negocio->estado ?? 0) === 1;
?>

<div class="contenido10 configsuscripcion config-subscription accordion_tab_content p-6 rounded-lg w-full space-y-6">

  <section class="config-subscription__hero">
    <div class="config-subscription__title">
      <span><i class="fa-solid fa-id-card"></i></span>
      <div>
        <small>SUSCRIPCION</small>
        <h2>Control de suscripcion</h2>
        <p>Consulta el estado de la cuenta, cobros vigentes e historial de pagos.</p>
      </div>
    </div>
    <div class="config-subscription__actions">
      <button id="btnDetalleSuscriptor" class="config-subscription__button config-subscription__button--light" type="button">
        <i class="fa-solid fa-user-gear"></i>
        Informacion del suscriptor
      </button>
      <button id="btnRegistrarPago" class="config-subscription__button config-subscription__button--primary" type="button">
        <i class="fa-solid fa-receipt"></i>
        Registrar pago
      </button>
    </div>
  </section>

  <section class="config-subscription__grid">
    <article class="config-subscription-card config-subscription-card--main">
      <div class="config-subscription-card__header">
        <div>
          <span>Cuenta</span>
          <h3><?php echo $negocio->negocio ?? ''; ?></h3>
          <p><?php echo $negocio->nombre ?? ''; ?></p>
        </div>
        <span id="estadoText" class="config-subscription-status <?php echo $estadoActivo ? 'config-subscription-status--active bg-green-100 text-green-700' : 'config-subscription-status--paused bg-red-100 text-red-700'; ?>">
          <?php echo $estadoActivo ? 'Activo' : 'Suspendido'; ?>
        </span>
      </div>

      <div class="config-subscription-metrics">
        <div>
          <span>Fecha de inicio</span>
          <strong><?php echo $negocio->created_at ?? ''; ?></strong>
        </div>
        <div>
          <span>Proximo pago</span>
          <strong id="fecha_corteText"><?php echo $negocio->fecha_corte ?? ''; ?></strong>
        </div>
        <div>
          <span>Monto mensual</span>
          <strong id="valorplanText">$<?php echo number_format($valorPlan, 0, ',', '.'); ?></strong>
        </div>
        <div>
          <span>Dias restantes</span>
          <strong id="diasRestantesText">-</strong>
        </div>
      </div>
    </article>

    <article class="config-subscription-card config-subscription-card--summary">
      <div class="config-subscription-card__eyebrow">
        <i class="fa-solid fa-calculator"></i>
        Resumen de cobros
      </div>
      <div class="config-subscription-summary">
        <div>
          <span>Valor base</span>
          <strong id="valorplanResumen">$<?php echo number_format($valorPlan, 0, ',', '.'); ?></strong>
        </div>
        <div class="is-discount">
          <span>Descuento aplicado</span>
          <strong>- $<?php echo number_format($descuento, 0, ',', '.'); ?></strong>
        </div>
        <div class="is-charge">
          <span>Cargo adicional</span>
          <strong>+ $<?php echo number_format($cargo, 0, ',', '.'); ?></strong>
        </div>
      </div>
      <div class="config-subscription-total">
        <span>Total a pagar</span>
        <strong id="totalSuscripcionText">$<?php echo number_format($totalSuscripcion, 0, ',', '.'); ?></strong>
      </div>
    </article>
  </section>

  <section class="config-subscription-history">
    <div class="config-subscription-history__header">
      <div>
        <span><i class="fa-solid fa-clock-rotate-left"></i></span>
        <div>
          <h3>Historial de pagos</h3>
          <p>Pagos registrados para la suscripcion actual.</p>
        </div>
      </div>
      <small><?php echo count($suscripcionPagos ?? []); ?> registro<?php echo count($suscripcionPagos ?? []) === 1 ? '' : 's'; ?></small>
    </div>

    <div class="config-subscription-history__table">
      <table>
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Metodo</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($suscripcionPagos as $value): ?>
            <tr>
              <td><?php echo $value->fecha_pago; ?></td>
              <td><span class="config-subscription-pill">$<?php echo number_format($value->valor_pagado, 0, ',', '.'); ?></span></td>
              <td><?php echo $value->mediopago; ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if(empty($suscripcionPagos)): ?>
            <tr>
              <td colspan="3" class="config-subscription-empty">Sin pagos registrados.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>

  <dialog id="miDialogoDetalleSuscripcion" class="config-subscription-dialog">
    <div class="config-subscription-dialog__header">
      <span><i class="fa-solid fa-id-card"></i></span>
      <div>
        <small>SUSCRIPCION</small>
        <h4>Detalle de la suscripcion</h4>
        <p>Actualiza el plan, estado y fecha de corte de la cuenta.</p>
      </div>
      <button class="config-subscription-dialog__close btnXCerrarRegistroPago" type="button" aria-label="Cerrar">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div id="divmsjalerta1"></div>
    <form id="formDetalleSuscripcion" class="formulario config-subscription-dialog__form">
      <div class="config-subscription-dialog__grid">
        <label>
          <span>Estado</span>
          <select id="estado" name="estado" required>
            <option value="1" <?php echo $estadoActivo ? 'selected' : ''; ?>>Activa</option>
            <option value="0" <?php echo !$estadoActivo ? 'selected' : ''; ?>>Suspendida</option>
          </select>
        </label>

        <label>
          <span>Plan</span>
          <select id="idplan" name="idplan" required>
            <option value="2" <?php echo ($negocio->idplan ?? '') == 2 ? 'selected' : ''; ?>>Plan mensual</option>
            <option value="1" <?php echo ($negocio->idplan ?? '') == 1 ? 'selected' : ''; ?>>Plan anual</option>
            <option value="3" <?php echo ($negocio->idplan ?? '') == 3 ? 'selected' : ''; ?>>Plan diario</option>
          </select>
        </label>

        <label>
          <span>Fecha de corte</span>
          <input id="fecha_corte" type="date" name="fecha_corte" value="<?php echo $negocio->fecha_corte; ?>" min="<?php echo date('Y-m-d');?>" required>
        </label>

        <label>
          <span>Valor del plan</span>
          <input id="valorplan" type="text" placeholder="Ingresa el monto" name="valorplan" value="<?php echo $negocio->valorplan; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
        </label>
      </div>

      <div class="config-subscription-dialog__actions">
        <button type="button" value="Cancelar" class="config-subscription__button config-subscription__button--secondary">Cancelar</button>
        <input id="btnEnviarDetalleSuscripcion" type="submit" value="Aplicar" class="config-subscription__button config-subscription__button--primary">
      </div>
    </form>
  </dialog>

  <dialog id="miDialogoRegistrarPago" class="config-subscription-dialog">
    <div class="config-subscription-dialog__header">
      <span><i class="fa-solid fa-receipt"></i></span>
      <div>
        <small>PAGO</small>
        <h4>Registrar pago</h4>
        <p>Guarda el pago recibido y actualiza la suscripcion.</p>
      </div>
      <button class="config-subscription-dialog__close btnXCerrarRegistroPago" type="button" aria-label="Cerrar">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div id="divmsjalerta1"></div>
    <form id="formRegistrarPago" class="formulario config-subscription-dialog__form">
      <div class="config-subscription-dialog__grid">
        <label>
          <span>Valor a registrar</span>
          <input id="valor_pagado" type="text" placeholder="Ingresa el monto" name="valor_pagado" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
        </label>

        <label>
          <span>Cantidad del plan pago</span>
          <input id="cantidad_plan" type="text" placeholder="Renovaciones del plan" name="cantidad_plan" value="1" oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, ''); if(this.value === '' || this.value === '0'){this.value = '';}" required>
        </label>

        <label class="config-subscription-dialog__wide">
          <span>Medio de pago</span>
          <input id="medio_pago" type="text" placeholder="Descripcion del medio de pago" name="medio_pago" value="" required>
        </label>

        <label class="config-subscription-dialog__wide">
          <span>Observacion</span>
          <textarea id="descripcion" name="descripcion" rows="4"></textarea>
        </label>
      </div>

      <div class="config-subscription-dialog__actions">
        <button type="button" value="Cancelar" class="config-subscription__button config-subscription__button--secondary">Cancelar</button>
        <input id="btnEnviarRegistrarPago" type="submit" value="Aplicar" class="config-subscription__button config-subscription__button--primary">
      </div>
    </form>
  </dialog>
</div>
