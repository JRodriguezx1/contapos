(()=>{
  if(document.querySelector('.creditos')){

    //const POS = (window as any).POS;
     
    const btnCrearCredito = document.querySelector('#btnCrearCredito') as HTMLButtonElement;
    const btnXCerrarModalCredito = document.querySelector('#btnXCerrarModalCredito') as HTMLButtonElement;
    const miDialogoCredito = document.querySelector('#miDialogoCredito') as any;
    const interes = document.querySelector('#interes') as HTMLSelectElement;
    const capital = (document.querySelector('#capital') as HTMLInputElement);
    const cantidadcuotas = (document.querySelector('#cantidadcuotas') as HTMLInputElement);
    
    let indiceFila=0, control=0, tablaCreditos:HTMLElement;


    type creditsapi = {
      id:string,
      id_fksucursal: string,
      factura_id: string,
      cliente_id: string,
      nombrecliente: string,
      capital: string,
      saldopendiente: string,
      cantidadcuotas: string,
      montocuota: string,
      frecuenciapago: string,
      fechainicio: string,
      interes: string,
      interesxcuota: string,
      interestotal: string,
      valorinteresxcuota: string,
      valorinterestotal: string,
      montototal: string,
      estado: string,
      created_at: string,
      //preciosadicionales: {id:string, idproductoid:string, precio:string, estado:string, created_at:string}[]
      //idservicios:{idempleado:string, idservicio:string}[]
    };
    
    interface Item {
      id_impuesto: number,
      facturaid: number,
      basegravable: number,
      valorimpuesto: number
    }
    let factimpuestos:Item[] = [];

    let credits:creditsapi[]=[], uncredito:creditsapi;
    const mapMediospago = new Map();


    (async ()=>{
      try {
          const url = "/admin/api/allcredits"; //llamado a la API REST y se trae todos los productos
          const respuesta = await fetch(url); 
          credits = await respuesta.json(); 
          console.log(credits);
      } catch (error) {
          console.log(error);
      }
    })();
    
    //////////////////  TABLA //////////////////////
    tablaCreditos = ($('#tablaCreditos') as any).DataTable(configdatatables);

    //btn para crear credito
    btnCrearCredito?.addEventListener('click', ():void=>{
      control = 0;
      miDialogoCredito.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
      ($('#cliente') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
      ($('#frecuenciapago') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
    });

    btnXCerrarModalCredito.addEventListener('click', (e)=>{
        miDialogoCredito.close();
        document.removeEventListener("click", cerrarDialogoExterno);
    });

    interes.addEventListener('change', e=>calculoTasaInteres());
    capital.addEventListener('input', e=>calculoTasaInteres());
    cantidadcuotas.addEventListener('input', e=>calculoTasaInteres());


    function calculoTasaInteres(){
      if(cantidadcuotas.value == '1' || (interes.value == '0' || interes.value == '')){
        (document.querySelector('#montocuota') as HTMLInputElement).value = capital.value;
        (document.querySelector('#interestotal') as HTMLInputElement).value = '0';
        (document.querySelector('#valorinteresxcuota') as HTMLInputElement).value = '0';
        (document.querySelector('#valorinterestotal') as HTMLInputElement).value = '0';
        (document.querySelector('#montototal') as HTMLInputElement).value = capital.value.toLocaleString();
      }
      if(cantidadcuotas.value !== '1'&&interes.value === '1'){
        const valorInteres = Number(capital.value)*0.02*Number(cantidadcuotas.value);
        const total = Number(capital.value) + valorInteres;
        const valorxcuota = Math.round(total/Number(cantidadcuotas.value));
        (document.querySelector('#montocuota') as HTMLInputElement).value = valorxcuota+'';
        (document.querySelector('#interestotal') as HTMLInputElement).value = 2*Number(cantidadcuotas.value)+'';
        (document.querySelector('#valorinteresxcuota') as HTMLInputElement).value = valorInteres/Number(cantidadcuotas.value)+'';
        (document.querySelector('#valorinterestotal') as HTMLInputElement).value = valorInteres.toLocaleString();
        (document.querySelector('#montototal') as HTMLInputElement).value = total.toLocaleString();
      }
    }


    //evento a la tabla
    document.querySelector('#tablaCreditos')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("editarCredito")||(e.target as HTMLElement).parentElement?.classList.contains("editarCredito"))editarCredito(e);
      //if(target?.classList.contains("bloquearProductos")||target.parentElement?.classList.contains("bloquearProductos"))bloquearProductos(e);
      //if(target?.classList.contains("eliminarProductos")||target.parentElement?.classList.contains("eliminarProductos"))eliminarProductos(e);
    });

    function editarCredito(e:Event){
      let idcredito = (e.target as HTMLElement).parentElement?.id!;
      if((e.target as HTMLElement)?.tagName === 'I')idcredito = (e.target as HTMLElement).parentElement?.parentElement?.id!;
      control = 1;
      document.querySelector('#modalCredito')!.textContent = "Actualizar credito";
      (document.querySelector('#btnEditarCrearCredito') as HTMLInputElement)!.value = "Actualizar";
      uncredito = credits.find(x=>x.id === idcredito)!; //obtengo el producto.
      $('#cliente').val(uncredito?.cliente_id??'');
      (document.querySelector('#capital')as HTMLInputElement).value = uncredito?.capital!;
      $('#interes').val(uncredito?.interes??'0');  //0 = No,  1 = Si
      (document.querySelector('#cantidadcuotas')as HTMLInputElement).value = uncredito?.cantidadcuotas!;
      (document.querySelector('#montocuota')as HTMLInputElement).value = uncredito?.montocuota!;
      $('#frecuenciapago').val(uncredito?.frecuenciapago??'10');  //0 = simple,  1 = compuesto
      //indiceFila = (tablaProductos as any).row((e.target as HTMLElement).closest('tr')).index();
      miDialogoCredito.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
      ($('#cliente') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
      ($('#frecuenciapago') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
    }


    ////////////////////  Actualizar/Editar CREDITO  //////////////////////
    document.querySelector('#formCrearUpdateCredito')?.addEventListener('submit', e=>{

      if(control){
        e.preventDefault();
        var info = (tablaCreditos as any).page.info();
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', uncredito!.id);
          datos.append('cliente_id', $('#cliente').val()as string);
          //datos.append('nombre', $('#nombre').val()as string);
          datos.append('capital', $('#capital').val()as string); 
          datos.append('interes', $('#interes').val()as string);
          datos.append('cantidadcuotas', $('#cantidadcuotas').val()as string);
          datos.append('montocuota', $('#montocuota').val()as string);
          datos.append('frecuenciapago', $('#frecuenciapago').val()as string);
          datos.append('tasainteres', '0');
          try {
              const url = "/admin/api/actualizarCredito";
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json(); 
              console.log(resultado); 
              if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                /// actualizar el arregle de creditos ///
                credits.forEach(a=>{if(a.id == uncredito.id)a = Object.assign(a, resultado.credito[0]);});
                ///////// cambiar la fila completa, su contenido //////////
                const datosActuales = (tablaCreditos as any).row(indiceFila).data();
                
                /*CLIENTE*/datosActuales[2] ='<div class="w-80 whitespace-normal">'+$('#nombre').val()+'</div>';
                /*capital*/datosActuales[3] = $('#categoria option:selected').text();
                /*DEUDA*/datosActuales[4] = '';
                /*ABONOTOTAL*/datosActuales[5] = $('#sku').val();
                
                (tablaCreditos as any).row(indiceFila).data(datosActuales).draw();
                (tablaCreditos as any).page(info.page).draw('page'); //me mantiene la pagina actual
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
              miDialogoCredito.close();
              document.removeEventListener("click", cerrarDialogoExterno);
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
      } //fin if(control)
    });



    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoCredito || (event.target as HTMLInputElement).value === 'salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
        miDialogoCredito.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }


  }

})();