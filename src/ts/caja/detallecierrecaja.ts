(():void=>{

  if(document.querySelector('.detallecierrecaja')){
    const btnImprimirDetalleCaja = document.querySelector('#btnImprimirDetalleCaja') as HTMLButtonElement;
    const btnVerCierreWeb = document.querySelector('#btnVerCierreWeb') as HTMLButtonElement;
    const btnVerCierreWs = document.querySelector('#btnVerCierreWs') as HTMLButtonElement;

    //capturar el id del cierre de caja por la url
    const parametrosURL = new URLSearchParams(window.location.search);
    const id:string = parametrosURL.get('id')??'';

    if(id==''||id==null||isNaN(Number(id)))return;

    ///////// imprimir detalle cierre
    btnImprimirDetalleCaja?.addEventListener('click', ()=>{
      if(id!=''){
          const ventana = window.open('/printdetallecierre?id='+id, '_blank');
          if(ventana){
              ventana.onload = ()=>{
                  ventana?.focus();
                  ventana?.print();
                  setTimeout(() => { ventana?.close(); }, 200); // Cerrar la ventana después de unos segundos
              };
          }
      }else{
        msjalertToast('error', '¡Error!', 'Error al generar detalle de cierre.');
      }
    });


    ///////// ver detalle cierre en web
    btnVerCierreWeb?.addEventListener('click', ()=>{
        const ventana = window.open('/printdetallecierre?id='+id, '_blank');
        if(ventana)ventana.onload = ()=>ventana?.focus();
    });


    ///////// ver detalle cierre en web
    btnVerCierreWs?.addEventListener('click', async()=>{
        const url = "/admin/api/ws/sendtextDetalleCierreCaja?id="+id; //llamado a la API REST para enviar detalle de cierre por ws
        try {
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json();
          if(resultado.code === 200 && !resultado.error){
            msjalertToast('success', '¡Éxito!', 'Mensaje detalle de cierre de caja enviado');
          }else{
            msjalertToast('error', '¡Error!', 'Error al enviar mensaje de cierre de caja');
          }
        } catch (error) {
          console.log(error);
        }
        
    });

  }

})();