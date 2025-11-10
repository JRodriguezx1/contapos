(()=>{
    if(!document.querySelector('.gestionDian'))return;
    const POS = (window as any).POS;

    const selectResolucioncompañia = document.querySelector('#selectResolucioncompañia') as HTMLSelectElement;
    const miDialogoGetResolucion = document.querySelector('#miDialogoGetResolucion') as any;

    ///////    CONSULTAR RESOLUCIONES   ///////
    document.querySelector('#formGetResolucion')?.addEventListener('submit', (e:Event)=>{
      e.preventDefault();
      const id:string = selectResolucioncompañia.options[selectResolucioncompañia.selectedIndex].value;
      const companiesAll = POS.companiesAll as companiesDian[];
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
        if(arrayResolutions&&arrayResolutions.length>0)printResolutions(idcompany, arrayResolutions, token);
      } catch (error) {
        console.log(error);  
      }
    }

    function printResolutions(idcompany:string, arrayResolutions:NumberRangeItem[], token:string){
      const tablaListResolutions = document.querySelector('#tablaListResolutions tbody') as HTMLTableElement;
      while(tablaListResolutions.firstChild)tablaListResolutions.removeChild(tablaListResolutions.firstChild);
      arrayResolutions.forEach(r =>{
        tablaListResolutions.insertAdjacentHTML('beforeend', 
          `<tr>
              <td class="px-4 py-2 border">${r.Prefix}</td>
              <td class="px-3 py-2 border">${r.ResolutionNumber}</td>
              <td class="px-3 py-2 border">${r.FromNumber} - ${r.ToNumber}</td>
              <td class="px-3 py-2 border">${r.ValidDateTo}</td>
              <td class="px-4 py-2 border text-2xl"><button class="downResolution" type="button" id="${r.ResolutionNumber}" data-company="${idcompany}">⏬</button></td>
          </tr>`
        )
      });
      tablaListResolutions.addEventListener('click', e=> descargarResolucion(e, arrayResolutions, token) );
    }


    async function descargarResolucion(e:Event, arrayResolutions:NumberRangeItem[], token:string){
      const target = e.target as HTMLButtonElement;
      if(target.classList.contains('downResolution')){
        const idcompany:string = target.dataset.idcompany!;
        const numberResolution = target.id;
        const resolutionSelected = arrayResolutions.find(x=>x.ResolutionNumber === numberResolution)!;
        resolutionSelected.idcompany = idcompany;
        (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
        try {
          const url = `/admin/api/guardarResolutionJ2`; //llamado a la API para guardar la resolucion DIAN
          const respuesta = await fetch(url,  { method: 'POST',
                                                headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                                body: JSON.stringify(resolutionSelected)
                                              });
          const resultado = await respuesta.json();

          //almacenar la resolucion obtenido de la dian en la API 
          const resolucion = {
                  type_document_id:'1', 
                  prefix: resolutionSelected.Prefix, 
                  resolution: resolutionSelected.ResolutionNumber, 
                  resolution_date: resolutionSelected.ResolutionDate, 
                  technical_key: typeof resolutionSelected.TechnicalKey === 'string'?resolutionSelected.TechnicalKey:'', 
                  from: resolutionSelected.FromNumber, 
                  to: resolutionSelected.ToNumber, 
                  generated_to_date:'0', 
                  date_from: resolutionSelected.ValidDateFrom, 
                  date_to: resolutionSelected.ValidDateTo
              };
          const sendresolToAPI = await POS.crearResolucion(resolucion, token);

          (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";

          console.log(sendresolToAPI);
          if(sendresolToAPI)msjalertToast('success', '¡Éxito!', 'Resoluccion asociada exitosamnete.');


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
        document.removeEventListener("click", POS.cerrarDialogoExterno);
      }//fin button
    }//fin funcion descargarResolucion

    
    function crearConsecutivoGestionCaja(idfacturador:string, nombre:string){
      const selectConsecutivoCaja = document.querySelector('#idtipoconsecutivo') as HTMLSelectElement;
      const option = document.createElement('option');
      option.value = idfacturador;
      option.textContent = nombre;
      selectConsecutivoCaja.appendChild(option);
    }

    const gestionarGetResolutions = {  //objeto a exportar
        miDialogoGetResolucion,
        selectResolucioncompañia,
    };

    POS.gestionarGetResolutions = gestionarGetResolutions;

})();