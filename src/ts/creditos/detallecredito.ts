(()=>{
  if(document.querySelector('.detallecredito')){

    //const POS = (window as any).POS;
     
    const btnDetalleProductos = document.querySelector('#btnDetalleProductos') as HTMLButtonElement;
    const btnAbonar = document.querySelector('#btnAbonar') as HTMLButtonElement;
    const btnXCerrarModalAbono = document.querySelector('#btnXCerrarModalAbono') as HTMLButtonElement;
    const miDialogoAbono = document.querySelector('#miDialogoAbono') as any;
    const miDialogoDetalleProducto = document.querySelector('#miDialogoDetalleProducto') as any;
    const pagarTodo = document.querySelector('#pagarTodo') as HTMLButtonElement;
    
    let indiceFila=0, control=0, tablacuotas:HTMLElement;

    
    document.addEventListener("click", cerrarDialogoExterno);
     
    //////////////////  TABLA //////////////////////
    tablacuotas = ($('#tablacuotas') as any).DataTable(configdatatables);



    btnDetalleProductos?.addEventListener('click', ():void=>{
      miDialogoDetalleProducto.showModal();
    });

    //btn para abonar credito
    btnAbonar?.addEventListener('click', ():void=>{
      control = 0;
      miDialogoAbono.showModal();
    });



    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      console.log(f);
      if (f === miDialogoAbono || f === miDialogoDetalleProducto || (f as HTMLInputElement).value === 'salir' || (f as HTMLInputElement).value === 'Cancelar' || (f as HTMLButtonElement).id == 'btnXCerrarModalDetalleProducto' || (f as HTMLButtonElement).id == 'btnXCerrarModalAbono') {
        miDialogoAbono.close();
        miDialogoDetalleProducto.close();
      }
    }


  }

})();