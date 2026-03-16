
(()=>{

    if(!document.querySelector('.ventasgenerales'))return;

    const POS = (window as any).POS;

    const tablaProductosVendidos = ($('#tablaProductosVendidos') as any);
    const tablaMediosPagos = ($('#tablaMediosPagos') as any);
    const tablacreditosSeparados = ($('#tablacreditosSeparados') as any);
    const tablaGastos = ($('#tablaGastos') as any);
    const tablaIngresoCanalventa = ($('#tablaIngresoCanalventa') as any);
    const tablaResumenVentas = ($('#tablaResumenVentas') as any);
    const tablaResumenCreditos = ($('#tablaResumenCreditos') as any);
    
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
        idestadocreditos:string,
        estado:string
        carteraTotal:string,
        carteraXCobrar:string,
        totalAbonado:string,
        total:string,
    }

    interface i_canaldeVenta {
        canaldeventa:string,
        transacciones:string,
        valor:string,
    }

    interface i_gastos {
        descripcion:string,
        tipogasto:string,
        valor:string,
    }
    
    interface i_resumenVentas {
        ventas:string,
        total_ventas:string,
        total_costo:string,
        ganancia:string,
        margenutilidad:string,
    }

    interface i_resumenCreditos {
        creditos:string,
        capitalTotal:string,
        costo_total:string,
        utilidad_comercial:string,
        utilidad_proyectada:string,
        valor_pagado:string,
        utilidad_realizada:string
    }

    let productosVendidos:i_productosVendidos[] = [], mediosPagos:i_mediosPagos[] = [], creditosSeparados:i_creditosSeparados[] = [], gastos:i_gastos[]=[], canalVenta:i_canaldeVenta[]=[], resumenVentas:i_resumenVentas[]=[], resumenCreditos:i_resumenCreditos[]=[];

    //tablaProductosVendidos.DataTable(configdatatables25reg);


    async function callApiReporte(dateinicio:string, datefin:string){
        document.querySelector('#fecha1')!.textContent = dateinicio;
        document.querySelector('#fecha2')!.textContent = datefin;
        
        (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
        const datos = new FormData();
        datos.append('fechainicio', dateinicio);
        datos.append('fechafin', datefin+' 23:59:59');
        try {
            const url = "/admin/api/reportes/reportesGenerales"; //llama a la api que esta en reportescontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            productosVendidos = resultado.productosVendidos;
            mediosPagos = resultado.mediosPagos;
            creditosSeparados = resultado.separados;
            gastos = resultado.gastos;
            canalVenta = resultado.canalVenta;
            resumenCreditos = resultado.resumenCreditos;
            resumenVentas = resultado.resumenVentas;
            printProductosVendidos();
            printMediosPagos();
            printCreditosSeparados();
            printGastos();
            printCanalVenta();
            printResumen();
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
                        {
                            title: 'Estado', 
                            data: 'estado', 
                            render: (data: any, type: any, row: any) => {return `<button class="btn-xs ${row.estado=='Abierto'?'btn-blue':row.estado=='Finalizado'?'btn-lima':'btn-light'}">${row.estado}</button>`}
                        },
                        {title: 'Cartera Total', data: 'carteraTotal', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Cartera Por Cobrar', data: 'carteraXCobrar', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Total Abonado', data: 'totalAbonado', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Total', data: 'total'}
                    ],
        });
    }


    printCanalVenta();
    function printCanalVenta(){
        tablaIngresoCanalventa.DataTable({
            destroy: true, // importante si recargas la tabla
            data: canalVenta,
            pageLength: 25,
            order: [[ 1, 'asc' ]],
            columns: [
                        {title: 'Canal De Venta', data: 'canalVenta'},
                        {title: 'Transacciones', data: 'transacciones'},
                        {title: 'Valor', data: 'valor', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    ],
        });
    }


    printGastos();
    function printGastos(){
        tablaGastos.DataTable({
            destroy: true, // importante si recargas la tabla
            data: gastos,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Descripcion', data: 'descripcion'},
                        {title: 'Tipo Gasto', data: 'tipogasto'},
                        {title: 'Valor', data: 'valor', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    ],
        });
    }

    printResumen();
    function printResumen(){
        //resumen financiero total de ventas
        tablaResumenVentas.DataTable({
            destroy: true, // importante si recargas la tabla
            data: resumenVentas,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Ventas', data: 'ventas'},
                        {title: 'Total Ventas Productos', data: 'total_ventas', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Total Costo Productos', data: 'total_costo', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Ganancia', data: 'ganancia', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Margen Utilidad', data: 'margenutilidad', render: (data:number) => `${Number(data).toLocaleString()}%`},
                    ],
        });

        //resumen financiero total creditos
        tablaResumenCreditos.DataTable({
            destroy: true, // importante si recargas la tabla
            data: resumenCreditos,
            pageLength: 25,
            order: [[ 1, 'desc' ]],
            columns: [
                        {title: 'Creditos', data: 'creditos'},
                        {title: 'Credito Total', data: 'capitalTotal', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Costo Total', data: 'costo_total', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Utilidad Comercial', data: 'utilidad_comercial', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Utilidad Proyectada', data: 'utilidad_proyectada', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Pago total', data: 'valor_pagado', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Utilidad Realizada', data: 'utilidad_realizada', render: (data:number) => `$${Number(data).toLocaleString()}`},
                    ],
        });

        const totalIngreso = Number(resumenVentas[0]?.total_ventas??0)+Number(resumenCreditos[0]?.valor_pagado??0);
        const totalEgreso = Number(gastos.at(-1)?.valor ?? 0);
        const utilidadTotal = totalIngreso - totalEgreso;
        const margenUtilidadTotal = totalIngreso > 0 ? (utilidadTotal / totalIngreso) * 100 : 0;
        const rentabilidadTotal = totalEgreso > 0 ? (utilidadTotal / totalEgreso) * 100 : 0;

        (document.querySelector('#ingresoTotal') as HTMLElement).textContent = '$'+totalIngreso.toLocaleString();
        (document.querySelector('#egreso') as HTMLElement).textContent = '$'+totalEgreso.toLocaleString();
        (document.querySelector('#utilidadTotal') as HTMLElement).textContent = '$'+utilidadTotal.toLocaleString();
        (document.querySelector('#margenUtilidadTotal') as HTMLElement).textContent = margenUtilidadTotal.toFixed(2) + '%';
        (document.querySelector('#rentabilidadTotal') as HTMLElement).textContent = rentabilidadTotal.toFixed(2) + '%';
    }

    POS.callApiReporte = callApiReporte;

})();