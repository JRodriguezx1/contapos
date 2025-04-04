<div class="perfil">
    <h4 class="text-slate-500 mb-4 !text-2xl"><i class="fa-solid fa-user-large mr-4"></i>Dashboard - mi <?php echo $titulo; ?> </h4>
    <div class="perfil__contenedor">
        <div class="perfil__col1">
            <div class="perfil__img">
                <i class="fa-solid fa-user-large"></i>
                <p class="perfil__nombre"><?php echo $usuario->nombre??'';?> <?php echo $usuario->apellido??'';?></p>
                <p class="perfil__cuenta"><?php echo $usuario->perfil=="Administrador"?'Cuenta Empleado':'Cuenta Admin';?></p>
            </div>
            <div class="perfil__contact">
                <label for="">Direccion email</label>
                <p class="perfil__email"><?php echo $usuario->email??'';?></p>
                <label for="">Contacto</label>
                <p class="perfil__phone"><?php echo $usuario->movil??'';?></p>
            </div>
        </div>
        <div class="perfil__col2">
        <?php require_once __DIR__ .'/../../templates/alertas.php'; ?>
        <a class="cambiarpassword" href="/admin/perfil/cambiarpassword">Cambiar Password</a>
        <div class="perfil__contenedorform">
            <form class="formulario" action="/admin/perfil" enctype="multipart/form-data" method="POST">
                <fieldset class="formulario__fieldset">
                    <div class="formulario__campo">
                        <label class="formulario__label" for="nombre">Nombre</label>
                        <div class="formulario__dato">
                            <input id="nombre" class="formulario__input" type="text" placeholder="Tu Nombre" id="nombre" name="nombre" value="<?php echo $usuario->nombre??''; ?>" required>
                            <label data-num="42" class="count-charts" for="">42</label>
                        </div>
                    </div>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="apellido">Apellido</label>
                        <div class="formulario__dato">
                            <input class="formulario__input" type="text" placeholder="Tu Apellido" id="apellido" name="apellido" value="<?php echo $usuario->apellido??'';?>" requiered>
                            <label data-num="42" class="count-charts" for="">42</label>
                        </div>
                    </div>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="email">Email</label>
                        <div class="formulario__dato">
                            <input class="formulario__input" type="email" placeholder="Tu Email" id="email" name="email" value="<?php echo $usuario->email??'';?>" requiered>
                            <label data-num="43" class="count-charts" for="">42</label>
                        </div>
                    </div>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="movil">Movil</label>
                        <input id="movil" class="formulario__input" type="number" min="3000000000" max="3777777777" placeholder="Movil de contacto" id="movil" name="movil" value="<?php echo $usuario->movil ?? '';?>" required>
                    </div>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="ciudad">Ciudad</label>
                        <div class="formulario__dato">
                            <input id="ciudad" class="formulario__input" type="text" placeholder="ciudad de residencia" id="ciudad" name="ciudad" value="<?php echo $usuario->ciudad ?? '';?>">
                            <label data-num="40" class="count-charts" for="">40</label>
                        </div>
                    </div>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="direccion">Direccion</label>
                        <div class="formulario__dato">
                            <input id="direccion" class="formulario__input" type="text" placeholder="Direccion del vivenda" id="direccion" name="direccion" value="<?php echo $usuario->direccion ?? '';?>">
                            <label data-num="56" class="count-charts" for="">56</label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="formulario__fieldset">
                    <!--<legend class="formulario-legend">Redes Sociales</legend>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="logo">Logo</label>
                        <input class="formulario__input--file" type="file" id="logo" name="logo">
                    </div>-->
                    <input class="formulario__submit" type="submit" value="Actualizar Perfil">
                </fieldset>
            </form>
        </div>
        </div>
    </div>



  <!--//////////////////////////////////////// -->
  <div class="col-span-8 overflow-hidden rounded-xl sm:bg-gray-50 sm:px-8 sm:shadow">
      <div class="pt-4"><h1 class="py-2 text-2xl font-semibold">Account settings</h1></div>
      <hr class="mt-4 mb-8" />
      <p class="py-2 text-xl font-semibold">Email Address</p>
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <p class="text-gray-600">Your email address is <strong>john.doe@company.com</strong></p>
        <button class="inline-flex text-sm font-semibold text-blue-600 underline decoration-2">Change</button>
      </div>
      <hr class="mt-4 mb-8" />

      <form action="/" method="POST">

        <p class="py-2 text-xl font-semibold">Movil</p>
        <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">
            <div>   
                    <span class="text-sm text-gray-500">Movil Actual</span>
                    <div class=" overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                        <input type="number" id="movil" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Tu movil" />
                    </div>
            </div>   
                
            </div>

        <p class="py-2 text-xl font-semibold">Password</p>
        <div class="flex items-center">
            <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">
                <label for="login-password">
                    <span class="text-sm text-gray-500">Current Password</span>
                    <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                        <input type="password" id="login-password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="***********" />
                    </div>
                </label>
                <label for="login-password">
                    <span class="text-sm text-gray-500">New Password</span>
                    <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                        <input type="password" id="login-password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="***********" />
                    </div>
                </label>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="mt-5 ml-2 h-6 w-6 cursor-pointer text-sm font-semibold text-gray-600 underline decoration-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        </div>
        <p class="mt-2">No puede recordar tu password actual. <a class="text-sm font-semibold text-blue-600 underline decoration-2" href="#">Recuperar Cuenta</a></p>
        <input class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-white" type="submit" value="Guardar Password">
      </form>

      <hr class="mt-4 mb-8" />

      <div class="mb-10">
        <p class="py-2 text-xl font-semibold">Delete Account</p>
        <p class="inline-flex items-center rounded-full bg-rose-100 px-4 py-1 text-rose-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          Proceed with caution
        </p>
        <p class="mt-2">Make sure you have taken backup of your account in case you ever need to get access to your data. We will completely wipe your data. There is no way to access your account after this action.</p>
        <button class="ml-auto text-sm font-semibold text-rose-600 underline decoration-2">Continue with deletion</button>
      </div>
    </div>
</div>