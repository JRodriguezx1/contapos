(function(){
  if(document.querySelector('.contenedorsetup')){

    const radios = document.querySelectorAll<HTMLInputElement>('.contenedorsetup input[type="radio"]');

    radios.forEach(radio => {
      radio.addEventListener('change', () => {
        // Obtenemos el grupo (name) del radio
        const grupo:string = radio.name;
        // Obtenemos la opción seleccionada de ese grupo
        const seleccionado = document.querySelector(`input[name="${grupo}"]:checked`) as HTMLInputElement;

        console.log(`${grupo}, Opción seleccionada: ${seleccionado.value}`);
        cambiarparametro(grupo, seleccionado.value);
      });
    });

    function cambiarparametro(clave:string, valor:string){
      const datos = new FormData();
      datos.append(clave, valor);
      (async ()=>{
        try {
            const url = "/admin/api/parametrosSistema";  //api llamada en parametroscontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
      })();
    }


  }
})();