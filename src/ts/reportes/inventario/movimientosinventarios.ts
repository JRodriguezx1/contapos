(()=>{
    if(document.querySelector('.movimientosinventarios')){


        const consultarFechaPersonalizada = document.querySelector('#consultarFechaPersonalizada') as HTMLButtonElement;
        let fechainicio:string = "", fechafin:string = "", tablaMovimientosInventarios:HTMLElement;

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
        if(fechainicio == '' || fechafin == ''){
            msjalertToast('error', '¡Error!', "Elegir fechas a consultar");
            return;
        }
        //callApiCompras(fechainicio, fechafin);
        });

        /*async function callApiCompras(dateinicio:string, datefin:string){
            console.log(dateinicio, datefin);
            (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
            const datos = new FormData();
            datos.append('fechainicio', dateinicio);
            datos.append('fechafin', datefin);
            try {
                const url = "/admin/api/reportecompras"; //llama a la api que esta en reportescontrolador.php
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                datosCompras = resultado;
                console.log(datosCompras);
                printTableCompras();
            (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
            } catch (error) {
                console.log(error);
            }
        }*/


    }

})();