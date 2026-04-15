(()=>{
    if(!document.querySelector('.comisiones'))return;

        const POS = (window as any).POS;

        const selectEmpleado = document.querySelector('#selectEmpleado') as HTMLSelectElement;
        const comisiontotalUser = document.querySelector('#comisiontotalUser') as HTMLParagraphElement;
        const comisionTotalUserPagada = document.querySelector('#comisionTotalUserPagada') as HTMLParagraphElement;
        const comisionUserPendiente = document.querySelector('#comisionUserPendiente') as HTMLParagraphElement;
        const btnLiquidar = document.querySelector('#btnLiquidar') as HTMLButtonElement;
        const miDialogoLiquidar = document.querySelector('#miDialogoLiquidar') as HTMLDialogElement;
        const inputValorLiquidar = (document.querySelector('#valorLiquidar') as HTMLInputElement).value;
        let tablaMovimientosComisiones:HTMLElement, comisionPendienteUser = 0;


        interface ComisionTotalUser {
            comisiontotal: number;
        }
        interface HistorialPagos {
            movimientos: any[]; // mejor reemplazar por un tipo específico si lo conoces
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
            datos.append('fechafin', datefin);
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
            comisionPendienteUser = resultado.comisionTotaluser.comisiontotal;
            comisiontotalUser.textContent = '$'+comisionPendienteUser.toLocaleString('es-CO', {minimumFractionDigits:2, maximumFractionDigits:2});
            comisionTotalUserPagada.textContent = '$'+resultado.historialPagos.totalPagado.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            comisionUserPendiente.textContent = '$'+(resultado.comisionTotaluser.comisiontotal-resultado.historialPagos.totalPagado).toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            //renderizar tabla
            printTableMovimientosComisiones(resultado.historialPagos.movimientos);
        }


        btnLiquidar.addEventListener('click', ()=>{
            miDialogoLiquidar.showModal();
        });


        document.querySelector('#formCrearUpdateLiquidar')?.addEventListener('submit', async(e:Event)=>{
            e.preventDefault();
            //validar que no supere el monto total a liquidar comision del usuario
            if(selectEmpleado.value === '' || Number(inputValorLiquidar) <= 0 || Number(inputValorLiquidar)>comisionPendienteUser){
                msjalertToast('error', '¡Error!', "Seleccionar un empleado de la lista o valor a liquidar no es valido");
                return;
            }
            const datos = new FormData();
            datos.append('fkusuarioid', selectEmpleado.value);
            datos.append('valor', inputValorLiquidar);
            datos.append('mediopago', (document.querySelector('#mediopago') as HTMLInputElement).value);
            datos.append('tipo', (document.querySelector('#tipo') as HTMLSelectElement).value);
            datos.append('referencia', (document.querySelector('#observacion') as HTMLInputElement).value);
            try {
                const url = "/admin/api/comisiones/liquidarComision"; //llama a la api que esta en comisionescontrolador.php
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();

            } catch (error) {
                console.log(error);
            }
        });


        printTableMovimientosComisiones([]);
        function printTableMovimientosComisiones(movimientos:any){
            tablaMovimientosComisiones = ($('#tablaMovimientosComisiones') as any).DataTable({
                "responsive": true,
                pageLength: 25,
                destroy: true, // importante si recargas la tabla
                data: movimientos,
                order: [[0, "desc"]],
                columns: [
                    {title: 'Fecha', data: 'fecha'}, 
                    {title: 'Concepto', data: 'tipo'},
                    {title: 'Crédito (+)', data: 'entrada', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    {title: 'Débito (-)', data: 'salida', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    {title: 'Acciones', data: null, render: (data: any, type: any, row: any) => `<button class="btn-eliminar" data-id="${row.entrada == '0'&&row.salida!='0'?row.id:''}">${row.entrada == '0'&&row.salida!='0'?'⛔':' - '}</button>`},
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


        //EVENTO A LA TABLA DE MOVIMIENTOS DE COMISIONES
    document.querySelector('#tablaMovimientosComisiones')?.addEventListener("click", (e)=>{
      const target = e.target as HTMLButtonElement;
      let idmovimento = target?.dataset.id;
      if(!idmovimento || isNaN(Number(idmovimento))){
        msjalertToast('error', '¡Error!', "id del movimiento no es valido");
        return;
    }
      if(target?.classList.contains("btn-eliminar"))eliminarMovimientoComision(idmovimento, target);
    });

    function eliminarMovimientoComision(idmovimento:string, target:HTMLButtonElement){
        const fila = (tablaMovimientosComisiones as any).row(target.closest('tr'));
        Swal.fire({
            customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
            icon: 'question',
            title: 'Desea eliminar el egreso de comision?',
            text: "La comision sera eliminado por completo del sistema.",
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result:any) => {
            if (result.isConfirmed) {
                (async ()=>{
                    const datos = new FormData();
                    datos.append('id', idmovimento);
                    try {
                        const url = "/admin/api/eliminarMovimientoComision"; //llamado a la API REST en reportescontrolador para eliminar un ingreso
                        const respuesta = await fetch(url, {method: 'POST', body: datos});
                        const resultado = await respuesta.json();
                        if(resultado.exito !== undefined){ 
                            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                            fila.remove().draw(false);
                        }else{
                            msjalertToast('error', '¡Error!', resultado.error[0]);
                        }
                    } catch (error) {
                        console.log(error);
                    }
                })();
            }
        });
    }

        function cerrarDialogoExterno(event:Event) {
            const f = event.target;
            if (f=== miDialogoLiquidar || (f as HTMLInputElement).value === 'salir' || (f as HTMLInputElement).value === 'Cancelar' || (f as HTMLElement).id == 'btnXCerrarModalLiquidar' ) {
                miDialogoLiquidar.close();
            }
        }


        POS.callApiReporte = callApiReporte;
    
})();