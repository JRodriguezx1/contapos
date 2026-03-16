<?php

$fechaVencimiento = new DateTime($sucursal->fecha_corte);
$hoy = new DateTime();

$diferencia = $hoy->diff($fechaVencimiento);
$diasVencidos = $diferencia->days;

$estaVencido = $hoy > $fechaVencimiento;

?>

<div class="box min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100">
    
    <!-- CONTENEDOR RELATIVE -->
    <div class="max-w-screen-lg w-full p-6 mb-40 relative">

        <!-- EFECTOS GLOW -->
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-400 opacity-20 blur-3xl rounded-full"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-purple-400 opacity-20 blur-3xl rounded-full"></div>

        <!-- TARJETA PRINCIPAL -->
        <div class="bg-white shadow-xl rounded-3xl border border-gray-200 overflow-hidden relative">

            <!-- HEADER -->
            <div class="w-full border-b border-white/20 relative p-8 flex items-center gap-6 overflow-hidden
            bg-[linear-gradient(to_left,_rgba(37,99,235,0.9)_0%,_rgba(79,70,229,0.9)_85%,_rgba(147,51,234,0.9)_100%)]
            hover:bg-[linear-gradient(to_left,_rgba(126,34,206,0.9)_0%,_rgba(79,70,229,0.9)_85%,_rgba(37,99,235,0.9)_100%)]
            transition-all duration-500
            before:content-[''] before:absolute before:top-0 before:right-0 before:w-1/3 before:h-full
            before:bg-[radial-gradient(circle_at_90%_50%,rgba(255,255,255,0.25),transparent_70%)]">

                <img src="/build/img/Logoj2blanco.png"
                     alt="J2 Software POS"
                     class="h-24 w-auto relative z-10">

                <div class="bg-white/20 p-3 rounded-full relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46
                        0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>

                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-white">
                        Cuenta suspendida
                    </h1>
                    <p class="text-white/90 text-lg mt-1">
                        Tu suscripción ha vencido. Realiza el pago para reactivar tu sistema.
                    </p>
                </div>

            </div>

            <!-- CONTENIDO -->
            <div class="grid md:grid-cols-2 gap-10 p-10">

                <!-- ESTADO DE CUENTA -->
                <div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        Estado de cuenta
                    </h2>

                    <div class="mb-4 text-base text-gray-500">
                        Tu acceso al sistema está temporalmente suspendido hasta recibir el pago.
                    </div>

                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 space-y-4 text-lg">

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Sucursal</span>
                            <span class="font-semibold text-gray-800"><?= $sucursal->nombre; ?></span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Plan</span>
                            <span class="font-semibold text-gray-800"><?= $sucursal->plan->nombre; ?></span>
                        </div>

                        <div class="border-b pb-4">

    <span class="text-gray-600 text-lg">Precio del plan</span>

    <div class="flex items-center justify-between mt-2">

        <span class="inline-block bg-blue-100 text-blue-700 text-sm font-semibold px-3 py-1 rounded-lg">
            <?= $sucursal->plan->nombre; ?>
        </span>

        <span class="text-4xl font-extrabold text-blue-600 tracking-tight">
            $<?= number_format($sucursal->valorplan, 2, ',', '.'); ?>
        </span>

    </div>

</div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Fecha vencimiento</span>
                            <span class="font-semibold text-red-500">
                                <?= $sucursal->fecha_corte; ?>
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Días vencidos</span>
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-lg font-bold">
                                <?= $estaVencido ? $diasVencidos : 0; ?>
                            </span>
                        </div>

                    </div>

                </div>

                <!-- MEDIOS DE PAGO -->
                <div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-6">
                        Medios de pago
                    </h2>

                    <div class="space-y-6 text-lg">

                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:shadow-md transition">

                            <p class="font-semibold text-gray-800 mb-3 text-xl">
                                Transferencia Bancaria
                            </p>

                            <p class="text-gray-600">Banco: Bancolombia</p>
                            <p class="text-gray-600">Cuenta: -</p>
                            <p class="text-gray-600">Titular: -</p>

                        </div>

                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:shadow-md transition">

                            <p class="font-semibold text-gray-800 mb-3 text-xl">
                                Nequi / Daviplata
                            </p>

                            <p class="text-gray-600">Número: 3022016786 / 304 2029683</p>

                        </div>

                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:shadow-md transition">

                            <p class="font-semibold text-gray-800 mb-3 text-xl">
                                Bre-B
                            </p>

                            <p class="text-gray-600">Número: @3022016786</p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- AVISO REACTIVACIÓN -->
            <div class="text-center text-base text-gray-500 px-6 pb-2">
                Tu sistema se reactivará automáticamente después de validar el pago. <br>
                Tiempo estimado: <span class="font-semibold text-gray-700">3 minutos</span>.
            </div>

            <!-- BOTONES -->
            <div class="border-t border-gray-200 p-6 flex flex-col md:flex-row gap-4 justify-between items-center">

                <a 
                    href="https://wa.me/573234433298?text=Hola%20acabo%20de%20realizar%20el%20pago%20de%20mi%20suscripción"
                    target="_blank"
                    class="bg-green-500 hover:bg-green-600 text-white px-10 py-3 rounded-xl font-semibold transition shadow-md">

                    Enviar comprobante por WhatsApp

                </a>

                <a href="/login"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-4 rounded-xl font-semibold transition shadow-md">

                    Ya realicé el pago

                </a>

            </div>

        </div>

        <p class="text-center text-base text-gray-500 mt-10">
            © <?= date('Y') ?> J2 SOFTWARE MULTISUCURSAL
        </p>

    </div>

</div>