(()=>{
  if(!document.querySelector('.ventas'))return;

  const POS = (window as any).POS;

  const miDialogoPreciosAdicionales = document.querySelector('#miDialogoPreciosAdicionales') as HTMLDialogElement;
  const aplicarprecioadicional = document.querySelector('#aplicarprecioadicional') as HTMLButtonElement;
  const inputComisionProducto = document.querySelector('#comisionproducto') as HTMLInputElement;
  const inputCantidadCalculada = document.querySelector('#inputCantidadCalculada') as HTMLInputElement;
  const operationSum = document.querySelector('#operationSum') as HTMLInputElement;
  const operationLess = document.querySelector('#operationLess') as HTMLInputElement;
  const reset = document.querySelector('#reset') as HTMLInputElement;
  const textCantidadCalculada = document.querySelector('#textCantidadCalculada') as HTMLParagraphElement;
  const lastOperation = document.querySelector('#lastOperation') as HTMLParagraphElement;
  let cantidadTotal:number = 0;
  let historialCalculadora: string[] = [];

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
                            <span class="text-gray-800 dark:text-gray-200 text-lg font-semibold">$${Number(precio.precio).toLocaleString()}</span>
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
      const unitem:CarritoItem|undefined = (POS.carrito as CarritoItem[])?.find(x=>x.idproducto == producto?.id);
      if(unitem!=undefined)unitem.percentcomision = Number(comision);
    }

    miDialogoPreciosAdicionales.close();
    document.removeEventListener("click", POS.cerrarDialogoExterno);
    if(producto != undefined)POS.actualizarCarrito(producto.id, cantidadTotal==0?1:cantidadTotal, true, true, seleccionado?.checked?seleccionado.value:producto.precio_venta);
  });


  //****CALCULADORA
  inputCantidadCalculada.addEventListener('keydown', (e: KeyboardEvent)=>{
    if(e.key === '+') {
      e.preventDefault();
      calcular('sumar');
    }
    if(e.key === '-') {
      e.preventDefault();
      calcular('restar');
    }
  });

  function calcular(operacion: 'sumar' | 'restar'):void{
    const cantidad = Number(inputCantidadCalculada.value);
    /*if(isNaN(cantidad) || inputCantidadCalculada.value === ''){
      inputCantidadCalculada.focus();
      return;
    }*/
    if(operacion === 'sumar'){
      cantidadTotal += cantidad;
      //lastOperation.textContent = `+${cantidad}`;
      historialCalculadora.push(`+${cantidad}`);
      lastOperation.textContent = historialCalculadora.join('');

    }else{
      cantidadTotal -= cantidad;
      //lastOperation.textContent = `-${cantidad}`;
      historialCalculadora.push(`-${cantidad}`);
      lastOperation.textContent = historialCalculadora.join('');
    }
    textCantidadCalculada.textContent = cantidadTotal.toFixed(2);
    inputCantidadCalculada.value = '';
    inputCantidadCalculada.focus();
  }

  operationSum.addEventListener('click', ()=>calcular('sumar'));
  operationLess.addEventListener('click', ()=>calcular('restar'));

  reset.addEventListener('click', ()=>{
    cantidadTotal = 0;
    inputCantidadCalculada.value = '';
    textCantidadCalculada.textContent = '0';
    lastOperation.textContent = '0';
    historialCalculadora.length = 0;
  });
  //****FIN CALCULADORA

  

  const gestionarPreciosAdicionales = {
    miDialogoPreciosAdicionales,
    abrirDialogo(elementProduct: HTMLElement) {
      (document.querySelector('#textCardProduct') as HTMLParagraphElement).textContent = elementProduct.querySelector('.card-producto')?.textContent??'';
      miDialogoPreciosAdicionales.showModal();
      cantidadTotal = 0;
      textCantidadCalculada.textContent = '0';
      lastOperation.textContent = '0';
      historialCalculadora.length = 0;
      const products = POS.products as productsapi[];
      producto = products.find(x=>x.id==elementProduct.dataset.id!);
      cargarPreciosAdicionales();
      document.addEventListener("click", POS.cerrarDialogoExterno);
    },
  };

  POS.gestionarPreciosAdicionales = gestionarPreciosAdicionales;

})();