(()=>{
  if(!document.querySelector('.ventas'))return;

  const POS = (window as any).POS;

  const miDialogoPreciosAdicionales = document.querySelector('#miDialogoPreciosAdicionales') as any;
  const aplicarprecioadicional = document.querySelector('#aplicarprecioadicional') as HTMLButtonElement;
  const inputComisionProducto = document.querySelector('#comisionproducto') as HTMLInputElement;

  let producto:  Partial<productsapi>|undefined = {};

  function cargarPreciosAdicionales() {
    const listaPrecios = document.querySelector('#listaPrecios') as HTMLElement;

    while(listaPrecios.firstChild)listaPrecios.removeChild(listaPrecios.firstChild);

    producto?.preciosadicionales?.forEach(precio=>{
      const preciohtml = `<label class="flex justify-between items-center p-4 rounded-xl bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-800 cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition">
                          <div class="flex items-center gap-3">
                              <input type="radio" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 inputprecioadicional" data-idproducto="${producto?.id}"  name="precioSeleccionado" value="${precio.precio}">
                              <span class="text-gray-900 dark:text-gray-100 text-lg font-medium">Precio adicional</span>
                          </div>
                          <span class="text-gray-800 dark:text-gray-200 text-lg font-semibold">${precio.precio}</span>
                      </label>`;
      listaPrecios.insertAdjacentHTML('beforeend', preciohtml);
    });
  }

  aplicarprecioadicional.addEventListener('click', ()=>{
    const comision = inputComisionProducto.value.trim();
    const seleccionado = document.querySelector('.inputprecioadicional:checked') as HTMLInputElement;

    if(producto != undefined && comision!=='' && !Number.isNaN(Number(comision))){  //ajustar porcentaje de comision a producto
      producto.percentcomision = Number(comision);
      //actualizar el carrito con el nuevo valor de comision
      const unitem:CarritoItem|undefined = (POS.carrito as CarritoItem[]).find(x=>x.idproducto == producto?.id);
      if(unitem!=undefined)unitem.percentcomision = Number(comision);
    }

    if(producto != undefined)POS.actualizarCarrito(producto.id, 1, true, true, seleccionado?.checked?seleccionado.value:producto.precio_venta);
  });


  const gestionarPreciosAdicionales = {
    miDialogoPreciosAdicionales,
    abrirDialogo(elementProduct: HTMLElement) {
      miDialogoPreciosAdicionales.showModal();
      const products = POS.products as productsapi[];
      producto = products.find(x=>x.id==elementProduct.dataset.id!);
      cargarPreciosAdicionales();
      document.addEventListener("click", POS.cerrarDialogoExterno);
    },
  };

  POS.gestionarPreciosAdicionales = gestionarPreciosAdicionales;

})();