<div class="detallecredito">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>

  <?php if(!empty($alertas['idcuota']) && ($_POST['imprimirComprobanteAbonoinicial'] ?? '0') === '1'): ?>
    <input id="autoPrintAbonoCredito" type="hidden" value="<?php echo $alertas['idcuota']; ?>">
  <?php endif; ?>
  
  <div class="detalle-credito-shell">
    <!-- Título principal -->
    <a href="/admin/creditos" class="detalle-credito-back">
      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
      </svg>
      <span class="sr-only">Atrás</span>
    </a>
    <h2 class="detalle-credito-title">
      Detalles del <?php echo $credito->idtipofinanciacion==1?'Crédito':'Separado'; ?>
    </h2> 

    <div id="divmsjalerta"></div>
    <!-- Información general del crédito -->
    <div class="detalle-credito-metrics">
      <div>
        <h3>🧾 Factura</h3>
        <p><?php echo $factura!=null?$factura->prefijo.' - '.$factura->num_consecutivo:'';?></p>
      </div>

      <div>
        <h3>💰 Credito</h3>
        <p id="creditoText">$ <?php echo number_format($credito->capital,'2', ',', '.'); ?></p>
      </div>

      <div>
        <h3>💸 Abono Inicial</h3>
        <p id="abonoInicialText">$ <?php echo number_format($credito->abonoinicial,'2', ',', '.');?></p>
      </div>

      <div>
        <h3>💷 Interes Total</h3>
        <p id="interesText">$ <?php echo number_format($credito->valorinterestotal,'2', ',', '.');?></p>
      </div>
    </div>

    <!-- Detalles financieros -->
    <div class="detalle-credito-metrics">
      <div>
        <h3>💲 Credito Total</h3>
        <p id="creditoTotalText">$ <?php echo number_format($credito->montototal,'2', ',', '.');?></p>
      </div>

      <div>
        <h3>📅 Fecha Emisión</h3>
        <p><?php echo $credito->fechainicio;?></p>
      </div>

      <div>
        <h3>🔢 Plazo</h3>
        <p><?php echo ($credito->numcuota??0).' / '.$credito->cantidadcuotas;?> Cuotas</p>
      </div>

      <div>
        <h3>📆 Fecha Vencimiento</h3>
        <p> - </p>
      </div>
    </div>

    <!-- Estado actual -->
    <div class="detalle-credito-status">
      <h3>📊 Estado del Crédito</h3>
      <div class="detalle-credito-status__content">
        <div class="detalle-credito-status__group">
          <span class="detalle-credito-state <?php echo $credito->idestadocreditos==1?'bg-cyan-100 text-blue-600':($credito->idestadocreditos==2?'bg-green-100 text-green-700':'bg-red-100 text-red-700'); ?>">
            <?php echo $credito->idestadocreditos==1?'Finalizado':($credito->idestadocreditos==2?'En curso':'Anulado'); ?>
          </span>
          <span>Saldo pendiente: <strong id="saldopendientetext">$<?php echo number_format($credito->saldopendiente,'2', ',', '.'); ?></strong></span>
        </div>
        <div class="detalle-credito-status__group">
          <span>Cliente: <strong><?php echo $cliente->nombre.' '.$cliente->apellido; ?></strong></span>
        </div>
        <div class="detalle-credito-status__group">
          <span>Productos: <div class="btn-xs <?php echo $credito->productoentregado==0?'btn-light':'btn-lima';?>"><?php echo $credito->productoentregado==0?'Pendiente':'Entregado';?></div></span>
        </div>
        <?php if($credito->idestadocreditos == 2 && $credito->idtipofinanciacion == 2):
                if(tienePermiso('Editar separados activos')&&userPerfil()>3 || userPerfil()<4){
        ?>
          <div><a href="/admin/creditos/adicionarProducto?id=<?php echo $credito->id;?>" class="detalle-credito-add-product">+</a></div>
        <?php } endif;?>
      </div>
    </div>

    <!-- Historial de abonos -->
    <div class="detalle-credito-table-card config-table-card">
      <h3>📚 Historial de Abonos</h3>
      <table id="tablacuotas">
        <thead>
          <tr>
            <th>N° de Cuota</th>
            <th>Fecha</th>
            <th>Valor cuota</th>
            <th>Valor pagado</th>
            <th>Medio pago</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($cuotas as $value): ?>
            <tr>
              <td><?php echo $value->numerocuota;?></td>
              <td><?php echo $value->fechapagado;?></td>
              <td>$<?php echo number_format($value->montocuota, '2', ',', '.');?></td>
              <td>$<?php echo number_format($value->valorpagado, '2', ',', '.');?></td>
              <td>
                <?php foreach($value->mediosdepago as $idx => $element): ?>
                <button id="<?php echo $value->id;?>" data-totalpagado="<?php echo $value->valorpagado;?>" data-idcredito="<?php echo $value->id_credito;?>" data-idmediopago="<?php echo $element->idmediopago;?>" data-mediopagado="<?php echo $element->valor;?>" class="mediosdepago"><?php echo $element->mediopago;?></button>
                <?php endforeach; ?>
              </td>
              <td>
                <div id="<?php echo $value->id;?>" class="flex justify-center gap-4">
                  <button class="anularAbono" title="Eliminar abono">X</button>
                  <button class="printPOSAbono material-symbols-outlined">print</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          
        </tbody>
      </table>
    </div>

    <!-- Botones de acción -->
    <div class="detalle-credito-actions">
      <?php if($credito->idestadocreditos == 2):
                if(tienePermiso('Editar separados activos')&&userPerfil()>3 || userPerfil()<4){
      ?>
        <button id="ajustarCredito">🔄 Ajustar Credito</button>
      <?php } endif; ?>
      <button id="btnDetalleProductos">📄 Productos</button>
      <button id="btnAbonar">➕ Abonar</button>
      <button id="btnPagarTodo">✅ Pagar Todo</button>
      <button>⬅️ Volver</button>
    </div>
  </div>


  <!-- MODAL DETALLE PRODUCTO-->
  <dialog id="miDialogoDetalleProducto" class="detalle-producto-dialog">
    <div class="detalle-producto-dialog__header">
      <div class="detalle-producto-dialog__title">
        <span class="detalle-producto-dialog__icon">
          <i class="fa-solid fa-boxes-stacked"></i>
        </span>
        <div>
          <p>Productos</p>
          <h4 id="modalDetalleProducto">Detalle producto</h4>
          <span><?php echo count($productos); ?> articulos asociados al <?php echo $credito->idtipofinanciacion==1?'credito':'separado'; ?>.</span>
        </div>
      </div>
      <button type="button" class="detalle-producto-dialog__close" aria-label="Cerrar detalle de producto">
          <i id="btnXCerrarModalDetalleProducto" class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div id="divmsjalerta1"></div>
    <!-- TABLA DE PRODUCTOS -->
    <div class="detalle-producto-dialog__body">
    <div class="detalle-producto-dialog__table-wrap">
        <table id="tabladetalleProducto"
            class="detalle-producto-dialog__table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Unidad de medida</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filas dinámicas -->
                <?php foreach($productos as $value): ?>
                  <tr>
                    <td data-label="Producto">
                      <span class="detalle-producto-dialog__product"><?php echo $value->nombreproducto; ?></span>
                    </td>
                    <td data-label="Cantidad">
                      <span class="detalle-producto-dialog__quantity"><?php echo $value->cantidad; ?></span>
                    </td>
                    <td data-label="Unidad">
                      <span class="detalle-producto-dialog__unit"><?php echo 'Unidades'; ?></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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
  <?php include __DIR__ . "/ajustarcredito.php"; ?>

  <script>
    const getParam = <?= json_encode($conflocal) ?>;
  </script>

</div>
