<div class="box trasladoinventario p-10 !pb-20 rounded-lg mb-4">
    <div>
        <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <span class="sr-only">Atrás</span>
        </a>
        <h4 class="text-gray-600 mb-5 mt-6">Traslado de inventario</h4>
        <?php include __DIR__."/../../templates/alertas.php"; ?>
    </div>
    <div class="p-6 ">
        <!-- Encabezado -->
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Solicitudes recibidas</h1>
        <p class="text-gray-600 mb-6">Gestiona las solicitudes de productos y materia prima de otras sedes.</p>

        <!-- Indicadores rápidos -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
            <!-- Pendientes -->
            <div class="grid grid-cols-2 items-center bg-indigo-50 rounded-2xl shadow-md p-6 flex-col justify-center hover:scale-105 hover:shadow-lg transition">
                <!-- <div class="bg-indigo-200 text-indigo-700 rounded-full w-12 h-12 flex items-center justify-center text-2xl mb-3">⏳</div> -->
                <div class="text-xl justify-self-start font-semibold text-indigo-600 uppercase tracking-wide">Pendientes</div>
                <div class="justify-self-end text-4xl font-extrabold text-indigo-700">5</div>
            </div>

            <!-- Aprobadas -->
            <div class="grid grid-cols-2 items-center bg-emerald-50 rounded-2xl shadow-md p-6 flex-col justify-center hover:scale-105 hover:shadow-lg transition">
                <!-- <div class="bg-emerald-200 text-emerald-700 rounded-full w-12 h-12 flex items-center justify-center text-2xl mb-3">✅</div> -->
                <div class="text-xl justify-self-start font-semibold text-emerald-600 uppercase tracking-wide">Aprobadas</div>
                <div class="justify-self-end text-4xl font-extrabold text-emerald-700">2</div>
            </div>

            <!-- Rechazadas -->
            <div class="grid grid-cols-2 items-center bg-rose-50 rounded-2xl shadow-md p-6 justify-center hover:scale-105 hover:shadow-lg transition">
                <!-- <div class="bg-rose-200 text-rose-700 rounded-full w-12 h-12 flex items-center justify-center text-2xl mb-3">❌</div> -->
                <div class="text-xl justify-self-start font-semibold text-rose-600 uppercase tracking-wide">Rechazadas</div>
                <div class="justify-self-end text-4xl font-extrabold text-rose-700">1</div>
            </div>

            <!-- Entregadas -->
            <div class="grid grid-cols-2 items-center bg-sky-50 rounded-2xl shadow-md p-6 justify-center hover:scale-105 hover:shadow-lg transition">
                <!-- <div class="bg-sky-200 text-sky-700 rounded-full w-12 h-12 flex items-center justify-center text-2xl mb-3">📦</div> -->
                <div class="text-xl justify-self-start font-semibold text-sky-600 uppercase tracking-wide">Entregadas</div>
                <div class="justify-self-end text-4xl font-extrabold text-sky-700">3</div>
            </div>
        </div> <!-- End Indicadores rápidos -->

        <!-- Filtros -->
        <div class="flex gap-3 mb-6 w-full flex-col md:flex-row p-2">
            <input type="text" placeholder="Buscar por # o producto..." class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-1/2 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
            
            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-1/4 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
            <option value="">Todas las sedes</option>
            <option value="norte">Sede Norte</option>
            <option value="centro">Sede Centro</option>
            </select>

            <select class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-1/4 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
            <option value="">Todos los estados</option>
            <option value="pendiente">Pendiente</option>
            <option value="aprobado">Aprobado</option>
            <option value="rechazado">Rechazado</option>
            <option value="entregado">Entregado</option>
            </select>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 text-base font-semibold uppercase tracking-wide">
                    <tr>
                    <th class="p-4"># Solicitud</th>
                    <th class="p-4">Sede</th>
                    <th class="p-4">Usuario</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-lg divide-y divide-gray-100">

                    <!-- Pendiente -->
                    <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-900">00123</td>
                    <td class="p-4">Sede Norte</td>
                    <td class="p-4">Carlos Pérez</td>
                    <td class="p-4">12/09/2025</td>
                    <td class="p-4">
                        <span class="px-3 py-1 text-base font-semibold bg-indigo-100 text-indigo-600 rounded-full">
                        Pendiente
                        </span>
                    </td>
                    <td class="p-4 flex items-center justify-center gap-2">
                        <button class="flex items-center gap-1 px-3 py-1 text-base text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                            👁 Ver
                        </button>
                        <button class="w-11 h-11 flex items-center justify-center text-green-600 border border-green-200 rounded-full hover:bg-green-50 text-xl">✅</button>
                        <button class="w-11 h-11 flex items-center justify-center text-rose-600 border border-rose-200 rounded-full hover:bg-rose-50 text-xl">❌</button>
                    </td>
                    </tr>

                    <!-- Aprobada -->
                    <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-900">00124</td>
                    <td class="p-4">Sede Sur</td>
                    <td class="p-4">Ana Gómez</td>
                    <td class="p-4">11/09/2025</td>
                    <td class="p-4">
                        <span class="px-3 py-1 text-base font-semibold bg-emerald-100 text-emerald-600 rounded-full">
                        Aprobada
                        </span>
                    </td>
                    <td class="p-4 flex items-center justify-center gap-2">
                        <button class="flex items-center gap-1 px-3 py-1 text-base text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                            👁 Ver
                        </button>
                        <button class="w-11 h-11 flex items-center justify-center text-green-600 border border-green-200 rounded-full hover:bg-green-50 text-xl">✅</button>
                        <button class="w-11 h-11 flex items-center justify-center text-rose-600 border border-rose-200 rounded-full hover:bg-rose-50 text-xl">❌</button>
                    </td>
                    </tr>

                    <!-- Rechazada -->
                    <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-900">00125</td>
                    <td class="p-4">Sede Centro</td>
                    <td class="p-4">Luis Torres</td>
                    <td class="p-4">10/09/2025</td>
                    <td class="p-4">
                        <span class="px-3 py-1 text-base font-semibold bg-rose-100 text-rose-600 rounded-full">
                        Rechazada
                        </span>
                    </td>
                    <td class="p-4 flex items-center justify-center gap-2">
                        <button class="flex items-center gap-1 px-3 py-1 text-base text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                            👁 Ver
                        </button>
                        <button class="w-11 h-11 flex items-center justify-center text-green-600 border border-green-200 rounded-full hover:bg-green-50 text-xl">✅</button>
                        <button class="w-11 h-11 flex items-center justify-center text-rose-600 border border-rose-200 rounded-full hover:bg-rose-50 text-xl">❌</button>
                    </td>
                    </tr>

                    <!-- Entregada -->
                    <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-900">00126</td>
                    <td class="p-4">Sede Oeste</td>
                    <td class="p-4">María López</td>
                    <td class="p-4">09/09/2025</td>
                    <td class="p-4">
                        <span class="px-3 py-1 text-base font-semibold bg-sky-100 text-sky-600 rounded-full">
                        Entregada
                        </span>
                    </td>
                    <td class="p-4 flex items-center justify-center gap-2">
                        <button class="flex items-center gap-1 px-3 py-1 text-base text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                            👁 Ver
                        </button>
                        <button class="w-11 h-11 flex items-center justify-center text-green-600 border border-green-200 rounded-full hover:bg-green-50 text-xl">✅</button>
                        <button class="w-11 h-11 flex items-center justify-center text-rose-600 border border-rose-200 rounded-full hover:bg-rose-50 text-xl">❌</button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>