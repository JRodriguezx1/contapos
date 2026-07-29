<?php
  $totalCreditos = count($creditos);
  $creditosAbiertos = 0;
  $saldoPendienteTotal = 0;

  foreach($creditos as $creditoResumen){
    if((int)$creditoResumen->idestadocreditos === 2){
      $creditosAbiertos++;
    }
    $saldoPendienteTotal += (float)$creditoResumen->saldopendiente;
  }
?>

<div class="box creditos">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>

  <div class="creditos-shell">
    <section class="creditos-hero">
      <div class="creditos-hero__content">
        <p class="creditos-eyebrow">Cartera</p>
        <h1>Gestion de creditos</h1>
        <p>Administra separados, creditos activos, saldos pendientes y reportes desde una vista mas clara.</p>
      </div>
      <div class="creditos-hero__metrics">
        <article class="creditos-stat">
          <span class="material-symbols-outlined">credit_score</span>
          <div>
            <strong><?php echo $totalCreditos; ?></strong>
            <small>registros</small>
          </div>
        </article>
        <article class="creditos-stat creditos-stat--accent">
          <span class="material-symbols-outlined">account_balance_wallet</span>
          <div>
            <strong>$<?php echo number_format($saldoPendienteTotal, '0', ',', '.'); ?></strong>
            <small>saldo pendiente</small>
          </div>
        </article>
      </div>
    </section>

    <section class="creditos-actions">
      <a class="creditos-button creditos-button--primary" href="/admin/creditos/separado">
        <span class="material-symbols-outlined">add_2</span>
        Crear separado
      </a>
      <a class="creditos-button creditos-button--secondary" href="/admin/reportes/creditos/cuotas-creditos">
        <span class="material-symbols-outlined">list_alt</span>
        Reporte cuotas
      </a>
      <a class="creditos-button creditos-button--light" href="/admin/reportes/creditos/creditos-finalizados">
        <span class="material-symbols-outlined">task_alt</span>
        Creditos finalizados
      </a>
      <a class="creditos-button creditos-button--light" href="/admin/reportes/creditos/creditos-anulados">
        <span class="material-symbols-outlined">folder_off</span>
        Creditos anulados
      </a>
    </section>

    <div id="divmsjalerta"></div>

    <section class="creditos-table-card config-table-card">
      <div class="creditos-table-card__header">
        <div>
          <h2>Historial de creditos</h2>
          <p>Consulta cliente, valores, estado y acciones disponibles por credito.</p>
        </div>
        <span class="creditos-table-card__counter"><?php echo $creditosAbiertos; ?> abiertos</span>
      </div>

      <table class="display responsive nowrap tabla creditos-data-table" width="100%" id="tablaCreditos">
        <thead>
            <tr>
                <th>id</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>CC</th>
                <th>Cliente</th>
                <th>Credito</th>
                <th>Interes</th>
                <th>Total Credito</th>
                <th>Abono total</th>
                <th>Estado</th>
                <th class="accionesth">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($creditos as $value): ?>
                <?php
                  $estadoCredito = $value->idestadocreditos==1?'Finalizado':($value->idestadocreditos==2?'Abierto':'Anulado');
                  $estadoClase = $value->idestadocreditos==1?'success':($value->idestadocreditos==2?'warning':'danger');
                  $tipoCredito = $value->idtipofinanciacion==1?'Credito':'Separado';
                  $tipoClase = $value->idtipofinanciacion==1?'credit':'separado';
                ?>
                <tr>
                    <td><?php echo $value->ID; ?></td>
                    <td><?php echo $value->fechainicio; ?></td>
                    <td><span class="creditos-pill creditos-pill--<?php echo $tipoClase; ?>"><?php echo $tipoCredito; ?></span></td>
                    <td><span class="creditos-pill creditos-pill--document"><?php echo $value->identificacion; ?></span></td>
                    <td>
                      <span class="creditos-client">
                        <span class="creditos-client__icon"><i class="fa-solid fa-user"></i></span>
                        <span><?php echo $value->nombre.' '.$value->apellido; ?></span>
                      </span>
                    </td> 
                    <td><strong class="creditos-money">$<?php echo number_format($value->capital,'2', ',', '.'); ?></strong></td>
                    <td>$<?php echo number_format($value->valorinterestotal,'2', ',', '.'); ?></td>
                    <td>$<?php echo number_format($value->montototal,'2', ',', '.'); ?></td>
                    <td><span class="creditos-pill creditos-pill--paid">$<?php echo number_format($value->montototal+$value->abonoinicial-$value->saldopendiente,'2', ',', '.'); ?></span></td>
                    <td><span class="creditos-status creditos-status--<?php echo $estadoClase; ?>"><?php echo $estadoCredito; ?></span></td>
                    <td class="accionestd">
                        <div class="acciones-btns" id="<?php echo $value->ID;?>">
                            <a class="creditos-action creditos-action--detail" href="/admin/creditos/detallecredito?id=<?php echo $value->ID;?>" title="Ver detalle del credito"><i class="fa-solid fa-chart-simple"></i></a>
                            <?php if($value->idtipofinanciacion==2&&$value->idestadocreditos==2): ?>
                                <?php if(tienePermiso('Anular separados')&&userPerfil()>3 || userPerfil()<4){ ?>
                                    <button class="creditos-action creditos-action--danger anularCredito" title="Anular credito"><i class="fa-solid fa-trash-can"></i></button>
                            <?php } endif; ?>
                            <span id="<?php echo $value->ID;?>" class="creditos-action creditos-action--print printPOSSeparado material-symbols-outlined cursor-pointer" title="Imprimir separado">print</span>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </div>


  <script>
    const getParam = <?= json_encode($conflocal) ?>;
  </script>

</div>
