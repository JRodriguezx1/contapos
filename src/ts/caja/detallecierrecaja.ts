(():void=>{

  if(document.querySelector('.detallecierrecaja')){
    const btnImprimirDetalleCaja = document.querySelector('#btnImprimirDetalleCaja') as HTMLButtonElement;
    const btnVerCierreWeb = document.querySelector('#btnVerCierreWeb') as HTMLButtonElement;

    //capturar el id del cierre de caja por la url
    const parametrosURL = new URLSearchParams(window.location.search);
    const id:string = parametrosURL.get('id')??'';
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
        //alerta
      }
    });

    if(id==''||id==null||isNaN(Number(id)))return;

    ///////// ver detalle cierre en web
    btnVerCierreWeb?.addEventListener('click', ()=>{
        const ventana = window.open('/printdetallecierre?id='+id, '_blank');
        if(ventana)ventana.onload = ()=>ventana?.focus();
    });


  }

})();