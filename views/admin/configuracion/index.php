<div class="configuracion box">
    <div class="tabs" id="tabulacion">
        <div class="tabs-content">
            <label><input type="radio" name="radio" <?php echo $paginanegocio??'';?> ><span id="pagina1">Negocio</span></label>
            <label><input type="radio" name="radio" <?php echo $paginaempleado??'';?> ><span id="pagina2">Empleados</span></label>
            <label><input type="radio" name="radio" <?php echo $paginamalla??'';?> ><span id="pagina3">Malla</span></label>
            <label><input type="radio" name="radio" <?php echo $paginadesc??'';?> ><span id="pagina4">Fecha desc..</span></label>
            <label><input type="radio" name="radio"><span id="pagina5">Configuración</span></label>
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


            <div class="text-center border border-gray-300 p-3 tlg:w-44 btnsetup">
                <span class="text-xl text-gray-600">Ajustes de sistema</span>
                <div>
                    <label class="btn-xs btn-dark mt-4 btn1" for="btn1">Parametros de Caja</label>
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn2" for="btn2">Impuestos</label>
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn3" for="btn3">Impresion</label>
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn4" for="btn4">Permisos</label> 
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn5" for="btn5">Claves</label> 
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn6" for="btn6">Caja</label>
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn7" for="btn7">Consecutivos</label>
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn8" for="btn8">Medios de Pago</label> 
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn9" for="btn9">n!....</label>
                    <label class="btn-xs btn-dark mt-4 tlg:!w-full btn10" for="btn10">n!...</label>
                </div>
            </div>
        
            <div class="flex-1 tlg:overflow-y-scroll tlg:pl-4 contenedorsetup">
            
                <div class="contenido1 accordion_tab_content py-4">
                    <div class="flex flex-wrap gap-10">
                        <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">$25.180.460</p>Valor inventario</div>
                        <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">621</p>Total de productos</div>
                        <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">62</p>Total de referencias</div>
                        <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">8</p>Categorias</div>
                        <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">14</p>Productos con bajo stock</div>
                        <div class="shadow-md text-center p-4 text-gray-600 text-xl leading-3 rounded-lg"><p class="m-0 font-medium text-green-500 text-3xl">9</p>Productos agotados</div>
                    </div>
                </div>

                <div class="contenido2 accordion_tab_content">
                    <?php include __DIR__. "/impuestos.php"; ?>
                </div> <!-- fin Impuestos -->

                <div class="contenido3 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Impresion</p>
                </div> <!-- fin Impresion-->

                <div class="contenido4 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Permisos</p>
                </div> <!-- fin Permisos -->

                <div class="contenido5 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Claves</p>
                </div> <!-- fin Claves-->

                <div class="contenido6 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Caja</p>
                </div> <!-- fin Caja -->

                <div class="contenido7 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Consecutivos</p>
                </div> <!-- fin Consecutivos-->

                <div class="contenido8 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Medios de pago</p>
                </div> <!-- fin Claves-->

                <div class="contenido9 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Aqui..</p>
                </div> <!-- fin Caja -->

                <div class="contenido10 accordion_tab_content">
                    <p class="text-xl mt-0 text-gray-600">Mas aqui..</p>
                </div> <!-- fin Consecutivos-->
            </div>

        </div> <!-- fin accordion_inv -->

        <div class="mediospago">
            <h4 class="text-center text-gray-600 mb-4">Medios De Pago</h4>
            <div class="mediospago__form">
                <?php foreach($mediospago as $value): ?>
                <div class="mediospago__mediopago">
                    <div class="stylecheckbox">
                        <input type="checkbox" id="<?php echo $value->mediopago??'';?>" name="mediopago" value="<?php echo $value->id??'';?>" <?php echo $value->id==1?'disabled':'';?>>
                        <label for="<?php echo $value->mediopago??'';?>"><?php echo $value->mediopago??'';?></label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="mediospago__btn">
                <span id="btnmediopago" class="btn-md btn-blueintense"><i class="fa-solid fa-plus"></i> Actualizar</span>
            </div>
        </div> <!-- fin mediospago -->
        
    </div> <!-- fin pagina5 -->


</div>