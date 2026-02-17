(()=>{
  if(document.querySelector('.detallecredito')){

     
    const btnajustarCredito = document.querySelector('#ajustarCredito') as HTMLButtonElement;
    const btnDetalleProductos = document.querySelector('#btnDetalleProductos') as HTMLButtonElement;
    const btnAbonar = document.querySelector('#btnAbonar') as HTMLButtonElement;
    const btnEditarCrearAbono = document.querySelector('#btnEditarCrearAbono') as HTMLInputElement;
    const btnEditarCrearPagoTotal = document.querySelector('#btnEditarCrearPagoTotal') as HTMLInputElement;
    const btnPagarTodo = document.querySelector('#btnPagarTodo') as HTMLButtonElement;
    const miDialogoAjustarCredito = document.querySelector('#miDialogoAjustarCredito') as any;
    const miDialogoAbono = document.querySelector('#miDialogoAbono') as any;
    const miDialogoPagoTotal = document.querySelector('#miDialogoPagoTotal') as any;
    const miDialogoDetalleProducto = document.querySelector('#miDialogoDetalleProducto') as any;
    const modalcambioMedioPago:any = document.querySelector("#cambioMedioPago");
    //const pagarTodo = document.querySelector('#pagarTodo') as HTMLButtonElement;
    const totalPagado = document.querySelector('#totalPagado') as HTMLSpanElement;
    const numCuota = document.querySelector('#numCuota') as HTMLLabelElement;
    const selectMediopago = document.querySelector('#selectMediopago') as HTMLSelectElement;
    const inputDescuentoAjustarCredito = document.querySelector('#inputDescuentoAjustarCredito') as HTMLInputElement;
    let contentMP:HTMLButtonElement, idcuota:string = '0', idcredito:string = '0', totalpagado:string = '0', idmediopago:string = '0', mediopagado:string = '0';
    
    let indiceFila=0, tablacuotas:HTMLElement;

    interface clavesApi {
      clave:string,
      valor_default:string|null,
      valor_final:string|null,
      valor_local:string|null
    };

    let clavedcto:clavesApi[];

    (async ()=>{
      try {
          const url = "/admin/api/getPasswords"; //llamado a la API REST
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          clavedcto = resultado;
      } catch (error) {
          console.log(error);
      }
    })();

    
    document.addEventListener("click", cerrarDialogoExterno);
     
    //////////////////  TABLA //////////////////////
    tablacuotas = ($('#tablacuotas') as any).DataTable(configdatatables);


    btnajustarCredito?.addEventListener('click', ():void=>{
      miDialogoAjustarCredito.showModal();
    });

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


    btnEditarCrearAbono.addEventListener('click', ()=>{
      btnEditarCrearAbono.disabled = true;
      (document.querySelector('#formCrearUpdateAbono') as HTMLFormElement).submit();
    });
    btnEditarCrearPagoTotal.addEventListener('click', ()=>{
      btnEditarCrearPagoTotal.disabled = true;
      (document.querySelector('#formCrearUpdatePagoTotal') as HTMLFormElement).submit();
    });
    

    const saldopendiente = (document.querySelector('#saldopendiente') as HTMLInputElement).value;
    document.querySelector('#abonoTotalAntiguo')?.addEventListener("input", (e:Event)=>{
      const abonoTotalAntiguo = (e.target as HTMLInputElement);
      if(Number(abonoTotalAntiguo.value)>Number(saldopendiente))abonoTotalAntiguo.value = '';
    });

    ////////////// Evento a la tabla cuotas ///////////////
    document.querySelector('#tablacuotas')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLButtonElement;
      if(target?.classList.contains("mediosdepago")||target.parentElement?.classList.contains("mediosdepago"))cambiomediopago(target);
      if(target?.classList.contains("printPOSAbono"))printPOSComprobanteAbono(target.id);
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



    document.querySelector('#formCrearUpdateAjustarCredito')?.addEventListener('submit', e=>{
      e.preventDefault();
      const v:number = validarPasswordDcto();
      if(!v)return;
      ajustarCreditoAntiguo();
    });

    function validarPasswordDcto():number{
      const clave = clavedcto.find(c => c.clave=='clave_para_ajustar_credito');
      if(clave?.valor_final!==null && inputDescuentoAjustarCredito.value !== clave?.valor_final){
        msjAlert('error', 'El password es invalido', (document.querySelector('#divmsjalertaClaveAjustarCredito') as HTMLElement));
        return 0;
      }
      return 1;
    }


    async function ajustarCreditoAntiguo(){
      const id:string = (document.querySelector('#idcredito') as HTMLInputElement).value;
      const abonototalantiguo = (document.querySelector('#abonoTotalAntiguo') as HTMLInputElement).value||'0';
      const recargo = (document.querySelector('#recargo') as HTMLInputElement).value||'0';
      const datos = new FormData();
      datos.append('id', id);
      datos.append('recargo', recargo);
      datos.append('abonototalantiguo', abonototalantiguo);
      try {
          const url = "/admin/api/ajustarCreditoAntiguo";  //va al controlador creditoscontrolador
          const respuesta = await fetch(url, {method: 'POST', body: datos}); 
          const resultado = await respuesta.json();
          if(resultado.exito !== undefined){
            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            ajustarIndicadores(abonototalantiguo, recargo);
          }else{
            msjalertToast('error', '¡Error!', resultado.error[0]);
          }
      } catch (error) {
          console.log(error);
      }
      miDialogoAjustarCredito.close();
    }


    function ajustarIndicadores(abonototalantiguo:string, recargo:string){
      const capital:number = Number((document.querySelector('#capital') as HTMLInputElement).value);
      const abonoinicial:number = Number((document.querySelector('#abonoinicial') as HTMLInputElement).value);
      const montototal:number = Number((document.querySelector('#montototal') as HTMLInputElement).value);
      const saldopendiente:number = Number((document.querySelector('#saldopendiente') as HTMLInputElement).value);
      document.querySelector('#abonoInicialText')!.textContent = '$ '+abonototalantiguo;
      document.querySelector('#interesText')!.textContent = '$ '+recargo;
      document.querySelector('#creditoTotalText')!.textContent = '$ '+(capital - abonoinicial + Number(recargo)).toLocaleString();
      document.querySelector('#saldopendientetext')!.textContent = '$ '+(capital+Number(recargo)-abonoinicial-Number(abonototalantiguo)).toLocaleString();
    }

    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      if (f=== miDialogoAjustarCredito || f === miDialogoAbono || f === miDialogoDetalleProducto || f === modalcambioMedioPago || (f as HTMLInputElement).value === 'salir' || (f as HTMLInputElement).value === 'Cancelar' 
          || (f as HTMLButtonElement).id == 'btnXCerrarModalDetalleProducto' || (f as HTMLButtonElement).id == 'btnXCerrarModalAbono' || f === miDialogoPagoTotal
          || (f as HTMLButtonElement).id == 'btnXCerrarModalPagoTotal' ) {
        miDialogoAbono.close();
        miDialogoPagoTotal.close();
        miDialogoDetalleProducto.close();
        modalcambioMedioPago.close();
        miDialogoAjustarCredito.close();
      }
    }


    function printPOSComprobanteAbono(idabono:string){
      if(!isNaN(Number(idabono)))
        window.open("/admin/printPDFAbonoCredito?id=" + idabono, "_blank"); //controlador printcontrolador
    }

  }

})();