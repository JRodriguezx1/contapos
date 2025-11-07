(():void=>{

  if(document.querySelector('.gestionDian')){
    const POS = (window as any).POS;
    const btnAdquirirCompañia = document.querySelector('#btnAdquirirCompañia') as HTMLButtonElement;
    const btnCrearCompañia = document.querySelector('#btnCrearCompañia') as HTMLButtonElement;
    const btnObtenerresolucion = document.querySelector('#btnObtenerresolucion') as HTMLButtonElement;
    const BtnSetpruebas = document.querySelector('#BtnSetpruebas') as HTMLButtonElement;
    const formCrearUpdateCompañia = document.querySelector('#formCrearUpdateCompañia') as HTMLFormElement;
    const miDialogoAdquirirCompañia = document.querySelector('#miDialogoAdquirirCompañia') as any;
    const miDialogoCompañia = document.querySelector('#miDialogoCompañia') as any;
    const miDialogoGetResolucion = document.querySelector('#miDialogoGetResolucion') as any;
    const miDialogosetpruebas = document.querySelector('#miDialogosetpruebas') as any;
    const selectDepartments = document.querySelector('#department_id') as HTMLSelectElement;
    const selectdCities = document.querySelector('#municipality_id') as HTMLSelectElement;
    const selectResolucioncompañia = document.querySelector('#selectResolucioncompañia') as HTMLSelectElement;
    const selectSetCompañia = document.querySelector('#selectSetCompañia') as HTMLSelectElement;

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
    

    interface TechnicalKeyObject {
      _attributes: {
        nil: string;
      };
    }
    interface NumberRangeItem {
      idcompany?: string,
      ResolutionNumber: string;
      ResolutionDate: string;
      Prefix: string;
      FromNumber: string;
      ToNumber: string;
      ValidDateFrom: string;
      ValidDateTo: string;
      TechnicalKey: string | TechnicalKeyObject;
    }


    interface resolconfig {
      type_document_id:string, 
      prefix:String, 
      resolution:string, 
      resolution_date:string, 
      technical_key:string, 
      from:string,
      to:string, 
      generated_to_date:string, 
      date_from:string, 
      date_to:string
    }

    

    type municipalities = {
        id:string,
        department_id:string,
        name:string,
        code:string,
      };
      let cities:municipalities[]=[];

    //  Obtener compañias
    async function getCompañiasLocal<T>():Promise<T[]> {
      try {
          const url = "/admin/api/getCompaniesAll"; //llamado a la API REST y se trae las cities segun cliente elegido
          const respuesta = await fetch(url); 
          const resultado:T[]= await respuesta.json(); 
          return resultado;
        } catch (error) {
            console.log(error);
            return [];
        }
    }
    
    let companiesAll:{id:string, identification_number:string, business_name:string, idsoftware:string, token:string}[];
    (async()=>{
       companiesAll = await getCompañiasLocal<{id:string, identification_number:string, business_name:string, idsoftware:string, token:string}>();
    })();


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
      
    }


    ///////////////////-------    Adquirir compañia     ---------//////////////////
    btnAdquirirCompañia.addEventListener('click', ()=>{
        miDialogoAdquirirCompañia.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    ///////////////////-------    crear compañia     --------///////////////////
    btnCrearCompañia.addEventListener('click', ()=>{
        limpiarformdialog();
        document.querySelector('#modalCompañia')!.textContent = "Crear compañia";
        (document.querySelector('#btnEditarCrearCompañia') as HTMLInputElement).value = "Crear";
        miDialogoCompañia.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    btnObtenerresolucion.addEventListener('click', ()=>{
        limpiarformdialog();
        miDialogoGetResolucion.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });

    BtnSetpruebas.addEventListener('click', async ()=>{
        limpiarformdialog();
        //const r = await getCompañiasLocal();

        miDialogosetpruebas.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    ///////////////////  ADQUIRIR COMPAÑIA  ////////////////////
    document.querySelector('#formAdquirirCompañia')?.addEventListener('submit', (e:Event)=>{
      e.preventDefault();
      
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
          crearCompanyAPI(datoscompañia);
        } catch (error) {
          alert('Error durante el procesamiento del certificado .p12');
          return;
        }
      }
    });


    async function crearCompanyAPI(datoscompañia: Record<string, FormDataEntryValue>){
      const { identification_number, certificadop12base64, password, idsoftware, pinsoftware } = datoscompañia;
        const dv = getDgv(Number(identification_number));
        try{
            const url = `https://apidianj2.com/api/ubl2.1/config/${identification_number}/${dv}`; //llamado a la API REST Dianlaravel
            const respuesta = await fetch(url,  {
                                                  method: 'POST',
                                                  headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                                  body: JSON.stringify(datoscompañia)
                                                });
            const resultado = await respuesta.json();
            if(resultado.success){
              miDialogoCompañia.close();
              document.removeEventListener("click", cerrarDialogoExterno);
              console.log(resultado);
              const cert = await configCertificado(resultado.token, certificadop12base64+'', password+'');
              const soft = await configSoftware(resultado.token, idsoftware+'', pinsoftware+'');
              const resolprueba:resolconfig = {
                type_document_id:'1', 
                prefix:'SETP', 
                resolution:'18760000001', 
                resolution_date:'2019-01-19', 
                technical_key: 'fc8eac422eba16e22ffd8c6f94b3f40a6e38162c', 
                from: '990000000', 
                to: '995000000', 
                generated_to_date:'0', 
                date_from:'2019-01-19', 
                date_to: '2030-01-19'
              };
              const resol = await crearResolucion(resolprueba, resultado.token);
              if(cert && soft && resol){
                crearCompanyJ2(datoscompañia, resultado.token);
              }else{
                //eliminar usuario de la api
                eliminarCompañia('', identification_number+'', resultado.token);
              }
            }else{

            }
          } catch (error) {
              console.log(error);
          }
    }


    ///////    CREAR CERTIFICADO EN LA API DIAN    ///////
    async function configCertificado(token:string, certificado:string, password:string):Promise<boolean> {
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
          return resultado.success;
        } catch (error) {
            console.log(error);
            return false;
        }
    }

    
    ///////    CREAR SOFTWARE EN LA API DIAN    ////////
    async function configSoftware(token:string, idsoftware:string, pinsoftware:string):Promise<boolean>
    {
      try {
        const url = "https://apidianj2.com/api/ubl2.1/config/software"; //llamado a la API REST Dianlaravel
        const respuesta = await fetch(url, {
                                              method: 'PUT',
                                              headers: {
                                                "Accept": "application/json",
                                                "Content-Type": "application/json",
                                                "Authorization": "Bearer "+token
                                              },
                                              body: JSON.stringify({"id": idsoftware, "pin":pinsoftware})
                                            });
        const resultado = await respuesta.json();
        console.log(resultado);
        return resultado.success;
      } catch (error) {
        console.log(error);
        return false;
      }
    }


    ///////    CREAR RESOLUCIONES    ////////
    async function crearResolucion(resolprueba:resolconfig, token:string)
    {
      try {
        const url = "https://apidianj2.com/api/ubl2.1/config/resolution"; //llamado a la API REST Dian-laravel
        const respuesta = await fetch(url, {
                                              method: 'PUT',
                                              headers: {
                                                "Accept": "application/json",
                                                "Content-Type": "application/json",
                                                "Authorization": "Bearer "+token
                                              },
                                              body: JSON.stringify(resolprueba)
                                            });
        const resultado = await respuesta.json();
        console.log(resultado);
        return resultado.success;
      } catch (error) {
        console.log(error);
        return false;
      }
      
    }


    ///////    CREAR COMPAÑIA EN J2    ////////
    async function crearCompanyJ2(datoscompañia: Record<string, FormDataEntryValue>, token:string){
      datoscompañia.token = token;
      try {
            const url = `/admin/api/crearCompanyJ2`; //llamado a la API para crear la compañia en j2
            const respuesta = await fetch(url,  { method: 'POST',
                                                  headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                                  body: JSON.stringify(datoscompañia)
                                                });
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              const tablaCompañias = document.querySelector('#tablaCompañias tbody');
              tablaCompañias?.insertAdjacentHTML('beforeend', `
                <tr class="" id="company${datoscompañia.identification_number}">
                  <td class="">${resultado.id}</td>
                  <td class="">${datoscompañia.business_name}</td> 
                  <td class="">${datoscompañia.identification_number}</td>
                  <td class="">${datoscompañia.idsoftware}</td>
                  <td class=""><div class="acciones-btns">  <button id="${resultado.id}"><span class="material-symbols-outlined eliminarcompañia">delete</span></button> </div></td>
                </tr>`
              );
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              // añadir a los selects de obtener compañia para resoluciones y de set pruebas
              SetCompañiaToSelect(resultado.id, token, datoscompañia.business_name+'');
              companiesAll.push({id:resultado.id, identification_number:datoscompañia.identification_number+'', business_name:datoscompañia.business_name+'', idsoftware:datoscompañia.idsoftware+'', token});
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
          } catch (error) {
              console.log(error);
          }
    }


    ///////    ENVIOREMNET MODO PRUEBAS - PRODUCCION    ///////
    

    document.querySelector('#tablaCompañias tbody')?.addEventListener('click', (e:Event)=>{
      const target = e.target as HTMLElement;
      if(target?.classList.contains("eliminarcompañia")){
        const id = target.parentElement?.id;
        const oneC = companiesAll.find(x=>x.id == id)!;
        eliminarCompañia(id!, oneC?.identification_number, oneC.token);
      }
    });

    ///////    ELIMINAR COMPAÑIA    ///////
    function eliminarCompañia(id:string, identification_number:string, token:string){
     
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar la compañia?',
          text: "La compañia sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
            (async ()=>{ 
              try {
                const url = "https://apidianj2.com/api/ubl2.1/config/deleteCompany"; //llamado a la API REST Dianlaravel
                const respuesta = await fetch(url, {
                                                      method: 'DELETE',
                                                      headers: { "Accept": "application/json", "Content-Type": "application/json", "Authorization": "Bearer "+token },
                                                      body: JSON.stringify({"identification_number": identification_number})
                                                    });
                const resultado = await respuesta.json();
                if(resultado.message){
                  const urlX = "/admin/api/eliminarCompanyLocal?id="+identification_number; // para eliminar compañia localmente
                  const respuestaLocal = await fetch(urlX); 
                  const resultadoLocal = await respuestaLocal.json(); 
                  document.querySelector('#company'+identification_number)?.remove();
                  msjalertToast('success', '¡Éxito!', resultado.message);
                  deleteFromCompany(id);
                }else{
                  msjalertToast('error', '¡Error!', 'Error intentalo nuevamente');
                }
              } catch (error) {
                console.log(error);
                return false;
              }
            })();
          }
      });
    }

    ///////  eliminar de los select de obtener resolucion y enviar set de pruebas  ///////
    function deleteFromCompany(id:string){
      selectResolucioncompañia.querySelector(`option[value=${id}]`)?.remove();
      selectSetCompañia.querySelector(`option[value=${id}]`)?.remove();
    }


    ///////    Set compañia en los select    ///////
    function SetCompañiaToSelect(id:string, token:string, business_name:string){
      selectResolucioncompañia.insertAdjacentHTML('afterbegin', `<option data-token="" value="${id}" >${business_name}</option>`);
      selectSetCompañia.insertAdjacentHTML('afterbegin', `<option data-token="${token}" value="${id}" >${business_name}</option>`);
    }

    ///////    CONSULTAR RESOLUCIONES   ///////
    document.querySelector('#formGetResolucion')?.addEventListener('submit', (e:Event)=>{
      e.preventDefault();
      const id:string = selectResolucioncompañia.options[selectResolucioncompañia.selectedIndex].value;
      const oneC = companiesAll.find(x=>x.id == id)!;
      getResolutions(oneC.id, oneC.idsoftware, oneC.token);
    });

    async function getResolutions(idcompany:string, idsoftware:string, token:string){
      try {
        const url = "https://apidianj2.com/api/ubl2.1/numbering-range"; //llamado a la API REST Dian-laravel para consultar las resoluciones
        const respuesta = await fetch(url, {
                                              method: 'POST',
                                              headers: { "Accept": "application/json", "Content-Type": "application/json", "Authorization": "Bearer "+token },
                                              body: JSON.stringify({"IDSoftware": idsoftware})
                                            });
        const resultado = await respuesta.json();
        const arrayResolutions = resultado.ResponseDian.Envelope.Body.GetNumberingRangeResponse.GetNumberingRangeResult.ResponseList.NumberRangeResponse;
        if(arrayResolutions&&arrayResolutions.length>0)printResolutions(idcompany, arrayResolutions);
      } catch (error) {
        console.log(error);  
      }
    }

    function printResolutions(idcompany:string, arrayResolutions:NumberRangeItem[]){
      const tablaListResolutions = document.querySelector('#tablaListResolutions tbody') as HTMLTableElement;
      while(tablaListResolutions.firstChild)tablaListResolutions.removeChild(tablaListResolutions.firstChild);
      arrayResolutions.forEach(r =>{
        tablaListResolutions.insertAdjacentHTML('beforeend', 
          `<tr>
              <td class="px-4 py-2 border">${r.Prefix}</td>
              <td class="px-3 py-2 border">${r.ResolutionNumber}</td>
              <td class="px-3 py-2 border">${r.FromNumber} - ${r.ToNumber}</td>
              <td class="px-3 py-2 border">${r.ValidDateTo}</td>
              <td class="px-4 py-2 border text-2xl"><button class="downResolution" type="button" id="${r.ResolutionNumber} data-company="${idcompany}">⏬</button></td>
          </tr>`
        )
      });
      tablaListResolutions.addEventListener('click', e=> descargarResolucion(e, arrayResolutions) );
    }

    async function descargarResolucion(e:Event, arrayResolutions:NumberRangeItem[]){
      const target = e.target as HTMLButtonElement;
      if(target.classList.contains('downResolution')){
        const idcompany:string = target.dataset.idcompany!;
        const numberResolution = target.id;
        const resolutionSelected = arrayResolutions.find(x=>x.ResolutionNumber === numberResolution)!;
        resolutionSelected.idcompany = idcompany;
        try {
          const url = `/admin/api/guardarResolutionJ2`; //llamado a la API para guardar la resolucion DIAN
          const respuesta = await fetch(url,  { method: 'POST',
                                                headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                                body: JSON.stringify(resolutionSelected)
                                              });
          const resultado = await respuesta.json();
          if(resultado.exito != undefined){
            const existeResol:number = POS.facturadores.findIndex((x:any)=>x.id==resultado.facturador.id&&x.resolucion == resolutionSelected?.ResolutionNumber);
            if(existeResol === -1){ //si no existe consecutibo imprmir
              // actualizar el arreglo de facturador
              POS.facturadores.push(resultado.facturador); //= [...facturadores, resultado.facturador];
              //insertar en vista facturador
              const tablaFacturadores = ($('#tablaFacturadores') as any).DataTable(configdatatables);
              (tablaFacturadores as any).row.add([
                        (tablaFacturadores as any).rows().count() + 1,
                        resultado.facturador.nombre,
                        'ELECTRONICA',
                        resolutionSelected?.FromNumber+' - '+resolutionSelected?.ToNumber,
                        1,
                        resolutionSelected?.ValidDateTo,
                        'Activo',
                        `<div class="acciones-btns" id="${resultado.facturador.id}" data-facturador="${resultado.facturador.nombre}">
                            <button class="btn-md btn-turquoise editarFacturador"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-md btn-red eliminarFacturador"><i class="fa-solid fa-trash-can"></i></button>
                        </div>`
                    ]).draw(false);
              //insertar facturador en caja para seleccionar
              crearConsecutivoGestionCaja(resultado.facturador.id, resultado.facturador.nombre);
            }
          }
        } catch (error) {
          console.log(error);
        }
        miDialogoGetResolucion.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }//fin button
    }//fin funcion descargarResolucion

    function crearConsecutivoGestionCaja(idfacturador:string, nombre:string){
      const selectConsecutivoCaja = document.querySelector('#idtipoconsecutivo') as HTMLSelectElement;
      const option = document.createElement('option');
      option.value = idfacturador;
      option.textContent = nombre;
      selectConsecutivoCaja.appendChild(option);
    }


    ///////   ENVIAR SET DE PRUEBAS    ///////
    document.querySelector('#formSetPruebas')?.addEventListener('submit', async(e:Event)=>{
      e.preventDefault();
      const id = selectSetCompañia.options[selectSetCompañia.selectedIndex]?.value;
      const test = document.querySelector('#idsetpruebas') as HTMLInputElement;

      const oneC = companiesAll.find(x=>x.id == id)!;
      const token = oneC.token;

      const date = new Date().toISOString().split("T")[0];
      const number = 992500000 + (Math.floor(Math.random()*500000)+1);  //rango de 1 a 500000

      const factura = {
        prefix: "SETP",
        number, // dinámico
        type_document_id: "1",
        date,   // dinámico
        time: "00:00:01",
        resolution_number: "18760000001",
        sendmail: false,
        notes: "Factura Electrónica de pruebas Auto",
        payment_form: {
          payment_form_id: "1",
          payment_method_id: "10",
          payment_due_date: date,
          duration_measure: "0"
        },
        customer: {
          identification_number: "222222222222",
          name: "Consumidor Final",
          phone: null,
          address: null,
          type_document_identification_id: 3,
          type_organization_id: 1,
          municipality_id: null
        },
        invoice_lines: [
          {
            unit_measure_id: "70",
            invoiced_quantity: "1.00",
            line_extension_amount: "2000.00",
            free_of_charge_indicator: false,
            tax_totals: [
              {
                tax_id: 1,
                tax_amount: "0.00",
                taxable_amount: "2000.00",
                percent: "0"
              }
            ],
            description: "Producto Prueba",
            code: "155",
            type_item_identification_id: "4",
            price_amount: "2000.00",
            base_quantity: "1"
          }
        ],
        legal_monetary_totals: {
          line_extension_amount: "2000",
          tax_exclusive_amount: "2000",
          tax_inclusive_amount: "2000",
          allowance_total_amount: "0",
          charge_total_amount: "0",
          payable_amount: "2000"
        },
        tax_totals: [
          {
            tax_id: 1,
            tax_amount: "0.00",
            percent: "0",
            taxable_amount: "2000.00"
          }
        ]
      };

      try {
        const url = "https://apidianj2.com/api/ubl2.1/invoice/"+test.value; //llamado a la API REST Dianlaravel
        const respuesta = await fetch(url, {
                                              method: 'POST',
                                              headers: {
                                                "Accept": "application/json",
                                                "Content-Type": "application/json",
                                                "Authorization": "Bearer "+token
                                              },
                                              body: JSON.stringify(factura)
                                            });
        const resultado = await respuesta.json();
        console.log(resultado);
        miDialogosetpruebas.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        return resultado.success;
      } catch (error) {
        console.log(error);
        return false;
      }
    });
    

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
      if(event.target === miDialogoAdquirirCompañia || event.target === miDialogoCompañia || event.target === miDialogosetpruebas || event.target === miDialogoGetResolucion || (event.target as HTMLInputElement).value === 'Salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
        miDialogoAdquirirCompañia.close();  
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