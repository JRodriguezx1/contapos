(function(){
  if(document.querySelector('.contenedorsetup')){

    const radios = document.querySelectorAll<HTMLInputElement>('.contenedorsetup input[type="radio"]');
    const claves = document.querySelectorAll<HTMLInputElement>('.keyinput');
    const porcentaje_de_impuesto = document.querySelector('#porcentaje_de_impuesto') as HTMLSelectElement;

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

    ////////////// inputs tipo radio  ////////////////
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
    ///////////  eventos a los inputs de las claves, limite de descuento, cantidad de zeta diarios etc 'Campos de entrada' /////////////
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



    //////////////////   campo tipo de descuento   /////////////////////
    porcentaje_de_impuesto?.addEventListener('input', (e)=>{
      console.log((e.target as HTMLSelectElement).value);
      (async ()=>{
          const datos = new FormData();
          datos.append('porcentaje_de_impuesto', (e.target as HTMLSelectElement).value);
          try {
              const url = "/admin/api/parametrosSistemaPorcentajeImpuesto";  //api llamada en parametroscontrolador.php
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

    });

    
  }

})();