(function(){
  if(document.querySelector('.contenedorsetup')){

    const radios = document.querySelectorAll<HTMLInputElement>('.contenedorsetup input[type="radio"]');
    const claves = document.querySelectorAll<HTMLInputElement>('.clave');

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

    //////////  CLAVES  ////////////
    ///////////  eventos a los inputs de las claves /////////////
    claves.forEach(c=>{
      c.addEventListener('input', (e)=>{  
        const inputClave = (e.target as HTMLInputElement);
        const valorClave = (e.target as HTMLInputElement).value;
        (async ()=>{
          const datos = new FormData();
          datos.append(inputClave.name, valorClave);
          try {
              const url = "/admin/api/parametrosSistemaClaves";  //api llamada en parametroscontrolador.php
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();
              if(resultado.exito !== undefined){
                inputClave.style.color = "#02db02";
                inputClave.style.fontWeight = "500";
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();
      });
    });

  }
})();