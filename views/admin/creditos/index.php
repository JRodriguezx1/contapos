<div class="box creditos">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de creditos</h4>
  <div class="flex flex-wrap gap-4 mb-6">
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/creditos/separado"><span class="material-symbols-outlined">add_2</span>Crear Separado</a>
    <!--<button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" id="btnGastosingresos"><span class="material-symbols-outlined">paid</span>Gastos</br>Ingresos</button>
    <button class="btn-command"><span class="material-symbols-outlined">lock_open</span>Abrir Cajon</button>
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/caja/pedidosguardados"><span class="material-symbols-outlined">folder_check_2</span>Cotizaciones</a>
    -->
  </div>
  <div id="divmsjalerta"></div>
  <table class="display responsive nowrap tabla" width="100%" id="tablaCreditos">
            <thead>
                <tr class="text-xl">
                    <th>id</th>
                    <th>Tipo</th>
                    <th>Cliente</th>
                    <th>Credito</th>
                    <th>Abono Inicial</th>
                    <th>Credito Financiado</th>
                    <th>Interes</th>
                    <th>Total Credito</th>
                    <th>Cuota</th>
                    <th>Abono total</th>
                    <th>Estado</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($creditos as $value): ?>
                    <tr class="text-xl"> 
                        <td class=""><?php echo $value->ID; ?></td>
                        <td class=""><?php echo $value->idtipofinanciacion==1?'Credito':'Separado'; ?></td>
                        <td class=""><?php echo $value->nombre.' '.$value->apellido; ?></td>         
                        <td class="">$<?php echo number_format($value->capital,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->abonoinicial,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->capital-$value->abonoinicial,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->valorinterestotal,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->montototal,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->montocuota,'2', ',', '.'); ?></td>
                        <td class="">$<?php echo number_format($value->montototal-$value->saldopendiente,'2', ',', '.'); ?></td>
                        <td class=""><?php echo $value->estado==0?'Abierto':'Cerrado'; ?></td>     
                        <td class="accionestd">
                            <div class="acciones-btns" id="<?php echo $value->ID;?>">
                                <button class="btn-xs btn-turquoise editarCredito" title="Actualizar datos del cliente"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a class="btn-xs btn-bluedark" href="/admin/creditos/detallecredito?id=<?php echo $value->ID;?>" title="Ver estadisticas del cliente"><i class="fa-solid fa-chart-simple"></i></a>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

  <!-- MODAL PARA CREAR SEPARADO-->
  <dialog id="miDialogoCredito" class="midialog-lg p-10">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalCredito" class="font-semibold text-gray-700 mb-4">Crear separado</h4>
        <button id="btnXCerrarModalCredito" class="p-2 rounded-lg hover:bg-gray-100 transition">
            <i class="fa-solid fa-xmark text-gray-600 text-3xl"></i>
        </button>
    </div>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateCredito" class="formulario" action="" method="POST">
        
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
            <label class="formulario__label" for="abonoinicial">Abono inicial</label>
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input 
                    id="abonoinicial" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                    type="text" 
                    placeholder="Abono inicial al capital" 
                    name="abonoinicial" 
                    value="<?php echo $credito->abonoinicial??'0';?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\.)/, ''); if(this.value === '')this.value = '0';"
                    required
                >
            </div>
        </div>
        
        <div class="formulario__campo">
            <label class="formulario__label" for="cantidadcuotas">Cantidad de cuotas</label>
            <input 
                id="cantidadcuotas" 
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                type="text" 
                placeholder="Cantidad de cuotas" 
                name="cantidadcuotas" 
                value="<?php echo $credito->cantidadcuotas??'1';?>"
                oninput="this.value = this.value.replace(/[,.]/g, '').replace(/\D/g, ''); if(this.value === '' || this.value === '0'){this.value = 1;}"
                required
            >    
        </div>
        <!-- El monto de la cuota se calcula atomaticamente segun la cantidad de cuotas-->
        <div class="formulario__campo">
            <label class="formulario__label" for="montocuota">Valor de la cuota</label>
            <input id="montocuota" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Valor de la cuota" name="montocuota" value="<?php echo $credito->montocuota??'';?>" readonly required>    
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

        <!-- SELECCIONAR PRODUCTOS -->
        <div class="">
            <div class="mb-4 md:w-1/2">
                <label for="articulo" class="block text-2xl font-medium text-gray-600">Articulo</label>
                <div class="mt-2 grid grid-cols-1">
                    <select id="articulo" name="articulo" autocomplete="articulo-name" class="bg-gray-50 border !border-gray-300 text-gray-900 rounded-lg focus:!border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" multiple="multiple" required>
                        <?php foreach($totalitems as $value): ?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="border-solid border-t-2 border-blue-600 pt-4 mb-4 overflow-x-auto">
                <table class=" tabla" width="100%" id="tablaSeparado">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th class="accionesth text-red-500"><i class="fa-solid fa-x"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div> <!-- FIn Apilamiento de productos -->
        </div>

        <div class="flex justify-start gap-4 mt-6">
            <div class="text-end">
                <p class="m-0 mb-2 text-slate-500 text-2xl font-normal">Sub Total:</p>
                <p class="m-0 mb-2 text-slate-500 text-2xl font-normal">Impuesto:</p>
                <p class="m-0 mb-2 text-slate-500 text-2xl font-normal">Descuento:</p>
                <p class="m-0 mb-2 text-slate-600 text-3xl font-semibold">Total:</p>
            </div>
            <div>
                <p id="subTotal" class="m-0 mb-2 text-slate-600 text-2xl font-semibold">$ 0</p>
                <p id="impuesto" class="m-0 mb-2 text-slate-600 text-2xl font-semibold">% 0</p>
                <p id="descuento" class="m-0 mb-2 text-slate-600 text-2xl font-semibold">$ 0</p>
                <p id="total" class="m-0 mb-2 text-green-500 text-3xl font-semibold" style="font-family: 'Tektur', serif;">$ 0</p>
            </div>
        </div>

        <div class="text-right border-t border-gray-200 pt-12 mt-4">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearCredito" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Credito-->

</div>