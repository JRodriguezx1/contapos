(()=>{
    if(document.querySelector('.movimientosinventarios')){

        interface compras {
        id:string,
        formapago:string,
        nfactura:string,
        impuesto:string,
        cantidaditems:string,
        observacion:string,
        estado:string,
        subtotal:string,
        valortotal:string,
        fechacompra:string,
        nombreusuario:string,
        nombreproveedor:string,
        nombrecaja:string
        estadocierrecaja:string
    } 

        const consultarFechaPersonalizada = document.querySelector('#consultarFechaPersonalizada') as HTMLButtonElement;
        let fechainicio:string = "", fechafin:string = "", tablaMovimientosInventarios:HTMLElement;
        let datosMovimientosInventarios:[] = [];

        const mesyaño:[string, number] = mesyañoactual();
        document.querySelector('#mesañoactual')!.textContent = mesyaño[0]+' '+mesyaño[1];

        // SELECTOR DE FECHAS DEL CALENDARIO
        ($('input[name="datetimes"]')as any).daterangepicker({
        timePicker: true,
        //startDate: moment().startOf('hour'),
        //endDate: moment().startOf('hour').add(32, 'hour'),
        startDate: moment().set({ hour: 0, minute: 0, second: 1 }),
        endDate: moment().set({ hour: 23, minute: 59, second: 59 }),
        locale: {
            format: 'M/DD hh:mm A'
        }
        });

        $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
            var endDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
            fechainicio = startDate;
            fechafin = endDate;
            //(document.querySelector('#fechainicio') as HTMLParagraphElement).textContent = fechainicio;
            //(document.querySelector('#fechafin') as HTMLParagraphElement).textContent = fechafin;
        });


        ///////   productos y subproductos en el select
        let filteredData: {id:string, text:string, tipo:string, sku:string, unidadmedida:string}[];   //tipo = 0 es producto simple,  1 = subproducto
        (async ()=>{
            try {
                const url = "/admin/api/totalitems"; //llamado a la API REST en el controlador almacencontrolador para treaer todas los productos simples y subproductos
                const respuesta = await fetch(url); 
                const resultado:{id:string, nombre:string, tipoproducto:string, sku:string, unidadmedida:string}[] = await respuesta.json(); 
                filteredData = resultado.map(item => ({ id: item.id, text: item.nombre, tipo: item.tipoproducto??'1', sku: item.sku, unidadmedida: item.unidadmedida }));
                activarselect2(filteredData);
                console.log(filteredData);
            } catch (error) {
                console.log(error);
            }
        })();

        function activarselect2(filteredData:{id:string, text:string, tipo:string, sku:string, unidadmedida:string}[]){
            ($('#item') as any).select2({ 
                data: filteredData,
                placeholder: "Selecciona un item",
                maximumSelectionLength: 1,
                /*
                templateResult: function (data:{id:string, text:string, tipo:string}) {
                    // Personalizar cómo se muestra cada opción en el dropdown
                    if (!data.id) { return data.text; }  // Si no hay id, solo mostrar el texto
                    const html = `
                        <div class="custom-option">
                            <span class="item-name">${data.text}</span> 
                            <span class="item-type">${data.tipo}</span>  <!-- Mostrar tipo adicional -->
                        </div>`;
                    return $(html);  // Devolver el HTML personalizado
                }*/
            });
        }


        ////// consulta por fecha personalizada
        consultarFechaPersonalizada.addEventListener('click', ()=>{
            let datos = ($('#item') as any).select2('data')[0];
            if(fechainicio == '' || fechafin == ''){
                msjalertToast('error', '¡Error!', "Elegir fechas a consultar");
                return;
            }
            if(datos === undefined){
                msjalertToast('error', '¡Error!', "Seleccionar un item de la lista");
                return;
            }
            console.log(datos);
            callApiMovimientoInventario(fechainicio, fechafin, datos.tipo, datos.id);
        });

        async function callApiMovimientoInventario(dateinicio:string, datefin:string, tipo:string, iditem:string){
            console.log(dateinicio, datefin);
            (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
            const datos = new FormData();
            datos.append('fechainicio', dateinicio);
            datos.append('fechafin', datefin);
            datos.append('tipo', tipo);
            datos.append('iditem', iditem);
            try {
                const url = "/admin/api/movimientoInventario"; //llama a la api que esta en reportescontrolador.php
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                datosMovimientosInventarios = resultado;
                console.log(datosMovimientosInventarios);
                printTableCompras();
            (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
            } catch (error) {
                console.log(error);
            }
        }


        printTableCompras();
        function printTableCompras(){
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
                        render: (data: any, type: any, row: any) => {return `<button class="btn-xs ${row.tipo=='venta'?'btn-lima':row.tipo=='compra'?'btn-blue':row.tipo=='ajuste'?'btn-turquoise':(row.tipo=='descuento de unidades' || row.tipo=='descuento por produccion')?'btn-bluelight':row.tipo=='salida por traslado'?'btn-yellow':'btn-bluelintense'}">${row.tipo}</button>`}
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
        }


    }

})();