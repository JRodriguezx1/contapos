(():void=>{

  if(document.querySelector('.detalleinvoice')){
    //const POS = (window as any).POS;
    const btnModalNotaCredito = document.querySelector('#btnModalNotaCredito') as HTMLButtonElement;
    const selectSetConsecutivo = document.querySelector('#selectSetConsecutivo') as HTMLSelectElement;
    const miDialogoNC = document.querySelector('#miDialogoNC') as any;

    const facturarA = document.querySelector('#facturarA') as HTMLButtonElement;
    const miDialogoFacturarA = document.querySelector('#miDialogoFacturarA') as any;
    const formFacturarA = document.querySelector('#formFacturarA') as HTMLFormElement;
    const documentinput = document.querySelector('#identification_number') as HTMLInputElement;
    const selectDepartments = document.querySelector('#department_id') as HTMLSelectElement;
    const selectdCities = document.querySelector('#municipality_id') as HTMLSelectElement;
    let customers:adquirientes[] = [];
    let customersfiltrados:adquirientes[] = [];


    interface adquirientes {
      id?:string,
      type_document_identification_id:string,
      identification_number:string,
      business_name:string,
      email:string,
      address:string,
      municipality_id?:string,
      department_id?:string,
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


    (async ()=>{
      const url = `/admin/api/filterAdquirientes`; 
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();
      customers = resultado;
      //formatearponentes(resultado);
    })();


    //buscar adquiriente
    documentinput.addEventListener('input', buscarAquiriente);

    function buscarAquiriente(e:Event){
        const busqueda:string = (e.target as HTMLInputElement).value;
        if(busqueda.length > 3 && /^\d+$/.test(busqueda)){
            //const expresionregular = new RegExp(busqueda, "i");
            customersfiltrados = customers.filter(document => { 
                if(document.identification_number.trim() === busqueda.trim()){
                    return document;
                }
            });   
        }else{
            customersfiltrados = [];
        }
        mostrarAdquiriente();
    }

    function mostrarAdquiriente(){
      if(customersfiltrados.length>0){
        $('#type_document_identification_id').val(customersfiltrados[0].type_document_identification_id);
        (document.querySelector('#business_name') as HTMLInputElement).value = customersfiltrados[0].business_name;
        (document.querySelector('#email') as HTMLInputElement).value = customersfiltrados[0].email;
        (document.querySelector('#address') as HTMLInputElement).value = customersfiltrados[0].address;
        if(customersfiltrados[0].department_id){
          $('#department_id').val(customersfiltrados[0].department_id);
          imprimirCiudades(customersfiltrados[0].department_id);
        }
        //$('#municipality_id').val(customersfiltrados[0].municipality_id);
        $('#type_organization_id').val(customersfiltrados[0].type_organization_id);
        $('#type_regime_id').val(customersfiltrados[0].type_regime_id);
        (document.querySelector('#phone') as HTMLInputElement).value = customersfiltrados[0].phone;
      }else{
        $('#type_document_identification_id').val("");
        (document.querySelector('#business_name') as HTMLInputElement).value = '';
        (document.querySelector('#email') as HTMLInputElement).value = '';
        (document.querySelector('#address') as HTMLInputElement).value = '';
        $('#department_id').val("");
        $('#municipality_id').val("");
        $('#type_organization_id').val("");
        $('#type_regime_id').val("");
        (document.querySelector('#phone') as HTMLInputElement).value = "";
      }
    }



    /////       Obtener municipio segun departamento        ///////
    selectDepartments?.addEventListener('change', (e:Event)=>{
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
      if(customersfiltrados.length>0&&customersfiltrados[0].municipality_id)$('#municipality_id').val(customersfiltrados[0].municipality_id);
    }


    ///////////////////// evento al btn facturar A /////////////////////
    facturarA.addEventListener('click', (e:Event)=>{
      miDialogoFacturarA.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });

    
    formFacturarA.addEventListener('submit', (e:Event)=>{
      e.preventDefault();
      const data = new FormData(formFacturarA);
      const datosAdquiriente: Record<string, FormDataEntryValue> = Object.fromEntries(data.entries());
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
            //añadir o actualizar al arreglo customers
            if(resultado.response == "crear"){
              customers = [...customers, resultado.obj];
            }else{
              /// actualizar el arregle del producto ///
              customers.forEach(a=>{if(a.identification_number == resultado.obj.identification_number)a = Object.assign(a, resultado.obj);});
            }
            datosAdquiriente.id = resultado.obj.id;
        } catch (error) {
            console.log(error);
        }
    }


    ///////////////////-------    Btn NC     --------///////////////////
    btnModalNotaCredito.addEventListener('click', ()=>{
        limpiarformdialog();
        miDialogoNC.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    ///////// Habilita el campo de consecutivo personalizado
    selectSetConsecutivo?.addEventListener('change', (e:Event)=>{
      const targetDom = e.target as HTMLSelectElement;
      const habilitaconsecutivo = document.querySelector('.habilitaconsecutivo') as HTMLElement;
      if(targetDom.value == '0'){  //  Siguiente consecutivo automatico
        habilitaconsecutivo.style.display = "none";
        document.querySelector('#consecutivoPersonalizado')?.removeAttribute("required");
      }
      else{  //consecutivo personalizado
        habilitaconsecutivo.style.display = "flex";
        document.querySelector('#consecutivoPersonalizado')?.setAttribute("required", "");
      }
    });

    document.querySelector('#formNC')?.addEventListener('submit', async e=>{
        e.preventDefault();
        const idfe = (document.querySelector('#idfe') as HTMLInputElement).value;
        const consecutivo = (document.querySelector('#consecutivoPersonalizado') as HTMLInputElement).value;
        miDialogoNC.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        try {
            const url = "/admin/api/sendNc"; //llamado a la API REST apidiancontrolador.php
            const respuesta = await fetch(url, {
                method: 'POST', 
                headers: { "Accept": "application/json", "Content-Type": "application/json" },
                body: JSON.stringify({id: idfe, consecutivo})  //si consecutivo es vacio '', es siguiente consecutivo
            });
            
            const responseDian = await respuesta.json(); 
            console.log(responseDian);
            msjalertToast('success', '¡Éxito!', responseDian.exito[0]);
            return responseDian;
        } catch (error) {
            console.log(error);
        }
        
    });


    function cerrarDialogoExterno(event:Event) {
      if( event.target === miDialogoNC || event.target === miDialogoFacturarA || (event.target as HTMLInputElement).value === 'Salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
        miDialogoNC.close();
        miDialogoFacturarA.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateCompañia') as HTMLFormElement)?.reset();
    }

  }

})();