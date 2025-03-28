
(()=>{
    if(document.querySelector('.compras')){
        const proveedor = document.querySelector('#proveedor') as HTMLSelectElement;
        const impuesto = document.querySelector('#inputimpuesto') as HTMLInputElement;
        const nfactura = document.querySelector('#nfactura') as HTMLInputElement;
        const fecha = document.querySelector('#fecha') as HTMLDataElement;
        const origenPago = document.querySelector('#origenPago') as HTMLSelectElement;
        const formapago = document.querySelector('#formapago') as HTMLSelectElement;
        const observacion = document.querySelector('#observacion') as HTMLInputElement;
        const btnvaciar = document.querySelector('#btnvaciar');
        const miDialogoVaciar = document.querySelector('#miDialogoVaciar') as any;
        const miDialogoRegistrarcompra = document.querySelector('#miDialogoRegistrarcompra') as any;
        const tablaCompras = document.querySelector('#tablaCompras tbody');

        type conversionunidadesapi = {
            id:string,
            idsubproducto: string,
            idunidadmedidabase: string,
            idunidadmedidadestino: string,
            nombreunidadbase: string,
            nombreunidaddestino: string,
            factorconversion: string,
            //idservicios:{idempleado:string, idservicio:string}[]
          };

        let carrito:{iditem:string, idpx:string, idsx:string, tipo: string, nombreitem:string, unidad:string, cantidad: number, cantidadcomprado: number, factor: number, impuesto: number, valorunidad: number, subtotal: number, precio_compra: number, valorcompra: number}[]=[];
        let allConversionUnidades:conversionunidadesapi[] = [];
        let filteredData: {id:string, text:string, tipo:string, sku:string, unidadmedida:string}[];   //tipo = 0 es producto simple,  1 = subproducto


        (async ()=>{
            try {
                const url = "/admin/api/allConversionesUnidades"; //llamado a la API REST en el controlador almacencontrolador para treaer todas las conversiones de unidades
                const respuesta = await fetch(url); 
                allConversionUnidades = await respuesta.json();
                console.log(allConversionUnidades);
            } catch (error) {
                console.log(error);
            }
        })();

        (async ()=>{
            try {
                const url = "/admin/api/totalitems"; //llamado a la API REST en el controlador almacencontrolador para treaer todas los productos simples y subproductos
                const respuesta = await fetch(url); 
                const resultado:{id:string, nombre:string, tipoproducto:string, sku:string, unidadmedida:string}[] = await respuesta.json(); 
                filteredData = resultado.map(item => ({ id: item.id, text: item.nombre, tipo: item.tipoproducto??'1', sku: item.sku, unidadmedida: item.unidadmedida }));
                activarselect2(filteredData);
            } catch (error) {
                console.log(error);
            }
        })();


        impuesto.addEventListener('input', ()=>resumen());

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
                const index = carrito.findIndex(x=>x.iditem==datos.id&&x.tipo==datos.tipo);
                if(index == -1){  //si el item seleccionado no existe en el carrito, agregarlo.
                    const itemselected = filteredData.find(x=>x.id==datos.id&&x.tipo==datos.tipo)!; //products es el arreglo de todos los productos traido por api
                    const item:{iditem: string, idpx: string, idsx: string, tipo: string, nombreitem: string, unidad: string, cantidad: number, cantidadcomprado: number, factor: number, impuesto: number, valorunidad: number, subtotal: number, precio_compra:number, valorcompra: number} = {
                        iditem: itemselected?.id!,
                        idpx: itemselected.tipo=='0'?itemselected.id:'NULL',
                        idsx: itemselected.tipo=='1'?itemselected.id:'NULL',
                        tipo: itemselected.tipo,  ////tipo = 0 es producto simple,  1 = subproducto
                        nombreitem: itemselected.text,
                        unidad: itemselected.unidadmedida,
                        cantidad: 1,
                        cantidadcomprado: 1,
                        factor: 1,
                        impuesto: 0,
                        valorunidad: 0,
                        subtotal: 0,
                        precio_compra: 0,
                        valorcompra: 0,
                    }
                    carrito = [...carrito, item];
                    printItemTable(datos.id, datos.tipo, datos.unidadmedida);
                }
            }
        });


        function printItemTable(id:string, tipo:string, unidadmedida:string){
            let options = `<option data-factor="1" value="" >${unidadmedida}</option>`;
            const unItem = filteredData.find(x=>x.id==id&&x.tipo==tipo)!;
            if(tipo=='1'){   //si es un subproducto
                options = "";
                const subproductounidades = allConversionUnidades.filter(x => x.idsubproducto == id); 
                subproductounidades.forEach(u=>options+=`<option data-factor="${u.factorconversion}" value="${u.idsubproducto}" >${u.nombreunidaddestino}</option>`);
            }
            const tr = document.createElement('TR');
            tr.classList.add('itemselect');
            tr.dataset.id = `${id}`;
            tr.dataset.tipo = `${tipo}`;
            tr.insertAdjacentHTML('afterbegin', `<td class="!px-0 !py-2 text-xl text-gray-500 leading-5">${unItem?.text}</td> 
            <td class="!p-2 text-xl text-gray-500 leading-5">
                <select class="formulario__select selectunidad">
                    ${options}
                </select>
            </td>
            <td class="!px-0 !py-2"><div class="flex"><button type="button"><span class="menos material-symbols-outlined">remove</span></button><input type="text" class="inputcantidad w-20 px-2 text-center" value="1" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||1)"><button type="button"><span class="mas material-symbols-outlined">add</span></button></div></td>
            <td class="!p-2 text-xl text-gray-500 leading-5"><input type="text" class="inputcompra w-32 px-2 text-center" value="" oninput="this.value = parseInt(this.value.replace(/[,.]/g, '')||0)"></td>
            <td class="accionestd"><div class="acciones-btns"><button class="btn-md btn-red eliminarItem"><i class="fa-solid fa-trash-can"></i></button></div></td>`);
            tablaCompras?.appendChild(tr);
        }
        

        //////////////////////////////////// evento a la tabla de los productos seleccionados  ///////////////////////////////////
        tablaCompras?.addEventListener('click', (e:Event)=>{
            const elementItem = (e.target as HTMLElement)?.closest('.itemselect'); //seleccionamos el tr de la tabla
            const iditem = (elementItem as HTMLElement).dataset.id!;
            const tipoitem = (elementItem as HTMLElement).dataset.tipo!;

            const itemCarrito = carrito.find(x=>x.iditem==iditem&&x.tipo==tipoitem)!;

            if((e.target as HTMLElement).classList.contains('selectunidad')){
                if((e.target as HTMLElement).dataset.event != "eventSelect"){
                    e.target?.addEventListener('change', (e:Event)=>{
                        const unit = e.target as HTMLSelectElement;
                        itemCarrito.factor = Number(unit.options[unit.selectedIndex].dataset.factor);
                    });
                    (e.target as HTMLElement).dataset.event = "eventSelect"; //se marca al input que ya tiene evento añadido
                }
            }
            
            if((e.target as HTMLElement).classList.contains('menos')){
                itemCarrito.cantidadcomprado--;
                if(itemCarrito.cantidadcomprado<0)itemCarrito.cantidadcomprado = 0;
            }

            if((e.target as HTMLElement).classList.contains('inputcantidad')){
                if((e.target as HTMLElement).dataset.event != "eventInput"){
                    e.target?.addEventListener('input', (e:Event)=>{
                        itemCarrito.cantidadcomprado = Number((e.target as HTMLInputElement).value);
                        itemCarrito.cantidad = itemCarrito.cantidadcomprado*itemCarrito.factor;
                    });
                    (e.target as HTMLElement).dataset.event = "eventInput"; //se marca al input que ya tiene evento añadido
                }
            }

            if((e.target as HTMLElement).classList.contains('mas'))itemCarrito.cantidadcomprado++;
            
            //////// INPUT CANTIDAD DE LA TABLA DE ITEMS DE COMPRA, SE ACTUALIZA CADA VEZ QUE SE DE CLICK EN MENOS O MAS
            (tablaCompras?.querySelector(`TR[data-id="${iditem}"][data-tipo="${tipoitem}"] .inputcantidad`) as HTMLInputElement).value = itemCarrito?.cantidadcomprado+'';

            /////// EVENTO AL INPUT VALOR DE COMPRA DE LA TABLA DE ITEMS DE COMPRA  ///////
            if((e.target as HTMLElement).classList.contains('inputcompra')){
                if((e.target as HTMLElement).dataset.event != "eventInput"){
                    e.target?.addEventListener('input', (e:Event)=>{
                        itemCarrito.valorcompra = Number((e.target as HTMLInputElement).value);
                        itemCarrito.precio_compra = itemCarrito.valorcompra/itemCarrito.cantidad;
                        resumen();
                    });
                    (e.target as HTMLElement).dataset.event = "eventInput"; //se marca al input que ya tiene evento añadido
                }
            }

            if((e.target as HTMLElement).classList.contains('eliminarItem') || (e.target as HTMLElement).tagName == "I"){
                carrito = carrito.filter(x=> {
                    if(x.iditem==iditem){
                        if(x.tipo==tipoitem){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return true;
                    }
                });
                tablaCompras?.querySelector(`TR[data-id="${iditem}"][data-tipo="${tipoitem}"]`)?.remove();
                resumen();
            }

            itemCarrito.cantidad = itemCarrito.cantidadcomprado*itemCarrito.factor;
        });


        btnvaciar?.addEventListener('click', ()=>{
            if(carrito.length){
              miDialogoVaciar.showModal();
              document.addEventListener("click", cerrarDialogoExterno);
            }
        });

        document.querySelector('#formComprar')?.addEventListener('submit', e=>{
            e.preventDefault();
            miDialogoRegistrarcompra.showModal();
            document.addEventListener("click", cerrarDialogoExterno);
        });

  
        async function procesarpedido(estado:string){
            const datos = new FormData();
            datos.append('idproveedor', proveedor.options[proveedor.selectedIndex].value);
            datos.append('idorigenpago', origenPago.options[origenPago.selectedIndex].value);
            datos.append('idformapago', formapago.options[formapago.selectedIndex].value);
            datos.append('nombreproveedor', proveedor.options[proveedor.selectedIndex].textContent!);
            datos.append('nombreorigenpago', origenPago.options[origenPago.selectedIndex].textContent+'');
            datos.append('formapago', formapago.options[formapago.selectedIndex].text);
            datos.append('nfactura', nfactura.value);
            datos.append('impuesto', impuesto.value);
            datos.append('cantidaditems', carrito.reduce((total, item)=>item.cantidad+total, 0)+'');
            datos.append('observacion', observacion.value);
            datos.append('estado', estado);
            datos.append('subtotal', carrito.reduce((total, item)=>item.valorcompra+total, 0)+'');
            datos.append('valortotal', carrito.reduce((total, item)=>item.valorcompra+total, 0)+'');
            datos.append('fechacompra', fecha.value);
            datos.append('carrito', JSON.stringify(carrito));  ////arreglo de objetos de producto simple y subproducto
            datos.append('subID', JSON.stringify(carrito.map(item=>{if(item.idsx){return item.idsx}}))); //envia solo los id de los subproductos
            try {
                const url = "/admin/api/registrarCompra";  //va al controlador ventascontrolador
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                /////// reinciar campos de la compra
                vaciarcompra();
                (document.querySelector('#formComprar') as HTMLFormElement)?.reset();
                }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
                }
            } catch (error) {
                console.log(error);
            }
        }

        function validarValorCompra():boolean{
            return carrito.some(item=>Number.isNaN(item.valorcompra)||item.valorcompra==0);
        }

        function resumen():void{
            document.querySelector('#impuesto')!.textContent = '% '+impuesto.value;
            document.querySelector('#total')!.textContent = '$ '+carrito.reduce((total, item)=>item.valorcompra+total, 0).toLocaleString()+'';
        
        }

        function vaciarcompra():void
        {
            carrito.length = 0;
            while(tablaCompras?.firstChild)tablaCompras.removeChild(tablaCompras?.firstChild);
            document.querySelector('#impuesto')!.textContent = '% 0';
            document.querySelector('#total')!.textContent = '$ 0';
        }

        function cerrarDialogoExterno(event:Event) {
            const f = event.target;
            if (f === miDialogoVaciar || f === miDialogoRegistrarcompra || (f as HTMLInputElement).closest('.novaciar') || (f as HTMLInputElement).closest('.sivaciar') || (f as HTMLInputElement).closest('.nocomprar') || (f as HTMLInputElement).closest('.sicomprar')) {
              miDialogoVaciar.close();
              miDialogoRegistrarcompra.close();
              document.removeEventListener("click", cerrarDialogoExterno);
              if((f as HTMLInputElement).closest('.sicomprar')){
                if(!validarValorCompra()){
                    procesarpedido('paga');
                }else{
                    msjalertToast('error', '¡Error!', 'Verifica el valor de compra de la lista de productos');
                }
              }
              if((f as HTMLInputElement).closest('.sivaciar'))vaciarcompra();
            }
        }
        
    }

})();