
<div class="box clientes !pb-20"> 

        <?php include __DIR__. "/../../templates/alertas.php"; ?>
        <h4 class="text-gray-600 mb-12 mt-4">Gestiòn de clientes</h4>
        <button id="crearCliente" class="btn-md btn-indigo !py-4 !px-6 !w-[168px]"> + Crear Cliente</button>
        <button id="crearDireccion" class="bg-white text-gray-800 font-semibold text-2xl rounded-md border border-gray-300 shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400 py-4 px-6 w-[168px] md:mt-0 mt-[0.8rem]"> + Crear Dirección</button>
        
        <table class="display responsive nowrap tabla" width="100%" id="tablaClientes">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>telefono</th>
                    <th>Email</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clientes as $cliente): ?>
                    <?php if($cliente->id != 1){ ?>
                    <tr> 
                        <td class=""><?php echo $cliente->id; ?></td> 
                        <td class=""><?php echo $cliente->nombre; ?></td>         
                        <td class=""><?php echo $cliente->apellido; ?></td> 
                        <td class=""><?php echo $cliente->telefono; ?></td> 
                        <td class=""><?php echo $cliente->email; ?></td>        
                        <td class="accionestd">
                            <div class="acciones-btns" id="<?php echo $cliente->id;?>">
                                <button class="btn-md btn-turquoise editarClientes" title="Actualizar datos del cliente"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="btn-md btn-light editarEliminarDireccion" title="Actualizar dirección del cliente"><i class="fa-solid fa-location-dot"></i></button>
                                <a class="btn-md btn-bluedark" href="/admin/clientes/detalle?id=<?php echo $cliente->id;?>" title="Ver detalles del cliente"><i class="fa-solid fa-chart-simple"></i></a>
                                
                                <button class="btn-md btn-red eliminarClientes" title="Eliminar cliente"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <dialog class="midialog-sm p-12" id="miDialogoCliente">
            <h4 id="modalCliente" class="font-semibold text-gray-700 mb-4">Crear cliente</h4>
            <div id="divmsjalerta1"></div>
            <form id="formCrearUpdateCliente" class="formulario" action="/admin/clientes/crear" method="POST">
                
                <div class="formulario__campo">
                    <label class="formulario__label" for="nombre">Nombre</label>
                    <div class="formulario__dato">
                        <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del cliente" id="nombre" name="nombre" value="<?php echo $crearcliente->nombre??'';?>" required>
                        <!-- <label data-num="28" class="count-charts" for="">28</label> -->
                    </div>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="apellido">Apellido</label>
                    <div class="formulario__dato">
                        <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Apellido del cliente" id="apellido" name="apellido" value="<?php echo $crearcliente->apellido??'';?>" required>
                        <!-- <label data-num="28" class="count-charts" for="">28</label> -->
                    </div>
                </div>
                <div class="formulario__campo">
                    <label class="formulario__label" for="tipodocumento">Tipo de documento</label>
                    <select class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" id="tipodocumento" name="tipodocumento" required>
                        <option value="" disabled selected>-Seleccionar-</option>
                        <option value="1">Registro civil</option>
                        <option value="2">Tarjeta de identidad</option>
                        <option value="3">Cedula de ciudadania</option>
                        <option value="4">Tarjeta de extranjeria</option>
                        <option value="5">Cedula de extrangeria</option>
                        <option value="6">NIT</option>
                        <option value="7">Pasaporte</option>
                        <option value="8">Documento de identificacion extranjero</option>
                        <option value="9">NIT de otro pais</option>
                        <option value="10">NUIP</option>
                    </select>          
                </div>
                
                
                <div class="formulario__campo">
                    <label class="formulario__label" for="identificacion">Identificación</label>
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" min="0" placeholder="Identificacion del cliente" id="identificacion" name="identificacion" value="<?php echo $crearcliente->identificacion??'';?>" required>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="telefono">Teléfono</label>
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" minlength="7" placeholder="telefono del cliente" id="telefono" name="telefono" value="<?php echo $crearcliente->telefono??'';?>" required>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="email">Correo Electrónico</label>
                    <div class="formulario__dato">
                        <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="email" placeholder="Ingresa correo electrónico" id="email" name="email" value="<?php echo $crearcliente->email ?? '';?>" required>
                        <!-- <label data-num="50" class="count-charts" for="">50</label> -->
                    </div>
                </div>
                
                <div class="formulario__campo">
                    <label class="formulario__label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="date" placeholder="Fecha de nacimiento del cliente" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $crearcliente->fecha_nacimiento??'';?>">
                </div>

                <!--
                <div class="formulario__campo">
                    <label class="formulario__label" for="tarifa">Tarifa</label>
                    <select class="formulario__select" id="tarifa" name="tarifa" required>
                        <option value="" disabled selected>-Seleccionar-</option>
                        <?php //foreach($tarifas as $tarifa): ?>
                        <option value="<?php //echo $tarifa->id;?>"><?php //echo $tarifa->nombre;?></option>
                        <?php //endforeach; ?>
                    </select>          
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="departamento">Departamento</label>
                    <div class="formulario__dato">
                        <input class="formulario__input" type="text" placeholder="Departamento o region" id="departamento" name="departamento" value="">
                        <label data-num="28" class="count-charts" for="">28</label>
                    </div>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="ciudad">Ciudad</label>
                    <div class="formulario__dato">
                        <input class="formulario__input" type="text" placeholder="ciudad de residencia" id="ciudad" name="ciudad" value="">
                        <label data-num="28" class="count-charts" for="">28</label>
                    </div>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="direccion">Direccion</label>
                    <div class="formulario__dato">
                        <input class="formulario__input" type="text" placeholder="direccion de vivienda" id="direccion" name="direccion" value="">
                        <label data-num="28" class="count-charts" for="">28</label>
                    </div>
                </div>-->
                
                <div class="masopciones"></div>
                
                <div class="text-right">
                    <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="salir">Salir</button>
                    <input id="btnEditarCrearCliente" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Crear">
                </div>
            </form>
        </dialog><!--fin crear/editar cliente-->


        <dialog class="midialog-sm p-12" id="miDialogoCrearDireccion">
            <h4 id="modalDireccion" class="font-semibold text-gray-700 mb-4">Crear Dirección</h4>
            <div id="divmsjalerta2"></div>
            <form id="formCrearUpdateDireccion" class="formulario" action="/admin/direcciones/crear" method="POST">
                
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 border-b border-gray-900/10 pb-10 mb-3">
                    
                    <div class="sm:col-span-6">
                        <label class="formulario__label" for="selectcliente">Seleccionar Cliente</label>
                        <div class="mt-2">
                            <select id="selectcliente" name="idcliente" class=" bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" multiple="multiple" required>
                                <?php foreach($clientes as $cliente): ?>
                                    <?php if($cliente->id > 1){ ?>
                                        <option value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre.' '.$cliente->apellido;?></option>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </select>
                        </div>          
                    </div>

                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="tarifa">Tarifa</label>
                        <div class="mt-2">
                            <select id="tarifa" name="idtarifa" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <?php foreach($tarifas as $tarifa): ?>
                                <option value="<?php echo $tarifa->id;?>"><?php echo $tarifa->nombre;?></option>
                                <?php endforeach; ?>
                            </select>  
                        </div>        
                    </div>

                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="departamento">Departamento</label>
                        <div class="formulario__dato mt-2">
                            <input type="text" placeholder="Departamento o region" id="departamento" name="departamento" value="" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                            <!-- <label data-num="28" class="count-charts" for="">28</label> -->
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="ciudad">Ciudad</label>
                        <div class="formulario__dato mt-2">
                            <input type="text" placeholder="ciudad de residencia" id="ciudad" name="ciudad" value="" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                            <!-- <label data-num="28" class="count-charts" for="">28</label> -->
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="direccion">Dirección</label>
                        <div class="formulario__dato mt-2">
                            <input type="text" placeholder="direccion de vivienda" id="direccion" name="direccion" value="" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                            <!-- <label data-num="36" class="count-charts" for="">36</label> -->
                        </div>
                    </div>
                </div>
                
                <div class="text-right">
                    <button class="btn-md btn-turquoise !py-4 !px-6 !w-[180px]" type="button" value="salir">Salir</button>
                    <input id="btnEditarCrearDireccion" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[180px]" type="submit" value="Crear">
                </div>
            </form>
        </dialog><!--fin crear/editar direccion-->
    

        <dialog class="midialog-sm p-12" id="miDialogoUpDireccion">
            <div class="flex justify-between items-center">
                <h4 id="modalUpDireccion" class="font-semibold text-gray-700 mb-4">Actualizar Direccion</h4>
                <button id="btnCerrarUpDireccion" class="btn-md btn-indigo"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div id="divmsjalerta3"></div>
            <form id="formUpDireccion" class="formulario" action="/admin/direccions/actualizar" method="POST">
                
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 border-b border-gray-900/10 pb-10 mb-3">
                    
                    <div class="sm:col-span-6">
                        <label class="formulario__label" for="direcciones">Seleccionar direcciones</label>
                        <div class="mt-2">
                            <select id="selectdirecciones" name="direcciones" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                
                            </select>  
                        </div>        
                    </div>
                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="tarifa">Tarifa</label>
                        <div class="mt-2">
                            <select id="uptarifa" name="tarifa" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
                                <option value="" disabled selected>-Seleccionar-</option>
                                <?php foreach($tarifas as $tarifa): ?>
                                <option value="<?php echo $tarifa->id;?>"><?php echo $tarifa->nombre;?></option>
                                <?php endforeach; ?>
                            </select>  
                        </div>        
                    </div>
                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="departamento">Departamento</label>
                        <div class="formulario__dato mt-2">
                            <input type="text" placeholder="Departamento o region" id="updepartamento" name="departamento" value="" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                            <!-- <label data-num="28" class="count-charts" for="">28</label> -->
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="ciudad">Ciudad</label>
                        <div class="formulario__dato mt-2">
                            <input type="text" placeholder="ciudad de residencia" id="upciudad" name="ciudad" value="" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                            <!-- <label data-num="28" class="count-charts" for="">28</label> -->
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="formulario__label" for="direccion">Dirección</label>
                        <div class="formulario__dato mt-2">
                            <input type="text" placeholder="direccion de vivienda" id="updireccion" name="direccion" value="" class="bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                            <!-- <label data-num="36" class="count-charts" for="">36</label> -->
                        </div>
                    </div>
                </div>
                
                <div class="text-right">
                    <button id="btnRemoveDireccion" class="btn-md btn-turquoise !py-4 !px-6 !w-[180px]" type="submit" value="Eliminar">Eliminar</button>
                    <input id="btnUpDireccion" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[180px]" type="submit" value="Actualizar">
                </div>
            </form>
        </dialog><!--fin actualizar direccion-->
</div>