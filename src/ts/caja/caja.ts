(():void=>{
  if(document.querySelector('.caja')){
    const modalGastosIngresos:any = document.querySelector("#gastosIngresos");
    const modalcambioMedioPago:any = document.querySelector("#cambioMedioPago");
    const btnGastosingresos = document.querySelector<HTMLButtonElement>("#btnGastosingresos");
    const operacion = document.querySelector('#operacion') as HTMLSelectElement;
    const mediosPago = document.querySelectorAll<HTMLInputElement>('.mediopago');
    const totalPagado = document.querySelector('#totalPagado') as HTMLSpanElement;
    const numfactura = document.querySelector('#numfactura') as HTMLLabelElement;

    let tablaListaPedidos:HTMLElement;
    let estadofactura:string, contentMP:HTMLElement, idfactura:string = '0';
    let mediospagoDB:{id:string, idmediopago:string, id_factura:string, valor:string}[];
    let nuevosMediosPago:{idmediopago:string, valor: string}[]=[];  // guardar los medios de pago a enviar a backend
    const setMediosPagoDB = new Set();

    tablaListaPedidos = ($('#tablaListaPedidos') as any).DataTable(configdatatables);

    //////// clic al btn gastos/ingresos
    btnGastosingresos?.addEventListener('click', ():void=>{
      modalGastosIngresos.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });


    ///////// cambio de tipo de operacion si ingreso o gasto, si es gasto habilita el select de los tipos de gastos
    operacion?.addEventListener('change', (e:Event)=>{
      const targetDom = e.target as HTMLSelectElement;
      const tipodegasto = document.querySelector('.tipodegasto') as HTMLElement;

      if(targetDom.value == 'gasto'){
        tipodegasto.style.display = 'flex';
        document.querySelector('#tipodegasto')?.setAttribute("required", "");
      }
      else{
        tipodegasto.style.display = 'none';
        document.querySelector('#tipodegasto')?.removeAttribute("required");
      }
    });


    ////////////// Evento a la tabla lista de pedidos ///////////////
    document.querySelector('#tablaListaPedidos')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("mediosdepago")||target.parentElement?.classList.contains("mediosdepago"))cambiomediopago(target);
    });


    //////////// Modal para el cambio de medio de pago ////////////
    function cambiomediopago(target:HTMLElement){
      idfactura = target.id;
      contentMP = target;
      estadofactura = target.dataset.estado??'';
      totalPagado.textContent = Number(target.dataset.totalpagado??'0').toLocaleString();
      if(target.tagName == "BUTTON"){
        idfactura = target.parentElement!.id;
        contentMP = target.parentElement!;
        estadofactura = target.parentElement?.dataset.estado??'';
        totalPagado.textContent = Number(target.parentElement!.dataset.totalpagado??'0').toLocaleString();
      }
      facturamediospago();     //muetra los valores de los medios de pago de cada factura
      if(estadofactura == "Eliminada")document.querySelector('#btnEnviarCambioMedioPago')?.classList.add('!hidden');
      if(estadofactura == "Paga")document.querySelector('#btnEnviarCambioMedioPago')?.classList.remove('!hidden');
      modalcambioMedioPago.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    function facturamediospago(){  //muetra los valores de los medios de pago de cada factura
      numfactura.textContent = 'Factura N° : '+idfactura;
      (async ()=>{
        try {
          const url = "/admin/api/mediospagoXfactura?id="+idfactura; //llamado a la API REST y se trae los medios de pago segun factura
          const respuesta = await fetch(url); 
          mediospagoDB = await respuesta.json(); 
          console.log(mediospagoDB);
          //const setMediosPagoDB = new Set(mediospagoDB.map(x=>x.idmediopago));
          //console.log(setMediosPagoDB);
          mediospagoDB.forEach(x => setMediosPagoDB.add(x.idmediopago));//se llena el set con los medios de pago de la DB
          mediosPago.forEach(mediopago =>{  //se llena los inputs medios de pago con los medios de pago de la DB
            mediopago.value = '0';
            for(let i=0; i<mediospagoDB.length; i++)
              if(mediopago.id == mediospagoDB[i].idmediopago){
                mediopago.value =  mediospagoDB[i].valor;
                break;
              }
          });
        } catch (error) {
            console.log(error);
        }
      })();
    }

    ////////////////// evento al bton pagar del modal facturar //////////////////////
    document.querySelector('#formCambioMedioPago')?.addEventListener('submit', e=>{
      e.preventDefault();
      let totalotrosmedios = 0;
      nuevosMediosPago.length = 0;
      mediosPago.forEach((item, index)=>{ 
        totalotrosmedios += parseInt((item as HTMLInputElement).value.replace(/[,.]/g, '')); //sumar todos los medios de pago de los inputs
        if(item.value != '0')
          nuevosMediosPago = [...nuevosMediosPago, {idmediopago: item.id, valor: item.value.replace(/[,.]/g, '')}];  //obtengo los nuevos medios de pago difente a cero
      });

      if(totalotrosmedios != parseInt(totalPagado.textContent!.replace(/[,.]/g, ''))){
        msjAlert('error', 'Valor diferente al pagado', (document.querySelector('#divmsjalerta2') as HTMLElement));
        return;
      }
      actualizarMediosPago();
    });


    async function actualizarMediosPago(){
      const setNuevosMediosPago = new Set(nuevosMediosPago.map(x=>x.idmediopago));
      ////cruzar los datos de los medios de pago de la DB y de los nuevos medios de pago////
      //////// medios de pago iguales o compartidos ///////////
      const mediospagocompartidos = mediospagoDB.filter(x=>setNuevosMediosPago.has(x.idmediopago));
      //////// nuevos medios de pago que no estan en DB, crear o agregar
      const nuevosMediosPagoNoEnDB = nuevosMediosPago.filter(x=>!setMediosPagoDB.has(x.idmediopago));
      //////// medios de pago de la DB que no estan en los nuevos medios de pago, eliminar
      const mediosPagoDBNoEnNuevos = mediospagoDB.filter(x=>!setNuevosMediosPago.has(x.idmediopago));

      const datos = new FormData();
      datos.append('id_factura', idfactura);
      datos.append('efectivoDB', mediospagoDB.find(x=>x.idmediopago=='1')?.valor??'0'+'');
      datos.append('nuevoEfectivo', nuevosMediosPago.find(x=>x.idmediopago=='1')?.valor??'0'+'');
      datos.append('mediospagocompartidos', JSON.stringify(mediospagocompartidos));
      datos.append('nuevosMediosPagoNoEnDB', JSON.stringify(nuevosMediosPagoNoEnDB));
      datos.append('mediosPagoDBNoEnNuevos', JSON.stringify(mediosPagoDBNoEnNuevos));
      datos.append('nuevosMediosPago', JSON.stringify(nuevosMediosPago));  
      try {
          const url = "/admin/api/cambioMedioPago";  //va al controlador ventascontrolador
          const respuesta = await fetch(url, {method: 'POST', body: datos}); 
          const resultado = await respuesta.json();
          if(resultado.exito !== undefined){
            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            updateMP(resultado.mediosPagoUpdate);
          }else{
            msjalertToast('error', '¡Error!', resultado.error[0]);
          }
      } catch (error) {
          console.log(error);
      }
      modalcambioMedioPago.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    }

    function updateMP(mediosPagoUpdate:{id:string, idmediopago:string, id_factura:string, valor:string, mediopago:string}[]){
      while(contentMP.firstChild)contentMP.removeChild(contentMP.firstChild);
      mediosPagoUpdate.forEach(btnMP=>{
        const button = document.createElement('button');
        button.classList.add('btn-xs', 'btn-light', 'mr-2');
        button.textContent = btnMP.mediopago;
        contentMP.appendChild(button);
      });
    }

    function cerrarDialogoExterno(event:Event) {
      if (event.target === modalGastosIngresos || event.target === modalcambioMedioPago || (event.target as HTMLInputElement).value === 'cancelar') {
          modalGastosIngresos.close();
          modalcambioMedioPago.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }
  }

})();