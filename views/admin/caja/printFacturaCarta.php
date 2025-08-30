<div>
    <!-- Invoice -->
    <div class="max-w-[85rem] px-16 mx-auto my-10">
        
        <!-- Grid -->
        <div class="flex justify-between">
            <div>
                <div class="grid space-y-3">
                    <img class=" w-48 h-24" src="/build/img/Logoj2indigo.png" alt="user">
                    <dl class="flex flex-col gap-y-3 text-sm pt-20">
                        <div class="font-medium text-gray-800">
                            <span class="block font-semibold">Facturado a:</span>
                            <span class="block font-semibold">Carlos Antonio</span>
                            <address class="not-italic font-normal text-gray-400">
                            NIT/CC: 1095223618,<br>
                            Email: lupelulu@gmail.com,<br>
                            Contacto: 3156982231<br>
                            </address>
                        </div>
                        <div class="font-medium text-gray-800">
                            <span class="block font-semibold"> Detalle de entrega:</span>
                            <address class="not-italic font-normal text-gray-400">
                            280 Suzanne Throughway,<br>
                            Armenia - Quindo<br>
                            </address>
                        </div>
                    </dl>
                </div>
            </div>
            <!-- Col -->

            <div>
                <div class="grid font-medium text-gray-800 text-center text-sm">
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
                    
                    <div class="text-sm">
                        <p class="min-w-36 max-w-[200px] text-gray-800 text-lg font-semibold">FACTURA #:</p>
                        <span class="text-gray-500">POS-<?php echo $factura->id??'';?></span>
                    </div>

                    <div class="font-medium text-gray-800 text-sm">
                        <address class="not-italic font-normal">
                        280 Suzanne Throughway,<br>
                        Breannabury, OR 45801,<br>
                        United States<br>
                        </address>
                    </div>

                    <dl class="flex flex-col gap-x-1 text-sm pt-8">
                        <p class="font-medium min-w-36 max-w-[200px] text-gray-800">
                            Fecha de factura: <span class=" font-normal text-gray-400"><?php echo $factura->fechapago??'';?></span>
                        </p>
                        <p class="font-medium text-gray-800">
                            Metodo de pago: <span class="font-normal text-gray-400">Contado</span>
                        </p>
                    </dl>

                </div>
            </div>
            <!-- Col -->
        </div>
        <!-- End Grid -->

        <!-- Table -->
        <div class="mt-6 border border-gray-200 p-4 rounded-lg space-y-4 dark:border-neutral-700">
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
                        <p class="text-lg text-gray-800"><?php echo $value->valorunidad??'';?></p>
                    </div>
                    <div>
                        <p class="text-lg sm:text-end text-gray-800">$<?php echo $value->total??'';?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <!--
            <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                <div class="col-span-full sm:col-span-2">
                    <p class="text-lg font-medium text-gray-800">Web project</p>
                </div>
                <div>
                    <p class="text-lg text-gray-800">1</p>
                </div>
                <div>
                    <p class="text-lg text-gray-800">24</p>
                </div>
                <div>
                    <p class="text-lg sm:text-end text-gray-800">$1250</p>
                </div>
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                <div class="col-span-full sm:col-span-2">
                    <p class="text-lg font-medium text-gray-800">SEO</p>
                </div>
                <div>
                    <p class="text-lg text-gray-800">1</p>
                </div>
                <div>
                    <p class="text-lg text-gray-800">6</p>
                </div>
                <div>
                    <p class="text-lg sm:text-end text-gray-800">$2000</p>
                </div>
            </div>-->
        </div>
        <!-- End Table -->

        <!-- Flex -->
        <div class="mt-8 flex sm:justify-end">
            <div class="w-full max-w-2xl sm:text-end space-y-2">
            <!-- Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                    <dt class="col-span-3 text-gray-400">Subotal:</dt>
                    <dd class="col-span-2 font-medium text-gray-800">$<?php echo $factura->subtotal??'';?></dd>
                </dl>

                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                    <dt class="col-span-3 text-gray-400">Descuento:</dt>
                    <dd class="col-span-2 font-medium text-gray-800">$<?php echo $factura->descuento??'';?></dd>
                </dl>

                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                    <dt class="col-span-3 text-gray-400">Impuesto:</dt>
                    <dd class="col-span-2 font-medium text-gray-800">$<?php echo $factura->valorimpuestototal??'';?></dd>
                </dl>

                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                    <dt class="col-span-3 text-gray-400">Total:</dt>
                    <dd class="col-span-2 font-medium text-gray-800">$<?php echo $factura->total??'';?></dd>
                </dl>
            </div>
            <!-- End Grid -->
            </div>
        </div>
        <!-- End Flex -->
    </div>
    <!-- End Invoice -->

</div>