<!-- MODAL PARA PAGO TOTAL-->
  <dialog id="miDialogoPagoTotal" class="detalle-abono-dialog detalle-pago-total-dialog">
    <div class="detalle-abono-dialog__header">
        <div class="detalle-abono-dialog__title">
            <span class="detalle-abono-dialog__icon detalle-pago-total-dialog__icon">
                <i class="fa-solid fa-circle-check"></i>
            </span>
            <div>
                <p>Credito</p>
                <h4 id="modalPagoTotal">Pago total</h4>
                <span>Cierra la deuda pendiente del cliente en una sola operacion.</span>
            </div>
        </div>
        <button id="btnXCerrarModalPagoTotal" type="button" class="detalle-abono-dialog__close" aria-label="Cerrar pago total">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="divmsjalerta3"></div>
    <form id="formCrearUpdatePagoTotal" class="detalle-abono-dialog__form formulario" action="/admin/creditos/pagoTotal" method="POST">
        <!-- El monto de la cuota se calcula atomaticamente segun la cantidad de cuotas-->
        <input class="hidden" type="text" name="id_credito" value="<?php echo $credito->id;?>">
        <div class="detalle-abono-dialog__amount-card detalle-pago-total-dialog__amount">
            <span><i class="fa-solid fa-wallet"></i></span>
            <div>
                <label>Total a pagar</label>
                <strong id="PagoTotal_abono_text">$ <?php echo number_format($credito->saldopendiente??'0', '2', ',', '.');?></strong>
            </div>
        </div>
        
        <input id="PagoTotal_montocuota" class="hidden" type="text" name="montocuota" value="$<?php echo number_format($credito->montocuota??'0', '2', ',', '.');?>" readonly required>    
       <input id="PagoTotal_abono" class="hidden" type="text" name="valorpagado" value="<?php echo $credito->saldopendiente??'';?>">

        <div class="detalle-abono-dialog__grid">
        <div class="detalle-abono-dialog__field">
            <label for="PagoTotal_caja">Caja</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-cash-register"></i></span>
            <select 
                id="PagoTotal_caja" 
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
            <label for="PagoTotal_mediopago">Medio de pago</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-credit-card"></i></span>
            <select id="PagoTotal_mediopago" name="mediopagoid" required>
                <?php foreach($mediospago as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->mediopago;?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>

        <input class="hidden" type="text" name="concepto" value="PAGO DEUDA TOTAL A FACTURA">
        <div class="detalle-abono-dialog__field detalle-abono-dialog__field--full">
            <label for="pagoTotal_detalle">Observacion</label>
            <textarea id="pagoTotal_detalle" name="detalle" placeholder="Observacion" rows="4"></textarea>
        </div>
        </div>

        <div class="detalle-abono-dialog__actions">
            <button class="detalle-abono-dialog__button detalle-abono-dialog__button--secondary" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearPagoTotal" class="detalle-abono-dialog__button detalle-abono-dialog__button--primary" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal PagoTotal-->
