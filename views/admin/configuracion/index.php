<div class="configuracion !pb-[5.5rem] box ">
    <!-- Menú horizontal fijo -->
    <div class="tabs sticky top-0 bg-white z-10 py-2" id="tabulacion">
        <div class="tabs-content">

            <label>
                <input type="radio" name="radio" <?php echo $paginanegocio??'';?> >
                <span id="pagina1">Negocio</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginaempleado??'';?> >
                <span id="pagina2">Empleados</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginamalla??'';?> >
                <span id="pagina3">Cajas</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina4">Facturadores</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina5">Bancos</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina6">Tarifas</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina7">M. pago</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina8">Dian</span>
            </label>
            
            <label>
                <input type="radio" name="radio">
                <span id="pagina9">Configuración</span>
            </label>
        </div>
    </div>

    <?php include __DIR__. "/../../templates/alertas.php"; ?>

    <!-- negocio -->
    <div class="hidden max-w-screen-md mx-auto mt-6 paginas pagina1"><?php include __DIR__. "/negocio.php";?></div>
    <!-- gestion empleado -->
    <div class="hidden mt-6 paginas pagina2"><?php include __DIR__. "/empleados.php";?></div>  
    <!-- gestion cajas -->
    <div class="hidden paginas pagina3"><?php include __DIR__. "/gestioncajas.php";?></div>
    <!-- gestion facturadores -->
    <div class="hidden paginas pagina4"><?php include __DIR__. "/gestionfacturadores.php";?></div>
    <!-- gestion bancos -->
    <div class="hidden paginas pagina5"><?php include __DIR__. "/gestionbancos.php";?></div>
    <!-- gestion tarifas -->
    <div class="hidden paginas pagina6"><?php include __DIR__. "/tarifas.php";?></div>
    <!-- gestion medios de pago -->
    <div class="hidden paginas pagina7"><?php include __DIR__. "/mediospago.php";?></div>
    <!-- gestion dian -->
    <div class="hidden paginas pagina8"><?php include __DIR__. "/dian.php";?></div>
    <!-- configuración -->
    <div class="hidden mt-6 paginas pagina9">
        <div class="tlg:flex flex-1 tlg:overflow-hidden accordion_inv">

            <!-- Inputs de control de pestañas verticales -->
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

            <!-- Menú vertical fijo -->
            <div class="text-center border border-gray-300 p-3 tlg:w-40 btnsetup sticky top-14 bg-white z-10">
                <span class="text-xl text-gray-600">Ajustes de sistema</span>
                <div>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 btn1" for="btn1">Caja</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn2" for="btn2">Inventario</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn3" for="btn3">Claves</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn4" for="btn4">Permisos</label> 
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn5" for="btn5">Impresión</label> 
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn6" for="btn6">Impuesto</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn7" for="btn7">Facturación</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn8" for="btn8">Sismeta</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn9" for="btn9">Suscripcion</label> 
                </div>
            </div>
        
            <!-- Contenido con scroll -->
            <div class="flex-1 tlg:overflow-y-scroll tlg:pl-4 contenedorsetup">
                <?php if(1): //esta activo cuando la suscripcion esta al dia ?>   
                    <?php include __DIR__. "/ajustesdelsistema/caja.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/inventario.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/claves.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/permisos.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/impresion.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/impuestos.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/facturacion.php"; ?>
                    <?php include __DIR__. "/ajustesdelsistema/sistema.php"; ?>
                <?php endif; ?>
                <?php include __DIR__. "/ajustesdelsistema/suscripcion.php"; ?>
            </div>
        </div>
    </div>
</div>
