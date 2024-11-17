(()=>{

  const productos = document.querySelectorAll<HTMLElement>('#producto')!;
  const contentproducts = document.querySelector('#productos');
  const tablaventa = document.querySelector('#tablaventa tbody');
  const btnvaciar = document.querySelector('#btnvaciar');
  const btnguardar = document.querySelector('#btnguardar');
  const btnfacturar = document.querySelector('#btnfacturar');
  const miDialogoVaciar = document.querySelector('#miDialogoVaciar') as any;
  const miDialogoGuardar = document.querySelector('#miDialogoGuardar') as any;
  const miDialogoFacturar = document.querySelector('#miDialogoFacturar') as any;
   
  let carrito:{id:string, idcategoria: string, nombre: string, precio_venta: string, cantidad: number, total: number}[]=[];
  const valorTotal = {subtotal: 0, impuesto: 0, descuento: 0, total: 0}

  type productsapi = {
    id:string,
    idcategoria: string,
    nombre: string,
    foto: string,
    marca: string,
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

  contentproducts?.addEventListener('click', (e:Event)=>{
    const elementProduct = (e.target as HTMLElement)?.closest('.producto');
    if(elementProduct)
      actualizarCarrito((elementProduct as HTMLElement).dataset.id!, 1, true);
  });

  function printProduct(id:string){
    const unproducto = products.find(x=>x.id==id);
    const tr = document.createElement('TR');
    tr.classList.add('productselect');
    tr.dataset.id = `${id}`;
    tr.insertAdjacentHTML('afterbegin', `<td class="!px-0 !py-2 text-xl text-gray-500 leading-5">${unproducto?.nombre}</td> 
    <td class="!px-0 !py-2"><div class="flex"><button><span class="menos material-symbols-outlined">remove</span></button><input type="text" class="inputcantidad w-20 px-2 text-center" value="1" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"><button><span class="mas material-symbols-outlined">add</span></button></div></td>
    <td class="!p-2 text-xl text-gray-500 leading-5">$${Number(unproducto?.precio_venta).toLocaleString()}</td>
    <td class="!p-2 text-xl text-gray-500 leading-5">$${Number(unproducto?.precio_venta).toLocaleString()}</td>
    <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarEmpleado"><i class="fa-solid fa-trash-can"></i></button></div></td>`);
    tablaventa?.appendChild(tr);
  }


  function actualizarCarrito(id:string, cantidad:number, control:boolean){
    const index = carrito.findIndex(x=>x.id==id);
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
      carrito[index].total = parseInt(carrito[index].precio_venta)*carrito[index].cantidad;
      valorCarritoTotal();
      (tablaventa?.querySelector(`TR[data-id="${id}"] .inputcantidad`) as HTMLInputElement).value = carrito[index].cantidad+'';
      (tablaventa?.querySelector(`TR[data-id="${id}"]`)?.children?.[3] as HTMLElement).textContent = "$"+carrito[index].total.toLocaleString();
    }else{  //agregar a carrito si el producto no esta agregado en carrito
      const producto = products.find(x=>x.id==id)!; //products es el arreglo de todos los productos traido por api
      const a:{id:string, idcategoria: string, nombre: string, precio_venta: string, cantidad: number, total:number} = {
        id: producto?.id!,
        idcategoria: producto.idcategoria,
        nombre: producto.nombre,
        precio_venta: producto.precio_venta,
        cantidad: 1,
        total: Number(producto.precio_venta)
      }
      carrito = [...carrito, a];
      valorCarritoTotal();
      printProduct(id);
    }
  }

  function valorCarritoTotal(){
    valorTotal.subtotal = carrito.reduce((total, x)=>x.total+total, 0);
    valorTotal.total = valorTotal.subtotal;
    document.querySelector('#subTotal')!.textContent = '$'+valorTotal.subtotal.toLocaleString();
    document.querySelector('#total')!.textContent = '$'+valorTotal.total.toLocaleString();
  }

  //////////////////////////////////// evento a la tabla de productos de venta ///////////////////////////////////
  tablaventa?.addEventListener('click', (e:Event)=>{
    const elementProduct = (e.target as HTMLElement)?.closest('.productselect');
    const idProduct = (elementProduct as HTMLElement).dataset.id!;
    if((e.target as HTMLElement).classList.contains('menos')){
      const productoCarrito = carrito.find(x=>x.id==idProduct);
      actualizarCarrito(idProduct, productoCarrito!.cantidad-1, false);
    }
    if((e.target as HTMLElement).classList.contains('inputcantidad')){
      if((e.target as HTMLElement).dataset.event != "eventInput"){
        e.target?.addEventListener('input', (e)=>{
          actualizarCarrito(idProduct, Number((e.target as HTMLInputElement).value), false);
        });
        (e.target as HTMLElement).dataset.event = "eventInput";
      }
    }
    if((e.target as HTMLElement).classList.contains('mas')){
      const productoCarrito = carrito.find(x=>x.id==idProduct);
      actualizarCarrito(idProduct, productoCarrito!.cantidad+1, false);
    }
    if((e.target as HTMLElement).classList.contains('eliminarEmpleado') || (e.target as HTMLElement).tagName == "I"){
      carrito = carrito.filter(x=>x.id != idProduct);
      valorCarritoTotal();
      tablaventa?.querySelector(`TR[data-id="${idProduct}"]`)?.remove();
    }
  });

  /////////////////////////////////btn vaciar ////////////////////////////////

  btnvaciar?.addEventListener('click', ()=>{
    if(carrito.length)
      miDialogoVaciar.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
  });

  btnguardar?.addEventListener('click', ()=>{
    if(carrito.length)
      miDialogoGuardar.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
  });

  btnfacturar?.addEventListener('click', ()=>{
    if(carrito.length)
      miDialogoFacturar.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
  });

  function cerrarDialogoExterno(event:Event) {
    if (event.target === miDialogoVaciar || event.target === miDialogoGuardar || event.target === miDialogoFacturar || (event.target as HTMLInputElement).closest('.novaciar') || (event.target as HTMLInputElement).closest('.sivaciar') || (event.target as HTMLInputElement).closest('.noguardar') || (event.target as HTMLInputElement).closest('.siguardar')) {
      miDialogoVaciar.close();
      miDialogoGuardar.close();
      miDialogoFacturar.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    }
  }

})();