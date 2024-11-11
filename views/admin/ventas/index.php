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
            <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#2">Todos</a>
            <?php foreach($categorias as $categoria): ?>
              <a class=" text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#2"><?php echo $categoria->nombre;?></a>
            <?php endforeach; ?>
          </div>
        </button>
        <button class="btn-md btn-lima">Otros</button>
      </div>

      <div id="productos" class="grid gap-4 grid-cols-2 lg:grid-cols-3 mt-4 border-solid border-t-2 border-gray-400 pt-4"> <!-- contenedor de los productos -->
        
        <?php foreach($productos as $producto): ?>
        <div id="producto" class="producto rounded-lg bg-slate-200 flex gap-4 py-4 pr-4" data-id="<?php echo $producto->id;?>">
          <img src="/build/img/<?php echo $producto->foto;?>" class="inline h-24 min-w-24 w-24 object-contain" alt="">
          <div class="flex flex-col justify-between grow overflow-hidden">
            <p class="m-0 text-xl leading-5 text-slate-500"><?php echo $producto->nombre; ?></p>
            <p class="m-0 text-blue-600 font-semibold"><?php echo $producto->precio_venta; ?></p>
          </div>
        </div>
        <?php endforeach; ?>

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
        <table class=" tabla" width="100%" id="tablaventa">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Und</th>
                    <th>Total</th>
                    <th class="accionesth text-red-500"><i class="fa-solid fa-x"></i></th>
                </tr>
            </thead>
            <tbody>
                <!--<tr>        
                    <td class="!p-2 text-xl text-gray-500 leading-5">Multivitaminico Womens Blend</td> 
                    <td class="!px-0 !py-2"><div class="flex"><button><span class="material-symbols-outlined">remove</span></button><input type="text" class="w-20 px-2 text-center" value="2"><button><span class="material-symbols-outlined">add</span></button></div></td>
                    <td class="!p-2 text-xl text-gray-500 leading-5">$320.000</td>
                    <td class="!p-2 text-xl text-gray-500 leading-5">$320.000</td>
                    <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>
                </tr>-->
                
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
            <p id="subTotal" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$0</p>
            <p id="impuesto" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$0</p>
            <p id="descuento" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$0</p>
            <p id="total" class="m-0 mb-2 text-slate-600 text-3xl font-semibold">$0</p>
          </div>
        </div>
      </div>
      <div class="text-center p-4">
        <button id="btnvaciar" class="btn-md btn-red mr-6">Vaciar</button>
        <button id="btnguardar" class="btn-md btn-turquoise mr-6">Guardar</button>
        <button id="btnfacturar" class="btn-md btn-blueintense">Facturar</button>
      </div>
    </div> <!-- fin segunda columna -->

  </div>


  <!-- MODAL PARA FINALizAR LA CITA Y CAMBIAR SU ESTADO A FINALIZAR, O ELIMINAR LA CITA-->
  <dialog class="midialog-xs px-2 pb-2" id="miDialogoVaciar">
      <div>
          <p class="text-weight500 text-greydark"></p>
          <p class="text-weight500 text-greydark"></p>
          <p class="text-xs text-greydark mb-0 pb-1"></p>
      </div>
      <div id="" class="terminarcita dflex flex-justifyAround borderT-greyclear pt-1">
          <div class="fincita dflex cursorpointer t-AllEase03 hoverScale1 text-blue text-weight600"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Pagar</p></div>
          <div class="eliminarcita dflex cursorpointer t-AllEase03 hoverScale1 text-red text-weight600"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">Eliminar</p></div>
      </div>
  </dialog>
  <!--///////////////////// Moal procesar el pago boton facturar /////////////////////////-->
  <dialog class="midialog-lg px-2 pb-2" id="miDialogoFinCita">
      <h4 class="dashboard__heading2 m-0">Registrar venta de cita</h4>
      <form class="formulario" action="/admin/citas/finalizar" method="POST">
          <input id="idcita" name="id" type="hidden">
          <div class="tabslife">
              <p class="text-center text-greydark">Elegir metodo de pago</p>
              <div id="metodospago" class="tabslife-content">
                  <?php foreach($mediospago as $index => $value): ?>
                      <label><input type="radio" name="radio" value="<?php echo $value->id??'';?>" <?php echo $index==0?'checked':'';?> ><span><?php echo $value->mediopago;?></span></label>
                  <?php endforeach; ?>
              </div>
          </div>
          <div class="dflex alignItems-center flex-justifyEvenly">
              <p class="text-greydark">Total: $<span id="valorcita" class="text-md text-greydark text-weight600">28.000</span></p>
              <p class="text-greydark text-xs">Cambio: <span id="cambio" class="text-orange text-sm text-weight500">$0</span></p>
          </div>
          <div class="dflex-sm flex-justifyAround">
              <div class="">
                  <p class="m-0 mb-1 text-md text-weight700 text-greyblack">Fecha de la cita:</p>
                  <span id="finfecha" class="dblock mb-2 text-xs text-greydark text-weight600">2024/8/11 - 11:30am</span>
                  <div class="formulario__campo">
                      <label class="formulario__label" for="">Cliente: </label>
                      <input id="fincliente" class="formulario__input" name="" type="text" value="Lupe lulu">
                  </div>
                  <div class="formulario__campo">
                      <label class="formulario__label" for="">Servicio</label>
                      <select class="formulario__select"  id="finservicios" name="" required disabled>
                          <option value="0" disabled selected> -Selecionar- </option>
                      </select>
                  </div>
              </div>
              <div class="">
                  <div class="formulario__campo">
                      <label class="formulario__label" for="">Empleado</label>
                      <select class="formulario__select"  id="finprofesionales" name="" required>
                          <option value="0" disabled selected> -Selecionar- </option>
                          <?php foreach($profesionales as $value):  ?>
                          <option value="<?php echo $value->id??'';?>"><?php echo $value->nombre??''.' '.$value->apellido??'';?></option>
                          <?php endforeach;  ?>
                      </select>
                  </div>
                  <div class="finRefPago formulario__campo dnone">
                      <label class="formulario__label" for="finRefPago">Referencia de pago: </label>
                      <input class="formulario__input" id="finRefPago" name="" type="text" placeholder="transaccion" value="" disabled>
                  </div>
                  <div class="finRecibio formulario__campo">
                      <label class="formulario__label" for="finRecibio">Recibido: </label>
                      <input class="formulario__input inputfocus-orange-2 text-orange text-weight500" id="finRecibio" name="" type="text" placeholder="0" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                  </div>
                  <div class="formulario__campo">
                      <textarea class="formulario__textarea" id="finobservacion" name="finobservacion" placeholder="Observaciones" rows="4"></textarea>
                  </div>

              </div>

          </div>
          <div class="aselfEnd">
              <button class="btn-md btn-red" type="button" value="cancelar">cancelar</button>
              <input class="btn-md btn-blue" type="submit" value="Crear Venta">
          </div>
          
      </form>
  </dialog>
</div>