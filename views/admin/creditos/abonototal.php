<!-- MODAL PARA ABONAR-->
  <dialog id="miDialogoPagoTotal" class="midialog-sm p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalPagoTotal" class="font-semibold text-gray-700 mb-4">Pago total</h4>
        <button class="rounded-lg hover:bg-gray-100 transition">
            <i id="btnXCerrarModalPagoTotal" class="p-2 fa-solid fa-xmark text-gray-600 text-3xl"></i>
        </button>
    </div>
    <div id="divmsjalerta3"></div>
    <form id="formCrearUpdatePagoTotal" class="formulario" action="/admin/creditos/pagoTotal" method="POST">
        <!-- El monto de la cuota se calcula atomaticamente segun la cantidad de cuotas-->
        <input class="hidden" type="text" name="id_credito" value="<?php echo $credito->id;?>">
        <p class="text-gray-600 text-3xl text-center font-light m-0">Total a pagar $: <span class="text-gray-700 font-semibold"><?php echo number_format($credito->saldopendiente??'0', '2', ',', '.');?></span></p>
        
        <input id="PagoTotal_montocuota" class="hidden" type="text" name="montocuota" value="$<?php echo number_format($credito->montocuota??'0', '2', ',', '.');?>" readonly required>    
       <input id="PagoTotal_abono" class="hidden" type="text" name="valorpagado" value="<?php echo $credito->saldopendiente??'';?>">

        <div class="formulario__campo">
            <label class="formulario__label" for="caja">Caja</label>
            <select id="PagoTotal_caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="cajaid" required>
                <?php foreach($cajas as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="mediopago">Medio de pago</label>
            <select id="PagoTotal_mediopago" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="mediopagoid" required>
                <?php foreach($mediospago as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->mediopago;?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-right border-t border-gray-200 pt-12 mt-8">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearPagoTotal" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal PagoTotal-->