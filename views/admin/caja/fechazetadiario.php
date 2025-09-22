<div class="fechazetadiario relative bg-white p-12 rounded-lg shadow">
    <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>
    <a href="/admin/caja/zetadiario" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <h4 class="text-gray-600 my-2">Detalle del zeta diario</h4>

    <div class="mt-6 mb-20 flex justify-between flex-col gap-8 lg:flex-row md:gap-4 w-full lg:w-auto">
        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-auto p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="datetimes" />
        <div class="content-dropdawn !w-full md:!w-auto">
            <div class="btnmultiselect 
                bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg 
                focus:border-indigo-600 block !w-full md:w-auto 
                p-2.5 dark:bg-gray-600 dark:border-gray-500 
                dark:placeholder-gray-400 dark:text-white 
                h-14 text-xl focus:outline-none focus:ring-1">
                <span class="btnmultiselect-text">Seleccionar Caja</span>
                <span class="arrow !bg-indigo-600"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
            <ul class="list-items z-10 hidden bg-white rounded-lg shadow-sm dark:bg-gray-700 !mt-0 !pl-0 !pt-4 !pr-0 !min-w-0 !w-full md:w-auto">
                <?php foreach($cajas as $value): ?>
                <li class="flex items-center gap-2 p-3 text-lg text-gray-700 dark:text-gray-200 w-auto">
                    <input class="caja scale-125" type="checkbox" id="caja<?php echo $value->id;?>" value="<?php echo $value->id;?>" checked>
                    <label class="text-xl" for="caja<?php echo $value->id;?>"><?php echo $value->nombre;?></label>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="content-dropdawn w-auto">
            <div class="btnmultiselect bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                <span class="btnmultiselect-text">Seleccionar Facturador</span>
                <span class="arrow !bg-indigo-600"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
            <ul class="list-items z-10 hidden bg-white rounded-lg shadow-sm dark:bg-gray-700 !mt-0 !pl-0 !pt-4 !pr-0 w-full !min-w-0">
                <?php foreach($consecutivos as $value): ?>
                <li class="flex items-center gap-2 p-3 text-lg text-gray-700 dark:text-gray-200 w-auto">
                    <input class="facturador scale-125" type="checkbox" id="<?php echo $value->id;?>" value="<?php echo $value->id;?>" checked>
                    <label class="text-xl" for="<?php echo $value->id;?>"><?php echo $value->nombre;?></label>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button id="consultarZDiario" class="btn-md border border-gray-300 text-white !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 bg-indigo-600 hover:bg-indigo-800">Consultar</button>
    </div>

    <div class="flex flex-wrap gap-2 mb-6 pt-6 border-t-2 border-blue-600">
        <button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
        <button class="btn-command"><span class="material-symbols-outlined">email</span>Enviar notificacion</button>
    </div>

    <div class="mt-8">
      <label class="text-[17px] text-gray-500 text-center block mb-8" for="first">Resumen</label>

        <div class="flex flex-col tlg:flex-row gap-12 mb-8">
            <div class="tlg:basis-1/2">
                <div class="flex gap-4 mb-4">
                    <div>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Caja: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Fecha inicio: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Fecha cierre: </p>
                    </div>
                    <div>
                        <p id="cajastext" class="m-0 text-slate-500 text-xl leading-loose"> <?php echo $cajaselected;?><span class="text-transparent">.</span></p>
                        <p id="fechainicio" class="m-0 text-slate-500 text-xl leading-loose"> <?php echo $cierreselected->fechainicio??''; ?> </p>
                        <p id="fechafin" class="m-0 text-slate-500 text-xl leading-loose"> <?php echo $cierreselected->fechacierre??''; ?> </p>
                    </div>
                </div>

                <table class="tabla2 mb-12" width="100%" id="tablaMediosPago">
                    <thead>
                        <tr>
                            <th>Medios de pago</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- se inserta datos desde fechazetadiario.ts -->
                        <?php foreach($discriminarmediospagos as $value):  ?>
                            <tr>
                                <td class=""><?php echo $value['mediopago']; ?></td> 
                                <td class="">$<?php echo number_format($value['valor'], '0', ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- DETALLE DE IMPUESTOS-->
                <div class="mt-16 mb-12">
                    <p class="text-sky-400 font-medium">Detalle tributario</p>
                    <table class="tabla2" width="100%" id="tablaMediosPago">
                        <thead>
                            <tr>
                                <th>Tarifa</th>
                                <th>Base Gravable</th>
                                <th>Impuesto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($discriminarimpuestos as $index => $value): ?>
                            <tr>
                                <td class=""><?php echo $value['tarifa']!=null?$value['tarifa'].'%':'Excluido';?></td>     
                                <td class=""><strong>$ </strong><?php echo number_format($value['basegravable'], '2', ',', '.');?></td>
                                <td class=""><strong>$ </strong><?php echo number_format($value['valorimpuesto'], "2", ",", ".");?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th>Consolidado de Impuesto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>        
                            <td class="">Base Total: </td>
                            <td id="base" class=""> $<?php echo $cierreselected?number_format($cierreselected->ingresoventas-$cierreselected->valorimpuestototal, '0', ',', '.'):'0'; ?></td>
                        </tr>
                        <tr>        
                            <td class="">Impuesto Total: </td> 
                            <td id="valorImpuestoTotal" class=""> $<?php echo number_format($cierreselected->valorimpuestototal??'0','0', ',', '.');?></td>
                        </tr>
                        
                    </tbody>
                </table>

                
            </div>

            <div class="tlg:basis-1/2">
                
                <table class="tabla2" width="100%" id="">
                    <thead>
                        <tr>
                            <th>Datos de venta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>        
                            <td class="">Ingreso de ventas</td> 
                            <td id="ingresoVentas" class=""> + $<?php echo number_format($cierreselected->ingresoventas??'0', '0', ',', '.');?></td>
                        </tr>
                        <tr>        
                            <td class="">Total descuentos</td> 
                            <td id="totalDescuentos" class=""> - $<?php echo number_format($cierreselected->totaldescuentos??'0', '0', ',', '.');?></td>
                        </tr>
                        <tr>        
                            <td class="text-blue-400 font-medium">Real de ventas</td> 
                            <td id="realVentas" class="text-blue-400 font-medium"> = $<?php echo number_format($cierreselected->realventas??'0', '0', ',', '.');?></td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th>Tipo de facturas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>      
                            <td class="">Facturas electronicas</td> 
                            <td id="cantidadElectronicas" class=""><?php echo $cierreselected->facturaselectronicas??'0';?></td>
                        </tr>
                        <tr>        
                            <td class="">Facturas POS</td> 
                            <td id="cantidadPOS" class=""><?php echo $cierreselected->facturaspos??'0';?></td>
                        </tr>
                        <tr>        
                            <td class="">Total facturas</td> 
                            <td id="cantidadPOS" class=""><?php echo $cierreselected?number_format($cierreselected->facturaspos+$cierreselected->facturaselectronicas, '0', ',', '.'):'0';?></td>
                        </tr>
                    </tbody>
                </table>
            
                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th>Ingreso por tipo de facturas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>        
                            <td class="">Facturas electronicas</td> 
                            <td id="valorElectronicas" class="">$<?php echo number_format($cierreselected->valorfe??0, '0', ',', '.');?></td>
                        </tr>
                        <tr>        
                            <td class="">Facturas POS</td> 
                            <td id="valorPOS" class="">$<?php echo number_format($cierreselected->valorpos??0, '0', ',', '.');?></td>
                        </tr>
                    </tbody>
                </table>
            
            </div>
        </div>   
      
    </div> <!-- fin accordion-->
</div>