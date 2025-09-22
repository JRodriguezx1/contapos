<div class="empleados">
    <h4 class="text-gray-600 text-center mb-4">Gestion de empleado</h4>
    <button id="crearempleado" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-auto">Crear Empleado</button>
    <table class="display responsive nowrap tabla" width="100%" id="tablaempleados">
        <thead>
            <tr>
                <th>N.</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Usuario</th>
                <th>Perfil</th>
                <th class="accionesth">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($empleados as $index => $value): ?>
            <tr> 
                <td class=""><?php echo $index+1;?></td>        
                <td class=""><?php echo $value->nombre.' '.$value->apellido;?></td> 
                <td class="" ><div class="text-center"><img style="width: 40px;" src="/build/img/<?php echo $value->img;?>" alt=""></div></td> 
                <td class=""><?php echo $value->nickname;?></td>
                <td class=""><?php echo $value->perfil==1?'Empleado':($value->perfil==2?'Admin':'Propietario');?></td>
                <td class="accionestd">
                    <div class="acciones-btns" id="<?php echo $value->id;?>">
                        <button class="btn-md btn-turquoise editarEmpleado" title="Actualizar datos empleados"><i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn-md btn-lima updatePassword" title="Cambiar contraseña"><i class="fa-solid fa-key"></i>
                        </button>
                        <button class="btn-md btn-red eliminarEmpleado" title="Eliminar empleado"><i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <dialog class="midialog-md p-12" id="miDialogoEmpleado">
        <h4 id="modalEmpleado" class="font-semibold text-gray-700 mb-4">Crear empleado</h4>
        <div id="divmsjalertaempleado1"></div>
        <form id="formCrearUpdateEmpleado" class="formulario" action="/admin/configuracion/crear_empleado" enctype="multipart/form-data" method="POST">
            
                <div class="formulario__campo">
                    <div class="formulario__contentinputfile">
                        <div class="formulario__imginputfile"><img id="imginputfile" src="" alt=""></div>
                        <p class="text-greymouse">Subir imagen</p>
                    </div>
                    <input id="upImage" class="formulario__inputfile" type="file" name="img" hidden>
                    <button id="customUpImage" class="text-white bg-gradient-to-br from-indigo-700 to-[#00CFCF] hover:bg-gradient-to-bl hover:from-[#00CFCF] hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-[#99fafa] dark:focus:ring-[#0a8a8a] font-medium rounded-lg text-sm text-center !w-[23%] !mx-auto mb-2 !px-8 !py-4" type="button">Cargar Imagen</button>
                </div>
            <div class="grid grid-cols-1 gap-x-6 sm:grid-cols-6">
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="nombre">*Nombre</label>
                    <div class="formulario__dato">
                        <input id="nombreempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del empleado" name="nombre" value="<?php echo $empleado->nombre??'';?>" required>
                        <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="apellido">Apellido</label>
                    <div class="formulario__dato">
                        <input id="apellidoempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Apellido del empleado" name="apellido" value="<?php echo $empleado->apellido??'';?>">
                        <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="nickname">*Usuario</label>
                    <div class="formulario__dato">
                        <input id="nicknameempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Usuario del empleado" name="nickname" value="<?php echo $empleado->nickname??'';?>" required>
                        <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="cedula">Cedula</label>
                    <div class="formulario__dato">
                        <input id="cedulaempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Cedula del empleado" name="cedula" value="<?php echo $empleado->cedula??'';?>">
                        <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="password">*Contraseña</label>
                    <div class="formulario__dato">
                        <input id="passwordempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="password" placeholder="Contraseña de sesion" name="password" value="<?php echo $empleado->password??'';?>" required>
                        <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="contraseña2">*Confirmar contraseña</label>
                    <div class="formulario__dato">
                        <input id="passwordempleado2" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="password" placeholder="Confirmar contraseña" name="password2" value="<?php echo $empleado->contraseña2??'';?>" required>
                        <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="movil">Movil</label>
                    <div class="formulario__dato">
                        <input id="movilempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" min="3000000000" max="3777777777" placeholder="Tu Movil" name="movil" value="<?php echo $empleado->movil??'';?>">
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="email">Email</label>
                    <div class="formulario__dato">
                        <input id="emailempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="email" placeholder="Tu Email" name="email" value="<?php echo $empleado->email??'';?>">
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="direccion">Dirección</label>
                    <div class="formulario__dato">
                        <input id="direccionempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Direccion de  residencia" name="direccion" value="<?php echo $empleado->direccion??'';?>">
                        <!-- <label data-num="90" class="count-charts" for="">90</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="departamento">Departamento</label>
                    <div class="formulario__dato">
                        <input id="departamentoempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="departamento" name="departamento" value="<?php echo $empleado->departamento??''; ?>">
                        <!-- <label data-num="18" class="count-charts" for="">18</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="ciudad">Ciudad</label>
                    <div class="formulario__dato">
                        <input id="ciudadempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="ciudad" name="ciudad" value="<?php echo $empleado->ciudad??'';?>">
                        <!-- <label data-num="14" class="count-charts" for="">14</label> -->
                    </div>
                </div>
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="perfil">*Perfil</label>
                    <select id="perfilempleado" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="perfil" required>
                        <option value="" disabled selected>-Seleccionar-</option>
                        <option value="2" <?php echo $empleado->perfil==1?'selected':'';?> >Supervisor</option>
                        <option value="3" <?php echo $empleado->perfil==2?'selected':'';?>>Administrador</option>
                        <option value="4" <?php echo $empleado->perfil==3?'selected':'';?>>Asesor</option>
                    </select>
                </div>
            </div>

            <div id="contentpermisos" style="display: none;">
                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-2xl mt-0">Modulo venta</p>
                    <div class="flex items-center">
                        <input id="habilitarmoduloventa" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="1">
                        <label for="habilitarmoduloventa" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Habilitar modulo de venta</label>
                    </div>
                    <div class="flex items-center">
                        <input id="registrarventa" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="2">
                        <label for="registrarventa" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Registrar nueva venta</label>
                    </div>
                    <div class="flex items-center">
                        <input id="anularventa" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="3">
                        <label for="anularventa" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Anular una venta</label>
                    </div>
                    <div class="flex items-center">
                        <input id="aplicardescuentos" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="4">
                        <label for="aplicardescuentos" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Aplicar descuentos</label>
                    </div>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-2xl mt-0">Módulo de Inventario</p>
                    <div class="flex items-center">
                        <input id="habilitarmoduloinventario" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="5">
                        <label for="habilitarmoduloinventario" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Habilitar modulo de inventario</label>
                    </div>
                    <div class="flex items-center">
                        <input id="consultarstock" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="6">
                        <label for="consultarstock" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Consultar stock</label>
                    </div>
                    <div class="flex items-center">
                        <input id="ajustarinventario" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="7">
                        <label for="ajustarinventario" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Hacer ajustes de inventario</label>
                    </div>
                    <div class="flex items-center">
                        <input id="actualizarprecios" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="8">
                        <label for="actualizarprecios" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Actualizar precios o datos</label>
                    </div>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-2xl mt-0">Módulo de Facturación</p>
                    <div class="flex items-center">
                        <input id="habilitarmodulofacturacion" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="9">
                        <label for="habilitarmodulofacturacion" class="text-xl text-gray-500 ms-3 dark:text-neutral-400"> Habilitar modulo de facturacion</label>
                    </div>
                    <div class="flex items-center">
                        <input id="emitirfacturaselectronicas" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="10">
                        <label for="emitirfacturaselectronicas" class="text-xl text-gray-500 ms-3 dark:text-neutral-400"> Emitir facturas electrónicas</label>
                    </div>
                    <div class="flex items-center">
                        <input id="eliminarfacturas" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="11">
                        <label for="eliminarfacturas" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Anular facturas y notas creditos</label>
                    </div>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-2xl mt-0">Módulo de Caja</p>
                    <div class="flex items-center">
                        <input id="habilitarmodulocaja" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="12">
                        <label for="habilitarmodulocaja" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Habilitar modulo de caja</label>
                    </div>
                    <div class="flex items-center">
                        <input id="abrircaja" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="13">
                        <label for="abrircaja" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Abrir caja registradora</label>
                    </div>
                    <div class="flex items-center">
                        <input id="cerrarcaja" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="14">
                        <label for="cerrarcaja" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Cerrar caja y generar arqueo</label>
                    </div>
                    <div class="flex items-center">
                        <input id="verreportescaja" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="15">
                        <label for="verreportescaja" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Ver reportes de caja</label>
                    </div>
                </div>
            </div>

            <div id="contentpermisosadmin" style="display: none;">
                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-2xl mt-0">Modulos administraivos</p>
                    <div class="flex items-center">
                        <input id="habilitarreportes" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="16">
                        <label for="habilitarreportes" class="text-xl text-gray-500 ms-3 dark:text-neutral-400"> Habilitar modulo de reportes</label>
                    </div>
                    <div class="flex items-center">
                        <input id="habilitarconfiguracion" name="permisos[]" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 w-6 h-6 focus:ring-2" value="17">
                        <label for="habilitarconfiguracion" class="text-xl text-gray-500 ms-3 dark:text-neutral-400">Habilitar modulo de configuracion</label>
                    </div>
                </div> 
            </div>

            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEditarCrearEmpleado" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
            </div>
        </form>
    </dialog><!--fin crear empleado-->

    <dialog class="midialog-md p-12" id="miDialogoContraseña">
        <h4 class="text-gray-600 font-semibold">Cambiar contraseña</h4>
        <div id="divmsjalertaempleado2"></div>
        <form id="formContraseña" class="formulario" method="POST">
            <h5 id="nombreEmpleadoPass" class="mt-2 text-xl text-gray-500">Julian Rodriguez</h5>
            <label for="cambiocontraseña"></label>
            <input id="changePassword" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 mt-6" type="text" value="" required>
            <div class="text-right mt-6">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarContrasela" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Actualizar">
            </div>
        </form>
    </dialog><!--fin Act/ediar contraseña por empleado-->
</div>