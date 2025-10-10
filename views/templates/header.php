<!-- <script src="https://cdn.tailwindcss.com"></script> -->

<!-- Flowbite -->
<!-- <script src="https://unpkg.com/flowbite@2.5.1/dist/flowbite.min.js"></script> -->

<div class="barra-mobile">
    <img id="logoj2" class="w-80 h-28" src="/build/img/Logoj2blanco.png" alt="logoj2">
    <!-- <div class="menu">
        <img id="mobile-menu" src="/build/img/menu.svg" alt="imagen menu">
    </div> -->

    <!-- Menú flotante en la parte inferior -->
    <div class="fixed z-50 w-full h-[7rem] max-w-[33rem] -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="grid h-full max-w-[33rem] grid-cols-5 mx-auto group">
            <a href="/admin/configuracion" data-tooltip-target="tooltip-home" class="inline-flex flex-col items-center justify-center px-5 rounded-s-full hover:bg-gray-50 dark:hover:bg-gray-800">
                <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.25V1m0 11.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M4 19v-2.25m6-13.5V1m0 2.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M10 19V7.75m6 4.5V1m0 11.25a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM16 19v-2"/>
                </svg>
                <span class="sr-only">Settings</span>
                <p class="text-base my-0 text-gray-500">Ajuste</p>
            </a>

            <a href="/admin/almacen" data-tooltip-target="tooltip-almacen" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z"/>
                    <path d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7 1.352L12.62 4Z"/>
                </svg>
                <span class="sr-only">Almacén</span>
                <p class="text-base my-0 text-gray-500">Almacén</p>
            </a>

            <div class="flex items-center justify-center menu">
                <button data-tooltip-target="tooltip-new" id="mobile-menu1" type="button" class="inline-flex items-center justify-center w-14 h-14 font-medium bg-indigo-500 rounded-full hover:bg-indigo-600 group focus:ring-4 focus:ring-indigo-300 focus:outline-none dark:focus:ring-indigo-700">
                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                    <span class="sr-only">Más opciones</span>
                </button>
            </div>
            
            <a href="/admin/caja" data-tooltip-target="tooltip-caja"    class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <!-- Ícono caja registradora -->
                <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500" 
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M4 10h16v10H4zM8 10V6h8v4M7 14h10M7 18h10M10 6h4" />
                </svg>
                <span class="sr-only">Módulo de Caja</span>
                <p class="text-base my-0 text-gray-500">Caja</p>
            </a>

            <a href="/admin/ventas" data-tooltip-target="tooltip-venta" class="inline-flex flex-col items-center justify-center px-5 rounded-e-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
                <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-500" 
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 
                            0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zm-12.83-2h13.66c.75 
                            0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0 0 22.34 7H6.21l-.94-2H1v2h3l3.6 
                            7.59-1.35 2.44C5.11 17.37 6 19 7 19h12v-2H7l1.1-2h9.45c.75 
                            0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0 0 22.34 7H6.21z"/>
                </svg>
                <span class="sr-only">Ventas</span>
                <p class="text-base my-0 text-gray-500">Venta</p>
            </a>
            <div id="tooltip-venta" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Ventas
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
</div>

<div class="barra">
    <div class="toggleanduser"><span class="sidebartoggle material-symbols-outlined">menu</span><p><span><?php echo $_SESSION['nombre']; ?></span></p></div>

    <div class="flex items-center gap-4 mr-4">
        <a class="cerrar-sesion !bg-indigo-600 hover:!bg-indigo-700" href="/logout">Cerrar Sesión</a>

        <button type="button" data-dropdown-toggle="notification-dropdown" class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300">
            <i class="text-4xl fa-solid fa-bell"></i>
        </button>

        <button id="notification-dropdown" type="button" class="group relative flex rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown">
            <img class="w-14 h-14 rounded-full" src="/build/img/avatar/avatar9.jpg" alt="user"/>
            <div class="absolute z-10 bg-white flex flex-col items-start top-full right-0 rounded-lg pt-2 pb-3 px-4 shadow-md scale-y-0 group-hover:scale-y-100 origin-top duration-200">    
                <span class="w-full text-start text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3"><?php echo nombreSucursal(); ?></span>
                <a class="w-full text-start text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/admin/dashboard">name@j2software.com</a>
                <a class="w-full text-start text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/admin/dashboard">Dashboard</a>
                <a class="w-full text-start text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/admin/perfil">mi Perfil</a>
                <a class="w-full text-start text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/admin/dashboard">Settings</a>
                <a class="w-full text-start text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/logout">Sign out</a>
            </div>
        </button>
    </div>
</div>

<!-- Menú movil barra inferior -->
<dialog id="miDialogomenumovil" class="p-0 w-[90%] max-w-6xl h-[75%] bg-white rounded-lg" hidden>
  <!-- Fondo semi-transparente -->
  <div class="fixed inset-0 bg-black bg-opacity-40" onclick="document.getElementById('miDialogomenumovil').close()"></div>
  
  <!-- Contenedor del menú -->
  <div class="relative w-auto h-full py-8 px-10 flex flex-col justify-between bg-white">
    <div class="flex justify-center">
        <img id="logoj2" class="w-80 h-28" src="/build/img/Logoj2indigo.png" alt="logoj2">
    </div>
    <!-- Encabezado con botón cerrar -->
    <div class="flex items-center justify-between mb-6 mt-4">
      <h4 class="text-4xl font-semibold text-gray-700 dark:text-gray-200">Menú</h4>
      <button onclick="document.getElementById('miDialogomenumovil').close()" 
              class="w-10 h-10 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
        <span class="material-symbols-outlined text-4xl">close</span>
      </button>
    </div>

    <nav class="flex flex-col space-y-3">
      <!-- Inicio -->
      <a href="/admin/dashboard" class="flex items-center text-2xl gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700   bg-gray-50 border-b border-gray-300 text-gray-900 focus:border-indigo-600 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-20 focus:outline-none focus:ring-0">
        <span class="material-symbols-outlined text-indigo-500 text-2xl">home</span>
        <span>Inicio</span>
      </a>

      <!-- Reportes -->
      <a href="/admin/reportes" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700   bg-gray-50 border-b border-gray-300 text-gray-900 focus:border-indigo-600 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-20 text-2xl focus:outline-none focus:ring-0">
        <span class="material-symbols-outlined text-indigo-500 text-2xl">format_list_bulleted</span>
        <span>Reportes</span>
      </a>

      <!-- Clientes -->
      <a href="/admin/clientes" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700   bg-gray-50 border-b border-gray-300 text-gray-900 focus:border-indigo-600 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-20 text-2xl focus:outline-none focus:ring-0">
        <span class="material-symbols-outlined text-indigo-500 text-2xl">support_agent</span>
        <span>Clientes</span>
      </a>

      <!-- Perfil -->
      <a href="/admin/perfil" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700   bg-gray-50 border-b border-gray-300 text-gray-900 focus:border-indigo-600 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-20 text-2xl focus:outline-none focus:ring-0">
        <span class="material-symbols-outlined text-indigo-500 text-2xl">manage_accounts</span>
        <span>Perfil</span>
      </a>
    </nav>

    <!-- Pie -->
    <div class="border-t mt-4 pt-4 text-base text-right">
      <p class="text-gray-500 text-xl">Bienvenido: 
        <span class="text-indigo-600 font-bold text-right text-xl"><?php echo $_SESSION['nombre']; ?></span>
      </p>
      <a class="cerrar-sesion mt-2 inline-block text-indigo-600 hover:text-indigo-800 font-bold transition-colors text-right" href="/logout text-xl">Cerrar Sesión</a>
    </div>
  </div>
</dialog>

