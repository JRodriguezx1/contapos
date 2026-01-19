<!-- MODAL PARA AJUSTAR CREDITO-->
  <dialog id="miDialogoAjustarCredito" class="midialog-sm p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalAjustarCredito" class="font-semibold text-gray-700 mb-4">Ajustar Credito</h4>
        <button class="rounded-lg hover:bg-gray-100 transition">
            <i id="btnXCerrarModalAjustarCredito" class="p-2 fa-solid fa-xmark text-gray-600 text-3xl"></i>
        </button>
    </div>
    <div id="divmsjalerta3"></div>
    <form id="formCrearUpdateAjustarCredito" class="formulario" >
        
        <input id="idcredito" class="hidden" type="text" name="idcredito_ajustarcredito" value="<?php echo $credito->id;?>">
        <input id="saldopendiente" class="hidden" type="text" name="saldopendiente" value="<?php echo $credito->saldopendiente??'';?>">

        <p class="text-gray-600 text-3xl text-center font-light mb-10">Credito $: <span class="text-gray-700 font-semibold"><?php echo number_format($credito->saldopendiente??'0', '2', ',', '.');?></span></p>
        
         <div class="formulario__campo">
            <label class="formulario__label" for="abonoTotalAntiguo">Abono total antiguo</label>
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input 
                    id="abonoTotalAntiguo" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                    type="text"
                    placeholder="Monto antiguo pagado hasta la fecha"
                    name="valorpagado"
                    value="<?php echo $cuota->valorpagado??'';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';"
                    required
                >
            </div>
        </div>

        <label for="inputDescuentoAjustarCredito" class="block text-2xl font-medium text-gray-600">Ingresar Clave</label>
        <div class="mt-2">
            <input id="inputDescuentoAjustarCredito" type="password" name="descuentoclave" class="miles bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1">
            <div id="divmsjalertaClaveAjustarCredito"></div>
        </div>

        <div class="text-right border-t border-gray-200 pt-12 mt-8">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearAjustarCredito" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Confirmar">
        </div>
    </form>
  </dialog><!--fin modal AjustarCredito-->