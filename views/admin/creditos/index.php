<div class="box creditos">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de creditos</h4>
  <div class="flex flex-wrap gap-4 mb-6">
    <button id="btnCrearCredito" class="btn-command"><span class="material-symbols-outlined">add_2</span>Nuevo Credito</button>
    <button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" id="btnGastosingresos"><span class="material-symbols-outlined">paid</span>Gastos</br>Ingresos</button>
    <button class="btn-command"><span class="material-symbols-outlined">lock_open</span>Abrir Cajon</button>
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/caja/pedidosguardados"><span class="material-symbols-outlined">folder_check_2</span>Cotizaciones</a>
  </div>

  <!-- MODAL PARA CREAR CREDITOS-->
  <dialog id="miDialogoCredito" class="midialog-sm p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalCredito" class="font-semibold text-gray-700 mb-4">Crear credito</h4>
        <button id="btnXCerrarModalCredito" class="p-2 rounded-lg hover:bg-gray-100 transition">
            <i class="fa-solid fa-xmark text-gray-600 text-3xl"></i>
        </button>
    </div>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateCredito" class="formulario" action="/admin/almacen/crearCredito" enctype="multipart/form-data" method="POST">
        
        <div class="formulario__campo">
            <label class="formulario__label" for="cliente">Cliente</label>
            <select id="cliente" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="idcliente" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($clientes as $cliente): 
                    if($cliente->visible == 1):    ?>
                        <option value="<?php echo $cliente->id;?>" ><?php echo $cliente->nombre;?></option>
                <?php endif; endforeach; ?>
            </select>             
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="montototal">Monto total</label>
            <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                <input id="montototal" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Valor total de la deuda" name="montototal" value="<?php echo $producto->montototal??'';?>" required>
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="interes">Aplicar interes</label>
            <select id="interes" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="interes">
                <option disabled selected>-Seleccionar-</option>
                <option value="1">Si</option>
                <option value="0">No</option>
            </select>          
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="tipoproducto">Cantidad de cuotas</label>
            <input id="cantidadcuotas" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Cantidad de cuotas" name="cantidadcuotas" value="<?php echo $producto->cantidadcuotas??'';?>" required>    
        </div>
        <!-- El monto de la cuota se calcula atomaticamente segun la cantidad de cuotas-->
        <div class="formulario__campo">
            <label class="formulario__label" for="tipoproducto">Valor de la cuota</label>
            <input id="montocuota" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Cantidad de cuotas" name="montocuota" value="<?php echo $producto->montocuota??'';?>" readonly required>    
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="frecuenciapago">Frecuencia de pago</label>
            <select id="frecuenciapago" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="frecuenciapago">
                <option disabled selected>-Seleccionar-</option>
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
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
            <input id="btnEditarCrearCredito" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
        </div>
    </form>
  </dialog><!--fin crear/editar Credito-->

</div>