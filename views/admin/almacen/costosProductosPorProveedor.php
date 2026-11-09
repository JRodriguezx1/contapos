<div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
        <div class="mb-2 flex items-center gap-2 text-xs font-medium text-slate-500"><span>Inventario</span><span>/</span><span class="text-indigo-600">Costos por proveedor</span></div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Costos por proveedor</h1>
        <p class="mt-1 text-sm text-slate-500">Compara los costos de compra y encuentra el mejor proveedor de cada producto.</p>
        </div>
        <button id="btnAdd" type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Actualizar costo
        </button>
    </div>

    <section aria-label="Indicadores" class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm"><p class="text-xs font-medium text-slate-500">Productos</p><p id="statProducts" class="mt-1 text-2xl font-semibold text-slate-900">0</p></div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm"><p class="text-xs font-medium text-slate-500">Con varios proveedores</p><p id="statMultiple" class="mt-1 text-2xl font-semibold text-slate-900">0</p></div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm"><p class="text-xs font-medium text-slate-500">Cotizaciones registradas</p><p id="statQuotes" class="mt-1 text-2xl font-semibold text-slate-900">0</p></div>
    </section>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm" aria-label="Listado de productos">
        <div class="flex flex-col gap-3 border-b border-slate-200 p-4 md:flex-row md:items-center">
            <div class="relative min-w-0 flex-1">
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                <input id="search" type="search" placeholder="Buscar por nombre, código o proveedor..." aria-label="Buscar productos" class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm outline-none placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
            </div>
            <select id="filter" aria-label="Filtrar productos" class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                <option value="all">Todos los productos</option>
                <option value="multiple">Con varios proveedores</option>
                <option value="single">Con un proveedor</option>
                <option value="none">Sin proveedor</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] border-collapse text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th scope="col" class="px-5 py-3">Producto</th><th scope="col" class="px-5 py-3">Proveedores</th><th scope="col" class="px-5 py-3">Mejor proveedor</th><th scope="col" class="px-5 py-3 text-right">Menor costo</th><th scope="col" class="px-5 py-3 text-right">Ver</th></tr>
                </thead>
                <tbody id="productsBody" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
        <div class="flex items-center justify-between border-t border-slate-200 px-5 py-3 text-xs text-slate-500"><span id="counter"></span><span>Valores de demostración · COP</span></div>
    </section>
</div>