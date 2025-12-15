<div class="box creditos">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de creditos</h4>
  <div class="flex flex-wrap gap-4 mb-6">
    <button id="btnCrearCredito" class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">add_2</span>Nuevo Credito</button>
    <!--<button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" id="btnGastosingresos"><span class="material-symbols-outlined">paid</span>Gastos</br>Ingresos</button>
    <button class="btn-command"><span class="material-symbols-outlined">lock_open</span>Abrir Cajon</button>
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/caja/pedidosguardados"><span class="material-symbols-outlined">folder_check_2</span>Cotizaciones</a>
    -->
  </div>
  <div id="divmsjalerta"></div>
  <table class="display responsive nowrap tabla" width="100%" id="tablaCreditos">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Cliente</th>
                    <th>Total del credito</th>
                    <th>Deuda</th>
                    <th>Cuota</th>
                    <th>Abono total</th>
                    <th>Estado</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($creditos as $value): ?>
                    <tr> 
                        <td class=""><?php echo $value->ID; ?></td> 
                        <td class=""><?php echo $value->nombre.' '.$value->apellido; ?></td>         
                        <td class="">$<?php echo number_format($value->montototal,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->saldopendiente,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->montocuota,'2', ',', '.'); ?></td> 
                        <td class="">$<?php echo number_format($value->montototal-$value->saldopendiente,'2', ',', '.'); ?></td>
                        <td class=""><?php echo $value->estado==0?'Abierto':'Cerrado'; ?></td>     
                        <td class="accionestd">
                            <div class="acciones-btns" id="<?php echo $value->ID;?>">
                                <button class="btn-md btn-turquoise editarCredito" title="Actualizar datos del cliente"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a class="btn-md btn-bluedark" href="/admin/creditos/detallecredito?id=<?php echo $value->ID;?>" title="Ver estadisticas del cliente"><i class="fa-solid fa-chart-simple"></i></a>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

  <!-- MODAL PARA CREAR CREDITOS-->
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
            <label class="formulario__label" for="montocuota">Valor de la cuota</label>
            <input id="montocuota" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Valor de la cuota" name="montocuota" value="<?php echo $producto->montocuota??'';?>" readonly required>    
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="frecuenciapago">Dia de pago</label>
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
  </dialog><!--fin crear/editar Credito-->

</div>