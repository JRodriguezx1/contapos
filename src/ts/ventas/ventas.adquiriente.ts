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
    const datosAquiriente: Record<string, FormDataEntryValue> = Object.fromEntries(data.entries());
    POS.gestionarAdquiriente.datosAquiriente = datosAquiriente;
  });


  const gestionarAdquiriente = {
    miDialogoFacturarA,
    datosAdquiriente: {}
  };

  POS.gestionarAdquiriente = gestionarAdquiriente;

})();