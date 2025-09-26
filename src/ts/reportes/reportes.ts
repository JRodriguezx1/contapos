(function(){
  if(document.querySelector('.reportes')){
    const graficaventa = document.querySelectorAll<HTMLButtonElement>('.graficaventa');
    const chartventas = (document.getElementById('chartventas') as HTMLCanvasElement)?.getContext('2d');
    const chartutilidad = (document.getElementById('chartutilidad') as HTMLCanvasElement)?.getContext('2d');
    const btnventasgenerales = document.querySelector<HTMLButtonElement>('#ventasgenerales')!;
    const cierrescaja = document.querySelector<HTMLButtonElement>('#cierrescaja')!;
    const modalFecha:any = document.querySelector("#modalFecha");

    const objDateRange: {inicio:string, fin:string} = {
      inicio: '',
      fin: ''
    }

    let chartVentasInstance: any | null = null;

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


    //graficaVentaMensual.addEventListener('click', ()=>{
      //console.log(777);
      /*(async ()=>{
        try {
          const url = "https://apidianj2.com/api/getconfigcompanies"; //llamado a la API REST Dianlaravel
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json();
          console.log(resultado);
        } catch (error) {
            console.log(error);
        }
      })();*/
      /*const idcli = 1;
      (async ()=>{
        try {
          const url = "/admin/api/ventasGraficaMensual?id="+idcli; //llamado a la API REST en reportescontrolador.php
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          console.log(resultado);
          graficaVentas(resultado);
        } catch (error) {
            console.log(error);
        }
      })();*/
    //});

    callapiventasgrafica("/admin/api/ventasGraficaMensual");

    graficaventa.forEach((btngrafica, index) =>{
      btngrafica.addEventListener('click', (e:Event)=>{
        let url:string = "/admin/api/ventasGraficaMensual"; //llamado a la API REST en reportescontrolador.php
        if(index == 1){  //grafico diario
          url = "/admin/api/ventasGraficaDiario"; //llamado a la API REST en reportescontrolador.php
        }
        callapiventasgrafica(url);
      })
    });

    async function callapiventasgrafica(url:string){
      try {
        const respuesta = await fetch(url); 
        const resultado = await respuesta.json(); 
        graficaVentas(resultado);
      } catch (error) {
          console.log(error);
      }
    }

    function graficaVentas(resultado:{label:String[], datos:string[]}){
      if (chartVentasInstance)chartVentasInstance.destroy();
      chartVentasInstance = new Chart(chartventas, {
        type: 'bar',
        data: {
          labels: resultado.label,
          datasets: [{
            label: 'Total Ventas',
            data: resultado.datos,
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
    }



    ////////////////////////////  chartutilidad - grafica costo/utlidad //////////////////////////////////
    (async ()=>{
        try {
          const url = "/admin/api/graficaValorInventario"; //llamado a la API REST en reportescontrolador.php
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json();
          new Chart(chartutilidad, {
            type: 'doughnut',
            data: {
              labels: ['Ventas total:', 'Costo:', 'Utilidad:'],
              datasets: [{
                label: 'Total Ventas',
                data: [Number(resultado.valorventa), Number(resultado.costoinv), (Number(resultado.valorventa) - Number(resultado.costoinv))],
                backgroundColor: ['rgb(54, 162, 235)','rgb(255, 99, 132)', 'rgb(255, 205, 86)'],
                //borderWidth: 1
                hoverOffset: 4
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                    labels: {
                        generateLabels: (chart:any) => {
                            const data = chart.data.datasets[0].data;
                            const labels = chart.data.labels;
                            return labels.map((label:any, i:any) => ({
                                text: `${label}: ${data[i]}`,
                                fillStyle: chart.data.datasets[0].backgroundColor[i],
                                index: i
                            }));
                        }
                    }
                }
              }
            }
          });

        } catch (error) {
            console.log(error);
        }
    })();







    ////////////////////////////////////////////////////////////////////


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