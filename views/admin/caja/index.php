<div class="box caja !pb-20">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de Caja</h4>
  <div class="flex flex-wrap gap-4 mb-6">
    <a class="btn-command" href="/admin/caja/cerrarcaja"><span class="material-symbols-outlined">hard_drive</span>Cerrar Caja</a>
    <button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" id="btnGastosingresos"><span class="material-symbols-outlined">paid</span>Gastos</br>Ingresos</button>
    <a class="btn-command" href="/admin/caja/zetadiario"><span class="material-symbols-outlined">document_search</span>Zeta Diario</a>
    <a class="btn-command text-center" href="/admin/caja/ultimoscierres"><span class="material-symbols-outlined">list_alt</span>Ultimos Cierres</a>
    <button class="btn-command"><span class="material-symbols-outlined">lock_open</span>Abrir Cajon</button>
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/caja/pedidosguardados"><span class="material-symbols-outlined">folder_check_2</span>Cotizaciones</a>
  </div>
  <h5 class="text-gray-600 mb-3">Lista de Facturas - <?php echo $sucursal; ?></h5>
  <table class="display responsive nowrap tabla" width="100%" id="tablaListaPedidos">
      <thead>
          <tr>
              <th>N.</th>
              <th>Fecha</th>
              <th>Caja</th>
              <th>Orden</th>
              <th>Factura</th>
              <th>Medio Pago</th>
              <th>Estado</th>
              <th>Valor Bruto</th>
              <th>Total</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($facturas as $index => $value): ?>
            <tr> 
              <td class=""><?php echo $index+1;?></td>
              <td class=""><?php echo $value->fechapago;?></td> 
              <td class=""><?php echo $value->caja;?></td>
              <td class=""><?php echo $value->id;?></td>
              <td class=""><?php echo $value->id;?></td>
              <td>
                <div data-estado="<?php echo $value->estado;?>" data-totalpagado="<?php echo $value->total;?>" id="<?php echo $value->id;?>" class="mediosdepago max-w-full flex flex-wrap gap-2">
                    <?php foreach($value->mediosdepago as $idx => $element): ?>
                    <button class="btn-xs btn-light"><?php echo $element->mediopago;?></button>
                    <?php endforeach; ?>
                </div>
              </td>
              <td class=""><div class="<?php echo $value->estado=='Paga'?'btn-xs btn-lima':($value->estado=='Guardado'?'btn-xs btn-turquoise':'btn-xs btn-light');?>"><?php echo $value->estado;?></div></td>
              <td class=""><strong>$ </strong><?php echo number_format($value->subtotal??0, "0", ",", ".");?></td>
              <td class=""><strong>$ </strong><?php echo number_format($value->total??0, "0", ",", ".");?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                    <a class="btn-xs btn-turquoise" title="Ver detalles del pedido" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">
                        Ver
                    </a>
                    <button class="btn-xs btn-light printPOS" title="Imprimir en PDF POS"><i class="fa-solid fa-print"></i>
                    </button>
                    <button class="btn-xs btn-light printPDF" title="Imprimir en PDF carta">
                        <i class="fa-solid fa-file-pdf text-red-600"></i>
                    </button>
                  </div>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr class="font-semibold text-gray-900 dark:text-white">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th class="px-6 py-3">Total Dia:</th>
            <td class="px-6 py-3">$<?php echo number_format($datacierrescajas??0, "0", ",", ".");?></td>
        </tr>
      </tfoot>
  </table>

  <dialog id="gastosIngresos" class="midialog-sm p-12">
    <h4 class="font-semibold text-gray-700 mb-4">Gastos e ingresos</h4>
    <div id="divmsjalerta1"></div>
    <form id="formGastosingresos" class="formulario" action="/admin/caja/ingresoGastoCaja" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="operacion">Operacion</label>
            <select id="operacion" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="operacion" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="ingreso">Ingreso a caja</option>
                <option value="gasto">Gasto</option>
            </select>
        </div>

        <div id="origengasto" class="hidden gap-2 mb-6">
            <!--<label class="block text-xl font-medium text-gray-700 mb-1 mt-5 lg:mt-0">Tipo costo inventario</label>-->
            <label for="gastocaja" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1">
                <input id="gastocaja" type="radio" name="origengasto" class="hidden peer" value="gastocaja" checked>
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Gastos de la caja</span>
            </label>

            <label for="gastobanco" class="flex items-center ps-4 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer select-none w-full p-2.5 h-14 text-xl focus:border-indigo-600 focus:outline-none focus:ring-1">
                <input id="gastobanco" type="radio" name="origengasto" class="hidden peer" value="gastobanco">
                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                <span class="ms-3 text-xl font-medium text-gray-900">Gastos transaccionales</span>
            </label>
        </div>  

        <div id="showbancos" class="mb-6 hidden">
            <label class="formulario__label" for="banco">Bancos</label>
            <select id="banco" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 mt-2 h-14 text-xl focus:outline-none focus:ring-1" name="id_banco">
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($bancos as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div id="showcajas" class="mb-6 hidden">
            <label class="formulario__label" for="caja">Caja</label>
            <select id="caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 mt-2 h-14 text-xl focus:outline-none focus:ring-1" name="id_caja" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($cajas as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="formulario__campo tipodegasto" style="display: none;"> <!-- solo aplica para gastos -->
            <label class="formulario__label" for="tipodegasto">Tipo de gasto</label>
            <select id="tipodegasto" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 mt-2 h-14 text-xl focus:outline-none focus:ring-1" name="idcategoriagastos">
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="1">Reabastecimiento</option>
                <option value="2">Arriendo o alquiler de espacio</option>
                <option value="3">Marketing y publicidad</option>
                <option value="4">Papeleria</option>
                <option value="5">Mantenimiento y/o reparacion</option>
                <option value="6">Alquiler de equipos</option>
                <option value="7">Servicios publicos</option>
                <option value="8">Insumos de aseo</option>
                <option value="9">Logistica distribucion o transporte</option>
                <option value="10">Otros</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="formulario__label" for="dinero">Ingresar dinero</label>
            <div class="formulario__dato">
                <input id="dinero" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 mt-2 h-14 text-xl focus:outline-none focus:ring-1" type="number" min="1" placeholder="Ingresa el dinero" name="valor" value="" required>
            </div>
        </div>
        <div class="mb-6">
            <label class="formulario__label" for="descripcion">Descripcion: </label>
            <textarea id="descripcion" class=" bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 mt-2 h-40 text-xl focus:outline-none focus:ring-1" name="descripcion" rows="4"></textarea>
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[137px]" type="button" value="cancelar">cancelar</button>
            <input id="btnEnviargastosingresos" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[137px]" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>


  <dialog id="cambioMedioPago" class="midialog-sm p-12">
    <h4 class="font-semibold text-gray-700 mb-4">Cambio medio de pago</h4>
    <div id="divmsjalerta2"></div>
    <form id="formCambioMedioPago" class="formulario" action="/admin/caja/cambioMedioPago" method="POST">
        <label id="numfactura" class="text-gray-700 text-2xl text-center mb-2">Factura N° : </label>
        <p class="text-gray-600 text-3xl text-center font-light m-0 mb-8">Total Pagado: $<span id="totalPagado" class="text-gray-700 font-semibold">0</span></p>
        <span class="m-0 block text-center text-2xl uppercase">Diferencia</span>
        <span id="diferencia" class="m-0 text-indigo-500 block text-center text-3xl font-bold mb-10">0</span>
        <div id="mediospagos" class="content flex flex-col items-end w-96 mx-auto mb-8">
            <?php foreach($mediospago as $index => $value):?>
            <div class="mb-4 mx-auto">
                <label class="text-gray-700 text-xl"><?php echo $value->mediopago??'';?>: </label>
                <input id="<?php echo $value->id??'';?>" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 mediopago <?php echo $value->mediopago??'';?>"
                    type="text" 
                    value="0" 
                    <?php //echo $value->mediopago=='Efectivo'?'readonly':'';?> 
                    oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()"
                >
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-right space-x-4">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="cancelar">cancelar</button>
            <input id="btnEnviarCambioMedioPago" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>

</div>