(()=>{
  if(!document.querySelector('.ventas'))return;

  const POS = (window as any).POS;

  const miDialogoPreciosAdicionales = document.querySelector('#miDialogoPreciosAdicionales') as HTMLDialogElement;
  const aplicarOpcionesProducto = document.querySelector('#aplicarOpcionesProducto') as HTMLButtonElement;
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
  let productoConfigurado: Partial<productsapi> | undefined = {};

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


  aplicarOpcionesProducto.addEventListener('click', ()=>{
    const comision = inputComisionProducto.value.trim();
    const seleccionado = document.querySelector('.inputprecioadicional:checked') as HTMLInputElement;
    const inputPrecioLibre = document.querySelector('#precioLibre') as HTMLInputElement;
    if(producto != undefined && comision!=='' && !Number.isNaN(Number(comision))){  //ajustar porcentaje de comision a producto
      producto.percentcomision = Number(comision);
      //actualizar el carrito con el nuevo valor de comision
      const unitem:CarritoItem|undefined = (POS.carrito as CarritoItem[])?.find(x=>x.idproducto == producto?.id);
      if(unitem!=undefined)unitem.percentcomision = Number(comision);
    }
    miDialogoPreciosAdicionales.close();
    document.removeEventListener("click", POS.cerrarDialogoExterno);
    const precioLibre = obtenerNumero(inputPrecioLibre);
    const prioridadValor = precioLibre!=null?precioLibre:seleccionado?.checked?seleccionado.value:producto?.precio_venta;
    filtrarInsumos(productoConfigurado); //esta en app.ts
    if(producto != undefined)POS.actualizarCarrito(producto.id, cantidadTotal==0?1:cantidadTotal, true, true, prioridadValor+'', productoConfigurado);
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

  

  /////////// INSUMOS DINAMICAMENTE  /////////////
  function cargarInsumos(){
    const listaInsumos = document.querySelector('#listaInsumos') as HTMLElement;
    //while(listaInsumos.firstChild)listaInsumos.removeChild(listaInsumos.firstChild);
    listaInsumos.innerHTML = "";
    const { obligatorios, insumosgrupo } = agruparInsumos();
    renderObligatorios(obligatorios, listaInsumos);
    insumosgrupo.forEach(insumogrupo =>renderGrupo(insumogrupo, listaInsumos));
    eventosCheckbox();
    eventosRadio();
    eventosCantidadInsumo();
  }

  function agruparInsumos() {
    const obligatorios = producto?.insumos?.filter(i => i.grupos_insumos === null) ?? [];
    
    const insumosgrupo = new Map<number, insumo[]>();
    producto?.insumos
        ?.filter(i => i.grupos_insumos !== null)
        .forEach(insumo => {
            const idGrupo = Number(insumo.grupos_insumos?.id);
            if (!insumosgrupo.has(idGrupo))
                insumosgrupo.set(idGrupo, []);

            insumosgrupo.get(idGrupo)!.push(insumo);
        });

    return { obligatorios, insumosgrupo };
  }

  function renderObligatorios(insumos:any[], contenedor:HTMLElement){
    if(insumos.length===0) return;
    contenedor.insertAdjacentHTML("beforeend", `<h3 class="text-lg font-bold mt-5 mb-3">Incluidos</h3>`);
    insumos.forEach(insumo=>{
        contenedor.insertAdjacentHTML("beforeend",
            `<div class="flex justify-between items-center p-3 rounded-lg bg-gray-100 dark:bg-gray-800">
                <span>✔ ${insumo.nombre}</span>
            </div>`
        );
    });
  }

  //   insumos = [{idproducto:1, idsubproducto: 3, seleccionado: 1}]
  function renderGrupo(insumos:any[], contenedor:HTMLElement){
    const grupo = insumos[0].grupos_insumos;
    contenedor.insertAdjacentHTML("beforeend", `<h3 class="text-lg font-bold mt-6 mb-3">${grupo.nombre}</h3>`);
    if(Number(grupo.tipo)===0){
        renderRadios(insumos, contenedor);
    }else{
        renderCheckbox(insumos, contenedor);
    }
  }

  function renderRadios(insumos:any[], contenedor:HTMLElement){
    insumos.forEach(insumo=>{
        contenedor.insertAdjacentHTML("beforeend",
            `<label class="flex justify-between items-center p-4 rounded-xl bg-indigo-50 border border-indigo-200 cursor-pointer">
              <div class="flex items-center gap-3">
                <input
                  type="radio"
                  class="inputInsumoRadio"
                  data-idproducto="${producto?.id}"
                  data-idinsumo="${insumo.id_subproducto}"
                  data-idgrupo="${insumo.grupos_insumos.id}"
                  name="grupo_${insumo.grupos_insumos.id}" 
                  ${Number(insumo.seleccionado) ? "checked":""}
                >
                <span class="text-center text-slate-600 font-medium">${insumo.nombre}</span>
              </div>
            </label>`
        );
    });
  }

  function renderCheckbox(insumos:any[], contenedor:HTMLElement){
    insumos.forEach(insumo=>{

        contenedor.insertAdjacentHTML("beforeend", 
          `<label class="block p-4 rounded-xl bg-indigo-50 border border-indigo-200">
            <div class="flex justify-between items-center">
              <div class="flex items-center gap-3">
                <input
                  type="checkbox"
                  class="inputInsumoCheckbox"
                  data-idproducto="${producto?.id}"
                  data-idinsumo="${insumo.id_subproducto}"
                  data-idgrupo="${insumo.grupos_insumos.id}"
                  ${Number(insumo.seleccionado) ? "checked":""}
                >
                <span class="text-center text-slate-600 font-medium">${insumo.nombre}</span>
              </div>
              ${htmlPrecioExtra(insumo)}
            </div>
            ${htmlCantidad(insumo)}
          </label>`
        );
    });
  }


  function htmlPrecioExtra(insumo: insumo): string {
    const precioExtra = Number(insumo.precio_extra);
    if (precioExtra <= 0)return "";
    return `<span class="text-green-500 text-xl font-medium">+$${precioExtra.toLocaleString()}</span>`;
  }


  function htmlCantidad(insumo: insumo): string {
    if (Number(insumo.permite_aumentar) === 0)return "";
    return `
        <div class="mt-3 flex items-center justify-center gap-4">
            <label class="text-slate-600 text-xl">Cantidad</label>
            <input
              type="number"
              class="inputCantidadInsumo w-36 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block p-3 mt-2 h-10 text-lg focus:outline-none focus:ring-1"
              data-idinsumo="${insumo.id_subproducto}"
              value="${insumo.cantidadsubproducto}" min="${insumo.cantidadsubproducto}" step="any"
            >
        </div>`;
  }


  function eventosCheckbox() {
    const checkboxes = document.querySelectorAll<HTMLInputElement>(".inputInsumoCheckbox");
    checkboxes.forEach(checkbox => checkbox.addEventListener("change", actualizarCheckbox));
  }

  function eventosRadio() {
    const radios = document.querySelectorAll<HTMLInputElement>(".inputInsumoRadio");
    radios.forEach(radio => radio.addEventListener("change", actualizarRadio));
  }

  function eventosCantidadInsumo() {
    const cantidades = document.querySelectorAll<HTMLInputElement>(".inputCantidadInsumo");
    cantidades.forEach(input => input.addEventListener("change", actualizarCantidadInsumo));
  }

  function actualizarCantidadInsumo(e: Event) {
    const input = e.target as HTMLInputElement;
    const idInsumo = Number(input.dataset.idinsumo);
    const insumo = productoConfigurado?.insumos?.find(
      item => Number(item.id_subproducto) === idInsumo
    );
    if(!insumo)return;

    const cantidadBase = Number(
      producto?.insumos?.find(item => Number(item.id_subproducto) === idInsumo)?.cantidadsubproducto ?? 0
    );
    const cantidad = Number(input.value);
    const cantidadValida = Number.isFinite(cantidad) && cantidad >= cantidadBase
      ? cantidad
      : cantidadBase;

    insumo.cantidadsubproducto = cantidadValida.toString();
    input.value = cantidadValida.toString();
  }


  function actualizarCheckbox(e: Event) {
    const checkbox = e.target as HTMLInputElement;
    const idInsumo = Number(checkbox.dataset.idinsumo);
    const insumo = productoConfigurado?.insumos?.find(i => Number(i.id_subproducto) === idInsumo);
    if (!insumo) return;
    insumo.seleccionado = checkbox.checked ?'1':'0';
  }


  function actualizarRadio(e: Event) {
    const radio = e.target as HTMLInputElement;
    if(!radio.checked)return;

    const idGrupo = Number(radio.dataset.idgrupo);
    const idInsumo = Number(radio.dataset.idinsumo);
    productoConfigurado?.insumos?.forEach(insumo => {
        if(Number(insumo.grupos_insumos?.id) === idGrupo)
            insumo.seleccionado = '0';
    });

    const seleccionado = productoConfigurado?.insumos?.find(i=>Number(i.id_subproducto) === idInsumo);
    if(seleccionado)seleccionado.seleccionado = '1';
  }


  /*function filtrarInsumos(){
    const insumos = productoConfigurado?.insumos??[];
    const ultimoSeleccionUnica  = insumos.filter(i=>i.grupos_insumos?.tipo === "0"&&i.seleccionado === "1").at(-1);

    const nuevosElementos:insumo[] = [
              ...(ultimoSeleccionUnica  ? [ultimoSeleccionUnica ] : []),
              ...insumos.filter(i=>i.grupos_insumos?.tipo === "1" &&i.seleccionado === "1")
    ];
    insumos.splice(0, insumos.length, ...nuevosElementos);
  }*/
  /*
  function actualizarCheckbox(e: Event) {
    const checkbox = e.target as HTMLInputElement;
    const idInsumo = Number(checkbox.dataset.idinsumo);
    const insumo = productoConfigurado?.insumos?.find(i => Number(i.id_subproducto) === idInsumo);
    if (!insumo || !productoConfigurado) return;
    insumo.seleccionado = checkbox.checked ?'1':'0';

    if(insumo.seleccionado == '1'){
      const existe = producto?.insumos?.some(i => Number(i.id_subproducto) === idInsumo);
      if (!existe)productoConfigurado?.insumos?.push(insumo);
    }else{
       productoConfigurado.insumos = productoConfigurado?.insumos?.filter(i => Number(i.id_subproducto) !== idInsumo);
    }

  }


  function actualizarRadio(e: Event) {
    const radio = e.target as HTMLInputElement;
    if(!radio.checked)return;

    const idGrupo = Number(radio.dataset.idgrupo);
    const idInsumo = Number(radio.dataset.idinsumo);
    productoConfigurado!.insumos = productoConfigurado?.insumos?.filter(insumo => Number(insumo.grupos_insumos?.id) !== idGrupo);

    console.log(productoConfigurado);
    const seleccionado = producto?.insumos?.find(
        i => Number(i.id_subproducto) === idInsumo
    );

    if(seleccionado&&productoConfigurado){
      seleccionado.seleccionado = '1';
      productoConfigurado.insumos?.push(seleccionado);
    }
  }
  */


  ///////// FIN INSUMOS DINAMICOS  //////////


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
      console.log(products);
      producto = products.find(x=>x.id==elementProduct.dataset.id!);
      productoConfigurado = structuredClone(producto);
      cargarPreciosAdicionales();
      cargarInsumos();
      document.addEventListener("click", POS.cerrarDialogoExterno);
    },
  };

  POS.gestionarPreciosAdicionales = gestionarPreciosAdicionales;

})();
