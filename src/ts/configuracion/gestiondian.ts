(():void=>{

  if(document.querySelector('.gestionfacturadores')){

    const crearCompañia = document.querySelector('#crearCompañia') as HTMLButtonElement;
    const obtenerresolucion = document.querySelector('#obtenerresolucion') as HTMLButtonElement;
    const setpruebas = document.querySelector('#setpruebas') as HTMLButtonElement;
    const formCrearUpdateCompañia = document.querySelector('#formCrearUpdateCompañia') as HTMLFormElement;
    const miDialogoCompañia = document.querySelector('#miDialogoCompañia') as any;
    const miDialogoGetResolucion = document.querySelector('#miDialogoGetResolucion') as any;
    const miDialogosetpruebas = document.querySelector('#miDialogosetpruebas') as any;
    const selectDepartments = document.querySelector('#department_id') as HTMLSelectElement;
    const selectdCities = document.querySelector('#municipality_id') as HTMLSelectElement;
    let indiceFila=0, control=0, tablaCompañias:HTMLTableElement;

    interface configCompany {
      success:boolean,
      message:string,
      password:string,
      token:string,
      company: {
        address: string,
        country_id: number,
        created_at: string,
        dv: string,
        eqdocs_type_environment_id: number,
        id: number,
        identification_number: string,
        language_id: number,
        merchant_registration: string,
        municipality_id: number,
        payroll_type_environment_id: 2,
        phone: string,
        state: number,
        tax_id: number,
        type_currency_id: number,
        type_document_identification_id: number,
        type_environment_id: number,
        type_liability_id: number,
        type_operation_id: number,
        type_organization_id: number,
        type_regime_id: number,
        updated_at: string,
        user: {
          email: string,
          name: string,
          updated_at: string,
          created_at: string
        }
      }
    }

    type municipalities = {
        id:string,
        department_id:string,
        name:string,
        code:string,
      };
      let cities:municipalities[]=[];


    /////       Obtener municipio segun departamento        ///////
    selectDepartments.addEventListener('change', (e:Event)=>{
      const x:HTMLOptionElement = (e.target as HTMLOptionElement);
      imprimirCiudades(x.value);
    });

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


    ///////////////////-------    crear compañia     --------///////////////////
    
    crearCompañia.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalCompañia')!.textContent = "Crear compañia";
        (document.querySelector('#btnEditarCrearCompañia') as HTMLInputElement).value = "Crear";
        miDialogoCompañia.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    obtenerresolucion.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        miDialogoGetResolucion.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    setpruebas.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        miDialogosetpruebas.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    formCrearUpdateCompañia.addEventListener('submit', async(e:Event)=>{
      e.preventDefault();
      const datos = new FormData(formCrearUpdateCompañia);
      const archivoP12 = datos.get('certificate') as File;
      const datoscompañia = Object.fromEntries(datos.entries());
      datoscompañia.merchant_registration = "0000000-00";

      const nit = datoscompañia.identification_number as string;
      if(!/^\d+$/.test(nit)){
        alert('Numero del Nit no es valido');
        return;
      }
      
      if(archivoP12 && archivoP12.size>0){
        if(!archivoP12.name.toLocaleLowerCase().endsWith('.p12')){
          alert('Por favor seleccione un archivo formato .p12 valido');
          return;
        }
        try {
          const base64String = await base64(archivoP12);
          datoscompañia.certificadop12base64 = base64String;
          console.log(datoscompañia);
          crearCompany(datoscompañia);
        } catch (error) {
          alert('Error durante el procesamiento del certificado .p12');
          return;
        }
      }
    });


    async function crearCompany(datoscompañia: Record<string, FormDataEntryValue>){
      const { identification_number, certificadop12base64, password } = datoscompañia;
        const dv = getDgv(Number(identification_number));
        try{
            const url = `https://apidianj2.com/api/ubl2.1/config/${identification_number}/${dv}`; //llamado a la API REST Dianlaravel
            const respuesta = await fetch(url, {
                                                  method: 'POST',
                                                  headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                                  body: JSON.stringify(datoscompañia)
                                                });
            const resultado = await respuesta.json();
            if(resultado.success){
              console.log(resultado);
              configCertificado(resultado.token, certificadop12base64+'', password+'');
            }
          } catch (error) {
              console.log(error);
          }
    }

    async function configCertificado(token:string, certificado:string, password:string) {
      try{
          const url = "https://apidianj2.com/api/ubl2.1/config/certificate"; //llamado a la API REST Dianlaravel
          const respuesta = await fetch(url, {
                                                method: 'PUT',
                                                headers: {
                                                  "Accept": "application/json",
                                                  "Content-Type": "application/json",
                                                  "Authorization": "Bearer "+token
                                                },
                                                body: JSON.stringify({"certificate": certificado, "password":password})
                                              });

          const resultado = await respuesta.json();
          console.log(resultado);
        } catch (error) {
            console.log(error);
        }
    }

    

    function base64(archivo: File):Promise<string>{
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => {
            const base64Completo = reader.result as string;
            const base64Puro = base64Completo.split(',')[1];
            resolve(base64Puro);
        };
        reader.onerror = () => reject(new Error('Error al leer el archivo'));
        reader.readAsDataURL(archivo);
      });
    }

    function getDgv(nit: number): number {
        const multiplicadores = [3, 7, 13, 17, 19, 23, 29, 37, 41, 43, 47, 53, 59, 67, 71];
        const digitos = nit.toString().trim().split('').map(Number);
        let suma = 0;
        digitos.forEach((digito, indice) => {
            const posicionMultiplicador = digitos.length - indice;
            suma += digito * multiplicadores[posicionMultiplicador - 1];
        });
        
        const modulo = suma%11;
        return modulo > 1 ?(11 - modulo):modulo;
    }

    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoCompañia || event.target === miDialogosetpruebas || event.target === miDialogoGetResolucion || (event.target as HTMLInputElement).value === 'Salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
          miDialogoCompañia.close();
          miDialogoGetResolucion.close();
          miDialogosetpruebas.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateCompañia') as HTMLFormElement)?.reset();
    }

  }

})();