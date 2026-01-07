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
                    <span class="text-lg font-medium text-gray-900"><?php echo $cliente->telefono ?></span>
                </p>
            </div>

            <!-- Columna derecha -->
            <div class="space-y-2">
                <p class="flex items-center gap-3 mb-0">
                    <span class="font-semibold text-base text-gray-500">Última compra:</span>
                    <span class="text-lg font-medium text-gray-900"><?php echo $cliente->ultima_compra;?></span>
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
            <p class="text-base text-gray-500">🛒 Total de compras</p>
            <p class="text-3xl lg:text-4xl font-bold"><?php echo $indicadores->cantidad_ventas??0;?></p>
        </div>
        <div class="bg-white rounded-2xl p-2 shadow text-center border-b-4 border-indigo-600">
            <p class="text-base text-gray-500">💰 Monto total gastado</p>
            <p class="text-3xl lg:text-4xl font-bold">$ <?php echo number_format($indicadores->total_ventas_cliente??0, 2, ',', '.');?></p>
        </div>
        <div class="bg-white rounded-2xl p-2 shadow text-center border-b-4 border-yellow-600">
            <p class="text-base text-gray-500">📊 Ticket promedio</p>
            <p class="text-3xl lg:text-4xl font-bold">$ <?php echo number_format($indicadores->ticket_promedio??0, 2, ',', '.');?></p>
        </div>
        <div class="bg-white rounded-2xl p-2 shadow text-center border-b-4 border-red-600">
            <p class="text-base text-gray-500">🏷️ Productos comprados</p>
            <p class="text-3xl lg:text-4xl font-bold"><?php echo $indicadores->total_productos_comprados??0;?></p>
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

    <!-- Historial de creditos -->
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="text-2xl font-bold mb-4">Historial de creditos</h2>
        <table id="tablaCreditos" class="tabla">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Fecha</th>
                    <th class="p-3">Tipo</th>
                    <th class="p-3">Credito</th>
                    <th class="p-3">Cuota</th>
                    <th class="p-3">N° Cuota</th>
                    <th class="p-3">Saldo pendiente</th>
                    <th class="p-3">Estado</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($creditos as $value): ?>
                <tr class="border-b">
                    <td class=""><?php echo $value->created_at;?></td>
                    <td class=""><?php echo $value->idtipofinanciacion==1?'Credito':'Separado';?></td>
                    <td class="">$<?php echo number_format($value->capital,'2', ',', '.'); ?></td>
                    <td class="">$<?php echo number_format($value->montocuota,'2', ',', '.'); ?></td>
                    <td class=""><?php echo $value->numcuota;?></td>
                    <td class="">$<?php echo number_format($value->saldopendiente,'2', ',', '.'); ?></td>
                    <td class=""><?php echo $value->idestadocreditos==1?'Finalizado':($value->idestadocreditos==2?'Abierto':'Anulado');?></td>
                    <td class="accionestd">
                        <div class="acciones-btns" id="<?php echo $value->id;?>">
                            <a class="btn-xs btn-bluedark" href="/admin/creditos/detallecredito?id=<?php echo $value->id;?>" target="_blank" title="Ver detalle del credito"><i class="fa-solid fa-chart-simple"></i></a>
                            <?php if($value->idtipofinanciacion==2): ?>
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
