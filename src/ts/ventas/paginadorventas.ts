
(()=>{
    if(document.querySelector('.paginadorventas')){

      const POS = (window as any).POS;

      const inputBuscar = document.querySelector<HTMLInputElement>('#buscarproducto');
      const filtrocategorias = document.querySelectorAll('.filtrocategorias');  //los btns de las categorias
      const btnCategorias = document.querySelector<HTMLButtonElement>('#btnCategorias');
      const menuCategorias = document.querySelector<HTMLDivElement>('#menuCategorias');

      var options = {
        valueNames: [ 'card-producto', { data: ['categoria', 'code'] }],
        page: 18,
        pagination: true,
      };
      const productos = document.querySelectorAll<HTMLElement>('.producto');
      if(productos.length)
      var hackerList = new List('hacker-list', options);
      POS.hackerList = hackerList;  //exportar

      filtrocategorias.forEach(element => {
        element.addEventListener('click', (e)=>{
          const categoria:string = (e.target as HTMLElement).dataset.categoria!;
          document.querySelector('#categorySelect')!.textContent = categoria;
          if(hackerList)
            hackerList.filter((item: any)=>{
              hackerList.search('');
              if(categoria === 'Todos')return true;
              return item.values().categoria === categoria
            });
        });
      });


      inputBuscar?.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter') return;

        e.preventDefault();

        if (!hackerList) return;

        const items = hackerList.visibleItems;

        if (!items.length) return;

        const productosku = items[0].elm as HTMLElement;
        const products = POS.products as productsapi[];
        const precio = products.find(x=>x.id == productosku.dataset.id)?.precio_venta;
        POS.actualizarCarrito(productosku.dataset.id, 1, true, true, precio);

        inputBuscar.value = '';
        hackerList.search('');
      });


      //////--------  Apertura y cierre del btn Categorias

      btnCategorias?.addEventListener('click', (e) => {
        e.stopPropagation(); // evita cierre inmediato
        menuCategorias?.classList.toggle('hidden');
        if(!menuCategorias?.classList.contains('hidden'))document.addEventListener('click', cerrarMenuCategorias);
      });
      // cerrar al hacer click en una categoría
      document.querySelectorAll('.filtrocategorias').forEach(el => {
        el.addEventListener('click', () => {
          menuCategorias?.classList.add('hidden');
          document.removeEventListener('click', cerrarMenuCategorias);
        });
      });
      // cerrar al hacer click fuera del menú
      function cerrarMenuCategorias() {
        menuCategorias?.classList.add('hidden');
        document.removeEventListener('click', cerrarMenuCategorias);
      }



      //////---------------------------------------------------------------------------


      const btnCarritoMovil = document.querySelector('#btnCarritoMovil') as HTMLButtonElement; //btn para abrir el modal del carrito de ventas en movil
      const contenidocarrito = document.getElementById('contenidocarrito') as HTMLElement;
      const contenedorDesktop = document.getElementById('contenedorDesktop') as HTMLDivElement;
      const miDialogoCarritoMovil = document.getElementById('miDialogoCarritoMovil') as HTMLDialogElement;
      const btnCerrarCarritoMovil = document.querySelector('#btnCerrarCarritoMovil') as HTMLButtonElement;
      const screenWidth:number = window.innerWidth;

      if(screenWidth<992)miDialogoCarritoMovil.appendChild(contenidocarrito);

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

      btnCerrarCarritoMovil.addEventListener('click', ()=>{
        miDialogoCarritoMovil.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      });

      function cerrarDialogoExterno(event:Event) {
        const f = event.target;
        if (f === miDialogoCarritoMovil ) {
          miDialogoCarritoMovil.close();
          document.removeEventListener("click", cerrarDialogoExterno);
        }
      }


      /*const paginador ={

      }
      POS.paginador = paginador;*/

    }

})();