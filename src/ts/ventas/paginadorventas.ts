(()=>{
    if(document.querySelector('.paginadorventas')){

      const filtrocategorias = document.querySelectorAll('.filtrocategorias');

      var options = {
        valueNames: [ 'card-producto', { data: ['categoria', 'code'] }],
        page: 18,
        pagination: true,
      };
      var hackerList = new List('hacker-list', options);

      filtrocategorias.forEach(element => {
        element.addEventListener('click', (e)=>{
          const categoria:string = (e.target as HTMLElement).dataset.categoria!;
          hackerList.filter((item: any)=>{
            if(categoria === 'Todos')return true;
            return item.values().categoria === categoria}
          );
        });
      });

    }

})();