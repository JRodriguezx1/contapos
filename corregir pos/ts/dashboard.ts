(function():void{
  if(document.querySelector('.inicio')){
    
    async function ventasgraficas($url:string, $dato:string){
      try{
        const respuesta = await fetch($url); 
        const resultado = await respuesta.json();
        if($dato == 'ventasVsGastos')graficaVentasVsGastos(resultado);
        if($dato == 'ultimos7dias')ventas7dias(resultado);
      }catch(error){
            console.log(error);
      }
    }
    ventasgraficas('/admin/api/ventasVsGastos', 'ventasVsGastos');
    ventasgraficas('/admin/api/ultimos7dias', 'ultimos7dias');

    // Ventas por horas (hoy) - ejemplo 24 horas o por horas de apertura (aquí 10 valores)
    const ventasPorHoras = {
      labels: ["08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00"],
      data:    [5, 12, 20, 35, 60, 48, 30, 22, 15, 10]
    };


    // Gastos por transacción (gráfico doughnut)
    const gastosTransaccion = {
      labels: ["Comisiones", "Materia Primas", "Servicios", "Otros"],
      data:   [15, 50, 25, 10] // porcentajes o montos relativos
    };


    // ---------- Charts ----------

    // Ventas por horas (line)
    /*const ctxHoras = (document.getElementById('chartVentasHoras') as HTMLCanvasElement).getContext('2d');
    new Chart(ctxHoras, {
      type: 'line',
      data: {
        labels: ventasPorHoras.labels,
        datasets: [{
          label: 'Ventas (unidades)',
          data: ventasPorHoras.data,
          borderColor: '#6366F1',
          backgroundColor: 'rgba(99,102,241,0.12)',
          fill: true,
          tension: 0.35,
          pointRadius: 3
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: (ctx:any) => ` ${ctx.parsed.y} unidades`
            }
          },
          legend: { display: false }
        }
      }
    });*/

    // Ingresos por día (bar)
    function ventas7dias(resultado:{dia:string, ventas_totales:string}[]){
      const ctxIngresosDias = (document.getElementById('chartIngresosDias') as HTMLCanvasElement).getContext('2d');
      new Chart(ctxIngresosDias, {
        type: 'bar',
        data: {
          labels: resultado.map(x=>x.dia),
          datasets: [{
            label: 'Ingresos',
            data: resultado.map(x=>x.ventas_totales),
            backgroundColor: '#10B981'
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: {
            y: {
              beginAtZero: true,
            }
          }
        }
      });
    }

    // Gastos por transacción (doughnut)
    /*const ctxGastos = (document.getElementById('chartGastosTransaccion') as HTMLCanvasElement).getContext('2d');
    new Chart(ctxGastos, {
      type: 'doughnut',
      data: {
        labels: gastosTransaccion.labels,
        datasets: [{
          data: gastosTransaccion.data,
          backgroundColor: ['#EF4444','#F59E0B','#3B82F6','#6B7280']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });*/

    function graficaVentasVsGastos(resultado:{periodo:string[], ventastotales:string[], gastostotales:string[]}){
      // Ventas vs Gastos (combinado: barras gastos + línea ventas)
      const ctxVG = (document.getElementById('chartVentasGastos') as HTMLCanvasElement).getContext('2d');
      new Chart(ctxVG, {
        data: {
          labels: resultado.periodo,
          datasets: [
            {
              type: 'bar',
              label: 'Ventas',
              data: resultado.ventastotales,
              backgroundColor: 'rgba(239,68,68,0.8)'
            },
            {
              type: 'line',
              label: 'Gastos',
              data: resultado.gastostotales,
              borderColor: '#4F46E5',
              backgroundColor: 'rgba(79,70,229,0.15)',
              tension: 0.3,
              fill: true,
              yAxisID: 'y1'
            }
          ]
        },
        options: {
          responsive: true,
          plugins: { legend: { position: 'bottom' } },
          scales: {
            y: {
              beginAtZero: true,
              position: 'left',
              title: { display: true, text: 'Ventas (COP)' }
            },
            y1: {
              beginAtZero: true,
              position: 'right',
              grid: { drawOnChartArea: false },
              title: { display: true, text: 'Gastos (COP)' }
            }
          },
        }
      });
    }
    

  }
})();