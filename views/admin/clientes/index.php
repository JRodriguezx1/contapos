
<div class="clientes">
    <div class="clientes__contenedor">
        <?php include __DIR__. "/../../templates/alertas.php"; ?>
        <div class="clientes__acciones">
            <div class="clientes__crear">
                <span id="crearcliente" class="btnsmall"> + Crear Cliente</span>
            </div>
            
                <div class="clientes__busqueda">
                    <form action="/admin/clientes" method="POST">
                        <select class="formulario__select" name="filtro" id="selectprofesional" required>
                            <option value="" disabled selected>-- Seleccione --</option>
                            <!--<option value="all" > All </option>-->
                            <option value="nombre" > Nombre </option>
                            <option value="email" > Email </option>
                            <option value="movil" > Movil </option>
                        </select>
                        <div class="btn_busqueda">
                            <input class="formulario__input" type="text" name="buscar" placeholder="buscar" required value="<?php echo $buscar ?? ''; ?>">
                            <label for="busqueda"><i class="lupa fa-solid fa-magnifying-glass"></i></label>
                            <input id="busqueda" type="submit" value="Buscar">
                        </div>
                    </form>
                </div>
            
        </div>

        <div class="clientes__tabla">
            <table class="tabla">
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
                        <?php if($cliente->id != 2){ ?>
                        <tr> 
                            <td class=""><?php echo $cliente->id; ?></td> 
                            <td class=""><?php echo $cliente->nombre; ?></td>         
                            <td class=""><?php echo $cliente->apellido; ?></td> 
                            <td class=""><?php echo $cliente->telefono; ?></td> 
                            <td class=""><?php echo $cliente->email; ?></td>        
                            <td class="accionestd"> <div data-id="<?php echo $cliente->id;?>" class="acciones-iconos"> <i title="Eitar datos del clinete" id="editar" class="finalizado fa-solid fa-pen-clip"></i><a href="/admin/clientes/detalle?id=<?php echo $cliente->id;?>"><i class="programar fa-solid fa-tablet-screen-button"></i></a><i title="Habilitar/deshabilidar cliente" id="hab_desh" class="<?php echo $cliente->habilitar==1?'cancelado fa-solid fa-x':'habilitar fa-solid fa-check' ?>"></i></div></td>    
                        </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> <!-- fin clientes__tabla -->
    </div> <!-- fin citas contenedor -->
</div>