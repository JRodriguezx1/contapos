<!-- <script src="https://cdn.tailwindcss.com"></script> -->

<!-- Flowbite -->
<!-- <script src="https://unpkg.com/flowbite@2.5.1/dist/flowbite.min.js"></script> -->

<div class="barra-mobile">
    <div class="barra-mobile__logo">
        <img id="logoj2" class="w-80 h-28" src="/build/img/Logoj2blanco.png" alt="logoj2">
    </div>

    <!-- aviso de vencimiento centrado -->
    <?php if(isset($this->getData()['Aviso_vencimiento'])): ?>
        <div class="subscription-alert-wrap subscription-alert-wrap--mobile">
            <a class="subscription-alert" href="/suspendido" role="alert" aria-label="Ver detalle de suspension y pago">
                <span class="subscription-alert__icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>

                <div class="subscription-alert__body">
                    <span class="subscription-alert__title">
                        <?php echo $this->data['msj_titulo_aviso_vencimiento']; ?>
                    </span>

                    <span class="subscription-alert__message">
                        <?php echo $this->data['msj_texto_aviso_vencimiento']; ?>
                    </span>
                </div> 
            </a>
        </div>
    <?php endif; ?>
</div>
    <!-- <div class="menu">
        <img id="mobile-menu" src="/build/img/menu.svg" alt="imagen menu">
    </div> -->

    <!-- Menu flotante en la parte inferior -->
    <div class="menu-mobile-bottom fixed z-30 w-full h-[7rem] max-w-[33rem] -translate-x-1/2 bg-white  border border-gray-200 rounded-full bottom-4 left-1/2  shadow-lg">
        <div class="grid h-full max-w-[33rem] grid-cols-5 mx-auto group">
            
            <?php if(tienePermiso('Habilitar modulo de configuracion')&&userPerfil()==3 || userPerfil()<3): ?>
            <a href="/admin/configuracion" data-tooltip-target="tooltip-home" class="inline-flex flex-col items-center justify-center px-5 rounded-s-full hover:bg-gray-50 ">
                <svg class="w-5 h-5 mb-1 text-gray-500  group-hover:text-indigo-600 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.25V1m0 11.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M4 19v-2.25m6-13.5V1m0 2.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M10 19V7.75m6 4.5V1m0 11.25a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM16 19v-2"/>
                </svg>
                <span class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Ajustes</span>
                <p class="text-base my-0 text-gray-500">Ajuste</p>
            </a>
            <?php endif; ?>

            <?php if(tienePermiso('Habilitar modulo de inventario') || userPerfil()<=3): ?>
            <a href="/admin/almacen" data-tooltip-target="tooltip-almacen" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50  group">
                <svg class="w-5 h-5 mb-1 text-gray-500  group-hover:text-indigo-600 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z"/>
                    <path d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7 1.352L12.62 4Z"/>
                </svg>
                <span class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Almacen</span>
                <p class="text-base my-0 text-gray-500">Almacen</p>
            </a>
            <?php endif; ?>

            <div class="flex items-center justify-center menu">
                <button data-tooltip-target="tooltip-new" id="mobile-menu1" type="button" class="inline-flex items-center justify-center w-14 h-14 font-medium bg-indigo-500 rounded-full hover:bg-indigo-600 group focus:ring-4 focus:ring-indigo-300 focus:outline-none ">
                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                    <span class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Mas opciones</span>
                </button>
            </div>
            
            <?php if(tienePermiso('Habilitar modulo de caja') || userPerfil()<=3): ?>
            <a href="/admin/caja" data-tooltip-target="tooltip-caja"    class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50  group">
                <!-- Icono caja registradora -->
                <svg class="w-5 h-5 mb-1 text-gray-500  group-hover:text-indigo-600 " 
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M4 10h16v10H4zM8 10V6h8v4M7 14h10M7 18h10M10 6h4" />
                </svg>
                <span class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Caja</span>
                <p class="text-base my-0 text-gray-500">Caja</p>
            </a>
            <?php endif; ?>

            <?php if(tienePermiso('Habilitar modulo de venta') || userPerfil()<=3): ?>
            <a href="/admin/ventas<?php echo (getConfigLocal()['habilitar_venta_modo_rapido']??null)?->valor_final == 1?'/modorapido':''; ?>" data-tooltip-target="tooltip-venta" class="inline-flex flex-col items-center justify-center px-5 rounded-e-full hover:bg-gray-50  group">
                <svg class="w-5 h-5 mb-1 text-gray-500  group-hover:text-indigo-600 " 
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 
                            0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zm-12.83-2h13.66c.75 
                            0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0 0 22.34 7H6.21l-.94-2H1v2h3l3.6 
                            7.59-1.35 2.44C5.11 17.37 6 19 7 19h12v-2H7l1.1-2h9.45c.75 
                            0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0 0 22.34 7H6.21z"/>
                </svg>
                <span class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Ventas</span>
                <p class="text-base my-0 text-gray-500">Venta</p>
            </a>
            <?php endif; ?>
            <div id="tooltip-venta" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
                Ventas
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>

<div class="barra flex items-center justify-between">
    <!-- izquierda -->
    <div class="toggleanduser flex items-center gap-3">
        <span class="sidebartoggle material-symbols-outlined">menu</span>
        <span class="bg-indigo-600 hover:bg-indigo-700 text-white text-xl font-bold px-6 py-2 rounded-full shadow-xl transition duration-300 ease-in-out transform hover:scale-110 uppercase tracking-wide">
            <?php echo nombreSucursal(); ?>
        </span>
    </div>


    <!-- aviso de vencimiento centrado -->
    <?php if(isset($this->getData()['Aviso_vencimiento'])): ?>
        <div class="subscription-alert-wrap hidden tlg:flex">
            <a class="subscription-alert" href="/suspendido" role="alert" aria-label="Ver detalle de suspension y pago">
                <span class="subscription-alert__icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>

                <div class="subscription-alert__body">
                    <span class="subscription-alert__title">
                        <?php echo $this->data['msj_titulo_aviso_vencimiento']; ?>
                    </span>

                    <span class="subscription-alert__message">
                        <?php echo $this->data['msj_texto_aviso_vencimiento']; ?>
                    </span>
                </div>
            </a>
        </div>
    <?php endif; ?>


    <!-- derecha -->
    <div class="flex items-center gap-4 mr-4">

        <a class="cerrar-sesion !bg-indigo-600 hover:!bg-indigo-700" href="/logout">
            Cerrar Sesi&oacute;n
        </a>

        <button type="button" data-dropdown-toggle="notification-dropdown"
            class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300">
            <i class="text-4xl fa-solid fa-bell"></i>
        </button>

        <div id="notification-dropdown"
            class="group relative flex rounded-full focus-within:ring-4 focus-within:ring-gray-300">

            <img class="w-14 h-14 rounded-full ring-2 ring-indigo-100" src="/build/img/avatar/avatar9.jpg" alt="user" />

            <div
                class="absolute z-50 bg-white flex flex-col items-stretch top-[calc(100%+.8rem)] right-0 w-96 rounded-xl border border-slate-200 p-3 shadow-2xl scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100 origin-top-right duration-200">

                <div class="flex items-center gap-3 rounded-lg bg-slate-50 px-3 py-3">
                    <img class="w-12 h-12 rounded-full ring-2 ring-white shadow-sm" src="/build/img/avatar/avatar9.jpg" alt="user" />
                    <div class="min-w-0 text-left">
                        <p class="text-sm font-bold uppercase tracking-wide text-indigo-600">Usuario activo</p>
                        <p class="truncate text-xl font-bold text-slate-800">
                            <?php echo $user['nombre']; ?>
                        </p>
                    </div>
                </div>

                <label for="selectSucursal" class="mt-3 text-left text-sm font-bold uppercase tracking-wide text-slate-500">
                    Sucursal
                </label>
                <select id="selectSucursal" class="sr-only" tabindex="-1" aria-hidden="true">

                    <option value="" selected disabled>Cambiar de Sede</option>

                    <?php foreach($sucursales as $val): ?>
                        <option value="<?php echo $val->id;?>">
                            <?php echo $val->nombre;?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <div class="relative mt-1 rounded-lg border border-slate-200 bg-white shadow-sm">
                    <button id="toggleSucursalMenu" type="button"
                        class="flex w-full items-center justify-between rounded-lg bg-slate-50 px-3 py-2.5 text-left text-lg font-bold text-slate-700 transition hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                        <span id="sucursalSeleccionada">Cambiar de Sede</span>
                        <i id="iconSucursalMenu" class="fa-solid fa-chevron-down text-sm text-indigo-500 transition-transform"></i>
                    </button>
                    <div id="sucursalMenuLista" class="absolute left-0 right-0 top-[calc(100%+.35rem)] z-50 hidden max-h-64 overflow-y-auto rounded-lg border border-slate-200 bg-white py-1 shadow-xl">
                        <?php foreach($sucursales as $val): ?>
                            <div role="button" tabindex="0"
                                class="js-sucursal-option flex w-full items-center gap-3 px-3 py-2.5 text-left text-base font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700"
                                data-sucursal-value="<?php echo $val->id;?>"
                                data-sucursal-label="<?php echo htmlspecialchars($val->nombre, ENT_QUOTES, 'UTF-8');?>">
                                <i class="fa-solid fa-store w-6 text-center text-indigo-500"></i>
                                <span><?php echo $val->nombre;?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="my-3 h-px bg-slate-200"></div>

                <a class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-lg font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700"
                    href="/admin/dashboard">
                    <i class="fa-solid fa-house w-6 text-center text-indigo-500"></i>
                    <span>Inicio</span>
                </a>

                <a class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-lg font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700"
                    href="/admin/perfil">
                    <i class="fa-solid fa-user w-6 text-center text-indigo-500"></i>
                    <span>Mi Perfil</span>
                </a>

                <?php if($user['perfil']<4): ?>
                    <a class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-lg font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700"
                        href="/admin/comisiones">
                        <i class="fa-solid fa-percent w-6 text-center text-indigo-500"></i>
                        <span>Comisiones</span>
                    </a>
                <?php endif; ?>

                <a class="mt-1 flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-lg font-semibold text-rose-600 transition hover:bg-rose-50"
                    href="/logout">
                    <i class="fa-solid fa-right-from-bracket w-6 text-center"></i>
                    <span>Cerrar sesi&oacute;n</span>
                </a>

            </div>
        </div>
    </div>
</div>


<!-- Menu movil barra inferior -->
<dialog id="miDialogomenumovil" class="p-0 w-[96%] max-w-lg h-[72%] max-h-[640px] bg-white rounded-xl overflow-hidden" hidden>
  <div class="fixed inset-0 bg-black bg-opacity-40" onclick="document.getElementById('miDialogomenumovil').close()"></div>

  <div class="relative z-10 flex h-full flex-col bg-white px-7 py-7 sm:px-8">
    <div class="shrink-0">
      <div class="flex justify-center">
        <img id="logoj2" class="h-24 w-72 object-contain" src="/build/img/Logoj2indigo.png" alt="JDOS">
      </div>
      <div class="mt-1 text-center">
        <span class="inline-flex max-w-full items-center justify-center rounded-full bg-indigo-600 px-5 py-2 text-lg font-bold uppercase tracking-wide text-white shadow-xl">
          <?php echo nombreSucursal(); ?>
        </span>
      </div>
    </div>

    <div class="mt-6 flex shrink-0 items-center justify-between">
      <h4 class="m-0 text-4xl font-semibold leading-none text-gray-800">Men&uacute;</h4>
      <button onclick="document.getElementById('miDialogomenumovil').close()"
              class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-white transition-colors hover:bg-indigo-700">
        <span class="material-symbols-outlined text-4xl leading-none">close</span>
      </button>
    </div>

    <nav class="mt-6 flex min-h-0 flex-1 flex-col space-y-3 overflow-y-auto pr-1">
      <?php if(tienePermiso('Mostrar dashboard') || userPerfil()<=3): ?>
        <a href="/admin/dashboard" class="flex h-20 w-full items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 text-2xl text-gray-900 transition hover:border-indigo-200 hover:bg-indigo-50 focus:border-indigo-600 focus:outline-none focus:ring-0">
          <span class="material-symbols-outlined text-3xl text-indigo-500">home</span>
          <span>Inicio</span>
        </a>
      <?php endif; ?>

      <?php if(tienePermiso(html_entity_decode('Habilitar m&oacute;dulo de credito/separados', ENT_QUOTES, 'UTF-8')) || tienePermiso('Habilitar modulo de credito/separados') || userPerfil()<=3): ?>
        <a href="/admin/creditos" class="flex h-20 w-full items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 text-2xl text-gray-900 transition hover:border-indigo-200 hover:bg-indigo-50 focus:border-indigo-600 focus:outline-none focus:ring-0">
          <span class="material-symbols-outlined text-3xl text-indigo-500">swap_horiz</span>
          <span>Cr&eacute;ditos</span>
        </a>
      <?php endif; ?>

      <?php if(tienePermiso('Habilitar modulo de reportes')&&userPerfil()==3 || userPerfil()<3): ?>
        <a href="/admin/reportes" class="flex h-20 w-full items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 text-2xl text-gray-900 transition hover:border-indigo-200 hover:bg-indigo-50 focus:border-indigo-600 focus:outline-none focus:ring-0">
          <span class="material-symbols-outlined text-3xl text-indigo-500">format_list_bulleted</span>
          <span>Reportes</span>
        </a>
      <?php endif; ?>

      <a href="/admin/clientes" class="flex h-20 w-full items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 text-2xl text-gray-900 transition hover:border-indigo-200 hover:bg-indigo-50 focus:border-indigo-600 focus:outline-none focus:ring-0">
        <span class="material-symbols-outlined text-3xl text-indigo-500">support_agent</span>
        <span>Clientes</span>
      </a>

      <a href="/admin/perfil" class="flex h-20 w-full items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 text-2xl text-gray-900 transition hover:border-indigo-200 hover:bg-indigo-50 focus:border-indigo-600 focus:outline-none focus:ring-0">
        <span class="material-symbols-outlined text-3xl text-indigo-500">manage_accounts</span>
        <span>Perfil</span>
      </a>
    </nav>

    <div class="mt-5 shrink-0 border-t border-slate-200 pt-4 text-center">
      <p class="text-xl font-bold text-indigo-600"><?php echo $_SESSION['nombre']; ?></p>
      <div class="mt-2 flex items-center justify-center gap-4 text-lg">
        <?php if($user['perfil']<4): ?>
          <a class="font-semibold text-slate-500 transition-colors hover:text-indigo-700" href="/admin/comisiones">Comisiones</a>
        <?php endif; ?>
        <a class="cerrar-sesion font-bold text-indigo-600 transition-colors hover:text-indigo-800" href="/logout">Cerrar sesi&oacute;n</a>
      </div>
      <p class="mt-3 text-base font-semibold text-slate-500">JDOS <?php echo $_SESSION['sucursal']->version; ?></p>
    </div>
  </div>
</dialog>

