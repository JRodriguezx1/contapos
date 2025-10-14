(():void=>{

  if(document.querySelector('.gastoseingresos')){

    const consultarFechaPersonalizada = document.querySelector('#consultarFechaPersonalizada') as HTMLButtonElement;
    const btnmesactual = document.querySelector('#btnmesactual') as HTMLButtonElement;
    const btnmesanterior = document.querySelector('#btnmesanterior') as HTMLButtonElement;
    const btnhoy = document.querySelector('#btnhoy') as HTMLButtonElement;
    const btnayer = document.querySelector('#btnayer') as HTMLButtonElement;
    let fechainicio:string = "", fechafin:string = "", tablaGastos:HTMLElement;

    interface apigastos {
        Id:string,
        id_compra:string,
        idg_cierrecaja:string,
        nombrecaja:string,
        nombrebanco:string,
        nombre:string,
        operacion:string,
        categoriagasto:string,
        valor:string,
        fecha:string
    } 

    let datosGastos:apigastos[] = [];


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

    btnmesactual.addEventListener('click', (e:Event)=>{
        const hoy = new Date();
        // Primer día del mes actual
        const primerDia = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        // Último día del mes actual
        const ultimoDia = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
        const fechainiciobtn:string = primerDia.toISOString().split('T')[0];
        const fechafinbtn:string = ultimoDia.toISOString().split('T')[0];
        callApiGastos(fechainiciobtn, fechafinbtn);
    });


    btnmesanterior.addEventListener('click', (e:Event)=>{
        // Fecha actual
        const hoy = new Date();
        // Primer día del mes anterior
        const primerDiaMesAnterior = new Date(hoy.getFullYear(), hoy.getMonth() - 1, 1);
        // Último día del mes anterior
        const ultimoDiaMesAnterior = new Date(hoy.getFullYear(), hoy.getMonth(), 0);
        const fechainiciobtn:string = primerDiaMesAnterior.toISOString().split('T')[0];
        const fechafinbtn:string = ultimoDiaMesAnterior.toISOString().split('T')[0];
        callApiGastos(fechainiciobtn, fechafinbtn);
    });

    btnhoy.addEventListener('click', (e:Event)=>{
        const hoy = new Date();
        const inicioDia = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), 0, 0, 0);
        const finDia = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), 23, 59, 59);
        const fechainiciobtn:string = formatoFecha(inicioDia);
        const fechafinbtn:string = formatoFecha(finDia);
        callApiGastos(fechainiciobtn, fechafinbtn);
    });

    btnayer.addEventListener('click', (e:Event)=>{
        // Fecha actual
        const hoy = new Date();
        // Día anterior
        const ayer = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate() - 1);
        // Inicio y fin del día anterior
        const inicioAyer = new Date(ayer.getFullYear(), ayer.getMonth(), ayer.getDate(), 0, 0, 0);
        const finAyer = new Date(ayer.getFullYear(), ayer.getMonth(), ayer.getDate(), 23, 59, 59);
        const fechainiciobtn:string = formatoFecha(inicioAyer);
        const fechafinbtn:string = formatoFecha(finAyer);
        callApiGastos(fechainiciobtn, fechafinbtn);
    });

    function formatoFecha(fecha: Date): string {
        const año = fecha.getFullYear();
        const mes = String(fecha.getMonth() + 1).padStart(2, "0");
        const dia = String(fecha.getDate()).padStart(2, "0");
        const hora = String(fecha.getHours()).padStart(2, "0");
        const minuto = String(fecha.getMinutes()).padStart(2, "0");
        const segundo = String(fecha.getSeconds()).padStart(2, "0");
        return `${año}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;
    }


    ////// consulta por fecha personalizada
    consultarFechaPersonalizada.addEventListener('click', ()=>{
      if(fechainicio == '' || fechafin == ''){
         msjalertToast('error', '¡Error!', "Elegir fechas a consultar");
         return;
      }
      callApiGastos(fechainicio, fechafin);
    });

    async function callApiGastos(dateinicio:string, datefin:string){
        console.log(dateinicio, datefin);
        (document.querySelector('.content-spinner1') as HTMLElement).style.display = "grid";
        const datos = new FormData();
        datos.append('fechainicio', dateinicio);
        datos.append('fechafin', datefin);
        try {
            const url = "/admin/api/gastoseingresos"; //llama a la api que esta en reportescontrolador.php
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            datosGastos = resultado;
            console.log(datosGastos);
            printTableGastos();
           (document.querySelector('.content-spinner1') as HTMLElement).style.display = "none";
        } catch (error) {
            console.log(error);
        }
    }


    printTableGastos();
    function printTableGastos(){
        tablaGastos = ($('#tablaGastos') as any).DataTable({
            destroy: true, // importante si recargas la tabla
            data: datosGastos,
            columns: [
                        {title: 'id', data: 'Id'}, 
                        {title: 'Caja', data: 'nombrecaja'},
                        {title: 'Banco', data: 'nombrebanco'},
                        {title: 'Usuario', data: 'nombre'},
                        {title: 'Operacion', data: 'operacion'},
                        {title: 'Tipo Gasto', data: 'categoriagasto'},
                        {title: 'Valor', data: 'valor', render: (data:number) => `$${Number(data).toLocaleString()}`},
                        {title: 'Fecha', data: 'fecha'},
                        { 
                            title: 'Acciones', 
                            data: null, 
                            orderable: false, 
                            searchable: false, 
                            render: (data: any, type: any, row: any) => { 
                                    return `<button class="btn-ver" data-id="${row.Id}">✳️​</button>
                                            <button class="btn-editar" data-id="${row.Id}">🖊️​</button>
                                            <button class="btn-eliminar" data-id="${row.Id}">⛔​</button>`}
                        }
                    ],
        });
    }

    document.querySelector('#tablaGastos')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLButtonElement;
      if((e.target as HTMLButtonElement)?.classList.contains("btn-editar"))editarGasto(e);
      if(target?.classList.contains("btn-eliminar"))eliminarGasto(e);
    });


    function editarGasto(e:Event){
        let idgasto = (e.target as HTMLButtonElement)?.dataset.id;
        console.log(idgasto);
    }

    function eliminarGasto(e:Event){
        let idgasto = (e.target as HTMLButtonElement)?.dataset.id;
        console.log(idgasto);
    }



  }

})();