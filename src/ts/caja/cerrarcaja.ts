(():void=>{

  if(document.querySelector('.cerrarcaja')){
    const modalArqueocaja:any = document.querySelector("#modalArqueocaja");
    const Modalcerrarcaja:any = document.querySelector("#Modalcerrarcaja");
    const btnArqueocaja = document.querySelector<HTMLButtonElement>("#btnArqueocaja");
    const btnCerrarcaja = document.querySelector<HTMLButtonElement>("#btnCerrarcaja");


    btnArqueocaja?.addEventListener('click', ():void=>{
      modalArqueocaja.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });

    btnCerrarcaja?.addEventListener('click', ():void=>{
      Modalcerrarcaja.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });


    function cerrarDialogoExterno(event:Event) {
      if (event.target === modalArqueocaja || event.target === Modalcerrarcaja || (event.target as HTMLInputElement).value === 'cancelar' || (event.target as HTMLInputElement).value === 'Aplicar' || (event.target as HTMLElement).closest('.salircerrarcaja') || (event.target as HTMLElement).closest('.finCerrarcaja')) {
          modalArqueocaja.close();
          Modalcerrarcaja.close();
          document.removeEventListener("click", cerrarDialogoExterno);
          if((event.target as HTMLElement).closest('.finCerrarcaja'))console.log(45);//eliminarCita(event.target.closest('.terminarcita').id);
      }
    }
  }

})();