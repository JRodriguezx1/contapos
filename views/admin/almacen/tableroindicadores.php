<div class="pt-12 bg-gray-50 dark:bg-gray-900 sm:pt-20">
            
            <div class="max-w-4xl mx-auto text-center">
              <h2 class="text-3xl font-extrabold leading-9 text-gray-900 dark:text-white sm:text-4xl sm:leading-10">
                Tablero de indicadores
              </h2>
              <p class="mt-3 text-xl leading-7 text-gray-600 dark:text-gray-400 sm:mt-4">
                Informacion de los principales indicadores de inventario del almacen.
              </p>
            </div>
            
            <div class="pb-12 mt-10 bg-gray-50 dark:bg-gray-900 sm:pb-16">
               
              <div class="max-w-6xl mx-auto">
                <dl class="bg-white dark:bg-gray-800 rounded-lg shadow-lg sm:grid sm:grid-cols-3">
                  <div class="flex flex-col p-6 text-center border-b border-gray-100 dark:border-gray-700 sm:border-0 sm:border-r">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400" id="item-1">
                      Valor inventario
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      aria-describedby="item-1" id="starsCount">
                      $<?php echo $valorInv;?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-b border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l sm:border-r">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Cantidad de productos
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="downloadsCount">
                      <?php echo number_format($cantidadProductos??0, "0", ",", ".");?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Cantidad de referencias
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      <?php echo number_format($cantidadReferencias??0, "0", ",", ".");?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Categorias
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      0.5
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Productos con bajo stock
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      <?php echo number_format($bajoStock??0, "0", ",", ".");?>
                    </dd>
                  </div>
                  <div class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                      Productos agotados
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold leading-none text-indigo-600 dark:text-indigo-100"
                      id="sponsorsCount">
                      <?php echo number_format($productosAgotados??0, "0", ",", ".");?>
                    </dd>
                  </div>
                </dl>
              </div>
                 
            </div>
          </div>