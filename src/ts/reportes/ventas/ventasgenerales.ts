
(()=>{

    if(!document.querySelector('.ventasgenerales'))return;

    const POS = (window as any).POS;

    const tablaProductosVendidos = ($('#tablaProductosVendidos') as any);
    const tablaMediosPagos = ($('#tablaMediosPagos') as any);
    const tablaResumen = ($('#tablaResumen') as any);
    const tablacreditosSeparados = ($('#tablacreditosSeparados') as any);
    
    interface i_productosVendidos {
        idproducto:string,
        cantidadrefencia:string,
        nombreproducto:string,
        totalProductosVendidos:string,
        valorunidad:string,
        valorTotal:string
    }

    interface i_mediosPagos {
        idmediopago:string,
        cantidadMP:string,
        mediopago:string,
        valor:string
    }

    interface i_creditosSeparados {
        carteraTotal:string,
        carteraxcobrar:string,
        totalAbonado:string,
        reditosFinalizados:string,
        creditosPendientes:string,
        creditosAnulados:string,
    }

    interface i_resumen {
        total_ventas:string,
        total_costo:string,
        ganancia:string,
    }

    let productosVendidos:i_productosVendidos[] = [], mediosPagos:i_mediosPagos[] = [], creditosSeparados:i_creditosSeparados[] = [], resumen:i_resumen[]=[];

    //tablaProductosVendidos.DataTable(configdatatables25reg);


    async function callApiReporte(dateinicio:string, datefin:string){
        console.log(dateinicio, datefin);
        
        (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
        const datos = new FormData();
        datos.append('fechainicio', dateinicio);
        datos.append('fechafin', datefin+' 23:59:59');
        try {
            const url = "/admin/api/reportes/reportesGenerales"; //llama a la api que esta en reportescontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            //facturaselectronicas = resultado;
            console.log(resultado);
            productosVendidos = resultado.productosVendidos;
            mediosPagos = resultado.mediosPagos;
            resumen = resultado.resumen;
            //creditosSeparados = resultado.creditosSeparados;
            printProductosVendidos();
            printMediosPagos();
            printResumen();
            //printCreditosSeparados();
            document.querySelector('#totalDescto')!.textContent = '$'+Number(resultado.totalDescuentos[0].total_descuentos).toLocaleString();
           (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
        } catch (error) {
            console.log(error);
        }
    }


    printProductosVendidos();
    function printProductosVendidos(){
        tablaProductosVendidos.DataTable({
            destroy: true, // importante si recargas la tabla
            data: productosVendidos,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Producto', data: 'nombreproducto'},
                        {title: 'Cantidad Vendida', data: 'totalProductosVendidos'},
                        {title: 'V. Unidad', data: 'valorunidad', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Total Ventas', data: 'valorTotal', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Costo Total', data: 'costoTotal', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Utilidad', data: 'utilidad', render: (data:number) => `$${Number(data).toLocaleString()}`}
                    ],
        });
    }

    printMediosPagos();
    function printMediosPagos(){
        tablaMediosPagos.DataTable({
            destroy: true, // importante si recargas la tabla
            data: mediosPagos,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Medio de Pago', data: 'mediopago'},
                        {title: 'Transacciones', data: 'cantidadMP'},
                        {title: 'Total Ventas', data: 'valor', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    ],
        });
    }

    printCreditosSeparados();
    function printCreditosSeparados(){
        tablacreditosSeparados.DataTable({
            destroy: true, // importante si recargas la tabla
            data: creditosSeparados,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Cartera Total', data: 'mediopago'},
                        {title: 'Cartera Por Cobrar', data: 'cantidadMP'},
                        {title: 'Total Abonado', data: 'valor', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Creditos Activos', data: 'cantidadMP'},
                        {title: 'Creditos Finalizados', data: 'mediopago'},
                        {title: 'Creditos Anulados', data: 'valor', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    ],
        });
    }

    printResumen();
    function printResumen(){
        tablaResumen.DataTable({
            destroy: true, // importante si recargas la tabla
            data: resumen,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Total Ventas Productos', data: 'total_ventas', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Total Costo Productos', data: 'total_costo', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Ganancia', data: 'ganancia', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    ],
        });
    }

    POS.callApiReporte = callApiReporte;

})();