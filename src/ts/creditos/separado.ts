(()=>{
  if(document.querySelector('.crearseparado')){

    const POS = (window as any).POS;
     
    //const btnCrearCredito = document.querySelector('#btnCrearCredito') as HTMLButtonElement;
    const btnCrearSeparado = document.querySelector('#btnCrearSeparado');
    //const btnXCerrarModalCredito = document.querySelector('#btnXCerrarModalCredito') as HTMLButtonElement;
    const miDialogoFacturar = document.querySelector('#miDialogoFacturar') as any;
    const tablaSeparado = document.querySelector('#tablaSeparado tbody');
    const btnPagar = document.getElementById('btnPagar') as HTMLInputElement;
    const btnCaja = document.querySelector('#caja') as HTMLSelectElement; //select de la caja en el modal pagar
    
    /*interface Item {
      id_impuesto: number,
      facturaid: number,
      basegravable: number,
      valorimpuesto: number
    }
    let factimpuestos:Item[] = [];*/

    type conversionunidadesapi = {
      id:string,
      idproducto: string,
      idsubproducto: string,
      idunidadmedidabase: string,
      idunidadmedidadestino: string,
      nombreunidadbase: string,
      nombreunidaddestino: string,
      factorconversion: string,
      //idservicios:{idempleado:string, idservicio:string}[]
    };

    interface Item {
      id_impuesto: number,
      facturaid: number,
      basegravable: number,
      valorimpuesto: number
    }

    let allConversionUnidades:conversionunidadesapi[] = [];
    let filteredData: {id:string, text:string, tipo:string, tipoproduccion:string, impuesto:string, sku:string, unidadmedida:string, precio_venta:string}[];   //tipo = 0 es producto simple,  1 = subproducto
    let carrito:{id:string, fk_producto:string,  tipoproducto: string, tipoproduccion:string, foto:string,costo:number, valorunidad:string, nombreproducto:string,  rendimientoestandar:string, unidad:string, cantidad: number, factor: number, precio_venta: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total: number, precio_compra: number}[]=[];
    const valorTotal = {subtotal: 0, base: 0, valorimpuestototal: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
    let factimpuestos:Item[] = [], tipoventa:string="Contado";
    const mapMediospago = new Map();
    
    const constImp: {[key:string]: number} = {};
    constImp['excluido'] = 0;
    constImp['0'] = 0;  //exento de iva, tarifa 0%
    constImp['5'] = 0.0476190476190476; //iva, tarifa al 5%,  Bienes/servicios al 5
    constImp['8'] = 0.0740740740740741; //inc, tarifa al 8%,  impuesto nacional al consumo
    constImp['16'] = 0.1379310344827586; //iva, tarifa al 16%,  contratos firmados con el estado antes de ley 1819
    constImp['19'] = 0.1596638655462185; //iva, tarifa al 19%,  tarifa general

    ($('#cliente') as any).select2({ placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
    ($('#frecuenciapago') as any).select2({ placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});

     document.addEventListener("click", cerrarDialogoExterno);

    (async ()=>{
        try {
            const url = "/admin/api/allproducts"; //llamado a la API REST en el controlador almacencontrolador para treaer todas los productos simples y subproductos
            const respuesta = await fetch(url); 
            const resultado:{id:string, nombre:string, tipoproducto:string, tipoproduccion:string, impuesto:string, sku:string, unidadmedida:string, precio_venta:string}[] = await respuesta.json();
            filteredData = resultado.map(item => ({ id: item.id, text: item.nombre, tipo: item.tipoproducto??'0', tipoproduccion: item.tipoproduccion??'0', impuesto: item.impuesto, sku: item.sku, unidadmedida: item.unidadmedida, precio_venta: item.precio_venta }));
            activarselect2(filteredData);
        } catch (error) {
            console.log(error);
        }
    })();

    (async ()=>{
        try {
            const url = "/admin/api/allConversionesUnidades"; //llamado a la API REST en el controlador almacencontrolador para treaer todas las conversiones de unidades
            const respuesta = await fetch(url); 
            allConversionUnidades = await respuesta.json();
        } catch (error) {
            console.log(error);
        }
    })();


    function activarselect2(filteredData:{id:string, text:string, tipo:string, sku:string, unidadmedida:string}[]){
      ($('#articulo') as any).select2({ 
          data: filteredData,
          placeholder: "Selecciona un item",
          maximumSelectionLength: 1,
          /*
          templateResult: function (data:{id:string, text:string, tipo:string}) {
              // Personalizar cómo se muestra cada opción en el dropdown
              if (!data.id) { return data.text; }  // Si no hay id, solo mostrar el texto
              const html = `
                  <div class="custom-option">
                      <span class="item-name">${data.text}</span> 
                      <span class="item-type">${data.tipo}</span>  <!-- Mostrar tipo adicional -->
                  </div>`;
              return $(html);  // Devolver el HTML personalizado
          }*/
      });
    }

    ////// EVENTO AL SELECT ARTICULOS O ITEMS PARA SELECCIONAR EL ITEM Y AÑADIR AL CARRITO ////// 
    $("#articulo").on('change', (e)=>{
        let datos = ($('#articulo') as any).select2('data')[0];
        if(datos){
          let cantidad = 1, itemselected = carrito.find(x=>x.fk_producto==datos.id);
          if(itemselected != undefined)cantidad += itemselected.cantidad;
          actualizarCarrito(datos.id, cantidad, true);
        }
    });

    function actualizarCarrito(id:string, cantidad:number = 1, stateinput:boolean){
      const index = carrito.findIndex(x=>x.fk_producto==id);
      if(index == -1){  //si el item seleccionado no existe en el carrito, agregarlo.
          const itemselected = filteredData.find(x=>x.id==id)!; //products es el arreglo de todos los productos traido por api
          
          const productototal = Number(itemselected.precio_venta)*cantidad;
          const productovalorimp = productototal*constImp[itemselected.impuesto??'0']; //si producto.impuesto es null toma el valor de cero
          
          const item:{id: string, fk_producto: string, tipoproducto: string, tipoproduccion:string, foto:string, costo:number, valorunidad:string, nombreproducto: string, rendimientoestandar:string, unidad: string, cantidad: number, factor: number, precio_venta: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total: number, precio_compra:number} = {
              id: '',
              fk_producto: itemselected?.id!,
              tipoproducto: itemselected.tipo,  ////tipo = 0 es producto simple,  1 = subproducto
              tipoproduccion: itemselected.tipoproduccion,
              foto: '',
              costo: 0,
              valorunidad: itemselected.precio_venta,
              nombreproducto: itemselected.text,
              rendimientoestandar: '1',
              unidad: itemselected.unidadmedida,
              cantidad: 1,
              factor: 1,
              impuesto: itemselected.impuesto,
              precio_venta: productototal,
              subtotal: productototal,
              base: productototal-productovalorimp,
              valorimp: productovalorimp,
              descuento: 0,
              total: Number(itemselected.precio_venta),
              precio_compra: 0,
          }
          carrito = [...carrito, item];
          printItemTable(id);
      }else{  //si ya existe en el carrito, sumar
        if(cantidad <= 0){
          cantidad = 0;
          carrito[index].total = 0;
          //carrito = carrito.filter(x=>x.iditem != id);
        }
        
        carrito[index].cantidad = cantidad;
        /*const total:number = carrito[index].cantidad*carrito[index].precio_venta;
        carrito[index].subtotal = total;
        carrito[index].total = total;*/
        carrito[index].subtotal = (carrito[index].precio_venta)*carrito[index].cantidad;
        carrito[index].total = carrito[index].subtotal;
        //calculo del impuesto y base por producto en el carrito deventas
        carrito[index].valorimp = parseFloat((carrito[index].total*constImp[carrito[index].impuesto??0]).toFixed(3));
        carrito[index].base = parseFloat((carrito[index].total-carrito[index].valorimp).toFixed(3));

        if(stateinput)
          (tablaSeparado?.querySelector(`TR[data-id="${id}"] .inputcantidad`) as HTMLInputElement).value = carrito[index].cantidad+'';
        (tablaSeparado?.querySelector(`TR[data-id="${id}"]`)?.children?.[3] as HTMLElement).textContent = "$"+carrito[index].total.toLocaleString();
        valorCarritoTotal();
      }
      //console.log(carrito);
      /*if(cantidad<1){
          carrito = carrito.filter(x=>x.iditem != id);
      }*/
    }

    function printItemTable(id:string){
        const uncarrito = carrito.find(x=>x.fk_producto==id)!;
        let options:string = '';

        const productounidades = allConversionUnidades.filter(x => x.idproducto === id); 
        productounidades.forEach(u=>options+=`<option data-factor="${u.factorconversion}" value="${u.idproducto}" >${u.nombreunidaddestino}</option>`);

        const tr = document.createElement('TR');
        tr.classList.add('productselect');
        tr.dataset.id = `${id}`;
        //tr.dataset.tipo = `${item.tipo}`;
        tr.insertAdjacentHTML('afterbegin', `
          <td class="!p-2 !py-0 text-xl text-gray-500 leading-5">${uncarrito.nombreproducto}</td> 
          <td class="!p-2 !py-0 text-xl text-gray-500 leading-5"><select class="formulario__select selectunidad">${options}</select></td>
          <td class="!p-2 !py-0"><div class="flex"><button type="button"><span class="menos material-symbols-outlined">remove</span></button><input type="text" class="inputcantidad w-20 px-2 text-center" name="inputcantidad" value="${uncarrito.cantidad}"><button type="button"><span class="mas material-symbols-outlined">add</span></button></div></td>
          <td class="!p-2 !py-0 text-xl text-gray-500 leading-5">${uncarrito.precio_venta*uncarrito.cantidad}</td>
          <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarProducto"><i class="fa-solid fa-trash-can"></i></button></div></td>`);
        tablaSeparado?.appendChild(tr);
        valorCarritoTotal();
    }

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
      //console.log(valorTotal);
      //console.log(factimpuestos);
      document.querySelector('#subTotal')!.textContent = '$'+valorTotal.subtotal.toLocaleString();
      (document.querySelector('#impuesto') as HTMLElement).textContent = '$'+valorTotalImp.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
      document.querySelector('#total')!.textContent = '$ '+valorTotal.total.toLocaleString();
      (document.querySelector('#montocuota') as HTMLInputElement).value = valorTotal.total+'';
      //valorTotal.total = Number((document.querySelector('#abonoinicial') as HTMLInputElement).value);
      //POS.gestionSubirModalPagar.valoresCredito
      POS.valorTotal = valorTotal;
      POS.mapMediospago = mapMediospago;
      //**** recalcular valores del credito
      POS.gestionSubirModalPagar.calculoTasaInteres();
    }


    //////////////////  TABLA //////////////////////
    tablaSeparado?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.productselect');
      const idProduct = (elementProduct as HTMLElement).dataset.id!;
      //const precio = (elementProduct as HTMLElement).dataset.precio!;
      const productoCarrito = carrito.find(x=>x.fk_producto==idProduct);
      if((e.target as HTMLElement).classList.contains('menos')){
        actualizarCarrito(idProduct, productoCarrito!.cantidad-1, true);
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
            actualizarCarrito(idProduct, Number((e.target as HTMLInputElement).value), false);
          });
          (e.target as HTMLElement).dataset.event = "eventInput"; //se marca al input que ya tiene evento añadido
        }
      }

      if((e.target as HTMLElement).classList.contains('mas')){
        actualizarCarrito(idProduct, productoCarrito!.cantidad+1, true);
      }
      
      if((e.target as HTMLElement).classList.contains('eliminarProducto') || (e.target as HTMLElement).tagName == "I"){
        carrito = carrito.filter(x=>x.fk_producto != idProduct);
        valorCarritoTotal();
        tablaSeparado?.querySelector(`TR[data-id="${idProduct}"]`)?.remove();
      }
    });


    //btn para abrir modal de pago
    btnCrearSeparado?.addEventListener('click', (e)=>{
      e.preventDefault();
      if((document.querySelector('#cliente') as HTMLSelectElement).value === ''){
        msjAlert('error', 'Debe seleccionar el cliente.', (document.querySelector('#divmsjalerta') as HTMLElement));
        return;
      }
      if(carrito.length){
        document.querySelector('.Efectivo')?.removeAttribute('readonly');
        document.querySelector('#inputscreditos')?.remove();  //elimina los inputs de credito en el modal de procesar pago.
        document.querySelector('#abonoTotal')?.classList.remove('hidden');
        tipoventa = "Credito";
        //mapMediospago.clear();
        POS.tipoventa = tipoventa;
        //POS.valorTotal = valorTotal;
        //POS.mapMediospago = mapMediospago;
        POS.gestionSubirModalPagar.subirModalPagar();
        miDialogoFacturar.showModal();
      }
    });


    document.querySelector('#formfacturar')?.addEventListener('submit', e=>{
      e.preventDefault();
      if(valorTotal.total <= 0 || valorTotal.subtotal <= 0){
        msjAlert('error', 'No se puede procesar pago con $0', (document.querySelector('#divmsjalertaprocesarpago') as HTMLElement));
        return;
      }
      //calcular si el totoal de los medios de pago es menor al abono inicial, abortar pago...
      let totalMediosPago:number = 0;
      for(let value of mapMediospago.values())totalMediosPago+=value;
      if(totalMediosPago<POS.gestionSubirModalPagar.valoresCredito.abonoinicial){
        msjAlert('error', 'Valor a pagar no corresponde', (document.querySelector('#divmsjalertaprocesarpago') as HTMLElement));
        return;
      }

      btnPagar.disabled = true;
      btnPagar.value = 'Procesando...';
      procesarSeparado();
    });


    async function procesarSeparado(){
      const imprimir = document.querySelector('input[name="imprimir"]:checked') as HTMLInputElement;
      const valoresCredito = POS.gestionSubirModalPagar.valoresCredito;
      valoresCredito.cliente_id = (document.querySelector('#cliente') as HTMLSelectElement).value;
      valoresCredito.valorpagado = valoresCredito.abonoinicial;
      valoresCredito.cajaid = btnCaja.value;
      const datos = new FormData();
      datos.append('cliente_id', $('#cliente').val()as string);
      datos.append('abonoinicial', $('#abonoinicial').val()as string);
      datos.append('cantidadcuotas', $('#cantidadcuotas').val()as string);
      datos.append('montocuota', $('#montocuota').val()as string);
      datos.append('frecuenciapago', $('#frecuenciapago').val()as string);
      datos.append('carrito', JSON.stringify(carrito.filter(x=>x.cantidad>0)));  //envio de todos los productos con sus cantidades
      datos.append('mediospago', JSON.stringify(Array.from(mapMediospago, ([mediopago_id, valor])=>({mediopago_id, idcuota:0, valor}))));
      datos.append('valorefectivo', mapMediospago.get(1)??'0');
      datos.append('factimpuestos', JSON.stringify(factimpuestos));
      datos.append('valoresCredito', JSON.stringify(valoresCredito));
      try {
          const url = "/admin/api/crearSeparado";  //va al controlador ventascontrolador
          const respuesta = await fetch(url, {method: 'POST', body: datos}); 
          const resultado = await respuesta.json();
          if(resultado.exito !== undefined){
            msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            /////// reinciar modulo de ventas
            //vaciarventa();
            btnPagar.disabled = false;
            btnPagar.value = 'Pagar';
            miDialogoFacturar.close();
            setTimeout(() => { window.location.href = "/admin/creditos"; }, 800);
            //if(resultado.idfactura && imprimir.value === '1')printTicketPOS(resultado.idfactura);
          }else{
            msjalertToast('error', '¡Error!', resultado.error[0]);
          }
      } catch (error) {
          console.log(error);
      }
    }

    function printTicketPOS(idfactura:string){
      setTimeout(() => {
        window.open("/admin/printPDFPOS?id=" + idfactura, "_blank");
      }, 1200);
    }

    function cerrarDialogoExterno(event:Event) {
      const f = event.target;
      if (f === miDialogoFacturar || (f as HTMLInputElement).value === 'salir' || (f as HTMLInputElement).value === 'Cancelar') {
        miDialogoFacturar.close();
      }
    }


  }

})();