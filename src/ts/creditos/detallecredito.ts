(()=>{
  if(document.querySelector('.detallecredito')){

    //const POS = (window as any).POS;
     
    const abonar = document.querySelector('#abonar') as HTMLButtonElement;
    const btnXCerrarModalAbonar = document.querySelector('#btnXCerrarModalAbonar') as HTMLButtonElement;
    const miDialogoAbonar = document.querySelector('#miDialogoAbonar') as any;
    const pagarTodo = document.querySelector('#pagarTodo') as HTMLButtonElement;
    
    let indiceFila=0, control=0, tablacuotas:HTMLElement;


    



    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoAbonar || (event.target as HTMLInputElement).value === 'salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
        miDialogoAbonar.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }


  }

})();