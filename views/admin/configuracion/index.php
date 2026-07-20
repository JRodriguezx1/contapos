<div class="configuracion configuracion-shell !pb-[5.5rem]">
    <section class="configuracion-header">
        <div>
            <p class="configuracion-eyebrow">Administraci&oacute;n</p>
            <h1>Configuraci&oacute;n</h1>
            <p class="configuracion-subtitle">Gestiona los datos del negocio, usuarios, facturaci&oacute;n y par&aacute;metros generales.</p>
        </div>
    </section>

    <div id="tabulacion" class="tabs configuracion-tabs">
        <div class="tabs-content configuracion-tabs__content">

            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginanegocio??'';?> >
                <span id="pagina1"><i class="fa-solid fa-store"></i>Negocio</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginaempleado??'';?> >
                <span id="pagina2"><i class="fa-solid fa-file-signature"></i>Emisores</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginaempleado??'';?> >
                <span id="pagina3"><i class="fa-solid fa-users-gear"></i>Empleados</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginamalla??'';?> >
                <span id="pagina4"><i class="fa-solid fa-cash-register"></i>Cajas</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina5"><i class="fa-solid fa-receipt"></i>Facturadores</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina6"><i class="fa-solid fa-building-columns"></i>Bancos</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina7"><i class="fa-solid fa-percent"></i>Tarifas</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina8"><i class="fa-solid fa-credit-card"></i>M. pago</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina9"><i class="fa-solid fa-file-invoice"></i>DIAN</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina10"><i class="fa-solid fa-print"></i>Impresoras</span>
            </label>
            <label class="configuracion-tab">
                <input type="radio" name="radio">
                <span id="pagina11"><i class="fa-solid fa-sliders"></i>Sistema</span>
            </label>
        </div>
    </div>

    <?php include __DIR__. "/../../templates/alertas.php"; ?>

    <section class="configuracion-content">
        <div class="hidden max-w-screen-md mx-auto paginas pagina1"><?php include __DIR__. "/negocio.php";?></div>
        <div class="hidden paginas pagina2"><?php include __DIR__. "/emisores.php";?></div>
        <div class="hidden paginas pagina3"><?php include __DIR__. "/empleados.php";?></div>
        <div class="hidden paginas pagina4"><?php include __DIR__. "/gestioncajas.php";?></div>
        <div class="hidden paginas pagina5"><?php include __DIR__. "/gestionfacturadores.php";?></div>
        <div class="hidden paginas pagina6"><?php include __DIR__. "/gestionbancos.php";?></div>
        <div class="hidden paginas pagina7"><?php include __DIR__. "/tarifas.php";?></div>
        <div class="hidden paginas pagina8"><?php include __DIR__. "/mediospago.php";?></div>
        <div class="hidden paginas pagina9"><?php include __DIR__. "/dian.php";?></div>
        <div class="hidden paginas pagina10"><?php include __DIR__. "/impresoras.php";?></div>
        <div class="hidden paginas pagina11">
            <div class="config-system accordion_inv">

                <input type="radio" name="config" id="btn1" checked>
                <input type="radio" name="config" id="btn2">
                <input type="radio" name="config" id="btn3">
                <input type="radio" name="config" id="btn4">
                <input type="radio" name="config" id="btn5">
                <input type="radio" name="config" id="btn6">
                <input type="radio" name="config" id="btn7">
                <input type="radio" name="config" id="btn8">
                <input type="radio" name="config" id="btn9">
                <input type="radio" name="config" id="btn10">

                <aside class="btnsetup config-system-nav">
                    <div class="config-system-nav__heading">
                        <span class="material-symbols-outlined">tune</span>
                        <div>
                            <strong>Ajustes de sistema</strong>
                            <small>Par&aacute;metros generales</small>
                        </div>
                    </div>
                    <div class="config-system-nav__grid">
                        <label class="config-system-tab btn1" for="btn1"><i class="fa-solid fa-cash-register"></i>Caja</label>
                        <label class="config-system-tab btn2" for="btn2"><i class="fa-solid fa-boxes-stacked"></i>Inventario</label>
                        <label class="config-system-tab btn3" for="btn3"><i class="fa-solid fa-key"></i>Claves</label>
                        <label class="config-system-tab btn4" for="btn4"><i class="fa-solid fa-user-shield"></i>Permisos</label>
                        <label class="config-system-tab btn5" for="btn5"><i class="fa-solid fa-print"></i>Impresi&oacute;n</label>
                        <label class="config-system-tab btn6" for="btn6"><i class="fa-solid fa-scale-balanced"></i>Impuesto</label>
                        <label class="config-system-tab btn7" for="btn7"><i class="fa-solid fa-file-invoice-dollar"></i>Facturaci&oacute;n</label>
                        <label class="config-system-tab btn8" for="btn8"><i class="fa-solid fa-gears"></i>Sistema</label>
                        <label class="config-system-tab btn9" for="btn9"><i class="fa-brands fa-whatsapp"></i>Whatsapp</label>
                        <label class="config-system-tab btn10" for="btn10"><i class="fa-solid fa-id-card"></i>Suscripci&oacute;n</label>
                    </div>
                </aside>

                <div class="contenedorsetup config-system-content">
                    <div class="config-param-search" role="search">
                        <span class="material-symbols-outlined">search</span>
                        <input
                            id="buscarParametroSistema"
                            type="search"
                            autocomplete="off"
                            placeholder="Buscar par&aacute;metro del sistema"
                            aria-label="Buscar par&aacute;metro del sistema"
                        >
                        <button id="limpiarBusquedaParametroSistema" type="button" aria-label="Limpiar b&uacute;squeda">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                        <small id="resultadoBusquedaParametroSistema" aria-live="polite"></small>
                    </div>
                    <?php include __DIR__. "/ajustesdelsistema/caja.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/inventario.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/claves.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/permisos.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/impresion.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/impuestos.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/facturacion.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/sistema.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/whatsapp.php"; ?>
                    <?php if(userPerfil()==1): ?>
                        <?php include __DIR__. "/ajustesdelsistema/suscripcion.php"; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

