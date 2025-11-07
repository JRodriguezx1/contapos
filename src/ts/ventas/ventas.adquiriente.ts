(()=>{
  if(!document.querySelector('.ventas'))return;

  const POS = (window as any).POS;

  interface adquirientes {
    id:string,
    type_document_identification_id:string,
    identification_number:string,
    business_name:string,
    email:string,
    address:string,
    phone:string,
    municipality_id:string,
    departamento:string,
    ciudad_nombre:string
  }

  const facturarA = document.querySelector('#facturarA') as HTMLButtonElement;
  const miDialogoFacturarA = document.querySelector('#miDialogoFacturarA') as any;
  const formFacturarA = document.querySelector('#formFacturarA') as HTMLFormElement;
  const ponentesinput = document.querySelector('#ponentes') as HTMLInputElement;
  let ponentes:adquirientes[] = [];
  let ponentesfiltrados = [];


  (async ()=>{
    const url = `/admin/api/filterAdquirientes`; 
    const respuesta = await fetch(url);
    const resultado = await respuesta.json();
    //formatearponentes(resultado);
  })();


  //buscar adquiriente
  ponentesinput.addEventListener('input', buscarponentes);

  function buscarponentes(e:Event){
      const busqueda = (e.target as HTMLInputElement).value;
      if(busqueda.length > 3){
          const expresionregular = new RegExp(busqueda, "i");
          ponentesfiltrados = ponentes.filter(ponente => { 
              if(ponente.nombre.toLowerCase().search(expresionregular) != -1){
                  return ponente;
              }
          });   
      }else{
          ponentesfiltrados = [];
      }
      //mostrarponente();
  }

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
          console.log(resultado);
          /*if(resultado.exito !== undefined){
            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
          }else{
            msjalertToast('error', '¡Error!', resultado.error[0]);
          }*/
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