(function():void{
  if(document.querySelector('.inicio')){
    const chartventas = (document.getElementById('chartventas') as HTMLCanvasElement)?.getContext('2d');

    new Chart(chartventas, {
      type: 'line',
      data: {
          labels: ["25-8-2024", "26-8-2024", "27-8-2024", "28-8-2024", "29-8-2024", "30-8-2024", "31-8-2024", "01-09-2024"],//resultado.map(programa=>programa.nombre),
          datasets: [{
          label: '# of Votes',
          data: [8,9,3,5,8,4,2,5],//resultado.map(programa=>programa.total),
          borderColor: '#7C3AED',
          //backgroundColor: ['#ea580c', '#84cc16', '#22d3ee', '#a855f7'],
          backgroundColor: '#00c8c2',
          tension: 0.3,
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
    });
  }
})();