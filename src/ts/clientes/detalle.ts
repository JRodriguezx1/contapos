
(():void=>{

    if(document.querySelector('.detallecliente')){

        const btnTotalCuotas = document.querySelector('#btnTotalCuotas') as HTMLButtonElement;
        const btnPagoDeudaTotal = document.querySelector('#btnPagoDeudaTotal') as HTMLButtonElement;
        const miDialogoTotalCuotas = document.querySelector('#miDialogoTotalCuotas') as HTMLDialogElement;
        const miDialogoPagoTotal = document.querySelector('#miDialogoPagoTotal') as HTMLDialogElement;
        const miDialogoAbono = document.querySelector('#miDialogoAbono') as HTMLDialogElement;
        const tablaCuotas = document.querySelector('#tablaCuotas tbody') as HTMLBodyElement;

        document.addEventListener("click", cerrarDialogoExterno);

        const parametrosURL = new URLSearchParams(window.location.search);
        const id = parametrosURL.get('id');

        function clientesGraficas($url:string, $dato:string){
            if(id!=null&&!Number.isNaN(id))
                (async ()=>{
                    try {
                        const url = $url+id;
                        const respuesta = await fetch(url); 
                        const resultado = await respuesta.json();
                        if($dato == 'comprasXMes')comprasXMesXCliente(resultado);
                        if($dato == 'ventasXCategorias')ventasXCategoriasXCliente(resultado);
                    } catch (error) {
                        console.log(error);
                    }
                })();
        }

        clientesGraficas('/admin/api/clientes/comprasXMesXCliente?id=', 'comprasXMes');
        clientesGraficas('/admin/api/clientes/ventasXCategoriasXCliente?id=', 'ventasXCategorias');
        

        function comprasXMesXCliente(resultado:{periodo:string, ventas_totales:string}[]){
            // Compras por mes
            const ctxMes = (document.getElementById("chartComprasMes") as HTMLCanvasElement).getContext('2d');
            if (ctxMes) {
                new Chart(ctxMes, {
                type: "line",
                data: {
                    labels: resultado.map(x=>x.periodo),
                    datasets: [{
                    label: "Compras",
                    data: resultado.map(x=>x.ventas_totales),
                    borderColor: "rgba(99, 102, 241, 1)",
                    backgroundColor: "rgba(99, 102, 241, 0.2)",
                    tension: 0.4,
                    fill: true,
                    }]
                },
                options: { responsive: true }
                });
            }
        }

        function ventasXCategoriasXCliente(resultado:{categoria:string, idcategoria:string, unidades_vendidas:string, venta_total_categoria:string}[]){
            // Categorías más compradas
            const ctxCat = (document.getElementById("chartCategorias") as HTMLCanvasElement).getContext('2d');
            if (ctxCat) {
                new Chart(ctxCat, {
                type: "doughnut",
                data: {
                    labels: resultado.map(x=>x.categoria),
                    datasets: [{
                        data: resultado.map(x=>x.unidades_vendidas),
                        backgroundColor: [
                            "rgba(99, 102, 241, 0.8)",   // Indigo
                            "rgba(16, 185, 129, 0.8)",   // Emerald
                            "rgba(249, 115, 22, 0.8)",   // Orange
                            "rgba(107, 114, 128, 0.8)"   // Gray
                        ],
                    }]
                },
                options: { responsive: true }
                });
            }
        }


        btnTotalCuotas.addEventListener('click', ()=>{
            miDialogoTotalCuotas.showModal();
            imprimirTotalCuotasXcliente();
        });


        btnPagoDeudaTotal.addEventListener('click', ()=>{
            miDialogoPagoTotal.showModal();
        });


        document.querySelector('#formPagoTotalDeuda')?.addEventListener('submit', async (e:Event)=>{
            e.preventDefault();
            if(id!=null&&!Number.isNaN(id)){
                const datos = new FormData();
                datos.append('idcliente', id);
                datos.append('caja', $('#PagoTotal_caja').val() as string);
                datos.append('mediodepago', $('#PagoTotal_mediopago').val() as string);
                datos.append('valorDeudaTotal', deudatotalCiente);
                try {
                    const url = "/admin/api/creditos/pagarDeudaTotal";  //api en creditoscontrolador
                    const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                    const resultado = await respuesta.json();
                    console.log(resultado);
                } catch (error) {
                    console.log(error);
                }
            }
        });



        async function imprimirTotalCuotasXcliente(){
            if(id!=null&&!Number.isNaN(id)){
                try {
                    const url = `/admin/api/totalCuotasXcliente?id=${id}`; //llamado a la API REST ventascontrolador, detalle producto compuesto
                    const respuesta = await fetch(url); 
                    const resultado:{capital:string, fechafin:string, fechainicio:string, fechapagado:string, idestadocreditos:string, interestotal:string, num_orden:string, numerocuota:string, valorpagado:string}[] = await respuesta.json();

                    while(tablaCuotas.firstChild)tablaCuotas.removeChild(tablaCuotas.firstChild);
                    resultado.forEach(c=>{
                        const tr = document.createElement('tr') as HTMLTableRowElement;
                        tr.innerHTML = `<td class="text-center">${c.num_orden}</td>
                                        <td class="text-center">$ ${(Number(c.capital)+Number(c.interestotal)).toLocaleString()}</td>
                                        <td class="text-center">${c.numerocuota}</td>
                                        <td class="text-center">$ ${Number(c.valorpagado).toLocaleString()}</td>
                                        <td class="text-center">${c.fechapagado}</td>
                                        <td class="text-center">${c.idestadocreditos=='1'?'Finalizado':c.idestadocreditos=='2'?'Abierto':'Anulado'}</td>`;
                        tablaCuotas.prepend(tr);
                    });

                } catch (error) {
                    console.log(error);
                }
            }
        }


        ////////////// Evento a la tabla cuotas ///////////////
        document.querySelector('#tablaCreditos')?.addEventListener("click", (e:Event)=>{ //evento click sobre toda la tabla
            const target = e.target as HTMLButtonElement;
            if(target?.classList.contains("abonarCredito") || target?.parentElement?.classList.contains("abonarCredito") )abonarCredito(target);
            if(target?.classList.contains("anularCredito") || target?.parentElement?.classList.contains("anularCredito"))anularCredito(target);
        });

        function abonarCredito(target: HTMLButtonElement){
            miDialogoAbono.showModal();
        }


        function anularCredito(target: HTMLButtonElement){
            const idabono = target.parentElement?.id;
            const fila = target.closest('tr');
            if(idabono==undefined)return;
            Swal.fire({
                customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
                icon: 'question',
                title: 'Desea anular el credito',
                text: "El credito, seran anulado definitivamente.",
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result:any) => {
                if (result.isConfirmed) {
                    /*(async ()=>{ 
                        try {
                            const url = "/admin/api/creditos/anularAbono?id="+idabono;
                            const respuesta = await fetch(url); 
                            const resultado = await respuesta.json();
                            if(resultado.exito !== undefined){
                                fila?.remove();
                                Swal.fire(resultado.exito[0], '', 'success');
                            }else{
                                Swal.fire(resultado.error[0], '', 'error');
                            }
                        } catch (error) {
                            console.log(error);
                        }
                    })();//cierre de async()*/
                }
            });
        }


        function cerrarDialogoExterno(event:Event) {
            const f = event.target;
            if (f=== miDialogoTotalCuotas || f === miDialogoPagoTotal || f === miDialogoAbono || (f as HTMLElement).id === 'btnCerrarTotalCuotas' || (f as HTMLElement).id === 'btnCerrarPagoTotal' || (f as HTMLButtonElement).value == 'Salir'){
                miDialogoTotalCuotas.close();
                miDialogoPagoTotal.close();
                miDialogoAbono.close();
            }
        }

    }

})();