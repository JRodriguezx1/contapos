(():void=>{

  if(document.querySelector('.detalleinvoice')){
    //const POS = (window as any).POS;
    const btnModalNotaCredito = document.querySelector('#btnModalNotaCredito') as HTMLButtonElement;
    const selectSetConsecutivo = document.querySelector('#selectSetConsecutivo') as HTMLSelectElement;
    const miDialogoNC = document.querySelector('#miDialogoNC') as any;


    ///////////////////-------    crear compañia     --------///////////////////
    btnModalNotaCredito.addEventListener('click', ()=>{
        limpiarformdialog();
        miDialogoNC.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    ///////// Habilita el campo de consecutivo personalizado
    selectSetConsecutivo?.addEventListener('change', (e:Event)=>{
      const targetDom = e.target as HTMLSelectElement;
      const habilitaconsecutivo = document.querySelector('.habilitaconsecutivo') as HTMLElement;
      if(targetDom.value == '0'){  //  Siguiente consecutivo automatico
        habilitaconsecutivo.style.display = "none";
        document.querySelector('#consecutivoPersonalizado')?.removeAttribute("required");
      }
      else{  //consecutivo personalizado
        habilitaconsecutivo.style.display = "flex";
        document.querySelector('#consecutivoPersonalizado')?.setAttribute("required", "");
      }
    });

    document.querySelector('#formNC')?.addEventListener('submit', async e=>{
        e.preventDefault();
        const idfe = (document.querySelector('#idfe') as HTMLInputElement).value;
        const consecutivo = (document.querySelector('#consecutivoPersonalizado') as HTMLInputElement).value;
        miDialogoNC.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        try {
            const url = "/admin/api/sendNc"; //llamado a la API REST apidiancontrolador.php
            const respuesta = await fetch(url, {
                method: 'POST', 
                headers: { "Accept": "application/json", "Content-Type": "application/json" },
                body: JSON.stringify({id: idfe, consecutivo})  //si consecutivo es vacio '', es siguiente consecutivo
            });
            
            const responseDian = await respuesta.json(); 
            console.log(responseDian);
            msjalertToast('success', '¡Éxito!', responseDian.exito[0]);
            return responseDian;
        } catch (error) {
            console.log(error);
        }
        
    });


    function cerrarDialogoExterno(event:Event) {
      if( event.target === miDialogoNC || (event.target as HTMLInputElement).value === 'Salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
        miDialogoNC.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateCompañia') as HTMLFormElement)?.reset();
    }

  }

})();