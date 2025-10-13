<!--
<div class="lineaencabezado" style="background-color: <?php //echo $negocio[0]->colorprincipal??'';?>;">
    <h1><?php //echo $negocio[0]->nombre??'';?></h1>
</div>

<section class="slider">
    <ul class="slider__contenido">
        <li class="slider__slide1 slider__slide"></li>
        <li class="slider__slide2 slider__slide"></li>
    </ul>
</section>

<main class="auth bloqueauth">
    <-- <a class="auth__btnatras bloqueauth__btnregresar" href="/">Regresar</a> --><!-- 
    <a class="bloqueauth__logocliente" href="/">
        <img loading="lazy" src="/build/img/<?php //echo $negocio[0]->logo??'';?>" alt="Logo Cliente">
    </a>
    
    <h2 class="auth__heading bloqueauth__iniciarsesion" style="color: <?php //echo $negocio[0]->colorprincipal??'';?>;"><?php echo $titulo; ?></h2>
    <?php //include __DIR__. "/../templates/alertas.php"; ?>
    <p class="auth__texto bloqueauth__subtitulo">Inicia sesión y reserva tu cita</p>
    <form class="formulario bloqueformulario" method="POST" action="/login">
        <div class="formulario__campo bloqueformulario__campo">
            <!-<label class="formulario__label bloqueformulario__label" for="">Correo Electrónico</label>
            <input class="formulario__input bloqueformulario__input" type="email" placeholder="Ingresa tu correo electrónico" id="email" name="email">
            --><!-- 
            <label class="formulario__label" for="movil">Número de Teléfono</label>
            <input class="formulario__input" type="number" placeholder="Ingresa tu número de telefónico" id="movil" name="movil">
        </div>
        <div class="formulario__campo ">
            <label class="formulario__label" for="">Contraseña</label>
            <input class="formulario__input" type="password" placeholder="Ingresa tu contraseña" id="password" name="password">
        </div>
        <input class="formulario__submit--login bloqueformulario__submit--login" type="submit" value="Iniciar Sesión" style="background-color: <?php echo $negocio[0]->colorprincipal??'';?>;">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? <br> Obtener una</a>
        <--<a href="/olvide" class="acciones__enlace">Olvidaste tu password</a>-->
        <!-- <a href="/" class="acciones__enlace">Home</a>
    </div>
</main>-->

<div class="h-screen w-screen flex justify-center items-center bg-gray-100 dark:bg-gray-900 transition-colors duration-300">

  <div class="grid gap-8">
    <?php include __DIR__. "/../templates/alertas.php"; ?>

    <div id="back-div" class="md:w-[421px] bg-gradient-to-r from-blue-500 to-purple-500 rounded-[30px] rounded-tl-[34px] m-4 shadow-lg">
      <img src="/build/img/Logoj2blanco.png" class="w-80 mx-auto mt-6" alt="logoj2">

      <div class="border-[20px] border-transparent rounded-[24px] bg-white dark:bg-gray-800 shadow-lg xl:p-10 2xl:p-10 lg:p-10 md:p-10 sm:p-4 m-2 transition-colors duration-300">
        <h1 class="pt-8 pb-6 font-bold text-5xl text-center cursor-default text-gray-800 dark:text-gray-200">
          Iniciar Sesión
        </h1>

        <form action="/login" method="post" class="space-y-4">
          <div>
            <label for="nickname" class="mb-2 block text-xl text-gray-700 dark:text-gray-300">Usuario</label>
            <input
              id="nickname"
              name="nickname"
              type="text"
              required
              placeholder="Ingresa tu usuario"
              class="w-full h-16 p-2.5 text-xl text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md
                     placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-600 
                     dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 dark:placeholder-gray-400
                     ease-in-out duration-300 focus:scale-105"
            />
          </div>

          <div>
            <label for="sucursal" class="block text-xl font-medium mb-1 text-gray-700 dark:text-gray-300">Sede</label>
            <span class="block mb-1 text-base text-gray-500 dark:text-gray-400">Seleccione una sede</span>
            <select 
              id="sucursal"
              name="idsucursal"
              class="w-full h-16 p-2.5 text-xl text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md
                     focus:outline-none focus:ring-1 focus:border-indigo-600
                     dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 dark:placeholder-gray-400"
            >
              <?php foreach($sucursales as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label for="password" class="mb-2 block text-xl text-gray-700 dark:text-gray-300">Contraseña</label>
            <input
              id="password"
              name="password"
              type="password"
              required
              placeholder="Ingresa tu contraseña"
              class="w-full h-16 p-2.5 text-xl text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md
                     placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-600 
                     dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 dark:placeholder-gray-400
                     ease-in-out duration-300 focus:scale-105"
            />
          </div>

          <a href="#" class="group text-blue-400 hover:text-blue-300 text-base transition-all duration-200">
            ¿Olvidaste tu contraseña?
          </a>

          <button
            type="submit"
            class="bg-gradient-to-r from-blue-500 to-purple-500 text-white dark:text-gray-200 shadow-lg mt-6 p-2 text-xl rounded-lg w-full
                   hover:scale-105 hover:from-purple-500 hover:to-blue-500 transition duration-300 ease-in-out h-16"
          >
            INICIAR SESIÓN
          </button>
        </form>

        <div class="flex flex-col mt-4 items-center justify-center text-lg">
          <h3 class="text-gray-700 dark:text-gray-300">
            ¿No tienes una cuenta?
            <a href="#" class="group text-blue-400 hover:text-blue-300 transition-all duration-200">
              <span class="bg-left-bottom bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat 
                           group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">
                Regístrate
              </span>
            </a>
          </h3>
        </div>

        <div class="text-gray-500 dark:text-gray-400 flex text-center flex-col mt-4 items-center text-lg leading-snug">
          <p class="cursor-default">
            Al iniciar sesión, acepta
            <a href="#" class="group text-blue-400 hover:text-blue-300 transition-all duration-200">
              <span class="cursor-pointer bg-left-bottom bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat 
                           group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">
                 nuestros
              </span>
            </a>
            Términos y <br />Política
            <a href="#" class="group text-blue-400 hover:text-blue-300 transition-all duration-200">
              <span class="cursor-pointer bg-left-bottom bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat 
                           group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">
                de privacidad.
              </span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

