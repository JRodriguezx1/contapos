<div class="box ventas pb-20">
  <div class="flex flex-col tlg:flex-row">
    <div class="basis-2/3 p-4">
      <div id="divmsjalerta1"></div>
      <div class="xs:flex xs:flex-wrap gap-4">
        <div class="formulario__campo flex-1">
          <label class="formulario__label" for="selectCliente">Cliente</label>
          <div class="formulario__dato">
            <select id="selectCliente" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="selectCliente" required>
                <option value="1" disabled selected>-Seleccionar-</option>
                <?php foreach($clientes as $cliente): ?>
                  <option data-tipoID="<?php echo $cliente->tipodocumento;?>" data-identidad="<?php echo $cliente->identificacion;?>" value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre.' '.$cliente->apellido;?></option> 
                <?php endforeach ?>
            </select>
            <div class="grid place-items-center  rounded-r-lg   hover:cursor-pointer">
              <span id="addcliente" class="material-symbols-outlined text-blue-500 hover:text-blue-800">add_circle</span>
            </div>
          </div> <!-- fin formulario dato-->
          <div class="formulario__campo flex-1 xs:flex-none">
            <label class="formulario__label" for="documento">N. Documento</label>
            <input id="documento" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Documento del cliente" name="documento" readonly>
          </div>
        </div>
        <div class="formulario__campo flex-1">
            <label class="formulario__label" for="direccionEntrega">Direccion</label>
            <div class="formulario__dato">
              <select id="direccionEntrega" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="direccionEntrega" required>
                  <option value="1" disabled selected>-Seleccionar-</option>
              </select>
              <div class="grid place-items-center hover:cursor-pointer">
                <span id="adddir" class="material-symbols-outlined text-blue-500 hover:text-blue-800">add_circle</span>
              </div>
            </div> <!-- fin formulario dato-->
        </div>
        <div class="formulario__campo flex-1">
            <label class="formulario__label" for="ciudad">Ciudad</label>
            <input id="ciudadEntrega" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Ciudad de entrega" name="ciudadEntrega" value="" readonly>
        </div>
      </div>

      <div id="hacker-list" class="paginadorventas">
        <div class="formulario__dato justify-center">
            <input id="buscarproducto" class="search bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Buscar nombre de producto/SKU/escanear codigo" name="buscarproducto" value="" required>
            <div class="grid place-items-center  rounded-r-lg border-solid border border-gray-300 !border-l-0 hover:cursor-pointer">
              <span class="material-symbols-outlined pr-1">search</span>
            </div>
        </div>
        
        <div class="mt-4">
          <button class="group relative btn-md btn-indigo !mb-4 !py-4 px-6 !w-[140px]">Categorias
            <div class="absolute bg-white flex flex-col items-start top-full left-0 rounded-lg pt-2 pb-3 px-4 shadow-md scale-y-0 group-hover:scale-y-100 origin-top duration-200">
              <a data-categoria="Todos" class=" filtrocategorias text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#2">Todos</a>
              <?php foreach($categorias as $categoria): 
                if($categoria->visible > 0):?>
                <a data-categoria="<?php echo $categoria->nombre;?>" class=" filtrocategorias text-gray-500 whitespace-nowrap hover:bg-slate-200 p-3" href="#2"><?php echo $categoria->nombre;?></a>
              <?php endif; endforeach; ?>
            </div>
          </button>

          <!-- Botón Otros -->
          <button id="btnotros" class="btn-md btn-turquoise !mb-4 !py-4 px-6 !w-[140px] flex items-center justify-center gap-2">
            <i class="fas fa-th-large"></i>
            Otros
          </button>

          <!-- Botón Adquiriente -->
          <button id="facturarA" class="bg-white text-gray-800 font-semibold text-2xl rounded-md border border-gray-300 shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400 !mb-4 !py-4 px-6 !w-[140px]">
            <i class="fas fa-user"></i>
            Adquiriente
          </button>
        </div>


        <div id="productos" class="list grid gap-4 grid-cols-2 lg:grid-cols-3 mt-4 border-solid border-t-2 border-gray-400 pt-4"> <!-- contenedor de los productos -->
            <?php foreach($productos as $producto): 
              if($producto->visible==1&&$producto->estado==1):?>
            <div data-categoria="<?php echo $producto->categoria;?>" data-code="<?php echo $producto->sku;?>" id="producto" class="producto rounded-lg bg-slate-200 flex gap-4 p-4 pr-4" data-id="<?php echo $producto->id;?>">
                <img 
                    src="/build/img/<?php echo $producto->foto;?>" 
                    onerror="this.onerror=null;this.src='/build/img/default-product.png';"
                    class="inline h-24 min-w-24 w-24 object-contain rounded-md" 
                    alt="Imagen de <?php echo $producto->nombre; ?>">
                
                <div class="flex flex-col justify-between grow overflow-hidden">
                    <p class="card-producto m-0 text-xl leading-5 text-slate-500"><?php echo $producto->nombre;?></p>
                    <p class="m-0 text-blue-600 font-semibold">$<?php echo number_format($producto->precio_venta, '0', ',', '.'); ?></p>
                </div> 
            </div>
            <?php endif; endforeach; ?>
        </div> <!-- fin contenedor de productos -->
        <div id="hacker-list" class="paginadorventas">
          <ul class="list">
            <!-- items aquí -->
          </ul>

          <!-- List.js inyectará aquí la paginación -->
          <ul class="pagination mt-4 justify-center"></ul>
        </div>
      </div>

      <!-- Botón del carrito de ventas solo en móvil -->
      </style>
      <button id="btnCarritoMovil" 
        class="transition-shadow duration-300 hover:shadow-xl shadow-lg shadow-indigo-500/50 bottom-[82px] right-6 text-white text-lg px-4 py-4 text-center w-24 h-24 rounded-full tlg:hidden fixed z-51 bg-gradient-to-br from-indigo-700 to-[#00CFCF] hover:bg-gradient-to-bl hover:from-[#00CFCF] hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-[#99fafa] dark:focus:ring-[#0a8a8a] font-medium">
        <span class="material-symbols-outlined">leak_add</span>
      </button> 
    </div> <!-- fin primera columna -->


    <div id="contenedorDesktop" class="basis-1/3 hidden tlg:block">
      <div id="contenidocarrito">
        <div class="formulario__campo">
            <label class="formulario__label" for="vendedor">vendedor</label>
            <div class="formulario__dato flex items-center gap-2">
              <span class="material-symbols-outlined">person</span>
              <input id="vendedor" data-idVendedor="<?php echo $user['id'];?>" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del Vendedor" name="vendedor" value="<?php echo $user['nombre'];?>" readonly>
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="npedido">N. Orden/Pedido</label>
            <div class="formulario__dato flex items-center gap-2">
              <span class="material-symbols-outlined">arrow_right</span>
              <input id="npedido" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Numero de orden o pedido" name="pedido" value="1" readonly>
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
        <!--
        <div class="text-center p-4 flex justify-center gap-x-8">
          <button id="btnvaciar" class="btn-md !flex !flex-row btn-red !mt-4 sm:mt-0 !mb-4 !py-4 px-6 !w-[140px] items-center justify-center gap-1 between992:mt-3">
            <span class="material-symbols-outlined text-2xl">delete</span>
            <span class="font-medium text-2xl">Vaciar</span>
          </button>

          <button id="btnguardar" class="btn-md !flex !flex-row btn-turquoise !mt-4 sm:mt-0 !mb-4 !py-4 px-6 !w-[140px] items-center justify-center gap-1 between992:mt-3">
            <span class="material-symbols-outlined text-2xl">save</span>
            <span class="font-medium text-2xl">Guardar</span>
          </button>

          <button id="btnfacturar" class="btn-md !flex !flex-row btn-indigo !mt-4 sm:mt-0 !mb-4 !py-4 px-6 !w-[140px] items-center justify-center gap-1 between992:mt-3">
            <span class="material-symbols-outlined text-2xl">receipt_long</span>
            <span class="font-medium text-2xl">Facturar</span>
          </button>
        </div>-->

        
        <div class="text-center p-4">
          <button id="btnvaciar" class="btn-md btn-red !py-4 !px-6 !w-[140px]">
            <span class="material-symbols-outlined text-2xl">delete</span>
            <span class="font-medium text-2xl">Vaciar</span>
          </button>

          <button id="btnguardar" class="btn-md btn-turquoise !py-4 !px-6 !w-[140px]">
            <span class="material-symbols-outlined text-2xl">save</span>
            <span class="font-medium text-2xl">Guardar</span>
          </button>

          <button id="btnfacturar" class="btn-md btn-indigo !mt-4 sm:mt-0 !mb-4 !py-4 px-6 !w-[140px] between992:mt-3">
            <span class="material-symbols-outlined text-2xl">receipt_long</span>
            <span class="font-medium text-2xl">Facturar</span>
          </button>
        </div>
      

      </div>
    </div> <!-- fin segunda columna -->
  </div>

  <!-- MODAL DEL CARRITO MOVIL-->
  <dialog id="miDialogoCarritoMovil" class="midialog-sm p-5">
    <div class="flex justify-between items-center">
        <h4 id="modalCarritoMovil" class="font-semibold text-gray-700 mb-4">Lista de productos</h4>
        <button id="btnCerrarCarritoMovil" class="btn-md btn-indigo"><i class="fa-solid fa-xmark"></i></button>
      <!-- Aqui se inyecto el carrito, se mueve del bloque principal a aqui -->
    </div>
    
  </dialog>

  <!-- MODAL PARA CREAR O AÑADIR CLIENTE-->
  <dialog id="miDialogoAddCliente" class="midialog-sm p-5">
      <h4 class=" text-gray-700 font-semibold">Crear Cliente</h4>
      <form id="formAddCliente" class="formulario" action="/" enctype="multipart/form-data" method="POST">

      <div class="border-b border-gray-900/10 pb-10 mb-3">
        
        <p class="mt-2 text-xl text-gray-600">Información Personal.</p>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="nombreclientenuevo" class="block text-2xl font-medium text-gray-600">Nombre</label>
            <div class="mt-2">
              <input type="text" name="nombreclientenuevo" id="nombreclientenuevo" autocomplete="given-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div> 
          </div>

          <div class="sm:col-span-3">
            <label for="clientenuevoapellido" class="block text-2xl font-medium text-gray-600">Apellido</label>
            <div class="mt-2">
              <input type="text" name="clientenuevoapellido" id="clientenuevoapellido" autocomplete="family-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="tipodocumento" class="block text-2xl font-medium text-gray-600">Tipo de documento</label>
            <div class="mt-2 grid grid-cols-1">
              <select id="tipodocumento" name="tipodocumento" autocomplete="tipodocumento-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                <option value="CC">CC</option>
                <option value="NIT">NIT</option>
                <option value="PASAPORTE">PASAPORTE</option>
                <option value="PERMISO TEMPORAL">PERMISO TEMPORAL</option>
                <option value="PERMISO ESPECIAL DE PERMANENCIA">PERMISO ESPECIAL DE PERMANENCIA</option>
                <option value="TARJETA DE INDENTIDAD">TARJETA DE INDENTIDAD</option>
                <option value="CEDULA DE EXTRANJERIA">CEDULA DE EXTRANJERIA</option>
                <option value="VISA">VISA</option>
              </select>
              <!-- <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg> -->
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="identificacion" class="block text-2xl font-medium text-gray-600">Documento</label>
            <div class="mt-2">
              <input id="identificacion" name="identificacion" type="text" autocomplete="documento ID" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-4">
            <label for="clientenuevoemail" class="block text-2xl font-medium text-gray-600">Email</label>
            <div class="mt-2">
              <input id="clientenuevoemail" name="clientenuevoemail" type="email" autocomplete="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="tarifa" class="block text-2xl font-medium text-gray-600">Tarifa</label>
            <div class="mt-2 grid grid-cols-1">
              <select id="clientenuevotarifa" name="tarifa" autocomplete="tarifa-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                <?php foreach($tarifas as $tarifa): ?>
                  <option value="<?php echo $tarifa->id;?>"><?php echo $tarifa->nombre;?></option>
                <?php endforeach; ?>
              </select>
              <!-- <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg> -->
            </div>
          </div>

          <div class="col-span-full">
            <label for="clientenuevodireccion" class="block text-2xl font-medium text-gray-600">Dirección</label>
            <div class="mt-2">
              <input type="text" name="clientenuevodireccion" id="clientenuevodireccion" autocomplete="clientenuevodireccion" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-2 sm:col-start-1">
            <label for="telefono" class="block text-2xl font-medium text-gray-600">Teléfono</label>
            <div class="mt-2">
              <input type="text" name="telefono" id="telefono" autocomplete="address-level2" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="departamento" class="block text-2xl font-medium text-gray-600">Departamento</label>
            <div class="mt-2">
              <input type="text" name="departamento" id="departamento" autocomplete="address-level1" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="ciudad" class="block text-2xl font-medium text-gray-600">Ciudad</label>
            <div class="mt-2">
              <input type="text" name="ciudad" id="ciudad" autocomplete="ciudad" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>
        </div>
      </div>

      <div class="text-right space-x-4 mt-6">
        <button class="btn-md btn-turquoise !py-4 !px-6 !w-[180px] rounded-lg salir" type="button" value="salir">Salir</button>
        <input id="btnCrearAddCliente" class="btn-md btn-indigo !py-4 !px-6 !w-[180px] rounded-lg" type="submit" value="Crear">
      </div>
    </form>
  </dialog>

  <!-- MODAL PARA CREAR NUEVA DIRECCION A CLIENTE-->
  <dialog id="miDialogoAddDir" class="midialog-sm p-5">
    <h4 class=" text-gray-700 font-semibold">Nueva Dirección</h4>
    <form id="formAddDir" class="formulario">

      <div class="border-b border-gray-900/10 pb-10 mb-3">
        
        <p class="mt-2 text-xl text-gray-600">Crear nueva dirección para el cliente seleccionado.</p>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="adddepartamento" class="block text-2xl font-medium text-gray-600">Departamento</label>
            <div class="mt-2">
              <input type="text" name="adddepartamento" id="adddepartamento" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="addciudad" class="block text-2xl font-medium text-gray-600">Ciudad</label>
            <div class="mt-2">
              <input type="text" name="addciudad" id="addciudad" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="col-span-full">
            <label for="adddireccion" class="block text-2xl font-medium text-gray-600">Dirección</label>
            <div class="mt-2">
              <input type="text" name="adddireccion" id="adddireccion" autocomplete="adddireccion" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="tarifa" class="block text-2xl font-medium text-gray-600">Tarifa</label>
            <div class="mt-2 grid grid-cols-1">
              <select id="tarifa" name="tarifa" autocomplete="tarifa-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
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
          <button class="btn-md btn-turquoise !py-4 !px-6 !w-[180px] salir" type="button" value="salir">Salir</button>
          <input id="btnCrearAddDir" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[180px]" type="submit" value="Crear">
      </div>
    </form>
  </dialog>

  <!-- MODAL PARA AGREGAR DESCUENTO -->
  <dialog id="miDialogoDescuento" class="midialog-xs p-5">
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
              <input id="inputDescuento" type="number" min="0" name="descuento" class="miles bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
          </div>
        </div>
      <div class="text-right">
          <button class="btn-md btn-turquoise !py-4 !px-6 !w-[125px] salir" type="button" value="salir">Salir</button>
          <input id="btnCrearAddDir" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[125px] crearAddDir" type="submit" value="Aplicar">
      </div>
    </form>
  </dialog>
  
  <!-- MODAL PARA VACIAR EL CARRITO-->
  <dialog id="miDialogoVaciar" class="bg-white rounded-xl shadow-lg p-8 max-w-lg w-full relative z-50">
    <div class="text-center">
      <p class="text-2xl font-semibold text-gray-600 mb-6">¿Desea vaciar el carrito de venta?</p>
      <div class="flex justify-around w-full border-t border-gray-300 pt-6">
        <div class="sivaciar flex items-center cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold">
          <i class="fa-regular fa-pen-to-square"></i>
          <p class="ml-2">Sí</p>
        </div>
        <div class="novaciar flex items-center cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold">
          <i class="fa-regular fa-trash-can"></i>
          <p class="ml-2">No</p>
        </div>
      </div>
    </div>
  </dialog>


  <!-- MODAL PARA GUARDAR EL PEDIDO-->
  <dialog id="miDialogoGuardar" class="bg-white rounded-xl shadow-lg p-8 relative z-50">
      <div class="text-center">
          <p class="text-2xl font-semibold text-gray-600 mb-6">Desea guardar el pedido?</p>
          <p class="text-xl text-gray-500">El pedido de venta No: 34512 se guardara en sistema.</p>
      </div>
      <div id="" class="flex justify-around w-full border-t border-gray-300 pt-6">
          <div class="siguardar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Si</p></div>
          <div class="noguardar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">No</p></div>
      </div>
  </dialog>
  <!--///////////////////// Modal procesar el pago boton facturar /////////////////////////-->
  <dialog id="miDialogoFacturar" class="midialog-md !p-12">
      <h4 class="text-3xl font-semibold m-0 text-neutral-800">Registro de pago</h4>
      <hr class="my-4 border-t border-neutral-300">
      <form id="formfacturar" class="formulario" method="POST">
          <div id="divmsjalerta2"></div>
          <p class="text-gray-600 text-3xl text-center font-light m-0">Total a pagar $: </br><span id="totalPagar" class="text-gray-700 font-semibold">$0</span></p>
          <div class="flex justify-center gap-12 mt-8">
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="caja">Caja</label>
              <select id="caja" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="caja" required>
                  <?php foreach($cajas as $index => $value):?>
                    <option value="<?php echo $value->id;?>" data-idfacturador="<?php echo $value->idtipoconsecutivo;?>"><?php echo $value->nombre;?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="formulario__campo w-1/2">
              <label class="formulario__label" for="facturador">Facturador</label>
              <select id="facturador" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="facturador" required>
                <?php foreach($consecutivos as $index => $value):?>
                  <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="accordion md:px-12 !mt-4">
            <input type="checkbox" id="first">
            <label class="etiqueta text-indigo-700" for="first">Elegir método de pago</label>
            <div class="wrapper">
              <div class="wrapper-content">
                <div id="mediospagos" class="content flex flex-col items-center w-1/2 mx-auto text-center">
                  <?php foreach($mediospago as $index => $value):?>
                    <div class="mb-4 text-center">
                      <label class="text-gray-700 text-xl text-center leading-relaxed"><?php echo $value->mediopago??'';?>: </label>
                      <input id="<?php echo $value->id??'';?>" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1 text-center mediopago <?php echo $value->mediopago??'';?>" type="text" value="0" <?php echo $value->mediopago=='Efectivo'?'readonly':'';?> oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div> <!-- fin accordion  -->

          <div class="mx-auto">
            <div class="formulario__campo w-80 mx-auto">
                <label class="formulario__label leading-relaxed text-center" for="recibio">Efectivo Recibido</label>
                <input id="recibio" class="formulario__input !text-2xl !border-0 !border-b-2 !border-indigo-500 !rounded-none text-center" name="" type="text" placeholder="0" oninput="this.value = parseInt(this.value.replace(/[^\d.,]/g, '').replace(/[,.]/g, '')||0).toLocaleString()">
            </div>
            <div class="flex flex-col items-center">
                <p id="cambio" class="text-center formulario__label">Devolver: <span class="text-gray-700 font-semibold text-2xl">$0</span></p>
            </div>
          </div>
          
         <!-- Opción imprimir factura -->
        <div class="formulario__campo md:px-12 mb-6">
          <label class="formulario__label block text-center mb-2">¿Desea imprimir factura?</label>
          <div class="flex justify-center gap-8">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="si" class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
              <span class="text-gray-700 text-lg">Sí</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="imprimir" value="no" class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500">
              <span class="text-gray-700 text-lg">No</span>
            </label>
          </div>
        </div>
        <!-- Fin opción imprimir factura -->


          <div class="formulario__campo md:px-12">
              <textarea id="observacion" class="formulario__textarea" name="observacion" placeholder="Observacion" rows="4"></textarea>
          </div>

          <div class="self-end">
              <button class="btn-md btn-turquoise !py-4 !px-6 !w-[180px]" type="button" value="Cancelar">Cancelar</button>
              <input class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[180px]" type="submit" value="Pagar">
          </div>
          
      </form>
  </dialog>

  <!-- MODAL DATOS DEL ADQUIRIENTE -->
<dialog id="miDialogoFacturarA" class="midialog-sm !p-12">

    <div class="flex items-start gap-3 mb-4">
      <div class="text-indigo-600 mt-1">
        <i class="fas fa-user-circle text-[4rem] leading-[2.5rem]"></i> <!-- Ícono más grande -->
      </div>
      <div>
        <h2 class="text-3xl font-semibold text-gray-900">Datos Factura Electrónica</h2>
        <p class="text-lg text-gray-600">Ingresar datos del adquiriente</p>
      </div>
    </div>

    <!-- <h4 class="text-gray-700 font-semibold">Facturar A:</h4> -->
    <form id="formFacturarA" class="formulario">
      <div class="border-b border-gray-900/10 pb-10 mb-3">
        <!-- <p class="mt-2 text-xl text-gray-600">Información del adquiriente.</p> -->

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8">
          <!-- Tipo de Documento -->
          <div>
            <label for="dato1" class="block text-2xl font-medium text-gray-600">Tipo Documento</label>
            <div class="mt-2">
              <select id="dato1" name="dato1" required
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1">
                <option value="">Seleccione tipo de documento</option>
                <option value="11">Registro civil</option>
                <option value="12">Tarjeta de identidad</option>
                <option value="13">Cédula de ciudadanía</option>
                <option value="21">Tarjeta de extranjería</option>
                <option value="22">Cédula de extranjería</option>
                <option value="31">NIT</option>
                <option value="41">Pasaporte</option>
                <option value="42">Documento de identificación extranjero</option>
                <option value="50">NUIP</option>
                <option value="91">Sin identificación del exterior</option>
              </select>
            </div>
          </div>

          <!-- Número de Documento + Botón Buscar -->
          <!-- Número de Documento + Botón Buscar -->
          <div>
            <label for="documento" class="block text-2xl font-medium text-gray-600">Número de Documento</label>
            <div class="mt-2 flex flex-wrap gap-2 items-center">
              <input id="documento" type="text" name="documento" required
                class="flex-1 min-w-[200px] bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                placeholder="Número sin dígito de verificación">

              <button id="btnBuscarAdquiriente" type="button"
                class="flex items-center gap-2 text-indigo-600 border border-indigo-600 hover:bg-indigo-50 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg px-4 py-2.5 h-14 text-xl dark:text-indigo-400 dark:border-indigo-400 dark:hover:bg-indigo-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
                Buscar
              </button>
            </div>
          </div>

          <!-- Nombre o Razón Social -->
          <div>
            <label for="dato2" class="block text-2xl font-medium text-gray-600">Nombre o Razón Social</label>
            <div class="mt-2">
              <input id="dato2" type="text" name="dato2" required
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                placeholder="Nombre del cliente o empresa">
            </div>
          </div>

          <!-- Correo Electrónico -->
          <div>
            <label for="correo" class="block text-2xl font-medium text-gray-600">Correo Electrónico</label>
            <div class="mt-2">
              <input id="correo" type="email" name="correo"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                placeholder="correo@ejemplo.com">
            </div>
          </div>
        </div>
      </div>

      <!-- Botones -->
      <div class="text-right">
        <button class="btn-md btn-turquoise !py-4 !px-6 !w-[145px]" type="button" value="Cancelar">Cancelar</button>
        <input class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[145px]" type="submit" value="Confirmar">
      </div>

      <!-- Botón para mostrar/ocultar -->
      <div class="accordion md:px-12 !mt-4">
        <!-- ID ÚNICO -->
        <input id="toggleOpcionesAdq" type="checkbox" class="peer sr-only">

      <label for="toggleOpcionesAdq"
            class="flex items-center justify-center gap-2 cursor-pointer text-gray-500 hover:text-indigo-600 select-none">
        <span>Mostrar/Ocultar más opciones</span>
        <span class="text-xl peer-checked:hidden">+</span>
        <span class="text-xl hidden peer-checked:inline">–</span>
      </label>

      <!-- Contenido oculto -->
      <div class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out peer-checked:max-h-[120rem]">
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8">
          
          <!-- Dirección -->
          <div>
            <label for="direccion" class="block text-2xl font-medium text-gray-600">Dirección</label>
            <input id="direccion" type="text" name="direccion"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1"
              placeholder="Dirección del adquiriente">
          </div>

          <!-- Ciudad o Municipio -->
          <div>
            <label for="ciudad" class="block text-2xl font-medium text-gray-600">Ciudad / Municipio</label>
            <input id="ciudad" type="text" name="ciudad"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1"
              placeholder="Ciudad o municipio">
          </div>

          <!-- Tipo Régimen -->
          <div>
            <label for="tipo_regimen" class="block text-2xl font-medium text-gray-600">Tipo Régimen</label>
            <select id="tipo_regimen" name="tipo_regimen"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
              <option value="">Seleccione tipo de régimen</option>
              <option value="responsable_iva">Responsable de IVA</option>
              <option value="no_responsable_iva">No responsable de IVA</option>
            </select>
          </div>

          <!-- Tipo de Organización -->
          <div>
            <label for="tipo_organizacion" class="block text-2xl font-medium text-gray-600">Tipo de Organización</label>
            <select id="tipo_organizacion" name="tipo_organizacion"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
              <option value="">Seleccione tipo de organización</option>
              <option value="persona_natural">Persona natural</option>
              <option value="persona_juridica">Persona jurídica</option>
            </select>
          </div>

          <!-- Teléfono -->
          <div>
            <label for="telefono" class="block text-2xl font-medium text-gray-600">Teléfono</label>
            <input id="telefono" type="tel" name="telefono"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1"
              placeholder="Teléfono de contacto">
          </div>
        </div>
      </div>
    </div>
  </form>
</dialog> 

<!-- MODAL OTROS PRODUCTOS -->
  <dialog id="miDialogoOtrosProductos" class="midialog-sm p-5">
    <h4 class=" text-gray-700 font-semibold">Otros:</h4>
    <form id="formOtrosProductos" class="formulario">  
      <div class="border-b border-gray-900/10 pb-10 mb-3">
        
        <p class="mt-2 text-xl text-gray-600">Agregar producto/servicio personalizado.</p>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

          <div class="sm:col-span-6">
            <label for="nombreotros" class="block text-2xl font-medium text-gray-600">Nombre</label>
            <div class="mt-2">
              <input id="nombreotros" type="text" name="nombreotros" autocomplete="given-name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" placeholder="Nombre del producto/servicio" required>
            </div> 
          </div>


          <div class="sm:col-span-6">
            <div class="flex gap-4">
              <div class="w-1/2">
                <label for="cantidadotros" class="block text-2xl font-medium text-gray-600">Cantidad</label>
                <input id="cantidadotros" type="number" name="cantidadotros" min="1" step="0.01"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                  placeholder="Cantidad" required>
              </div>

              <div class="w-1/2">
                <label for="preciootros" class="block text-2xl font-medium text-gray-600">Precio total</label>
                <input id="preciootros" type="number" name="preciootros" min="0"
                  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1"
                  placeholder="Valor" required>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="text-right">
          <button class="btn-md btn-turquoise !py-4 !px-6 !w-[145px]" type="button" value="Cancelar">Cancelar</button>
          <input class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[145px]" type="submit" value="Agregar">
      </div>
    </form>
  </dialog>
  
</div>