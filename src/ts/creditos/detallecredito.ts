(()=>{
  if(document.querySelector('.detallecredito')){

    //const POS = (window as any).POS;
     
    const btnDetalleProductos = document.querySelector('#btnDetalleProductos') as HTMLButtonElement;
    const btnAbonar = document.querySelector('#btnAbonar') as HTMLButtonElement;
    const btnPagarTodo = document.querySelector('#btnPagarTodo') as HTMLButtonElement;
    const miDialogoAbono = document.querySelector('#miDialogoAbono') as any;
    const miDialogoPagoTotal = document.querySelector('#miDialogoPagoTotal') as any;
    const miDialogoDetalleProducto = document.querySelector('#miDialogoDetalleProducto') as any;
    const modalcambioMedioPago:any = document.querySelector("#cambioMedioPago");
    const pagarTodo = document.querySelector('#pagarTodo') as HTMLButtonElement;
    const totalPagado = document.querySelector('#totalPagado') as HTMLSpanElement;
    const numCuota = document.querySelector('#numCuota') as HTMLLabelElement;
    const selectMediopago = document.querySelector('#selectMediopago') as HTMLSelectElement;
    let contentMP:HTMLButtonElement, idcuota:string = '0', idcredito:string = '0', totalpagado:string = '0', idmediopago:string = '0', mediopagado:string = '0';
    
    let indiceFila=0, tablacuotas:HTMLElement;

    
    document.addEventListener("click", cerrarDialogoExterno);
     
    //////////////////  TABLA //////////////////////
    tablacuotas = ($('#tablacuotas') as any).DataTable(configdatatables);



    btnDetalleProductos?.addEventListener('click', ():void=>{
      miDialogoDetalleProducto.showModal();
    });

    //btn para abonar credito
    btnAbonar?.addEventListener('click', ():void=>{
      miDialogoAbono.showModal();
    });

    //btn para abonar credito
    btnPagarTodo?.addEventListener('click', ():void=>{
      miDialogoPagoTotal.showModal();
    });


    ////////////// Evento a la tabla lista de pedidos ///////////////
    document.querySelector('#tablacuotas')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLButtonElement;
      if(target?.classList.contains("mediosdepago")||target.parentElement?.classList.contains("mediosdepago"))cambiomediopago(target);
      
    });


    function cambiomediopago(target:HTMLButtonElement){
      document.querySelector('#textMP')!.textContent = 'Pago por '+target.textContent+': ';
      idcuota = target.id;
      totalpagado = target.dataset.totalpagado??'0';
      idcredito = target.dataset.idcredito??'0';
      idmediopago = target.dataset.idmediopago??'0';
      mediopagado = target.dataset.mediopagado??'0';
      contentMP = target;
      totalPagado.textContent = '$ '+Number(mediopagado).toLocaleString();
      numCuota.textContent = 'Credito N° : '+idcredito;
      selectMediopago.value = idmediopago;
      modalcambioMedioPago.showModal();
    }


    document.querySelector('#formCambioMedioPago')?.addEventListener('submit', e=>{
      e.preventDefault();
      let totalotrosmedios = 0;
      
      actualizarMediosPago();
    });


    async function actualizarMediosPago(){
      const datos = new FormData();
      datos.append('id', idcuota);
      datos.append('idmediopago', idmediopago);
      datos.append('id_credito', idcredito);
      datos.append('idnuevomediopago', selectMediopago.value);
      datos.append('valor', mediopagado);
      try {
          const url = "/admin/api/cuota/cambioMedioPagoSeparado";  //va al controlador creditoscontrolador
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
    }


    function updateMP(mediosPagoUpdate:{id:string, idcuota:string, mediopago_id:string, valor:string}){
      const {mediopago_id} = mediosPagoUpdate;
      contentMP.textContent = selectMediopago.options[selectMediopago.selectedIndex].textContent;
      contentMP.dataset.idmediopago = mediopago_id;
    }


    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      if (f === miDialogoAbono || f === miDialogoDetalleProducto || f === modalcambioMedioPago || (f as HTMLInputElement).value === 'salir' || (f as HTMLInputElement).value === 'Cancelar' 
          || (f as HTMLButtonElement).id == 'btnXCerrarModalDetalleProducto' || (f as HTMLButtonElement).id == 'btnXCerrarModalAbono' || f === miDialogoPagoTotal
          || (f as HTMLButtonElement).id == 'btnXCerrarModalPagoTotal' ) {
        miDialogoAbono.close();
        miDialogoPagoTotal.close();
        miDialogoDetalleProducto.close();
        modalcambioMedioPago.close();
      }
    }


  }

})();