(():void=>{

  if(document.querySelector('.gestionfacturadores')){

    const crearCompañia = document.querySelector('#crearCompañia') as HTMLButtonElement;
    const obtenerresolucion = document.querySelector('#obtenerresolucion') as HTMLButtonElement;
    const setpruebas = document.querySelector('#setpruebas') as HTMLButtonElement;
    const miDialogoCompañia = document.querySelector('#miDialogoCompañia') as any;
    const miDialogoGetResolucion = document.querySelector('#miDialogoGetResolucion') as any;
    const miDialogosetpruebas = document.querySelector('#miDialogosetpruebas') as any;
    let indiceFila=0, control=0, tablaCompañias:HTMLElement;

    crearCompañia.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalCompañia')!.textContent = "Crear compañia";
        (document.querySelector('#btnEditarCrearCompañia') as HTMLInputElement).value = "Crear";
        miDialogoCompañia.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    obtenerresolucion.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        miDialogoGetResolucion.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    setpruebas.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        miDialogosetpruebas.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoCompañia || event.target === miDialogosetpruebas || event.target === miDialogoGetResolucion || (event.target as HTMLInputElement).value === 'Salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
          miDialogoCompañia.close();
          miDialogoGetResolucion.close();
          miDialogosetpruebas.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateCompañia') as HTMLFormElement)?.reset();
    }

  }

})();