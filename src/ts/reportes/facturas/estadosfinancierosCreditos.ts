(()=>{
    if(!document.querySelector('.estadosfinancierosCreditos'))return;

        const POS = (window as any).POS;

        let tablaEstdosFinancierosCreditos:HTMLElement;
        let estadosFinancierosCreditos:[] = [];



        async function callApiReporte(dateinicio:string, datefin:string){
            (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
            const datos = new FormData();
            datos.append('fechainicio', dateinicio);
            datos.append('fechafin', datefin);
            try {
                const url = "/admin/api/reportes/creditos/estadosFinancieros"; //llama a la api que esta en reportescontrolador.php
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                estadosFinancierosCreditos = resultado;
                console.log(estadosFinancierosCreditos);
                //printTableEstadosFinancierosCreditos();
            (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
            } catch (error) {
                console.log(error);
            }
        }


        printTableEstadosFinancierosCreditos();
        function printTableEstadosFinancierosCreditos(){
            tablaEstdosFinancierosCreditos = ($('#tablaEstdosFinancierosCreditos') as any).DataTable({
                "responsive": true,
                pageLength: 25,
                destroy: true, // importante si recargas la tabla
                data: estadosFinancierosCreditos,
                //order: [[8, "desc"]],
                columns: [
                    {title: 'N°', data: 'Num_orden'}, 
                    {title: 'Credito', data: 'credito'},
                    {title: 'Costo', data: 'costo'},
                    {title: 'Pagado', data: 'pagado'},
                    {title: 'Utilidad Realizada', data: 'utilidad_realizada'},
                    {title: 'Utilidad Proyectada', data: 'utilidad_proyectada'},
                    {title: 'Estado', data: 'estado'},
                    {title: 'Fecha', data: 'created_at'},
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
                }
            });
        }

        POS.callApiReporte = callApiReporte;
    
})();