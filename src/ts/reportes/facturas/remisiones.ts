(()=>{
    if(!document.querySelector('.remisiones'))return;

    const POS = (window as any).POS;

    const tablaRemisiones = ($('#tablaRemisiones') as any);

    interface i_remisiones {
        id:string,
        fechacreacion:string,
        vendedor:string,
        cliente:string,
        num_orden:string,
        entrega:string,
        entregado:string,
    }

    let remisiones:i_remisiones[] = [];


    async function callApiReporte(dateinicio:string, datefin:string){
        document.querySelector('#fecha1')!.textContent = dateinicio;
        document.querySelector('#fecha2')!.textContent = datefin;
        (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
        const datos = new FormData();
        datos.append('fechainicio', dateinicio);
        datos.append('fechafin', datefin+' 23:59:59');
        try {
            const url = "/admin/api/reportes/remisiones"; //llama a la api que esta en reportescontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            remisiones = resultado;
            printRemisiones();
           (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
        } catch (error) {
            console.log(error);
        }
    }

    
    printRemisiones();
    function printRemisiones(){
        tablaRemisiones.DataTable({
            destroy: true, // importante si recargas la tabla
            data: remisiones,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Id', data: 'id'},
                        {title: 'Fecha', data: 'fechacreacion', render: (data:string) => `<div class="w-36 whitespace-normal">${data}</div>`},
                        {title: 'Fecha Entrega', data: 'fechaentrega',  render: (data:string) => `<div class="text-center">${data??'-'}</div>`},
                        {title: 'Usuario', data: 'vendedor',  render: (data:string) => `<div class="w-48 whitespace-normal">${data}</div>`},
                        {title: 'Cliente', data: 'cliente',  render: (data:string) => `<div class="w-48 whitespace-normal">${data}</div>`},
                        {title: 'Orden', data: 'num_orden'},
                        {title: 'Entrega', data: 'entrega'},
                        {title: 'Estado', data: 'entregado', render: (data:string) => `${data=='1'?'<label class="text-green-500 font-medium">Despachado</label>':'<label class="text-red-500 font-medium">Pendiente</label>'}`},
                        { 
                            title: 'Acciones', 
                            data: null, 
                            orderable: false, 
                            searchable: false, 
                            render: (data: any, type: any, row: any) => {return `<a class="btn-xs btn-indigo" target="_blank" href="/admin/caja/ordenresumen?id=${row.id}" data-id="${row.id}">Abrir</a>`}
                        },        
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