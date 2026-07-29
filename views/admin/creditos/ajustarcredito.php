<!-- MODAL PARA AJUSTAR CREDITO-->
  <dialog id="miDialogoAjustarCredito" class="detalle-abono-dialog detalle-ajuste-dialog">
    <div class="detalle-abono-dialog__header">
        <div class="detalle-abono-dialog__title">
            <span class="detalle-abono-dialog__icon detalle-ajuste-dialog__icon">
                <i class="fa-solid fa-sliders"></i>
            </span>
            <div>
                <p>Credito</p>
                <h4 id="modalAjustarCredito">Ajustar credito</h4>
                <span>Actualiza recargos, abonos anteriores y fecha inicial.</span>
            </div>
        </div>
        <button type="button" class="detalle-abono-dialog__close" aria-label="Cerrar ajuste de credito">
            <i id="btnXCerrarModalAjustarCredito" class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="divmsjalerta3"></div>
    <form id="formAjustarCredito" class="detalle-abono-dialog__form formulario" >
        
        <input id="idcredito" class="hidden" type="text" name="idcredito_ajustarcredito" value="<?php echo $credito->id;?>">
        <input id="capital" class="hidden" type="text" name="capital" value="<?php echo $credito->capital??'';?>">
        <input id="abonoinicial" class="hidden" type="text" name="abonoinicial" value="<?php echo $credito->abonoinicial??'';?>">
        <input id="saldopendiente" class="hidden" type="text" name="saldopendiente" value="<?php echo $credito->saldopendiente??'';?>">
        <input id="montototal" class="hidden" type="text" name="montototal" value="<?php echo $credito->montototal??'';?>">

        <div class="detalle-abono-dialog__amount-card detalle-ajuste-dialog__amount">
            <span><i class="fa-solid fa-file-invoice-dollar"></i></span>
            <div>
                <label>Credito actual</label>
                <strong>$ <?php echo number_format($credito->saldopendiente??'0', '2', ',', '.');?></strong>
            </div>
        </div>
        
        <div class="recargo"></div>
        <div class="detalle-abono-dialog__grid">
        <div class="detalle-abono-dialog__field">
            <label for="recargo">Recargo interes</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-percent"></i></span>
                <input 
                    id="recargo" 
                    type="text"
                    placeholder="Recargo de interes al credito"
                    value="<?php echo $credito->valorinterestotal??'';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '';"
                >
            </div>
        </div>

        <div class="detalle-abono-dialog__field">
            <label for="abonoTotalAntiguo">Abono total antiguo</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-hand-holding-dollar"></i></span>
                <input 
                    id="abonoTotalAntiguo" 
                    type="text"
                    placeholder="Monto antiguo pagado hasta la fecha"
                    value="<?php echo $credito->abonototalantiguo??'';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '';"
                >
            </div>
        </div>

        <div class="detalle-abono-dialog__field detalle-abono-dialog__field--full">
            <label for="ajustarFechaInicio">Ajustar fecha de inicio</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-calendar-days"></i></span>
                <input 
                    id="ajustarFechaInicio" 
                    type="date"
                    value="<?php echo $credito->fechainicio??'';?>"
                >
            </div>
        </div>

        <div class="detalle-abono-dialog__field detalle-abono-dialog__field--full">
            <label for="inputPasswordAjustarCredito">Clave de autorizacion</label>
            <div class="detalle-abono-dialog__control">
                <span><i class="fa-solid fa-key"></i></span>
                <input id="inputPasswordAjustarCredito" type="password" name="ajustarCreditoClave" class="miles" placeholder="Ingresa la clave para ajustar el credito">
            </div>
            <div id="divmsjalertaClaveAjustarCredito"></div>
        </div>
        </div>

        <div class="detalle-abono-dialog__actions">
            <button class="detalle-abono-dialog__button detalle-abono-dialog__button--secondary" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearAjustarCredito" class="detalle-abono-dialog__button detalle-abono-dialog__button--primary" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal AjustarCredito-->
