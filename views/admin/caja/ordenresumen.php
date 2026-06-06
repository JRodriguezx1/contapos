<div class="box ordenresumen !pb-20">
    <button onclick="history.back()" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2">
        <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <span class="sr-only">Atrás</span>
    </button>
    <div class="flex flex-wrap gap-2 mt-4 mb-6 pb-4 border-b-2 border-blue-600">
        <?php if($factura->cambioaventa == 0 && ($factura->estado=='Guardado' || $factura->estado=='Remision')):?>
            <button id="btnfacturar" title="Procesar pago de cotizaciones y remisiones. Solo para las cotizaciones se descuenta de inventario" class="btn-command"><span class="material-symbols-outlined">attach_money</span>Procesar pago</button>
        <?php endif; ?>
        <?php if($factura->estado=='Paga' || $factura->estado=='Remision'):?>
            <button id="btneliminarorden" class="btn-command"><span class="material-symbols-outlined">delete</span>Eliminar orden</button>
        <?php endif; ?>
        <?php if($factura->estado=='Paga' || $factura->estado=='Eliminada'):?>
            <button id="printcarta" class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><span class="material-symbols-outlined">print</span>Imprimir factura</button>
        <?php endif; ?>
        <?php if($factura->estado=='Guardado'):?>
            <button id="printcotizacion" class="btn-command text-center"><span class="material-symbols-outlined">print</span>Imprimir cotizacion</button>
        <?php endif; ?>
        <?php if($factura->tipoventa=='Credito'):?>
            <a class="btn-command text-center" href="/admin/creditos/detallecredito?id=<?php echo $factura->ref_creditoid;?>"><span class="material-symbols-outlined">format_list_bulleted</span>Detalle credito</a>
        <?php endif; ?>
        <?php if($factura->estado=='Paga'):?>
            <button id="enviarEmail" class="btn-command text-center"><span class="material-symbols-outlined">mail</span>Enviar factura</button>
        <?php endif; ?>
            <!--<a class="btn-command text-center" href="/admin/caja/detalleorden?id=<?php //echo $factura->id;?>"><span class="material-symbols-outlined">format_list_bulleted</span>Detalle orden</a>-->
        <?php if($factura->cambioaventa == 0 && ($factura->estado=='Guardado' || $factura->estado == 'Remision')):?>
            <a id="abrirOrden" class="btn-command" href="/admin/ventas?id=<?php echo $factura->id;?>"><span class="material-symbols-outlined">app_registration</span>Abrir</a>
        <?php endif; ?>
        <?php if($factura->estado=='Paga'):?>
            <a class="btn-command text-center" href="/admin/reportes/detalleInvoice?id=<?php echo $factura->id;?>"><span class="material-symbols-outlined">article_shortcut</span>Factura Electronica</a>
        <?php endif; ?>
        <?php if($factura->entregado == 0 && ($factura->estado=='Paga' && $factura->entrega == 'Domicilio' || $factura->estado == 'Remision')):?>
            <button id="btnDespachar" title="Solo para facturas pendientes de despachar y remisiones" class="btn-command"><span class="material-symbols-outlined">delivery_truck_speed</span>Marcar despachado</button>
        <?php endif; ?>
        <button id="btnMasOpciones" class="btn-command text-center"><span class="material-symbols-outlined">Apps</span>Mas</button>
    </div>
    
<div class="flex flex-wrap gap-3 mb-6">

    <span class="px-5 py-2.5 rounded-full bg-slate-100 text-slate-700 font-medium">
        Orden #<?php echo $factura->num_orden??'';?>
    </span>

    <span class="px-5 py-2.5 rounded-full bg-indigo-50 text-indigo-700 font-medium">
        Referencia: <?php echo $factura->referencia??'';?>
    </span>

    <span id="textEstado"
        class="px-5 py-2.5 rounded-full bg-amber-100 text-amber-700 font-medium">
        <?php echo (($factura->entrega=='Domicilio'||$factura->entrega=='Presencial') && $factura->entregado==0)
            ? 'Pendiente de despacho'
            : ($factura->entrega=='Presencial' && $factura->entregado==1
                ? 'Presencial'
                : 'Domicilio/Presencial entregado'); ?>
    </span>

</div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
            <p class="font-bold text-slate-800 flex items-center justify-center gap-3">
                <span class="material-symbols-outlined text-indigo-600">
                    calendar_month
                </span>
                Fecha Orden
            </p>
            <p><?php echo $factura->fechacreacion??'';?></p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
            <p class="font-bold text-slate-800 flex items-center justify-center gap-3">
                <span class="material-symbols-outlined text-indigo-600">
                    payments
                </span>
                Fecha Pago
            </p>
            <p><?php echo $factura->fechapago??'';?></p>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
            <p class="font-bold text-slate-800 flex items-center justify-center gap-3">
                <span class="material-symbols-outlined text-indigo-600">
                    badge
                </span>
                Vendedor
            </p>
            <button id="btnSelectVendedor" class="btn-xs btn-light"><?php echo $factura->vendedor??'';?></button>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
            <p class="font-bold text-slate-800 flex items-center justify-center gap-3">
                <span class="material-symbols-outlined text-indigo-600">
                    inventory_2
                </span>
                Estado Orden
            </p>
            <p id="estadoOrden" class="mb-2"><?php echo (($factura->tipoventa =='Contado'|| $factura->tipoventa =='')&&$factura->remision==0)?$factura->estado:($factura->remision==1 && ($factura->estado == 'Paga' || $factura->estado == 'Aceptada')?'Remision - '.$factura->estado:($factura->remision==1&&$factura->estado=='Remision'?$factura->estado:"Credito - F. $factura->estado"));?></p>
            <p class="m-0 text-gray-600 text-xl font-medium"> - Factura: <?php echo ($factura->prefijo??'') . $factura->num_consecutivo;?></p>
        </div>
    </div>

    <div id="idorden" class="hidden" data-idorden="<?php echo $factura->id;?>"></div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        <div class="relative overflow-x-auto xl:col-span-9 bg-white border border-slate-200 rounded-2xl shadow-sm p-4 min-h-[420px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">
                        inventory_2
                    </span>
                    Productos de la orden
                </h3>

                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-sm font-medium">
                    <?php echo count($productos); ?> productos
                </span>
            </div>
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
                <tbody id="tablaDetalleProductos">
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
                                    <?php if($value->tipoproducto == 0): ?> 
                                        <span><?php echo $value->nombreproducto ?? ''; ?></span>
                                    <?php else: ?>
                                        <button id="<?php echo $value->idproducto;?>" class="productoCompuesto btn-xs btn-light"><?php echo $value->nombreproducto ?? '';?></button>
                                    <?php endif; ?>
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
                        <td class="px-6 py-3">$<?php echo number_format($factura->subtotal??0, "0", ",", ".");?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    
    
        <div class="xl:col-span-3 flex flex-col gap-4">
            <div class="w-full flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <p class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">
                        person
                    </span>
                    CLIENTE
                </p>
                <p class="mb-0 text-center md:text-left text-lg leading-5 text-gray-600 flex items-center"><span class="material-symbols-outlined">person</span><?php echo $factura->cliente??'';?></p>
                <p class="my-0 text-center md:text-left text-lg leading-5 text-gray-600 flex items-center"><span class="material-symbols-outlined">mail</span><?php echo $cliente->email??'';?></p>
                <p class="mt-0 text-center md:text-left text-lg leading-5 text-gray-600 flex items-center"><span class="material-symbols-outlined">phone_in_talk</span><?php echo $cliente->telefono??'';?></p>
            </div>
            <div class="w-full flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <p class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">
                        local_shipping
                    </span>
                    Dirección de entrega
                </p>
                <p class="m-0 md:text-left text-lg leading-5 text-gray-600">Tipo entrega: <?php echo $factura->entrega??'';?></p>
                <p class="md:text-left text-lg leading-5 text-gray-600"><?php echo $direccion->ciudad.'-'.$direccion->direccion??'';?></p>
                <p class="mt-0 md:text-left text-lg leading-5 text-gray-600">Tarifa envio: $<?php echo number_format($factura->valortarifa??'0', 0, ',', '.');?></p>
            </div>
            <div class="w-full flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <p class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">
                        receipt_long
                    </span>
                    Dirección de facturación
                </p>
                <p class="md:text-left text-lg leading-5 text-gray-600"> - </p>
            </div>
        </div>     
    </div>

    <div class="mt-8 bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
            <!-- OBSERVACIONES -->
            <div class="xl:col-span-2 bg-slate-50 rounded-xl p-6 border border-slate-200 min-h-[100px]">

                <p class="font-semibold text-slate-800 text-xl mb-4">
                    Observaciones
                </p>

                <?php if(empty(trim($factura->observacion ?? ''))): ?>
                    <div class="flex items-center gap-2 mt-6 text-slate-500 italic">
                        <span class="material-symbols-outlined text-xl">
                            info
                        </span>
                        <span>Sin observaciones registradas.</span>
                    </div>
                <?php else: ?>

                    <p class="text-slate-600 text-lg mb-4">
                        <?php echo $factura->observacion;?>
                    </p>

                <?php endif; ?>

                <?php if(!empty($factura->observacioneliminacion)): ?>
                    <div class="border-t border-slate-200 pt-4 mt-4">

                        <p class="font-medium text-red-600 mb-2">
                            Observación de eliminación
                        </p>

                        <p class="text-slate-600 text-lg">
                            <?php echo $factura->observacioneliminacion;?>
                        </p>

                    </div>
                <?php endif; ?>
            </div>

            <!-- RESUMEN DE PAGO -->
            <div class="xl:col-span-1 bg-slate-50 rounded-xl p-5 border border-slate-200">

                <p class="font-semibold text-slate-800 text-xl mb-5">
                    Resumen de pago
                </p>

                <div class="flex justify-between">
                    <div class="text-start">
                        <p class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            Sub Total:
                        </p>

                        <p class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            Abono:
                        </p>

                        <p class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            Impuesto:
                        </p>

                        <p class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            Descuento:
                        </p>

                        <p class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            Tarifa Envío:
                        </p>
                    </div>

                    <div class="text-end">
                        <p id="subTotal" class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            $<?php echo number_format($factura->subtotal ?? 0, 0, ',', '.');?>
                        </p>

                        <p class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            $<?php echo number_format($factura->abono ?? 0, 0, ',', '.');?>
                        </p>

                        <p id="impuesto" class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            $<?php echo number_format($factura->valorimpuestototal ?? 0, 0, ',', '.');?>
                        </p>

                        <p id="descuento" class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            <?php echo $factura->dctox100;?>%
                            $<?php echo number_format($factura->descuento ?? 0, 0, ',', '.');?>
                        </p>

                        <p id="valorTarifa" class="m-0 mb-2 text-slate-600 text-xl font-normal">
                            $<?php echo number_format($factura->valortarifa ?? 0, 0, ',', '.');?>
                        </p>

                    </div>
                </div>

                <!-- TOTAL DESTACADO -->
                <div class="mt-6 bg-emerald-50 border border-emerald-200 rounded-xl px-5 py-4">
                    <div class="flex justify-between items-center">

                        <span class="text-slate-700 text-2xl font-semibold">
                            Total:
                        </span>

                        <span id="total"
                            class="text-emerald-600 text-6xl font-bold"
                            style="font-family:'Tektur', serif;">
                            $ <?php echo number_format($factura->total ?? 0, 0, ',', '.');?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <dialog id="miDialogoFacturar" class="midialog-md !p-12">
      <h4 class="text-3xl font-semibold m-0 text-neutral-800">Registro de pago</h4>
      <hr class="my-4 border-t border-neutral-300">
      <form id="formfacturarCotizacion" class="formulario" method="POST">
          <input id="idcita" name="id" type="hidden">
          <p class="text-gray-600 text-3xl text-center font-light m-0">Total a pagar $: </br><span id="totalPagar" class="text-gray-700 font-semibold">0</span></p>
          <div class="flex justify-center gap-12 mt-8">
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="caja">Caja</label>
              <select id="caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="caja" required>
                  <?php foreach($cajas as $index => $value):?>
                    <option value="<?php echo $value->id;?>" data-idfacturador="<?php echo $value->idtipoconsecutivo;?>"><?php echo $value->nombre;?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="facturador">Facturador</label>
              <select id="facturador" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 h-14 text-xl focus:outline-none focus:ring-1" name="facturador" required>
                <?php foreach($consecutivos as $index => $value):?>
                  <option data-idtipofacturador="<?php echo $value->idtipofacturador;?>" value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
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


     <!-- MODAL DE MAS OPCIONES -->
    <dialog id="miDialogoMasOpciones" class="rounded-2xl border border-gray-200 w-[95%] max-w-2xl p-8 bg-white backdrop:bg-black/40">
        <!-- Encabezado -->
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <div>
                <h4 id="modalMasOpciones"
                    class="text-2xl font-bold text-gray-900">
                    Más opciones
                </h4>

                <p class="text-sm text-slate-500 mt-1">
                    Acciones adicionales disponibles para esta orden.
                </p>
            </div>
            <button class="rounded-lg hover:bg-gray-100 transition">
                <i id="btnXCerrarMasOpciones" class="p-2 fa-solid fa-xmark text-gray-600 text-3xl"></i>
            </button>
        </div>

        <!-- Opciones -->
        <div class="flex flex-col gap-4">
            <button id="btnImprimirTirilla" class="flex items-center justify-between px-6 py-6 rounded-xl border border-gray-200 hover:bg-indigo-50 transition">
                <span class="flex items-center gap-3 text-gray-900 text-lg font-medium">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">receipt_long</span>
                    Imprimir factura tirilla
                </span>
                <i class="fa-solid fa-chevron-right text-gray-400 text-xl"></i>
            </button>

            <?php if($factura->estado=='Paga' || $factura->remision == 1):?>
            <button id="btnOrdenEnvio" class="flex items-center justify-between px-6 py-6 rounded-xl border border-gray-200 hover:bg-indigo-50 transition">
                <span class="flex items-center gap-3 text-gray-900 text-lg font-medium">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">local_shipping</span>
                    Imprimir Orden de entrega
                </span>
                <i class="fa-solid fa-chevron-right text-gray-400 text-xl"></i>
            </button>
            <?php endif; ?>
        </div>
    </dialog>


    <!-- MODAL PARA ELIMINAR ORDEN-->
    <?php include __DIR__. "/modalEliminarOrden.php"; ?>
    <!-- MODAL DETALLE DE PRODUCTO COMPUESTO-->
    <?php include __DIR__. "/modalProductoCompuesto.php"; ?>
    <!-- MODAL PARA CAMBIAR USUARIO Y COMSION DE VENTA -->
    <?php include __DIR__. "/modalCambiarUsuario.php"; ?>
    <!-- MODAL PARA ENVIAR FACTURA POR EMAIL -->
    <?php include __DIR__. "/modalSendInvoiceEmail.php"; ?>
    <!-- MODAL REMISION -->
    <?php include __DIR__. "/remision.php"; ?>
</div>