<div class="fechazetadiario">
    <a href="/admin/caja/zetadiario" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <h4 class="text-gray-600 my-2">Detalle del zeta diario</h4>

    <div class="mt-6 mb-20 flex justify-between">
        <input type="text" class="border border-gray-500 rounded-lg text-lg leading-4 px-3 py-1 outline-cyan-500" name="datetimes" />
        <div class="content-dropdawn">
            <div class="btnmultiselect">
                <span class="btnmultiselect-text">Seleccionar Caja</span>
                <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
            <ul class="list-items">
                <?php foreach($cajas as $value): ?>
                <li class="item stylecheckbox border-radius05 border-greyclear p-08">
                    <input class="caja" type="checkbox" id="caja<?php echo $value->id;?>" value="<?php echo $value->id;?>" checked>
                    <label for="caja<?php echo $value->id;?>"><?php echo $value->nombre;?></label>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="content-dropdawn">
            <div class="btnmultiselect">
                <span class="btnmultiselect-text">Seleccionar Facturador</span>
                <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
            <ul class="list-items">
                <?php foreach($consecutivos as $value): ?>
                <li class="item stylecheckbox border-radius05 border-greyclear p-08">
                    <input class="facturador" type="checkbox" id="<?php echo $value->id;?>" value="<?php echo $value->id;?>" checked>
                    <label for="<?php echo $value->id;?>"><?php echo $value->nombre;?></label>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button id="consultarZDiario" class="btn-md btn-blueintense !py-4 px-6 !bg-indigo-600">Consultar</button>
    </div>

    <div class="flex flex-wrap gap-2 mb-6 pt-6 border-t-2 border-blue-600">
        <button class="btn-command"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
        <button class="btn-command"><span class="material-symbols-outlined">email</span>Enviar notificacion</button>
    </div>

    <div class="mt-8">
      <label class="text-[17px] text-gray-500 text-center block mb-8" for="first">Resumen</label>

        <div class="flex flex-col tlg:flex-row gap-12 mb-8">
            <div class="tlg:basis-1/2">

                <div class="flex gap-4 mb-4">
                    <div>
                        <p class="m-0 text-slate-500 text-xl font-semibold">Caja: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold">Fecha inicio: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold">Fecha cierre: </p>
                    </div>
                    <div>
                        <p class="m-0 text-slate-500 text-xl"><?php echo $ultimocierre->nombrecaja;?></p>
                        <p class="m-0 text-slate-500 text-xl"><?php echo $ultimocierre->fechainicio;?></p>
                        <p class="m-0 text-slate-500 text-xl"><?php echo $ultimocierre->fechacierre;?></p>
                    </div>
                </div>

                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th>Medios de pago</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($discriminarmediospagos as $index => $value): ?>
                        <tr>        
                            <td class=""><?php echo $value['mediopago'];?></td> 
                            <td class="">$ <?php echo number_format($value['valor'], "0", ",", ".");?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th>Detalle de impuesto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>        
                            <td class="">Base</td> 
                            <td class=""> - $0</td>
                        </tr>
                        <tr>        
                            <td class="">Impuesto</td> 
                            <td class=""> - $0</td>
                        </tr>
                        
                    </tbody>
                </table>

                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th>Detalle Bruto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>        
                            <td class="">Total Bruto</td> 
                            <td class=""> - $0</td>
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
                            <td class=""> + $<?php echo number_format($ultimocierre->ingresoventas??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Total descuentos</td> 
                            <td class=""> - $<?php echo number_format($ultimocierre->totaldescuentos??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="text-blue-400 font-medium">Real de ventas</td> 
                            <td class="text-blue-400 font-medium"> = $<?php echo number_format($ultimocierre->ingresoventas-$ultimocierre->totaldescuentos??0, "0", ",", ".");?></td>
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
                            <td class=""><?php echo number_format($ultimocierre->facturaselectronicas??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Facturas POS</td> 
                            <td class=""><?php echo number_format($ultimocierre->facturaspos??0, "0", ",", ".");?></td>
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
                            <td class=""><?php echo number_format($ultimocierre->facturaselectronicas??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Facturas POS</td> 
                            <td class=""><?php echo number_format($ultimocierre->facturaspos??0, "0", ",", ".");?></td>
                        </tr>
                    </tbody>
                </table>
            
            </div>
        </div>   
      
    </div> <!-- fin accordion-->
</div>