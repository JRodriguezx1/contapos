<!-- MODAL PARA REDMIR O CAJEAR PUNTOS -->
<dialog id="miDialogoRedimir" class="midialog-sm">

    <div class="max-h-[88vh] overflow-y-auto p-10">
        <div class="flex items-start gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-6 mb-7">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 shadow-sm">
                <i class="fa-solid fa-box-open text-3xl"></i>
            </div>

            <div class="min-w-0">
                <p class="text-base font-bold uppercase tracking-wide text-indigo-600">Liberar producto</p>
                <h4 class="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight">Redimir Puntos</h4>
                <p class="mt-2 text-lg text-slate-500">Redimir puntos por productos o servicios de la tienda</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 sm:p-7">

            <div class="mb-5 flex items-start gap-3 border-b border-slate-200 pb-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                    <i class="fa-solid fa-user text-xl"></i>
                </div>
                <div>
                    <h5 id="clienteRedimir" class="text-2xl font-bold text-slate-900">Cliente</h5>
                    <p class="text-base text-slate-500 mt-0">Puntos acumulados del cliente.</p>
                </div>
            </div>

            
                <div class="flex justify-center gap-8 items-center">
                    <label for="cantidadPuntos" class="block text-lg font-semibold text-slate-700">Puntos:</label>
                    <div class="flex items-center gap-4">
                        <i class="fa-solid fa-gift text-3xl" style="color: rgb(130, 22, 221);"></i>
                        <div>
                            <p id="viewPtsCli" class="text-slate-900 text-3xl font-bold mb-0 leading-5"> - </p>
                            <small id="valorTotalPts" class="text-base font-medium text-slate-500"> - </small>
                        </div>
                        
                    </div>
                </div>
                <div class="flex justify-center items-center gap-2 mt-4">
                    <input
                        id="inputCantidadPuntos"
                        type="text"
                        name="cantidadPuntos"
                        autocomplete="off"
                        class="h-12 max-w-52 rounded-xl border border-slate-300 bg-white px-4 text-xl text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        placeholder="Ej: 350"
                        required
                        oninput="formatearMoneda(this)"
                    >
                    <button id="aplicarPtsFactura" class="btn-xs btn-indigo">Aplicar Factura</button>
                </div>
                <small id="puntosValor" class="text-base font-medium text-slate-500 block text-center">$0</small>
            </div>
                
            <div class="mt-5 grid grid-cols-2 gap-3 border-t border-slate-200 pt-4">
                <button type="button" class="btn-md btn-turquoise salir !m-0 !w-full !py-4">Cancelar</button>
                <input id="btnAplicarRedimir" type="submit" value="Redimir" class="redimir btn-md btn-indigo !m-0 !w-full !py-4">
            </div>
        
    </div>
</dialog>