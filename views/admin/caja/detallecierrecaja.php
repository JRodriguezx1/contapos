<div class="bg-white p-6 rounded-lg shadow detallecierrecaja">
    <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <h4 class="text-gray-600 my-2">Detalle del cierre de caja</h4>
    <div class="flex flex-wrap gap-2 mb-6 pt-6 border-t-2 border-blue-600">
        <button id="btnImprimirDetalleCaja" class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
        <button id="btnVerCierreWeb" class="btn-command"><span class="material-symbols-outlined">developer_mode_tv</span>Visualizar cierre</button>
        <button class="btn-command"><span class="material-symbols-outlined">email</span>Enviar notificacion</button>
    </div>
    <div class="accordion pb-20">
       <input type="checkbox" id="first">
       <label class="etiqueta text-sky-400 text-center  font-bold uppercase" for="first">Resumen</label>  

        <div class="flex flex-col tlg:flex-row gap-12 mb-8">
            <div class="tlg:basis-1/2">

                <div class="flex gap-4 mb-4">
                    <div>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Cierre de caja: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Caja: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Cajero: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Fecha inicio: </p>
                        <p class="m-0 text-slate-500 text-xl font-semibold leading-loose">Fecha cierre: </p>
                    </div>
                    <div>
                        <p class="m-0 text-slate-500 text-xl leading-loose">ID - <?php echo $ultimocierre->id;?></p>
                        <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $ultimocierre->nombrecaja;?></p>
                        <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $user['nombre'];?></p>
                        <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $ultimocierre->fechainicio;?></p>
                        <p class="m-0 text-slate-500 text-xl leading-loose"><?php echo $ultimocierre->fechacierre;?></p>
                    </div>
                </div>

                <table class="tabla2" width="100%" id="">
                    <thead>
                        <tr>
                            <th colspan="2" class="w-full bg-gray-100 text-gray-700 p-3 text-center">Cuadre de caja</th>
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
                            <td class="">Abonos en efectivo</td> 
                            <td id="abonosEfectivo" class="">+ $<?php echo number_format($ultimocierre->abonosenefectivo??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Gastos de la caja</td> 
                            <td class="">- $<?php echo number_format($ultimocierre->gastoscaja??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="text-blue-400 font-medium">Dinero en caja</td> 
                            <td class="text-blue-400 font-medium">= $<?php echo number_format($ultimocierre->basecaja+$ultimocierre->ventasenefectivo+($ultimocierre->abonosenefectivo??0)-$ultimocierre->gastoscaja??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Domicilios</td> 
                            <td class="">- $<?php echo number_format($ultimocierre->domicilios??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="text-blue-600 font-medium">Real en caja</td> 
                            <td class="text-blue-600 font-medium">= $<?php echo number_format($ultimocierre->basecaja+$ultimocierre->ventasenefectivo+($ultimocierre->abonosenefectivo??0)-$ultimocierre->gastoscaja-$ultimocierre->domicilios??0, "0", ",", ".");?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- DETALLE DE IMPUESTOS-->
                <div class="mt-32 mb-12">
                    <p class="text-sky-400 text-center  font-bold">Detalle de Impuestos</p>
                    <table class="tabla2" width="100%" id="tablaMediosPago">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 p-3 text-center">
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

                <!-- DETALLE GASTOS DE LA CAJA-->
                <div class="mt-32 mb-12">
                    <p class="text-sky-400 text-center  font-bold">Detalle gastos de la caja</p>
                    <table class="tabla2" width="100%" id="tablaMediosPago">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 p-3 text-center">
                                <th>Categoria gasto</th>
                                <th>Valor gasto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($discriminargastos as $index => $value): ?>
                            <tr>
                                <td class=""><strong><?php echo $value['nombre'];?></td>
                                <td class=""><strong>$ </strong><?php echo number_format($value['valorgasto'], "2", ",", ".");?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- DETALLE ABONOS-->
                <div class="mt-32 mb-12">
                    <table class="tabla2" width="100%" id="tablaAbonos">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 p-3 text-center">
                                <th>Abonos</th>
                                <th>Abonos separados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class=""><strong>$ </strong><?php echo number_format($ultimocierre->abonos??0, "0", ",", ".");?></td>
                                <td class=""><strong>$ </strong><?php echo number_format($ultimocierre->abonosseparados??0, "0", ",", ".");?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tlg:basis-1/2">
                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th colspan="2" class="w-full bg-gray-100 text-gray-700 p-3 text-center">Medios de pagos</th>
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
                            <th colspan="2" class="w-full bg-gray-100 text-gray-700 p-3 text-center">Datos de venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>        
                            <td class="">Ingreso de ventas total</td> 
                            <td id="ingresoVentasTotal" class=""> + $<?php echo number_format(($ultimocierre->ingresoventas??0)+($ultimocierre->totaldescuentos??0), "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Abonos totales</td> 
                            <td id="abonosTotales" class=""> + $<?php echo number_format(($ultimocierre->abonostotales??0), "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Total gastos de caja</td> 
                            <td id="totalGastosCaja" class=""> - $<?php echo number_format($ultimocierre->gastoscaja??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Total descuentos</td> 
                            <td id="totalDescuentos" class=""> - $<?php echo number_format($ultimocierre->totaldescuentos??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Total domicilios</td> 
                            <td id="totalDomicilios" class=""> - $<?php echo number_format($ultimocierre->domicilios??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="text-blue-400 font-medium">Real ingreso de ventas</td> 
                            <td id="realVentas" class="text-blue-400 font-medium"> = $<?php echo number_format(($ultimocierre->ingresoventas??0)-($ultimocierre->totaldescuentos??0)-($ultimocierre->domicilios??0)-($ultimocierre->gastoscaja??0), "0", ",", ".");?></td>
                        </tr>
                        
                        <tr>        
                            <td class="text-blue-600 font-medium">Base grabable</td> 
                            <td id="totalBaseGravable" class="text-blue-600 font-medium"> = $<?php echo number_format($ultimocierre->basegravable??0, "0", ",", ".");?></td>
                        </tr>
                        <tr>        
                            <td class="">Impuesto Total</td> 
                            <td id="impuestoTotal" class=""> - $<?php echo number_format($ultimocierre->valorimpuestototal??0, "2", ",", ".");?></td>
                        </tr>
                        <tr>     
                            <td class="text-gray-700 font-medium">Gastos otros/bancarios</td> 
                            <td id="otrosGastosBancarios" class="text-gray-700 font-medium"> - $<?php echo number_format($ultimocierre->gastosbanco??0, "0", ",", ".");?></td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="tabla2 mb-12" width="100%" id="">
                    <thead>
                        <tr>
                            <th colspan="2" class="w-full bg-gray-100 text-gray-700 p-3 text-center">Tipo de facturas</th>
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
                
                <div class="overflow-x-auto">
                    <p class="text-sky-400 font-bold text-center">Analisis Sobrantes y Faltantes</p>
                    <table class="tabla2 mb-12 min-w-[500px]" width="100%" id="">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 p-3 text-center">
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
                        <tr class="bg-gray-100 text-gray-700 p-3 text-center">
                            <th>Ventas por usuario</th>
                            <th>N°</th>
                            <th>Total</th>
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

        <h5 class="text-sky-400 font-bold uppercase text-center mb-3">Ventas del dia</h5>
        <!-- Facturas del dia -->
        <div class="overflow-x-auto">
            <table class="display responsive nowrap tabla w-full min-w-[700px]" width="100%" id="">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-center">
                        <th class="p-2">N.</th>
                        <th class="p-2">Fecha</th>
                        <th class="p-2">Cliente</th>
                        <th class="p-2">Factura</th>
                        <th class="p-2">Estado</th>
                        <th class="p-2">Subtotal</th>
                        <th class="p-2">Total</th>
                        <th class="p-2 accionesth">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($facturas as $index => $value): ?>
                    <tr> 
                        <td class=""><?php echo $index+1;?></td>        
                        <td class=""><?php echo $value->fechapago;?></td> 
                        <td class=""><?php echo $value->cliente;?></td> 
                        <td class=""><?php echo $value->id;?></td>
                        <td class=""><div class="btn-xs <?php echo $value->estado=='Paga'&&$value->tipoventa=='Contado'?'btn-lima':($value->estado=='Paga'&& $value->tipoventa=='Credito'?'btn-green':($value->estado=='Guardado'?'btn-turquoise':'btn-light'));?>"><?php echo ($value->tipoventa =='Contado'||$value->tipoventa =='')?$value->estado:'Credito';?></div></td>
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
        </div>
      
    </div> <!-- fin accordion-->
</div>