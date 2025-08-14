(():void=>{

  if(document.querySelector('.cerrarcaja')){
    const modalArqueocaja:any = document.querySelector("#modalArqueocaja");
    const Modalcerrarcaja:any = document.querySelector("#Modalcerrarcaja");
    const btnArqueocaja = document.querySelector<HTMLButtonElement>("#btnArqueocaja");
    const btnCerrarcaja = document.querySelector<HTMLButtonElement>("#btnCerrarcaja");
    const inputsmediospago = document.querySelectorAll<HTMLInputElement>('.inputmediopago');
    const formArqueocaja = document.querySelector('#formArqueocaja') as HTMLFormElement;

    btnArqueocaja?.addEventListener('click', ():void=>{
      modalArqueocaja.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });

    btnCerrarcaja?.addEventListener('click', ():void=>{
      Modalcerrarcaja.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });
    

    //////////////////     Arqueo de caja      //////////////////////
    formArqueocaja?.addEventListener('submit', (e:Event)=>{
      e.preventDefault();
      sumatoriaDenominaciones();
      const datos = new FormData(formArqueocaja);
      (async ()=>{
        try {
            const url = "/admin/api/arqueocaja";  //api llamada en cajacontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              modalArqueocaja.close();
              document.removeEventListener("click", cerrarDialogoExterno);
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
      })();
      
    });

    function sumatoriaDenominaciones():void{
      const ef = document.querySelector('#Efectivo') as HTMLInputElement;
      const inputsDenominaciones = Array.from( document.querySelectorAll<HTMLInputElement>('.denominacion'));
      const sum = inputsDenominaciones.reduce((total, denominaicon)=>(Number(denominaicon.dataset.moneda)*Number(denominaicon.value))+total, 0);
      ef.value = sum+'';
      const eventInput = new Event('input');  //crea un evento
      ef.dispatchEvent(eventInput); // se dispara el evento de manera manual, abajo.
    }

    ///////////  eventos a los inputs medios de pago de declarar valores /////////////
    inputsmediospago.forEach(m=>{
      m.addEventListener('input', (e)=>{  
        const inputmediopago = (e.target as HTMLInputElement);
        (async ()=>{
          const datos = new FormData();
          datos.append('id_mediopago', inputmediopago.dataset.idmediopago+'');
          datos.append('nombremediopago', inputmediopago.name);
          datos.append('valordeclarado', inputmediopago.value);
          try {
              const url = "/admin/api/declaracionDinero";  //api llamada en cajacontrolador.php
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();
              if(resultado.exito !== undefined){
                inputmediopago.style.color = "#02db02";
                inputmediopago.style.fontWeight = "500";
                actualizarAnalisis(inputmediopago.dataset.idmediopago!, inputmediopago.value, inputmediopago.name);
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();
      });
    }); 


    function actualizarAnalisis(id: string, valordeclarado: string, mediopago:string):void{
      const coldeclarado = document.querySelector(`.coldeclarado[data-mediopagoid="${id}"]`);
      if(coldeclarado){
        const coldif = coldeclarado.nextElementSibling;
        coldeclarado.textContent = Number(valordeclarado).toLocaleString('es-ES', { useGrouping: true });
        const colsistem = coldeclarado.previousElementSibling?.textContent?.replace(/[.,]/g, '');
        coldif!.textContent = ((Number(valordeclarado) - Number(colsistem))).toLocaleString('es-ES', { useGrouping: true }); 
      }else{
        const cuerpoanalisis = document.querySelector('.cuerpoanalisis');
        cuerpoanalisis?.insertAdjacentHTML('beforeend', `
          <tr class="${mediopago=='Efectivo'?'!border-2 !border-indigo-600':''}">
            <td class="">${mediopago}</td> 
            <td class="colsistem">0</td>
            <td class="coldeclarado" data-mediopagoid="${id}">${Number(valordeclarado).toLocaleString('es-ES', { useGrouping: true })}</td>
            <td class="coldif">${Number(valordeclarado).toLocaleString('es-ES', { useGrouping: true })}</td>
          </tr>`
        );
      }
    }

    function confirmarcierre(){
      const datos = new FormData();
      
      datos.append('idcierrecaja', document.querySelector('#idCierrecaja')?.textContent!);
      
      (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
      Modalcerrarcaja.close();
      document.removeEventListener("click", cerrarDialogoExterno);
      (async ()=>{
        try {

            const url = "/admin/api/cierrecajaconfirmado";  //api llamada en cajacontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              setTimeout(() => {
                (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
                window.location.href = `/admin/caja/detallecierrecaja?id=${resultado.ultimocierre[0]}`;
              }, 1600);
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
      })();
    }

    function cerrarDialogoExterno(event:Event) {
      if (event.target === modalArqueocaja || event.target === Modalcerrarcaja || (event.target as HTMLInputElement).value === 'cancelar' || (event.target as HTMLElement).closest('.salircerrarcaja') || (event.target as HTMLElement).closest('.finCerrarcaja')) {
          modalArqueocaja.close();
          Modalcerrarcaja.close();
          document.removeEventListener("click", cerrarDialogoExterno);

          if((event.target as HTMLElement).closest('.finCerrarcaja')){  //Cuando se hace el cierre de caja
            confirmarcierre();
          }
      }
    }
  }

})();