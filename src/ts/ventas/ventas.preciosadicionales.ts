(()=>{
  if(!document.querySelector('.ventas'))return;

  const POS = (window as any).POS;

  const miDialogoPreciosAdicionales = document.querySelector('#miDialogoPreciosAdicionales') as any;

  function cargarPreciosAdicionales() {
    // tu lógica existente
    const products = POS.products;
    console.log(products);
    const listaPrecios = document.querySelector('#listaPrecios') as HTMLElement;
    const precio = `<label class="flex justify-between items-center p-4 rounded-xl bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-800 cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="precioSeleccionado" value="20000" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-900 dark:text-gray-100 text-lg font-medium">Precio normal</span>
                        </div>
                        <span class="text-gray-800 dark:text-gray-200 text-lg font-semibold">$20.000</span>
                    </label>`;
    //listaPrecios.insertAdjacentHTML('beforeend', precio);

  }

  const gestionarPreciosAdicionales = {
    miDialogoPreciosAdicionales,
    abrirDialogo(elementProduct: HTMLElement) {
      miDialogoPreciosAdicionales.showModal();
      document.addEventListener("click", POS.cerrarDialogoExterno);
      cargarPreciosAdicionales();
      console.log("Abriendo precios para producto", elementProduct.dataset.id);
    },  
  };

  POS.gestionarPreciosAdicionales = gestionarPreciosAdicionales;

})();