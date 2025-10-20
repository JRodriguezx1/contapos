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
            <?php foreach($empleados as $index => $value): 
                if($value->perfil!=1): ?>
                <tr> 
                    <td class=""><?php echo $index+1;?></td>        
                    <td class=""><?php echo $value->nombre.' '.$value->apellido;?></td> 
                    <td class="" ><div class="text-center"><img style="width: 40px;" src="/build/img/<?php echo $value->img;?>" alt=""></div></td> 
                    <td class=""><?php echo $value->nickname;?></td>
                    <td class=""><?php echo $value->perfil==1?'root':($value->perfil==2?'Superior':($value->perfil==3?'Administrador':'Asesor'));?></td>
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
            <?php endif; endforeach; ?>
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
                    <label class="formulario__label flex items-center gap-1 group relative" for="nombre">
                        Nombre
                        <!-- icono obligatorio -->
                        <span class="text-red-500 font-bold cursor-help">⚠️</span>

                        <!-- tooltip -->
                        <span
                        class="absolute left-1/2 -translate-x-1/2 -top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        Campo obligatorio
                        </span>
                    </label>

                    <div class="formulario__dato">
                        <input
                        id="nombreempleado"
                        class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                        type="text"
                        placeholder="Nombre del empleado"
                        name="nombre"
                        value="<?php echo $empleado->nombre??'';?>"
                        required
                        >
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
                    <label class="formulario__label flex items-center gap-1 group relative" for="nickname">
                        Usuario
                        <!-- icono obligatorio -->
                        <span class="text-red-500 font-bold cursor-help">⚠️</span>

                        <!-- tooltip -->
                        <span
                        class="absolute left-1/2 -translate-x-1/2 -top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        Campo obligatorio
                        </span>
                    </label>

                    <div class="formulario__dato">
                        <input
                        id="nicknameempleado"
                        class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                        type="text"
                        placeholder="Usuario del empleado"
                        name="nickname"
                        value="<?php echo $empleado->nickname??'';?>"
                        required
                        >
                    </div>
                </div>

                <!--<div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="cedula">Cédula</label>
                    <div class="formulario__dato">
                        <input id="cedulaempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Cedula del empleado" name="cedula" value="<?php //echo $empleado->cedula??'';?>">-->
                        <!-- <label data-num="42" class="count-charts" for="">42</label> -->
                    <!--</div>
                </div>-->

                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label flex items-center gap-1 group relative" for="password">
                        Contraseña
                        <!-- icono obligatorio -->
                        <span class="text-red-500 font-bold cursor-help">⚠️</span>

                        <!-- tooltip -->
                        <span
                        class="absolute left-1/2 -translate-x-1/2 -top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        Campo obligatorio
                        </span>
                    </label>

                    <div class="formulario__dato">
                        <input
                        id="passwordempleado"
                        class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                        type="password"
                        placeholder="Contraseña de sesión"
                        name="password"
                        value="<?php echo $empleado->password??'';?>"
                        required
                        >
                    </div>
                </div>

                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label flex items-center gap-1 group relative" for="contraseña2">
                        Confirmar contraseña
                        <!-- icono obligatorio -->
                        <span class="text-red-500 font-bold cursor-help">⚠️</span>

                        <!-- tooltip con tailwind -->
                        <span
                        class="absolute left-1/2 -translate-x-1/2 -top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        Campo obligatorio
                        </span>
                    </label>

                    <div class="formulario__dato">
                        <input
                        id="passwordempleado2"
                        class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                        type="password"
                        placeholder="Confirmar contraseña"
                        name="password2"
                        value="<?php echo $empleado->contraseña2??'';?>"
                        required
                        >
                    </div>
                </div>

                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="movil">Teléfono</label>
                    <div class="formulario__dato">
                        <input id="movilempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" min="3000000000" max="3777777777" placeholder="Tu Movil" name="movil" value="<?php echo $empleado->movil??'';?>">
                    </div>
                </div>
                <!--<div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="email">Email</label>
                    <div class="formulario__dato">
                        <input id="emailempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="email" placeholder="Tu Email" name="email" value="<?php //echo $empleado->email??'';?>">
                    </div>
                </div>-->
                <!--<div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="direccion">Dirección</label>
                    <div class="formulario__dato">
                        <input id="direccionempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Direccion de  residencia" name="direccion" value="<?php //echo $empleado->direccion??'';?>">-->
                        <!-- <label data-num="90" class="count-charts" for="">90</label> -->
                    <!--</div>
                </div>-->
                <!--<div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="departamento">Departamento</label>
                    <div class="formulario__dato">
                        <input id="departamentoempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="departamento" name="departamento" value="<?php //echo $empleado->departamento??''; ?>">
                    </div>
                </div>-->
                <!--<div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label" for="ciudad">Ciudad</label>
                    <div class="formulario__dato">
                        <input id="ciudadempleado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="ciudad" name="ciudad" value="<?php //echo $empleado->ciudad??'';?>">-->
                        <!-- <label data-num="14" class="count-charts" for="">14</label> -->
                    <!--</div>
                </div>-->
                <div class="formulario__campo sm:col-span-3">
                    <label class="formulario__label flex items-center gap-1 group relative" for="perfil">
                        Perfil
                        <!-- icono obligatorio -->
                        <span class="text-red-500 font-bold cursor-help">⚠️</span>

                        <!-- tooltip -->
                        <span
                        class="absolute left-1/2 -translate-x-1/2 -top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        Campo obligatorio
                        </span>
                    </label>

                    <div class="formulario__dato">
                        <select
                        id="perfilempleado"
                        class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                        name="perfil"
                        required
                        >
                        <option value="" disabled selected>-Seleccionar-</option>
                        <option value="2" <?php echo $empleado->perfil==1?'selected':'';?>>Supervisor</option>
                        <option value="3" <?php echo $empleado->perfil==2?'selected':'';?>>Administrador</option>
                        <option value="4" <?php echo $empleado->perfil==3?'selected':'';?>>Asesor</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="contentpermisos" style="display: none;">
            <!-- Módulo de Ventas -->
                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-xl font-bold mb-4">Módulo de Ventas</p>

                    <label for="habilitarmoduloventa" class="flex items-center justify-between cursor-pointer mb-3">
                    <span class="text-gray-600 text-xl dark:text-gray-300">Habilitar módulo de venta</span>
                    <input id="habilitarmoduloventa" name="permisos[]" value="1" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="registrarventa" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Registrar nueva venta</span>
                        <input id="registrarventa" name="permisos[]" value="2" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="anularventa" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Anular una venta</span>
                        <input id="anularventa" name="permisos[]" value="3" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="aplicardescuentos" class="flex items-center justify-between cursor-pointer">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Aplicar descuentos</span>
                        <input id="aplicardescuentos" name="permisos[]" value="4" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-xl font-bold mb-4">Módulo de Inicio</p>

                    <label for="habilitarmoduloinicio" class="flex items-center justify-between cursor-pointer mb-3">
                    <span class="text-gray-600 text-xl dark:text-gray-300">Habilitar módulo de inicio</span>
                    <input id="habilitarmoduloinicio" name="permisos[]" value="1" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                </div>

                <!-- Módulo de Inventario -->
                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-xl font-bold mb-4">Módulo de Inventario</p>

                    <label for="habilitarmoduloinventario" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Habilitar módulo de inventario</span>
                        <input id="habilitarmoduloinventario" name="permisos[]" value="5" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="consultarstock" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Consultar stock</span>
                        <input id="consultarstock" name="permisos[]" value="6" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="ajustarinventario" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Hacer ajustes de inventario</span>
                        <input id="ajustarinventario" name="permisos[]" value="7" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="actualizarprecios" class="flex items-center justify-between cursor-pointer">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Actualizar precios o datos</span>
                        <input id="actualizarprecios" name="permisos[]" value="8" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                </div>

                <!-- Módulo de Facturación -->
                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-xl font-bold mb-4">Módulo de Facturación</p>

                    <label for="habilitarmodulofacturacion" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300">Habilitar módulo de facturación</span>
                        <input id="habilitarmodulofacturacion" name="permisos[]" value="9" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="emitirfacturaselectronicas" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Emitir facturas electrónicas</span>
                        <input id="emitirfacturaselectronicas" name="permisos[]" value="10" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="eliminarfacturas" class="flex items-center justify-between cursor-pointer">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Anular facturas y notas créditos</span>
                        <input id="eliminarfacturas" name="permisos[]" value="11" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                </div>

                <!-- Módulo de Caja -->
                <div class="p-4 border border-gray-200 rounded-lg moduloventas mb-4">
                    <p class="text-slate-600 text-xl font-bold mb-4">Módulo de Caja</p>

                    <label for="habilitarmodulocaja" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Habilitar módulo de caja</span>
                        <input id="habilitarmodulocaja" name="permisos[]" value="12" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="abrircaja" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Abrir caja registradora</span>
                        <input id="abrircaja" name="permisos[]" value="13" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="cerrarcaja" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Cerrar caja y generar arqueo</span>
                        <input id="cerrarcaja" name="permisos[]" value="14" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="verreportescaja" class="flex items-center justify-between cursor-pointer">
                        <span class="text-gray-600 dark:text-gray-300">Ver reportes de caja</span>
                        <input id="verreportescaja" name="permisos[]" value="15" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
                </div>
            </div>

            <div id="contentpermisosadmin" style="display: none;">
                <div class="p-4 border border-gray-200 rounded-lg moduloadmin mb-4">
                    <p class="text-slate-600 text-xl font-bold mb-4">Módulos Administrativos</p>

                    <label for="habilitarreportes" class="flex items-center justify-between cursor-pointer mb-3">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Habilitar módulo de reportes</span>
                        <input id="habilitarreportes" name="permisos[]" value="16" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>

                    <label for="habilitarconfiguracion" class="flex items-center justify-between cursor-pointer">
                        <span class="text-gray-600 dark:text-gray-300 text-xl">Habilitar módulo de configuración</span>
                        <input id="habilitarconfiguracion" name="permisos[]" value="17" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 relative transition">
                            <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:translate-x-5 transition"></div>
                        </div>
                    </label>
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