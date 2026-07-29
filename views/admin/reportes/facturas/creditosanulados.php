<?php
  $totalRegistros = is_countable($creditosAnulados) ? count($creditosAnulados) : 0;
  $totalCredito = 0;
  $totalAbonado = 0;

  foreach($creditosAnulados as $creditoAnulado){
    $totalCredito += (float) $creditoAnulado->montototal;
    $totalAbonado += (float) ($creditoAnulado->montototal - $creditoAnulado->saldopendiente);
  }
?>

<div class="box creditosAnulados report-cuotas report-anulados">
  <div class="report-cuotas__shell">
    <section class="report-cuotas__hero">
      <a href="/admin/creditos" class="report-cuotas__back" aria-label="Volver a creditos">
        <i class="fa-solid fa-arrow-left"></i>
      </a>

      <div class="report-cuotas__title">
        <p>Cartera</p>
        <h1>Creditos anulados</h1>
        <span>Consulta creditos y separados que fueron cancelados o reversados.</span>
      </div>

      <div class="report-cuotas__stats" aria-label="Resumen de creditos anulados">
        <article class="report-cuotas__stat report-anulados__stat">
          <span><i class="fa-solid fa-ban"></i></span>
          <div>
            <strong><?php echo number_format($totalRegistros, 0, ',', '.'); ?></strong>
            <small>registros anulados</small>
          </div>
        </article>
        <article class="report-cuotas__stat report-cuotas__stat--accent">
          <span><i class="fa-solid fa-wallet"></i></span>
          <div>
            <strong>$<?php echo number_format($totalAbonado, 0, ',', '.'); ?></strong>
            <small>total abonado</small>
          </div>
        </article>
      </div>
    </section>

    <section class="report-cuotas__table-card">
      <div class="report-cuotas__table-header">
        <div>
          <h2>Historial anulado</h2>
          <p>Detalle de cliente, valores, abonos y acceso rapido al credito.</p>
        </div>
        <span>$<?php echo number_format($totalCredito, 0, ',', '.'); ?> en cartera anulada</span>
      </div>

      <div class="report-cuotas__table-wrap">
        <table id="tablaCreditosAnulados" class="display responsive nowrap tabla report-cuotas__table report-anulados__table" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Fecha</th>
              <th>Tipo</th>
              <th>Cliente</th>
              <th>Credito</th>
              <th>Interes</th>
              <th>Total credito</th>
              <th>Abono total</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($creditosAnulados as $value): ?>
              <?php
                $tipo = $value->idtipofinanciacion == 1 ? 'Credito' : 'Separado';
                $estado = $value->idestadocreditos == 1 ? 'Finalizado' : ($value->idestadocreditos == 2 ? 'Abierto' : 'Anulado');
                $estadoClase = $value->idestadocreditos == 1 ? 'report-cuotas__status--success' : ($value->idestadocreditos == 2 ? 'report-cuotas__status--warning' : 'report-cuotas__status--danger');
                $tipoClase = $value->idtipofinanciacion == 1 ? 'report-cuotas__pill--credit' : 'report-cuotas__pill--separado';
                $cliente = trim($value->nombre.' '.$value->apellido);
                $abonoTotal = (float) ($value->montototal - $value->saldopendiente);
              ?>
              <tr>
                <td><span class="report-cuotas__document"><?php echo htmlspecialchars($value->ID); ?></span></td>
                <td><?php echo htmlspecialchars($value->fechainicio); ?></td>
                <td><span class="report-cuotas__pill <?php echo $tipoClase; ?>"><?php echo $tipo; ?></span></td>
                <td>
                  <span class="report-cuotas__client">
                    <i class="fa-solid fa-user"></i>
                    <?php echo htmlspecialchars($cliente ?: 'Sin cliente'); ?>
                  </span>
                </td>
                <td><strong class="report-cuotas__money">$<?php echo number_format($value->capital, 2, ',', '.'); ?></strong></td>
                <td>$<?php echo number_format($value->valorinterestotal, 2, ',', '.'); ?></td>
                <td><strong>$<?php echo number_format($value->montototal, 2, ',', '.'); ?></strong></td>
                <td><span class="report-cuotas__method">$<?php echo number_format($abonoTotal, 2, ',', '.'); ?></span></td>
                <td>
                  <div class="report-finalizados__actions">
                    <span class="report-cuotas__status <?php echo $estadoClase; ?>"><?php echo $estado; ?></span>
                    <a class="report-finalizados__open" href="/admin/creditos/detallecredito?id=<?php echo htmlspecialchars($value->ID); ?>" target="_blank" rel="noopener">
                      <i class="fa-solid fa-arrow-up-right-from-square"></i>
                      Abrir
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>
