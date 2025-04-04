<div class="barra-mobile">
    <h1>UpTask</h1>
    <div class="menu">
        <img id="mobile-menu" src="/build/img/menu.svg" alt="imagen menu">
    </div>
</div>

<div class="barra">
    <div class="toggleanduser"><span class="sidebartoggle material-symbols-outlined">menu</span><p>hola: <span> <?php echo $_SESSION['nombre']; ?></span></p></div>

    <div class="flex items-center gap-4 mr-4">
        <a class="cerrar-sesion" href="/logout">Cerrar Sesion</a>

        <button type="button" data-dropdown-toggle="notification-dropdown" class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300">
            <i class="text-4xl fa-solid fa-bell"></i>
        </button>

        <button id="user-menu-button" type="button" class="group relative flex rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown">
            <img class="w-14 h-14 rounded-full" src="/build/img/avatar/avatar9.jpg" alt="user"/>
            <div class="absolute bg-white flex flex-col items-start top-full right-0 rounded-lg pt-2 pb-3 px-4 shadow-md scale-y-0 group-hover:scale-y-100 origin-top duration-200">
                <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/admin">name@j2software.com</a>
                <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/">Dashboard</a>
                <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/">mi Perfil</a>
                <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="/">Settings</a>
                <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#">Sign out</a>
            </div>
        </button>

    </div>

</div>