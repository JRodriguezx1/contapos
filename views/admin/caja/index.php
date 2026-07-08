<div class="box caja !pb-20">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de Caja</h4>
  <div class="flex flex-wrap gap-4 mb-6">
    <?php if(tienePermiso('Ver detalle de la caja')&&userPerfil()>3 || userPerfil()<4): ?>
        <a class="btn-command" href="/admin/caja/cerrarcaja"><span class="material-symbols-outlined">hard_drive</span>Cerrar Caja</a>
    <?php endif; ?>
    <button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" id="btnGastosingresos">
        <span class="material-symbols-outlined">paid</span>Gastos</br>Ingresos</button>
    <?php if($conflocal['permitir_ver_zeta_diario']->valor_final == 1):?>
        <a class="btn-command" href="/admin/caja/zetadiario"><span class="material-symbols-outlined">document_search</span>Zeta Diario</a>
    <?php endif; ?>
    <?php if($conflocal['permitir_ver_cierres_de_cajas_anteriores']->valor_final == 1):?>
        <a class="btn-command text-center" href="/admin/caja/ultimoscierres"><span class="material-symbols-outlined">list_alt</span>Ultimos Cierres</a>
     <?php endif; ?>
    <button id="btnAbrirCajon" class="btn-command"><span class="material-symbols-outlined">lock_open</span>Abrir Cajon</button>
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/caja/pedidosguardados"><span class="material-symbols-outlined">folder_check_2</span>Cotizaciones</a>
    <!--<a class="btn-command text-center" href="/admin/caja/trasladosRetirosDinero"><span class="material-symbols-outlined">assured_workload</span>Traslados y retiros</a>-->
    <a class="btn-command text-center" href="/admin/caja/despachosPendientes"><span class="material-symbols-outlined">delivery_truck_speed</span>Despachos pendientes</a>
    <a class="btn-command text-center" href="/admin/reportes/remisiones"><span class="material-symbols-outlined">format_list_bulleted</span>Remisiones</a>
  </div>
    <h5 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-4">
        Lista de Ordenes
        <span class="bg-indigo-600 hover:bg-indigo-700 text-white text-xl font-bold px-6 py-2 rounded-full shadow-xl transition duration-300 ease-in-out transform hover:scale-110 uppercase tracking-wide">
            <?php echo $sucursal; ?>
        </span>
    </h5>

  <table id="tablaListaPedidos" class="display responsive nowrap tabla" width="100%">
      <thead>
          <tr>
              <th>N.</th>
              <th title="Fecha de pago">Fecha</th>
              <th>Caja</th>
              <th>Entrega</th>
              <th>Orden</th>
              <th>Factura</th>
              <th>Medio Pago</th>
              <th>Estado</th>
              <th>Subtotal</th>
              <th>Total</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($facturas as $index => $value): ?>
            <tr> 
              <td class=""><?php echo $index+1;?></td>
              <td class=""><div class="w-36 whitespace-normal"><?php echo $value->fechapago;?></div></td> 
              <td class=""><div class="w-24 whitespace-normal"><?php echo $value->nombrecaja;?></div></td>
              <td class="<?php echo ($value->entrega=='Domicilio' && ($value->estado == 'Paga' || $value->estado == 'Remision') && $value->entregado == 1)?'text-green-500':(($value->entrega=='Domicilio'&& ($value->estado == 'Paga' || $value->estado == 'Remision') && $value->entregado == 0)?'text-red-500':'');?>"><?php echo $value->entrega;?></td>
              <td class=""><?php echo $value->num_orden;?></td>
              <td class=""><?php echo $value->prefijo.''.$value->num_consecutivo;?></td>
              <td>
                <div data-estado="<?php echo $value->estado;?>" data-totalpagado="<?php echo $value->total;?>" id="<?php echo $value->id;?>" class="mediosdepago max-w-full flex flex-wrap gap-2">
                    <?php foreach($value->mediosdepago as $idx => $element): ?>
                    <button class="btn-xs btn-light"><?php echo $element->mediopago;?></button>
                    <?php endforeach; ?>
                </div>
              </td>
              <td class=""><div class="btn-xs <?php echo $value->estado=='Paga'&&$value->tipoventa=='Contado'?'btn-lima':($value->estado=='Paga'&& $value->tipoventa=='Credito'?'btn-green':($value->estado=='Guardado'?'btn-turquoise':($value->estado=='Remision' || $value->estado=='Paga'&&$value->remision==1?'btn-indigo':'btn-light')));?>"><?php echo ($value->tipoventa =='Contado'||$value->tipoventa =='')?$value->estado:(($value->tipoventa =='Credito' && $value->estado == 'Paga')?'Credito':'Credito elim..');?></div></td>
              <td class=""><strong>$ </strong><?php echo number_format($value->subtotal??0, "0", ",", ".");?></td>
              <td class=""><strong>$ </strong><?php echo number_format($value->total??0, "0", ",", ".");?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-cotizacion="<?php echo $value->cotizacion;?>" >
                    <a class="btn-xs btn-turquoise" title="Ver detalles del pedido" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">Ver</a>
                    <?php if($value->estado=='Paga'): ?>
                        <button class="btn-xs btn-light printPOS" title="Imprimir en PDF POS"><i class="fa-solid fa-print"></i></button>
                    <?php endif; ?>
                    <button class="btn-xs btn-light printPDF" title="Imprimir en PDF carta"><i class="fa-solid fa-file-pdf text-red-600"></i></button>
                  </div>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr class="font-semibold text-gray-900">
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

    <!-- MODAL GASTOS E INGRESOS -->
    <dialog id="gastosIngresos"
        class="rounded-2xl border border-gray-200 w-[95%] max-w-3xl p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">

        <!-- Encabezado -->
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h4 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">
                💰 Gastos e ingresos
            </h4>
            <button id="btnCerrarGastosIngresos"
                class="p-2 rounded-lg hover:bg-gray-100 transition"
                onclick="document.getElementById('gastosIngresos').close()">
                <i class="fa-solid fa-xmark text-gray-600 text-2xl"></i>
            </button>
        </div>

        <div id="divmsjalerta1"></div>

        <form id="formGastosingresos" class="formulario space-y-6" action="/admin/caja/ingresoGastoCaja" method="POST" enctype="multipart/form-data">

            <!-- Operación -->
            <div class="formulario__campo">
                <label class="formulario__label text-lg font-medium text-gray-700" for="operacion">Operación</label>
                <select id="operacion"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 h-14 text-lg focus:outline-none focus:ring-1"
                    name="operacion" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="ingreso">Ingreso a caja</option>
                    <option value="gasto">Gasto</option>
                </select>
            </div>

            <!-- Origen del gasto -->
            <div id="origengasto" class="hidden gap-3">
                <label for="gastocaja"
                    class="flex items-center ps-4 bg-indigo-50 border border-indigo-200 text-gray-900 rounded-xl cursor-pointer select-none w-full p-3 h-14 text-lg transition hover:bg-indigo-100">
                    <input id="gastocaja" type="radio" name="origengasto" class="hidden peer" value="gastocaja" checked>
                    <div class="w-5 h-5 border-2 border-indigo-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                    <span class="ms-3 font-medium">Gastos de la caja</span>
                </label>

                <label for="gastobanco"
                    class="flex items-center ps-4 bg-indigo-50 border border-indigo-200 text-gray-900 rounded-xl cursor-pointer select-none w-full p-3 h-14 text-lg transition hover:bg-indigo-100">
                    <input id="gastobanco" type="radio" name="origengasto" class="hidden peer" value="gastobanco">
                    <div class="w-5 h-5 border-2 border-indigo-300 rounded-full peer-checked:bg-indigo-600 peer-checked:border-indigo-600"></div>
                    <span class="ms-3 font-medium">Gastos transaccionales</span>
                </label>
            </div>

            <!-- Banco -->
            <div id="showbancos" class="hidden">
                <label class="formulario__label text-lg font-medium text-gray-700" for="banco">Banco</label>
                <select id="banco"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                    name="id_banco">
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($bancos as $value): ?>
                    <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Caja -->
            <div id="showcajas" class="hidden">
                <label class="formulario__label text-lg font-medium text-gray-700" for="caja">Caja</label>
                <select id="caja"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                    name="id_caja" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($cajas as $value): ?>
                    <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipo de gasto -->
            <div class="formulario__campo tipodegasto hidden">
                <label class="formulario__label text-lg font-medium text-gray-700" for="tipodegasto">Tipo de gasto</label>
                <select id="tipodegasto"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                    name="idcategoriagastos">
                    <option value="" disabled selected>-Seleccionar-</option>
                    <?php foreach($categoriasgastos as $value): ?>
                    <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>
                <a href="/admin/caja/categoriaGasto"
                    class="text-base text-indigo-600 font-medium hover:text-indigo-800 transition">Agregar categoría de gasto</a>
            </div>

            <!-- Soporte físico (solo para gasto) -->
            <div id="soporteGasto" class="hidden">
                <label class="formulario__label text-lg font-medium text-gray-700" for="soporte">Soporte físico (imagen del gasto)</label>
                <input id="soporte" type="file" name="imgcomprobante" accept="image/*"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full mt-2 p-3 text-lg focus:outline-none focus:ring-1">
                <p class="text-sm text-gray-500 mt-1">Formatos permitidos: JPG, PNG, JPEG.</p>
            </div>

            <!-- Dinero -->
            <div>
                <label class="formulario__label text-lg font-medium text-gray-700" for="dinero">Ingresar dinero</label>
                <input id="dinero"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-14 text-lg focus:outline-none focus:ring-1"
                    type="text" placeholder="Ingresa el dinero" name="valor" value=""
                    oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString('es-CO')"
                    required>
            </div>

            <!-- Descripción -->
            <div>
                <label class="formulario__label text-lg font-medium text-gray-700" for="descripcion">Descripción</label>
                <textarea id="descripcion"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 mt-2 h-40 text-lg focus:outline-none focus:ring-1"
                    name="descripcion" rows="4"></textarea>
            </div>

            <!-- Botones -->
            <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px]"
                    onclick="document.getElementById('gastosIngresos').close()">Cancelar</button>
                <input id="btnEnviargastosingresos" type="submit" value="Aplicar"
                    class="btn-md btn-indigo !py-4 !px-6 !w-[135px]">
            </div>
        </form>
    </dialog>

    <!-- Modal Abrir cajón monedero -->
    <dialog class="midialog-sm rounded-3xl p-0 overflow-hidden" id="miDialogoAbrirCaja">
        <!-- Header -->
        <div class="bg-indigo-600 text-white px-8 py-6 text-center">
            <i class="fa-solid fa-cash-register text-5xl mb-3"></i>

            <h2 class="text-3xl font-bold">
                Abrir Cajón Monedero
            </h2>

            <p class="text-indigo-100 mt-2 text-lg">
                Se requiere autorización para abrir el cajón.
            </p>
        </div>

        <!-- Body -->
        <div class="p-8">
            <div id="divmsjalerta3"></div>
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6">

                <label
                    for="inputAbrirCaja"
                    class="block text-xl font-semibold text-slate-700 mb-3">

                    Clave de autorización
                </label>

                <input
                    id="inputAbrirCaja"
                    type="password"
                    class="w-full h-14 rounded-xl border border-slate-300 px-4 text-xl focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 focus:outline-none"
                    placeholder="Ingrese la clave">

            </div>
            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-8">

                <button
                    type="button"
                    class="noAbrirCajon px-6 py-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 transition">

                    Cancelar
                </button>

                <button
                    type="button"
                    class="siAbrirCajon px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-sm">

                    <i class="fa-solid fa-lock-open mr-2"></i>
                    Confirmar
                </button>
            </div>
        </div>
    </dialog>


    <!-- MODAL CAMBIO MEDIO DE PAGO -->
    <dialog id="cambioMedioPago"
        class="rounded-2xl border border-gray-200 w-[95%] max-w-[58rem] p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">

        <!-- Encabezado -->
        <div class="flex justify-between items-center border-b border-slate-200 pb-6 mb-8">
            <h4 class="flex items-center gap-3 text-3xl font-bold text-slate-800">
                <span class="material-symbols-outlined text-indigo-600 text-4xl">
                    payments
                </span>
                Cambiar medio de pago
            </h4>

            <button
                type="button"
                id="btnCerrarCambioMedioPago"
                class="p-2 rounded-lg hover:bg-gray-100 transition"
                onclick="document.getElementById('cambioMedioPago').close()">

                <i class="fa-solid fa-xmark text-gray-600 text-2xl"></i>
            </button>
        </div>

        <div id="divmsjalerta2"></div>

        <form id="formCambioMedioPago"
            class="formulario space-y-6"
            action="/admin/caja/cambioMedioPago"
            method="POST">
            <!-- Factura -->
            <div class="text-center mb-5">
                <label
                    id="numfactura"
                    class="text-xl font-semibold text-slate-600">
                </label>
            </div>

            <!-- Tarjeta Total -->
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-8 text-center mb-8">
                <p class="uppercase tracking-[0.25em] text-sm font-semibold text-emerald-700">
                    Total pagado
                </p>

                <p class="mt-4 text-6xl font-bold text-emerald-700">
                    $<span id="totalPagado">0</span>
                </p>
            </div>

            <!-- Diferencia -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 mb-8 text-center">
                <p class="uppercase tracking-[0.25em] text-sm font-semibold text-slate-500">
                    Diferencia
                </p>

                <p
                    id="diferencia"
                    class="mt-3 text-5xl font-bold text-indigo-600">

                    0
                </p>
                <p class="mt-2 text-sm text-slate-500">
                    Debe quedar en cero para aplicar el cambio.
                </p>
            </div>

            <!-- Tarjeta Medios de pago -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">
                        account_balance_wallet
                    </span>

                    <h5 class="text-2xl font-bold text-slate-800">
                        Medios de pago
                    </h5>
                </div>

                <!-- NUEVA ALERTA -->
                <div
                    id="ayudaCambioMedioPago"
                    class="mb-6 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">

                    <span class="material-symbols-outlined text-amber-600 mt-0.5">
                        info
                    </span>

                    <div class="text-sm leading-6 text-amber-800">

                        <strong>Importante:</strong>

                        Para cambiar un medio de pago,
                        primero reduzca el valor del
                        <strong>medio actual</strong>
                        y luego registre ese mismo valor
                        en el nuevo medio.

                        La diferencia debe quedar en
                        <strong>$0</strong>.

                    </div>
                </div>

                <div
                    id="mediospagos"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">

                    <?php foreach($mediospago as $index => $value): ?>
                        <div class="contenedor-medio-pago relative pt-8 w-full">

                            <!-- Esta etiqueta la mostrará luego el JavaScript -->
                            <span
                                class="medio-actual hidden absolute top-0 left-0 rounded-full bg-indigo-100  text-indigo-700 text-xs font-semibold px-3 py-1">
                                ① Medio de pago actual
                            </span>

                            <label
                                class="block text-lg font-semibold text-slate-700 mb-2">

                                <?php echo $value->mediopago ?? ''; ?>
                            </label>

                            <input
                                id="<?php echo $value->id ?? ''; ?>"
                                class="bg-white
                                    border
                                    border-slate-300
                                    text-slate-800
                                    rounded-xl
                                    block
                                    w-full
                                    p-3
                                    mt-1
                                    h-16
                                    text-xl
                                    text-center
                                    font-semibold
                                    focus:border-indigo-600
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-indigo-200
                                    transition
                                    mediopago
                                    input-medio-pago
                                    <?php echo $value->mediopago ?? ''; ?>"
                                type="text"
                                value="0"
                                oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Botones -->
            <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
                <button
                    type="button"
                    class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]"
                    onclick="document.getElementById('cambioMedioPago').close()">
                    Cancelar
                </button>

                <input
                    id="btnEnviarCambioMedioPago"
                    class="btn-md btn-indigo !py-4 !px-6 !w-[136px]"
                    type="submit"
                    value="Aplicar">
            </div>
        </form>
    </dialog>


    <script>
        document.getElementById('operacion').addEventListener('change', function () {
            const esGasto = this.value === 'gasto';
            //document.getElementById('origengasto').classList.toggle('hidden', !esGasto);
            //document.querySelector('.tipodegasto').classList.toggle('hidden', !esGasto);
            document.getElementById('soporteGasto').classList.toggle('hidden', !esGasto);
        });

        const getParam = <?= json_encode($conflocal) ?>;
    </script>
</div>