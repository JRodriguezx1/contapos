<!-- MODAL PARA ABONAR-->
  <dialog id="miDialogoAbono" class="midialog-sm p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalAbono" class="font-semibold text-gray-700 mb-4">Registrar abono</h4>
        <button class="rounded-lg hover:bg-gray-100 transition">
            <i id="btnXCerrarModalAbono" class="p-2 fa-solid fa-xmark text-gray-600 text-3xl"></i>
        </button>
    </div>
    <div id="divmsjalerta2"></div>
    <form id="formCrearUpdateAbono" class="formulario" action="/admin/creditos/registrarAbono" enctype="multipart/form-data" method="POST">
        <!-- El monto de la cuota se calcula atomaticamente segun la cantidad de cuotas-->
        <input class="hidden" type="text" name="id_credito" value="<?php echo $credito->id;?>">
        <div class="formulario__campo">
            <label class="formulario__label" for="montocuota">Valor de la cuota</label>
            <input id="montocuota" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg font-semibold focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Valor de la cuota" name="montocuota" value="$<?php echo number_format($credito->montocuota??'0', '2', ',', '.');?>" readonly required>    
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="caja">Caja</label>
            <select id="caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="cajaid" required>
                <?php foreach($cajas as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="mediopago">Medio de pago</label>
            <select id="mediopago" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="mediopagoid" required>
                <?php foreach($mediospago as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->mediopago;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="abono">Abono</label>
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input 
                    id="abono" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                    type="text"
                    placeholder="Abono de la deuda"
                    name="valorpagado"
                    value="<?php echo $cuota->valorpagado??'';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';"
                    required
                >
            </div>
        </div>

        <div class="text-right border-t border-gray-200 pt-12 mt-8">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearAbono" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal Abonoar-->