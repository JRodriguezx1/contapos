<!-- MODAL PARA ABONAR-->
<dialog id="miDialogoAbono" class="clientes-dialog cliente-detail-dialog">
    <div class="clientes-dialog__header clientes-dialog__header--with-close">
        <span><i class="fa-solid fa-hand-holding-dollar"></i></span>
        <div>
            <p>Credito</p>
            <h4 id="modalAbono">Registrar abono</h4>
            <small>Aplica un pago parcial al saldo pendiente.</small>
        </div>
        <button type="button" class="clientes-dialog__close" title="Cerrar">
            <i id="btnXCerrarModalAbono" class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="divmsjalerta2"></div>
    <form id="formrealizarAbono" class="clientes-dialog__form cliente-detail-form">
        <div class="cliente-detail-credit-box">
            <h5 id="numCredito">Credito No.: </h5>
            <p id="saldopendiente">Saldo pendiente: $500.000</p>
        </div>

        <label class="clientes-field">
            <span>Caja</span>
            <span class="clientes-control clientes-control--select">
                <i class="fa-solid fa-cash-register"></i>
                <select id="abono_caja" name="cajaid" required>
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
                <select id="abono_mediopago" name="mediopagoid" required>
                    <?php foreach($mediospago as $value): ?>
                    <option value="<?php echo $value->id; ?>"><?php echo htmlspecialchars($value->mediopago, ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </label>

        <label class="clientes-field">
            <span>Abono</span>
            <span class="clientes-control">
                <i class="fa-solid fa-dollar-sign"></i>
                <input
                    id="abono"
                    type="text"
                    placeholder="Abono de la deuda"
                    name="valorpagado"
                    value="<?php echo $cuota->valorpagado??'';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';"
                    required
                >
            </span>
        </label>

        <label for="imprimirAbono" class="cliente-detail-switch">
            <span>
                <strong>Imprimir comprobante</strong>
                <small>Genera el soporte del abono al confirmar.</small>
            </span>
            <input
                id="imprimirAbono"
                name="imprimirAbono"
                value="1"
                type="checkbox"
                <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?>
            >
            <i aria-hidden="true"></i>
        </label>

        <div class="clientes-dialog__actions">
            <button class="clientes-button clientes-button--secondary" type="button" value="Salir">Salir</button>
            <button id="btnEditarCrearAbono" class="clientes-button clientes-button--primary" type="submit">Confirmar</button>
        </div>
    </form>
</dialog><!--fin modal Abonar-->
