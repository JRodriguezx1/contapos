<div class="pt-3 bg-gray-50 dark:bg-gray-900 sm:pt-20">
  
  <!-- Título -->
  <div class="max-w-4xl mx-auto text-center shadow-md px-6 py-3">
    <h2 class="text-3xl font-extrabold leading-9 sm:text-4xl sm:leading-10 text-indigo-600 dark:text-indigo-300 uppercase">
      Tablero de indicadores
    </h2>
    <p class="mt-3 text-xl leading-7 text-gray-600 dark:text-gray-400 sm:mt-4 mb-0">
      Información de los principales indicadores de inventario del almacén.
    </p>
  </div>

  <!-- Contenido principal -->
  <div class="pb-12 mt-10 bg-gray-50 dark:bg-gray-900 sm:pb-16">
    <div class="max-w-6xl mx-auto">
      <dl class="bg-white dark:bg-gray-800 rounded-lg shadow-lg sm:grid sm:grid-cols-3">
        
        <!-- Valor inventario -->
        <div class="flex flex-col p-6 text-center border-b border-gray-100 dark:border-gray-700 sm:border-0 sm:border-r">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400" id="item-1">
            Valor inventario
          </dt>
          <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-300"
              aria-describedby="item-1" id="starsCount">
            $<?php echo $valorInv;?>
          </dd>
        </div>

        <!-- Stock total -->
        <div class="flex flex-col p-6 text-center border-t border-b border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l sm:border-r">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
            Stock total productos de venta
          </dt>
          <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-300"
              id="downloadsCount">
            <?php echo number_format($cantidadProductos??0, "0", ",", ".");?>
          </dd>
        </div>

        <!-- Cantidad referencias -->
        <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
            <p class="mb-0">Cantidad de referencias</p>
            <span class="text-base text-gray-400 dark:text-gray-500">(productos e insumos)</span>
          </dt>
          <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-300"
              id="sponsorsCount">
            <?php echo number_format($cantidadReferencias??0, "0", ",", ".");?>
          </dd>
        </div>

        <!-- Categorías -->
        <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
            Categorías
          </dt>
          <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-300"
              id="sponsorsCount">
            <?php echo $cantidadCategorias;?>
          </dd>
        </div>

        <!-- Bajo stock -->
        <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
            Productos con bajo stock
          </dt>
          <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-300"
              id="sponsorsCount">
            <?php echo number_format($bajoStock??0, "0", ",", ".");?>
          </dd>
        </div>

        <!-- Agotados -->
        <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
            Productos agotados
          </dt>
          <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-300"
              id="sponsorsCount">
            <?php echo number_format($productosAgotados??0, "0", ",", ".");?>
          </dd>
        </div>

      </dl>
    </div>
  </div>
</div>
