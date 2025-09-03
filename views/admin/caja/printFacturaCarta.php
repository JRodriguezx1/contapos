<div class="min-h-screen flex flex-col">
    <!-- Contenedor Factura -->
    <div class="flex-1">
        <!-- Invoice -->
        <div class="max-w-[85rem] px-16 mx-auto my-10">

            <!-- Grid -->
            <div class="flex justify-between">
                <div>
                    <div class="grid space-y-3">
                        <img class="w-auto h-24" src="/build/img/Logoj2indigo.png" alt="user">
                        <dl class="flex flex-col gap-y-3 text-sm pt-20">
                            <div class="font-medium text-gray-800 text-lg leading-normal">
                                <span class="block font-semibold uppercase">Facturado a</span>
                                <span class="not-italic font-normal text-gray-400">Carlos Antonio</span>
                                <address class="not-italic font-normal text-gray-400">
                                    <span class="font-semibold">NIT/CC:</span> 1095223618,<br>
                                    <span class="font-semibold uppercase">Email:</span> lupelulu@gmail.com,<br>
                                    <span class="font-semibold uppercase">Teléfono:</span> 3156982231<br>
                                </address>
                            </div>
                            <div class="font-medium text-gray-800 text-lg leading-normal mt-6">
                                <span class="block font-semibold uppercase">Dirección de entrega</span>
                                <address class="not-italic font-normal text-gray-400">
                                    280 Suzanne Throughway,<br>
                                    Armenia - Quindo<br>
                                </address>
                            </div>
                        </dl>
                    </div>
                </div>
                <!-- Col -->

                <div class="text-lg leading-normal">
                    <div class="grid font-medium text-gray-800 text-center text-lg leading-normal">
                        <span class="block font-semibold text-lg uppercase">Innova Tech SAS</span>
                        <address class="not-italic font-light">
                            Cr 14 #18-31 Edificion SUr,<br>
                            Tel: 3183658250,<br>
                            Armenia - Quindio,<br>
                            contabilidad@innovatech.com,<br>
                            www.innovatech.com<br>
                        </address>
                    </div>
                </div>
                <!-- Col -->

                <div>
                    <div class="grid space-y-3">
                        <div class="text-lg leading-normal">
                            <p class="min-w-36 max-w-[200px] text-gray-800 text-lg font-semibold">FACTURA #:</p>
                            <span class="text-gray-500">POS-<?php echo $factura->id??'';?></span>
                        </div>

                        <div class="font-medium text-gray-800 text-lg leading-normal">
                            <address class="not-italic font-normal">
                                280 Suzanne Throughway,<br>
                                Breannabury, OR 45801,<br>
                                United States<br>
                            </address>
                        </div>

                        <div class="flex flex-col gap-x-1 pt-8 text-lg leading-normal">
                            <p class="font-medium min-w-36 max-w-[200px] text-gray-800">
                                <span class="uppercase"> Fecha y Hora de Factura</span> <br>
                                <span class=" font-normal text-gray-400"><?php echo $factura->fechapago??'';?></span>
                            </p>
                            <p class="font-medium text-gray-800 mt-5">
                                <span class="uppercase"> Metodo de Pago</span> <br>
                                <span class="font-normal text-gray-400">Contado</span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Col -->
            </div>
            <!-- End Grid -->

            <!-- Table -->
            <div class="mt-6 border border-gray-200 p-4 rounded-lg space-y-4 dark:border-neutral-700 text-lg leading-normal">
                <div class="hidden sm:grid sm:grid-cols-5">
                    <div class="sm:col-span-2 text-base font-nomal text-gray-400 uppercase">Item</div>
                    <div class="text-start text-base font-nomal text-gray-400 uppercase">Cantidad</div>
                    <div class="text-start text-base font-nomal text-gray-400 uppercase">Vr. Unitario</div>
                    <div class="text-end text-base font-nomal text-gray-400 uppercase">Vr. Total</div>
                </div>
                <div class="hidden sm:block border-b border-gray-200 dark:border-neutral-700"></div>

                <?php foreach($productos as $index=>$value): ?>
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                        <div class="col-span-full sm:col-span-2">
                            <p class="text-lg font-medium text-gray-800"><?php echo $value->nombreproducto??'';?></p>
                        </div>
                        <div>
                            <p class="text-lg text-gray-800"><?php echo $value->cantidad??'';?></p>
                        </div>
                        <div>
                            <p class="text-lg text-gray-800"><?php echo number_format($value->valorunidad??'', '0', ',', '.');?></p>
                        </div>
                        <div>
                            <p class="text-lg sm:text-end text-gray-800">$<?php echo number_format($value->total??'', '0', ',', '.');?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End Table -->

            <!-- Totales -->
            <div class="mt-8 flex sm:justify-end">
                <div class="w-full max-w-2xl sm:text-end space-y-2">
                    <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-400">Subotal:</dt>
                            <dd class="col-span-2 font-medium text-gray-800">$<?php echo number_format($factura->subtotal??'', '0', ',', '.');?></dd>
                        </dl>

                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-400">Descuento:</dt>
                            <dd class="col-span-2 font-medium text-gray-800">$<?php echo number_format($factura->descuento??'', '0', ',', '.');?></dd>
                        </dl>

                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-400">Impuesto:</dt>
                            <dd class="col-span-2 font-medium text-gray-800">$<?php echo number_format($factura->valorimpuestototal??'', '0', ',', '.');?></dd>
                        </dl>

                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-400">Total:</dt>
                            <dd class="col-span-2 font-medium text-gray-800">$<?php echo number_format($factura->total??'','0', ',', '.');?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <!-- End Totales -->

            <!-- Observaciones -->
            <div class="mt-8">
                <div class="border border-gray-200 p-4 rounded-lg space-y-2 text-lg leading-normal">
                    <span class="block font-semibold uppercase text-gray-800">Observaciones</span>
                    <p class="text-gray-500">
                        <?php echo $factura->observaciones ?? 'Ninguna'; ?>
                    </p>
                </div>
            </div>
            <!-- End Observaciones -->
        </div>
        <!-- End Invoice -->
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-200 py-6 text-center text-sm text-gray-400 leading-relaxed">
        <p class="mb-2">Esta factura es un documento válido generado por <span class="font-semibold text-gray-600">Innova Tech SAS</span>.</p>
        <p class="mb-1">Gracias por confiar en nosotros.</p>
        <p class="mb-1">Contáctanos: <a href="mailto:contabilidad@innovatech.com" class="text-indigo-600 hover:underline">contabilidad@innovatech.com</a> | Tel: 3183658250</p>
        <p class="mb-1">Dirección: Cr 14 #18-31 Edificio Sur, Armenia - Quindío</p>
        <p class="mt-4 text-xs text-gray-400">© <?php echo date("Y"); ?> Innova Tech SAS. Todos los derechos reservados.</p>
    </footer>
    <!-- End Footer -->
</div>
