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

<div class="h-screen w-screen flex justify-center items-center bg-gray-100 px-6 transition-colors duration-300 relative overflow-hidden">

  <!-- Fondo desenfocado / Light Glass Effect -->
  <div class="absolute inset-0 bg-gradient-to-br from-blue-100/20 via-purple-100/20 to-indigo-200/20 backdrop-blur-md"></div>

  <div class="relative z-10 grid gap-0 w-full xsp:w-[38rem] xlg:w-[48rem] mx-auto">

    <?php include __DIR__. "/../templates/alertas.php"; ?>

    <!-- Contenedor Principal Flotante -->
    <div id="back-div" class="w-full relative rounded-[30px] shadow-2xl p-0 transition-transform duration-500 hover:scale-[1.02] bg-[linear-gradient(to_left,_rgba(37,99,235,0.9)_0%,_rgba(79,70,229,0.9)_85%,_rgba(147,51,234,0.9)_100%)] hover:bg-[linear-gradient(to_left,_rgba(126,34,206,0.9)_0%,_rgba(79,70,229,0.9)_85%,_rgba(37,99,235,0.9)_100%)] before:content-[''] before:absolute before:top-0 before:right-0 before:w-1/3 before:h-full before:bg-[radial-gradient(circle_at_90%_50%,rgba(255,255,255,0.25),transparent_70%)] before:rounded-[30px]">
      <img src="/build/img/Logoj2blanco.png" class="w-56 sm:w-72 md:w-80 mx-auto mt-6 transition-transform duration-500 hover:scale-105" alt="logoj2">

      <!-- Formulario con efecto glass y sombras internas -->
      <div class="border-[10px] border-transparent rounded-[24px] bg-white/90 shadow-lg xl:p-10 2xl:p-10 lg:p-10 md:p-10 sm:p-4 m-2 backdrop-blur-md transition-colors duration-300">
        <h1 class="pt-8 pb-6 font-bold text-3xl sm:text-4xl md:text-5xl text-center text-gray-800 uppercase">
          Iniciar Sesión
        </h1>

        <form action="/login" method="post" class="space-y-4">

          <div>
            <label for="nickname" class="mb-2 block text-xl text-gray-700">Usuario</label>
            <input
              id="nickname"
              name="nickname"
              type="text"
              required
              placeholder="Ingresa tu usuario"
              class="w-full h-[4.7rem] xlg:h-[5.1rem] p-3 text-xl text-gray-900 bg-white/80 border border-gray-300 rounded-2xl
                     shadow-inner placeholder-gray-400/70 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                     transition-all duration-300 ease-in-out hover:scale-[1.02] focus:scale-[1.03]"
            />
          </div>

          <div>
            <label for="sucursal" class="block text-xl font-medium mb-1 text-gray-700">Sede</label>
            <span class="block mb-1 text-base text-gray-500 dark:text-gray-400">Seleccione una sede</span>
            <select 
              id="sucursal"
              name="idsucursal"
              class="w-full h-[4.7rem] xlg:h-[5.1rem] p-3 text-xl text-gray-900 bg-white/80 border border-gray-300 rounded-2xl shadow-inner
                     focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 ease-in-out
                     hover:scale-[1.02] focus:scale-[1.03]"
            >
              <?php foreach($sucursales as $value): ?>
                <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label for="password" class="mb-2 block text-xl text-gray-700">Contraseña</label>
            <input
              id="password"
              name="password"
              type="password"
              required
              placeholder="Ingresa tu contraseña"
              class="w-full h-[4.7rem] xlg:h-[5.1rem] p-3 text-xl text-gray-900 bg-white/80 border border-gray-300 rounded-2xl shadow-inner
                     placeholder-gray-400/70 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                     transition-all duration-300 ease-in-out hover:scale-[1.02] focus:scale-[1.03]"
            />
          </div>

          <a href="#" class="group text-blue-500 dark:text-blue-400 hover:text-blue-400 dark:hover:text-blue-300 text-base transition-all duration-200">
            ¿Olvidaste tu contraseña?
          </a>

          <button
            type="submit"
            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white dark:text-gray-200 shadow-lg mt-6 p-2 text-xl rounded-2xl w-full
                   hover:scale-105 hover:from-purple-700 hover:to-blue-700 transition duration-300 ease-in-out h-[4.7rem] xlg:h-[5.1rem]"
          >
            INICIAR SESIÓN
          </button>
        </form>

        <div class="flex flex-col mt-4 items-center justify-center text-lg">
          <h3 class="text-gray-700">
            ¿No tienes una cuenta?
            <a href="#" class="group text-blue-500 dark:text-blue-400 hover:text-blue-400 dark:hover:text-blue-300 transition-all duration-200">
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
            <a href="#" class="group text-blue-500 dark:text-blue-400 hover:text-blue-400 dark:hover:text-blue-300 transition-all duration-200">
              nuestros Términos y <br />Política de privacidad.
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>




