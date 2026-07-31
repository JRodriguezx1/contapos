(()=>{
    if(document.querySelector('.creditosAnulados')){
        let tablaCreditosAnulados:HTMLElement;
        tablaCreditosAnulados = ($('#tablaCreditosAnulados') as any).DataTable(configdatatablesgenerico);
    }
    if(document.querySelector('.creditosFinalizados')){
        let tablaCreditosFinalizados:HTMLElement;
        tablaCreditosFinalizados = ($('#tablaCreditosFinalizados') as any).DataTable(configdatatablesgenerico);
    }

})();