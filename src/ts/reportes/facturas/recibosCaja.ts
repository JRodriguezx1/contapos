(()=>{
    if(!document.querySelector('.recibosCaja'))return;

    const POS = (window as any).POS;

    const tablaRecibosCaja = ($('#tablaRecibosCaja') as any);

    interface i_ingresosEmisores {
        num_orden:string,
        fechapagada:string,
        concepto:string,
        documento:string,
        cliente:string,
        mediopago:string,
        detalle:string,
        cajero:string,
        valorpagado:string,
        emisor:string
    }



    let ingresosEmisores:i_ingresosEmisores[] = [];



    async function callApiReporte(dateinicio:string, datefin:string){
        document.querySelector('#fecha1')!.textContent = dateinicio;
        document.querySelector('#fecha2')!.textContent = datefin;
        (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
        const datos = new FormData();
        datos.append('fechainicio', dateinicio);
        datos.append('fechafin', datefin+' 23:59:59');
        try {
            const url = "/admin/api/reportes/recibosCaja"; //llama a la api que esta en reportescontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            ingresosEmisores = resultado.ingresos;
            reporteRecibosCaja();
           (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
        } catch (error) {
            console.log(error);
        }
    }

    
    reporteRecibosCaja();
    function reporteRecibosCaja(){
        tablaRecibosCaja.DataTable({
            destroy: true, // importante si recargas la tabla
            data: ingresosEmisores,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Num', data: 'num_orden', render: (data:string) => `<div class="w-48 whitespace-normal">${data}</div>`},
                        {title: 'Fecha', data: 'fechapagada'},
                        {title: 'Concepto', data: 'concepto', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Documento', data: 'documento', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Cliente', data: 'cliente', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Medio Pago', data: 'mediopago', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Detalle', data: 'detalle', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Cajero', data: 'cajero', render: (data:number) => `<p class="m-0 font-semibold"> $${Number(data).toLocaleString()} </p>`},
                        {title: 'Detalle', data: 'detalle', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Cajero', data: 'cajero', render: (data:number) => `<p class="m-0 font-semibold"> $${Number(data).toLocaleString()} </p>`}            
            ],
            language: {
                search: 'Busqueda',
                emptyTable: 'No Hay datos disponibles',
                zeroRecords:    "No se encontraron registros coincidentes",
                lengthMenu: '_MENU_ Entradas por pagina',
                info: 'Mostrando pagina _PAGE_ de _PAGES_',
                infoEmpty: 'No hay entradas a mostrar',
                infoFiltered: ' (filtrado desde _MAX_ registros)',
                paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
            },
            layout: {
                topStart: {
                    buttons: [
                        {extend: 'excelHtml5', title: 'emisores procesadas'},  
                        {extend: 'pdfHtml5', title: 'emisores procesadas'}, 
                        {extend: 'print', title: 'emisores procesadas', text: 'Imprimir'},
                        'colvis'
                    ],
                    pageLength: 'pageLength'
                }
            },
        });
    }


    POS.callApiReporte = callApiReporte;

})();