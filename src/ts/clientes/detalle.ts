(():void=>{

    if(document.querySelector('.detallecliente')){

        const btnTotalCuotas = document.querySelector('#btnTotalCuotas') as HTMLButtonElement;
        const miDialogoTotalCuotas = document.querySelector('#miDialogoTotalCuotas') as HTMLDialogElement;
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


        function cerrarDialogoExterno(event:Event) {
            const f = event.target;
            if (f=== miDialogoTotalCuotas || (f as HTMLInputElement).id === 'btnCerrarTotalCuotas'){
                miDialogoTotalCuotas.close();
            }
        }

    }

})();