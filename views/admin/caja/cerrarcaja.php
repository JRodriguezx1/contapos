
<div class="relative pb-20">
    <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>
<div class="box cerrarcaja">
  <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
  <h4 class="text-gray-600 mb-12 mt-4">Cierre de caja</h4>
  <div class="flex gap-4">
    <div>
      <p class="m-0 text-slate-500 text-xl font-semibold">Caja: </p>
      <p class="m-0 text-slate-500 text-xl font-semibold">Fecha: </p>
      <p class="m-0 text-slate-500 text-xl font-semibold">Cajero: </p>
    </div>
    <div>
      <p id="nombreCaja" class="m-0 text-slate-500 text-xl">Caja principal</p>
      <p class="m-0 text-slate-500 text-xl"><?php echo date('Y-m-d');?></p>
      <p class="m-0 text-slate-500 text-xl"><?php echo $user['nombre'];?></p>
    </div>
  </div>
  <div class="flex flex-col tlg:flex-row tlg:items-start gap-4 mt-4">
    <div class="basis-1/3 border border-gray-300 p-4 declaracionvalores rounded-lg">
      <div class="formulario__campo">
          <label class="formulario__label" for="EF">Efectivo en caja</label>
          <div class="formulario__dato gap-x-[0.7rem]">
              <input id="Efectivo" 
                class="formulario__input inputmediopago bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
                type="text" 
                placeholder="Dinero en caja" 
                name="Efectivo" 
                data-idmediopago="1" 
                value=""
                oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()"
                required>
              <button class="btn-md btn-turquoise !py-auto !px-6" id="btnArqueocaja">Arqueo de caja</button>
          </div>
      </div>
      <?php foreach($mediospagos as $index => $value): 
        if($index>0):  ////////// declaracion de valores /////////?>
        <div class="formulario__campo">
          <label class="formulario__label" for="<?php echo $value->nick??'';?>"><?php echo $value->mediopago??'';?></label>
          
          <input class="formulario__input inputmediopago bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" 
            type="text" 
            placeholder="Dinero en <?php echo $value->mediopago??'';?>" 
            id="<?php echo $value->nick??'';?>" 
            name="<?php echo $value->mediopago??'';?>" 
            value=""
            data-idmediopago="<?php echo $value->id;?>"
            oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()"
            required
          >

        </div>
      <?php endif; endforeach; ?>
    </div> <!-- Fin col 1 -->
    <div class="basis-2/3 border-b border-gray-300 p-4 flex items-start gap-8 xxs:gap-20">
        <div class="flex gap-4">
          <div class="text-start">
          <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">ID:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Base en caja:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Gastos:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Domicilios:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-semibold">Ventas Total:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Nº Facturas:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Cotizaciones:</p>
          </div>
          <div>
          <p id="idCierrecaja" class="m-0 mb-2 text-slate-600 text-2xl font-normal"><?php echo $ultimocierre->id??'id';?></p>
            <p id="basecajaResumen" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$<?php echo number_format($ultimocierre->basecaja??0, "0", ",", ".");?></p>
            <p id="gastoscajaResumen" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$<?php echo number_format($ultimocierre->gastoscaja??0, "0", ",", ".");?></p>
            <p id="domiciliosResumen" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$<?php echo number_format($ultimocierre->domicilios??0, "0", ",", ".");?></p>
            <p id="ingresoventasResumen" class="m-0 mb-2 text-slate-600 text-2xl font-semibold">$<?php echo number_format($ultimocierre->ingresoventas??0, "0", ",", ".");?></p>
            <p id="totalfacturasResumen" class="m-0 mb-2 text-slate-600 text-2xl font-normal"><?php echo $ultimocierre->totalfacturas??0;?></p>
            <p id="totalcotizacionesResumen" class="m-0 mb-2 text-slate-600 text-2xl font-normal"><?php echo $ultimocierre->totalcotizaciones??0;?></p>
          </div>
        </div>
        <div class="flex flex-wrap gap-4 max-w-96">
            <button id="btnCerrarcaja" class="btn-command"><span class="material-symbols-outlined">keyboard_lock</span>Cerrar caja</button>
            <button id="btnImprimirDetalleCaja" class="btn-command"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
            <button id="btnCambiarCaja" class="btn-command"><span class="material-symbols-outlined">change_circle</span>Cambiar caja</button>
        </div>
    </div> <!-- Fin col 2 -->
  </div>


  <?php if($conflocal['permitir_ver_resumen_cierre_de_caja']->valor_final == 1): ?>
    <div class="accordion">
        <input type="checkbox" id="first" checked>
        <label class="etiqueta text-sky-400 text-center  font-bold uppercase" for="first">Resumen</label>
        <div class="wrapper flex flex-col lg:flex-row gap-8">
            <div class="wrapper-content">
                <div class="content">

                    <div class="flex flex-col tlg:flex-row gap-12 mb-8">
                        <div class="tlg:basis-1/2">
                            <table class="tabla2" width="100%" id="">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="w-full bg-gray-100 text-gray-700 p-3 text-center">Cuadre de caja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>        
                                        <td class="">Base + ingresos de caja</td> 
                                        <td id="baseIngresoCaja" class="">+ $<?php echo number_format($ultimocierre->basecaja??0, "0", ",", ".");?></td>
                                    </tr>
                                    <tr>        
                                        <td class="">Ventas en efectivo</td> 
                                        <td id="ventasEfectivo" class="">+ $<?php echo number_format($ultimocierre->ventasenefectivo??0, "0", ",", ".");?></td>
                                    </tr>
                                    <tr>        
                                        <td class="">Gastos de la caja</td> 
                                        <td id="gastosCaja" class="">- $<?php echo number_format($ultimocierre->gastoscaja??0, "0", ",", ".");?></td>
                                    </tr>
                                    <tr>        
                                        <td class="text-blue-400 font-medium">Dinero en caja</td> 
                                        <td id="dineroCaja" class="text-blue-400 font-medium">= $<?php echo number_format(($ultimocierre->basecaja??0)+($ultimocierre->ventasenefectivo??0)-($ultimocierre->gastoscaja??0), "0", ",", ".");?></td>
                                    </tr>
                                    <tr>        
                                        <td class="">Domicilios</td> 
                                        <td id="domicilios" class="">- $<?php echo number_format($ultimocierre->domicilios??0, "0", ",", ".");?></td>
                                    </tr>
                                    <tr>        
                                        <td class="text-blue-600 font-medium">Real en caja</td> 
                                        <td id="realCaja" class="text-blue-600 font-medium">= $<?php echo number_format(($ultimocierre->basecaja??0)+($ultimocierre->ventasenefectivo??0)-($ultimocierre->gastoscaja??0)-($ultimocierre->domicilios??0), "0", ",", ".");?></td>
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
                                            <td class=""><?php echo $value['tarifa']!=null?$value['tarifa'].'%':'Excluido';?></td>     
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

                        </div>

                        <div class="tlg:basis-1/2">
                            <table class="tabla2 mb-12" width="100%" id="tablaMediosPago">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="w-full bg-gray-100 text-gray-700 p-3 text-center">Medios de pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($discriminarmediospagos as $index => $value): ?>
                                    <tr>        
                                        <td class=""><?php echo $value['mediopago'];?></td>
                                        <td class=""><strong>$ </strong><?php echo number_format($value['valor'], "0", ",", ".");?></td>
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
                                        <td id="ingresoVentasTotal" class=""> + $<?php echo number_format($ultimocierre->ingresoventas??0, "0", ",", ".");?></td>
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
                                        <td id="cantidadFacturasFE" class=""><?php echo number_format($ultimocierre->facturaselectronicas??0, "0", ",", ".");?></td>
                                    </tr>
                                    <tr>        
                                        <td class="">Facturas POS</td> 
                                        <td id="cantidadFacturasPOS" class=""><?php echo number_format($ultimocierre->facturaspos??0, "0", ",", ".");?></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="overflow-x-auto">
                                <p class="text-sky-400 font-bold text-center">Analisis Sobrantes y Faltantes</p>
                                <table class="tabla2 w-full min-w-[500px] mb-12" width="100%" id="sobranteFaltante">
                                    <thead>
                                        <tr class="bg-gray-100 text-gray-700 p-3 text-center">
                                            <th class="p-2">Medios de pago</th>
                                            <th class="p-2"> Sisitema </th>
                                            <th class="p-2"> Valor declarado </th>
                                            <th class="p-2"> Diferencia </th>
                                        </tr>
                                    </thead>
                                    <tbody class="cuerpoanalisis">
                                        <?php foreach($sobrantefaltante as $index => $value): ?>
                                        <tr class="<?php echo $value->nombremediopago=='Efectivo'?'!border-2 !border-indigo-600':'';?>">        
                                            <td class="p-2"><?php echo $value->nombremediopago;?></td> 
                                            <td class="p-2 colsistem"><?php echo number_format($value->valorsistema, "0", ",", ".");?></td>
                                            <td class="p-2 coldeclarado" data-mediopagoid="<?php echo $value->id_mediopago;?>"><?php echo number_format($value->valordeclarado, "0", ",", ".");?></td>
                                            <td class="p-2 coldif"><?php echo number_format($value->valordeclarado-$value->valorsistema, "0", ",", ".");?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <table class="tabla2 mb-12" width="100%" id="ventasXUsuario">
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
                        <table class="display responsive nowrap tabla w-full min-w-[700px]" id="tablaVentas">
                            <thead>
                            <tr class="bg-gray-100 text-gray-700 text-center">
                                <th class="p-2">N.</th>
                                <th class="p-2">Fecha</th>
                                <th class="p-2">Cliente</th>
                                <th class="p-2">Factura</th>
                                <th class="p-2">Medio pago</th>
                                <th class="p-2">Estado</th>
                                <th class="p-2">Valor Bruto</th>
                                <th class="p-2">Total</th>
                                <th class="p-2 accionesth">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($facturas as $index => $value): ?>
                            <tr>
                                <td><?php echo $index+1;?></td>
                                <td><?php echo $value->fechapago;?></td>
                                <td><?php echo $value->cliente;?></td>
                                <td><?php echo $value->id;?></td>
                                <td>
                                <div data-estado="<?php echo $value->estado;?>" data-totalpagado="<?php echo $value->total;?>" id="<?php echo $value->id;?>" class="mediosdepago max-w-full flex flex-wrap gap-2">
                                    <?php foreach($value->mediosdepago as $idx => $element): ?>
                                    <button class="btn-xs btn-light"><?php echo $element->mediopago;?></button>
                                    <?php endforeach; ?>
                                </div>
                                </td>
                                <td class="<?php echo $value->estado=='Paga'?'btn-xs btn-lima':'btn-xs btn-blueintense';?>"><?php echo $value->estado;?></td>
                                <td>$ <?php echo number_format($value->subtotal??0, "0", ",", ".");?></td>
                                <td>$ <?php echo number_format($value->total??0, "0", ",", ".");?></td>
                                <td class="accionestd">
                                <div class="acciones-btns" id="<?php echo $value->id;?>">
                                    <a class="btn-xs btn-turquoise" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">Ver</a>
                                    <button class="btn-xs btn-light"><i class="fa-solid fa-print"></i></button>
                                </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>    
                </div> <!--fin content -->
            </div> <!--fin wrpper-content-->
        </div> <!--fin wrapper -->
        
    </div> <!-- fin accordion-->
  <?php endif; ?>

  <!-- Ventana Modal Arqueo de caja -->
  <dialog class="p-14 w-[600px] max-w-full" id="modalArqueocaja">
    <h4 class="font-semibold text-gray-700 mb-4">Arqueo de caja</h4>
    <div id="divmsjalerta2"></div>
    <form id="formArqueocaja" class="formulario" action="/" method="POST">
        <div class="formulario__campo">
          <label class="formulario__label " for="cienmil">$100.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $100.000" id="cienmil" name="cienmil" value="0" data-moneda="100000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="cincuentamil">$50.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $50.000" id="cincuentamil" name="cincuentamil" value="0" data-moneda="50000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="veintemil">$20.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $20.000" id="veintemil" name="veintemil" value="0" data-moneda="20000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="diezmil">$10.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $10.000" id="diezmil" name="diezmil" value="0" data-moneda="10000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="cincomil">$5.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $5.000" id="cincomil" name="cincomil" value="0" data-moneda="5000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="dosmil">$2.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $2.000" id="dosmil" name="dosmil" value="0" data-moneda="2000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="mil">$1.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $1.000" id="mil" name="mil" value="0" data-moneda="1000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="quinientos">$500</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $500" id="quinientos" name="quinientos" value="0" data-moneda="500">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="docientos">$200</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $200" id="docientos" name="docientos" value="0" data-moneda="200">
        </div>
        
        <div class="flex justify-end space-x-4">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[140px]" type="button" value="Cancelar">Cancelar</button>
            <input id="btnAPlicararqueocaja" class="btn-md btn-indigo !py-4 !px-6 !w-[140px]" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>
  
  <!-- MODAL ventana para cerrar caja-->
  <dialog id="Modalcerrarcaja" class="midialog-xs p-12">
    <div>
        <h4 class="font-semibold text-gray-700 mb-4">Caja principal</h4>
        <p class="text-gray-600">Desea cerrar la caja? Ya no se podra modificar.</p>
    </div>
    <div id="" class="cerrarcaja flex justify-around border-t border-gray-300 pt-4">
        <div class="finCerrarcaja flex cursor-pointer transition-transform duration-300 hover:scale-110 text-blue-600 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-4">Confirmar</p></div>
        <div class="salircerrarcaja flex cursor-pointer transition-transform duration-300 hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-4">Salir</p></div>
    </div>
  </dialog>

  <!-- MODAL cambiar caja-->
  <dialog id="modalCambiarCaja" class="midialog-sm p-12">
    <h4 class="font-semibold text-gray-700 mb-4">Cambiar caja</h4>
    <div id="divmsjalertaCambiarCaja"></div>
    <form id="formCambiarCaja" class="formulario" action="/admin/caja" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="CambiarCaja">Seleccionar caja</label>
            <select id="CambiarCaja" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="CambiarCaja" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <?php foreach($cajas as $index => $value): ?>
                    <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="text-right space-x-4">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
            <input id="btnEnviarCambiarCaja" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>

  <div><a href="www.j2softwarepos.com" class="text-gray-500 text-center block text-lg">J2 Software POS MultiSucursal</a></div>

</div>
</div>