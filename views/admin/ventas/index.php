<div class="box ventas !pb-28">
  <div class="flex flex-col tlg:flex-row">
    <div class="basis-2/3 px-4 pb-4 pt-0">
      <div id="divmsjalerta1"></div>
      <!-- RESUMEN CLIENTE PRO CON CRÉDITO -->
      <div class="mb-6">
        <button id="addcliente" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-5 shadow-sm hover:shadow-md hover:border-indigo-500 transition-all flex items-center justify-between">

          <!-- IZQUIERDA -->
          <div class="flex items-center gap-5">
            <div id="iconCliente" class="bg-indigo-100 text-indigo-600 p-3 rounded-xl">
              <span class="material-symbols-outlined text-4xl">person</span>
            </div>

            <div class="text-left">
              <p class="text-base text-gray-500 m-0 mb-3">Cliente</p>
              <p id="resumenCliente" class="m-0 text-xl font-semibold text-gray-800 leading-tight">Seleccionar cliente</p>
            </div>
          </div>
          <!-- BADGE ESTADO -->
          <div class="flex items-center gap-3">
            <span id="badgeEstado" class="text-base font-semibold px-4 py-2 rounded-full bg-gray-100 text-gray-700">SIN CLIENTE</span>
            <span class="material-symbols-outlined text-gray-400 text-3xl">chevron_right</span>
          </div>
        </button>
      </div>

      <div id="hacker-list" class="paginadorventas">
        <div class="formulario__dato justify-center">
            <input id="buscarproducto" class="search bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Buscar nombre de producto/SKU/escanear codigo" name="buscarproducto" value="" required>
            <div class="grid place-items-center  rounded-r-lg border-solid border border-gray-300 !border-l-0 hover:cursor-pointer">
              <span class="material-symbols-outlined pr-1">search</span>
            </div>
        </div>
        
        <div class="mt-4">
          
          <button id="btnCategorias" class="relative btn-md btn-indigo !mb-4 !py-4 px-6 !w-[140px]">Categorias</button>
          <div id="menuCategorias" class="absolute z-10 bg-white flex flex-col items-start mt-1 rounded-lg pt-2 pb-3 px-4 shadow-md hidden">
            <a data-categoria="Todos" class="filtrocategorias p-3 hover:bg-slate-200">Todos</a>
            <?php foreach($categorias as $categoria): if($categoria->visible > 0): ?>
              <a data-categoria="<?= $categoria->nombre ?>" class="filtrocategorias p-3 hover:bg-slate-200">
                <?= $categoria->nombre ?>
              </a>
            <?php endif; endforeach; ?>
          </div>


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

        <p>Categoria: <strong id="categorySelect">Todos</strong></p>

        <div id="productos" class="list grid gap-4 grid-cols-1 sm:grid-cols-2 tlg:grid-cols-1 xlg:grid-cols-2 2xlg:grid-cols-3 mt-4 border-solid border-t-2 border-gray-400 pt-4"> <!-- contenedor de los productos -->
          <?php foreach($productos as $producto): 
            if($producto->visible==1&&$producto->estado==1):?>
            <div data-categoria="<?php echo $producto->categoria;?>" data-code="<?php echo $producto->sku;?>" class="relative producto rounded-lg bg-slate-200 flex gap-4 p-4 pr-4 h-32 md:h-auto" data-id="<?php echo $producto->ID;?>">
                <img 
                    src="/build/img/<?php echo ($producto->foto!=null&&$producto->foto!='null'&&$producto->foto!='undefined')?$producto->foto:'default-product.png';?>" 
                    onerror="this.onerror=null;this.src='/build/img/default-product.png';"
                    class="block object-contain h-24 min-w-24 w-24 rounded-md" 
                    alt="Imagen de <?php echo $producto->nombre; ?>">
                
                <div class="flex flex-col justify-between grow overflow-hidden">
                    <p class="card-producto m-0 text-xl leading-5 text-slate-500"><?php echo $producto->nombre;?></p>
                    
                    <p class="m-0 text-blue-600 font-semibold">$<?php echo number_format($producto->precio_venta, '0', ',', '.'); ?></p>
                </div>
                <button id="precioadicional" title="Precio personalizado" class="text-indigo-600 hover:text-indigo-800"><i class="fa-solid fa-pen-to-square fa-xl"></i></button>
                <!--<div class="popup absolute right-8 top-1/3 -translate-y-14 translate-x-10 opacity-100 transition-all duration-800 ease-out w-10 h-10 rounded-full text-center grid place-items-center bg-teal-400 text-white">2</div>-->
            </div>

            <!--
            <div data-categoria="<?php echo $producto->categoria;?>" data-code="<?php echo $producto->sku;?>" id="producto" class="relative producto rounded-lg bg-slate-200  gap-4 p-4 pr-4 h-32 md:h-auto" data-id="<?php echo $producto->id;?>">
              <div class="flex gap-4  h-32 md:h-auto">  
                <img 
                    src="/build/img/<?php echo $producto->foto;?>" 
                    onerror="this.onerror=null;this.src='/build/img/default-product.png';"
                    class="block object-contain h-24 min-w-24 w-24 rounded-md" 
                    alt="Imagen de <?php echo $producto->nombre; ?>">
                
                <div class="overflow-hidden">
                    <p class="card-producto m-0 text-xl leading-5 text-slate-500"><?php echo $producto->nombre;?></p>
                </div>
              </div>
              <div class="flex justify-between">
                  <p class="m-0 text-blue-600 font-semibold">$<?php echo number_format($producto->precio_venta, '0', ',', '.'); ?></p>
                  <button title="Precio personalizado" class="text-indigo-600 hover:text-indigo-800"><i class="fa-solid fa-pen-to-square fa-xl"></i></button>
              </div>
            </div>
              -->

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
        class="transition-shadow duration-300 hover:shadow-xl shadow-lg shadow-indigo-500/50 bottom-[82px] right-6 text-white text-lg px-4 py-4 text-center w-24 h-24 rounded-full tlg:hidden fixed z-51 bg-gradient-to-br from-indigo-700 to-[#00CFCF] hover:bg-gradient-to-bl hover:from-[#00CFCF] hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-[#99fafa]  font-medium">
        <span class="material-symbols-outlined">leak_add</span>
      </button> 
    </div> <!-- fin primera columna -->


    <div id="contenedorDesktop" class="basis-1/3 hidden tlg:block">
      <div id="contenidocarrito">
        <div class="formulario__campo">
            <label class="formulario__label" for="vendedor">vendedor</label>
            <div class="formulario__dato flex items-center gap-2">
              <span class="material-symbols-outlined">person</span>
              <input id="vendedor" data-idVendedor="<?php echo $user['id'];?>" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Nombre del Vendedor" name="vendedor" value="<?php echo $user['nombre'];?>" readonly>
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="npedido">N. Orden/Pedido</label>
            <div class="formulario__dato flex items-center gap-2">
              <span class="material-symbols-outlined">arrow_right</span>
              <input id="npedido" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" type="number" placeholder="Numero de orden o pedido" name="pedido" value="<?php echo $num_orden;?>" readonly>
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
        <div class="border-solid border-t-2 border-blue-600 pt-4 overflow-x-auto md:overflow-x-visible">
          <table class=" tabla w-full border-collapse" width="100%" id="tablaventa">
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
          
          <button id="btnguardar" class="btn-md btn-turquoise !py-4 !px-6 !w-[140px] flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-2xl">save</span>
            <span class="font-medium text-2xl uppercase">Cotizar</span>
          </button>
          
          <button id="btnfacturar" class="btn-md btn-indigo !mt-4 sm:mt-0 !mb-4 !py-4 px-6 !w-[140px] between992:mt-3 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-2xl">receipt_long</span>
            <span class="font-medium text-2xl uppercase">Facturar</span>
          </button>
          
          <button id="btnaplicarcredito" class=" text-gray-800 rounded-md border border-gray-300 shadow-sm hover:bg-gray-100 focus:ring-2 focus:ring-indigo-400 !py-4 !px-6 !w-[180px] flex items-center justify-center gap-2 mx-auto">
            <span class="material-symbols-outlined text-2xl">payments</span>
            <span class="font-medium text-2xl uppercase">Crédito</span>
          </button>
        </div>

      </div>
    </div> <!-- fin segunda columna -->
  </div>

  <!-- MODAL DEL CARRITO MOVIL-->
  <dialog id="miDialogoCarritoMovil" class="midialog-sm p-5 w-full max-w-sm overflow-x-hidden">
    <div class="flex justify-between items-center">
      <h4 id="modalCarritoMovil" class="font-semibold text-gray-700 mb-4">Lista de productos</h4>
      <button id="btnCerrarCarritoMovil" class="btn-md btn-indigo"><i class="fa-solid fa-xmark"></i></button>
      <!-- Aqui se inyecto el carrito, se mueve del bloque principal a aqui -->
    </div>
  </dialog>

  <!-- MODAL PARA CREAR O AÑADIR CLIENTE -->
  <dialog id="miDialogoAddCliente" class="midialog-sm rounded-2xl border border-gray-200 w-[95%] max-w-3xl p-8 bg-white backdrop:bg-black/40 shadow-2xl transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out">
    <!-- Encabezado -->
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-5">
      <h4 class="text-2xl font-bold text-indigo-700">👤 Cliente</h4>
      <button class="p-2 rounded-lg hover:bg-gray-100 transition salir"><i class="fa-solid fa-xmark text-gray-600 text-2xl"></i></button>
    </div>
    <!-- ================= BUSCAR CLIENTE EXISTENTE ================= -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-5">
      <h5 class="text-lg font-semibold text-gray-700 mb-3">🔎 Buscar cliente existente</h5>
      <select
        id="selectCliente"
        type="text"
        name="selectCliente"
        class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600"
        name="selectCliente" 
        multiple="multiple" 
        required
      >
        <?php foreach($clientes as $cliente): ?>
          <option data-tipoID="<?php echo $cliente->tipodocumento;?>" data-identidad="<?php echo $cliente->identificacion;?>" value="<?php echo $cliente->id;?>"><?php echo $cliente->nombre.' '.$cliente->apellido;?></option> 
        <?php endforeach ?>
      </select>
      
    </div>


    <form id="formAddCliente" class="formulario space-y-6" action="/" method="POST">

      <!-- ================= CREAR NUEVO CLIENTE ================= -->
      <div class="border-t border-gray-200 pt-6">
        <h5 class="text-lg font-semibold text-gray-700 mb-6">➕ Crear nuevo cliente</h5>

        <div class="formulario__campo">
          <label class="formulario__label text-lg font-medium text-gray-700" for="nombreclientenuevo">* Nombre</label>
          <input id="nombreclientenuevo" type="text" name="nombreclientenuevo" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600" required>
        </div>

        <div class="formulario__campo">
          <label class="formulario__label text-lg font-medium text-gray-700" for="clientenuevoapellido">Apellido</label>
          <input id="clientenuevoapellido" type="text" name="clientenuevoapellido" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
        </div>

        <div class="formulario__campo">
          <label class="formulario__label text-lg font-medium text-gray-700" for="identificacion">* Documento</label>
          <input id="identificacion" name="identificacion" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600" required>
        </div>

        <div class="formulario__campo">
          <label class="formulario__label text-lg font-medium text-gray-700" for="telefono">* Teléfono</label>
          <input id="telefono" type="text" name="telefono" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600" required>
        </div>

        <div class="formulario__campo">
          <label class="formulario__label text-lg font-medium text-gray-700" for="direccionEntrega">Dirección</label>
          <select id="direccionEntrega" type="text"
            name="direccionEntrega"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600"
            >
            <option value="1" disabled selected>-Seleccionar-</option>
          </select>
        </div>

      </div>

      <!-- ================= MOSTRAR / OCULTAR MÁS OPCIONES ================= -->
      <div class="border-t border-gray-200 pt-2">
        <div class="accordion">

          <input type="checkbox" id="opcionesCliente">

          <label class="etiqueta flex items-center justify-center gap-2 cursor-pointer text-indigo-600 font-medium hover:text-indigo-800 select-none"for="opcionesCliente">Mostrar / Ocultar más opciones</label>

          <div class="wrapper">
            <div class="wrapper-content">
              <div class="content space-y-6 mt-6">

                <!-- Campos secundarios (los dejo igual que ya los tenías) -->

                <div class="formulario__campo">
                  <label class="formulario__label text-lg font-medium text-gray-700" for="tipodocumento">Tipo documento</label>
                  <select id="tipodocumento" name="tipodocumento" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                    <option value="1">Registro civil</option>
                    <option value="2">Tarjeta de identidad</option>
                    <option value="3" selected>Cedula de ciudadania</option>
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
                  <label class="formulario__label text-lg font-medium text-gray-700" for="clientenuevoemail">Email</label>
                  <input id="clientenuevoemail" name="clientenuevoemail" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

                <div class="formulario__campo">
                  <label class="formulario__label text-lg font-medium text-gray-700" for="departamento">Departamento</label>
                  <input id="departamento" type="text" name="departamento" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

                <div class="formulario__campo">
                  <label class="formulario__label text-lg font-medium text-gray-700" for="ciudad">Ciudad</label>
                  <input id="ciudad" type="text" name="ciudad" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

                <div class="formulario__campo">
                  <label class="formulario__label text-lg font-medium text-gray-700" for="clientenuevodireccion">Nueva direccion</label>
                  <input id="clientenuevodireccion" type="text" name="clientenuevodireccion" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-3 h-12 text-lg focus:outline-none focus:ring-1 focus:border-indigo-600">
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Botones -->
      <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
        <button type="button" class="btn-md btn-turquoise !py-4 !px-6 !w-[135px] salir">Cancelar</button>
        <input id="btnCrearAddCliente" type="submit" value="Guardar" class="btn-md btn-indigo !py-4 !px-6 !w-[135px]">
      </div>

    </form>
  </dialog>

  

  <!-- MODAL PARA AGREGAR DESCUENTO -->
  <dialog id="miDialogoDescuento" class="midialog-xs p-8">
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
            <label for="inputDescuento" class="block text-2xl font-medium text-gray-600">Descuento</label>
            <div class="mt-2">
              <input id="inputDescuento" type="number" min="0" name="descuento" data-descuento="" class="miles bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1" required>
            </div>
            
            <div class="sm:col-start-2 col-span-4 mt-6">
              <label for="inputDescuentoClave" class="block text-2xl font-medium text-gray-600">Ingresar Clave</label>
              <div class="mt-2">
                <input id="inputDescuentoClave" type="password" name="descuentoclave" class="miles bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1">
                <div id="divmsjalertaClaveDcto"></div>
              </div>
              <div class="grid grid-cols-2 gap-3 mt-6">
                <button type="button" class="btn-md btn-turquoise !py-4 !px-6 w-full salir">Salir</button>
                <button id="btnCrearAddDir" type="submit" class="btn-md btn-indigo !py-4 !px-6 w-full crearAddDir">Aplicar</button>
              </div>
            </div>
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
  <?php include __DIR__. "/modalguardarpedido.php"; ?>
  <!--///////////////////// Modal procesar el pago boton facturar /////////////////////////-->
  <?php include __DIR__. "/modalprocesarpago.php"; ?>
  <!--///////////////////// Modal procesar credito boton facturar /////////////////////////-->
  <?php //include __DIR__. "/modalprocesarcredito.php"; ?>
  <!-- MODAL DATOS DEL ADQUIRIENTE -->
  <?php include __DIR__. "/modaladquiriente.php"; ?>
  <!-- MODAL OTROS PRODUCTOS -->
  <?php include __DIR__. "/modalotrosproductos.php"; ?>
  <!-- MODAL PRECIOS ADICIONALES -->
  <?php include __DIR__. "/modalpreciosadicionales.php"; ?>

  <script>
   const mediosPagoDB = <?= json_encode($mediospago) ?>;  //se inyecta el array de medios de pago desde PHP a JavaScript y se utiliza en ventas.ts
  </script>

</div>
