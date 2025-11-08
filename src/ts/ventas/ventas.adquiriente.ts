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
    municipality_id:string,
    departamento:string,
    ciudad_nombre:string
    type_organization_id:string,
    type_regime_id:string,
    phone:string
  }

  type municipalities = {
        id:string,
        department_id:string,
        name:string,
        code:string,
  };
  let cities:municipalities[]=[];

  const facturarA = document.querySelector('#facturarA') as HTMLButtonElement;
  const miDialogoFacturarA = document.querySelector('#miDialogoFacturarA') as any;
  const formFacturarA = document.querySelector('#formFacturarA') as HTMLFormElement;
  const documentinput = document.querySelector('#identification_number') as HTMLInputElement;
  const selectdCities = document.querySelector('#municipality_id') as HTMLSelectElement;
  let documents:adquirientes[] = [];
  let documentosfiltrados:adquirientes[] = [];


  (async ()=>{
    const url = `/admin/api/filterAdquirientes`; 
    const respuesta = await fetch(url);
    const resultado = await respuesta.json();
    documents = resultado;
    console.log(documents);
    //formatearponentes(resultado);
  })();


  //buscar adquiriente
  documentinput.addEventListener('input', buscarAquiriente);

  function buscarAquiriente(e:Event){
      const busqueda:string = (e.target as HTMLInputElement).value;
      if(busqueda.length > 3 && /^\d+$/.test(busqueda)){
          //const expresionregular = new RegExp(busqueda, "i");
          documentosfiltrados = documents.filter(document => { 
              if(document.identification_number.trim() === busqueda.trim()){
                  return document;
              }
          });   
      }else{
          documentosfiltrados = [];
      }
      mostrarAdquiriente();
  }

  function mostrarAdquiriente(){
    console.log(documentosfiltrados);
    if(documentosfiltrados.length>0){
      $('#type_document_identification_id').val(documentosfiltrados[0].type_document_identification_id);
      (document.querySelector('#business_name') as HTMLInputElement).value = documentosfiltrados[0].business_name;
      (document.querySelector('#email') as HTMLInputElement).value = documentosfiltrados[0].email;
      (document.querySelector('#address') as HTMLInputElement).value = documentosfiltrados[0].address;
      $('#type_organization_id').val(documentosfiltrados[0].type_organization_id);
      $('#type_regime_id').val(documentosfiltrados[0].type_regime_id);
      (document.querySelector('#phone') as HTMLInputElement).value = documentosfiltrados[0].phone;
    }else{
      $('#type_document_identification_id').val("");
      (document.querySelector('#business_name') as HTMLInputElement).value = '';
      (document.querySelector('#email') as HTMLInputElement).value = '';
      (document.querySelector('#address') as HTMLInputElement).value = '';
      $('#type_organization_id').val("");
      $('#type_regime_id').val("");
      (document.querySelector('#phone') as HTMLInputElement).value = "";
    }
  }



  /////       Obtener municipio segun departamento        ///////
    /*selectDepartments?.addEventListener('change', (e:Event)=>{
      const x:HTMLOptionElement = (e.target as HTMLOptionElement);
      imprimirCiudades(x.value);
    });*/

    function imprimirCiudades(x:string){
      (async ()=>{
        try {
          const url = "/admin/api/citiesXdepartments?id="+x; //llamado a la API REST y se trae las cities segun cliente elegido
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          if(resultado.error){
            Swal.fire(resultado.error[0], '', 'error')
          }else{
            cities = resultado;
            addCitiesToSelect(cities);
          }
        } catch (error) {
            console.log(error);
        }
      })();
    }
       
    function addCitiesToSelect<T extends {id:string, department_id:string, name:string, code:string}>(addrs: T[]):void{
      while(selectdCities?.firstChild)selectdCities.removeChild(selectdCities?.firstChild);
      addrs.forEach(x =>{
        const option = document.createElement('option');
        option.textContent = x.name;
        option.value = x.id;
        option.dataset.code = x.code;
        option.dataset.department_id = x.department_id;
        selectdCities.appendChild(option);
      });
      
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