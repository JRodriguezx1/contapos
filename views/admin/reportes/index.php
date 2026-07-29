<div class="box reportes reportes-dashboard mb-20">
  <div class="reportes-dashboard__shell">
    <section class="reportes-dashboard__hero">
      <div class="reportes-dashboard__hero-text">
        <span>Analitica</span>
        <h1>Centro de reportes</h1>
        <p>Consulta ventas, cartera, facturacion, inventario y rentabilidad desde una vista mas clara.</p>
      </div>
      <div class="reportes-dashboard__hero-card">
        <span class="material-symbols-outlined">query_stats</span>
        <strong>Panel</strong>
        <small>reportes disponibles</small>
      </div>
    </section>

    <section class="reportes-dashboard__charts">
      <article class="reportes-dashboard__chart reportes-dashboard__chart--wide">
        <div class="reportes-dashboard__chart-header">
          <div>
            <span>Ventas</span>
            <h2>Representacion grafica de ventas</h2>
          </div>
          <div class="reportes-dashboard__switch">
            <button id="graficaVentaMensual" class="graficaventa" type="button">Mensual</button>
            <button id="graficaVentaDiario" class="graficaventa" type="button">Diario</button>
          </div>
        </div>
        <div class="reportes-dashboard__canvas">
          <canvas id="chartventas"></canvas>
        </div>
      </article>

      <article class="reportes-dashboard__chart">
        <div class="reportes-dashboard__chart-header">
          <div>
            <span>Inventario</span>
            <h2>Productos principales</h2>
          </div>
        </div>
        <div class="reportes-dashboard__canvas">
          <canvas id="chartutilidad"></canvas>
        </div>
      </article>
    </section>

    <section class="reportes-dashboard__section">
      <div class="reportes-dashboard__section-header">
        <span class="material-symbols-outlined">payments</span>
        <div>
          <h2>Reportes de ventas</h2>
          <p>Seguimiento comercial, cartera y operaciones de caja.</p>
        </div>
      </div>
      <div class="reportes-dashboard__grid">
        <a href="/admin/reportes/ventasgenerales" class="reportes-dashboard__link reportes-dashboard__link--primary">
          <span class="material-symbols-outlined">payments</span>
          <strong>Ventas generales</strong>
          <small>Resumen de ventas</small>
        </a>
        <a href="/admin/reportes/creditos" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">account_balance_wallet</span>
          <strong>Estados creditos</strong>
          <small>Cartera activa</small>
        </a>
        <a href="/admin/caja/ultimoscierres" class="reportes-dashboard__link reportes-dashboard__link--primary">
          <span class="material-symbols-outlined">point_of_sale</span>
          <strong>Cierres de caja</strong>
          <small>Control de caja</small>
        </a>
        <a href="/admin/caja/zetadiario" class="reportes-dashboard__link">
          <i class="fa-solid fa-z"></i>
          <strong>Zeta diario</strong>
          <small>Corte diario</small>
        </a>
        <a href="/admin/reportes/ventasxtransaccion" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">receipt_long</span>
          <strong>Ventas por transaccion</strong>
          <small>Detalle de movimientos</small>
        </a>
        <a href="/admin/reportes/ventasxcliente" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">person_search</span>
          <strong>Ventas por cliente</strong>
          <small>Consumo por cliente</small>
        </a>
        <a href="/admin/reportes/ventaProductosUsuarios" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">package_2</span>
          <strong>Productos por usuario</strong>
          <small>Gestion por vendedor</small>
        </a>
        <a href="/admin/reportes/reporteEmisores" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">business_center</span>
          <strong>Reporte de emisores</strong>
          <small>Operacion por emisor</small>
        </a>
      </div>
    </section>

    <section class="reportes-dashboard__section">
      <div class="reportes-dashboard__section-header">
        <span class="material-symbols-outlined">request_quote</span>
        <div>
          <h2>Reportes de facturas</h2>
          <p>Consulta facturas, recibos y documentos electronicos.</p>
        </div>
      </div>
      <div class="reportes-dashboard__grid">
        <a href="/admin/reportes/facturaspagas" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">request_quote</span>
          <strong>Facturas pagas</strong>
          <small>Documentos pagados</small>
        </a>
        <a href="/admin/caja/pedidosguardados" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">receipt_long</span>
          <strong>Cotizaciones</strong>
          <small>Pedidos guardados</small>
        </a>
        <a href="/admin/reportes/facturasanuladas" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">contract_delete</span>
          <strong>Facturas anuladas</strong>
          <small>Documentos anulados</small>
        </a>
        <a href="/admin/reportes/facturaselectronicas" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">description</span>
          <strong>Electronicas generadas</strong>
          <small>Facturacion electronica</small>
        </a>
        <a href="/admin/reportes/facturaselectronicaspendientes" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">pending_actions</span>
          <strong>Electronicas pendientes</strong>
          <small>Por gestionar</small>
        </a>
        <a href="/admin/reportes/recibosCaja" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">point_of_sale</span>
          <strong>Recibos de caja</strong>
          <small>Ingresos registrados</small>
        </a>
      </div>
    </section>

    <section class="reportes-dashboard__section">
      <div class="reportes-dashboard__section-header">
        <span class="material-symbols-outlined">inventory_2</span>
        <div>
          <h2>Reportes de inventario</h2>
          <p>Movimientos, compras y control de existencias.</p>
        </div>
      </div>
      <div class="reportes-dashboard__grid">
        <a href="/admin/reportes/inventarioxproducto" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">category</span>
          <strong>Inventario por producto</strong>
          <small>Existencias por articulo</small>
        </a>
        <button class="reportes-dashboard__link" type="button">
          <span class="material-symbols-outlined">splitscreen_bottom</span>
          <strong>Inventario por categoria</strong>
          <small>Vista agrupada</small>
        </button>
        <button class="reportes-dashboard__link" type="button">
          <span class="material-symbols-outlined">storefront</span>
          <strong>Inventario por sede</strong>
          <small>Stock por ubicacion</small>
        </button>
        <button class="reportes-dashboard__link" type="button">
          <span class="material-symbols-outlined">inventory_2</span>
          <strong>Inventario general</strong>
          <small>Balance completo</small>
        </button>
        <a href="/admin/reportes/movimientosinventarios" class="reportes-dashboard__link">
          <span class="material-symbols-outlined">sync_alt</span>
          <strong>Movimientos de inventario</strong>
          <small>Entradas y salidas</small>
        </a>
        <a href="/admin/reportes/compras" class="reportes-dashboard__link reportes-dashboard__link--primary">
          <span class="material-symbols-outlined">shopping_cart</span>
          <strong>Compras</strong>
          <small>Ordenes y compras</small>
        </a>
        <button class="reportes-dashboard__link reportes-dashboard__link--primary" type="button">
          <span class="material-symbols-outlined">move_up</span>
          <strong>Rotacion de inventario</strong>
          <small>Indicadores de salida</small>
        </button>
      </div>
    </section>

    <div class="reportes-dashboard__columns">
      <section class="reportes-dashboard__section">
        <div class="reportes-dashboard__section-header">
          <span class="material-symbols-outlined">monitoring</span>
          <div>
            <h2>Utilidad y crecimiento</h2>
            <p>Rentabilidad, gastos y comparativos.</p>
          </div>
        </div>
        <div class="reportes-dashboard__grid reportes-dashboard__grid--compact">
          <a href="/admin/reportes/utilidadRentabilidad" class="reportes-dashboard__link">
            <span class="material-symbols-outlined">monitoring</span>
            <strong>Utilidad rentabilidad</strong>
            <small>Margenes del negocio</small>
          </a>
          <a href="/admin/reportes/utilidadxproducto" class="reportes-dashboard__link">
            <span class="material-symbols-outlined">chart_data</span>
            <strong>Utilidad por producto</strong>
            <small>Margen por articulo</small>
          </a>
          <button class="reportes-dashboard__link" type="button">
            <span class="material-symbols-outlined">category</span>
            <strong>Utilidad por categoria</strong>
            <small>Agrupacion por familia</small>
          </button>
          <a href="/admin/reportes/gastoseingresos" class="reportes-dashboard__link">
            <span class="material-symbols-outlined">fact_check</span>
            <strong>Gastos e ingresos</strong>
            <small>Flujo operativo</small>
          </a>
          <button class="reportes-dashboard__link" type="button">
            <span class="material-symbols-outlined">query_stats</span>
            <strong>Comparacion interanual</strong>
            <small>Evolucion por anos</small>
          </button>
          <button class="reportes-dashboard__link" type="button">
            <span class="material-symbols-outlined">deployed_code_update</span>
            <strong>Tasa de retorno</strong>
            <small>Indicador de inversion</small>
          </button>
        </div>
      </section>

      <section class="reportes-dashboard__section">
        <div class="reportes-dashboard__section-header">
          <span class="material-symbols-outlined">group</span>
          <div>
            <h2>Otros reportes</h2>
            <p>Clientes y actividad del sistema.</p>
          </div>
        </div>
        <div class="reportes-dashboard__grid reportes-dashboard__grid--compact">
          <a href="/admin/reportes/clientesnuevos" class="reportes-dashboard__link">
            <span class="material-symbols-outlined">person_add</span>
            <strong>Clientes nuevos</strong>
            <small>Altas recientes</small>
          </a>
          <a href="/admin/reportes/clientesrecurrentes" class="reportes-dashboard__link reportes-dashboard__link--primary">
            <span class="material-symbols-outlined">person_check</span>
            <strong>Clientes recurrentes</strong>
            <small>Frecuencia de compra</small>
          </a>
          <button class="reportes-dashboard__link reportes-dashboard__link--primary" type="button">
            <span class="material-symbols-outlined">vpn_key_alert</span>
            <strong>Registro de actividad</strong>
            <small>Auditoria interna</small>
          </button>
        </div>
      </section>
    </div>
  </div>
</div>
