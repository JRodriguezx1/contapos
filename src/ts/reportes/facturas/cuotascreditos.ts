(()=>{

    if(!document.querySelector('.cuotasCreditos'))return;

    const POS = (window as any).POS;

    const tablaCuotasCreditos = ($('#tablaCuotasCreditos') as any);

    interface i_cuotasCreditos {
        fechapagado:string,
        idtipofinanciacion:string,
        cliente:string,
        credito:string,
        numerocuota:string,
        valorpormedio:string,
        mediopago:string,
        idestadocreditos:string,
    }

    let cuotasCreditos:i_cuotasCreditos[] = [];

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
            cuotasCreditos = resultado;
            console.log(cuotasCreditos);
            printCuotasCreditos();
           (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
        } catch (error) {
            console.log(error);
        }
    }

    

    printCuotasCreditos();
    function printCuotasCreditos(){
        tablaCuotasCreditos.DataTable({
            destroy: true, // importante si recargas la tabla
            data: cuotasCreditos,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Fecha', data: 'fechapagado'},
                        {title: 'Tipo', data: 'idtipofinanciacion', render: (data:number) => `${data==1?'Credito':'Separado'}`},
                        {title: 'Cliente', data: 'cliente'},
                        {title: 'Credito', data: 'credito'},
                        {title: 'N° Cuota', data: 'numerocuota'},
                        {title: 'Valor', data: 'valorpormedio', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Medio de pago', data: 'mediopago'},
                        {
                            title: 'Estado', 
                            data: 'idestadocreditos', 
                            render: (data: any, type: any, row: any) => { 
                                                                            return `<button class="btn-xs ${row.idestadocreditos=='1'?'btn-lima':row.idestadocreditos=='2'?'btn-blue':'btn-red'}">
                                                                                        ${row.idestadocreditos=='1'?'Finalizado':row.idestadocreditos=='2'?'Abierto':'Anulado'}
                                                                                    </button>`
                                                                        }
                        }
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
                        {extend: 'excelHtml5', title: 'facturas procesadas'},  
                        {extend: 'pdfHtml5', title: 'facturas procesadas'}, 
                        {extend: 'print', title: 'facturas procesadas', text: 'Imprimir'},
                        'colvis'
                    ],
                    pageLength: 'pageLength'
                }
            },
        });
    }


    POS.callApiReporte = callApiReporte;

})();