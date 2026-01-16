<!--///////////////////// Modal procesar el pago boton facturar /////////////////////////-->
  <dialog id="miDialogoFacturar" class="midialog-md !p-12">
      <h4 class="text-3xl font-semibold m-0 text-neutral-800">Registro de pago</h4>
      <hr class="my-4 border-t border-neutral-300">
      <form id="formfacturar" class="formulario" method="POST">
          <div id="divmsjalertaprocesarpago"></div>
          <p class="text-gray-600 text-3xl text-center font-light m-0">Total a pagar $: </br><span id="totalPagar" class="text-gray-700 font-semibold">$0</span></p>
          <div class="flex justify-center gap-12 mt-8">
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="caja">Caja</label>
              <select id="caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5     h-14 text-xl focus:outline-none focus:ring-1" name="caja" required>
                  <?php foreach($cajas as $index => $value):?>
                    <option value="<?php echo $value->id;?>" data-idfacturador="<?php echo $value->idtipoconsecutivo;?>"><?php echo $value->nombre;?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="facturador">Facturador</label>
              <select id="facturador" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5     h-14 text-xl focus:outline-none focus:ring-1" name="facturador" required>
                <?php foreach($consecutivos as $index => $value):?>
                  <option data-idtipofacturador="<?php echo $value->idtipofacturador;?>" value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div id="inputscreditos" class="grid grid-cols-1 md:grid-cols-2 gap-8 gap-y-0 mt-6">
            <!-- Abono inicial -->
            <div class="formulario__campo">
              <label class="formulario__label" for="abonoinicial">Abono inicial</label>
              <input id="abonoinicial" name="abonoinicial" type="text" placeholder="0" value="0"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5    h-14 text-xl focus:outline-none focus:ring-1"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';">
            </div>

            <!-- Aplicar interes -->
            <div class="formulario__campo">
              <label class="formulario__label" for="saldoPendiente">Aplicar interes</label>
              <select id="interes" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="interes">
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="1">Si</option>
                <option value="0">No</option>
              </select>
            </div>

            <!-- Plazo (cuotas) -->
            <div class="formulario__campo">
              <label class="formulario__label" for="cantidadcuotas">Plazo (cuotas)</label>
              <input id="cantidadcuotas" name="cantidadcuotas" type="text" min="1" placeholder="Ingrese cantidad de días del palzo" value="1"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5    h-14 text-xl focus:outline-none focus:ring-1"
                oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, ''); if(this.value === '' || this.value === '0'){this.value = 1;}"
              >
            </div>

            <!-- Valor de la cuota -->
            <div class="formulario__campo">
              <label class="formulario__label" for="montocuota">Valor de la cuota</label>
              <input id="montocuota" name="montocuota" type="text" readonly
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5    h-14 text-xl focus:outline-none focus:ring-1">
            </div>
          </div>
       
          <p id="abonoTotal" class="text-gray-600 text-2xl text-center font-light m-0 hidden">Abono Inicial $: <span id="valorAbono" class="text-gray-700 font-semibold"> 0 </span></p>

          <div class="accordion md:px-12 !mt-4">
            <input type="checkbox" id="first">
            <label class="etiqueta text-indigo-700" for="first">Elegir método de pago</label>
            <div class="wrapper">
              <div class="wrapper-content">
                <div id="mediospagos" class="content flex flex-col items-center w-1/2 mx-auto text-center">
                  <?php foreach($mediospago as $index => $value):?>
                    <div class="mb-4 text-center">
                      <label class="text-gray-700 text-xl text-center leading-relaxed"><?php echo $value->mediopago??'';?>: </label>
                      <input id="<?php echo $value->id??'';?>" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5     h-14 text-xl focus:outline-none focus:ring-1 text-center mediopago <?php echo $value->mediopago??'';?>" type="text" value="0" <?php echo $value->mediopago=='Efectivo'?'readonly':'';?> oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div> <!-- fin accordion  -->

          <div class="mx-auto">
            <div class="formulario__campo w-80 mx-auto">
                <label class="formulario__label leading-relaxed text-center" for="recibio">Efectivo Recibido</label>
                <input id="recibio" class="formulario__input !text-2xl !border-0 !border-b-2 !border-indigo-500 !rounded-none text-center" name="" type="text" placeholder="0" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
            </div>
            <div class="flex flex-col items-center">
                <p id="cambio" class="text-center formulario__label">Devolver: <span class="text-gray-700 font-semibold text-2xl">$0</span></p>
            </div>
          </div>
          
         <!-- Opción imprimir factura -->
        <div class="formulario__campo md:px-12 mb-6">
          <label id="textPrint" class="formulario__label block text-center mb-2">¿Desea imprimir factura?</label>
          <div class="flex justify-center gap-8">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="1" class="w-5 h-5" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?> >
              <span class="text-gray-700 text-lg">Sí</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="0" class="w-5 h-5" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 0?'checked':'';?> >
              <span class="text-gray-700 text-lg">No</span>
            </label>
          </div>
        </div>
        <!-- Fin opción imprimir factura -->


          <div class="formulario__campo md:px-12">
              <textarea id="observacion" class="formulario__textarea" name="observacion" placeholder="Observacion" rows="4"></textarea>
          </div>

          <div class="self-end">
              <button class="btn-md btn-turquoise !py-4 !px-6 !w-[140px]" type="button" value="Cancelar">Cancelar</button>
              <input id="btnPagar" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[140px]" type="submit" value="Pagar">
          </div>
          
      </form>
  </dialog>