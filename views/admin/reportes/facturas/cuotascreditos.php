<div class="box cuotasCreditos report-cuotas">
  <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>

  <div class="report-cuotas__shell">
    <section class="report-cuotas__hero">
      <a href="/admin/creditos" class="report-cuotas__back" aria-label="Volver a creditos">
        <i class="fa-solid fa-arrow-left"></i>
      </a>

      <div class="report-cuotas__title">
        <p>Cartera</p>
        <h1>Reporte de cuotas</h1>
        <span>Consulta pagos de creditos y separados por rango de fechas.</span>
      </div>

      <div class="report-cuotas__stats" aria-label="Resumen del reporte">
        <article class="report-cuotas__stat">
          <span><i class="fa-solid fa-receipt"></i></span>
          <div>
            <strong id="cuotasCreditosTotalRegistros">0</strong>
            <small>cuotas registradas</small>
          </div>
        </article>
        <article class="report-cuotas__stat report-cuotas__stat--accent">
          <span><i class="fa-solid fa-wallet"></i></span>
          <div>
            <strong id="cuotasCreditosTotalValor">$0</strong>
            <small>valor pagado</small>
          </div>
        </article>
      </div>
    </section>

    <section class="report-cuotas__filters">
      <div class="report-cuotas__filters-header">
        <span><i class="fa-solid fa-calendar-days"></i></span>
        <div>
          <h2>Periodo de consulta</h2>
          <p>Elige un atajo o define un rango personalizado.</p>
        </div>
      </div>

      <div class="report-cuotas__quick-actions">
        <button id="btnmesactual" class="report-cuotas__filter-button report-cuotas__filter-button--primary" type="button">
          <i class="fa-regular fa-calendar-check"></i>
          Mes actual
        </button>
        <button id="btnmesanterior" class="report-cuotas__filter-button" type="button">
          <i class="fa-solid fa-calendar-minus"></i>
          Mes anterior
        </button>
        <button id="btnhoy" class="report-cuotas__filter-button" type="button">
          <i class="fa-regular fa-sun"></i>
          Hoy
        </button>
        <button id="btnayer" class="report-cuotas__filter-button" type="button">
          <i class="fa-solid fa-clock-rotate-left"></i>
          Ayer
        </button>
      </div>

      <div class="report-cuotas__custom-range">
        <label for="cuotasCreditosRango">Rango personalizado</label>
        <div class="report-cuotas__date-field">
          <span><i class="fa-solid fa-calendar"></i></span>
          <input
            id="cuotasCreditosRango"
            type="text"
            name="datetimes"
            placeholder="Seleccionar fecha"
            autocomplete="off"
            inputmode="none"
            readonly
          >
        </div>
        <button id="consultarFechaPersonalizada" class="report-cuotas__filter-button report-cuotas__filter-button--accent" type="button">
          <i class="fa-solid fa-magnifying-glass-chart"></i>
          Consultar
        </button>
      </div>
    </section>

    <section class="report-cuotas__table-card">
      <div class="report-cuotas__table-header">
        <div>
          <h2>Cuotas de creditos/separados</h2>
          <p>Detalle de pagos, medio utilizado y estado del credito.</p>
        </div>
        <span id="cuotasCreditosPeriodo">Sin periodo consultado</span>
      </div>

      <div class="report-cuotas__table-wrap">
        <table id="tablaCuotasCreditos" class="display responsive nowrap tabla report-cuotas__table" width="100%">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Tipo</th>
              <th>Cliente</th>
              <th>Credito</th>
              <th>No. cuota</th>
              <th>Valor</th>
              <th>Medio de pago</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </section>
  </div>
</div>
