(()=>{
  if(document.querySelector('.ventas')){

    const POS = (window as any).POS;
     
    const selectCliente = POS.gestionClientes.selectCliente;
    const dirEntrega = POS.gestionClientes.dirEntrega;
    const productos = document.querySelectorAll<HTMLElement>('#producto')!;
    const selectVendedor = (document.querySelector('#vendedor') as HTMLSelectElement);
    const valorDomicilio = document.querySelector('#valorDomicilio') as HTMLInputElement;
    const contentproducts = document.querySelector('#productos');
    const btnEntrega = document.querySelector('#btnEntrega') as HTMLButtonElement;
    const btnPresencial = document.querySelector('#btnPresencial') as HTMLButtonElement;
    const modalidadEntrega = document.querySelector('#modalidadEntrega') as HTMLElement;
    const totalunidades = document.querySelector('#totalunidades') as HTMLElement;
    const tablaventa = document.querySelector('#tablaventa tbody');
    const carritoVacio = document.querySelector('#carritoVacio') as HTMLElement;
    const btnguardar = document.querySelector('#btnguardar');
    const btnfacturar = document.querySelector('#btnfacturar');
    const btnaplicarcredito = document.querySelector('#btnaplicarcredito');
    const btnAddCliente = document.querySelector('#addcliente') as HTMLElement;
    const miDialogoAddCliente = POS.gestionClientes.miDialogoAddCliente;
    //const miDialogoAddDir = POS.gestionClientes.miDialogoAddDir;
    const miDialogoOtrosProductos = POS.gestionOtrosProductos.miDialogoOtrosProductos;
    const miDialogoPreciosAdicionales = POS.gestionarPreciosAdicionales.miDialogoPreciosAdicionales;
    const miDialogoFacturarA = POS.gestionarAdquiriente.miDialogoFacturarA;
    const miDialogoDescuento = POS.gestionarDescuentos.miDialogoDescuento;
    const miDialogoCredito = document.querySelector('#miDialogoCredito') as any;
    const miDialogoGuardar = document.querySelector('#miDialogoGuardar') as any;
    const miDialogoFacturar = document.querySelector('#miDialogoFacturar') as any;
    const miDialogoCalculadora = document.querySelector('#miDialogoCalculadora') as HTMLDialogElement;
    const btnCaja = document.querySelector('#caja') as HTMLSelectElement; //select de la caja en el modal pagar
    const btnTipoFacturador = document.querySelector('#facturador') as HTMLSelectElement; //select del consecutivo o facturador en el modal de pago
    const btnPagar = document.getElementById('btnPagar') as HTMLInputElement;
    const btnCarritoMovil = document.querySelector('#btnCarritoMovil') as HTMLButtonElement|null;
    const carritoMovilBadge = document.querySelector('#carritoMovilBadge') as HTMLElement|null;
    const ventaCarritoToast = document.querySelector('#ventaCarritoToast') as HTMLElement|null;
    const ventaCarritoToastTitle = document.querySelector('#ventaCarritoToastTitle') as HTMLElement|null;
    const ventaCarritoToastMeta = document.querySelector('#ventaCarritoToastMeta') as HTMLElement|null;
    
    let carrito:{id:string, idproducto:string, tipoproducto:string, tipoproduccion:string, idcategoria: string, foto:string, nombreproducto: string, rendimientoestandar:string, costo:string, valorunidad: string, stock: number, promediostock: number, prioridadcomision: string, percentcomision: number, valorcomision: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total: number, insumos:insumo[]}[]=[];
    const valorTotal = {porcentgananciauser: 0, valorgananciauser: 0, subtotal: 0, base: 0, valorimpuestototal: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
    let tarifas:{id:string, idcliente:string, nombre:string, valor:string}[] = [];
    let indexcarrito:number, nombretarifa:string|undefined='', tipoventa:string="Contado";
    const promesas: Promise<any>[] = [];
    let printerBT:string = getParam.impresora_principal_de_CAJA_para_Android_por_BT.valor_final;
    
    function resaltarSelectorCliente():void{
      if(!btnAddCliente)return;
      btnAddCliente.classList.remove('cliente-required-pulse');
      void btnAddCliente.offsetWidth;
      btnAddCliente.classList.add('cliente-required-pulse');
      btnAddCliente.scrollIntoView({behavior: 'smooth', block: 'center'});
      setTimeout(()=>btnAddCliente.classList.remove('cliente-required-pulse'), 3600);
    }    
    const constImp: {[key:string]: number} = {};
    constImp['excluido'] = 0;
    constImp['0'] = 0;  //exento de iva, tarifa 0%
    constImp['5'] = 0.0476190476190476; //iva, tarifa al 5%,  Bienes/servicios al 5
    constImp['8'] = 0.0740740740740741; //inc, tarifa al 8%,  impuesto nacional al consumo

    function formatCantidadBadge(cantidad:number): string{
      if(cantidad >= 1000000){
        return (cantidad / 1000000).toLocaleString('es-CO', {maximumFractionDigits: 1}) + 'M';
      }
      if(cantidad >= 10000){
        return (cantidad / 1000).toLocaleString('es-CO', {maximumFractionDigits: 1}) + 'K';
      }
      return cantidad.toLocaleString('es-CO');
    }

    function ajustarAnchoCantidad(input:HTMLInputElement, cantidad:number|string): void{
      const largo = String(cantidad || 0).length;
      input.style.width = `${Math.min(Math.max(largo + 2, 5), 10)}ch`;
      input.title = String(cantidad || 0);
    }

    let ventaCarritoToastTimer:number|undefined;
    function actualizarBadgeCarritoMovil(cantidad:number): void{
      if(!carritoMovilBadge)return;
      carritoMovilBadge.textContent = formatCantidadBadge(cantidad);
      carritoMovilBadge.title = cantidad.toLocaleString('es-CO');
      carritoMovilBadge.classList.toggle('is-visible', cantidad > 0);
    }

    function mostrarFeedbackCarrito(nombre:string, cantidadProducto:number): void{
      if(window.innerWidth >= 992)return;

      if(btnCarritoMovil){
        btnCarritoMovil.classList.remove('carrito-feedback-pulse');
        void btnCarritoMovil.offsetWidth;
        btnCarritoMovil.classList.add('carrito-feedback-pulse');
        setTimeout(()=>btnCarritoMovil.classList.remove('carrito-feedback-pulse'), 500);
      }

      if(ventaCarritoToast && ventaCarritoToastTitle && ventaCarritoToastMeta){
        ventaCarritoToastTitle.textContent = `${nombre} agregado`;
        ventaCarritoToastMeta.textContent = `Cantidad: ${cantidadProducto.toLocaleString('es-CO')}`;
        ventaCarritoToast.classList.add('is-visible');
        if(ventaCarritoToastTimer)window.clearTimeout(ventaCarritoToastTimer);
        ventaCarritoToastTimer = window.setTimeout(()=>ventaCarritoToast.classList.remove('is-visible'), 1500);
      }
    }

    function mostrarFeedbackProducto(productoEl:HTMLElement, nombre:string, cantidadProducto:number): void{
      productoEl.classList.remove('producto-agregado-feedback');
      void productoEl.offsetWidth;
      productoEl.classList.add('producto-agregado-feedback');
      setTimeout(()=>productoEl.classList.remove('producto-agregado-feedback'), 900);

      mostrarFeedbackCarrito(nombre, cantidadProducto);
    }
    constImp['16'] = 0.1379310344827586; //iva, tarifa al 16%,  contratos firmados con el estado antes de ley 1819
    constImp['19'] = 0.1596638655462185; //iva, tarifa al 19%,  tarifa general

    interface Item {
      id_impuesto: number,
      facturaid: number,
      basegravable: number,
      valorimpuesto: number
    }
    let factimpuestos:Item[] = [];

    let products:productsapi[]=[], unproducto:productsapi;
    const mapMediospago = new Map();

    const mediosPagoDBMAP = new Map<string, string>(  //se usa para imprimir los medios de pago en el servidor de impresion
      mediosPagoDB.map(m => [m.id, m.mediopago]) //mediosPagoDB se declara en app.ts el cual viene del <script> en index.php que convierte el array de medios de pago de php a js.
    );

    (async ()=>{
      products = await POS.productosAPI.getProductosAPI();
      POS.products = products;  //Se expone globalmente
      POS.gestionOtrosProductos.otrosproductos();
    })();

    /*productos.forEach(producto=>{
      producto.addEventListener('click', (e)=>{
        console.log(producto.dataset.id);
      });
    });*/
    


                       /******** *********/

    selectFacturadorSegunCaja(btnCaja);
    btnCaja.addEventListener('change', (e:Event)=>selectFacturadorSegunCaja(e.target as HTMLSelectElement));
    function selectFacturadorSegunCaja(z:HTMLSelectElement){
      $('#facturador').val(z.options[z.selectedIndex].dataset.idfacturador??'1');
    }

    POS.gestionClientes.clientes();  //inicializa modulo de clientes

    //////////// evento al boton modalidad de entrega //////////////
    function tipoEntregaActual(): string {
      return modalidadEntrega.textContent!.replace(': ', '').trim();
    }

    function actualizarEstadoCarrito(): void {
      if(carritoVacio)carritoVacio.classList.toggle('hidden', carrito.length > 0);
    }

    function normalizarValorDomicilio(): number {
      const valor = Number(valorDomicilio.value || 0);
      return Number.isFinite(valor) ? valor : 0;
    }

    function actualizarBotonesEntrega(): void {
      const tipo = tipoEntregaActual();
      const clasesActivo = ['bg-white', 'text-indigo-700', 'shadow-sm'];
      const clasesInactivo = ['text-slate-600', 'hover:bg-white/70', 'hover:text-indigo-700'];
      btnPresencial?.classList.remove(...clasesActivo, ...clasesInactivo);
      btnEntrega?.classList.remove(...clasesActivo, ...clasesInactivo);
      if(tipo === 'Domicilio'){
        btnEntrega?.classList.add(...clasesActivo);
        btnPresencial?.classList.add(...clasesInactivo);
        valorDomicilio?.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-100');
      }else{
        btnPresencial?.classList.add(...clasesActivo);
        btnEntrega?.classList.add(...clasesInactivo);
        valorDomicilio?.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-100');
      }
    }

    function cambiarTipoEntrega(tipo: 'Presencial' | 'Domicilio'): void {
      modalidadEntrega.textContent = tipo;
      if(tipo === 'Domicilio' && selectCliente.value === ''){
        msjalertToast('warning', 'Cliente requerido', 'Selecciona un cliente para activar el domicilio.');
        resaltarSelectorCliente();
      }
      printTarifaEnvio();
      valorCarritoTotal();
      actualizarBotonesEntrega();
    }

    btnPresencial?.addEventListener('click', ()=> cambiarTipoEntrega('Presencial'));
    btnEntrega?.addEventListener('click', ()=> cambiarTipoEntrega('Domicilio'));

    valorDomicilio?.addEventListener('input', ()=>{
      if(normalizarValorDomicilio() > 0 && tipoEntregaActual() !== 'Domicilio'){
        cambiarTipoEntrega('Domicilio');
        return;
      }
      printTarifaEnvio();
      valorCarritoTotal();
      actualizarBotonesEntrega();
    });

    valorDomicilio?.addEventListener('blur', ()=>{
      if(tipoEntregaActual() === 'Domicilio' && normalizarValorDomicilio() <= 0){
        valorDomicilio.classList.add('border-amber-400', 'ring-2', 'ring-amber-100');
        setTimeout(()=> valorDomicilio.classList.remove('border-amber-400', 'ring-2', 'ring-amber-100'), 1400);
      }
    });

    ///////// funcion que imprime el valor de la tarifa segun direccion ///////////
    function printTarifaEnvio():void{
      tarifas = POS.tarifas; //viene de ahelper.clientes.ts
      const selectDir = dirEntrega.options[dirEntrega.selectedIndex];
      document.querySelector('#confirmarDespacho')?.classList.remove('hidden');
      if(tipoEntregaActual() == "Presencial"){
        document.querySelector('#confirmarDespacho')?.classList.add('hidden');
        valorTotal.valortarifa = 0;
        valorTotal.idtarifa = 0;
        nombretarifa = ''; 
        actualizarBotonesEntrega();
        return; 
      }   

      const valorManual = normalizarValorDomicilio();
      if(valorManual > 0){
        valorTotal.valortarifa = valorManual;
        valorTotal.idtarifa = Number(selectDir?.dataset.idtarifa || 0);
        const objtarifaManual = tarifas.find(tarifa => tarifa.idcliente == selectDir?.dataset.idcliente && tarifa.id == selectDir?.dataset.idtarifa);
        nombretarifa = objtarifaManual?.nombre || 'Domicilio';
        actualizarBotonesEntrega();
        return;
      }

      if(dirEntrega.selectedIndex == -1){
        document.querySelector('#confirmarDespacho')?.classList.add('hidden');
        valorTotal.valortarifa = 0;
        valorTotal.idtarifa = 0;
        nombretarifa = '';
        actualizarBotonesEntrega();
        return;
      }

      if(selectDir?.dataset.idtarifa && tipoEntregaActual() == "Domicilio"){
        const objtarifa = tarifas.find(tarifa =>{
          if(tarifa.idcliente == selectDir.dataset.idcliente && tarifa.id == selectDir.dataset.idtarifa)return true;
        });
        valorTotal.valortarifa = Number(objtarifa?.valor || 0);
        valorTotal.idtarifa = Number(objtarifa?.id || 0);
        nombretarifa = objtarifa?.nombre || 'Domicilio';
      }
      actualizarBotonesEntrega();
    }

    actualizarBotonesEntrega();

    //////////// evento a toda el area de los productos a seleccionar //////////////
    contentproducts?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.producto');
      if(!elementProduct)return;

      if((e.target as HTMLElement).closest('#precioadicional')){
        POS.gestionarPreciosAdicionales.abrirDialogo(elementProduct);  //ejecuta los precios adicionales
        return;   
      }

      if(false && window.innerWidth < 992){
        // Crear popup
        const popup = document.createElement('div');
        popup.className = `popup absolute z-40 right-8 top-1/3 opacity-0 translate-x-0 translate-y-0 transition-all duration-500 w-10 h-10 rounded-full text-center grid place-items-center bg-teal-400 text-white font-semibold text-lg`;
        popup.innerHTML = '';
        elementProduct!.appendChild(popup);
        // Forzar reflow para activar transiciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n
        requestAnimationFrame(() => {
          popup.classList.remove("opacity-0", "translate-y-0", "translate-x-0");
          popup.classList.add("opacity-100", "-translate-y-14", "translate-x-10");
        });
        const popupx = document.querySelectorAll('.popup');
        setTimeout(() => {popupx.forEach(t=>{t.remove();});}, 2500);
      }

      const precio = products.find(x=>x.id == (elementProduct as HTMLElement).dataset.id)?.precio_venta;
      const productoConfigurado = structuredClone(products.find(x=>x.id == (elementProduct as HTMLElement).dataset.id)!);
      filtrarInsumos(productoConfigurado);
      actualizarCarrito((elementProduct as HTMLElement).dataset.id!, 1, true, true, precio, productoConfigurado);
      const productoAgregado = carrito.find(x=>x.idproducto == (elementProduct as HTMLElement).dataset.id && x.valorunidad == precio && mismaConfiguracion(x, productoConfigurado));
      const nombre = (elementProduct.querySelector('.card-producto')?.textContent || 'Producto').trim();
      mostrarFeedbackProducto(elementProduct as HTMLElement, nombre, productoAgregado?.stock ?? 1);
    });
    

    function printProduct(id:string, precio:string, index:number){ //recibe el id del producto
      //const indice = carrito.findIndex(x => x.idproducto == id && x.valorunidad == precio);
      //const uncarrito = carrito.find(x=>x.idproducto==id&&x.valorunidad==precio)!;
    
      //if(indice === -1)return;
      const uncarrito = carrito[index];

      const tr = document.createElement('TR');
      tr.classList.add(
          'productselect',
          'border-b',
          'border-slate-100',
          'hover:bg-slate-50',
          'transition-colors'
      );
      tr.dataset.id = `${id}`;
      tr.dataset.precio = precio;
      tr.dataset.indexcarrito = index+'';
      tr.insertAdjacentHTML('afterbegin',    
        `<td class="pl-4 pr-3 py-3 align-middle text-left">
            <p class="
                nombreproducto
                text-xl
                font-semibold
                text-slate-800
                leading-7
                break-words
                max-w-[260px]
            ">
                ${uncarrito?.nombreproducto}
            </p>
        </td>
        <td class="px-2 py-3 align-middle w-36 min-w-[9rem]">
          <div class="flex items-center justify-center gap-1.5 min-w-max">
            <button type="button" class="w-7 h-7 shrink-0 bg-indigo-700 text-white rounded-full flex items-center justify-center">
              <span class="menos material-symbols-outlined text-base">remove</span>
            </button>
            <input
              type="text"
              class="
                  inputcantidad
                  min-w-[6ch]
                  max-w-[12ch]
                  h-9
                  px-2
                  rounded-lg 
                  border
                  border-slate-300
                  text-center
                  font-semibold
                  text-xl
                  outline-none 
                  focus:border-indigo-500
              "
              value="${uncarrito.stock}"
              style="width: ${Math.min(Math.max(String(uncarrito.stock || 0).length + 2, 6), 12)}ch"
              title="${uncarrito.stock}"
            >
            <button type="button" class="w-7 h-7 shrink-0 bg-indigo-700 text-white rounded-full flex items-center justify-center">
              <span class="mas material-symbols-outlined text-base">add</span>
            </button>
          </div>
        </td>
        <td class="px-2 py-3 text-center align-middle w-24 text-xl font-medium text-slate-700">$${Number(uncarrito?.valorunidad).toLocaleString()}</td>
        <td class="px-2 py-3 text-center align-middle w-28 text-xl font-bold text-slate-900">$${Number(uncarrito?.total).toLocaleString()}</td>
        <td class="px-2 py-3 text-center align-middle w-12 accionestd">
            <div class="flex justify-center">
                <button
                    class="
                        eliminarProducto
                        flex
                        items-center
                        justify-center
                        w-9
                        h-9
                        rounded-lg
                        border
                        border-red-200
                        bg-red-50
                        text-red-500
                        transition-all
                        duration-300
                        hover:bg-red-600
                        hover:text-white
                        hover:border-red-600
                        hover:shadow-md
                    "
                >
                    <i class="fa-solid fa-trash-can text-base"></i>
                </button>
            </div>
        </td>
        `);
      tablaventa?.appendChild(tr);
      actualizarEstadoCarrito();
    } //oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"


    function actualizarCarrito(id:string, cantidad:number, control:boolean, stateinput:boolean, precio:string = '0', productoConfigurado:productsapi|null){
      ///limpiar el campo de buscar producto
      POS.reiniciarCatalogoVentas?.();
      const index = carrito.findIndex(x=>x.idproducto==id && x.valorunidad == precio && mismaConfiguracion(x, productoConfigurado!)); //devuelve el index si el producto existe
      
      if(index>-1){
        if(cantidad < 0 && (carrito[index].stock + cantidad)<0){
          cantidad = 0;
          carrito[index].stock = 0;
          carrito[index].total = 0;
        }
        if(control){ //cuando el producto se agrega desde la lista de productos
          carrito[index].stock += cantidad;
        }else{ //cuando el producto se agrega por el input cantidad
          carrito[index].stock = cantidad;
        }
       
        
        carrito[index].subtotal = parseInt(carrito[index].valorunidad)*carrito[index].stock;
        carrito[index].total = carrito[index].subtotal;
        carrito[index].valorcomision = (carrito[index].subtotal*carrito[index].percentcomision)/100;
        //calculo del impuesto y base por producto en el carrito deventas
        carrito[index].valorimp = parseFloat((carrito[index].total*constImp[carrito[index].impuesto??0]).toFixed(3));
        carrito[index].base = parseFloat((carrito[index].total-carrito[index].valorimp).toFixed(3));

        valorCarritoTotal();
        const inputCantidad = tablaventa?.querySelector(`TR[data-indexcarrito="${index}"] .inputcantidad`) as HTMLInputElement;
        if(inputCantidad){
          if(stateinput)inputCantidad.value = carrito[index].stock+'';
          ajustarAnchoCantidad(inputCantidad, carrito[index].stock);
        }
        (tablaventa?.querySelector(`TR[data-indexcarrito="${index}"]`)?.children?.[3] as HTMLElement).textContent = "$"+carrito[index].total.toLocaleString();
      }else{  //agregar a carrito si el producto no esta agregado en carrito, se agrega por primera vez
        const producto = products.find(x=>x.id==id)!; //products es el arreglo de todos los productos traido por api
        if(cantidad < 0)cantidad = 0;
        const productovalorimp = (Number(precio)*cantidad)*constImp[producto.impuesto??'0']; //si producto.impuesto es null toma el valor de cero
        const productototal = Number(precio)*cantidad;

        //varia segun la prioridad de la comision
        if(producto.prioridadcomision === '0'){  //si el porcentaje es por usuario
          //producto.percentcomision = Number(percentComisionUser);  ////porcentaje de comision del usuario logueado
          producto.percentcomision = Number(selectVendedor.options[selectVendedor.selectedIndex].dataset.comision);
        }
        const valorcomision:number = (productototal*producto.percentcomision)/100;

        //obtener nombre de insumo cuando es radiobutton o checkbox
        let insumos = productoConfigurado?.insumos||[];
        //obtener el ultimo insumo de seleccion unica
        let seleccionUnica:insumo|undefined;
        for(let i = insumos.length-1; i>=0; i--)
          if(insumos[i].seleccionado === "1" &&insumos[i].grupos_insumos?.tipo === "0"){
            seleccionUnica = insumos[i];
            break
          }
        
        var a:{id:string, idproducto:string, tipoproducto:string, tipoproduccion:string, idcategoria: string, nombreproducto: string, rendimientoestandar:string, foto:string, costo:string, valorunidad: string, stock: number, promediostock: number, prioridadcomision:string, percentcomision: number, valorcomision: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total:number, insumos:insumo[]} = {
          id: '',
          idproducto: producto?.id!,
          tipoproducto: producto.tipoproducto,
          tipoproduccion: producto.tipoproduccion,
          idcategoria: producto.idcategoria,
          nombreproducto:`${producto.nombre} ${seleccionUnica?.nombre?'('+seleccionUnica.nombre+')':''}`,
          rendimientoestandar: producto.rendimientoestandar,
          foto: producto.foto,
          costo: producto.precio_compra,
          valorunidad: precio,
          stock: cantidad,
          promediostock: Number(producto.promediostock),
          prioridadcomision: producto.prioridadcomision,
          percentcomision: Number(producto.percentcomision),
          valorcomision: valorcomision,
          subtotal: productototal, //este es el subtotal del producto
          base: productototal-productovalorimp,
          impuesto: producto.impuesto, //porcentaje de impuesto, es null si es excluido de iva
          valorimp: productovalorimp,
          descuento: 0,
          total: productototal, //valorunidad x cantidad
          insumos: productoConfigurado?.insumos??[]
        }
        
        carrito = [...carrito, a];
        const indice = carrito.length - 1;
        valorCarritoTotal();
        printProduct(id, precio, indice);
        POS.carrito = carrito;
      }
    }


    function mismaConfiguracion(productCarrito: any, producto2: productsapi):boolean {
      const mapaProduct2 = new Map(producto2.insumos.map((ins:any) => [ins.id_subproducto, ins]));
      // Deben ser el mismo producto
      if(productCarrito.idproducto !== producto2.id)return false;

      // Deben tener la misma cantidad de insumos
      if(productCarrito.insumos.length !== producto2.insumos.length)return false;

      for (const insumo1 of productCarrito.insumos) {
        //const insumo2 = producto2.insumos.find((x:any) => x.id_subproducto == insumo1.id_subproducto);
        const insumo2:any = mapaProduct2.get(insumo1.id_subproducto);
        if (!insumo2)return false;
        // Comparar selecciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n
        if (Number(insumo1.seleccionado) !== Number(insumo2.seleccionado))
            return false;
        // Comparar cantidad
        if (Number(insumo1.cantidadsubproducto) !== Number(insumo2.cantidadsubproducto))
            return false;
      }
      return true;
    }

    //evento al select del vendedor
    selectVendedor.addEventListener('change', (e:Event)=>{
      const target = e.target as HTMLSelectElement;
      const comisionUser:number = Number(target.selectedOptions[0].dataset.comision);
      carrito.forEach(x=>{ 
        if(x.prioridadcomision === '0'){
          x.percentcomision = comisionUser;
          x.valorcomision = (x.total*comisionUser)/100;
        }
      });
      valorCarritoTotal();
    });

    ////////////////////// valores finales subtotal y total ////////////////////////
    function valorCarritoTotal(){
      actualizarEstadoCarrito();
      if(!carrito.length){
        valorTotal.subtotal = 0;
        valorTotal.base = 0;
        valorTotal.valorimpuestototal = 0;
        valorTotal.dctox100 = 0;
        valorTotal.descuento = 0;
        valorTotal.valortarifa = 0;
        valorTotal.total = 0;
        document.querySelector('#subTotal')!.textContent = '$0';
        (document.querySelector('#impuesto') as HTMLElement).textContent = '$0';
        (document.querySelector('#descuento') as HTMLElement).textContent = '$0';
        (document.querySelector('#valorTarifa') as HTMLElement).textContent = '$0';
        document.querySelector('#total')!.textContent = '$0';
        totalunidades.textContent = '0';
        totalunidades.title = '0';
        actualizarBadgeCarritoMovil(0);
        return;
      }
      if(tipoEntregaActual() == "Domicilio")printTarifaEnvio();
      valorTotal.valorgananciauser = 0;
      //calcular el impuesto discriminado por tarifa
      const idimpuesto: Record<string, number> = {'0': 1, '5': 2, '16': 3, '19': 4, 'excluido': 5, '8': 6 };
      const objbase:{'0':number, '5':number, '16':number, '19':number, 'excluido':number, '8':number} = {'0': 0, '5': 0, '16': 0, '19': 0, 'excluido':0, '8': 0};

      const mapImpuesto = new Map();
      carrito.forEach(x=>{
        if(x.impuesto){
          if(mapImpuesto.has(x.impuesto)){
            const valor = mapImpuesto.get(x.impuesto) + x.total*constImp[x.impuesto];
            mapImpuesto.set(x.impuesto, valor);
          }else{
            mapImpuesto.set(x.impuesto, x.total*constImp[x.impuesto]);
          }
        }
        if(x.impuesto == null)x.impuesto = "excluido";
        objbase[x.impuesto as keyof typeof objbase] += x.base;
        const impValor = mapImpuesto.get(x.impuesto)??0;
        const index = factimpuestos.findIndex(Obj=>Obj.id_impuesto == idimpuesto[x.impuesto]);
        if(index!=-1){ //si existe remplazar obj
          factimpuestos[index] = {id_impuesto:idimpuesto[x.impuesto], facturaid:0, basegravable:objbase[x.impuesto as keyof typeof objbase], valorimpuesto: impValor};
        }else{
          factimpuestos = [...factimpuestos, {id_impuesto:idimpuesto[x.impuesto], facturaid:0, basegravable:objbase[x.impuesto as keyof typeof objbase], valorimpuesto: impValor}];
        }
        
        //calcular valor total de comision para el usuario
        valorTotal.valorgananciauser += Number(x.valorcomision);
      });
     
      //Valor del impuesto total de todos los productos, es decir de la factura;
      let valorTotalImp:number = 0;
      for(let valorImp of mapImpuesto.values())valorTotalImp += valorImp;
      
      valorTotal.valorimpuestototal = parseFloat(valorTotalImp.toFixed(3));  //valor del impuesto total factura de todos los productos

      valorTotal.subtotal = carrito.reduce((total, x)=>x.total+total, 0);
      valorTotal.porcentgananciauser =  (100*valorTotal.valorgananciauser)/valorTotal.subtotal;
      valorTotal.base = valorTotal.subtotal - valorTotal.valorimpuestototal;  //valor de la base total factura de todos los productos
      valorTotal.total = valorTotal.subtotal + valorTotal.valortarifa - valorTotal.descuento;
      document.querySelector('#subTotal')!.textContent = '$'+valorTotal.subtotal.toLocaleString();
      (document.querySelector('#impuesto') as HTMLElement).textContent = '$'+valorTotalImp.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
      (document.querySelector('#valorTarifa') as HTMLElement).textContent = '$'+valorTotal.valortarifa.toLocaleString();
      document.querySelector('#total')!.textContent = '$ '+valorTotal.total.toLocaleString();
      // cantidad total de productos
      const cantidadTotalProductos = carrito.reduce((total, producto)=>producto.stock+total, 0);
      totalunidades.textContent = formatCantidadBadge(cantidadTotalProductos);
      totalunidades.title = cantidadTotalProductos.toLocaleString('es-CO');
      actualizarBadgeCarritoMovil(cantidadTotalProductos);
    }


    /////////////////////// evento a la tabla de productos de venta (carrito) //////////////////////////
    tablaventa?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.productselect');
      if(!elementProduct)return;
      const idProduct = (elementProduct as HTMLElement).dataset.id!;
      const precio = (elementProduct as HTMLElement).dataset.precio!;
      indexcarrito = Number((elementProduct as HTMLElement).dataset.indexcarrito!);
      //const productoCarrito = carrito.find(x=>x.idproducto==idProduct && x.valorunidad==precio);
      let productoCarrito = carrito[indexcarrito];

      /*for (let i = 0; i < carrito.length; i++) {
        const item = carrito[i];
        if (item.idproducto == idProduct && item.valorunidad == precio) {
            indiceCarrito = i;
            productoCarrito = item;
            break;
        }
      }*/


      if((e.target as HTMLElement).classList.contains('nombreproducto')){
        const inputMerma = document.querySelector('#inputMerma') as HTMLInputElement;
        inputMerma.value = '';
        if(getParam.activar_calculadira_de_merma_en_modulo_de_ventas.valor_final == '1'){
          miDialogoCalculadora.showModal();
          inputMerma.focus();
          document.addEventListener("click", cerrarDialogoExterno);
        }
      }
      
      if((e.target as HTMLElement).classList.contains('menos')){
        editarCantidad(indexcarrito, productoCarrito!.stock-1, false, true);
        //actualizarCarrito(idProduct, productoCarrito!.stock-1, false, true, productoCarrito?.valorunidad, null);
      }
      if((e.target as HTMLElement).classList.contains('mas')){
        editarCantidad(indexcarrito, productoCarrito!.stock+1, false, true);
        //actualizarCarrito(idProduct, productoCarrito!.stock+1, false, true, productoCarrito?.valorunidad, null);
      }
      if((e.target as HTMLElement).classList.contains('eliminarProducto') || (e.target as HTMLElement).tagName == "I"){
        //carrito = carrito.filter(x=>x.idproducto != idProduct || x.valorunidad != precio);
        carrito.splice(indexcarrito, 1);
        while(tablaventa.firstChild)tablaventa.removeChild(tablaventa.firstChild);
        carrito.forEach((item, i) =>printProduct(item.idproducto, item.valorunidad, i));
        valorCarritoTotal();
        //tablaventa?.querySelector(`TR[data-indexcarrito="${indexcarrito}"]`)?.remove();
      }
    });


    tablaventa?.addEventListener('input', e=>{
      const input = e.target as HTMLInputElement;
      if (!input.classList.contains('inputcantidad')) return;
      const fila = input?.closest('.productselect') as HTMLTableRowElement;
      const idProduct = fila.dataset.id!;
      const precio = fila.dataset.precio!;
      indexcarrito = Number(fila.dataset.indexcarrito!);
      //const productoCarrito = carrito.find(x=>x.idproducto==idProduct && x.valorunidad==precio);

      let val = input.value;
      val = val.replace(/[^0-9.]/g, '');
      const partes = val.split('.');
      if(partes.length > 2)val = partes[0]+'.'+partes.slice(1).join('');
      if (val.startsWith('.'))val = '1';
      if (val === '' || isNaN(parseFloat(val))) val = '';

      input.value = val;
      ajustarAnchoCantidad(input, input.value || 0);
      editarCantidad(indexcarrito, Number(input.value), false, false);
      //actualizarCarrito(idProduct, Number(input.value), false, false,  productoCarrito?.valorunidad, null);
    });


    function editarCantidad(index:number, cantidad:number, control:boolean, stateinput:boolean){
        if(cantidad < 0 && (carrito[index].stock + cantidad)<0){
          cantidad = 0;
          carrito[index].stock = 0;
          carrito[index].total = 0;
        }
        if(control){ //cuando el producto se agrega desde la lista de productos
          carrito[index].stock += cantidad;
        }else{ //cuando el producto se agrega por el input cantidad
          carrito[index].stock = cantidad;
        }
        
        carrito[index].subtotal = parseInt(carrito[index].valorunidad)*carrito[index].stock;
        carrito[index].total = carrito[index].subtotal;
        carrito[index].valorcomision = (carrito[index].subtotal*carrito[index].percentcomision)/100;
        //calculo del impuesto y base por producto en el carrito de ventas
        carrito[index].valorimp = parseFloat((carrito[index].total*constImp[carrito[index].impuesto??0]).toFixed(3));
        carrito[index].base = parseFloat((carrito[index].total-carrito[index].valorimp).toFixed(3));

        valorCarritoTotal();
        const inputCantidad = tablaventa?.querySelector(`TR[data-indexcarrito="${index}"] .inputcantidad`) as HTMLInputElement;
        if(inputCantidad){
          if(stateinput)inputCantidad.value = carrito[index].stock+'';
          ajustarAnchoCantidad(inputCantidad, carrito[index].stock);
        }
        (tablaventa?.querySelector(`TR[data-indexcarrito="${index}"]`)?.children?.[3] as HTMLElement).textContent = "$"+carrito[index].total.toLocaleString();
    }


    //calculadora que se ejecuta cuando se da clic sobre el nombre del producto
    document.querySelector('#btnMermaCantidad')?.addEventListener('click', (e:Event)=>{
      const inputMerma = (document.querySelector('#inputMerma') as HTMLInputElement).value;
      const {stock} = carrito[indexcarrito];
      let nuevaCantidad = stock - Number(inputMerma);
      if(nuevaCantidad<0)nuevaCantidad=0;
      (tablaventa?.querySelector(`TR[data-indexcarrito="${indexcarrito}"] .inputcantidad`) as HTMLInputElement).value = nuevaCantidad+'';
      editarCantidad(indexcarrito, nuevaCantidad, false, false);
      miDialogoCalculadora.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    });

    /*btnvaciar?.addEventListener('click', ()=>{
      if(carrito.length){
        miDialogoVaciar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });*/

    btnguardar?.addEventListener('click', ()=>{
      if(carrito.length && valorTotal.total>0){
        miDialogoGuardar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    btnaplicarcredito?.addEventListener('click', ()=>{
      if(tipoEntregaActual() === "Domicilio" && (selectCliente.value =='' || !dirEntrega.value) || selectCliente.value ==''){
        msjalertToast('warning', 'Cliente requerido', 'Selecciona un cliente y una direccion antes de registrar la venta a credito.');
        resaltarSelectorCliente();
        return;
      }
      if(carrito.length && valorTotal.total>0){
        document.querySelector('.Efectivo')?.removeAttribute('readonly');
        document.querySelector('#inputscreditos')?.classList.add('flex');
        document.querySelector('#inputscreditos')?.classList.remove('hidden');
        if(tipoventa == "Contado"){
          mapMediospago.clear();
          $('.mediopago').val(0);
        }
        tipoventa = "Credito";
        POS.tipoventa = tipoventa;
        POS.gestionSubirModalPagar.subirModalPagar();
        //miDialogoCredito.showModal();
        miDialogoFacturar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    btnfacturar?.addEventListener('click', ()=>{
      if(tipoEntregaActual() === "Domicilio" && (selectCliente.value =='' || !dirEntrega.value)){
        msjAlert('error', 'Cliente o direccion no seleccionado', (document.querySelector('#divmsjalerta1') as HTMLElement));
        resaltarSelectorCliente();
        return;
      }
      
      if(tipoEntregaActual() == "Domicilio")document.querySelector('#confirmarDespacho')?.classList.remove('hidden');

      if(carrito.length && valorTotal.total>0){
        document.querySelector('.Efectivo')?.setAttribute('readonly', 'true');
        document.querySelector('#inputscreditos')?.classList.add('hidden');
        document.querySelector('#inputscreditos')?.classList.remove('flex');
        tipoventa = "Contado";
        POS.tipoventa = tipoventa;
        POS.gestionSubirModalPagar.subirModalPagar();
        miDialogoFacturar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });


    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      if (f === miDialogoDescuento || f === miDialogoCredito || f === miDialogoGuardar || f === miDialogoFacturar || f === miDialogoAddCliente || f === miDialogoOtrosProductos || f === miDialogoFacturarA || /*f === miDialogoAddDir ||*/ f=== miDialogoPreciosAdicionales || f === miDialogoCalculadora || (f as HTMLInputElement).closest('.salir') || (f as HTMLInputElement).closest('.novaciar') || (f as HTMLInputElement).closest('.cotizacion') || (f as HTMLInputElement).closest('.remision') || (f as HTMLInputElement).closest('.siguardar') || (f as HTMLButtonElement).value == "Cancelar" || /*(f as HTMLButtonElement).value == "Seleccionar" ||*/ (f as HTMLButtonElement).classList.contains('btnCerrarPreciosAdicionales') ) {
        miDialogoDescuento.close();
        //miDialogoCredito.close();
        miDialogoGuardar.close();
        miDialogoFacturar.close();
        miDialogoAddCliente.close();
        //miDialogoAddDir.close();
        miDialogoFacturarA.close();
        miDialogoOtrosProductos.close();
        miDialogoPreciosAdicionales.close();
        miDialogoCalculadora.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        if((f as HTMLInputElement).closest('.cotizacion')){
          tipoventa = "";
          procesarpedido('Guardado', '1');
        }
        if((f as HTMLInputElement).closest('.remision')){
          tipoventa = "";
          procesarpedido('Remision', '0');
        }
        //if((f as HTMLInputElement).closest('.sivaciar'))vaciarventa();
      }
    }

    function vaciarventa():void
    {
      if(datosfactura?.id)datosfactura.id = '';
      (document.querySelector('#formFacturarA') as HTMLFormElement)?.reset();
      (document.querySelector('#formfacturar') as HTMLFormElement)?.reset();
      (document.querySelector('#formAddCliente') as HTMLFormElement).reset();
      (document.querySelector('#badgeEstado') as HTMLParagraphElement).textContent = 'SIN CLIENTE';
      (document.querySelector('#badgeEstado') as HTMLParagraphElement).classList.remove('bg-green-100', 'text-green-600');
      (document.querySelector('#badgeEstado') as HTMLParagraphElement).classList.add('bg-gray-100', 'text-gray-700');
      (document.querySelector('#resumenCliente') as HTMLParagraphElement).textContent = "Seleccionar cliente";
      mapMediospago.clear();
      $('.mediopago').val(0);
      carrito.length = 0;
      factimpuestos.length = 0;
      for(const key in valorTotal)valorTotal[key as keyof typeof valorTotal] = 0; //reiniciar objeto

      history.replaceState({}, "", "/admin/ventas");
      while(tablaventa?.firstChild)tablaventa.removeChild(tablaventa?.firstChild);
      actualizarEstadoCarrito();
      (document.querySelector('#npedido') as HTMLInputElement).value = '';
      document.querySelector('#subTotal')!.textContent = '$'+0;
      document.querySelector('#impuesto')!.textContent = '$'+0;
      (document.querySelector('#descuento') as HTMLElement).textContent = '$'+0;
      (document.querySelector('#valorTarifa') as HTMLElement).textContent = '$'+0;
      document.querySelector('#total')!.textContent = '$'+0;
      valorDomicilio.value = '';
      modalidadEntrega.textContent = 'Presencial';
      document.querySelector('#confirmarDespacho')?.classList.add('hidden');
      $('#selectCliente').val('').trigger('change');   //aqui tambien se reinicia la elemento del valor de la tarifa
      (document.querySelector('#valorTarifa') as HTMLElement).textContent = '$'+0;
      document.querySelector('#total')!.textContent = '$'+0;
      //volver a mapear los productos con los valores originales de inventario

      //actualizar DOM
      for(const prod of products){
          const item = POS.hackerList.get('id', prod.id)[0];
          prod.precio_venta = prod.precio_original!;
          if(item)item.elm.querySelector('.precioVenta').textContent = '$'+Number(prod.precio_venta).toLocaleString();
      }
      POS.reiniciarCatalogoVentas?.();
    }


    ////////////////// evento al bton pagar del modal facturar //////////////////////
    document.querySelector('#formfacturar')?.addEventListener('submit', e=>{
      e.preventDefault();
      if(valorTotal.total <0 || valorTotal.subtotal <0){
        msjAlert('error', 'No se puede procesar pago con $0', (document.querySelector('#divmsjalertaprocesarpago') as HTMLElement));
        return;
      }

      //calcular si el totoal de los medios de pago es menor al abono inicial, abortar pago...
      let totalMediosPago:number = 0;
      for(let value of mapMediospago.values())totalMediosPago+=value;
      if(totalMediosPago<POS.gestionSubirModalPagar.valoresCredito.abonoinicial){
        msjAlert('error', 'Medio de pago no indicado', (document.querySelector('#divmsjalertaprocesarpago') as HTMLElement));
        return;
      }

      if(tipoventa == "Credito" && (isNaN(POS.gestionSubirModalPagar.valoresCredito.cantidadcuotas)||POS.gestionSubirModalPagar.valoresCredito.cantidadcuotas<=0)){
        msjAlert('error', 'Plazo de cuotas no especificado', (document.querySelector('#divmsjalertaprocesarpago') as HTMLElement));
        return;
      }
  
      btnPagar.disabled = true;
      btnPagar.value = 'Procesando...';
      procesarpedido('Paga', '0');
    });

    async function procesarpedido(estado:string, ctz:string){
      const imprimir = document.querySelector('input[name="imprimir"]:checked') as HTMLInputElement;
      const despachar = document.querySelector('#despachar') as HTMLInputElement;
      const valoresCredito = POS.gestionSubirModalPagar.valoresCredito;
      const tipoEntrega = tipoEntregaActual();
      const datos = new FormData();
      datos.append('id', datosfactura?.id??'');
      datos.append('idemisor', btnCaja.selectedOptions[0].dataset.idemisor??'');
      datos.append('idcliente', (document.querySelector('#selectCliente') as HTMLSelectElement).value || '1');
      datos.append('idvendedor', selectVendedor.value);
      datos.append('idcaja', btnCaja.value);
      datos.append('idconsecutivo', btnTipoFacturador.value);
      datos.append('iddireccion', dirEntrega.value);
      datos.append('idtarifazona', valorTotal.idtarifa+'');
      datos.append('idcanaldeventa', (document.querySelector('#canalVenta') as HTMLSelectElement)?.value??'1');
      datos.append('cliente', selectCliente.value==''?'N/A':selectCliente.options[selectCliente.selectedIndex].textContent!);
      datos.append('vendedor', $('#vendedor option:selected').text());
      datos.append('caja', (document.querySelector('#caja option:checked') as HTMLSelectElement).textContent!);
      datos.append('tipofacturador', btnTipoFacturador.options[btnTipoFacturador.selectedIndex].textContent!);
      datos.append('direccion', dirEntrega.options[dirEntrega.selectedIndex]?.text??'');
      datos.append('tarifazona', nombretarifa||'');
      datos.append('carrito', JSON.stringify(carrito.filter(x=>x.stock>0)));  //envio de todos los productos con sus cantidades
      datos.append('totalunidades', totalunidades.textContent!);
      //datos.append('mediosPago', JSON.stringify(Object.fromEntries(mapMediospago)));
      datos.append('mediosPago', JSON.stringify(Array.from(mapMediospago, ([idmediopago, valor])=>({idmediopago, id_factura:0, valor}))));
      datos.append('factimpuestos', JSON.stringify(factimpuestos));
      datos.append('recibido', document.querySelector<HTMLInputElement>('#recibio')!.value);
      datos.append('transaccion', '');
      datos.append('tipoventa', tipoventa);
      datos.append('valoresCredito', JSON.stringify(valoresCredito));
      datos.append('cotizacion', ctz);  //1= cotizacion, 0 = no cotizacion pagada.
      datos.append('remision', estado=='Remision'?'1':'0');  //1= cotizacion, 0 = no cotizacion pagada.
      datos.append('estado', estado);
      datos.append('porcentgananciauser', valorTotal.porcentgananciauser.toFixed(2));
      datos.append('valorgananciauser', valorTotal.valorgananciauser.toFixed(2));
      datos.append('subtotal', valorTotal.subtotal+'');
      datos.append('base', valorTotal.base.toFixed(3));
      datos.append('valorimpuestototal', valorTotal.valorimpuestototal+''); //valor total del impuesto. 
      datos.append('dctox100',valorTotal.dctox100+'');
      datos.append('descuento',valorTotal.descuento+'');
      datos.append('total', valorTotal.total.toString());
      datos.append('observacion', document.querySelector<HTMLTextAreaElement>('#observacion')!.value);
      datos.append('departamento', '');
      datos.append('ciudad', (document.querySelector('#ciudad') as HTMLInputElement).value);
      datos.append('entrega', tipoEntrega);
      datos.append('entregado', estado=='Paga'&&tipoEntrega=='Domicilio'?(despachar.checked?'1':'0'):estado=='Paga'&&tipoEntrega=='Presencial'?'1':'0'); //si es remision no se ha entregado, si es pago y entrega a domicilio se define segun el checkbox de despachar, si es pago y entrega presencial se marca como entregado
      datos.append('valortarifa', valorTotal.valortarifa+'');
      datos.append('datosAdquiriente', JSON.stringify(POS.gestionarAdquiriente.datosAdquiriente));
      datos.append('opc1', '');
      datos.append('opc2', '');
  
      try {
          const url = "/admin/api/facturar";  //va al controlador ventascontrolador
          const respuesta = await fetch(url, {method: 'POST', body: datos}); 
          const resultado = await respuesta.json();

          if(resultado.exito !== undefined){
            if(estado == "Paga"){
              resultado.dataInvoice.items = carrito.filter(x=>x.stock>0);
              resultado.dataInvoice.mediospago = Array.from(mapMediospago, ([idmediopago, valor])=>({
                idmediopago,
                mediopago: mediosPagoDBMAP.get(idmediopago),
                valor,
              }));
            }

            limpiarFormFacturar();
            msjalertToast('success', 'Exito!', resultado.exito[0]);
            //ENVIAR FACTURA A DIAN SI ES FACTURACION ELECTRONICA
            if(btnTipoFacturador.options[btnTipoFacturador.selectedIndex].dataset.idtipofacturador == '1'){
              const resDian = await POS.sendInvoiceAPI.sendInvoice(resultado.idfactura);
              POS.gestionarAdquiriente.datosAdquiriente = {}; //reiniciar datos de adquiriente cada vez que se facture electronicamente
              resultado.dataInvoice.cufe = resDian.cufe;
              resultado.dataInvoice.link = resDian.link;
              console.log(resDian);
            }
            //IMPRIMIR TICKET POS
            if(resultado.idfactura && imprimir.value === '1')printTicketPOS(resultado.idfactura, resultado.dataInvoice);
            vaciarventa();
          }else{
            limpiarFormFacturar();
            msjalertToast('error', 'Error!', resultado.error[0]);
          }
      } catch (error) {
          console.log(error);
      }
    }


    function limpiarFormFacturar(){
      btnPagar.disabled = false;
      btnPagar.value = 'Pagar';
      miDialogoFacturar.close();
      document.removeEventListener("click", cerrarDialogoExterno);
      (document.getElementById('contenedorDesktop') as HTMLDivElement).classList.add('translate-x-full');
      (document.getElementById('overlayCarrito') as HTMLDivElement).classList.add('hidden');
    }


    async function printTicketPOS(idfactura:string, datainvoice:DataInvoice){
      console.log(datainvoice);
      ////// cuando no es impresora CAJA por BT
      const isAndroid = /Android/i.test(navigator.userAgent);

      if(printerBT === '1'){  //solo aplica para impresora principal si es android
        const builder = new InvoiceTicketBuilder2(datainvoice);
        const ticket = await builder.generate(true); //true para version buffer bytes
        
        const base64 = bytesToBase64(ticket);
        //const url = `intent://base64,${base64}#Intent;scheme=rawbt;package=ru.a4024.rawbtprinter;end;`;
        //const url = `intent://base64,${base64}#Intent;scheme=rawbt;package=ru.a4024.rawbtprinter;end;`;
        //window.location.href = url;
        if (isAndroid)window.location.href = `rawbt:base64,${base64}`;

        //version string
          //const encoder = new TextEncoder();
          //const bytes = encoder.encode(ticket);
        //descargar .bin a equipo
          /*const blob = new Blob([ticket], { type: 'application/octet-stream' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'ticket.bin';
          a.click();
          URL.revokeObjectURL(url);*/
      }

      if(printerBT !== '1'){
        const dataPrinter = {
          businessId: datainvoice.host,
          sucursal: datainvoice.sucursal,
          printerName: 'CAJA',
          tipoTicket: 'ticket',
          content: datainvoice
        };

        console.log(dataPrinter);

        try {
          //const url = "http://localhost:3100/api/print/printJob"; //llamado a la API server print nodejs/ts
          const url = "https://servidorimpresionposws-production.up.railway.app/api/print/printJob"; //llamado a la API server print nodejs/ts
          const respuesta = await fetch(url, {
            method: 'POST',
            headers: { "Accept": "application/json", "Content-Type": "application/json" },
            body: JSON.stringify(dataPrinter)
        });
          const resultado = await respuesta.json();
          console.log(resultado);
        } catch (error) {
          console.log(error);
        }
      }

      setTimeout(() => {
        window.open("/admin/printPDFPOS?id=" + idfactura, "_blank");  //llama a printcontrolador.php
      }, 1000);

    }

    
    /////////////////////////obtener datos de cotizacion /////////////////////
    const parametrosURL = new URLSearchParams(window.location.search);
    const id = parametrosURL.get('id');
    let datosfactura:{id:string, idcliente: string, idvendedor:string, idcaja:string, idconsecutivo:string, iddireccion:string, idtarifazona:string, idcierrecaja:string, num_orden:string, cliente:string, vendedor:string, caja:string, tipofacturador:string, direccion:string, tarifazona:string, totalunidades:string, recibido:string, transaccion:string, tipoventa:string,
                      cotizacion:string, estado:string, cambioaventa:string, referencia:string, subtotal:string, base:string, valorimpuestototal:string, dctox100:string, descuento:string, total:string, observacion:string, departamento:string, ciudad:string, entrega:string, valortarifa:string, fechacreacion:string, fechapago:string, opc1:string, opc2:string};
    if(id){
      (async ()=>{
        try {
            const url = "/admin/api/getcotizacion_venta?id="+id; //llamado a la API REST
            const respuesta = await fetch(url); 
            const resultado = await respuesta.json();
            datosfactura = resultado.factura;
            carrito = resultado.productos;
            carrito.forEach((item, i) =>printProduct(item.idproducto, item.valorunidad, i));
            //valorCarritoTotal(); //recalcula impuestos de la cotizacion y valores totales
            (document.querySelector('#npedido') as HTMLInputElement).value = datosfactura.num_orden;
            $('#selectCliente').val(datosfactura.idcliente).trigger('change');
        } catch (error) {
            console.log(error);
        }
      })();
    }

    function limpiarformdialog(){
      (document.querySelector('#formAddCliente') as HTMLFormElement)?.reset();
    }


    //exponer variables y funciones globalmente
    POS.limpiarformdialog = limpiarformdialog;
    POS.printTarifaEnvio = printTarifaEnvio;
    POS.valorCarritoTotal = valorCarritoTotal;
    POS.actualizarCarrito = actualizarCarrito;
    POS.mostrarFeedbackCarrito = mostrarFeedbackCarrito;
    //POS.calcularCambio = calcularCambio;
    POS.cerrarDialogoExterno = cerrarDialogoExterno;
    POS.tarifas = tarifas;
    POS.valorTotal = valorTotal;
    POS.mapMediospago = mapMediospago;
    POS.tipoventa = tipoventa;
    //POS.carrito = carrito;
    //POS.products = products;
  }


})();
