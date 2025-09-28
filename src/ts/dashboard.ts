(function():void{
  if(document.querySelector('.inicio')){
    
    

    // Ventas por horas (hoy) - ejemplo 24 horas o por horas de apertura (aquí 10 valores)
    const ventasPorHoras = {
      labels: ["08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00"],
      data:    [5, 12, 20, 35, 60, 48, 30, 22, 15, 10]
    };

    // Ingresos últimos 7 días
    const ingresosDias = {
      labels: ["Lun","Mar","Mié","Jue","Vie","Sáb","Dom"],
      data:   [120000, 150000, 180000, 90000, 200000, 170000, 220000]
    };

    // Gastos por transacción (gráfico doughnut)
    const gastosTransaccion = {
      labels: ["Comisiones", "Materia Primas", "Servicios", "Otros"],
      data:   [15, 50, 25, 10] // porcentajes o montos relativos
    };

    // Histórico Ventas vs Gastos (últimos 6 meses)
    const historicoVG = {
      labels: ["Abr","May","Jun","Jul","Ago","Sep"],
      ventas: [1200000, 1500000, 1800000, 1400000, 2000000, 2200000],
      gastos: [700000, 800000, 850000, 780000, 900000, 980000]
    };

    // Stock minimo - ejemplo
    const stockMinimo = [
      { nombre: "Vitamina women Blend", actual: 2, minimo: 5 },
      { nombre: "Aspiradorax", actual: 3, minimo: 4 },
      { nombre: "Bi-Pro Vainilla 5kg", actual: 6, minimo: 8 }
    ];

    // Rellenar lista stock minimo
    const ulStock = document.getElementById('listaStockMinimo')!;
    ulStock.innerHTML = "";
    stockMinimo.forEach(item => {
      const li = document.createElement('li');
      const levelClass = item.actual <= item.minimo ? 'text-red-500 font-bold text-xl' : 'text-yellow-600 font-semibold';
      li.className = 'flex items-center justify-between';
      li.innerHTML = `
        <div>
          <p class="font-medium">${item.nombre}</p>
          <p class="text-xs text-gray-400">Min: ${item.minimo}</p>
        </div>
        <div class="text-right">
          <p class="${levelClass}">${item.actual}</p>
          <p class="text-xs text-gray-400">uds</p>
        </div>
      `;
      ulStock.appendChild(li);
    });

    // ---------- Charts ----------

    // Helper to format currency in tooltips
    const formatCOP = (value:number) => {
      if (typeof value === 'number') return `$${value.toLocaleString('es-CO')}`;
      return value;
    };

    // Ventas por horas (line)
    const ctxHoras = (document.getElementById('chartVentasHoras') as HTMLCanvasElement).getContext('2d');
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
    });

    // Ingresos por día (bar)
    const ctxIngresosDias = (document.getElementById('chartIngresosDias') as HTMLCanvasElement).getContext('2d');
    new Chart(ctxIngresosDias, {
      type: 'bar',
      data: {
        labels: ingresosDias.labels,
        datasets: [{
          label: 'Ingresos',
          data: ingresosDias.data,
          backgroundColor: '#10B981'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: (ctx:any) => formatCOP(ctx.parsed.y)
            }
          },
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { callback: (v:any) => (v >= 1000 ? `$${(v/1000)}k` : `$${v}`) }
          }
        }
      }
    });

    // Gastos por transacción (doughnut)
    const ctxGastos = (document.getElementById('chartGastosTransaccion') as HTMLCanvasElement).getContext('2d');
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
    });

    // Ventas vs Gastos (combinado: barras gastos + línea ventas)
    const ctxVG = (document.getElementById('chartVentasGastos') as HTMLCanvasElement).getContext('2d');
    new Chart(ctxVG, {
      data: {
        labels: historicoVG.labels,
        datasets: [
          {
            type: 'bar',
            label: 'Gastos',
            data: historicoVG.gastos,
            backgroundColor: 'rgba(239,68,68,0.8)'
          },
          {
            type: 'line',
            label: 'Ventas',
            data: historicoVG.ventas,
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
            title: { display: true, text: 'Gastos (COP)' }
          },
          y1: {
            beginAtZero: true,
            position: 'right',
            grid: { drawOnChartArea: false },
            title: { display: true, text: 'Ventas (COP)' }
          }
        },
      }
    });
  }
})();