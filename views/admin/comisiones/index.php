<div class="box comisiones">
    <h4 class="text-gray-800 mb-8 mt-4">Comisiones</h4>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="shadow rounded-xl p-6">
            <p class="text-sm font-medium text-slate-500 uppercase">Comisiones Totales</p>
            <p class="text-2xl font-bold text-slate-900">$<?php echo number_format($widgets[0]->comisiontotal, 0, ',', '.'); ?></p>
        </div>

        <div class="shadow rounded-xl p-6">
            <p class="text-sm font-medium text-slate-500 uppercase">Anticipos Entregados</p>
            <p class="text-2xl font-bold text-red-600">-$<?php echo number_format($widgets[1]->comisiontotalpagada, 0, ',', '.'); ?></p>
        </div>

        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm">
            <p class="text-sm font-medium text-blue-600 uppercase">Saldo a Liquidar</p>
            <p class="text-2xl font-bold text-blue-900">$<?php echo number_format($widgets[0]->comisiontotal-$widgets[1]->comisiontotalpagada, 0, ',', '.'); ?></p>
        </div>
    </div>

    <div class="p-4 rounded-xl border border-slate-200 shadow-sm mb-8">
        <div class="mb-6 flex flex-wrap items-end gap-4">
            <div class="w-full xs:w-1/2">
                <label class="block text-base font-semibold text-slate-500 uppercase mb-1">Empleado</label>
                <select id="selectEmpleado" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-indigo-600 block p-3 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Seleccionar empleado...</option>
                    <?php foreach($usuarios as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->nombre.' '.$value->apellido;?></option>
                    <?php endforeach;  ?>
                </select>
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-500 uppercase mb-1">Periodo</label>
                <!-- Input y botón consultar -->
                <div class="flex items-center gap-3">
                    <input 
                        type="text" 
                        name="datetimes" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-indigo-600 block w-60 lg:w-80 p-3 text-base     focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Seleccionar fecha"
                    />
                    <button id="consultarFechaPersonalizada" class="px-6 py-3 text-base font-medium bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-md transition">
                        Consultar
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-4">
            <div class="lg:col-span-3 p-6 rounded-xl border-l-4 border-l-blue-600 border border-slate-200 shadow-sm flex justify-between items-center">
                <div class="flex gap-8 flex-wrap">   
                    <div>
                        <h4 class="text-base text-slate-500 font-medium">Total comisiones</h4>
                        <p id="comisiontotalUser" class="text-2xl font-bold text-slate-900 leading-none mt-1">$</p>
                    </div>
                    <div>
                        <h4 class="text-base text-slate-500 font-medium">Total pagado</h4>
                        <p id="comisionTotalUserPagada" class="text-2xl font-bold text-green-600 leading-none mt-1">$</p>
                    </div>
                    <div>
                        <h4 class="text-base text-slate-500 font-medium">Saldo por Liquidar</h4>
                        <p id="comisionUserPendiente" class="text-2xl font-bold text-red-600 leading-none mt-1">$</p>
                    </div>
                </div>
                
                <div class="flex gap-3 font-medium text-base">
                    <button class="btn-xs bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition-colors">Dar Anticipo</button>
                    <button id="btnLiquidar" class="btn-xs btn-green">Liquidar Saldo</button>
                </div>
            </div>

            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                <h4 class="text-lg font-bold text-slate-400 uppercase tracking-wider mb-3">Rendimiento</h4>
                <div class="space-y-2">
                    <div class="flex justify-between text-base">
                        <span class="text-slate-600">Ventas Realizadas:</span>
                        <span class="font-bold text-slate-800"></span>
                    </div>
                    <div class="flex justify-between text-base">
                        <span class="text-slate-600">Tasa de Comisión:</span>
                        <span class="font-bold text-slate-800"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
            <h4 id="textNameUser" class="font-semibold text-slate-700">Detalle de Movimientos</h4>
            <button class="btn-xs btn-blue">Registrar Anticipo / Pago</button>
        </div>
        
        <div class="overflow-x-auto">
            <table id="tablaMovimientosComisiones" class="display responsive nowrap tabla" width="100%">
                <thead class="bg-slate-100 text-slate-700 uppercase text-xl">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Concepto</th>
                        <th class="px-6 py-3">Crédito (+)</th>
                        <th class="px-6 py-3">Débito (-)</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-lg">
                    <!--<tr>
                        <td class="px-6 py-4">10 Abr 2026</td>
                        <td class="px-6 py-4">
                            <span class="block font-medium text-slate-900">Venta #FAC-1025</span>
                            <span class="text-xs text-slate-400">Cliente: Empresa ABC</span>
                        </td>
                        <td class="px-6 py-4 text-green-600 font-medium">+$45.00</td>
                        <td class="px-6 py-4">-</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase">Pendiente</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4">08 Abr 2026</td>
                        <td class="px-6 py-4">
                            <span class="block font-medium text-slate-900">Anticipo de Quincena</span>
                            <span class="text-xs text-slate-400">Ref: Transf. 9982</span>
                        </td>
                        <td class="px-6 py-4">-</td>
                        <td class="px-6 py-4 text-red-600 font-medium">-$100.00</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase">Entregado</span>
                        </td>
                    </tr>-->
                </tbody>
            </table>
        </div>
    </div>


    <!-- MODAL PARA CAMBIAR USUARIO Y COMSION DE VENTA -->
    <?php include __DIR__. "/modalLiquidar.php"; ?>


</div>