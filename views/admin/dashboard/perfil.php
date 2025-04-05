<div class="perfil">
    <h4 class="text-slate-500 mb-4 !text-2xl"><i class="fa-solid fa-user-large mr-4"></i>Dashboard - mi <?php echo $titulo; ?> </h4>
  
  <div class="overflow-hidden rounded-xl sm:bg-gray-50 sm:px-8 sm:shadow">
      <div class="pt-4"><h1 class="text-gray-600 py-2 text-3xl font-semibold">Configuracion de la cuenta</h1></div>
      <hr class="mt-4 mb-8" />
      <p class="py-2 text-2xl font-semibold">Direccion correo electronico</p>
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <p class="text-gray-600">Tu direccion de correo electronico es <strong><?php echo $usuario->email??'No tiene email'; ?></strong></p>
        <button id="btnCambiarEmail" class="inline-flex text-xl font-semibold text-blue-600 underline decoration-2">Cambiar</button>
      </div>
      <hr class="mt-4 mb-8" />

      <form action="/admin/perfil" method="POST">
        <p class="py-2 text-2xl font-semibold">Informacion personal</p>
        <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">
            
            <div class="">   
                <span class="text-lg text-gray-500">Movil Actual</span>
                <div class="rounded-md border-2 transition focus-within:border-blue-600">
                    <input type="number" id="movil" name="movil" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-lg text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Tu movil" value="<?php echo $usuario->movil??'';?>" required/>
                </div>
            </div>
            <div class="">   
                <span class="text-lg text-gray-500">Ciudad</span>
                <div class="rounded-md border-2 transition focus-within:border-blue-600">
                    <input type="text" id="ciudad" name="ciudad" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-lg text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Ciudad de residencia" value="<?php echo $usuario->ciudad??'';?>" required/>
                </div>
            </div>   
            <div class="sm:min-w-96">
                <span class="text-lg text-gray-500">Direccion</span>
                <div class="rounded-md border-2 transition focus-within:border-blue-600">
                    <input type="text" id="direccion" name="direccion" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-lg text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Direccion de vivienda" value="<?php echo $usuario->direccion??'';?>" required/>
                </div>
            </div>
                
        </div>

        <p class="py-2 text-2xl font-semibold">Password</p>
        <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">
            <div>
                <span class="text-lg text-gray-500">Password Actual</span>
                <div class="rounded-md border-2 transition focus-within:border-blue-600">
                    <input type="password" id="password" name="password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-xl text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="***********" required/>
                </div>
            </div>
            <div>
                <span class="text-lg text-gray-500">Nuevo Password</span>
                <div class="flex items-center">
                    <div class="flex-1 rounded-md border-2 transition focus-within:border-blue-600">
                        <input type="password" id="password" name="password2" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-xl text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="***********" />
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class=" ml-2 h-6 w-6 cursor-pointer text-sm font-semibold text-gray-600 underline decoration-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </div>
            </div>
        </div>
           
        <p class="mt-2">No puede recordar tu password actual. <a class="text-xl font-semibold text-blue-600 underline decoration-2" href="#">Recuperar Cuenta</a></p>
        <input class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-white" type="submit" value="Guardar Cambios">
      </form>
      <hr class="mt-4 mb-8" />
      <div class="mb-10">
        <p class="py-2 text-2xl font-semibold">Eliminar cuenta</p>
        <p class="inline-flex items-center rounded-full bg-rose-100 px-4 py-1 text-rose-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          Proceda con precaución
        </p>
        <p class="mt-2">Borraremos completamente tus datos. No podrás acceder a tu cuenta después de esta acción.</p>
        <button class="ml-auto text-xl font-semibold text-rose-600 underline decoration-2">Continuar con la eliminacion</button>
      </div>
  </div>

  <dialog class="midialog-sm p-5" id="miDialogoUpEmail">
    <h4 id="modalUpEmail" class="font-semibold text-gray-700 mb-4">Actualizar Correo Electronico</h4>
    <div id="divmsjalerta1"></div>
    <form id="formUpEmail" class="formulario" action="/admin" method="POST">
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 border-b border-gray-900/10 pb-10 mb-3">
            <div class="sm:col-span-5">
                <label class="formulario__label" for="Email">Email</label>
                <div class="formulario__dato mt-2">
                    <input type="text" placeholder="Tu email actual" id="Email" name="Email" value="" class="block w-full rounded-md bg-white px-3 py-1.5 text-xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    <label data-num="36" class="count-charts" for="">36</label>
                </div>
            </div>
        </div>
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="salir">Salir</button>
            <input id="btnUpEmail" class="btn-md btn-blue" type="submit" value="Actualizar">
        </div>
    </form>
  </dialog><!--fin crear/editar direccion-->

</div>