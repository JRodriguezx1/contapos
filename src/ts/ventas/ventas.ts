(()=>{
  if(document.querySelector('.ventas')){

    const POS = (window as any).POS;
     
    const selectCliente = POS.gestionClientes.selectCliente;
    const dirEntrega = POS.gestionClientes.dirEntrega;
    const facturarA = document.querySelector('#facturarA') as HTMLButtonElement;
    const productos = document.querySelectorAll<HTMLElement>('#producto')!;
    const contentproducts = document.querySelector('#productos');
    const btnEntrega = document.querySelector('#btnEntrega');
    const modalidadEntrega = document.querySelector('#modalidadEntrega') as HTMLElement;
    const totalunidades = document.querySelector('#totalunidades') as HTMLElement;
    const tablaventa = document.querySelector('#tablaventa tbody');
    const btnguardar = document.querySelector('#btnguardar');
    const btnfacturar = document.querySelector('#btnfacturar');
    const btnaplicarcredito = document.querySelector('#btnaplicarcredito');
    const miDialogoAddCliente = POS.gestionClientes.miDialogoAddCliente;
    const miDialogoAddDir = POS.gestionClientes.miDialogoAddDir;
    const miDialogoOtrosProductos = POS.gestionOtrosProductos.miDialogoOtrosProductos;
    const miDialogoPreciosAdicionales = POS.gestionarPreciosAdicionales.miDialogoPreciosAdicionales;
    const miDialogoFacturarA = document.querySelector('#miDialogoFacturarA') as any;
    const miDialogoDescuento = POS.gestionarDescuentos.miDialogoDescuento;
    const miDialogoCredito = document.querySelector('#miDialogoCredito') as any;
    const miDialogoGuardar = document.querySelector('#miDialogoGuardar') as any;
    const miDialogoFacturar = document.querySelector('#miDialogoFacturar') as any;
    const btnCaja = document.querySelector('#caja') as HTMLSelectElement; //select de la caja en el modal pagar
    const btnTipoFacturador = document.querySelector('#facturador') as HTMLSelectElement; //select del consecutivo o facturador en el modal de pago
    
    let carrito:{id:string, idproducto:string, tipoproducto:string, tipoproduccion:string, idcategoria: string, foto:string, nombreproducto: string, rendimientoestandar:string, costo:string, valorunidad: string, cantidad: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total: number}[]=[];
    const valorTotal = {subtotal: 0, base: 0, valorimpuestototal: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
    let tarifas:{id:string, idcliente:string, nombre:string, valor:string}[] = [];
    let nombretarifa:string|undefined='', tipoventa:string="Contado";
    
    const constImp: {[key:string]: number} = {};
    constImp['excluido'] = 0;
    constImp['0'] = 0;  //exento de iva, tarifa 0%
    constImp['5'] = 0.0476190476190476; //iva, tarifa al 5%,  Bienes/servicios al 5
    constImp['8'] = 0.0740740740740741; //inc, tarifa al 8%,  impuesto nacional al consumo
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

    /////select 2 a btn selectCliente
    //selectCliente.select2  multiple="multiple" maximumSelectionLength: 1,
    ($('#selectCliente') as any).select2();
    


                       /******** *********/

    selectFacturadorSegunCaja(btnCaja);
    btnCaja.addEventListener('change', (e:Event)=>selectFacturadorSegunCaja(e.target as HTMLSelectElement));
    function selectFacturadorSegunCaja(z:HTMLSelectElement){
      $('#facturador').val(z.options[z.selectedIndex].dataset.idfacturador??'1');
    }

    POS.gestionClientes.clientes();  //inicializa modulo de clientes

    //////////// evento al boton modalidad de entrega //////////////
    btnEntrega?.addEventListener('click', (e:Event)=>{
      modalidadEntrega.textContent == ": Presencial"?modalidadEntrega.textContent = ": Domicilio":modalidadEntrega.textContent=": Presencial";
      printTarifaEnvio();
      valorCarritoTotal();
    });

    ///////// funcion que imprime el valor de la tarifa segun direccion ///////////
    function printTarifaEnvio():void{
      tarifas = POS.tarifas;
      const selectDir = dirEntrega.options[dirEntrega.selectedIndex];
      if(modalidadEntrega.textContent == ": Presencial" || dirEntrega.selectedIndex == -1){
        valorTotal.valortarifa = 0;
        nombretarifa = '';
        return;
      }
      if(selectDir?.dataset.idtarifa && modalidadEntrega.textContent == ": Domicilio"){
        const objtarifa = tarifas.find(tarifa =>{
          if(tarifa.idcliente == selectDir.dataset.idcliente && tarifa.id == selectDir.dataset.idtarifa)return true;
        });
        valorTotal.valortarifa = Number(objtarifa?.valor);
        valorTotal.idtarifa = Number(objtarifa?.id);
        nombretarifa = objtarifa?.nombre;
      }
    }

    ///////////////////// evento al btn facturar A /////////////////////
    facturarA.addEventListener('click', (e:Event)=>{
      miDialogoFacturarA.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });


    //////////// evento a toda el area de los productos a seleccionar //////////////
    contentproducts?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.producto');
      const count = carrito.find(x=>x.idproducto == (elementProduct as HTMLElement).dataset.id);

      if((e.target as HTMLElement).parentElement?.id === 'precioadicional'){
        POS.gestionarPreciosAdicionales.abrirDialogo(elementProduct);  //ejecuta los precios adicionales
        return;
      }

      if(window.innerWidth < 992){
        // Crear popup
        const popup = document.createElement('div');
        popup.className = `popup absolute z-40 right-8 top-1/3 opacity-0 translate-x-0 translate-y-0 transition-all duration-500 w-10 h-10 rounded-full text-center grid place-items-center bg-teal-400 text-white font-semibold text-lg`;
        popup.innerHTML = `${(count?.cantidad??0)+1}`;
        elementProduct!.appendChild(popup);
        // Forzar reflow para activar transición
        requestAnimationFrame(() => {
          popup.classList.remove("opacity-0", "translate-y-0", "translate-x-0");
          popup.classList.add("opacity-100", "-translate-y-14", "translate-x-10");
        });
        const popupx = document.querySelectorAll('.popup');
        setTimeout(() => {popupx.forEach(t=>{t.remove();});}, 2500);
      }

      const precio = products.find(x=>x.id == (elementProduct as HTMLElement).dataset.id)?.precio_venta;
      if(elementProduct)actualizarCarrito((elementProduct as HTMLElement).dataset.id!, 1, true, true, precio);
    });

    function printProduct(id:string, precio:string){ //recibe el id del producto
      const uncarrito = carrito.find(x=>x.idproducto==id&&x.valorunidad==precio)!;
      const tr = document.createElement('TR');
      tr.classList.add('productselect');
      tr.dataset.id = `${id}`;
      tr.dataset.precio = precio;
      tr.insertAdjacentHTML('afterbegin', `<td class="!px-0 !py-2 text-xl text-gray-500 leading-5">${uncarrito?.nombreproducto}</td> 

      <td class="!px-0 !py-2">
        <div class="flex items-center gap-2 px-4">
          <button type="button" class="w-8 h-8 bg-indigo-700 text-white rounded-full flex items-center justify-center">
            <span class="menos material-symbols-outlined text-base">remove</span>
          </button>

          <input type="text" class="inputcantidad w-20 px-2 text-center" value="${uncarrito.cantidad}">

          <button type="button" class="w-8 h-8 bg-indigo-700 text-white rounded-full flex items-center justify-center">
            <span class="mas material-symbols-outlined text-base">add</span>
          </button>
        </div>
      </td>

      <td class="!p-2 text-xl text-gray-500 leading-5">$${Number(uncarrito?.valorunidad).toLocaleString()}</td>
      <td class="!p-2 text-xl text-gray-500 leading-5">$${Number(uncarrito?.total).toLocaleString()}</td>
      <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarProducto"><i class="fa-solid fa-trash-can"></i></button></div></td>`);
      tablaventa?.appendChild(tr);
    } //oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"


    function actualizarCarrito(id:string, cantidad:number, control:boolean, stateinput:boolean, precio:string = '0'){
      const index = carrito.findIndex(x=>x.idproducto==id && x.valorunidad == precio); //devuelve el index si el producto existe
      
      if(index>-1){
        if(cantidad <= 0){
          cantidad = 0;
          carrito[index].total = 0;
        }
        if(control){ //cuando el producto se agrega desde la lista de productos
          carrito[index].cantidad += cantidad;
        }else{ //cuando el producto se agrega por cantidad
          carrito[index].cantidad = cantidad;
        }
       
        
        carrito[index].subtotal = parseInt(carrito[index].valorunidad)*carrito[index].cantidad;
        carrito[index].total = carrito[index].subtotal;
        //calculo del impuesto y base por producto en el carrito deventas
        carrito[index].valorimp = parseFloat((carrito[index].total*constImp[carrito[index].impuesto??0]).toFixed(3));
        carrito[index].base = parseFloat((carrito[index].total-carrito[index].valorimp).toFixed(3));

        valorCarritoTotal();
        if(stateinput)
        (tablaventa?.querySelector(`TR[data-id="${id}"][data-precio="${precio}"] .inputcantidad`) as HTMLInputElement).value = carrito[index].cantidad+'';
        (tablaventa?.querySelector(`TR[data-id="${id}"][data-precio="${precio}"]`)?.children?.[3] as HTMLElement).textContent = "$"+carrito[index].total.toLocaleString();
      }else{  //agregar a carrito si el producto no esta agregado en carrito, cuando se agrega por primera vez
        const producto = products.find(x=>x.id==id)!; //products es el arreglo de todos los productos traido por api
        
        const productovalorimp = (Number(precio)*cantidad)*constImp[producto.impuesto??'0']; //si producto.impuesto es null toma el valor de cero
        const productototal = Number(precio)*cantidad;
        
        var a:{id:string, idproducto:string, tipoproducto:string, tipoproduccion:string, idcategoria: string, nombreproducto: string, rendimientoestandar:string, foto:string, costo:string, valorunidad: string, cantidad: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total:number} = {
          id: '',
          idproducto: producto?.id!,
          tipoproducto: producto.tipoproducto,
          tipoproduccion: producto.tipoproduccion,
          idcategoria: producto.idcategoria,
          nombreproducto: producto.nombre,
          rendimientoestandar: producto.rendimientoestandar,
          foto: producto.foto,
          costo: producto.precio_compra,
          valorunidad: precio,
          cantidad: cantidad,
          subtotal: productototal, //este es el subtotal del producto
          base: productototal-productovalorimp,
          impuesto: producto.impuesto, //porcentaje de impuesto, es null si es excluido de iva
          valorimp: productovalorimp,
          descuento: 0,
          total: productototal //valorunidad x cantidad
        }
        
        carrito = [...carrito, a];
        console.log(carrito);
        valorCarritoTotal();
        printProduct(id, precio);
        POS.carrito = carrito;
      }
    }

    ////////////////////// valores finales subtotal y total ////////////////////////
    function valorCarritoTotal(){
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
      });

     
      //Valor del impuesto total de todos los productos, es decir de la factura;
      let valorTotalImp:number = 0;
      for(let valorImp of mapImpuesto.values())valorTotalImp += valorImp;
      
      valorTotal.valorimpuestototal = parseFloat(valorTotalImp.toFixed(3));  //valor del impuesto total factura de todos los productos

      valorTotal.subtotal = carrito.reduce((total, x)=>x.total+total, 0);
      valorTotal.base = valorTotal.subtotal - valorTotal.valorimpuestototal;  //valor de la base total factura de todos los productos
      valorTotal.total = valorTotal.subtotal + valorTotal.valortarifa - valorTotal.descuento;
      document.querySelector('#subTotal')!.textContent = '$'+valorTotal.subtotal.toLocaleString();
       (document.querySelector('#impuesto') as HTMLElement).textContent = '$'+valorTotalImp.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
      (document.querySelector('#valorTarifa') as HTMLElement).textContent = '$'+valorTotal.valortarifa.toLocaleString();
      document.querySelector('#total')!.textContent = '$ '+valorTotal.total.toLocaleString();
      // cantidad total de productos
      totalunidades.textContent = carrito.reduce((total, producto)=>producto.cantidad+total, 0)+'';
    }

    /////////////////////// evento a la tabla de productos de venta (carrito) //////////////////////////
    tablaventa?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.productselect');
      const idProduct = (elementProduct as HTMLElement).dataset.id!;
      const precio = (elementProduct as HTMLElement).dataset.precio!;
      const productoCarrito = carrito.find(x=>x.idproducto==idProduct && x.valorunidad==precio);
      if((e.target as HTMLElement).classList.contains('menos')){
        actualizarCarrito(idProduct, productoCarrito!.cantidad-1, false, true, productoCarrito?.valorunidad);
      }
      if((e.target as HTMLElement).classList.contains('inputcantidad')){
        if((e.target as HTMLElement).dataset.event != "eventInput"){
          e.target?.addEventListener('input', (e)=>{
           
            let val = (e.target as HTMLInputElement).value;
            val = val.replace(/[^0-9.]/g, '');
            const partes = val.split('.');
            if(partes.length > 2)val = partes[0]+'.'+partes.slice(1).join('');
            if (val.startsWith('.'))val = '1';
            if (val === '' || isNaN(parseFloat(val))) val = '0';

            (e.target as HTMLInputElement).value = val;
            actualizarCarrito(idProduct, Number((e.target as HTMLInputElement).value), false, false,  productoCarrito?.valorunidad);
          });
          (e.target as HTMLElement).dataset.event = "eventInput"; //se marca al input que ya tiene evento añadido
        }
      }
      if((e.target as HTMLElement).classList.contains('mas')){
        actualizarCarrito(idProduct, productoCarrito!.cantidad+1, false, true, productoCarrito?.valorunidad);
      }
      if((e.target as HTMLElement).classList.contains('eliminarProducto') || (e.target as HTMLElement).tagName == "I"){
        carrito = carrito.filter(x=>x.idproducto != idProduct && x.valorunidad != precio);
        valorCarritoTotal();
        tablaventa?.querySelector(`TR[data-id="${idProduct}"][data-precio="${precio}"]`)?.remove();
      }
    });


    /*btnvaciar?.addEventListener('click', ()=>{
      if(carrito.length){
        miDialogoVaciar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });*/

    btnguardar?.addEventListener('click', ()=>{
      if(carrito.length){
        miDialogoGuardar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    btnaplicarcredito?.addEventListener('click', ()=>{
      if(modalidadEntrega.textContent === ": Domicilio" && (selectCliente.value =='1' || !dirEntrega.value) || selectCliente.value =='1'){
        msjAlert('error', 'Cliente o direccion no seleccionado', (document.querySelector('#divmsjalerta1') as HTMLElement));
        return;
      }
      if(carrito.length){
        document.querySelector('.Efectivo')?.removeAttribute('readonly');
        document.querySelector('#inputscreditos')?.classList.add('flex');
        document.querySelector('#inputscreditos')?.classList.remove('hidden');
        if(tipoventa == "Contado"){
          mapMediospago.clear();
          $('.mediopago').val(0);
        }
        tipoventa = "Credito";
        POS.gestionSubirModalPagar.subirModalPagar();
        //miDialogoCredito.showModal();
        miDialogoFacturar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    btnfacturar?.addEventListener('click', ()=>{
      if(modalidadEntrega.textContent === ": Domicilio" && (selectCliente.value =='1' || !dirEntrega.value)){
        msjAlert('error', 'Cliente o direccion no seleccionado', (document.querySelector('#divmsjalerta1') as HTMLElement));
        return;
      }
      if(carrito.length){
        document.querySelector('.Efectivo')?.setAttribute('readonly', 'true');
        document.querySelector('#inputscreditos')?.classList.add('hidden');
        document.querySelector('#inputscreditos')?.classList.remove('flex');
        tipoventa = "Contado";
        POS.gestionSubirModalPagar.subirModalPagar();
        miDialogoFacturar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });


    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      if (f === miDialogoDescuento || f === miDialogoCredito || f === miDialogoGuardar || f === miDialogoFacturar || f === miDialogoAddCliente || f === miDialogoOtrosProductos || f === miDialogoFacturarA || f === miDialogoAddDir || f=== miDialogoPreciosAdicionales || (f as HTMLInputElement).closest('.salir') || (f as HTMLInputElement).closest('.novaciar') || (f as HTMLInputElement).closest('.sivaciar') || (f as HTMLInputElement).closest('.noguardar') || (f as HTMLInputElement).closest('.siguardar') || (f as HTMLButtonElement).value == "Cancelar" || /*(f as HTMLButtonElement).value == "Seleccionar" ||*/ (f as HTMLButtonElement).classList.contains('btnCerrarPreciosAdicionales') ) {
        miDialogoDescuento.close();
        //miDialogoCredito.close();
        miDialogoGuardar.close();
        miDialogoFacturar.close();
        miDialogoAddCliente.close();
        miDialogoAddDir.close();
        miDialogoFacturarA.close();
        miDialogoOtrosProductos.close();
        miDialogoPreciosAdicionales.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        if((f as HTMLInputElement).closest('.siguardar')){
          tipoventa = "";
          procesarpedido('Guardado', '1');
        }
        //if((f as HTMLInputElement).closest('.sivaciar'))vaciarventa();
      }
    }

    function vaciarventa():void
    {
      if(datosfactura?.id)datosfactura.id = '';
      mapMediospago.clear();
      $('.mediopago').val(0);
      carrito.length = 0;
      factimpuestos.length = 0;
      history.replaceState({}, "", "/admin/ventas");
      while(tablaventa?.firstChild)tablaventa.removeChild(tablaventa?.firstChild);
      (document.querySelector('#npedido') as HTMLInputElement).value = '';
      document.querySelector('#subTotal')!.textContent = '$'+0;
      (document.querySelector('#descuento') as HTMLElement).textContent = '$'+0;
      document.querySelector('#total')!.textContent = '$'+0;
      $('#selectCliente').val(1).trigger('change');   //aqui tambien se reinicia la elemento del valor de la tarifa
      for(const key in valorTotal)valorTotal[key as keyof typeof valorTotal] = 0; //reiniciar objeto
    }


    ////////////////// evento al bton pagar del modal facturar //////////////////////
    document.querySelector('#formfacturar')?.addEventListener('submit', e=>{
      e.preventDefault();
      if(valorTotal.total <= 0 || valorTotal.subtotal <= 0){
        msjAlert('error', 'No se puede procesar pago con $0', (document.querySelector('#divmsjalerta2') as HTMLElement));
        return;
      }
      procesarpedido('Paga', '0');
    });

    async function procesarpedido(estado:string, ctz:string){
      const imprimir = document.querySelector('input[name="imprimir"]:checked') as HTMLInputElement;
      const datos = new FormData();
      datos.append('id', datosfactura?.id??'');
      datos.append('idcliente', (document.querySelector('#selectCliente') as HTMLSelectElement).value);
      datos.append('idvendedor', (document.querySelector('#vendedor') as HTMLInputElement).dataset.idvendedor!);
      datos.append('idcaja', btnCaja.value);
      datos.append('idconsecutivo', btnTipoFacturador.value);
      datos.append('iddireccion', dirEntrega.value);
      datos.append('idtarifazona', valorTotal.idtarifa+'');
      datos.append('cliente', selectCliente.value=='1'?'N/A':selectCliente.options[selectCliente.selectedIndex].textContent!);
      datos.append('vendedor', (document.querySelector('#vendedor') as HTMLInputElement).value);
      datos.append('caja', (document.querySelector('#caja option:checked') as HTMLSelectElement).textContent!);
      datos.append('tipofacturador', btnTipoFacturador.options[btnTipoFacturador.selectedIndex].textContent!);
      datos.append('direccion', dirEntrega.options[dirEntrega.selectedIndex]?.text??'');
      datos.append('tarifazona', nombretarifa||'');
      datos.append('carrito', JSON.stringify(carrito.filter(x=>x.cantidad>0)));  //envio de todos los productos con sus cantidades
      datos.append('totalunidades', totalunidades.textContent!);
      //datos.append('mediosPago', JSON.stringify(Object.fromEntries(mapMediospago)));
      datos.append('mediosPago', JSON.stringify(Array.from(mapMediospago, ([idmediopago, valor])=>({idmediopago, id_factura:0, valor}))));
      datos.append('factimpuestos', JSON.stringify(factimpuestos));
      datos.append('recibido', document.querySelector<HTMLInputElement>('#recibio')!.value);
      datos.append('transaccion', '');
      datos.append('tipoventa', tipoventa);
      datos.append('cotizacion', ctz);  //1= cotizacion, 0 = no cotizacion pagada.
      datos.append('estado', estado);
      datos.append('subtotal', valorTotal.subtotal+'');
      datos.append('base', valorTotal.base.toFixed(3));
      datos.append('valorimpuestototal', valorTotal.valorimpuestototal+''); //valor total del impuesto. 
      datos.append('dctox100',valorTotal.dctox100+'');
      datos.append('descuento',valorTotal.descuento+'');
      datos.append('total', valorTotal.total.toString());
      datos.append('observacion', document.querySelector<HTMLTextAreaElement>('#observacion')!.value);
      datos.append('departamento', '');
      datos.append('ciudad', (document.querySelector('#ciudadEntrega') as HTMLInputElement).value);
      datos.append('entrega', modalidadEntrega.textContent!.replace(': ', ''));
      datos.append('valortarifa', valorTotal.valortarifa+'');
      datos.append('opc1', '');
      datos.append('opc2', '');
      try {
          const url = "/admin/api/facturar";  //va al controlador ventascontrolador
          const respuesta = await fetch(url, {method: 'POST', body: datos}); 
          const resultado = await respuesta.json();
          if(resultado.exito !== undefined){
            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            /////// reinciar modulo de ventas
            vaciarventa();
            if(resultado.idfactura && imprimir.value === '1')printTicketPOS(resultado.idfactura);
          }else{
            msjalertToast('error', '¡Error!', resultado.error[0]);
          }
      } catch (error) {
          console.log(error);
      }
      miDialogoFacturar.close();
      (document.getElementById('miDialogoCarritoMovil') as HTMLDialogElement).close();
      document.removeEventListener("click", cerrarDialogoExterno);
    }


    function printTicketPOS(idfactura:string){
      setTimeout(() => {
        window.open("/admin/printPDFPOS?id=" + idfactura, "_blank");
      }, 1200);
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
            carrito.forEach(item =>printProduct(item.idproducto, item.valorunidad));
            valorCarritoTotal(); //recalcula impuestos de la cotizacion y valores totales
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