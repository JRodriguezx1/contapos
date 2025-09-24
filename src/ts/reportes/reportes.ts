(function(){
  if(document.querySelector('.reportes')){
    const graficaVentaMensual = document.querySelector('#graficaVentaMensual') as HTMLButtonElement;
    const graficaVentaSemanal = document.querySelector('#graficaVentaSemanal') as HTMLButtonElement;
    const graficaVentaDiario = document.querySelector('#graficaVentaDiario') as HTMLButtonElement;
    const chartventas = (document.getElementById('chartventas') as HTMLCanvasElement)?.getContext('2d');
    const chartutilidad = (document.getElementById('chartutilidad') as HTMLCanvasElement)?.getContext('2d');
    const btnventasgenerales = document.querySelector<HTMLButtonElement>('#ventasgenerales')!;
    const cierrescaja = document.querySelector<HTMLButtonElement>('#cierrescaja')!;
    const modalFecha:any = document.querySelector("#modalFecha");

    const objDateRange: {inicio:string, fin:string} = {
      inicio: '',
      fin: ''
    }

    /*new Chart(ctx, {
      type: 'line',
      data: {
          labels: [1,2,3,4,5,6,7,8,9],//resultado.map(programa=>programa.nombre),
          datasets: [{
          label: '# of Votes',
          data: [1,2,3,4,10,3,11,4,17],//resultado.map(programa=>programa.total),
          borderColor: '#00c8c2',
          //backgroundColor: ['#ea580c', '#84cc16', '#22d3ee', '#a855f7'],
          backgroundColor: '#ea580c',
          //tension: 0.3,
          //stepped: 'middle',
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          },
          plugins: {legend: {display: false } } //elimina el label del dataset
      }
    });*/


    graficaVentaMensual.addEventListener('click', ()=>{
      console.log(569);
      (async ()=>{
        try {
          const url = "https://apidian.wdc.dom.my.id/api/ping"; //llamado a la API REST y se trae las direcciones segun cliente elegido
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json();
          console.log(resultado);
        } catch (error) {
            console.log(error);
        }
      })();
    });

    /*const idcli = 1;
      (async ()=>{
        try {
          const url = "/admin/api/direccionesXcliente?id="+idcli; //llamado a la API REST y se trae las direcciones segun cliente elegido
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          
        } catch (error) {
            console.log(error);
        }
      })();*/

    new Chart(chartventas, {
      type: 'bar',
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
          label: 'Total Ventas',
          data: [12, 19, 3, 5, 2, 3],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            grid: {display: false} //ocultar regilla horizontal
          },
          x: {
              grid: {display: false}, ////ocultar regilla vertical
          }
        },
        responsive: true,
      }
    });


    ////////////////////////////  chartutilidad - grafica costo/utlidad //////////////////////////////////
    new Chart(chartutilidad, {
      type: 'doughnut',
      data: {
        labels: ['Ventas total:', 'Costo:', 'Utilidad:'],
        datasets: [{
          label: 'Total Ventas',
          data: [19, 7, 12],
          backgroundColor: ['rgb(54, 162, 235)','rgb(255, 99, 132)', 'rgb(255, 205, 86)'],
          //borderWidth: 1
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
      }
    });

    ($('input[name="daterange"]') as any).daterangepicker({
      opens: 'right', // Posición deseada
      alwaysShowCalendars: true, // Siempre visible
    });

    
    btnventasgenerales?.addEventListener('click', ():void=>{

      objDateRange.inicio = '';
      objDateRange.fin = '';
      modalfechas('ventasgenerales');
      ///////////////  calendario ////////////////
      ($('input[name="daterange"]') as any).daterangepicker({
        opens: 'right', // Posición deseada
        alwaysShowCalendars: true, // Siempre visible
      });
      $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        objDateRange.inicio = startDate;
        objDateRange.fin = endDate;
      });
      //modalFecha.showModal();
      //document.addEventListener("click", cerrarDialogoExterno);
    });

    cierrescaja.addEventListener('click', ():void=>{
      objDateRange.inicio = '';
      objDateRange.fin = '';
      modalfechas('cierrescaja');
      ///////////////  calendario ////////////////
      ($('input[name="daterange"]') as any).daterangepicker();
      $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        objDateRange.inicio = picker.startDate.format('YYYY-MM-DD');
        objDateRange.fin = picker.endDate.format('YYYY-MM-DD');
      });
    });


    function modalfechas(rutaReporte:string){
      Swal.fire({
        title: "<strong>Seleccionar <u>Fecha</u></strong>",
        //icon: "info",
        html: `
        <div class="campodaterange">
          <label class="formulario__label" for="fechapersonalizada">Fecha personalizada</label>
          <input type="text" name="daterange" class="formulario__input" id="fechapersonalizada" /></div>
        `,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        width: 'auto', //ancho del modal automatico
      }).then((result:any) => {
        if (result.isConfirmed) {
          if(objDateRange.inicio != '' && objDateRange.fin != '')
            window.location.href = `/admin/reportes/${rutaReporte}?inicio=${objDateRange.inicio}&fin=${objDateRange.fin}`;    
        }
      });
    }

    /* cerrarDialogoExterno(event:Event) {
      if (event.target === modalFecha || (event.target as HTMLInputElement).value === 'cancelar' || (event.target as HTMLElement).closest('.finCerrarcaja')) {
          modalFecha.close();
          document.removeEventListener("click", cerrarDialogoExterno);
          if((event.target as HTMLElement).closest('.finCerrarcaja'))console.log(45);//eliminarCita(event.target.closest('.terminarcita').id);
      }
    }*/

  }
})();