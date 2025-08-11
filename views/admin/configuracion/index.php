<div class="configuracion box">
    <div class="tabs" id="tabulacion">
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
                <span id="pagina3">Malla</span>
            </label>
            <label>
                <input type="radio" name="radio" <?php echo $paginadesc??'';?> >
                <span id="pagina4">Fecha desc..</span>
            </label>
            <label>
                <input type="radio" name="radio">
                <span id="pagina5">Configuración</span>
            </label>
        </div>
    </div>

    <?php include __DIR__. "/../../templates/alertas.php"; ?>
    <!-- negocio -->
    <div class="hidden max-w-screen-md mx-auto mt-6 negocio paginas pagina1"><?php include __DIR__. "/negocio.php";?></div>
    
    <!-- crear empleado-->
    <div class="hidden mt-6 empleado paginas pagina2"><?php include __DIR__. "/empleado.php";?></div>  

    <!--malla-->
    <div class="hidden paginas pagina3 mallaempleado"></div>

    <div class="hidden paginas pagina4 descpagina3"></div>

    <!-- configuración - medios de pago, colores, tiempo de servicio -->
    <div class="hidden mt-6 paginas pagina5 configAdd">
        
        <div class="tlg:flex flex-1 tlg:overflow-hidden accordion_inv">
            <input type="radio" name="config" id="btn9" checked>
            <input type="radio" name="config" id="btn1">
            <input type="radio" name="config" id="btn2">
            <input type="radio" name="config" id="btn3">
            <input type="radio" name="config" id="btn4">
            <input type="radio" name="config" id="btn5">
            <input type="radio" name="config" id="btn6">
            <input type="radio" name="config" id="btn7">
            <input type="radio" name="config" id="btn8">
            <input type="radio" name="config" id="btn0">
            <input type="radio" name="config" id="btn10">


            <div class="text-center border border-gray-300 p-3 tlg:w-40 btnsetup">
                <span class="text-xl text-gray-600">Ajustes de sistema</span>
                <div>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 btn9" for="btn9">Generar</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 btn1" for="btn1">Caja</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn2" for="btn2">Inventario</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn3" for="btn3">Claves</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn4" for="btn4">Permisos</label> 
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn5" for="btn5">Impresión</label> 
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn6" for="btn6">Impuesto</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn7" for="btn7">Facturación</label>
                    <label class="btn-xs btn-indigo !w-[83px] !py-4 mt-4 tlg:!w-full btn8" for="btn8">Sismeta</label> 
                    <!-- <label class="btn-xs btn-indigo !py-4 mt-4 tlg:!w-full btn9" for="btn9">n!....</label>
                    <label class="btn-xs btn-indigo !py-4 mt-4 tlg:!w-full btn10" for="btn10">n!...</label> -->
                </div>
            </div>
        
            <div class="flex-1 tlg:overflow-y-scroll tlg:pl-4 contenedorsetup">
                
                <?php include __DIR__. "/ajustesdelsistema/generar.php"; ?>
                <?php include __DIR__. "/ajustesdelsistema/caja.php"; ?>
                <?php include __DIR__. "/ajustesdelsistema/inventario.php"; ?>
                <?php include __DIR__. "/ajustesdelsistema/claves.php"; ?>
                <?php include __DIR__. "/ajustesdelsistema/permisos.php"; ?>
                <?php include __DIR__. "/ajustesdelsistema/impresion.php"; ?>
                <?php include __DIR__. "/ajustesdelsistema/impuestos.php"; ?>
                <?php include __DIR__. "/ajustesdelsistema/facturacion.php"; ?>


               

                <div class="contenido8 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Medios de pago</p>
                </div> <!-- fin Claves-->

                <!-- LO USÉ PARA EL CONTENEDOR GENERAR DE LOS PARAMETROS<div class="contenido9 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Aqui..</p>
                </div> fin Caja -->

                <div class="contenido10 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Mas aqui..</p>
                </div> <!-- fin Consecutivos-->
            </div>

        </div> <!-- fin accordion_inv -->


        
    </div> <!-- fin pagina5 -->


</div>