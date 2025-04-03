
<div class="box clientes">
    
        <?php include __DIR__. "/../../templates/alertas.php"; ?>
        <h4 class="text-gray-600 mb-12 mt-4">Gestion de clientes</h4>
        <button id="crearCliente" class="btn-md btn-blue mb-4"> + Crear Cliente</button>
        <button id="crearCliente" class="btn-xs btn-light mb-4"> + Crear Direccion</button>
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
                                <button class="btn-md btn-turquoise editarClientes"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="btn-md btn-light editarEliminarDireccion"><i class="fa-solid fa-location-dot"></i></button>
                                <a class="btn-md btn-bluedark" href="/admin/clientes/detalle?id=<?php echo $cliente->id;?>"><i class="fa-solid fa-chart-simple"></i></a>
                                
                                <button class="btn-md btn-red eliminarClientes"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <dialog class="midialog-sm p-5" id="miDialogoCliente">
            <h4 id="modalCliente" class="font-semibold text-gray-700 mb-4">Crear cliente</h4>
            <div id="divmsjalerta1"></div>
            <form id="formCrearUpdateCliente" class="formulario" action="/admin/clientes/crear" method="POST">
                
                <div class="formulario__campo">
                    <label class="formulario__label" for="nombre">Nombre</label>
                    <div class="formulario__dato">
                        <input class="formulario__input" type="text" placeholder="Nombre del cliente" id="nombre" name="nombre" value="<?php echo $crearcliente->nombre??'';?>" required>
                        <label data-num="28" class="count-charts" for="">28</label>
                    </div>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="apellido">Apellido</label>
                    <div class="formulario__dato">
                        <input class="formulario__input" type="text" placeholder="Apellido del cliente" id="apellido" name="apellido" value="<?php echo $crearcliente->apellido??'';?>" required>
                        <label data-num="28" class="count-charts" for="">28</label>
                    </div>
                </div>
                <div class="formulario__campo">
                    <label class="formulario__label" for="tipodocumento">Tipo de documento</label>
                    <select class="formulario__select" id="tipodocumento" name="tipodocumento" required>
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
                    <label class="formulario__label" for="identificacion">Identificacion</label>
                    <input class="formulario__input" type="text" min="0" placeholder="Identificacion del cliente" id="identificacion" name="identificacion" value="<?php echo $crearcliente->identificacion??'';?>" required>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="telefono">telefono</label>
                    <input class="formulario__input" type="number" min="0" placeholder="telefono del cliente" id="telefono" name="telefono" value="<?php echo $crearcliente->telefono??'';?>" required>
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="email">Correo Electrónico</label>
                    <div class="formulario__dato">
                        <input class="formulario__input" type="email" placeholder="Ingresa correo electrónico" id="email" name="email" value="<?php echo $crearcliente->email ?? '';?>" required>
                        <label data-num="50" class="count-charts" for="">50</label>
                    </div>
                </div>
                
                <div class="formulario__campo">
                    <label class="formulario__label" for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input class="formulario__input" type="date" placeholder="Fecha de nacimiento del cliente" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $crearcliente->fecha_nacimiento??'';?>">
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
                    <button class="btn-md btn-red" type="button" value="salir">Salir</button>
                    <input id="btnEditarCrearCliente" class="btn-md btn-blue" type="submit" value="Crear">
                </div>
            </form>
        </dialog><!--fin crear/editar cliente-->


        <dialog class="midialog-sm p-5" id="miDialogoCrearDireccion">
            <h4 id="modalDireccion" class="font-semibold text-gray-700 mb-4">Crear Direccion</h4>
            <div id="divmsjalerta1"></div>
            <form id="formCrearUpdateDireccion" class="formulario" action="/admin/direccions/crear" method="POST">
                
                
                <div class="formulario__campo">
                    <label class="formulario__label" for="tipodocumento">Tipo de documento</label>
                    <select class="formulario__select" id="tipodocumento" name="tipodocumento" required>
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
                </div>
                
                <div class="masopciones"></div>
                
                <div class="text-right">
                    <button class="btn-md btn-red" type="button" value="salir">Salir</button>
                    <input id="btnEditarCrearDireccion" class="btn-md btn-blue" type="submit" value="Crear">
                </div>
            </form>
        </dialog><!--fin crear/editar direccion-->
    
</div>