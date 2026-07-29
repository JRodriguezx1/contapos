<?php
    $nombreCliente = trim(($cliente->nombre ?? '') . ' ' . ($cliente->apellido ?? ''));
    $emailCliente = $cliente->email ?: 'Sin correo registrado';
    $telefonoCliente = $cliente->telefono ?: 'NA';
    $totalCompras = $indicadores->cantidad_ventas ?? 0;
    $montoComprado = $indicadores->total_ventas_cliente ?? 0;
    $ticketPromedio = $indicadores->ticket_promedio ?? 0;
    $deudaCliente = $cliente->totaldebe ?? 0;
?>

<div class="detallecliente">
    <div class="cliente-detail-shell">
        <section class="cliente-detail-hero">
            <a href="/admin/clientes" class="cliente-detail-back" title="Volver a clientes">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="sr-only">Atras</span>
            </a>

            <div class="cliente-detail-hero__content">
                <p class="cliente-detail-eyebrow">CRM</p>
                <h1><?php echo htmlspecialchars($nombreCliente ?: 'Cliente', ENT_QUOTES, 'UTF-8'); ?></h1>
                <p>Consulta perfil, compras, creditos y deuda del cliente desde una vista mas clara.</p>
            </div>

            <div class="cliente-detail-hero__badge">
                <span><i class="fa-solid fa-user-check"></i></span>
                <div>
                    <strong>Activo</strong>
                    <small>estado del cliente</small>
                </div>
            </div>
        </section>

        <section class="cliente-detail-profile-card">
            <div class="cliente-detail-profile-card__header">
                <span><i class="fa-solid fa-address-card"></i></span>
                <div>
                    <h2>Perfil del cliente</h2>
                    <p>Datos principales de contacto y relacion comercial.</p>
                </div>
            </div>

            <div class="cliente-detail-info-grid">
                <article class="cliente-detail-info-item">
                    <span><i class="fa-solid fa-envelope"></i></span>
                    <div>
                        <small>Correo</small>
                        <strong><?php echo htmlspecialchars($emailCliente, ENT_QUOTES, 'UTF-8'); ?></strong>
                    </div>
                </article>
                <article class="cliente-detail-info-item">
                    <span><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <small>Telefono</small>
                        <strong><?php echo htmlspecialchars($telefonoCliente, ENT_QUOTES, 'UTF-8'); ?></strong>
                    </div>
                </article>
                <article class="cliente-detail-info-item">
                    <span><i class="fa-solid fa-bag-shopping"></i></span>
                    <div>
                        <small>Ultima compra</small>
                        <strong>-</strong>
                    </div>
                </article>
                <article class="cliente-detail-info-item">
                    <span><i class="fa-solid fa-calendar-check"></i></span>
                    <div>
                        <small>Cliente desde</small>
                        <strong>-</strong>
                    </div>
                </article>
            </div>
        </section>

        <section class="cliente-detail-kpis">
            <article class="cliente-detail-kpi cliente-detail-kpi--emerald">
                <span><i class="fa-solid fa-receipt"></i></span>
                <div>
                    <small>Total de compras</small>
                    <strong><?php echo number_format($totalCompras, 0, ',', '.'); ?></strong>
                </div>
            </article>
            <article class="cliente-detail-kpi cliente-detail-kpi--purple">
                <span><i class="fa-solid fa-coins"></i></span>
                <div>
                    <small>Monto total comprado</small>
                    <strong>$ <?php echo number_format($montoComprado, 2, ',', '.'); ?></strong>
                </div>
            </article>
            <article class="cliente-detail-kpi cliente-detail-kpi--cyan">
                <span><i class="fa-solid fa-chart-line"></i></span>
                <div>
                    <small>Ticket promedio</small>
                    <strong>$ <?php echo number_format($ticketPromedio, 2, ',', '.'); ?></strong>
                </div>
            </article>
            <article class="cliente-detail-kpi cliente-detail-kpi--rose">
                <span><i class="fa-solid fa-gift"></i></span>
                <div>
                    <small>Puntos acumulados</small>
                    <strong>900 Pts</strong>
                </div>
            </article>
        </section>

        <section class="cliente-detail-chart-grid">
            <article class="cliente-detail-card">
                <div class="cliente-detail-card__header">
                    <span><i class="fa-solid fa-chart-area"></i></span>
                    <div>
                        <h2>Compras por mes</h2>
                        <p>Evolucion de ventas asociadas al cliente.</p>
                    </div>
                </div>
                <div class="cliente-detail-chart">
                    <canvas id="chartComprasMes"></canvas>
                </div>
            </article>

            <article class="cliente-detail-card">
                <div class="cliente-detail-card__header">
                    <span><i class="fa-solid fa-chart-pie"></i></span>
                    <div>
                        <h2>Categorias mas compradas</h2>
                        <p>Participacion por categoria en unidades vendidas.</p>
                    </div>
                </div>
                <div class="cliente-detail-chart cliente-detail-chart--compact">
                    <canvas id="chartCategorias"></canvas>
                </div>
            </article>
        </section>

        <section class="cliente-detail-debtbar">
            <button id="btnDeudaTotal" class="cliente-detail-debt-button cliente-detail-debt-button--summary" type="button">
                <span><i class="fa-solid fa-wallet"></i></span>
                <span>Deuda total <strong id="totalDeudaText">$<?php echo number_format($deudaCliente, 0, ',', '.'); ?></strong></span>
            </button>
            <button id="btnPagoDeudaTotal" class="cliente-detail-debt-button cliente-detail-debt-button--pay" type="button">
                <span><i class="fa-solid fa-check"></i></span>
                <span>Pago total</span>
            </button>
            <button id="btnTotalCuotas" class="cliente-detail-debt-button cliente-detail-debt-button--installments" type="button">
                <span><i class="fa-solid fa-list-check"></i></span>
                <span>Cuotas</span>
            </button>
        </section>

        <section class="cliente-detail-card cliente-detail-card--table">
            <div class="cliente-detail-card__header">
                <span><i class="fa-solid fa-file-invoice-dollar"></i></span>
                <div>
                    <h2>Historial de creditos</h2>
                    <p>Consulta saldos, estado y acciones disponibles por credito.</p>
                </div>
            </div>

            <div class="cliente-detail-table-wrap">
                <table id="tablaCreditos" class="cliente-detail-table tabla">
                    <thead>
                        <tr>
                            <th>Emisor</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Credito</th>
                            <th>No. cuota</th>
                            <th>Saldo pendiente</th>
                            <th>Estado</th>
                            <th class="accionesth">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($creditos as $value): ?>
                        <?php
                            $estadoTexto = $value->idestadocreditos==1 ? 'Finalizado' : ($value->idestadocreditos==2 ? 'Abierto' : 'Anulado');
                            $estadoClase = $value->idestadocreditos==1 ? 'is-done' : ($value->idestadocreditos==2 ? 'is-open pendiente' : 'is-cancelled');
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($value->nombreEmisor ?? 'Negocio', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($value->created_at, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $value->idtipofinanciacion==1 ? 'Credito' : 'Separado'; ?></td>
                            <td>$<?php echo number_format($value->capital, 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($value->numcuota, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="<?php echo $value->saldopendiente>0 ? 'cliente-detail-debt-cell' : ''; ?>">$<?php echo number_format($value->saldopendiente, 2, ',', '.'); ?></td>
                            <td class="<?php echo $estadoClase; ?>"><span class="cliente-detail-status cliente-detail-status--<?php echo $value->idestadocreditos; ?>"><?php echo $estadoTexto; ?></span></td>
                            <td class="accionestd">
                                <div class="acciones-btns cliente-detail-actions" id="<?php echo $value->id; ?>" data-saldopendiente="<?php echo $value->saldopendiente; ?>" data-montocuota="<?php echo $value->montocuota; ?>">
                                    <button class="cliente-detail-action cliente-detail-action--pay abonarCredito" type="button" title="Abonar al credito"><i class="fa-solid fa-dollar-sign"></i></button>
                                    <a class="cliente-detail-action cliente-detail-action--view" href="/admin/creditos/detallecredito?id=<?php echo $value->id; ?>" target="_blank" title="Ver detalle del credito"><i class="fa-solid fa-chart-simple"></i></a>
                                    <?php if($value->idtipofinanciacion==2&&$value->idestadocreditos==2): ?>
                                    <button class="cliente-detail-action cliente-detail-action--delete anularCredito" type="button" title="Eliminar el credito"><i class="fa-solid fa-trash-can"></i></button>
                                    <?php endif; ?>
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

<?php include __DIR__ . "/abonoCredito.php"; ?>

<dialog id="miDialogoTotalCuotas" class="clientes-dialog cliente-detail-dialog cliente-detail-dialog--wide">
    <div class="clientes-dialog__header clientes-dialog__header--with-close">
        <span><i class="fa-solid fa-calendar-days"></i></span>
        <div>
            <p>Credito</p>
            <h4 id="modalTotalCuotas">Todas las cuotas</h4>
            <small>Detalle completo de cuotas asociadas al cliente.</small>
        </div>
        <button type="button" class="clientes-dialog__close" title="Cerrar">
            <i id="btnCerrarTotalCuotas" class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="divmsjalerta"></div>
    <div class="cliente-detail-table-wrap cliente-detail-table-wrap--modal">
        <table id="tablaCuotas" class="cliente-detail-table cliente-detail-table--modal">
            <thead>
                <tr>
                    <th>No. credito</th>
                    <th>Credito total</th>
                    <th>No. cuota</th>
                    <th>Valor cuota</th>
                    <th>Fecha pago</th>
                    <th>Estado credito</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</dialog>

<dialog id="miDialogoPagoTotal" class="clientes-dialog cliente-detail-dialog">
    <div class="clientes-dialog__header clientes-dialog__header--with-close">
        <span><i class="fa-solid fa-circle-check"></i></span>
        <div>
            <p>Pago</p>
            <h4 id="modalPagoTotal">Pago total</h4>
            <small>Registra el pago completo de la deuda del cliente.</small>
        </div>
        <button type="button" class="clientes-dialog__close" title="Cerrar">
            <i id="btnCerrarPagoTotal" class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="divmsjalerta1"></div>
    <form id="formPagoTotalDeuda" class="clientes-dialog__form cliente-detail-form">
        <div class="cliente-detail-total-box">
            <span><i class="fa-solid fa-money-bill-wave"></i></span>
            <div>
                <small>Total a pagar</small>
                <strong>$<?php echo number_format($deudaCliente, 0, ',', '.'); ?></strong>
            </div>
        </div>

        <label class="clientes-field">
            <span>Caja</span>
            <span class="clientes-control clientes-control--select">
                <i class="fa-solid fa-cash-register"></i>
                <select id="PagoTotal_caja" name="cajaid" required>
                    <?php foreach($cajas as $value): ?>
                    <option value="<?php echo $value->id; ?>"><?php echo htmlspecialchars($value->nombre, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </label>

        <label class="clientes-field">
            <span>Medio de pago</span>
            <span class="clientes-control clientes-control--select">
                <i class="fa-solid fa-credit-card"></i>
                <select id="PagoTotal_mediopago" name="mediopagoid" required>
                    <?php foreach($mediospago as $value): ?>
                    <option value="<?php echo $value->id; ?>"><?php echo htmlspecialchars($value->mediopago, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </label>

        <div class="clientes-dialog__actions">
            <button class="clientes-button clientes-button--secondary" type="button" value="Salir">Salir</button>
            <button id="btnFormPagoTotalDeuda" class="clientes-button clientes-button--primary" type="submit">Confirmar</button>
        </div>
    </form>
</dialog>

<script>
    const getParam = <?= json_encode($conflocal) ?>;
    let deudatotalCiente = <?= json_encode($cliente->totaldebe) ?>
</script>
