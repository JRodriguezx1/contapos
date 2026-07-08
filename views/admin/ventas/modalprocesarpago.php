<!--///////////////////// Modal procesar el pago boton facturar /////////////////////////-->
  <dialog id="miDialogoFacturar" class="midialog-md !p-12">
      <h4 class="text-3xl font-semibold m-0 text-neutral-800">
          Procesar venta
      </h4>
      <hr class="my-4 border-t border-neutral-300">
      <form id="formfacturar" class="formulario" method="POST">
          <div id="divmsjalertaprocesarpago"></div>
          <div class="mt-2 mb-8 rounded-2xl border border-emerald-100 bg-emerald-50 p-8 text-center">
              <p class="uppercase tracking-widest text-sm font-semibold text-emerald-700">
                  TOTAL DE LA VENTA
              </p>

              <p id="totalPagar"
                class="mt-3 text-6xl font-bold text-emerald-600"
                style="font-family:'Tektur', serif;">
                  $0
              </p>
          </div>

          <div class="rounded-2xl bg-slate-50 border border-slate-200 p-6 mt-2">
              <div class="flex items-center gap-3 mb-6">
                  <span class="material-symbols-outlined text-indigo-600">
                      shopping_cart
                  </span>

                  <p class="text-xl font-semibold text-slate-700">
                      Información de la venta
                  </p>
              </div>

              <div class="flex justify-start gap-12">
                <div class="formulario__campo w-96">
                  <label class="formulario__label" for="caja">Caja</label>
                  <select id="caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2 text-lg focus:outline-none focus:ring-1" name="caja" required>
                      <?php foreach($cajas as $index => $value):?>
                        <option value="<?php echo $value->id;?>" data-idfacturador="<?php echo $value->idtipoconsecutivo;?>" data-idemisor="<?php echo $value->idemisor;?>"><?php echo $value->nombre;?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
                <div class="formulario__campo w-96">
                  <label class="formulario__label" for="facturador">Facturador</label>
                  <select id="facturador" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2 text-lg focus:outline-none focus:ring-1 w-full" name="facturador" required>
                    <?php foreach($consecutivos as $index => $value):?>
                      <option data-idtipofacturador="<?php echo $value->idtipofacturador;?>" value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <?php if($conflocal['habilitar_canal_de_venta']->valor_final): ?>
              <div id="contenedorCanalVenta" class=" grid grid-cols-1 xsp:grid-cols-2 gap-12 gap-y-0">
                <div class=" max-w-96 mx-auto xsp:mx-0">
                  <label class="formulario__label" for="canalventa">Canal de venta</label>
                  <select id="canalVenta" class="bg-gray-50 border border-gray-300 w-full mt-2 text-gray-900 rounded-lg block p-2 text-lg focus:outline-none focus:ring-1" name="canalventa" required>
                    <?php foreach($canalesVenta as $index => $value):?>
                      <option data-idCanalVenta="<?php echo $value->id;?>" value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <?php endif; ?>
          
              <div id="inputscreditos" class="grid grid-cols-1 md:grid-cols-2 gap-12 gap-y-0 mt-6">
                <!-- Abono inicial -->
                <div id="campoabonoinicial" class="formulario__campo">
                  <label class="formulario__label" for="abonoinicial">Abono inicial</label>
                  <input id="abonoinicial" name="abonoinicial" type="text" placeholder="0" value="0"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2 text-xl focus:outline-none focus:ring-1"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '';"
                  >
                </div>

                <!-- Aplicar interes -->
                <div class="formulario__campo">
                  <label class="formulario__label" for="saldoPendiente">Aplicar interes</label>
                  <select id="interes" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2 text-xl focus:outline-none focus:ring-1" name="interes">
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                  </select>
                </div>

                <!-- Plazo (cuotas) -->
                <div id="campocantidadcuotas" class="formulario__campo">
                  <label class="formulario__label" for="cantidadcuotas">Plazo (cuotas)</label>
                  <input id="cantidadcuotas" name="cantidadcuotas" type="text" min="1" placeholder="Ingrese cantidad de días del palzo" value="1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2 text-xl focus:outline-none focus:ring-1"
                    oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, ''); if(this.value === '' || this.value === '0'){this.value = '';}"
                  >
                </div>

                <!-- Valor de la cuota -->
                <div id="campomontocuota" class="formulario__campo">
                  <label class="formulario__label" for="montocuota">Valor de la cuota</label>
                  <input id="montocuota" name="montocuota" type="text" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2 text-xl focus:outline-none focus:ring-1">
                </div>
            </div>
          </div>

          <p id="abonoTotal" class="text-gray-600 text-2xl text-center font-light m-0 hidden">Abono Inicial $: <span id="valorAbono" class="text-gray-700 font-semibold"> 0 </span></p>

          <div class="accordion mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6">
            <input type="checkbox" id="first">
            <label
                class="etiqueta flex items-center justify-between cursor-pointer !pb-0"
                for="first">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-indigo-600">
                            payments
                        </span>

                        <h5 class="text-3xl font-semibold text-slate-800">
                            Métodos de pago
                        </h5>
                    </div>

                    <p class="mt-2 ml-12 text-slate-500 text-lg text-left">
                        Se abrirá para registrar uno o varios medios de pago.
                    </p>
                </div>
            </label>
            <div class="wrapper">
              <div class="wrapper-content">
                <div id="mediospagos" class="content grid grid-cols-2 gap-x-8 gap-y-6 max-w-2xl mx-auto">
                  <?php foreach($mediospago as $index => $value):?>
                    <div class="flex flex-col">
                        <label
                            class="text-center text-lg font-medium text-slate-700 mb-2">

                            <?php echo $value->mediopago ?? ''; ?>

                        </label>

                        <input
                            id="<?php echo $value->id ?? ''; ?>"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-64 mx-auto p-2.5 h-14 text-xl text-center focus:outline-none focus:ring-1 mediopago <?php echo $value->mediopago ?? ''; ?>"
                            type="text"
                            value="0"
                            <?php echo $value->mediopago == 'Efectivo' ? 'readonly' : ''; ?>
                            oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div> <!-- fin accordion  -->

          <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6">
            <div class="grid grid-cols-2 gap-8 items-center">
                <!-- EFECTIVO -->
                <div class="flex flex-col items-center">
                    <label
                        class="block text-lg font-semibold text-slate-700 mb-3 text-center"
                        for="recibio">

                        💵 Efectivo recibido

                    </label>

                    <input
                        id="recibio"
                        class="formulario__input
                              !w-72
                              !text-3xl
                              !border-0
                              !border-b-2
                              !border-indigo-500
                              !rounded-none
                              bg-transparent
                              text-center"
                        type="text"
                        placeholder="0"
                        oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                </div>

                <!-- CAMBIO -->
                <div class="flex flex-col items-center">
                    <p class="text-lg text-slate-500 mb-3">
                        Cambio a entregar
                    </p>

                    <p
                        id="cambio"
                        class="text-5xl font-bold text-emerald-600">
                        $0
                    </p>
                </div>
            </div>
          </div>
          
        <!-- Opción imprimir factura -->
        <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6">
          <div class="flex items-center justify-center gap-3 mb-5">
              <span class="material-symbols-outlined text-indigo-600">
                  print
              </span>

              <p
                  id="textPrint"
                  class="text-xl font-semibold text-slate-700">
                  ¿Desea imprimir factura?
              </p>
          </div>
          <div class="flex justify-center gap-12">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="1" class="w-5 h-5" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?> >
              <span class="text-slate-700 font-medium text-lg">Sí</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="0" class="w-5 h-5" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 0?'checked':'';?> >
              <span class="text-slate-700 font-medium text-lg">No</span>
            </label>
          </div>
        </div>
        <!-- Fin opción imprimir factura -->

        <div id="confirmarDespacho" class="hidden">
          <label for="despachar" class="flex flex-col items-center cursor-pointer mb-6">
            <span class="formulario__label block text-center mb-2">Despachar orden</span>
            <input
                id="despachar" 
                name="despachar"
                value="1" 
                type="checkbox" 
                class="sr-only peer"
                <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?>
                >
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
            </div>
          </label>
        </div>


          <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6">
              <label
                  for="observacion"
                  class="block text-xl font-semibold text-slate-700 mb-4">

                  📝 Observación
              </label>

              <textarea
                  id="observacion"
                  name="observacion"
                  rows="4"
                  placeholder="Escriba una observación (opcional)..."
                  class="w-full rounded-xl border border-slate-300 p-4 text-lg resize-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
              </textarea>
          </div>

          <div class="mt-10 flex justify-end gap-5">
              <button class="btn-md btn-turquoise transition-all duration-200 hover:scale-105 !py-4 !px-6 !w-[160px]" type="button" value="Cancelar">Cancelar</button>
              <input id="btnPagar" class="btn-md btn-indigo transition-all duration-200 hover:scale-105 !py-4 px-6 !w-[160px]" type="submit" value="Pagar">
          </div>
          
      </form>
  </dialog>