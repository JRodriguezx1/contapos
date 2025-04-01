<div>
    <a class="btn-xs btn-dark" href="/admin/caja/ultimoscierres">Atras</a>
    <h4 class="text-gray-600 my-2">Detalle del cierre de caja</h4>
    <div class="flex flex-wrap gap-2 mb-6 pt-6 border-t-2 border-blue-600">
        <button class="btn-command"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
        <button class="btn-command"><span class="material-symbols-outlined">email</span>Enviar notificacion</button>
    </div>
    <div class="accordion">
      <input type="checkbox" id="first">
      <label class="etiqueta text-gray-500" for="first">Resumen</label>
      <div class="wrapper">
          <div class="wrapper-content">
            

                <div class="flex flex-col tlg:flex-row gap-12 mb-8">
                    <div class="tlg:basis-1/2">

                    <div class="flex gap-4 mb-4">
                        <div>
                            <p class="m-0 text-slate-500 text-xl font-semibold">Caja: </p>
                            <p class="m-0 text-slate-500 text-xl font-semibold">Cajero: </p>
                            <p class="m-0 text-slate-500 text-xl font-semibold">Fecha inicio: </p>
                            <p class="m-0 text-slate-500 text-xl font-semibold">Fecha cierre: </p>
                        </div>
                        <div>
                            <p class="m-0 text-slate-500 text-xl"><?php echo $ultimocierre->nombrecaja;?></p>
                            <p class="m-0 text-slate-500 text-xl"><?php echo $user['nombre'];?></p>
                            <p class="m-0 text-slate-500 text-xl"><?php echo $ultimocierre->fechainicio;?></p>
                            <p class="m-0 text-slate-500 text-xl"><?php echo $ultimocierre->fechacierre;?></p>
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
                                    <td class=""><?php echo $value['valor'];?></td>
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
                                    <a class="btn-xs btn-turquoise" href="/admin/caja/detallepedido?id=<?php echo $value->id;?>">Ver</a> <button class="btn-xs btn-light"><i class="fa-solid fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
           
          </div> <!--fin wrpper-content-->
      </div> <!--fin wrapper -->
      
    </div> <!-- fin accordion-->
</div>