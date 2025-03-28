<!--<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/dashboard" class="dashboard__enlace <?php echo validar_string_url('/dashboard')?'dashboard__enlace--actual':''; ?>">
            <i class="fa-solid fa-house"></i>
            <span class="dashboard__menu-texto">inicio</span>
        </a>

        <a href="/admin/servicios" class="dashboard__enlace <?php echo validar_string_url('/servicios')?'dashboard__enlace--actual':''; ?>" >
            <i class="fa-solid fa-list"></i>
            <span class="dashboard__menu-texto">servicios</span>
        </a>

        <a href="/admin/facturacion" class="dashboard__enlace <?php echo validar_string_url('/facturacion')?'dashboard__enlace--actual':''; ?>" >
            <i class="fa-solid fa-credit-card"></i>
            <span class="dashboard__menu-texto">facturacion</span>
        </a>

        <a href="/admin/reportes" class="dashboard__enlace <?php echo validar_string_url('/reportes')?'dashboard__enlace--actual':''; ?>" >
            <i class="fa-solid fa-coins"></i>
            <span class="dashboard__menu-texto">reportes</span>
        </a>

        <a href="/admin/citas" class="dashboard__enlace <?php echo validar_string_url('/citas')?'dashboard__enlace--actual':''; ?>" >
            <i class="fa-solid fa-calendar"></i>
            <span class="dashboard__menu-texto">citas</span>
        </a>

        <a href="/admin/clientes" class="dashboard__enlace <?php echo validar_string_url('/clientes')?'dashboard__enlace--actual':''; ?>" >
            <i class="fa-solid fa-users"></i>
            <span class="dashboard__menu-texto">clientes</span>
        </a>

        <a href="/admin/fidelizacion" class="dashboard__enlace <?php echo validar_string_url('/fidelizacion')?'dashboard__enlace--actual':''; ?>" >
            <i class="fa-solid fa-gift"></i>
            <span class="dashboard__menu-texto">descuentos</span>
        </a>
        <?php //if($user['admin']>2): ?>
        <a href="/admin/adminconfig" class="dashboard__enlace <?php echo validar_string_url('/adminconfig')?'dashboard__enlace--actual':''; ?>" >
            <i class="fa-solid fa-gears"></i>
            <span class="dashboard__menu-texto">administrador</span>
        </a>
        <?php //endif; ?>
    </nav>
</aside>-->

<aside class="sidebar">
    <div class="uptask">
        <h1 class="font-bold nametop">InterPos</h1>
        <div class="menux">
            <img id="mobile-menux" src="/build/img/cerrar.svg" alt="cerrar menu">
        </div>
    </div>
    
    <nav class="sidebar-nav"> <!-- el tamaño de las letras de los links <a> estan definidos en 1.6rem en gloables.scss -->
        <a class="<?php echo ($titulo === 'Inicio')?'activo':''; ?>" href="/admin/dashboard"><span class="material-symbols-outlined">home</span> <label class="btnav"> Inicio</label> </a>
        <a class="<?php echo ($titulo === 'Contabilidad')?'activo':''; ?>" href="/admin/contabilidad"><span class="material-symbols-outlined"> article</span> <label class="btnav"> Informes Contables</label></a>
        <a class="<?php echo ($titulo === 'Almacen')?'activo':''; ?>" href="/admin/almacen"><span class="material-symbols-outlined">warehouse</span> <label class="btnav"> Almacenamiento</label></a>
        <a class="<?php echo ($titulo === 'Caja')?'activo':''; ?>" href="/admin/caja"><span class="material-symbols-outlined">point_of_sale</span> <label class="btnav"> Caja</label></a>
        <a class="<?php echo ($titulo === 'Ventas')?'activo':''; ?>" href="/admin/ventas"><span class="material-symbols-outlined">storefront</span> <label class="btnav"> Ventas</label></a>
        <a class="<?php echo ($titulo === 'Reportes')?'activo':''; ?>" href="/admin/reportes"><span class="material-symbols-outlined">format_list_bulleted</span> <label class="btnav"> Reportes</label></a>
        <a class="<?php echo ($titulo === 'Clientes')?'activo':''; ?>" href="/admin/clientes"><span class="material-symbols-outlined">support_agent</span> <label class="btnav"> Clientes</label></a>
        <a class="<?php echo ($titulo === 'Perfil')?'activo':''; ?>" href="/admin/perfil"><span class="material-symbols-outlined">manage_accounts</span> <label class="btnav"> Perfil</label></a>
        <a class="<?php echo ($titulo === 'Configuracion')?'activo':''; ?>" href="/admin/configuracion"><span class="material-symbols-outlined">settings</span> <label class="btnav"> Configuracion</label></a>
    </nav>
    <div class="cerrar-sesion-mobile">
        <p>Bienvenido: <span> <?php echo $_SESSION['nombre']; ?></span></p>
        <a class="cerrar-sesion" href="/logout">Cerrar Sesion</a>
    </div>
</aside>