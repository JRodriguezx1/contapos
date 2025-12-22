(()=>{
  if(document.querySelector('.creditos')){

    //const POS = (window as any).POS;
     
    const btnCrearCredito = document.querySelector('#btnCrearCredito') as HTMLButtonElement;
    const btnXCerrarModalCredito = document.querySelector('#btnXCerrarModalCredito') as HTMLButtonElement;
    const miDialogoCredito = document.querySelector('#miDialogoCredito') as any;
    const tablaSeparado = document.querySelector('#tablaSeparado tbody');

    type creditsapi = {
      id:string,
      id_fksucursal: string,
      factura_id: string,
      cliente_id: string,
      nombrecliente: string,
      capital: string,
      abonoinicial: string,
      saldopendiente: string,
      numcuota: string,
      cantidadcuotas: string,
      montocuota: string,
      frecuenciapago: string,
      fechainicio: string,
      interes: string,
      interesxcuota: string,
      interestotal: string,
      valorinteresxcuota: string,
      valorinterestotal: string,
      montototal: string,
      fechavencimiento: string,
      productoentregado: string,
      estado: string,
      created_at: string,
    };
    
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

    let credits:creditsapi[]=[], uncredito:creditsapi;
    let indiceFila=0, control=0, tablaCreditos:HTMLElement;
    let allConversionUnidades:conversionunidadesapi[] = [];
    let filteredData: {id:string, text:string, tipo:string, impuesto:string, sku:string, unidadmedida:string, precio_venta:string}[];   //tipo = 0 es producto simple,  1 = subproducto
    let carrito:{iditem:string,  tipo: string, nombreitem:string, unidad:string, cantidad: number, factor: number, precio_venta: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total: number, precio_compra: number}[]=[];
    const valorTotal = {subtotal: 0, base: 0, valorimpuestototal: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
    let factimpuestos:Item[] = [];
    
    const constImp: {[key:string]: number} = {};
    constImp['excluido'] = 0;
    constImp['0'] = 0;  //exento de iva, tarifa 0%
    constImp['5'] = 0.0476190476190476; //iva, tarifa al 5%,  Bienes/servicios al 5
    constImp['8'] = 0.0740740740740741; //inc, tarifa al 8%,  impuesto nacional al consumo
    constImp['16'] = 0.1379310344827586; //iva, tarifa al 16%,  contratos firmados con el estado antes de ley 1819
    constImp['19'] = 0.1596638655462185; //iva, tarifa al 19%,  tarifa general


    (async ()=>{
      try {
          const url = "/admin/api/allcredits"; //llamado a la API REST y se trae todos los productos
          const respuesta = await fetch(url); 
          credits = await respuesta.json(); 
          console.log(credits);
      } catch (error) {
          console.log(error);
      }
    })();

    (async ()=>{
        try {
            const url = "/admin/api/allproducts"; //llamado a la API REST en el controlador almacencontrolador para treaer todas los productos simples y subproductos
            const respuesta = await fetch(url); 
            const resultado:{id:string, nombre:string, tipoproducto:string, impuesto:string, sku:string, unidadmedida:string, precio_venta:string}[] = await respuesta.json(); 
            filteredData = resultado.map(item => ({ id: item.id, text: item.nombre, tipo: item.tipoproducto??'1', impuesto: item.impuesto, sku: item.sku, unidadmedida: item.unidadmedida, precio_venta: item.precio_venta }));
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
          dropdownParent: $('#miDialogoCredito'),
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
            const index = carrito.findIndex(x=>x.iditem==datos.id);
            if(index == -1){  //si el item seleccionado no existe en el carrito, agregarlo.
                const itemselected = filteredData.find(x=>x.id==datos.id)!; //products es el arreglo de todos los productos traido por api
                
                const productovalorimp = (Number(itemselected.precio_venta)*1)*constImp[itemselected.impuesto??'0']; //si producto.impuesto es null toma el valor de cero
                const productototal = Number(itemselected.precio_venta)*1;
                
                const item:{iditem: string, tipo: string, nombreitem: string, unidad: string, cantidad: number, factor: number, precio_venta: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total: number, precio_compra:number} = {
                    iditem: itemselected?.id!,
                    tipo: itemselected.tipo,  ////tipo = 0 es producto simple,  1 = subproducto
                    nombreitem: itemselected.text,
                    unidad: itemselected.unidadmedida,
                    cantidad: 1,
                    factor: 1,
                    impuesto: itemselected.impuesto,
                    precio_venta: Number(itemselected.precio_venta),
                    subtotal: Number(itemselected.precio_venta),
                    base: productototal-productovalorimp,
                    valorimp: productovalorimp,
                    descuento: 0,
                    total: Number(itemselected.precio_venta),
                    precio_compra: 0,
                }
                carrito = [...carrito, item];
            }else{
              carrito[index].cantidad++;
              /*const total:number = carrito[index].cantidad*carrito[index].precio_venta;
              carrito[index].subtotal = total;
              carrito[index].total = total;*/
              carrito[index].subtotal = (carrito[index].precio_venta)*carrito[index].cantidad;
              carrito[index].total = carrito[index].subtotal;
              //calculo del impuesto y base por producto en el carrito deventas
              carrito[index].valorimp = parseFloat((carrito[index].total*constImp[carrito[index].impuesto??0]).toFixed(3));
              carrito[index].base = parseFloat((carrito[index].total-carrito[index].valorimp).toFixed(3));
            }
            console.log(carrito);
            printItemTable();
        }
    });

    function printItemTable(){
        let options:string;
        while(tablaSeparado?.firstChild)tablaSeparado.removeChild(tablaSeparado.firstChild);

        carrito.forEach(item =>{
          options = '';
          const productounidades = allConversionUnidades.filter(x => x.idproducto === item.iditem); 
          productounidades.forEach(u=>options+=`<option data-factor="${u.factorconversion}" value="${u.idproducto}" >${u.nombreunidaddestino}</option>`);

          const tr = document.createElement('TR');
          tr.classList.add('itemselect');
          tr.dataset.id = `${item.iditem}`;
          tr.dataset.tipo = `${item.tipo}`;
          tr.insertAdjacentHTML('afterbegin', `
            <td class="!py-2 text-xl text-gray-500 leading-5">${item.nombreitem}</td> 
            <td class="!p-2 text-xl text-gray-500 leading-5"><select class="formulario__select selectunidad">${options}</select></td>
            <td class="!py-2"><div class="flex"><button type="button"><span class="menos material-symbols-outlined">remove</span></button><input type="text" class="inputcantidad w-20 px-2 text-center" value="${item.cantidad}" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"><button type="button"><span class="mas material-symbols-outlined">add</span></button></div></td>
            <td class="!p-2 text-xl text-gray-500 leading-5">${item.precio_venta*item.cantidad}</td>
            <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarItem"><i class="fa-solid fa-trash-can"></i></button></div></td>`);
            tablaSeparado?.appendChild(tr);
        });
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
      console.log(valorTotal);
      console.log(factimpuestos);
      document.querySelector('#subTotal')!.textContent = '$'+valorTotal.subtotal.toLocaleString();
      (document.querySelector('#impuesto') as HTMLElement).textContent = '$'+valorTotalImp.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
      document.querySelector('#total')!.textContent = '$ '+valorTotal.total.toLocaleString();
    }


    //////////////////  TABLA //////////////////////
    tablaSeparado?.addEventListener('click', (e:Event)=>{
      const elementProduct = (e.target as HTMLElement)?.closest('.productselect');
      const idProduct = (elementProduct as HTMLElement).dataset.id!;
      const precio = (elementProduct as HTMLElement).dataset.precio!;
      const productoCarrito = carrito.find(x=>x.iditem==idProduct);
      if((e.target as HTMLElement).classList.contains('menos')){
        //actualizarCarrito(idProduct, productoCarrito!.cantidad-1, false, true, productoCarrito?.valorunidad);
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
            //actualizarCarrito(idProduct, Number((e.target as HTMLInputElement).value), false, false,  productoCarrito?.valorunidad);
          });
          (e.target as HTMLElement).dataset.event = "eventInput"; //se marca al input que ya tiene evento añadido
        }
      }
      if((e.target as HTMLElement).classList.contains('mas')){
        //actualizarCarrito(idProduct, productoCarrito!.cantidad+1, false, true, productoCarrito?.valorunidad);
      }
      if((e.target as HTMLElement).classList.contains('eliminarProducto') || (e.target as HTMLElement).tagName == "I"){
        carrito = carrito.filter(x=>x.iditem != idProduct);
        valorCarritoTotal();
        tablaSeparado?.querySelector(`TR[data-id="${idProduct}"][data-precio="${precio}"]`)?.remove();
      }
    });

    
    //////////////////  TABLA //////////////////////
    tablaCreditos = ($('#tablaCreditos') as any).DataTable(configdatatables);

    //btn para crear credito
    btnCrearCredito?.addEventListener('click', ():void=>{
      control = 0;
      miDialogoCredito.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
      ($('#cliente') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
      ($('#frecuenciapago') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
    });

    btnXCerrarModalCredito.addEventListener('click', (e)=>{
        miDialogoCredito.close();
        document.removeEventListener("click", cerrarDialogoExterno);
    });

    


    //evento a la tabla
    document.querySelector('#tablaCreditos')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("editarCredito")||(e.target as HTMLElement).parentElement?.classList.contains("editarCredito"))editarCredito(e);
      //if(target?.classList.contains("bloquearProductos")||target.parentElement?.classList.contains("bloquearProductos"))bloquearProductos(e);
      //if(target?.classList.contains("eliminarProductos")||target.parentElement?.classList.contains("eliminarProductos"))eliminarProductos(e);
    });

    function editarCredito(e:Event){
      let idcredito = (e.target as HTMLElement).parentElement?.id!;
      if((e.target as HTMLElement)?.tagName === 'I')idcredito = (e.target as HTMLElement).parentElement?.parentElement?.id!;
      control = 1;
      document.querySelector('#modalCredito')!.textContent = "Actualizar credito";
      (document.querySelector('#btnEditarCrearCredito') as HTMLInputElement)!.value = "Actualizar";
      uncredito = credits.find(x=>x.id === idcredito)!; //obtengo el producto.
      $('#cliente').val(uncredito?.cliente_id??'');
      (document.querySelector('#capital')as HTMLInputElement).value = uncredito?.capital!;
      $('#interes').val(uncredito?.interes??'0');  //0 = No,  1 = Si
      (document.querySelector('#cantidadcuotas')as HTMLInputElement).value = uncredito?.cantidadcuotas!;
      (document.querySelector('#montocuota')as HTMLInputElement).value = uncredito?.montocuota!;
      $('#frecuenciapago').val(uncredito?.frecuenciapago??'10');  //0 = simple,  1 = compuesto
      //indiceFila = (tablaProductos as any).row((e.target as HTMLElement).closest('tr')).index();
      miDialogoCredito.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
      ($('#cliente') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
      ($('#frecuenciapago') as any).select2({ dropdownParent: $('#miDialogoCredito'), placeholder: "Seleccionar el cliente", maximumSelectionLength: 1});
    }


    ////////////////////  Actualizar/Editar CREDITO  //////////////////////
    document.querySelector('#formCrearUpdateCredito')?.addEventListener('submit', e=>{

      if(control){
        e.preventDefault();
        var info = (tablaCreditos as any).page.info();
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', uncredito!.id);
          datos.append('cliente_id', $('#cliente').val()as string);
          //datos.append('nombre', $('#nombre').val()as string);
          datos.append('capital', $('#capital').val()as string); 
          datos.append('interes', $('#interes').val()as string);
          datos.append('cantidadcuotas', $('#cantidadcuotas').val()as string);
          datos.append('montocuota', $('#montocuota').val()as string);
          datos.append('frecuenciapago', $('#frecuenciapago').val()as string);
          datos.append('tasainteres', '0');
          try {
              const url = "/admin/api/actualizarCredito";
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json(); 
              console.log(resultado); 
              if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                /// actualizar el arregle de creditos ///
                credits.forEach(a=>{if(a.id == uncredito.id)a = Object.assign(a, resultado.credito[0]);});
                ///////// cambiar la fila completa, su contenido //////////
                const datosActuales = (tablaCreditos as any).row(indiceFila).data();
                
                /*CLIENTE*/datosActuales[2] ='<div class="w-80 whitespace-normal">'+$('#nombre').val()+'</div>';
                /*capital*/datosActuales[3] = $('#categoria option:selected').text();
                /*DEUDA*/datosActuales[4] = '';
                /*ABONOTOTAL*/datosActuales[5] = $('#sku').val();
                
                (tablaCreditos as any).row(indiceFila).data(datosActuales).draw();
                (tablaCreditos as any).page(info.page).draw('page'); //me mantiene la pagina actual
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
              miDialogoCredito.close();
              document.removeEventListener("click", cerrarDialogoExterno);
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
      } //fin if(control)
    });



    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoCredito || (event.target as HTMLInputElement).value === 'salir' || (event.target as HTMLInputElement).value === 'Cancelar') {
        miDialogoCredito.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }


  }

})();