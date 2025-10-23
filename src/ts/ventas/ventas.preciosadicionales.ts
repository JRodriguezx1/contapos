(()=>{
  if(!document.querySelector('.ventas'))return;

  const POS = (window as any).POS;

  const miDialogoPreciosAdicionales = document.querySelector('#miDialogoPreciosAdicionales') as any;
  const aplicarprecioadicional = document.querySelector('#aplicarprecioadicional') as HTMLButtonElement;

  function cargarPreciosAdicionales(id:string) {
    const listaPrecios = document.querySelector('#listaPrecios') as HTMLElement;
    const products = POS.products as productsapi[];
    const producto = products.find(x=>x.id==id);

    while(listaPrecios.firstChild)listaPrecios.removeChild(listaPrecios.firstChild);

    producto?.preciosadicionales.forEach(precio=>{
      const preciohtml = `<label class="flex justify-between items-center p-4 rounded-xl bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-800 cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition">
                          <div class="flex items-center gap-3">
                              <input type="radio" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 inputprecioadicional" data-precio="${id}"  name="precioSeleccionado" value="${precio.precio}">
                              <span class="text-gray-900 dark:text-gray-100 text-lg font-medium">Precio adicional</span>
                          </div>
                          <span class="text-gray-800 dark:text-gray-200 text-lg font-semibold">${precio.precio}</span>
                      </label>`;
      listaPrecios.insertAdjacentHTML('beforeend', preciohtml);
    });
  }

  aplicarprecioadicional.addEventListener('click', ()=>{
    if(document.querySelector('.inputprecioadicional')){  //si existe uno de los input de precios adicionales
      const seleccionado = document.querySelector('.inputprecioadicional:checked') as HTMLInputElement;
      POS.actualizarCarrito(seleccionado.dataset.precio, 1, true, true, seleccionado.value);
      console.log(seleccionado);
    }
  });


  const gestionarPreciosAdicionales = {
    miDialogoPreciosAdicionales,
    abrirDialogo(elementProduct: HTMLElement) {
      miDialogoPreciosAdicionales.showModal();
      cargarPreciosAdicionales(elementProduct.dataset.id!);
      document.addEventListener("click", POS.cerrarDialogoExterno);
      console.log("Abriendo precios para producto", elementProduct.dataset.id);
    },  
  };

  POS.gestionarPreciosAdicionales = gestionarPreciosAdicionales;

})();