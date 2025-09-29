(():void=>{

  if(document.querySelector('.detallecierrecaja')){
    const btnImprimirDetalleCaja = document.querySelector('#btnImprimirDetalleCaja') as HTMLButtonElement;

    //capturar el id del cierre de caja por la url
    const parametrosURL = new URLSearchParams(window.location.search);
    const id = parametrosURL.get('id');
    ///////// imprimir detalle cierre
    btnImprimirDetalleCaja?.addEventListener('click', ()=>{
        const ventana = window.open('/printdetallecierre?id=1', '_blank');
        if(ventana){
            ventana.onload = ()=>{
                ventana?.focus();
                ventana?.print();
                setTimeout(() => { ventana?.close(); }, 200); // Cerrar la ventana después de unos segundos
            };
        }
    });


  }

})();