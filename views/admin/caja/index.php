<div class="box caja">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de Caja</h4>
  <div class="flex flex-wrap gap-4 mb-6">
    <a class="btn-command" href="/admin/caja/cerrarcaja"><span class="material-symbols-outlined">hard_drive</span>Cerrar Caja</a>
    <button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/almacen/productos" id="btnGastosingresos"><span class="material-symbols-outlined">paid</span>Gastos</br>Ingresos</button>
    <a class="btn-command" href="/admin/caja/zetadiario"><span class="material-symbols-outlined">document_search</span>Zeta Diario</a>
    <a class="btn-command text-center" href="/admin/caja/ultimoscierres"><span class="material-symbols-outlined">list_alt</span>Ultimos Cierres</a>
    <button class="btn-command"><span class="material-symbols-outlined">lock_open</span>Abrir Cajon</button>
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/almacen/productos" href="/admin/caja"><span class="material-symbols-outlined">folder_check_2</span>Guardados</a>
  </div>
  <h5 class="text-gray-600 mb-3"><span  class="material-symbols-outlined"></span>Lista de Facturas</h5>
  <table class="display responsive nowrap tabla" width="100%" id="tablaListaPedidos">
      <thead>
          <tr>
              <th>N.</th>
              <th>Fecha</th>
              <th>Cliente</th>
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
              <td class=""><?php echo $value->cliente;?></td>
              <td class=""><?php echo $value->id;?></td>
              <td>
                <div data-estado="<?php echo $value->estado;?>" data-totalpagado="<?php echo $value->total;?>" id="<?php echo $value->id;?>" class="mediosdepago max-w-full flex flex-wrap gap-2">
                    <?php foreach($value->mediosdepago as $idx => $element): ?>
                    <button class="btn-xs btn-light"><?php echo $element->mediopago;?></button>
                    <?php endforeach; ?>
                </div>
              </td>
              <td class="<?php echo $value->estado=='Paga'?'btn-xs btn-lima':($value->estado=='Guardado'?'btn-xs btn-turquoise':'btn-xs btn-light');?>"><?php echo $value->estado;?></td>
              <td class=""><strong>$ </strong><?php echo number_format($value->subtotal??0, "0", ",", ".");?></td>
              <td class=""><strong>$ </strong><?php echo number_format($value->total??0, "0", ",", ".");?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                      <a class="btn-xs btn-turquoise" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">Ver</a> <button class="btn-xs btn-light"><i class="fa-solid fa-print"></i></button>
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
            <td class="px-6 py-3">$<?php echo number_format($ultimocierre->ingresoventas??0, "0", ",", ".");?></td>
        </tr>
      </tfoot>
  </table>

  <dialog class="midialog-sm p-5" id="gastosIngresos">
    <h4 class="font-semibold text-gray-700 mb-4">Gastos e ingresos</h4>
    <div id="divmsjalerta1"></div>
    <form id="formGastosingresos" class="formulario" action="/admin/caja/ingresoGastoCaja" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="operacion">Operacion</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="operacion" id="operacion" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="ingreso">Ingreso a caja</option>
                <option value="gasto">Gasto de la caja</option>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="caja">Caja</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="id_caja" id="caja" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($cajas as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="formulario__campo tipodegasto" style="display: none;"> <!-- solo aplica para gastos -->
            <label class="formulario__label" for="tipodegasto">Tipo de gasto</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="idcategoriagastos" id="tipodegasto">
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
        <div class="formulario__campo">
            <label class="formulario__label" for="dinero">Ingresar dinero</label>
            <div class="formulario__dato">
                <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" min="1" placeholder="Ingresa el dinero" id="dinero" name="valor" value="" required>
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="descripcion">Descripcion: </label>
            <textarea class=" bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-40 text-xl focus:outline-none focus:ring-1" id="descripcion" name="descripcion" rows="4"></textarea>
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[180px]" type="button" value="cancelar">cancelar</button>
            <input id="btnEnviargastosingresos" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[180px]" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>


  <dialog class="midialog-sm p-5" id="cambioMedioPago">
    <h4 class="font-semibold text-gray-700 mb-4">Cambio medio de pago</h4>
    <div id="divmsjalerta2"></div>
    <form id="formCambioMedioPago" class="formulario" action="/admin/caja/cambioMedioPago" method="POST">
        <label id="numfactura" class="text-gray-700 text-2xl text-center mb-2">Factura N° : </label>
        <p class="text-gray-600 text-3xl text-center font-light m-0 mb-8">Total Pagado: $<span id="totalPagado" class="text-gray-700 font-semibold">0</span></p>
        <div id="mediospagos" class="content flex flex-col items-end w-96 mx-auto">
            <?php foreach($mediospago as $index => $value):?>
            <div class="mb-4">
                <label class="text-gray-700 text-xl"><?php echo $value->mediopago??'';?>: </label>
                <input id="<?php echo $value->id??'';?>" 
                    class="w-44 py-1 px-3 rounded-lg border border-gray-300 focus:outline-none focus:border-gray-500 text-xl mediopago <?php echo $value->mediopago??'';?>"
                    type="text" 
                    value="0" 
                    <?php //echo $value->mediopago=='Efectivo'?'readonly':'';?> 
                    oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()"
                >
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="cancelar">cancelar</button>
            <input id="btnEnviarCambioMedioPago" class="btn-md btn-blue" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>

</div>