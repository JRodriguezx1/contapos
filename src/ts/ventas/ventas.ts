(()=>{
  if(document.querySelector('.ventas')){
    const btnAddCliente = document.querySelector('#addcliente') as HTMLElement;
    const btnAddDir = document.querySelector('#adddir') as HTMLElement;
    const selectCliente = document.querySelector('#selectCliente') as HTMLSelectElement;
    const dirEntrega = document.querySelector('#direccionEntrega')! as HTMLSelectElement;
    const facturarA = document.querySelector('#facturarA') as HTMLButtonElement;
    const productos = document.querySelectorAll<HTMLElement>('#producto')!;
    const contentproducts = document.querySelector('#productos');
    const btnotros = document.querySelector('#btnotros') as HTMLButtonElement;  //btn de otros
    const btndescuento = document.querySelector('#btndescuento') as HTMLButtonElement;
    const btnEntrega = document.querySelector('#btnEntrega');
    const modalidadEntrega = document.querySelector('#modalidadEntrega') as HTMLElement;
    const totalunidades = document.querySelector('#totalunidades') as HTMLElement;
    const tablaventa = document.querySelector('#tablaventa tbody');
    const btnvaciar = document.querySelector('#btnvaciar');
    const btnguardar = document.querySelector('#btnguardar');
    const btnfacturar = document.querySelector('#btnfacturar');
    const miDialogoAddCliente = document.querySelector('#miDialogoAddCliente') as any;
    const miDialogoAddDir = document.querySelector('#miDialogoAddDir') as any;
    const miDialogoOtrosProductos = document.querySelector('#miDialogoOtrosProductos') as any;
    const miDialogoFacturarA = document.querySelector('#miDialogoFacturarA') as any;
    const miDialogoDescuento = document.querySelector('#miDialogoDescuento') as any;
    const miDialogoVaciar = document.querySelector('#miDialogoVaciar') as any;
    const miDialogoGuardar = document.querySelector('#miDialogoGuardar') as any;
    const miDialogoFacturar = document.querySelector('#miDialogoFacturar') as any;
    const btnCaja = document.querySelector('#caja') as HTMLSelectElement;
    const btnTipoFacturador = document.querySelector('#facturador') as HTMLSelectElement;
    const mediospago = document.querySelectorAll('.mediopago');
    const tipoDescts = document.querySelectorAll<HTMLInputElement>('input[name="tipodescuento"]'); //radio buttom
    const inputDescuento = document.querySelector('#inputDescuento') as HTMLInputElement;
    
    let carrito:{id:string, idproducto:string, tipoproducto:string, idcategoria: string, nombreproducto: string, valorunidad: string, cantidad: number, subtotal: number, impuesto:number, descuento:number, total: number}[]=[];
    const valorTotal = {subtotal: 0, impuesto: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
    let tarifas:{id:string, idcliente:string, nombre:string, valor:string}[] = [];
    let nombretarifa:string|undefined='', valorMax = 0;

    let otrosproductos:{id:number, nombre:string, cantidad:number, valorunidad:number, total:number}={
      id: 0,
      nombre: '',
      cantidad: 0,
      valorunidad: 0,
      total: 0
    }

    type productsapi = {
      id:string,
      idcategoria: string,
      nombre: string,
      foto: string,
      impuesto: string,
      marca: string,
      tipoproducto: string, // 0 = simple,  1 = compuesto
      codigo: string,
      descripcion: string,
      peso: string,
      medidas: string,
      color: string,
      funcion: string,
      uso:string,
      fabricante: string,
      garantia: string,
      stock: string,
      categoria: string,
      precio_compra: string,
      precio_venta: string,
      fecha_ingreso: string,
      //idservicios:{idempleado:string, idservicio:string}[]
    };
    

    let products:productsapi[]=[], unproducto:productsapi;
    const mapMediospago = new Map();

    (async ()=>{
      try {
          const url = "/admin/api/allproducts"; //llamado a la API REST
          const respuesta = await fetch(url); 
          products = await respuesta.json(); 
          console.log(products);
      } catch (error) {
          console.log(error);
      }
    })();

    /*productos.forEach(producto=>{
      producto.addEventListener('click', (e)=>{
        console.log(producto.dataset.id);
      });
    });*/

    //////////// evento al boton añadir cliente nuevo //////////////
    btnAddCliente?.addEventListener('click', (e)=>{
      miDialogoAddCliente.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });
    //////////// evento al boton añadir nueva direccion //////////////
    btnAddDir?.addEventListener('click', (e)=>{
      miDialogoAddDir.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });
    //////////// evento al btn submit del formulario add nuevo cliente //////////////
    document.querySelector('#formAddCliente')?.addEventListener('submit', e=>{
      e.preventDefault();
      (async ()=>{
        const datos = new FormData();
        datos.append('nombre', (document.querySelector('#nombreclientenuevo') as HTMLInputElement).value);
        datos.append('apellido', (document.querySelector('#clientenuevoapellido') as HTMLInputElement).value);
        datos.append('tipodocumento', (document.querySelector('#tipodocumento') as HTMLInputElement).value);
        datos.append('identificacion', (document.querySelector('#identificacion') as HTMLInputElement).value);
        datos.append('telefono', (document.querySelector('#telefono') as HTMLInputElement).value);
        datos.append('email', (document.querySelector('#clientenuevoemail') as HTMLInputElement).value);
        datos.append('idtarifa', (document.querySelector('#clientenuevotarifa') as HTMLSelectElement).value);
        datos.append('direccion', (document.querySelector('#clientenuevodireccion') as HTMLInputElement).value);
        datos.append('departamento', (document.querySelector('#departamento') as HTMLInputElement).value);
        datos.append('ciudad', (document.querySelector('#ciudad') as HTMLInputElement).value);
        try {
            const url = "/admin/api/apiCrearCliente";
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              addClienteSelect(resultado.nextID);
              limpiarformdialog();
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
      })();
      miDialogoAddCliente.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    });
    /////////////// añadir cliente al select despues de crearse ///////////////////
    function addClienteSelect(clienteID:string): void{
      const option = document.createElement('option');
      option.textContent = (document.querySelector('#nombreclientenuevo') as HTMLInputElement).value + " " + (document.querySelector('#clientenuevoapellido') as HTMLInputElement).value;
      option.value = clienteID;
      option.dataset.tipodocumento = (document.querySelector('#tipodocumento') as HTMLInputElement).value;
      option.dataset.identidad = (document.querySelector('#identificacion') as HTMLInputElement).value;
      selectCliente?.appendChild(option);
      $('#selectCliente').val(clienteID).trigger('change'); // seleccionar el cliente nuevo, en el select y dispara evento
    }
    //evento 'cambio' al selecionar cliente, tambien se ejecuta cuando se crea cliente nuevo//
    $("#selectCliente").on('change', (e)=>{
      const idcli = (e.target as HTMLInputElement).value;
      (async ()=>{
        try {
          const url = "/admin/api/direccionesXcliente?id="+idcli; //llamado a la API REST y se trae las direcciones segun cliente elegido
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          addDireccionSelect(resultado);
        } catch (error) {
            console.log(error);
        }
      })();
      const select = (e.target as HTMLSelectElement);
      const x:string = select.options[select.selectedIndex].dataset.identidad||'';
      (document.querySelector('#documento') as HTMLInputElement).value = x;
    });
    ////// añade direccion al select de direcciones, cuando se selecciona o se agrega un cliente o si se agrega un nueva direccion/////
    function addDireccionSelect<T extends {id:string, idcliente:string, idtarifa:string, tarifa:{id:string, idcliente:string, nombre:string, valor:string}, direccion:string, ciudad:string}>(addrs: T[]):void{
      while(dirEntrega?.firstChild)dirEntrega.removeChild(dirEntrega?.firstChild);
      const setTarifas = new Set();
      tarifas.length = 0;
      addrs.forEach(dir =>{
        const option = document.createElement('option');
        option.textContent = dir.direccion;
        option.value = dir.id;
        option.dataset.idcliente = dir.idcliente;
        option.dataset.idtarifa = dir.idtarifa;
        option.dataset.ciudad = dir.ciudad;
        dirEntrega.appendChild(option);
        dir.tarifa.idcliente = dir.idcliente;
        if(!setTarifas.has(dir.tarifa.id)){
          tarifas = [...tarifas, dir.tarifa];
          setTarifas.add(dir.tarifa.id);
        }
      });
      setTarifas.clear();
      printTarifaEnvio();
      valorCarritoTotal();
      (document.querySelector('#ciudadEntrega') as HTMLInputElement).value = addrs[0].ciudad;
    }
    ///////// Evento al select de direcciones ////////////
    dirEntrega?.addEventListener('change', (e)=>{
      const select = (e.target as HTMLSelectElement);
      const x:string = select.options[select.selectedIndex].dataset.ciudad||'';
      (document.querySelector('#ciudadEntrega') as HTMLInputElement).value = x;
      printTarifaEnvio();
      valorCarritoTotal();
    });

    ////////////////// evento al btn submit del formulario add direccion //////////////////////
    document.querySelector('#formAddDir')?.addEventListener('submit', e=>{
      e.preventDefault();
      (async ()=>{
        const datos = new FormData();
        datos.append('idcliente', selectCliente.value);
        datos.append('departamento', (document.querySelector('#adddepartamento') as HTMLInputElement).value);
        datos.append('ciudad', (document.querySelector('#addciudad') as HTMLInputElement).value);
        datos.append('direccion', (document.querySelector('#adddireccion') as HTMLInputElement).value);
        datos.append('idtarifa', (document.querySelector('#tarifa') as HTMLSelectElement).value);
        try {
            const url = "/admin/api/addDireccionCliente";  //direccionescontrolador
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              addDireccionSelect(resultado.direcciones);
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
      })();
      miDialogoAddDir.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    });


    //////////// evento al boton modalidad de entrega //////////////
    btnEntrega?.addEventListener('click', (e:Event)=>{
      modalidadEntrega.textContent == ": Presencial"?modalidadEntrega.textContent = ": Domicilio":modalidadEntrega.textContent=": Presencial";
      printTarifaEnvio();
      valorCarritoTotal();
    });

    ///////// funcion que imprime el valor de la tarifa segun direccion ///////////
    function printTarifaEnvio():void{
      const selectDir = dirEntrega.options[dirEntrega.selectedIndex];
      if(modalidadEntrega.textContent == ": Presencial" || dirEntrega.selectedIndex == -1){
        valorTotal.valortarifa = 0;
        nombretarifa = '';
        return;
      }
      if(selectDir?.dataset.idtarifa && modalidadEntrega.textContent == ": Domicilio"){
        const objtarifa = tarifas.find(tarifa =>{
          if(tarifa.idcliente == selectDir.dataset.idcliente && tarifa.id == selectDir.dataset.idtarifa)
            return true;
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

    ///////////////////// Evento al btn Otros /////////////////////////
    btnotros.addEventListener('click', (e:Event)=>{
      miDialogoOtrosProductos.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });

    /////////////////////Evento al formulario de agregar otros productos //////////////////////
    document.querySelector('#formOtrosProductos')?.addEventListener('submit', (e:Event)=>{
      e.preventDefault();
      const formelements = (e.target as HTMLFormElement).elements;
      const cantidadotros = Number((formelements.namedItem('cantidadotros') as HTMLInputElement).value);
      const preciootros = Number((formelements.namedItem('preciootros') as HTMLInputElement).value);
      
      otrosproductos!.id += -1 ;
      otrosproductos!.nombre = (formelements.namedItem('nombreotros') as HTMLInputElement).value;
      otrosproductos!.cantidad = cantidadotros;
      otrosproductos!.valorunidad = preciootros/cantidadotros;
      otrosproductos!.total = preciootros;
      
      products = [...products, {
        id: otrosproductos!.id+'', 
        idcategoria: '-1',
        nombre: otrosproductos!.nombre,
        foto: 'na',
        impuesto: '0',
        marca: 'na',
        tipoproducto: '-1', // 0 = simple,  1 = compuesto
        codigo: '-1',
        descripcion: 'na',
        peso: 'na',
        medidas: 'na',
        color: 'na',
        funcion: 'na',
        uso: 'na',
        fabricante: 'na',
        garantia: 'na',
        stock: '0',
        categoria: 'na',
        precio_compra: 'na',
        precio_venta: otrosproductos!.valorunidad+'',
        fecha_ingreso: ''
      }];

      actualizarCarrito(otrosproductos.id+'', 1, false);
    });

    //////////// evento a toda el area de los productos a seleccionar //////////////
    contentproducts?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.producto');
      if(elementProduct)
        actualizarCarrito((elementProduct as HTMLElement).dataset.id!, 1, true);
    });

    function printProduct(id:string){
      unproducto = products.find(x=>x.id==id)!;
      const tr = document.createElement('TR');
      tr.classList.add('productselect');
      tr.dataset.id = `${id}`;
      tr.insertAdjacentHTML('afterbegin', `<td class="!px-0 !py-2 text-xl text-gray-500 leading-5">${unproducto?.nombre}</td> 

      <td class="!px-0 !py-2">
        <div class="flex items-center gap-2 px-4">
          <button type="button" class="w-8 h-8 bg-indigo-700 text-white rounded-full flex items-center justify-center">
            <span class="menos material-symbols-outlined text-base">remove</span>
          </button>

          <input type="text" class="inputcantidad w-20 px-2 text-center" value="1"
            oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)">

          <button type="button" class="w-8 h-8 bg-indigo-700 text-white rounded-full flex items-center justify-center">
            <span class="mas material-symbols-outlined text-base">add</span>
          </button>
        </div>
      </td>


      <td class="!p-2 text-xl text-gray-500 leading-5">$${Number(unproducto?.precio_venta).toLocaleString()}</td>
      <td class="!p-2 text-xl text-gray-500 leading-5">$${Number(unproducto?.precio_venta).toLocaleString()}</td>
      <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>`);
      tablaventa?.appendChild(tr);
    }


    function actualizarCarrito(id:string, cantidad:number, control:boolean){
      const index = carrito.findIndex(x=>x.idproducto==id); //devuelve el index si el producto existe
      
      if(index>-1){
        if(cantidad == 0){
          carrito[index].cantidad = 1;
          return;
        }
        if(control){ //cuando el producto se agrega desde la lista de productos
          carrito[index].cantidad += cantidad;
        }else{ //cuando el producto se agrega por cantidad
          carrito[index].cantidad = cantidad;
        }
        carrito[index].total = parseInt(carrito[index].valorunidad)*carrito[index].cantidad;
        valorCarritoTotal();
        (tablaventa?.querySelector(`TR[data-id="${id}"] .inputcantidad`) as HTMLInputElement).value = carrito[index].cantidad+'';
        (tablaventa?.querySelector(`TR[data-id="${id}"]`)?.children?.[3] as HTMLElement).textContent = "$"+carrito[index].total.toLocaleString();
      }else{  //agregar a carrito si el producto no esta agregado en carrito
        const producto = products.find(x=>x.id==id)!; //products es el arreglo de todos los productos traido por api
        
          var a:{id:string, idproducto:string, tipoproducto:string, idcategoria: string, nombreproducto: string, valorunidad: string, cantidad: number, subtotal: number, impuesto:number, descuento:number, total:number} = {
            id: producto?.id!,
            idproducto: producto?.id!,
            tipoproducto: producto.tipoproducto,
            idcategoria: producto.idcategoria,
            nombreproducto: producto.nombre,
            valorunidad: producto.precio_venta,
            cantidad: 1,
            subtotal: 0, //este es el subtotal del producto
            impuesto: 0,
            descuento: 0,
            total: Number(producto.precio_venta)
          }
        
        carrito = [...carrito, a];
        valorCarritoTotal();
        printProduct(id);
      }
    }

    ////////////////////// valores finales subtotal y total ////////////////////////
    function valorCarritoTotal(){
      valorTotal.subtotal = carrito.reduce((total, x)=>x.total+total, 0);
      //console.log(valorTotal.subtotal);
      valorTotal.total = valorTotal.subtotal + valorTotal.valortarifa - valorTotal.descuento;
      document.querySelector('#subTotal')!.textContent = '$'+valorTotal.subtotal.toLocaleString();
      (document.querySelector('#valorTarifa') as HTMLElement).textContent = '$'+valorTotal.valortarifa.toLocaleString();
      document.querySelector('#total')!.textContent = '$ '+valorTotal.total.toLocaleString();
      // cantidad total de productos
      totalunidades.textContent = carrito.reduce((total, producto)=>producto.cantidad+total, 0)+'';
    }

    //////////////////////////////////// evento a la tabla de productos de venta ///////////////////////////////////
    tablaventa?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.productselect');
      const idProduct = (elementProduct as HTMLElement).dataset.id!;
      if((e.target as HTMLElement).classList.contains('menos')){
        const productoCarrito = carrito.find(x=>x.idproducto==idProduct);
        actualizarCarrito(idProduct, productoCarrito!.cantidad-1, false);
      }
      if((e.target as HTMLElement).classList.contains('inputcantidad')){
        if((e.target as HTMLElement).dataset.event != "eventInput"){
          e.target?.addEventListener('input', (e)=>{
            actualizarCarrito(idProduct, Number((e.target as HTMLInputElement).value), false);
          });
          (e.target as HTMLElement).dataset.event = "eventInput"; //se marca al input que ya tiene evento añadido
        }
      }
      if((e.target as HTMLElement).classList.contains('mas')){
        const productoCarrito = carrito.find(x=>x.idproducto==idProduct);
        actualizarCarrito(idProduct, productoCarrito!.cantidad+1, false);
      }
      if((e.target as HTMLElement).classList.contains('eliminarEmpleado') || (e.target as HTMLElement).tagName == "I"){
        carrito = carrito.filter(x=>x.idproducto != idProduct);
        valorCarritoTotal();
        tablaventa?.querySelector(`TR[data-id="${idProduct}"]`)?.remove();
      }
    });

    /////////////////btns descuento, vaciar, guardar y facturar /////////////////

    btndescuento?.addEventListener('click', ()=>{
      if(carrito.length){
        valorMax = valorTotal.subtotal;
        //validar que si al reducir los productos o aumentar recalcular el porcentaje
        miDialogoDescuento.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    btnvaciar?.addEventListener('click', ()=>{
      if(carrito.length){
        miDialogoVaciar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    btnguardar?.addEventListener('click', ()=>{
      if(carrito.length){
        miDialogoGuardar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    btnfacturar?.addEventListener('click', ()=>{
        if(modalidadEntrega.textContent === ": Domicilio" && (selectCliente.value =='1' || selectCliente.value =='2' || !dirEntrega.value)){
          msjAlert('error', 'Cliente o direccion no seleccionado', (document.querySelector('#divmsjalerta1') as HTMLElement));
          return;
        }
      if(carrito.length){
        subirModalPagar();
        miDialogoFacturar.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

  /////////////////////  logica del descuento  //////////////////////////
    tipoDescts.forEach(desc=>{ //evento a los radiobutton
      desc.addEventListener('change', (e:Event)=>{
        if((e.target as HTMLInputElement).value === "porcentaje"){
          valorMax = 100;
          inputDescuento.value = '';
        }
        if((e.target as HTMLInputElement).value === "valor"){
          inputDescuento.value = '';
          valorMax = valorTotal.subtotal;
        }
      });
    });

    inputDescuento?.addEventListener('input', (e)=>{
      var valorInput:number = Number((e.target as HTMLInputElement).value);
      if(valorInput > valorMax){
        inputDescuento.value = valorMax+'';
        valorInput = valorMax; 
      }
    });

    document.querySelector('#formDescuento')?.addEventListener('submit', e=>{
      e.preventDefault();
      const valorInput:number = Number(inputDescuento.value);
      if(tipoDescts[0].checked){  //tipo valor
        valorTotal.dctox100 = Math.round((valorInput*100)/valorTotal.subtotal);  // valor en porcentaje
        valorTotal.descuento = valorInput;  //valor del dcto
      }
      if(tipoDescts[1].checked){ //tipo porcentaje
        valorTotal.descuento = (valorTotal.subtotal*valorInput)/100;  //valor descontado
        valorTotal.dctox100 = valorInput;  //valor en porcentaje
      }
      valorTotal.total = valorTotal.subtotal - valorTotal.descuento + valorTotal.valortarifa;
      document.querySelector('#total')!.textContent = '$ '+valorTotal.total.toLocaleString();
      (document.querySelector('#descuento') as HTMLElement).textContent = '$'+valorTotal.descuento.toLocaleString();
      miDialogoDescuento.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    });

  /////////////////////  logica del modal de pago  //////////////////////////
    function subirModalPagar(){
      document.querySelector('#totalPagar')!.textContent = `${valorTotal.total.toLocaleString()}`;
      //como se puede cerrar el modal y aumentar los productos, hay calcular los inputs
      let totalotrosmedios = 0;
      mediospago.forEach((item, index)=>{
        if(index>0)totalotrosmedios += parseInt((item as HTMLInputElement).value.replace(/[,.]/g, ''));
      });

      if(valorTotal.total<totalotrosmedios){
        totalotrosmedios = 0;
        mapMediospago.clear();
        $('.mediopago').val(0);
      }
      (document.querySelector('.Efectivo')! as HTMLInputElement).value =  `${valorTotal.total-totalotrosmedios}`;
      mapMediospago.set('1', valorTotal.total-totalotrosmedios);
      if(valorTotal.total-totalotrosmedios == 0 && mapMediospago.has('1'))mapMediospago.delete('1');
      calcularCambio(document.querySelector<HTMLInputElement>('#recibio')!.value);
    }
    
    //eventos a los inputs medios de pago
    mediospago.forEach(m=>{m.addEventListener('input', (e)=>{ calcularmediospago(e);});}); 

    function calcularmediospago(e:Event){
      let totalotrosmedios = 0;
      mediospago.forEach((item, index)=>{ //sumar todos los medios de pago menos el efectivo
        if(index>0)totalotrosmedios += parseInt((item as HTMLInputElement).value.replace(/[,.]/g, ''));
      });
      if(totalotrosmedios<=valorTotal.total){
        mapMediospago.set('1', valorTotal.total-totalotrosmedios);
        if(valorTotal.total-totalotrosmedios == 0 && mapMediospago.has('1'))mapMediospago.delete('1');
        mapMediospago.set((e.target as HTMLInputElement).id, parseInt((e.target as HTMLInputElement).value.replace(/[,.]/g, '')));
        if((e.target as HTMLInputElement).value == '0' && mapMediospago.has((e.target as HTMLInputElement).id))mapMediospago.delete((e.target as HTMLInputElement).id);
      }else{ //si la suma de los medios de pago superan el valor total, toma el ultimo input digitado y lo reestablece a su ultimo valor
        if(mapMediospago.has((e.target as HTMLInputElement).id)){
          (e.target as HTMLInputElement).value = mapMediospago.get((e.target as HTMLInputElement).id).toLocaleString();
        }else{
          (e.target as HTMLInputElement).value = '0';
        }
      }
      (mediospago[0] as HTMLInputElement).value = mapMediospago.get('1')??0;
      calcularCambio(document.querySelector<HTMLInputElement>('#recibio')!.value);
    }

    /////////////////////  evento al input recibido  //////////////////////////
    document.querySelector<HTMLInputElement>('#recibio')?.addEventListener('input', (e)=>{
      calcularCambio((e.target as HTMLInputElement).value);
    });

    function calcularCambio(recibido:string):void{
      recibido = recibido.replace(/[,.]/g, '');
      if(Number(recibido)>mapMediospago.get('1')){
        (document.querySelector('#cambio') as HTMLElement).textContent = (Number(recibido)-mapMediospago.get('1')).toLocaleString()+'';
        return;
      }
      (document.querySelector('#cambio') as HTMLElement).textContent = '0';
    }


    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      if (f === miDialogoDescuento || f === miDialogoVaciar || f === miDialogoGuardar || f === miDialogoFacturar || f === miDialogoAddCliente || f === miDialogoOtrosProductos || f === miDialogoFacturarA || f === miDialogoAddDir || (f as HTMLInputElement).closest('.salir') || (f as HTMLInputElement).closest('.novaciar') || (f as HTMLInputElement).closest('.sivaciar') || (f as HTMLInputElement).closest('.noguardar') || (f as HTMLInputElement).closest('.siguardar') || (f as HTMLButtonElement).value == "Cancelar" ) {
        miDialogoDescuento.close();
        miDialogoVaciar.close();
        miDialogoGuardar.close();
        miDialogoFacturar.close();
        miDialogoAddCliente.close();
        miDialogoAddDir.close();
        miDialogoFacturarA.close();
        miDialogoOtrosProductos.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        if((f as HTMLInputElement).closest('.siguardar'))procesarpedido('Guardado', '1');
        if((f as HTMLInputElement).closest('.sivaciar'))vaciarventa();
      }
    }

    function vaciarventa():void
    {
      mapMediospago.clear();
      $('.mediopago').val(0);
      carrito.length = 0;
      while(tablaventa?.firstChild)tablaventa.removeChild(tablaventa?.firstChild);
      document.querySelector('#subTotal')!.textContent = '$'+0;
      (document.querySelector('#descuento') as HTMLElement).textContent = '$'+0;
      document.querySelector('#total')!.textContent = '$'+0;
      $('#selectCliente').val(1).trigger('change');   //aqui tambien se reinicia la elemento del valor de la tarifa
      for(const key in valorTotal)valorTotal[key as keyof typeof valorTotal] = 0; //reiniciar objeto
    }


    ////////////////// evento al bton pagar del modal facturar //////////////////////
    document.querySelector('#formfacturar')?.addEventListener('submit', e=>{
      e.preventDefault();
      procesarpedido('Paga', '0');
    });

    async function procesarpedido(estado:string, ctz:string){
      const datos = new FormData();
      datos.append('idcliente', (document.querySelector('#selectCliente') as HTMLSelectElement).value);
      datos.append('idvendedor', (document.querySelector('#vendedor') as HTMLInputElement).dataset.idvendedor!);
      datos.append('idcaja', btnCaja.value);
      datos.append('idconsecutivo', btnTipoFacturador.value);
      datos.append('iddireccion', dirEntrega.value);
      datos.append('idtarifazona', valorTotal.idtarifa+'');
      datos.append('cliente', selectCliente.options[selectCliente.selectedIndex].textContent!);
      datos.append('vendedor', (document.querySelector('#vendedor') as HTMLInputElement).value);
      datos.append('caja', (document.querySelector('#caja option:checked') as HTMLSelectElement).textContent!);
      datos.append('tipofacturador', btnTipoFacturador.options[btnTipoFacturador.selectedIndex].textContent!);
      datos.append('direccion', dirEntrega.options[dirEntrega.selectedIndex].text);
      datos.append('tarifazona', nombretarifa||'');
      datos.append('carrito', JSON.stringify(carrito));  //envio de todos los productos con sus cantidades
      datos.append('totalunidades', totalunidades.textContent!);
      //datos.append('mediosPago', JSON.stringify(Object.fromEntries(mapMediospago)));
      datos.append('mediosPago', JSON.stringify(Array.from(mapMediospago, ([idmediopago, valor])=>({idmediopago, id_factura:0, valor}))));
      datos.append('recibido', document.querySelector<HTMLInputElement>('#recibio')!.value);
      datos.append('transaccion', '');
      datos.append('cotizacion', ctz);  //1= cotizacion, 0 = no cotizacion pagada.
      datos.append('estado', estado);
      datos.append('subtotal', valorTotal.subtotal+'');
      datos.append('impuesto', valorTotal.impuesto+'');
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
          console.log(resultado);
          if(resultado.exito !== undefined){
            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            /////// reinciar modulo de ventas
            vaciarventa();
          }else{
            msjalertToast('error', '¡Error!', resultado.error[0]);
          }
      } catch (error) {
          console.log(error);
      }
      miDialogoFacturar.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    }


    function limpiarformdialog(){
      (document.querySelector('#formAddCliente') as HTMLFormElement)?.reset();
    }
  }

})();
