
(()=>{
    if(document.querySelector('.paginadorventas')){

      const filtrocategorias = document.querySelectorAll('.filtrocategorias');  //los btns de las categorias

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



      const btnCarritoMovil = document.querySelector('#btnCarritoMovil') as HTMLButtonElement; //btn para abrir el modal del carrito de ventas en movil
      const contenidocarrito = document.getElementById('contenidocarrito') as HTMLElement;
      const contenedorDesktop = document.getElementById('contenedorDesktop') as HTMLDivElement;
      const miDialogoCarritoMovil = document.getElementById('miDialogoCarritoMovil') as HTMLDialogElement;
      const btnCerrarCarritoMovil = document.querySelector('#btnCerrarCarritoMovil') as HTMLButtonElement;

      window.addEventListener('resize', ()=>{
        if (window.innerWidth >= 992) {
          contenedorDesktop.appendChild(contenidocarrito);
          miDialogoCarritoMovil.close();
          document.removeEventListener("click", cerrarDialogoExterno);
        } else {
          miDialogoCarritoMovil.appendChild(contenidocarrito);
        }
      });

      // btn para abrir el carrito de ventas en movil
      btnCarritoMovil?.addEventListener('click', (e)=>{
        miDialogoCarritoMovil.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      });

      btnCerrarCarritoMovil.addEventListener('click', ()=>miDialogoCarritoMovil.close());

      function cerrarDialogoExterno(event:Event) {
        const f = event.target;
        if (f === miDialogoCarritoMovil ) {
          miDialogoCarritoMovil.close();
          document.removeEventListener("click", cerrarDialogoExterno);
        }
      }


    }

})();