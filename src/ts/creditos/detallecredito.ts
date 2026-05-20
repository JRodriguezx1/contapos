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
    const inputPasswordAjustarCredito = document.querySelector('#inputPasswordAjustarCredito') as HTMLInputElement;
    let contentMP:HTMLButtonElement, idcuota:string = '0', idcredito:string = '0', totalpagado:string = '0', idmediopago:string = '0', mediopagado:string = '0';
    
    let printerBT:string = getParam.impresora_principal_de_CAJA_para_Android_por_BT.valor_final;
    let indiceFila=0, tablacuotas:HTMLElement;

    interface clavesApi {
      clave:string,
      valor_default:string|null,
      valor_final:string|null,
      valor_local:string|null
    };

    let password:clavesApi[];

    (async ()=>{
      try {
          const url = "/admin/api/getPasswords"; //llamado a la API REST
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          password = resultado;
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
    document.querySelector('#tablacuotas')?.addEventListener("click", (e:Event)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLButtonElement;
      if(target?.classList.contains("mediosdepago")||target.parentElement?.classList.contains("mediosdepago"))cambiomediopago(target);
      if(target?.classList.contains("anularAbono"))anularAbono(target);
      if(target?.classList.contains("printPOSAbono"))printPOSComprobanteAbono(target.parentElement?.id);
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



    document.querySelector('#formAjustarCredito')?.addEventListener('submit', e=>{
      e.preventDefault();
      const v:number = validarPasswordDcto();
      if(!v)return;
      ajustarCreditoAntiguo();
    });

    function validarPasswordDcto():number{
      const clave = password.find(c => c.clave=='clave_para_ajustar_credito');
      if(inputPasswordAjustarCredito && clave?.valor_final!==null && inputPasswordAjustarCredito.value !== clave?.valor_final){
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
      datos.append('fechainicio', (document.querySelector('#ajustarFechaInicio') as HTMLInputElement).value);
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
          || (f as HTMLElement).id == 'btnXCerrarModalDetalleProducto' || (f as HTMLElement).id == 'btnXCerrarModalAbono' || f === miDialogoPagoTotal
          || (f as HTMLElement).id == 'btnXCerrarModalPagoTotal' ) {
        miDialogoAbono.close();
        miDialogoPagoTotal.close();
        miDialogoDetalleProducto.close();
        modalcambioMedioPago.close();
        miDialogoAjustarCredito.close();
      }
    }


    function anularAbono(target: HTMLButtonElement){
      const idabono = target.parentElement?.id;
      const fila = target.closest('tr');
      if(idabono==undefined)return;
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea anular el abono registrado',
          text: "El abono, seran anulado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  try {
                      const url = "/admin/api/creditos/anularAbono?id="+idabono;
                      const respuesta = await fetch(url); 
                      const resultado = await respuesta.json();
                      if(resultado.exito !== undefined){
                        fila?.remove();
                        Swal.fire(resultado.exito[0], '', 'success');
                      }else{
                          Swal.fire(resultado.error[0], '', 'error');
                      }
                  } catch (error) {
                      console.log(error);
                  }
              })();//cierre de async()
          }
      });
    }


    async function printPOSComprobanteAbono(idabono:string|undefined){
      if(idabono==undefined)return;
      try{
        const url = "/admin/api/creditos/getAbono?id="+idabono; //llamado a la API REST - creditocontrolador 
        const respuesta = await fetch(url); 
        const resultado = await respuesta.json();
        const isAndroid = /Android/i.test(navigator.userAgent);
        if(printerBT === '1'){
          const builder = new ticketAbonoBuilder(resultado);
          const ticket = await builder.generate(true); //true para version buffer bytes
          const base64 = bytesToBase64(ticket);
          if(isAndroid)window.location.href = `rawbt:base64,${base64}`;
          //descargar .bin a equipo
          /*const blob = new Blob([ticket], { type: 'application/octet-stream' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'ticket.bin';
          a.click();
          URL.revokeObjectURL(url);*/
        }
      }catch(error){
        console.log(error);
      }

      if(!isNaN(Number(idabono)))
        window.open("/admin/printPDFAbonoCredito?id=" + idabono, "_blank"); //controlador printcontrolador
    }
  }

})();