<div class="box ordenresumen !pb-20">
    <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <div class="flex flex-wrap gap-2 mt-4 mb-6 pb-4 border-b-2 border-blue-600">
        <?php if($factura->estado=='Guardado' && $factura->cambioaventa == 0):?>
        <button id="btnfacturar" class="btn-command"><span class="material-symbols-outlined">attach_money</span>Procesar pago</button>
        <?php endif; ?>
        <?php if($factura->estado=='Paga'):?>
        <button id="btneliminarorden" class="btn-command"><span class="material-symbols-outlined">delete</span>Eliminar orden</button>
        <?php endif; ?>
        <?php if($factura->estado=='Paga'):?>
        <button id="printcarta" class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">print</span>Imprimir factura</button>
        <?php endif; ?>
        <?php if($factura->estado=='Guardado'):?>
        <button id="printcotizacion" class="btn-command text-center"><span class="material-symbols-outlined">print</span>Imprimir cotizacion</button>
        <?php endif; ?>
        <?php if($factura->tipoventa=='Credito'):?>
        <a class="btn-command text-center" href="/admin/caja/detallecredito?id=<?php echo $factura->id;?>"><span class="material-symbols-outlined">format_list_bulleted</span>Detalle credito</a>
        <?php endif; ?>
        <button id="enviarEmail" class="btn-command text-center"><span class="material-symbols-outlined">mail</span>Enviar factura</button>
        <!--<a class="btn-command text-center" href="/admin/caja/detalleorden?id=<?php //echo $factura->id;?>"><span class="material-symbols-outlined">format_list_bulleted</span>Detalle orden</a>-->
        <?php if($factura->estado=='Guardado' && $factura->cambioaventa == 0):?>
        <a id="abrirOrden" class="btn-command" href="/admin/ventas?id=<?php echo $factura->id;?>"><span class="material-symbols-outlined">app_registration</span>Abrir</a>
        <?php endif; ?>
    </div>
    
    <div class="flex gap-4 mb-4">
        <div>
            <span class="m-0 text-slate-500 text-xl font-semibold">Orden: </span>
            <span id="numOrden" class="m-0 text-slate-500 text-xl">#: <?php echo $factura->num_orden??'';?></span>
        </div>
        <div>
            <span class="m-0 text-slate-500 text-xl font-semibold">Referencia: </span>
            <span id="referenciaFactura" class="m-0 text-slate-500 text-xl">Orden: <?php echo $factura->referencia??'';?></span>
        </div>
    </div>

    <div class="flex justify-between p-4 border border-gray-300 rounded mb-6">
        <div class="flex-1 text-center">
            <p class="font-bold">Fecha Orden</p>
            <p><?php echo $factura->fechacreacion??'';?></p>
        </div>
        <div class="flex-1 text-center border-l border-gray-300">
            <p class="font-bold">Fecha Pago</p>
            <p><?php echo $factura->fechapago??'';?></p>
        </div>
        <div class="flex-1 text-center border-l border-gray-300">
            <p class="font-bold">Vendedor</p>
            <p><?php echo $factura->vendedor??'';?></p>
        </div>
        <div class="flex-1 text-center border-l border-gray-300">
            <p class="font-bold">Estado Orden</p>
            <p id="estadoOrden"><?php echo ($factura->tipoventa =='Contado'||$factura->tipoventa =='')?$factura->estado:'Credito';?></p>
        </div>
    </div>

    <div id="idorden" class="hidden" data-idorden="<?php echo $factura->id;?>"></div>

    <div class="flex flex-col tlg:flex-row gap-8">
            <div class="relative overflow-x-auto flex-1">
                <table class="w-full text-xl text-left rtl:text-right text-gray-500">
                    <thead class=" text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-s-lg">
                                Nombre producto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Qty
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Unidad
                            </th>
                            <th scope="col" class="px-6 py-3 rounded-e-lg">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($productos as $index=>$value): ?>
                            <tr class="bg-white">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900">
                                    <div class="flex items-center gap-4">
                                        <img 
                                            class="w-24" 
                                            src="/build/img/<?php echo $value->foto;?>"
                                            onerror="this.onerror=null;this.src='/build/img/default-product.png';"
                                            alt="J2SoftwarePOS" 
                                        />
                                        <span> <?php echo $value->nombreproducto??'';?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $value->cantidad??'';?>
                                </td>
                                <td class="px-6 py-4">
                                    $<?php echo number_format($value->valorunidad??0, "0", ",", ".");?>
                                </td>
                                <td class="px-6 py-4">
                                    $<?php echo number_format($value->total??0, "0", ",", ".");?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold text-gray-900">
                            <th scope="row" class="px-6 py-3">Total</th>
                            <td class="px-6 py-3"><?php echo $factura->totalunidades;?></td>
                            <td class="px-6 py-3"> - </td>
                            <td class="px-6 py-3">$<?php echo number_format($factura->total??0, "0", ",", ".");?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        
       
            <div class="flex flex-col sm:flex-row tlg:flex-col justify-between tlg:justify-normal gap-4">
                <div class="w-full sm:max-w-96 flex flex-col  border px-4 border-gray-300 rounded">
                    <p class="text-xl font-semibold leading-4 text-center text-gray-800">CLIENTE</p>
                    <p class="mb-0 text-center md:text-left text-lg leading-5 text-gray-600 flex items-center"><span class="material-symbols-outlined">person</span><?php echo $factura->cliente??'';?></p>
                    <p class="my-0 text-center md:text-left text-lg leading-5 text-gray-600 flex items-center"><span class="material-symbols-outlined">mail</span><?php echo $cliente->email??'';?></p>
                    <p class="mt-0 text-center md:text-left text-lg leading-5 text-gray-600 flex items-center"><span class="material-symbols-outlined">phone_in_talk</span><?php echo $cliente->telefono??'';?></p>
                </div>
                <div class="w-full sm:max-w-96 flex flex-col border px-4 border-gray-300 rounded">
                    <p class="text-xl font-semibold leading-4 text-center text-gray-800">Direccion de entrega</p>
                    <p class="md:text-left text-lg leading-5 text-gray-600"><?php echo $direccion->ciudad.'-'.$direccion->direccion??'';?></p>
                    <p class="mt-0 md:text-left text-lg leading-5 text-gray-600">Tarifa envio: $<?php echo $tarifa->valor??'';?></p>
                </div>
                <div class="w-full sm:max-w-96 flex flex-col border px-4 border-gray-300 rounded">
                    <p class="text-xl font-semibold leading-4 text-center text-gray-800">Direccion de facturacion</p>
                    <p class="md:text-left text-lg leading-5 text-gray-600">180 North King Street, Northhampton MA 1060</p>
                </div>
            </div>
            
       

    </div>

    <div>
        <div class="mt-6 flex justify-end items-start border-solid border border-gray-300 py-4 px-8 rounded">
            <div class="flex justify-end gap-4 sm:gap-60">
                <div class="text-end">
                    <p class="m-0 mb-2 text-slate-600 text-xl font-normal">Sub Total:</p>
                    <p class="m-0 mb-2 text-slate-600 text-xl font-normal">Impuesto:</p>
                    <p class="m-0 mb-2 text-slate-600 text-xl font-normal">Descuento:</p>
                    <p class="m-0 mb-2 text-slate-600 text-xl font-normal">Tarifa Envio:</p>
                    <p class="m-0 mb-2 text-slate-600 text-3xl font-semibold">Total:</p>
                </div>
                <div>
                    <p id="subTotal" class="m-0 mb-2 text-slate-600 text-xl font-normal">$<?php echo number_format($factura->subtotal??0, '0', ',', '.');?></p>
                    <p id="impuesto" class="m-0 mb-2 text-slate-600 text-xl font-normal">$<?php echo number_format($factura->valorimpuestototal??0, '0', ',', '.');?></p>
                    <p id="descuento" class="m-0 mb-2 text-slate-600 text-xl font-normal"><?php echo $factura->dctox100.'%  $'.$factura->descuento;?></p>
                    <p id="valorTarifa" class="m-0 mb-2 text-slate-600 text-xl font-normal">$<?php echo $factura->valortarifa??'';?></p>
                    <p id="total" class="m-0 mb-2 text-green-500 text-3xl font-semibold" style="font-family: 'Tektur', serif;">$ <?php echo number_format($factura->total??0, "0", ",", ".");?></p>
                </div>
            </div>
        </div>
        <div></div>
    </div>


    <dialog id="miDialogoFacturar" class="midialog-md !p-12">
      <h4 class="text-3xl font-semibold m-0 text-neutral-800">Registro de pago</h4>
      <hr class="my-4 border-t border-neutral-300">
      <form id="formfacturar" class="formulario" method="POST">
          <input id="idcita" name="id" type="hidden">
          <p class="text-gray-600 text-3xl text-center font-light m-0">Total a pagar $: </br><span id="totalPagar" class="text-gray-700 font-semibold">0</span></p>
          <div class="flex justify-center gap-12 mt-8">
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="caja">Caja</label>
              <select id="caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="caja" required>
                  <!--<option value="" disabled selected>-Seleccionar-</option>
                  <option value="1">Caja principal</option>
                  <option value="2">Caja bodega</option>-->
                  <?php foreach($cajas as $index => $value):?>
                    <option value="<?php echo $value->id;?>" data-idfacturador="<?php echo $value->idtipoconsecutivo;?>"><?php echo $value->nombre;?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="facturador">Facturador</label>
              <select id="facturador" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="facturador" required>
                <?php foreach($consecutivos as $index => $value):?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
              </select>
            </div>

          </div>
          <div class="accordion md:px-12 !mt-4">
            <input type="checkbox" id="first">
            <label class="etiqueta text-indigo-700" for="first">Elegir metodo de pago</label>
            <div class="wrapper">
              <div class="wrapper-content">
                <div id="mediospagos" class="content flex flex-col items-center w-1/2 mx-auto text-center">
                  <?php foreach($mediospago as $index => $value):?>
                    <div class="mb-4 text-center">
                      <label class="text-gray-700 text-xl text-center leading-relaxed"><?php echo $value->mediopago??'';?>: </label>
                      <input id="<?php echo $value->id??'';?>" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 h-14 text-xl focus:outline-none focus:ring-1 text-center mediopago <?php echo $value->mediopago??'';?>" type="text" value="0" <?php echo $value->mediopago=='Efectivo'?'readonly':'';?> oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div> <!-- fin accordion  -->

          <div class="mx-auto">
            <div class="formulario__campo w-80 mx-auto">
                <label class="formulario__label leading-relaxed text-center" for="recibio">Efectivo Recibido</label>
                <input id="recibio" class="formulario__input !text-2xl !border-0 !border-b-2 !border-indigo-500 !rounded-none text-center" name="" type="text" placeholder="0" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
            </div>
            <div class="flex flex-col items-center">
                <p id="cambio" class="text-center formulario__label">Devolver: <span class="text-gray-700 font-semibold text-2xl">$0</span></p>
            </div>
          </div>

        <!-- Opción imprimir factura -->
        <div class="formulario__campo md:px-12 mb-6">
          <label class="formulario__label block text-center mb-2">¿Desea imprimir factura?</label>
          <div class="flex justify-center gap-8">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="1" class="w-5 h-5" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 1?'checked':'';?>>
              <span class="text-gray-700 text-lg">Sí</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="0" class="w-5 h-5" <?php echo $conflocal['imprimir_factura_automaticamente']->valor_final == 0?'checked':'';?>>
              <span class="text-gray-700 text-lg">No</span>
            </label>
          </div>
        </div>
        <!-- Fin opción imprimir factura -->

          <div class="formulario__campo md:px-12">
              <textarea id="observacion" class="formulario__textarea" name="observacion" placeholder="Observacion" rows="4"></textarea>
          </div>

          <div class="self-end">
              <button class="btn-md btn-turquoise !py-4 !px-6 !w-[145px]" type="button" value="Cancelar">Cancelar</button>
              <input class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[145px]" type="submit" value="Pagar">
          </div>
          
      </form>
    </dialog>

    <!-- MODAL PARA ELIMINAR LA ORDEN-->
    <dialog class="midialog-sm px-8 pb-8" id="miDialogoEliminarOrden">
        <div>
            <p class="text-3xl font-semibold text-gray-500">Desea eliminar la orden de venta?</p>
        </div>

        <div id="divmsjalerta1"></div>

        <div class="text-center mb-4">
            <p class="mt-2 text-xl text-gray-600">Desea devolver los productos al inventario.</p>
            <div class="inline-flex  border-[3px] border-indigo-600 rounded-xl select-none">  
                <label class="flex  p-1 cursor-pointer">
                    <input type="radio" name="devolverinventario" value="1" class="peer hidden"/>
                    <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 px-6 py-3 rounded-lg transition duration-300 ease-in-out text-xl"> Si </span>
                </label>
                <label class="flex  p-1 cursor-pointer">
                    <input type="radio" name="devolverinventario" value="0" class="peer hidden" checked />
                    <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 px-6 py-3 rounded-lg transition duration-300 ease-in-out text-xl"> No </span>
                </label>
            </div>

            <div class="sm:col-start-2 col-span-4 mt-6">
              <label for="descuento" class="block text-2xl font-medium text-gray-600">Ingresar Clave</label>
              <div class="mt-2">
                <input id="inputDescuentoClave" type="number" min="0" name="descuento" class="miles bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-1/2 mx-auto p-2.5 h-14 text-xl focus:outline-none focus:ring-1" required>
              </div>
            </div>

        </div>

        <table id="productsInv" class="w-full text-xl text-left rtl:text-right text-gray-500 hidden">
            <thead class=" text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 rounded-s-lg">
                        Nombre producto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Qty
                    </th>
                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                        Devolver
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $index=>$value): ?>
                    <tr class="bg-white">
                        <td class="px-6 py-4">
                            <?php echo $value->nombreproducto??'';?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $value->cantidad??0;?>
                        </td>
                        <td class="px-6 py-4" data-qty="<?php echo $value->cantidad??0;?>">
                            <input 
                            id="<?php echo $value->idproducto;?>" 
                            data-tipoproducto = "<?php echo $value->tipoproducto;?>";
                            data-tipoproduccion = "<?php echo $value->tipoproduccion;?>";
                            data-rendimientoestandar = "<?php echo $value->rendimientoestandar;?>";
                            class="inputInv block w-full rounded-md px-3 py-1.5 text-xl text-gray-500 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600" 
                            type="text" 
                            name="" 
                            value="<?php echo $value->cantidad??0;?>" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||0)" 
                            required
                            >  
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="flex justify-around border-t-gray-300 pt-4">
            <div class="sieliminar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Confirmar</p></div>
            <div class="noeliminar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">Cancelar</p></div>
        </div>
    </dialog>

    <dialog id="miDialogoEnviarEmailCliente" class="midialog-xs p-8 rounded-lg shadow-lg">
        <h4 id="modalEnviarEmail" class="font-semibold text-gray-700 mb-4 mt-4">Enviar orden por email</h4>
        <div id="divmsjalertaEnviarEmail"></div>
        <form id="formEnviarEmailCliente" class="formulario" method="POST">
            <h5 class="my-2 text-lg text-gray-500">Enviar detalle de la orden por correo electronico</h5>
            <div class="formulario__campo">
                <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                    <input id="inputEmail" class="formulario__input !border-0" type="email" placeholder="Email"  required>
                </div>
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4  !w-[100px]" type="button" value="Salir">Salir</button>
                <input id="btnEnviarEmailCliente" class="btn-md btn-indigo !py-4  !w-[100px]" type="submit" value="Enviar">
            </div>
        </form>
    </dialog><!--fin enviar email a cliente-->
</div>