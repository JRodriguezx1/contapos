(()=>{

    if(!document.querySelector('.ventasgenerales'))return;

     const POS = (window as any).POS;

    const consultarFechaPersonalizada = document.querySelector('#consultarFechaPersonalizada') as HTMLButtonElement;
    const btnmesactual = document.querySelector('#btnmesactual') as HTMLButtonElement;
    const btnmesanterior = document.querySelector('#btnmesanterior') as HTMLButtonElement;
    const btnhoy = document.querySelector('#btnhoy') as HTMLButtonElement;
    const btnayer = document.querySelector('#btnayer') as HTMLButtonElement;
    let fechainicio:string = "", fechafin:string = "";

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
        POS.callApiReporte(fechainiciobtn, fechafinbtn);
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
        POS.callApiReporte(fechainiciobtn, fechafinbtn);
    });

    btnhoy.addEventListener('click', (e:Event)=>{
        const hoy = new Date();
        const inicioDia = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), 0, 0, 0);
        const finDia = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), 23, 59, 59);
        const fechainiciobtn:string = formatoFecha(inicioDia);
        const fechafinbtn:string = formatoFecha(finDia);
        POS.callApiReporte(fechainiciobtn, fechafinbtn);
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
        POS.callApiReporte(fechainiciobtn, fechafinbtn);
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
      POS.callApiReporte(fechainicio, fechafin);
    });
})();