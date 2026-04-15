(()=>{
    if(!document.querySelector('.comisiones'))return;

        const POS = (window as any).POS;

        const selectEmpleado = document.querySelector('#selectEmpleado') as HTMLSelectElement;
        const comisiontotalUser = document.querySelector('#comisiontotalUser') as HTMLParagraphElement;
        const comisionTotalUserPagada = document.querySelector('#comisionTotalUserPagada') as HTMLParagraphElement;
        const comisionUserPendiente = document.querySelector('#comisionUserPendiente') as HTMLParagraphElement;
        const btnLiquidar = document.querySelector('#btnLiquidar') as HTMLButtonElement;
        const miDialogoLiquidar = document.querySelector('#miDialogoLiquidar') as HTMLDialogElement;
        let tablaMovimientosInventarios:HTMLElement;
        let comisionUser:[] = [];
        //const mesyaño:[string, number] = mesyañoactual();


        interface ComisionTotalUser {
            comisiontotal: number;
        }
        interface HistorialPagos {
            pagos: any[]; // mejor reemplazar por un tipo específico si lo conoces
            totalPagado: number;
        }
        interface ResponseComision {
            comisionTotaluser: ComisionTotalUser;
            historialPagos: HistorialPagos;
        }


        document.addEventListener("click", cerrarDialogoExterno);

        //api para traer valores del usuario a consultar
        async function callApiReporte(dateinicio:string, datefin:string){
            if(selectEmpleado.value === ''){
                msjalertToast('error', '¡Error!', "Seleccionar un empleado de la lista");
                return;
            }

            (document.querySelector('#textNameUser') as HTMLElement).textContent = "Detalle de Movimientos - "+$('#selectEmpleado option:selected').text();

            //(document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
            const datos = new FormData();
            datos.append('fechainicio', dateinicio);
            datos.append('fechafin', datefin+' 23:59:59');
            datos.append('idempleado', selectEmpleado.value);
            try {
                const url = "/admin/api/comisiones/comisionesXUser"; //llama a la api que esta en comisionescontrolador.php
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                printWidgetsUser(resultado);
                
                //(document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
            } catch (error) {
                console.log(error);
            }
        }


        function printWidgetsUser(resultado:ResponseComision){
            comisiontotalUser.textContent = '$'+resultado.comisionTotaluser.comisiontotal.toLocaleString('es-CO', {minimumFractionDigits:2, maximumFractionDigits:2});
            comisionTotalUserPagada.textContent = '$'+resultado.historialPagos.totalPagado.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            comisionUserPendiente.textContent = '$'+(resultado.comisionTotaluser.comisiontotal-resultado.historialPagos.totalPagado).toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            
        }


        btnLiquidar.addEventListener('click', ()=>{
            miDialogoLiquidar.showModal();
        });


        document.querySelector('#formCrearUpdateLiquidar')?.addEventListener('submit', async(e:Event)=>{
            e.preventDefault();
            //validar que no supere el monto total a liquidar comision del usuario
            const datos = new FormData();
            
            datos.append('idempleado', selectEmpleado.value);
            try {
                const url = "/admin/api/comisiones/comisionesXUser"; //llama a la api que esta en comisionescontrolador.php
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                
            } catch (error) {
                console.log(error);
            }
        });



        /*printTableMovimientoInventario();
        function printTableMovimientoInventario(){
            tablaMovimientosInventarios = ($('#tablaMovimientosInventarios') as any).DataTable({
                "responsive": true,
                pageLength: 25,
                destroy: true, // importante si recargas la tabla
                data: datosMovimientosInventarios,
                order: [[8, "desc"]],
                columns: [
                    {title: 'id', data: 'id'}, 
                    {title: 'Usuario', data: 'usuario'},
                    {title: 'Producto', data: 'nombre'},
                    {title: 'Unidad', data: 'unidadmedida'},
                    {
                        title: 'tipo', 
                        data: null, 
                        orderable: false, 
                        searchable: false, 
                        render: (data: any, type: any, row: any) => {return `<button class="btn-xs ${row.tipo=='venta'?'btn-lima':row.tipo=='compra'?'btn-blue':row.tipo=='ajuste'?'btn-turquoise':(row.tipo=='descuento de unidades' || row.tipo=='descuento por produccion')?'btn-bluelight':row.tipo=='salida por traslado'?'btn-yellow':row.tipo=='devolucion'?'btn-red':'btn-blueintense'}">${row.tipo}</button>`}
                    },
                    {title: 'Cantidad', data: 'cantidad'},
                    {title: 'Stock anterior', data: 'stockanterior'},
                    {title: 'Stock', data: 'stocknuevo'},
                    {title: 'Fecha', data: 'created_at'},
                    {title: 'Referencia', data: 'referencia'},
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
        }*/

            function cerrarDialogoExterno(event:Event) {
                const f = event.target;
                if (f=== miDialogoLiquidar || (f as HTMLInputElement).value === 'salir' || (f as HTMLInputElement).value === 'Cancelar' || (f as HTMLElement).id == 'btnXCerrarModalLiquidar' ) {
                    miDialogoLiquidar.close();
                }
            }


        POS.callApiReporte = callApiReporte;
    
})();