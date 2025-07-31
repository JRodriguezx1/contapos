<h4 class="text-gray-600 text-center mb-4">Gestion De Empleado</h4>
<button id="crearempleado" class="btn-md btn-blueintense mb-1">Crear Empleado</button>
<table class="display responsive nowrap tabla" width="100%" id="tablaempleados">
    <thead>
        <tr>
            <th>N.</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Movil</th>
            <th>Email</th>
            <th>Cedula</th>
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
            <td class=""><?php echo $value->movil;?></td>
            <td class=""><?php echo $value->email;?></td>
            <td class=""><?php echo $value->cedula;?></td>
            <td class=""><?php echo $value->perfil==1?'Empleado':($value->perfil==2?'Admin':'Propietario');?></td>
            <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>">
                    <button class="btn-md btn-turquoise editarEmpleado"><i class="fa-solid fa-pen-to-square"></i></button><button class="btn-md btn-lima empleadoSkills"><i class="fa-solid fa-grip-vertical"></i></button> <button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<dialog class="midialog-md p-5" id="miDialogoEmpleado">
    <h4 id="modalEmpleado" class="font-semibold text-gray-700 mb-4">Crear empleado</h4>
    <div id="divmsjalerta1"></div>
    <form id="formCrearUpdateEmpleado" class="formulario" action="/admin/adminconfig/crear_empleado" enctype="multipart/form-data" method="POST">
        <div class="empleado-grid">
            <div class="formulario__campo">
                <div class="formulario__contentinputfile">
                    <div class="formulario__imginputfile"><img id="imginputfile" src="" alt=""></div>
                    <p class="text-greymouse">Subir imagen</p>
                </div>
                <input id="upImage" class="formulario__inputfile" type="file" name="img" hidden>
                <button id="customUpImage" class="btn-xs btn-blue self-center !rounded-3xl !px-8 !py-4" type="button">Cargar Imagen</button>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="nombre">Nombre</label>
                <div class="formulario__dato">
                    <input class="formulario__input" type="text" placeholder="Nombre del empleado" id="nombre" name="nombre" value="<?php echo $empleado->nombre??'';?>" required>
                    <label data-num="42" class="count-charts" for="">42</label>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="apellido">Apellido</label>
                <div class="formulario__dato">
                    <input class="formulario__input" type="text" placeholder="Apellido del empleado" id="apellido" name="apellido" value="<?php echo $empleado->apellido??'';?>" required>
                    <label data-num="42" class="count-charts" for="">42</label>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="movil">Movil</label>
                <div class="formulario__dato">
                    <input class="formulario__input" type="number" min="3000000000" max="3777777777" placeholder="Tu Movil" id="movil" name="movil" value="<?php echo $empleado->movil??'';?>" required>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="email">Email</label>
                <div class="formulario__dato">
                    <input class="formulario__input" type="email" placeholder="Tu Email" id="email" name="email" value="<?php echo $empleado->email??'';?>" required>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="direccion">Direccion</label>
                <div class="formulario__dato">
                    <input class="formulario__input" type="text" placeholder="Direccion de  residencia" id="direccion" name="direccion" value="<?php echo $empleado->direccion??'';?>">
                    <label data-num="90" class="count-charts" for="">90</label>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="departamento">Departamento</label>
                <div class="formulario__dato">
                    <input class="formulario__input" type="text" placeholder="departamento" id="departamento" name="departamento" value="<?php echo $empleado->departamento??''; ?>">
                    <label data-num="18" class="count-charts" for="">18</label>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="ciudad">Ciudad</label>
                <div class="formulario__dato">
                    <input class="formulario__input" type="text" placeholder="ciudad" id="ciudad" name="ciudad" value="<?php echo $empleado->ciudad??'';?>">
                    <label data-num="14" class="count-charts" for="">14</label>
                </div>
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="perfil">Perfil</label>
                <select class="formulario__select" name="perfil" id="perfil" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="1" <?php echo $empleado->perfil==1?'selected':'';?> >Empleado</option>
                    <option value="2" <?php echo $empleado->perfil==2?'selected':'';?>>Admin</option>
                    <option value="3" <?php echo $empleado->perfil==3?'selected':'';?>>Propietario</option>
                </select>                   
            </div>
        </div>
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="cancelar">cancelar</button>
            <input id="btnEditarCrearEmpleado" class="btn-md btn-blue" type="submit" value="Crear">
        </div>
    </form>
</dialog><!--fin crear empleado-->
<dialog class="midialog-md" id="miDialogoSkills">
    <h4 id="modalSkills" class="dashboard__heading2">My Skills</h4>
    <div id="divmsjalerta2"></div>
    <form id="formSkills" class="formulario" action="/admin/adminconfig/skills" method="POST">
        <h5>Julian Rodriguez</h5>
        <p>Empleado con las sigientes habilidades:</p>
        <div class="dflex flexWrap gap1">
            <?php foreach($servicios as $servicio): ?>
                <div class="inputskills stylecheckbox border-radius05 border-greyclear p-08">
                    <input type="checkbox" data-skillid ="<?php echo $servicio->id;?>" id="skill<?php echo $servicio->id;?>" value="<?php echo $servicio->id;?>">
                    <label for="skill<?php echo $servicio->id;?>"><?php echo $servicio->nombre;?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="cancelar">cancelar</button>
            <input id="btnEnviarSkills" class="btn-md btn-blue" type="submit" value="Actualizar">
        </div>
    </form>
</dialog><!--fin Act/ediar servicios/skills por empleado-->