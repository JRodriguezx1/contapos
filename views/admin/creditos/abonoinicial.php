<!-- MODAL PARA ABONAR-->
  <dialog id="miDialogoAbono" class="detalle-abono-dialog">
    <div class="detalle-abono-dialog__header">
        <div class="detalle-abono-dialog__title">
            <span class="detalle-abono-dialog__icon">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </span>
            <div>
                <p>Credito</p>
                <h4 id="modalAbono">Registrar abono</h4>
                <span>Aplica un pago parcial al saldo pendiente.</span>
            </div>
        </div>
        <button type="button" class="detalle-abono-dialog__close" aria-label="Cerrar registro de abono">
            <i id="btnXCerrarModalAbono" class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="divmsjalerta2"></div>
    <form id="formCrearUpdateAbono" class="detalle-abono-dialog__form formulario" action="/admin/creditos/registrarAbono" method="POST">
        <!-- El monto de la cuota se calcula atomaticamente segun la cantidad de cuotas-->
        <input class="hidden" type="text" name="id_credito" value="<?php echo $credito->id;?>">
        <div class="detalle-abono-dialog__amount-card">
            <span><i class="fa-solid fa-receipt"></i></span>
            <div>
                <label for="montocuota">Valor de la cuota</label>
                <input id="montocuota" type="text" placeholder="Valor de la cuota" name="montocuota" value="$<?php echo number_format($credito->montocuota??'0', '2', ',', '.');?>" readonly required>
            </div>
        </div>
        <div class="detalle-abono-dialog__grid">
        <div class="detalle-abono-dialog__field">
            <label for="caja">Caja</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-cash-register"></i></span>
            <select 
                id="caja" 
                name="cajaid"
                <?= $conflocal['restringir_caja_facturadora_a_caja_inicial_del_credito']->valor_final==1?'disabled':''; ?> 
                required
            >
                <?php foreach($cajas as $value):  ?>
                      <option value="<?php echo $value->id;?>" data-idemisor="<?= $value->idemisor ?>" <?=($credito->idemisor==$value->idemisor)?'selected':'';?> ><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>
        <div class="detalle-abono-dialog__field">
            <label for="mediopago">Medio de pago</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-credit-card"></i></span>
            <select id="mediopago" name="mediopagoid" required>
                <?php foreach($mediospago as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->mediopago;?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>
        <div class="detalle-abono-dialog__field detalle-abono-dialog__field--full">
            <label for="abono">Abono</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-dollar-sign"></i></span>
                <input
                    id="abono" 
                    type="text"
                    placeholder="Abono de la deuda"
                    name="valorpagado"
                    value="<?php echo $cuota->valorpagado??'';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';"
                    required
                >
            </div>
        </div>

        <div class="detalle-abono-dialog__field detalle-abono-dialog__field--full">
            <label for="detalle">Observacion</label>
            <textarea id="detalle" name="detalle" placeholder="Observacion" rows="4"></textarea>
        </div>
        </div>
        
        <label for="imprimirComprobanteAbonoinicial" class="detalle-abono-dialog__switch">
            <span class="detalle-abono-dialog__switch-copy">
                <strong>Imprimir comprobante</strong>
                <small>Genera el soporte del abono al confirmar.</small>
            </span>
            
            <input 
                id="imprimirComprobanteAbonoinicial" 
                name="imprimirComprobanteAbonoinicial" 
                value="1" 
                type="checkbox" 
                class="sr-only peer"
                <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?>
                >
            <div class="detalle-abono-dialog__toggle">
                <small class="detalle-abono-dialog__toggle-state detalle-abono-dialog__toggle-state--off">OFF</small>
                <small class="detalle-abono-dialog__toggle-state detalle-abono-dialog__toggle-state--on">ON</small>
                <span></span>
            </div>
        </label>

        <div class="detalle-abono-dialog__actions">
            <button class="detalle-abono-dialog__button detalle-abono-dialog__button--secondary" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearAbono" class="detalle-abono-dialog__button detalle-abono-dialog__button--primary" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal Abonoar-->
