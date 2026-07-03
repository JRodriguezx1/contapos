<div class="space-y-6 detallecliente">
    <!-- Información del cliente -->
    <div class="bg-white rounded-2xl p-8 shadow-md">
            <a href="/admin/clientes" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2    mb-6">
            <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
            <span class="sr-only">Atrás</span>
        </a>
        <!-- Título -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A11.955 11.955 0 0112 15c2.485 0 4.77.755 6.879 2.045M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Perfil del Cliente
        </h2>

        <!-- Grid con datos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">
            <!-- Columna izquierda -->
            <div class="space-y-2">
                <p class="flex items-center gap-3 mb-0">
                    <span class="font-semibold text-base text-gray-500">Nombre:</span>
                    <span class="text-2xl font-bold text-gray-900"><?php echo $cliente->nombre.' '.$cliente->apellido; ?></span>
                </p>
                <p class="flex items-center gap-3">
                    <span class="font-semibold text-base text-gray-500">Correo:</span>
                    <span class="text-lg font-medium text-indigo-600 underline"><?php echo $cliente->email; ?></span>
                </p>
                <p class="flex items-center gap-3">
                    <span class="font-semibold text-base text-gray-500">Teléfono:</span>
                    <span class="text-lg font-medium text-gray-900"><?php echo $cliente->telefono??'NA'; ?></span>
                </p>
            </div>

            <!-- Columna derecha -->
            <div class="space-y-2">
                <p class="flex items-center gap-3 mb-0">
                    <span class="font-semibold text-base text-gray-500">Última compra:</span>
                    <span class="text-lg font-medium text-gray-900"> - </span>
                </p>
                <p class="flex items-center gap-3">
                    <span class="font-semibold text-base text-gray-500">Cliente desde:</span>
                    <span class="text-lg font-medium text-gray-900"> - </span>
                </p>
                <p class="flex items-center gap-3">
                    <span class="font-semibold text-base text-gray-500">Estado:</span>
                    <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700 font-semibold">Activo</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Indicadores -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-2 shadow text-center border-b-4 border-green-600">
            <p class="text-base text-gray-500">🏷️ Total de compras</p>
            <p class="text-3xl lg:text-4xl font-bold"><?php echo $indicadores->cantidad_ventas??0;?></p>
        </div>
        <div class="bg-white rounded-2xl p-2 shadow text-center border-b-4 border-indigo-600">
            <p class="text-base text-gray-500">💰 Monto total comprado</p>
            <p class="text-3xl lg:text-3xl font-bold">$ <?php echo number_format($indicadores->total_ventas_cliente??0, 2, ',', '.');?></p>
        </div>
        <div class="bg-white rounded-2xl p-2 shadow text-center border-b-4 border-yellow-600">
            <p class="text-base text-gray-500">📊 Ticket promedio</p>
            <p class="text-3xl lg:text-3xl font-bold">$ <?php echo number_format($indicadores->ticket_promedio??0, 2, ',', '.');?></p>
        </div>
        <div class="bg-white rounded-2xl p-2 shadow text-center border-b-4 border-red-600">
            <p class="text-base text-gray-500">❤️ Puntos Acumulados</p>
            <p class="text-3xl lg:text-4xl font-bold">900 Pts</p>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ventas por meses -->
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold">Compras por Mes</h3>
            </div>
            <div class="card-canvas">
                <canvas id="chartComprasMes"></canvas>
            </div>
            </div>

            <!-- Categorías más compradas -->
            <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold">Categorías más compradas</h3>
            </div>
            <div class="card-canvas w-2/3 mx-auto">
                <canvas id="chartCategorias"></canvas>
            </div>
        </div>
    </div>

    <div class="flex justify-start gap-4">
        <button id="btnDeudaTotal" class=" text-gray-800 rounded-md border-2 border-indigo-400 shadow-sm hover:bg-gray-100 focus:ring-1 focus:ring-indigo-400 !py-4 !px-6 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-2xl text-blue-400">payments</span>
            <span class="font-medium text-2xl uppercase text-blue-400">Deuda total: <span id="totalDeudaText" class="text-gray-800">$<?php echo number_format($cliente->totaldebe??0, 0, ',', '.'); ?></span></span>
        </button>
        <button id="btnPagoDeudaTotal" class=" text-gray-800 rounded-md border-2 border-indigo-400 shadow-sm hover:bg-gray-100 focus:ring-1 focus:ring-indigo-400 !py-4 !px-6 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-2xl text-blue-400">check</span>
            <span class="font-medium text-2xl uppercase text-blue-400">Pago total</span>
        </button>
        <button id="btnTotalCuotas" class=" text-gray-800 rounded-md border-2 border-indigo-400 shadow-sm hover:bg-gray-100 focus:ring-1 focus:ring-indigo-400 !py-4 !px-6 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-2xl">payments</span>
            <span class="font-medium text-2xl uppercase">Cuotas</span>
        </button>

    </div>

    <!-- Historial de creditos -->
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="text-2xl font-bold mb-4">Historial de creditos</h2>
        <table id="tablaCreditos" class="tabla">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Emisor</th>
                    <th class="p-3">Fecha</th>
                    <th class="p-3">Tipo</th>
                    <th class="p-3">Credito</th>
                    <th class="p-3">N° Cuota</th>
                    <th class="p-3">Saldo pendiente</th>
                    <th class="p-3">Estado</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($creditos as $value): ?>
                <tr class="border-b">
                    <td class=""><?php echo $value->nombreEmisor??'Negocio';?></td>
                    <td class=""><?php echo $value->created_at;?></td>
                    <td class=""><?php echo $value->idtipofinanciacion==1?'Credito':'Separado';?></td>
                    <td class="">$<?php echo number_format($value->capital,'2', ',', '.'); ?></td>
                    <td class=""><?php echo $value->numcuota;?></td>
                    <td class="<?php echo $value->saldopendiente>0?'text-red-500':'';?>">$<?php echo number_format($value->saldopendiente,'2', ',', '.'); ?></td>
                    <td class="pendiente"><?php echo $value->idestadocreditos==1?'Finalizado':($value->idestadocreditos==2?'Abierto':'Anulado');?></td>
                    <td class="accionestd">
                        <div class="acciones-btns" id="<?php echo $value->id;?>" data-saldopendiente="<?php echo $value->saldopendiente;?>" data-montocuota="<?php echo $value->montocuota;?>">
                            <button class="btn-xs btn-lima abonarCredito" title="Abonar al credito"><i class="fa-solid fa-dollar-sign"></i></button>
                            <a class="btn-xs btn-bluedark" href="/admin/creditos/detallecredito?id=<?php echo $value->id;?>" target="_blank" title="Ver detalle del credito"><i class="fa-solid fa-chart-simple"></i></a>
                            <?php if($value->idtipofinanciacion==2&&$value->idestadocreditos==2): ?>
                            <button class="btn-xs btn-red anularCredito" title="Eliminar el credito"><i class="fa-solid fa-trash-can"></i></button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</div>

<?php include __DIR__ . "/abonoCredito.php"; ?>

<dialog id="miDialogoTotalCuotas" class="midialog-md p-12">
    <div class="flex justify-between items-center mb-4">
        <h4 id="modalTotalCuotas" class="font-semibold text-gray-700 mb-4">Todas las cuotas</h4>
        <button class="rounded-lg bg-indigo-500 hover:bg-indigo-700 transition"><i id="btnCerrarTotalCuotas" class="fa-solid fa-xmark px-4 py-2 text-3xl text-white"></i></button>
    </div>
    <div id="divmsjalerta"></div>
    <!-- TABLA DE INSUMOS -->
    <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
        <table id="tablaCuotas"
            class="w-full text-left border-collapse">
            <thead
                class="bg-indigo-100 text-indigo-800 uppercase text-base tracking-wide">
                <tr>
                    <th class="px-5 py-3 border-b border-gray-200">N° Credito</th>
                    <th class="px-5 py-3 border-b border-gray-200">Credito total</th>
                    <th class="px-5 py-3 border-b border-gray-200">N° Cuota</th>
                    <th class="px-5 py-3 border-b border-gray-200">Valor cuota</th>
                    <th class="px-5 py-3 border-b border-gray-200">Fecha pago</th>
                    <th class="px-5 py-3 border-b border-gray-200">Estado credito</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-lg divide-y divide-gray-100">
                <!-- Filas dinámicas -->
            </tbody>
        </table>
    </div>
</dialog>


<dialog id="miDialogoPagoTotal" class="midialog-sm p-12">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h4 id="modalPagoTotal" class="font-semibold text-gray-700 mb-4">Pago total</h4>
        <button class="rounded-lg bg-indigo-500 hover:bg-indigo-700 transition"><i id="btnCerrarPagoTotal" class="fa-solid fa-xmark px-4 py-2 text-3xl text-white"></i></button>
    </div>
    <div id="divmsjalerta1"></div>
    <form id="formPagoTotalDeuda" class="formulario">
        
        <p class="text-gray-600 text-3xl text-center font-light m-0">Total a pagar $: <span class="text-gray-700 font-semibold">$<?php echo number_format($cliente->totaldebe??0, 0, ',', '.'); ?></span></p>
        

        <div class="formulario__campo">
            <label class="formulario__label" for="caja">Caja</label>
            <select id="PagoTotal_caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="cajaid" required>
                <?php foreach($cajas as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="mediopago">Medio de pago</label>
            <select id="PagoTotal_mediopago" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="mediopagoid" required>
                <?php foreach($mediospago as $value):  ?>
                      <option value="<?php echo $value->id;?>" ><?php echo $value->mediopago;?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-right border-t border-gray-200 pt-12 mt-8">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Salir">Salir</button>
            <input id="btnFormPagoTotalDeuda" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Confirmar">
        </div>
    </form>
</dialog>

<script>
    const getParam = <?= json_encode($conflocal) ?>;
    let deudatotalCiente = <?= json_encode($cliente->totaldebe) ?>
</script>
