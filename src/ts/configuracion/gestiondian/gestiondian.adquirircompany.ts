(()=>{
    if(!document.querySelector('.gestionDian'))return;
    const POS = (window as any).POS;

    const btnAdquirirCompañia = document.querySelector('#btnAdquirirCompañia') as HTMLButtonElement;
    const miDialogoAdquirirCompañia = document.querySelector('#miDialogoAdquirirCompañia') as any;

    btnAdquirirCompañia.addEventListener('click', ()=>{
        miDialogoAdquirirCompañia.showModal();
        document.addEventListener("click", POS.cerrarDialogoExterno);
    });

    ///////    CONSULTAR COMPAÑIA POR NIT   ///////
    document.querySelector('#formAdquirirCompañia')?.addEventListener('submit', async (e:Event)=>{
      e.preventDefault();
      const nit = (document.querySelector('#nitcompany') as HTMLInputElement).value;
      const adquirirCompañiaPassword = (document.querySelector('#adquirirCompañiaPassword') as HTMLInputElement).value;
      miDialogoAdquirirCompañia.close();
      document.removeEventListener("click", POS.cerrarDialogoExterno);
      try {
        const url = `https://apidianj2.com/api/getCompany/${nit}`; //llamado a la API REST Dian-laravel para consultar la compañia por nit
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        POS.crearCompanyJ2({ business_name:resultado.compañia.user.name, identification_number: resultado.compañia.identification_number, idsoftware: resultado.compañia.software.identifier, pinsoftware:12345, estado:1 }, resultado.compañia.user.api_token);
      } catch (error) {
        console.log(error);
      }
    });


    const gestionAdquirirCompany = {  //objeto a exportar
        miDialogoAdquirirCompañia,
    };

    POS.gestionAdquirirCompany = gestionAdquirirCompany;

})();