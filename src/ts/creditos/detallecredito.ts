(()=>{
  if(document.querySelector('.detallecredito')){

    //const POS = (window as any).POS;
     
    const btnAbonar = document.querySelector('#btnAbonar') as HTMLButtonElement;
    const btnXCerrarModalAbono = document.querySelector('#btnXCerrarModalAbono') as HTMLButtonElement;
    const miDialogoAbono = document.querySelector('#miDialogoAbono') as any;
    const pagarTodo = document.querySelector('#pagarTodo') as HTMLButtonElement;
    
    let indiceFila=0, control=0, tablacuotas:HTMLElement;

    
     
    //////////////////  TABLA //////////////////////
    tablacuotas = ($('#tablacuotas') as any).DataTable(configdatatables);

    //btn para crear credito
    btnAbonar?.addEventListener('click', ():void=>{
      control = 0;
      miDialogoAbono.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
      ($('#mediopago') as any).select2({ dropdownParent: $('#miDialogoAbono'), placeholder: "Seleccionar el medio de pago", maximumSelectionLength: 1});
    });

    btnXCerrarModalAbono.addEventListener('click', (e)=>{
        miDialogoAbono.close();
        document.removeEventListener("click", cerrarDialogoExterno);
    });
    



    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoAbono || (event.target as HTMLInputElement).value === 'salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
        miDialogoAbono.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }


  }

})();