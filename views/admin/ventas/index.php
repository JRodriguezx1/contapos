<div class="box ventas">
  <div class="flex flex-col tlg:flex-row">
    <div class="basis-2/3 p-4">
      <div id="divmsjalerta1"></div>
      <div class="xs:flex xs:flex-wrap gap-4">
        <div class="formulario__campo flex-1">
          <label class="formulario__label" for="selectCliente">Cliente</label>
          <div class="formulario__dato">
            <select class="formulario__select !border-gray-300 !rounded-r-none !border-r-0" id="selectCliente" name="selectCliente" required>
                <option value="1" disabled selected>-Seleccionar-</option>
                <?php foreach($clientes as $cliente): ?>
                  <option data-tipoID="<?php echo $cliente->tipodocumento;?>" data-identidad="<?php echo $cliente->identificacion;?>" value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre.' '.$cliente->apellido;?></option>
                <?php endforeach ?>
            </select>
            <div class="grid place-items-center  rounded-r-lg border-solid border border-gray-300 !border-l-0 hover:cursor-pointer">
              <span id="addcliente" class="material-symbols-outlined text-blue-500 hover:text-blue-800">add_circle</span>
            </div>
          </div> <!-- fin formulario dato-->
          <div class="formulario__campo flex-1 xs:flex-none">
            <label class="formulario__label" for="documento">N. Documento</label>
            <input class="formulario__input !border-gray-300" type="number" placeholder="Documento del cliente" id="documento" name="documento" readonly>
          </div>
        </div>
        <div class="formulario__campo flex-1">
            <label class="formulario__label" for="direccionEntrega">Direccion</label>
            <div class="formulario__dato">
              <select class="formulario__select !border-gray-300 !rounded-r-none !border-r-0" id="direccionEntrega" name="direccionEntrega" required>
                  <option value="1" disabled selected>-Seleccionar-</option>
              </select>
              <div class="grid place-items-center  rounded-r-lg border-solid border border-gray-300 !border-l-0 hover:cursor-pointer">
                <span id="adddir" class="material-symbols-outlined text-blue-500 hover:text-blue-800">add_circle</span>
              </div>
            </div> <!-- fin formulario dato-->
        </div>
        <div class="formulario__campo flex-1">
            <label class="formulario__label" for="ciudad">Ciudad</label>
            <input class="formulario__input !border-gray-300" type="text" placeholder="Ciudad de entrega" id="ciudadEntrega" name="ciudadEntrega" readonly>
        </div>
      </div>

    
      <div class="formulario__dato justify-center">
          <input class="formulario__input !border-gray-300 !flex-none w-11/12 xs:w-2/3 !border-r-0" type="text" placeholder="Buscar nombre de producto/SKU/escanear codigo" id="buscarproducto" name="buscarproducto" value="" required>
          <div class="grid place-items-center  rounded-r-lg border-solid border border-gray-300 !border-l-0 hover:cursor-pointer">
            <span class="material-symbols-outlined pr-1">search</span>
          </div>
      </div>
      
      <div class="mt-4">
        <button class="group relative btn-md btn-blueintense">Categorias
          <div class="absolute bg-white flex flex-col items-start top-full left-0 rounded-lg pt-2 pb-3 px-4 shadow-md scale-y-0 group-hover:scale-y-100 origin-top duration-200">
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
            <input data-idVendedor="<?php echo $user['id'];?>" class="formulario__input !border-gray-300" type="text" placeholder="Nombre del Vendedor" id="vendedor" name="vendedor" value="<?php echo $user['nombre'];?>" readonly>
          </div>
      </div>
      <div class="formulario__campo">
          <label class="formulario__label" for="pedido">N. Ultima Factura/Pedido</label>
          <div class="formulario__dato">
            <span class="material-symbols-outlined">arrow_right</span>
            <input class="formulario__input !border-gray-300" type="number" placeholder="Numero de pedido" id="pedido" name="pedido" value="1" readonly>
          </div>
      </div>

      <div class="px-4 mb-4 flex items-center justify-between">
        <div>
          <button id="btnEntrega" class="btn-xs btn-light">Entrega</button>
          <span id="modalidadEntrega" class="text-red-500 text-2xl font-medium">: Presencial</span>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-3xl text-neutral-500">CARRITO:</span>
          <span id="totalunidades" class="text-3xl font-medium text-neutral-500">0</span>
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
                <!-- productos seleccionados a vender
                <td class="!px-0 !py-2 text-xl text-gray-500 leading-5">lupe lulu</td> 
                <td class="!px-0 !py-2"><div class="flex"><button><span class="menos material-symbols-outlined">remove</span></button><input type="text" class=" w-20 px-2 text-center" value="11" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"><button><span class="mas material-symbols-outlined">add</span></button></div></td>
                <td class="!p-2 text-xl text-gray-500 leading-5">56000</td>
                <td class="!p-2 text-xl text-gray-500 leading-5">56880</td>
                <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>-->
            </tbody>
        </table>
      </div> <!-- FIn Apilamiento de productos -->
      <div class="flex justify-between items-start border-solid border border-gray-300 py-4 px-8">
        <button id="btndescuento" class="btn-xs btn-light">Descuento</button>
        <div class="flex justify-end gap-4">
          <div class="text-end">
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Sub Total:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Impuesto:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Descuento:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Tarifa Envio:</p>
            <p class="m-0 mb-2 text-slate-600 text-3xl font-semibold">Total:</p>
          </div>
          <div>
            <p id="subTotal" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$0</p>
            <p id="impuesto" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$0</p>
            <p id="descuento" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$0</p>
            <p id="valorTarifa" class="m-0 mb-2 text-slate-600 text-2xl font-normal">$0</p>
            <p id="total" class="m-0 mb-2 text-green-500 text-4xl font-semibold" style="font-family: 'Tektur', serif;">$ 0</p>
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


  <!-- MODAL PARA CREAR O AÑADIR CLIENTE-->
  <dialog class="midialog-sm p-5" id="miDialogoAddCliente">
      <h4 class=" text-gray-700 font-semibold">Crear Cliente</h4>
      <form id="formAddCliente" class="formulario" action="/" enctype="multipart/form-data" method="POST">

      <div class="border-b border-gray-900/10 pb-10 mb-3">
        
        <p class="mt-2 text-xl text-gray-600">Informacion Personal.</p>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="nombreclientenuevo" class="block text-2xl font-medium text-gray-600">Nombre</label>
            <div class="mt-2">
              <input type="text" name="nombreclientenuevo" id="nombreclientenuevo" autocomplete="given-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="clientenuevoapellido" class="block text-2xl font-medium text-gray-600">Apellido</label>
            <div class="mt-2">
              <input type="text" name="clientenuevoapellido" id="clientenuevoapellido" autocomplete="family-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="tipodocumento" class="block text-2xl font-medium text-gray-600">Tipo de documento</label>
            <div class="mt-2 grid grid-cols-1">
              <select id="tipodocumento" name="tipodocumento" autocomplete="tipodocumento-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                <option value="CC">CC</option>
                <option value="NIT">NIT</option>
                <option value="PASAPORTE">PASAPORTE</option>
                <option value="PERMISO TEMPORAL">PERMISO TEMPORAL</option>
                <option value="PERMISO ESPECIAL DE PERMANENCIA">PERMISO ESPECIAL DE PERMANENCIA</option>
                <option value="TARJETA DE INDENTIDAD">TARJETA DE INDENTIDAD</option>
                <option value="CEDULA DE EXTRANJERIA">CEDULA DE EXTRANJERIA</option>
                <option value="VISA">VISA</option>
              </select>
              <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="identificacion" class="block text-2xl font-medium text-gray-600">Documento</label>
            <div class="mt-2">
              <input id="identificacion" name="identificacion" type="text" autocomplete="documento ID" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-4">
            <label for="clientenuevoemail" class="block text-2xl font-medium text-gray-600">Email</label>
            <div class="mt-2">
              <input id="clientenuevoemail" name="clientenuevoemail" type="email" autocomplete="email" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="tarifa" class="block text-2xl font-medium text-gray-600">Tarifa</label>
            <div class="mt-2 grid grid-cols-1">
              <select id="clientenuevotarifa" name="tarifa" autocomplete="tarifa-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                <?php foreach($tarifas as $tarifa): ?>
                  <option value="<?php echo $tarifa->id;?>"><?php echo $tarifa->nombre;?></option>
                <?php endforeach; ?>
              </select>
              <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg>
            </div>
          </div>

          <div class="col-span-full">
            <label for="clientenuevodireccion" class="block text-2xl font-medium text-gray-600">Direccion</label>
            <div class="mt-2">
              <input type="text" name="clientenuevodireccion" id="clientenuevodireccion" autocomplete="clientenuevodireccion" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-2 sm:col-start-1">
            <label for="telefono" class="block text-2xl font-medium text-gray-600">Telefono</label>
            <div class="mt-2">
              <input type="text" name="telefono" id="telefono" autocomplete="address-level2" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="departamento" class="block text-2xl font-medium text-gray-600">Departamento</label>
            <div class="mt-2">
              <input type="text" name="departamento" id="departamento" autocomplete="address-level1" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="ciudad" class="block text-2xl font-medium text-gray-600">Ciudad</label>
            <div class="mt-2">
              <input type="text" name="ciudad" id="ciudad" autocomplete="ciudad" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>
        </div>
      </div>

      <div class="text-right">
          <button class="btn-md btn-red salir" type="button" value="salir">Salir</button>
          <input id="btnCrearAddCliente" class="btn-md btn-blue crearAddCliente" type="submit" value="Crear">
      </div>
    </form>
  </dialog>

  <!-- MODAL PARA CREAR NUEVA DIRECCION A CLIENTE-->
  <dialog class="midialog-sm p-5" id="miDialogoAddDir">
    <h4 class=" text-gray-700 font-semibold">Nueva Direccion</h4>
    <form id="formAddDir" class="formulario">

      <div class="border-b border-gray-900/10 pb-10 mb-3">
        
        <p class="mt-2 text-xl text-gray-600">Crear nueva direccion para el cliente seleccionado.</p>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="adddepartamento" class="block text-2xl font-medium text-gray-600">Departamento</label>
            <div class="mt-2">
              <input type="text" name="adddepartamento" id="adddepartamento" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="addciudad" class="block text-2xl font-medium text-gray-600">Ciudad</label>
            <div class="mt-2">
              <input type="text" name="addciudad" id="addciudad" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="col-span-full">
            <label for="adddireccion" class="block text-2xl font-medium text-gray-600">Direccion</label>
            <div class="mt-2">
              <input type="text" name="adddireccion" id="adddireccion" autocomplete="adddireccion" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="tarifa" class="block text-2xl font-medium text-gray-600">Tarifa</label>
            <div class="mt-2 grid grid-cols-1">
              <select id="tarifa" name="tarifa" autocomplete="tarifa-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                <?php foreach($tarifas as $tarifa): ?>
                  <option value="<?php echo $tarifa->id;?>"><?php echo $tarifa->nombre.' - $'.$tarifa->valor;?></option>
                <?php endforeach; ?>
              </select>
              <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg>
            </div>
          </div>

        </div>
      </div>

      <div class="text-right">
          <button class="btn-md btn-red salir" type="button" value="salir">Salir</button>
          <input id="btnCrearAddDir" class="btn-md btn-blue crearAddDir" type="submit" value="Crear">
      </div>
    </form>
  </dialog>

  <!-- MODAL PARA AGREGAR DESCUENTO -->
  <dialog class="midialog-xs p-5" id="miDialogoDescuento">
    <h4 class=" text-gray-700 font-semibold">Aplicar Descuento</h4>
    <form id="formDescuento" class=" border-b border-gray-900/10 pb-6 text-center">
        <p class="mt-2 text-xl text-gray-600">Aplicar descuento al subtotal del pedido.</p>
        <div class="inline-flex  border-[3px] border-indigo-600 rounded-xl select-none">  
            <label class="flex  p-1 cursor-pointer">
              <input type="radio" name="tipodescuento" value="valor" class="peer hidden" checked/>
              <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 p-2 rounded-lg transition duration-150 ease-in-out text-xl"> Valor </span>
            </label>
            <label class="flex  p-1 cursor-pointer">
              <input type="radio" name="tipodescuento" value="porcentaje" class="peer hidden"/>
              <span class="tracking-widest peer-checked:bg-indigo-600 peer-checked:text-white text-gray-700 p-2 rounded-lg transition duration-150 ease-in-out text-xl"> Porcentaje </span>
            </label>
        </div>
        <div class="my-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-start-2 col-span-4">
            <label for="descuento" class="block text-2xl font-medium text-gray-600">Descuento</label>
            <div class="mt-2">
              <input id="inputDescuento" type="number" min="0" name="descuento" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" required>
            </div>
          </div>
        </div>
      <div class="text-right">
          <button class="btn-md btn-indigo salir" type="button" value="salir">Salir</button>
          <input id="btnCrearAddDir" class="btn-md btn-lima crearAddDir" type="submit" value="Aplicar">
      </div>
    </form>
  </dialog>
  
  <!-- MODAL PARA VACIAR EL CARRITO-->
  <dialog class="midialog-xs px-8 pb-8" id="miDialogoVaciar">
      <div>
          <p class="text-2xl font-semibold text-gray-500">Desea vaciar el carrito de venta?</p>
      </div>
      <div class="flex justify-around border-t-gray-300 pt-4">
          <div class="sivaciar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Si</p></div>
          <div class="novaciar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">No</p></div>
      </div>
  </dialog>
  <!-- MODAL PARA GUARDAR EL PEDIDO-->
  <dialog class="midialog-xs px-8 pb-8" id="miDialogoGuardar">
      <div>
          <p class="text-3xl font-semibold text-gray-500">Desea guardar el pedido?</p>
          <p class="text-xl text-gray-500">El pedido de venta No: 34512 se guardara en sistema.</p>
      </div>
      <div id="" class="flex justify-around border-t-gray-300 pt-4">
          <div class="siguardar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Si</p></div>
          <div class="noguardar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">No</p></div>
      </div>
  </dialog>
  <!--///////////////////// Modal procesar el pago boton facturar /////////////////////////-->
  <dialog class="midialog-md p-4" id="miDialogoFacturar">
      <h4 class="text-3xl text-gray-600 font-semibold m-0">Registro de pago</h4>
      <form id="formfacturar" class="formulario" method="POST">
          <input id="idcita" name="id" type="hidden">
          <p class="text-gray-600 text-3xl text-center font-light m-0">Total: $<span id="totalPagar" class="text-gray-700 font-semibold">0</span></p>
          <div class="flex justify-center gap-12 mt-8">
            <div class="formulario__campo w-60">
              <label class="formulario__label" for="caja">Caja</label>
              <select class="formulario__select !border-gray-300" name="caja" id="caja" required>
                  <!--<option value="" disabled selected>-Seleccionar-</option>
                  <option value="1">Caja principal</option>
                  <option value="2">Caja bodega</option>-->
                  <?php foreach($cajas as $index => $value):?>
                    <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="formulario__campo w-60">
              <label class="formulario__label" for="facturador">Facturador</label>
              <select class="formulario__select !border-gray-300" name="facturador" id="facturador" required>
                <?php foreach($consecutivos as $index => $value):?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
              </select>
            </div>

          </div>
          <div class="accordion md:px-12 !mt-4">
            <input type="checkbox" id="first">
            <label class="etiqueta text-gray-500" for="first">Elegir metodo de pago</label>
            <div class="wrapper">
              <div class="wrapper-content">
                <div id="mediospagos" class="content flex flex-col items-end w-96 mx-auto">
                  <?php foreach($mediospago as $index => $value):?>
                    <div class="mb-4">
                      <label class="text-gray-700 text-xl"><?php echo $value->mediopago??'';?>: </label>
                      <input id="<?php echo $value->id??'';?>" class="w-44 py-1 px-3 rounded-lg border border-gray-300 focus:outline-none focus:border-gray-500 text-xl mediopago <?php echo $value->mediopago??'';?>" type="text" value="0" <?php echo $value->mediopago=='Efectivo'?'readonly':'';?> oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div> <!-- fin accordion  -->

          <div class="mx-auto w-40">
            <div class="formulario__campo">
                <label class="formulario__label" for="recibio">Recibido: </label>
                <input class="formulario__input !text-2xl !border-0 !border-b-2 !border-blue-500 !rounded-none" id="recibio" name="" type="text" placeholder="0" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
            </div>
            <div class="">
                <p class="text-center text-gray-500">Cambio: <span id="cambio" class="text-gray-700 font-semibold">$0</span></p>
            </div>
          </div>
          
          <div class="formulario__campo md:px-12">
              <textarea class="formulario__textarea" id="observacion" name="observacion" placeholder="Observacion" rows="4"></textarea>
          </div>

          <div class="self-end">
              <button class="btn-md btn-red" type="button" value="Cancelar">Cancelar</button>
              <input class="btn-md btn-blue" type="submit" value="Pagar">
          </div>
          
      </form>
  </dialog>
  
</div>