(()=>{
  if(document.querySelector('.detallecredito')){

    //const POS = (window as any).POS;
     
    const btnDetalleProductos = document.querySelector('#btnDetalleProductos') as HTMLButtonElement;
    const btnAbonar = document.querySelector('#btnAbonar') as HTMLButtonElement;
    const btnPagarTodo = document.querySelector('#btnPagarTodo') as HTMLButtonElement;
    const miDialogoAbono = document.querySelector('#miDialogoAbono') as any;
    const miDialogoPagoTotal = document.querySelector('#miDialogoPagoTotal') as any;
    const miDialogoDetalleProducto = document.querySelector('#miDialogoDetalleProducto') as any;
    const pagarTodo = document.querySelector('#pagarTodo') as HTMLButtonElement;
    
    let indiceFila=0, tablacuotas:HTMLElement;

    
    document.addEventListener("click", cerrarDialogoExterno);
     
    //////////////////  TABLA //////////////////////
    tablacuotas = ($('#tablacuotas') as any).DataTable(configdatatables);



    btnDetalleProductos?.addEventListener('click', ():void=>{
      miDialogoDetalleProducto.showModal();
    });

    //btn para abonar credito
    btnAbonar?.addEventListener('click', ():void=>{
      miDialogoAbono.showModal();
    });

    //btn para abonar credito
    btnPagarTodo?.addEventListener('click', ():void=>{
      miDialogoPagoTotal.showModal();
    });


    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      if (f === miDialogoAbono || f === miDialogoDetalleProducto || (f as HTMLInputElement).value === 'salir' || (f as HTMLInputElement).value === 'Cancelar' 
          || (f as HTMLButtonElement).id == 'btnXCerrarModalDetalleProducto' || (f as HTMLButtonElement).id == 'btnXCerrarModalAbono' || f === miDialogoPagoTotal
          || (f as HTMLButtonElement).id == 'btnXCerrarModalPagoTotal' ) {
        miDialogoAbono.close();
        miDialogoPagoTotal.close();
        miDialogoDetalleProducto.close();
      }
    }


  }

})();