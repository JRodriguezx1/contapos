<div class="box min-h-screen flex items-center justify-center">
    <div class="max-w-screen-lg w-full p-6 mb-56">
        <div class="bg-white shadow-2xl rounded-2xl border border-gray-100 overflow-hidden">

            <!-- HEADER -->
            <div class="bg-red-50 border-b border-red-100 p-6 flex items-center gap-4">
                <div class="bg-red-100 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46
                        0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-red-700">Cuenta suspendida</h1>
                    <p class="text-red-600 text-lg">Tu suscripción ha vencido. Realiza el pago para reactivar tu sistema.</p>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="grid md:grid-cols-2 gap-8 p-12">
                <!-- ESTADO DE CUENTA -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Estado de cuenta</h2>
                    <div class="space-y-4 text-xl">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Sucursal</span>
                            <span class="font-medium"><?= $sucursal->nombre; ?></span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Plan</span>
                            <span class="font-medium"><?= $sucursal->plan->nombre; ?></span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Precio</span>
                            <span class="font-semibold">$<?= number_format($sucursal->valorplan, '2', ',', '.'); ?></span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Fecha vencimiento</span>
                            <span class="font-medium"><?= $sucursal->fecha_corte; ?></span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Días vencidos</span>
                            <span class="font-medium text-red-600"></span>
                        </div>
                    </div>
                </div>

                <!-- MEDIOS DE PAGO -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Medios de pago</h2>
                    <div class="space-y-8 text-xl">
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <p class="font-semibold text-gray-700 mb-2">Transferencia Bancaria</p>
                            <p class="text-gray-500">Banco: Bancolombia</p>
                            <p class="text-gray-500">Cuenta: 123456789</p>
                            <p class="text-gray-500">Titular: Tu Empresa SAS</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <p class="font-semibold text-gray-700 mb-2">Nequi / Daviplata</p>
                            <p class="text-gray-500">Número: 3001234567</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="border-t p-6 flex flex-col md:flex-row gap-4 justify-between items-center">
                <a 
                    href="https://wa.me/573234433298?text=Hola%20acabo%20de%20realizar%20el%20pago%20de%20mi%20suscripción"
                    target="_blank"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                    Enviar comprobante por WhatsApp
                </a>
                <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">Ya realicé el pago</a>
            </div>

        </div>
        <p class="text-center text-base text-gray-600 mt-10">© <?= date('Y') ?> J2 SOFTWARE MULTISUCURSAL</p>
    </div>

</div>