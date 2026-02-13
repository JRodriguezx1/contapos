(()=>{

    if(!document.querySelector('.cuotasCreditos'))return;

    const POS = (window as any).POS;

    const tablaCuotasCreditos = ($('#tablaCuotasCreditos') as any);

    interface i_creditosSeparados {
        idestadocreditos:string,
        estado:string
        carteraTotal:string,
        carteraXCobrar:string,
        totalAbonado:string,
        total:string,
    }

    let creditosSeparados:i_creditosSeparados[] = [];

    //tablaProductosVendidos.DataTable(configdatatables25reg);


    async function callApiReporte(dateinicio:string, datefin:string){
        console.log(dateinicio, datefin);
        
        (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
        const datos = new FormData();
        datos.append('fechainicio', dateinicio);
        datos.append('fechafin', datefin+' 23:59:59');
        try {
            const url = "/admin/api/reportes/creditos/cuotasCreditos"; //llama a la api que esta en reportescontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            console.log(resultado);
            //printCreditosSeparados();
           (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
        } catch (error) {
            console.log(error);
        }
    }

    

    printCreditosSeparados();
    function printCreditosSeparados(){
        tablaCuotasCreditos.DataTable({
            destroy: true, // importante si recargas la tabla
            data: creditosSeparados,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {
                            title: 'Fecha', 
                            data: 'estado', 
                            render: (data: any, type: any, row: any) => {return `<button class="btn-xs ${row.estado=='Abierto'?'btn-blue':row.estado=='Finalizado'?'btn-lima':'btn-light'}">${row.estado}</button>`}
                        },
                        {title: 'Cliente', data: 'carteraTotal', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Credito', data: 'carteraXCobrar', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'N°', data: 'totalAbonado', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Valor', data: 'Valor'}
                    ],
        });
    }


    POS.callApiReporte = callApiReporte;

})();