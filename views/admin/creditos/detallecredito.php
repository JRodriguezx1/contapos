<div class="p-6 min-h-screen detallecredito">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <div class="max-w-auto mx-auto bg-white shadow-lg rounded-2xl p-8">
    <!-- Título principal -->
    <a href="/admin/creditos" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 mb-6">
      <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
      </svg>
      <span class="sr-only">Atrás</span>
    </a>
    <h2 class="text-3xl font-bold text-gray-800 mb-4 flex items-center gap-2">
      💳 Detalles del <?php echo $credito->idtipofinanciacion==1?'Crédito':'Separado'; ?>
    </h2>

    <div id="divmsjalerta"></div>
    <!-- Información general del crédito -->
    <div class="grid md:grid-cols-4 gap-6 mb-6">
      <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-blue-700 mb-1 uppercase">🧾 Factura</h3>
        <p class="text-gray-800 text-lg mb-0"><?php echo $factura!=null?$factura->prefijo.' - '.$factura->num_consecutivo:'';?></p>
      </div>

      <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-green-700 mb-1 uppercase">💰 Credito</h3>
        <p class="text-gray-800 text-lg mb-0">$ <?php echo number_format($credito->capital,'2', ',', '.'); ?></p>
      </div>

      <div class="bg-purple-50 border border-purple-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-purple-700 mb-1 uppercase">💸 Abono Inicial</h3>
        <p class="text-gray-800 text-lg mb-0">$ <?php echo number_format($credito->abonoinicial,'2', ',', '.');?></p>
      </div>

      <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-yellow-700 mb-1 uppercase">💷 Interes Total</h3>
        <p class="text-gray-800 text-lg mb-0">$ <?php echo number_format($credito->valorinterestotal,'2', ',', '.');?></p>
      </div>
    </div>

    <!-- Detalles financieros -->
    <div class="grid md:grid-cols-4 gap-6 mb-6">
      <div class="bg-purple-50 border border-purple-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-purple-700 mb-1 uppercase">💲 Credito Total</h3>
        <p class="text-gray-800 text-lg mb-0">$ <?php echo number_format($credito->montototal,'2', ',', '.');?></p>
      </div>

      <div class="bg-orange-50 border border-orange-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-orange-700 mb-1 uppercase">📅 Fecha Emisión</h3>
        <p class="text-gray-800 text-lg mb-0"><?php echo $credito->fechainicio;?></p>
      </div>

      <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-blue-700 mb-1 uppercase">🔢 Plazo</h3>
        <p class="text-gray-800 text-lg mb-0"><?php echo ($credito->numcuota??0).' / '.$credito->cantidadcuotas;?> Cuotas</p>
      </div>

      <div class="bg-red-50 border border-red-200 rounded-xl p-5 shadow-sm">
        <h3 class="text-xl font-semibold text-red-700 mb-1 uppercase">📆 Fecha Vencimiento</h3>
        <p class="text-gray-800 text-lg mb-0"> - </p>
      </div>
    </div>

    <!-- Estado actual -->
    <div class="bg-gray-100 border border-gray-300 rounded-xl p-5 mb-8">
      <h3 class="text-xl font-semibold text-gray-700 mb-3 uppercase">📊 Estado del Crédito</h3>
      <div class="flex flex-col sm:flex-row gap-10">
        <div class="flex items-center gap-4">
          <span class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-700">
            <?php echo $credito->estado==0?'En curso':'Finalizado'; ?>
          </span>
          <span class="text-gray-600">Saldo pendiente: <strong>$<?php echo number_format($credito->saldopendiente,'2', ',', '.'); ?></strong></span>
        </div>
        <div>
          <span class="text-gray-600">Cliente: <strong><?php echo $cliente->nombre.' '.$cliente->apellido; ?></strong></span>
        </div>
        <div>
          <span class="text-gray-600">Productos: <div class="btn-xs <?php echo $credito->productoentregado==0?'btn-light':'btn-lima';?>"><?php echo $credito->productoentregado==0?'Pendiente':'Entregado';?></div></span>
        </div>
      </div>
    </div>

    <!-- Historial de abonos -->
    <div class="mb-10">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">📚 Historial de Abonos</h3>
      <table id="tablacuotas" class="w-full border border-gray-200 rounded-xl overflow-hidden">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-base font-semibold text-gray-700">N° de Cuota</th>
            <th class="px-4 py-2 text-base font-semibold text-gray-700">Fecha</th>
            <th class="px-4 py-2 text-base font-semibold text-gray-700">Valor cuota</th>
            <th class="px-4 py-2 text-base font-semibold text-gray-700">Valor pagado</th>
            <th class="px-4 py-2 text-base font-semibold text-gray-700">Medio pago</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($cuotas as $value): ?>
            <tr class="border-t">
              <td class="px-4 py-2 text-gray-800"><?php echo $value->numerocuota;?></td>
              <td class="px-4 py-2 text-gray-800"><?php echo $value->fechapagado;?></td>
              <td class="px-4 py-2 text-gray-800">$<?php echo number_format($value->montocuota, '2', ',', '.');?></td>
              <td class="px-4 py-2 text-gray-800">$<?php echo number_format($value->valorpagado, '2', ',', '.');?></td>
              <td class="px-4 py-2 text-gray-800">
                <?php foreach($value->mediosdepago as $idx => $element): ?>
                <button id="<?php echo $value->id;?>" data-totalpagado="<?php echo $value->valorpagado;?>" data-idcredito="<?php echo $value->id_credito;?>" data-idmediopago="<?php echo $element->idmediopago;?>" data-mediopagado="<?php echo $element->valor;?>" class="mediosdepago btn-xs btn-light"><?php echo $element->mediopago;?></button>
                <?php endforeach; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          
        </tbody>
      </table>
    </div>

    <!-- Botones de acción -->
    <div class="flex justify-end gap-4">
      <button id="btnDetalleProductos" class="btn-md btn-blue mb-4 !py-4 px-6">
        📄 Productos
      </button>
      <button id="btnAbonar" class="btn-md btn-blueintense mb-4 !py-4 px-6 !bg-indigo-600">
        ➕ Abonar
      </button>
      <button id="btnPagarTodo" class="hover:bg-green-700 btn-turquoise text-white font-semibold  rounded-lg shadow flex items-center gap-2 mb-4 py-4 px-6">
        ✅ Pagar Todo
      </button>
      <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold  rounded-lg shadow flex items-center gap-2 mb-4 py-4 px-6">
        ⬅️ Volver
      </button>
    </div>
  </div>


  <!-- MODAL DETALLE PRODUCTO-->
  <dialog id="miDialogoDetalleProducto" class="midialog-md p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
      <h4 id="modalDetalleProducto" class="font-semibold text-gray-700 mb-4">Detalle producto</h4>
      <button class="rounded-lg hover:bg-gray-100 transition">
          <i id="btnXCerrarModalDetalleProducto" class="fa-solid fa-xmark text-gray-600 text-3xl p-2"></i>
      </button>
    </div>
    <div id="divmsjalerta1"></div>
    <!-- TABLA DE PRODUCTOS -->
    <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
        <table id="tabladetalleProducto"
            class="w-full text-left border-collapse">
            <thead
                class="bg-indigo-100 text-indigo-800 uppercase text-base tracking-wide">
                <tr>
                    <th class="px-5 py-3 border-b border-gray-200">Producto</th>
                    <th class="px-5 py-3 border-b border-gray-200">Cantidad</th>
                    <th class="px-5 py-3 border-b border-gray-200">Unidad de medida</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-lg divide-y divide-gray-100">
                <!-- Filas dinámicas -->
                <?php foreach($productos as $value): ?>
                  <tr>
                    <td class="px-4 py-2 border"><?php echo $value->nombreproducto; ?></td>
                    <td class="px-4 py-2 border"><?php echo $value->cantidad; ?></td>
                    <td class="px-4 py-2 border"><?php echo 'Unidades'; ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
  </dialog><!--fin modal detalle producto-->


  <!-- MODAL CAMBIO MEDIO DE PAGO -->
    <dialog id="cambioMedioPago"
        class="midialog-xs p-12">
        <!-- Encabezado -->
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h4 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">💳 Cambio medio de pago</h4>
            <button type="button" id="btnCerrarCambioMedioPago"
                class="p-2 rounded-lg hover:bg-gray-100 transition"
                onclick="document.getElementById('cambioMedioPago').close()">
                <i class="fa-solid fa-xmark text-gray-600 text-2xl"></i>
            </button>
        </div>

        <div id="divmsjalerta2"></div>

        <form id="formCambioMedioPago" class="formulario space-y-6" action="/admin/caja/cambioMedioPago" method="POST">

            <div class="text-center">
                <label id="numCuota" class="text-gray-700 text-2xl font-medium block mb-2">
                    Credito N° :
                </label>
                <p id="textMP" class="text-gray-600 text-3xl font-light m-0 mb-2"></p>
                <span id="totalPagado" class="text-gray-800 text-2xl font-semibold block mb-4">$ </span>
            </div>

            <!-- Medios de pago -->
            <div class="formulario__campo">
                <label class="formulario__label" for="selectMediopago">Medio de pago</label>
                <select id="selectMediopago" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="mediopagoid" required>
                    <?php foreach($mediospago as $value):  ?>
                          <option value="<?php echo $value->id;?>" ><?php echo $value->mediopago;?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones -->
            <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" value="Cancelar">Cancelar</button>
                <input id="btnEnviarCambioMedioPago" class="btn-md btn-indigo !py-4 !px-6 !w-[136px]" type="submit" value="Aplicar">
            </div>
        </form>
    </dialog>

  <?php include __DIR__ . "/abonoinicial.php"; ?>
  <?php include __DIR__ . "/abonototal.php"; ?>

</div>
