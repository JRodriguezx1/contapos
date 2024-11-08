<div class="box">
  <div class="flex flex-col tlg:flex-row">
    <div class="basis-2/3 p-4">
      <!--<form id="" class="formulario" action="" method="POST">
              <div class="formulario__campo">
                  <label class="formulario__label" for="cliente">Cliente</label>
                  <select class="formulario__select" name="cliente" id="cliente" required>
                      <option value="" disabled selected>-Seleccionar-</option>
                      <option value="1" <?php //echo $empleado->perfil==1?'selected':'';?> >Bernardo Fernando Mondragon Castañeda</option>
                      <option value="2" <?php //echo $empleado->perfil==2?'selected':'';?>>Admin</option>
                      <option value="3" <?php //echo $empleado->perfil==3?'selected':'';?>>Propietario</option>
                  </select>                   
              </div>
              <div class="formulario__campo">
                  <label class="formulario__label" for="nombre">Nombre</label>
                  <div class="formulario__dato">
                      <input class="formulario__input" type="text" placeholder="Nombre del cliente" id="nombre" name="nombre" value="<?php echo $empleado->nombre??'';?>" required>
                      <label data-num="42" class="count-charts" for="">42</label>
                  </div>
              </div>
              <div class="formulario__campo">
                  <label class="formulario__label" for="apellido">Apellido</label>
                  <div class="formulario__dato">
                      <input class="formulario__input" type="text" placeholder="Apellido del cliente" id="apellido" name="apellido" value="<?php echo $empleado->apellido??'';?>" required>
                      <label data-num="42" class="count-charts" for="">42</label>
                  </div>
              </div>
              <div class="formulario__campo">
                  <label class="formulario__label" for="tipoid">Tipo de documento</label>
                  <select class="formulario__select" name="perfil" id="perfil" required>
                      <option value="" disabled selected>-Seleccionar-</option>
                      <option value="1">Cedula</option>
                      <option value="2">Nit</option>
                      <option value="3">Tarjeta de identidad</option>
                      <option value="4">Permiso proteccion Temporal</option>
                      <option value="5">Permiso temporal permanencia</option>
                      <option value="6">Pasaporte</option>
                  </select>                   
              </div>
              <div class="formulario__campo">
                  <label class="formulario__label" for="documento">N. Documento</label>
                  <div class="formulario__dato">
                      <input class="formulario__input" type="number" placeholder="Documento del cliente" id="documento" name="documento" value="<?php echo $empleado->movil??'';?>" required>
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
                  <label class="formulario__label" for="ciudad">Ciudad</label>
                  <div class="formulario__dato">
                      <input class="formulario__input" type="text" placeholder="ciudad" id="ciudad" name="ciudad" value="<?php echo $empleado->ciudad??'';?>">
                      <label data-num="14" class="count-charts" for="">14</label>
                  </div>
              </div>
      </form>-->
      <div class="xs:flex xs:flex-wrap gap-4">
        <div class="formulario__campo flex-1">
          <label class="formulario__label" for="cliente">Cliente</label>
          <div class="formulario__dato">
            <select class="formulario__select !border-gray-300 !rounded-r-none !border-r-0" name="cliente" id="cliente" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="1" <?php //echo $empleado->perfil==1?'selected':'';?> >Bernardo Fernando Mondragon Castañeda</option>
                <option value="2" <?php //echo $empleado->perfil==2?'selected':'';?>>Admin</option>
                <option value="3" <?php //echo $empleado->perfil==3?'selected':'';?>>Propietario</option>
            </select>
            <div class="grid place-items-center  rounded-r-lg border-solid border border-gray-300 !border-l-0 hover:cursor-pointer">
              <span class="material-symbols-outlined text-blue-500 hover:text-blue-800">add_circle</span>
            </div>
          </div>
        </div>
        <div class="formulario__campo flex-1">
            <label class="formulario__label" for="nombre">Nombre</label>
            <input class="formulario__input !border-gray-300" type="text" placeholder="Nombre del cliente" id="nombre" name="nombre" value="<?php echo $empleado->nombre??'';?>" required>
        </div>
        <div class="formulario__campo flex-1 xs:flex-none">
            <label class="formulario__label" for="documento">N. Documento</label>
            <input class="formulario__input !border-gray-300" type="number" placeholder="Documento del cliente" id="documento" name="documento" value="<?php echo $empleado->movil??'';?>" required>
        </div>
      </div>

      
      <div class="formulario__dato justify-center">
          <input class="formulario__input !border-gray-300 !flex-none w-11/12 xs:w-2/3 !border-r-0" type="text" placeholder="Buscar nombre de producto/SKU/escanear codigo" id="nombre" name="nombre" value="<?php echo $empleado->nombre??'';?>" required>
          <div class="grid place-items-center  rounded-r-lg border-solid border border-gray-300 !border-l-0 hover:cursor-pointer">
            <span class="material-symbols-outlined pr-1">search</span>
          </div>
      </div>
      
      <div class="mt-4">
        <button class="group relative btn-md btn-blueintense">Categorias
          <div class="absolute bg-white flex flex-col items-start top-full left-0 rounded-lg pt-2 pb-3 px-4 shadow-md scale-y-0 group-focus:scale-y-100 origin-top duration-200">
            <?php foreach($categorias as $categoria): ?>
              <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#2"><?php echo $categoria->nombre;?></a>
            <?php endforeach; ?>
            <!--<a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#1">hola</a>
            <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#2">Herramientas electricas</a>
            <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#3">lulu</a>
            <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#1">hola lupe lulu</a>
            <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#2">Herramientas electricas</a>
            <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#3">lupe lulu</a>-->
          </div>
        </button>
        <button class="btn-md btn-lima">Otros</button>
      </div>

      <div class="grid gap-4 grid-cols-2 lg:grid-cols-3 mt-4 border-solid border-t-2 border-gray-400 pt-4"> <!-- contenedor de los productos -->
        <?php foreach($productos as $producto): ?>
        <div class="rounded-lg bg-slate-200 flex gap-4 py-4 pr-4">
          <img src="/build/img/<?php echo $producto->foto;?>" class="inline h-24 min-w-24 w-24 object-contain" alt="">
          <div class="flex flex-col justify-between grow overflow-hidden">
            <p class="m-0 text-xl leading-5 text-slate-500"><?php echo $producto->nombre; ?></p>
            <p class="m-0 text-blue-600 font-semibold"><?php echo $producto->precio_venta; ?></p>
          </div>
        </div>
        <?php endforeach; ?>
        <!--
        <div class="rounded-lg bg-slate-200 flex gap-4 py-4 pr-4">
          <img src="/build/img/cliente1/productos/tenis1.jpg" class="inline h-24 min-w-24 w-24 object-contain" alt="">
          <div class="flex flex-col justify-between grow overflow-hidden">
            <p class="m-0 text-xl leading-5 text-slate-500">Multivitaminico Womens Blend</p>
            <p class="m-0 text-blue-600 font-semibold">$135.000</p>
          </div>
        </div>
        <div class="rounded-lg bg-slate-200 flex gap-4 py-4 pr-4">
          <img src="/build/img/cliente1/productos/vitaminas5.jpg" class="inline h-24 min-w-24 w-24 object-contain" alt="">
          <div class="flex flex-col justify-between grow overflow-hidden">
            <p class="m-0 text-xl leading-5 text-slate-400">Multivitaminico Womens Blend</p>
            <p class="m-0 text-blue-600 font-semibold">$135.000</p>
          </div>
        </div>
        <div class="rounded-lg border-solid border border-gray-300 flex gap-4 py-4 pr-4">
          <img src="/build/img/cliente1/productos/movil2.jpg" class="inline h-24 min-w-24 w-24 object-contain" alt="">
          <div class="flex flex-col justify-between grow overflow-hidden">
            <p class="m-0 text-xl leading-5 text-slate-400">Multivitaminico Womens Blend</p>
            <p class="m-0 text-blue-600 font-semibold">$135.000</p>
          </div>
        </div>
        <div class="rounded-lg bg-indigo-50 flex gap-4 py-4 pr-4">
          <img src="/build/img/cliente1/productos/control1.jpg" class="inline h-24 min-w-24 w-24 object-contain" alt="">
          <div class="flex flex-col justify-between grow overflow-hidden">
            <p class="m-0 text-xl leading-5 text-slate-400">Multivitaminico Womens Blend</p>
            <p class="m-0 text-blue-600 font-semibold">$135.000</p>
          </div>
        </div>-->

      </div> <!-- fin contenedor de productos -->
    </div> <!-- fin primera columna -->

    <div class="basis-1/3">
      <div class="formulario__campo">
          <label class="formulario__label" for="vendedor">vendedor</label>
          <div class="formulario__dato">
            <span class="material-symbols-outlined">person</span>
            <input class="formulario__input !border-gray-300" type="text" placeholder="Nombre del Vendedor" id="vendedor" name="vendedor" value="<?php echo $empleado->vendedor??'';?>" required>
          </div>
      </div>
      <div class="formulario__campo">
          <label class="formulario__label" for="pedido">N. Pedido</label>
          <div class="formulario__dato">
            <span class="material-symbols-outlined">arrow_right</span>
            <input class="formulario__input !border-gray-300" type="number" placeholder="Numero de pedido" id="pedido" name="pedido" value="<?php echo $empleado->movil??'';?>" required>
          </div>
      </div>

      <div class="px-4 mb-4 flex items-center justify-between">
        <div>
          <button class="btn-xs btn-light">Entrega</button>
          <span class="text-red-500 text-2xl font-medium">: Presencial</span>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-3xl text-neutral-500">CARRITO:</span>
          <span class="text-3xl font-medium text-neutral-500">4</span>
        </div>
      </div>
      <!-- Apilamiento de productos -->
      <div class="border-solid border-t-2 border-blue-600 pt-4">
        <table class=" tabla" width="100%" id="">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th class="accionesth">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <tr>        
                    <td class="!p-2 text-xl text-gray-500 leading-5">Multivitaminico Womens Blend</td> 
                    <td class="!p-2"><div class="flex"><button><span class="material-symbols-outlined">remove</span></button><input type="text" class="w-20 px-2 text-center" value="2"><button><span class="material-symbols-outlined">add</span></button></div></td>
                    <td class="!p-2 text-xl text-gray-500 leading-5">$320.000</td>
                    <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>
                </tr>
                <tr>        
                    <td class="!p-2 text-xl text-gray-500 leading-5">Multivitaminico Womens Blend</td> 
                    <td class="!p-2"><div class="flex"><button><span class="material-symbols-outlined">remove</span></button><input type="text" class="w-20 px-2 text-center" value="1"><button><span class="material-symbols-outlined">add</span></button></div></td>
                    <td class="!p-2 text-xl text-gray-500 leading-5">$320.000</td>
                    <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>
                </tr>
                <tr>        
                    <td class="!p-2 text-xl text-gray-500 leading-5">Multivitaminico Womens Blend</td> 
                    <td class="!p-2"><div class="flex"><button><span class="material-symbols-outlined">remove</span></button><input type="text" class="w-20 px-2 text-center" value="6"><button><span class="material-symbols-outlined">add</span></button></div></td>
                    <td class="!p-2 text-xl text-gray-500 leading-5">$4.320.000</td>
                    <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>
                </tr>
            </tbody>
        </table>
      </div> <!-- FIn Apilamiento de productos -->
      <div class="flex justify-between items-start border-solid border border-gray-300 py-4 px-8">
        <button class="btn-xs btn-light">Descuento</button>
        <div class="flex justify-end gap-4">
          <div class="text-end">
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Sub Total:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Impuesto:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Descuento:</p>
            <p class="m-0 mb-2 text-slate-600 text-3xl font-semibold">Total:</p>
          </div>
          <div>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$987.250</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$84.500</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$4.500</p>
            <p class="m-0 mb-2 text-slate-600 text-3xl font-semibold">$1.172.374</p>
          </div>
        </div>
      </div>
      <div class="text-center p-4">
        <button class="btn-md btn-red mr-6">Vaciar</button>
        <button class="btn-md btn-turquoise mr-6">Guardar</button>
        <button class="btn-md btn-blueintense">Facturar</button>
      </div>
    </div> <!-- fin segunda columna -->

  </div>
</div>