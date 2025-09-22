<div class="bg-white p-6 rounded-lg shadow detallecierrecaja">
    <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <h4 class="text-gray-600 my-2">Detalle del cierre de caja</h4>
    <div class="flex flex-wrap gap-2 mb-6 pt-6 border-t-2 border-blue-600">
        <button id="btnImprimirDetalleCaja" class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
        <button class="btn-command"><span class="material-symbols-outlined">email</span>Enviar notificacion</button>
    </div>
    <div class="accordion">
      <input type="checkbox" id="first">
      <label class="etiqueta text-gray-500 mb-4" for="first">Resumen</label>  

                <div class="flex flex-col tlg:flex-row gap-12 mb-8">
                    <div class="tlg:basis-1/2">

                    <div class="flex gap-4 mb-4">
                        <div>
                            <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Caja: </p>
                            <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Cajero: </p>
                            <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Fecha inicio: </p>
                            <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Fecha cierre: </p>
                        </div>
                        <div>
                            <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $ultimocierre->nombrecaja;?></p>
                            <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $user['nombre'];?></p>
                            <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $ultimocierre->fechainicio;?></p>
                            <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $ultimocierre->fechacierre;?></p>
                        </div>
                    </div>

                        <table class="tabla2" width="100%" id="">
                            <thead>
                                <tr>
                                    <th>Cuadre de caja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>        
                                    <td class="">Base + ingresos de caja</td> 
                                    <td class="">+ $<?php echo number_format($ultimocierre->basecaja??0, "0", ",", ".");?></td>
                                </tr>
                                <tr>        
                                    <td class="">Ventas en efectivo</td> 
                                    <td class="">+ $<?php echo number_format($ultimocierre->ventasenefectivo??0, "0", ",", ".");?></td>
                                </tr>
                                <tr>        
                                    <td class="">Gastos de la caja</td> 
                                    <td class="">- $<?php echo number_format($ultimocierre->gastoscaja??0, "0", ",", ".");?></td>
                                </tr>
                                <tr>        
                                    <td class="text-blue-400 font-medium">Dinero en caja</td> 
                                    <td class="text-blue-400 font-medium">= $<?php echo number_format($ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja??0, "0", ",", ".");?></td>
                                </tr>
                                <tr>        
                                    <td class="">Domicilios</td> 
                                    <td class="">- $<?php echo number_format($ultimocierre->domicilios??0, "0", ",", ".");?></td>
                                </tr>
                                <tr>        
                                    <td class="text-blue-600 font-medium">Real en caja</td> 
                                    <td class="text-blue-600 font-medium">= $<?php echo number_format($ultimocierre->basecaja+$ultimocierre->ventasenefectivo-$ultimocierre->gastoscaja-$ultimocierre->domicilios??0, "0", ",", ".");?></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- DETALLE DE IMPUESTOS-->
                        <div class="mt-32 mb-12">
                            <p class="text-sky-400 font-medium">Detalle de Impuestos</p>
                            <table class="tabla2" width="100%" id="tablaMediosPago">
                                <thead>
                                    <tr>
                                        <th>Tarifa</th>
                                        <th>Base Gravable</th>
                                        <th>Impuesto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($discriminarimpuesto as $index => $value): ?>
                                    <tr>
                                        <td class=""><?php echo $value['tarifa'];?>%</td>     
                                        <td class=""><strong>$ </strong><?php echo number_format($value['basegravable'], '2', ',', '.');?></td>
                                        <td class=""><strong>$ </strong><?php echo number_format($value['valorimpuesto'], "2", ",", ".");?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tlg:basis-1/2">
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
                                <tr>        
                                    <td class="">Impuesto</td> 
                                    <td class=""> - $0</td>
                                </tr>
                                <tr>        
                                    <td class="text-blue-600 font-medium">Total bruto</td> 
                                    <td class="text-blue-600 font-medium"> = $<?php echo number_format($ultimocierre->ingresoventas??0, "0", ",", ".");?></td>
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
                        
                        <div>
                            <p class="text-sky-400 font-medium">Analisis Sobrantes y Faltantes</p>
                            <table class="tabla2 mb-12" width="100%" id="">
                                <thead>
                                    <tr>
                                        <th>Medios de pago</th>
                                        <th> Sisitema </th>
                                        <th> Valor declarado </th>
                                        <th> Diferencia </th>
                                    </tr>
                                </thead>
                                <tbody class="cuerpoanalisis">
                                    <?php foreach($sobrantefaltante as $index => $value): ?>
                                    <tr class="<?php echo $value->nombremediopago=='Efectivo'?'!border-2 !border-indigo-600':'';?>">        
                                        <td class=""><?php echo $value->nombremediopago;?></td> 
                                        <td class="colsistem"><?php echo number_format($value->valorsistema, "0", ",", ".");?></td>
                                        <td class="coldeclarado" data-mediopagoid="<?php echo $value->id_mediopago;?>"><?php echo number_format($value->valordeclarado, "0", ",", ".");?></td>
                                        <td class="coldif"><?php echo number_format($value->valordeclarado-$value->valorsistema, "0", ",", ".");?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <table class="tabla2 mb-12" width="100%" id="">
                            <thead>
                                <tr>
                                    <th>Ventas por usuario</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ventasxusuarios as $index => $value): ?>
                                <tr>        
                                    <td class=""><?php echo $value['Nombre'];?></td> 
                                    <td class=""><?php echo $value['N_ventas'];?></td>
                                    <td class=""><strong>$ </strong><?php echo number_format($value['ventas'], "0", ",", ".");?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    
                    </div>
                </div>

                <h5 class="text-gray-500 border border-gray-300 px-4 py-3 mb-4">Ventas del dia</h5>
                <!-- Facturas del dia -->
                <table class="display responsive nowrap tabla" width="100%" id="">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Factura</th>
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
                            <td class="<?php echo $value->estado=='Paga'?'btn-xs btn-lima':'btn-xs btn-blueintense';?>"><?php echo $value->estado;?></td>
                            <td class=""><?php echo number_format($value->subtotal??0, "0", ",", ".");?></td>
                            <td class=""><?php echo number_format($value->total??0, "0", ",", ".");?></td>
                            <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                                    <a class="btn-xs btn-turquoise" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">Ver</a> <button class="btn-xs btn-light"><i class="fa-solid fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
      
    </div> <!-- fin accordion-->
</div>