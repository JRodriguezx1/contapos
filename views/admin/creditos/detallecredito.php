<div class="p-6 min-h-screen detallecredito">
  <div class="max-w-auto mx-auto bg-white shadow-lg rounded-2xl p-8">
    <!-- Título principal -->
     <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 mb-6">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      💳 Detalles del Crédito
    </h2>

    <!-- Información general del crédito -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
      <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-blue-700 mb-1 uppercase">🧾 Factura</h3>
        <p class="text-gray-800 text-lg">FAP1</p>
      </div>

      <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-green-700 mb-1 uppercase">💰 Total del Credito</h3>
        <p class="text-gray-800 text-lg">$ <?php echo number_format($credito->montototal,'2', ',', '.'); ?></p>
      </div>

      <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-yellow-700 mb-1 uppercase">📅 Fecha Emisión</h3>
        <p class="text-gray-800 text-lg"><?php echo $credito->fechainicio;?></p>
      </div>
    </div>

    <!-- Detalles financieros -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
      <div class="bg-purple-50 border border-purple-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-purple-700 mb-1 uppercase">🔢 Plazo</h3>
        <p class="text-gray-800 text-lg"><?php echo $credito->cantidadcuotas;?>  / Cuotas</p>
      </div>

      <div class="bg-orange-50 border border-orange-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-orange-700 mb-1 uppercase">📆 Fecha Vencimiento</h3>
        <p class="text-gray-800 text-lg"> - </p>
      </div>

      <div class="bg-red-50 border border-red-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-red-700 mb-1 uppercase">💸 Abono Inicial</h3>
        <p class="text-gray-800 text-lg">$ <?php echo $credito->abonoinicial;?></p>
      </div>
    </div>

    <!-- Estado actual -->
    <div class="bg-gray-100 border border-gray-300 rounded-xl p-5 mb-8">
      <h3 class="text-xl font-semibold text-gray-700 mb-3 uppercase">📊 Estado del Crédito</h3>
      <div class="flex items-center gap-4">
        <span class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-700">
          <?php echo $credito->estado==0?'En curso':'Finalizado'; ?>
        </span>
        <span class="text-gray-600">Saldo pendiente: <strong>$<?php echo number_format($credito->saldopendiente,'2', ',', '.'); ?></strong></span>
      </div>
    </div>

    <!-- Historial de abonos -->
    <div class="mb-10">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">📚 Historial de Abonos</h3>
      <table id="tablacuotas" class="w-full border border-gray-200 rounded-xl overflow-hidden">
        <thead class="bg-gray-100">
          <tr>
            <th class="text-left px-4 py-2 text-base font-semibold text-gray-700">Fecha</th>
            <th class="text-left px-4 py-2 text-base font-semibold text-gray-700">Monto</th>
            <th class="text-left px-4 py-2 text-base font-semibold text-gray-700">Método</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($cuotas as $value): ?>
            <tr class="border-t">
              <td class="px-4 py-2 text-gray-800"><?php echo $value->fechapago;?></td>
              <td class="px-4 py-2 text-gray-800">$<?php echo $value->montocuota;?></td>
              <td class="px-4 py-2 text-gray-800"><?php echo $value->mediopago;?></td>
            </tr>
          <?php endforeach; ?>
          
        </tbody>
      </table>
    </div>

    <!-- Botones de acción -->
    <div class="flex justify-end gap-4">
      <button id="abonar" class="btn-md btn-blueintense mb-4 !py-4 px-6 !bg-indigo-600">
        ➕ Abonar
      </button>
      <button id="pagarTodo" class="hover:bg-green-700 btn-turquoise text-white font-semibold  rounded-lg shadow flex items-center gap-2 mb-4 py-4 px-6">
        ✅ Pagar Todo
      </button>
      <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold  rounded-lg shadow flex items-center gap-2 mb-4 py-4 px-6">
        ⬅️ Volver
      </button>
    </div>
  </div>


  <!-- MODAL PARA ABONAR-->
  <dialog id="miDialogoCredito" class="midialog-sm p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalCredito" class="font-semibold text-gray-700 mb-4">Crear credito</h4>
        <button id="btnXCerrarModalCredito" class="p-2 rounded-lg hover:bg-gray-100 transition">
            <i class="fa-solid fa-xmark text-gray-600 text-3xl"></i>
        </button>
    </div>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateCredito" class="formulario" action="/admin/creditos/crearCredito" enctype="multipart/form-data" method="POST">
        
        <div class="formulario__campo">
            <label class="formulario__label" for="cliente">Cliente</label>
            <select id="cliente" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1"  multiple="multiple" name="cliente_id" required>
                <?php foreach($clientes as $cliente):  
                    if($cliente->id>1):   ?>
                        <option value="<?php echo $cliente->id;?>" ><?php echo $cliente->nombre.' '.$cliente->apellido;?></option>
                <?php endif; endforeach; ?>
            </select>             
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="capital">Capital</label>
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input 
                    id="capital" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                    type="text" 
                    placeholder="Valor total de la deuda" 
                    name="capital" 
                    value="<?php echo $producto->capital??'';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';"
                    required
                >
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="interes">Aplicar interes</label>
            <select id="interes" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="interes">
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="1">Si</option>
                <option value="0">No</option>
            </select>          
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="tipoproducto">Cantidad de cuotas</label>
            <input 
                id="cantidadcuotas" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                type="text" 
                placeholder="Cantidad de cuotas" 
                name="cantidadcuotas" 
                value="<?php echo $producto->cantidadcuotas??'1';?>"
                oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, ''); if(this.value === '' || this.value === '0'){this.value = 1;}"
                required
            >    
        </div>
        <!-- El monto de la cuota se calcula atomaticamente segun la cantidad de cuotas-->
        <div class="formulario__campo">
            <label class="formulario__label" for="tipoproducto">Valor de la cuota</label>
            <input id="montocuota" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Cantidad de cuotas" name="montocuota" value="<?php echo $producto->montocuota??'';?>" readonly required>    
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="frecuenciapago">Frecuencia de pago</label>
            <select id="frecuenciapago" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" multiple="multiple" name="frecuenciapago">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">26</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
            </select>          
        </div>

        <p class="text-xl leading-7 text-gray-600 mb-0 mt-4 pt-4">Tasa: %<input id="interesxcuota" type="text" name="interesxcuota" readonly value="2"></p>
        <input id="interestotal" class="hidden" type="text" name="interestotal">
        <input id="valorinteresxcuota" class="hidden" type="text" name="valorinteresxcuota">
        <p class="text-xl leading-7 text-gray-600 mb-0 mt-2">Interes: $<input id="valorinterestotal" type="text" name="valorinterestotal" readonly></p>
        <p class="text-xl leading-7 text-gray-600 mb-4 mt-2">Total: $<input id="montototal" type="text" name="montototal" readonly></p>

        <div class="text-right border-t border-gray-200 pt-12 mt-8">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearCredito" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin modal Abonoar-->

</div>
