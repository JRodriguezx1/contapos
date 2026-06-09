<dialog id="miDialogoEnviarEmailCliente"
    class="rounded-2xl border border-gray-200 w-[95%] max-w-lg p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">

    <!-- Encabezado -->
    <div class="text-center border-b border-gray-200 pb-4 mb-4">

        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-100 mb-4">
            <i class="fa-solid fa-envelope text-indigo-600 text-4xl"></i>
        </div>

        <h4 id="modalEnviarEmail"
            class="text-3xl font-bold text-indigo-700">
            Enviar por correo
        </h4>

        <p class="mt-2 text-gray-500 text-lg">
            Envíe el detalle de la orden al correo electrónico del cliente.
        </p>

    </div>

    <div id="divmsjalertaEnviarEmail"></div>

    <form id="formEnviarEmailCliente"
        class="formulario"
        method="POST">

        <!-- Correo -->
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">

            <label
                for="inputEmail"
                class="block text-lg font-semibold text-slate-700 mb-3">

                Correo del cliente
            </label>

            <div class="relative">

                <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                <input
                    id="inputEmail"
                    class="w-full h-14 pl-12 pr-4 bg-white border border-slate-300 rounded-xl text-lg focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600"
                    type="email"
                    placeholder="cliente@email.com"
                    required>

            </div>

            <p class="text-sm text-slate-500 mt-3">
                Se enviará una copia de la orden a este correo.
            </p>

        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">

            <button
                class="btn-md btn-turquoise !py-4 !w-[120px]"
                type="button"
                value="Salir">

                Salir
            </button>

            <input
                id="btnEnviarEmailCliente"
                class="btn-md btn-indigo !py-4 !w-[120px]"
                type="submit"
                value="Enviar">
        </div>
    </form>
</dialog>