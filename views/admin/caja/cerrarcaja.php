
<div class="relative">
    <div class="content-spinner1" style="display: none;"><div class="spinner1"></div></div>
<div class="box cerrarcaja">
  <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
      <p class="m-0 text-slate-500 text-xl">Caja principal</p>
      <p class="m-0 text-slate-500 text-xl"><?php echo date('Y-m-d');?></p>
      <p class="m-0 text-slate-500 text-xl"><?php echo $user['nombre'];?></p>
    </div>
  </div>
  <div class="flex flex-col tlg:flex-row tlg:items-start gap-4 mt-4">
    <div class="basis-1/3 border border-gray-300 p-4 declaracionvalores rounded-lg">
      <div class="formulario__campo">
          <label class="formulario__label" for="EF">Efectivo en caja</label>
          <div class="formulario__dato gap-x-[0.7rem]">
              <input class="formulario__input inputmediopago bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Dinero en caja" id="Efectivo" name="Efectivo" data-idmediopago="1" value="" required>
              <button class="btn-md btn-turquoise !py-auto !px-6" id="btnArqueocaja">Arqueo de caja</button>
          </div>
      </div>
      <?php foreach($mediospagos as $index => $value): 
        if($index>0):  ////////// declaracion de valores /////////?>
        <div class="formulario__campo">
          <label class="formulario__label" for="<?php echo $value->nick??'';?>"><?php echo $value->mediopago??'';?></label>
          
          <input class="formulario__input inputmediopago bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" 
            type="text" 
            placeholder="Dinero en <?php echo $value->mediopago??'';?>" 
            id="<?php echo $value->nick??'';?>" 
            name="<?php echo $value->mediopago??'';?>" 
            value=""
            data-idmediopago="<?php echo $value->id;?>" 
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
          <p class="m-0 mb-2 text-slate-600 text-2xl font-normal" id="idCierrecaja"><?php echo $ultimocierre->id;?></p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$<?php echo number_format($ultimocierre->basecaja??0, "0", ",", ".");?></p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$<?php echo number_format($ultimocierre->gastoscaja??0, "0", ",", ".");?></p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$<?php echo number_format($ultimocierre->domicilios??0, "0", ",", ".");?></p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-semibold">$<?php echo number_format($ultimocierre->ingresoventas??0, "0", ",", ".");?></p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal"><?php echo $ultimocierre->totalfacturas??0;?></p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal"><?php echo $ultimocierre->totalcotizaciones??0;?></p>
          </div>
        </div>
        <div class="flex flex-wrap gap-4 max-w-96">
            <button class="btn-command" id="btnCerrarcaja"><span class="material-symbols-outlined">keyboard_lock</span>Cerrar caja</button>
            <button class="btn-command"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
            <button class="btn-command"><span class="material-symbols-outlined">change_circle</span>Cambiar caja</button>
        </div>
    </div> <!-- Fin col 2 -->
  </div>

  <div class="accordion">
      <input type="checkbox" id="first">
      <label class="etiqueta text-gray-500" for="first">Resumen</label>
      <div class="wrapper">
          <div class="wrapper-content">
            <div class="content">

                <div class="flex flex-col tlg:flex-row gap-12 mb-8">
                    <div class="tlg:basis-1/2">
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
                                    <td class=""><strong>$ </strong><?php echo number_format($value['valor'], "0", ",", ".");?></td>
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
                                    <td class="">Ingreso de ventas total</td> 
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
                                    <td class="text-blue-400 font-medium">Real de ventas sin domicilio</td> 
                                    <td class="text-blue-400 font-medium"> = $<?php echo number_format($ultimocierre->ingresoventas-$ultimocierre->totaldescuentos-$ultimocierre->domicilios??0, "0", ",", ".");?></td>
                                </tr>
                                <tr>        
                                    <td class="">Impuesto</td> 
                                    <td class=""> - $<?php echo number_format($ultimocierre->valorimpuestototal??0, "2", ",", ".");?></td>
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
                            <td class="">$ <?php echo number_format($value->subtotal??0, "0", ",", ".");?></td>
                            <td class="">$ <?php echo number_format($value->total??0, "0", ",", ".");?></td>
                            <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                                    <a class="btn-xs btn-turquoise" href="/admin/caja/ordenresumen?id=<?php echo $value->id;?>">Ver</a> <button class="btn-xs btn-light"><i class="fa-solid fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
            </div> <!--fin content -->
          </div> <!--fin wrpper-content-->
      </div> <!--fin wrapper -->
      
  </div> <!-- fin accordion-->

  <!-- Ventana Modal Arqueo de caja -->
  <dialog class="p-14 w-[600px] max-w-full" id="modalArqueocaja">
    <h4 class="font-semibold text-gray-700 mb-4">Arqueo de caja</h4>
    <div id="divmsjalerta2"></div>
    <form id="formArqueocaja" class="formulario" action="/" method="POST">
        <div class="formulario__campo">
          <label class="formulario__label " for="cienmil">$100.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $100.000" id="cienmil" name="cienmil" value="0" data-moneda="100000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="cincuentamil">$50.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $50.000" id="cincuentamil" name="cincuentamil" value="0" data-moneda="50000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="veintemil">$20.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $20.000" id="veintemil" name="veintemil" value="0" data-moneda="20000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="diezmil">$10.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $10.000" id="diezmil" name="diezmil" value="0" data-moneda="10000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="cincomil">$5.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $5.000" id="cincomil" name="cincomil" value="0" data-moneda="5000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="dosmil">$2.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $2.000" id="dosmil" name="dosmil" value="0" data-moneda="2000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="mil">$1.000</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $1.000" id="mil" name="mil" value="0" data-moneda="1000">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="quinientos">$500</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $500" id="quinientos" name="quinientos" value="0" data-moneda="500">
        </div>
        <div class="formulario__campo">
          <label class="formulario__label" for="docientos">$200</label>
          <input class="formulario__input denominacion bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Denominacion de $200" id="docientos" name="docientos" value="0" data-moneda="200">
        </div>
        
        <div class="flex justify-end space-x-4">
            <button class="btn-md btn-turquoise !py-4 !px-6 !w-[140px]" type="button" value="cancelar">cancelar</button>
            <input id="btnAPlicararqueocaja" class="btn-md btn-indigo !py-4 !px-6 !w-[140px]" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>
  
  <!-- MODAL ventana para cerrar caja-->
  <dialog class="midialog-xs p-5" id="Modalcerrarcaja">
    <div>
        <h4 class="font-semibold text-gray-700 mb-4">Caja principal</h4>
        <p class="text-gray-600">Desea cerrar la caja? Ya no se podra modificar.</p>
    </div>
    <div id="" class="cerrarcaja flex justify-around border-t border-gray-300 pt-4">
        <div class="finCerrarcaja flex cursor-pointer transition-transform duration-300 hover:scale-110 text-blue-600 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-4">Confirmar</p></div>
        <div class="salircerrarcaja flex cursor-pointer transition-transform duration-300 hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-4">Salir</p></div>
    </div>
  </dialog>

  <div><p class="text-gray-500 text-center">Innovatech</p></div>

</div>
</div>