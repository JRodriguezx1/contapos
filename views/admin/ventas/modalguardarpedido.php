<!-- MODAL PARA GUARDAR EL PEDIDO-->
<dialog id="miDialogoGuardar"
    class="rounded-2xl border border-gray-200 w-[95%] max-w-2xl p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">

    <div class="text-center">
        <p class="text-2xl font-bold text-indigo-700 mb-6">
            Generar orden
        </p>

        <p class="text-lg text-gray-600 leading-relaxed">
            La orden No: <?php echo $num_orden;?> se registrará en el sistema.
            Podrá volver a retomarla posteriormente.
        </p>
    </div>

    <div class="flex justify-center gap-4 w-full border-t border-gray-200 pt-6 mt-6">
        <button class="btn-md btn-blue !py-4 !px-6 !w-[140px] cotizacion">
            Cotización
        </button>

        <button class="btn-md btn-indigo !py-4 !px-6 !w-[140px] remision">
            Remisión
        </button>
    </div>

</dialog>
