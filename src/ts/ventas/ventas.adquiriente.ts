(()=>{
  if(!document.querySelector('.ventas'))return;

  const POS = (window as any).POS;

  const facturarA = document.querySelector('#facturarA') as HTMLButtonElement;
  const miDialogoFacturarA = document.querySelector('#miDialogoFacturarA') as any;
  const formFacturarA = document.querySelector('#formFacturarA') as HTMLFormElement;

  ///////////////////// evento al btn facturar A /////////////////////
  facturarA.addEventListener('click', (e:Event)=>{
    miDialogoFacturarA.showModal();
    document.addEventListener("click", POS.cerrarDialogoExterno);
  });

   
  formFacturarA.addEventListener('submit', (e:Event)=>{
    e.preventDefault();
    const data = new FormData(formFacturarA);
    const datosAdquiriente: Record<string, FormDataEntryValue> = Object.fromEntries(data.entries());
    POS.gestionarAdquiriente.datosAdquiriente = datosAdquiriente; //guarda en el objeto global
    miDialogoFacturarA.close();
    document.removeEventListener("click", cerrarDialogoExterno);
    //guardar adquiriente en DB.
    guardarAdquiriente(datosAdquiriente);
  });


  async function guardarAdquiriente(datosAdquiriente: Record<string, FormDataEntryValue>){
    try {
          const url = "/admin/api/guardarAdquiriente";  //va al controlador ventascontrolador
          const respuesta = await fetch(url, {
                                    method: 'POST',
                                    headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                    body: JSON.stringify(datosAdquiriente)
                                  }); 
          const resultado = await respuesta.json();
          if(resultado.exito !== undefined){
            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
          }else{
            msjalertToast('error', '¡Error!', resultado.error[0]);
          }
      } catch (error) {
          console.log(error);
      }
  }
  

  const gestionarAdquiriente = {  //objeto a exportar
    miDialogoFacturarA,
    datosAdquiriente: {} //inicializar 
  };

  POS.gestionarAdquiriente = gestionarAdquiriente;

})();