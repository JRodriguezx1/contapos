(()=>{
    if(document.querySelector('.adicionarProducto')){
        // EDITAR LOS PRODUCTOS A TRASLADOR A OTRA SEDE
        const btnAddItem = document.querySelector('#btnAddItem') as HTMLButtonElement;
        const tablaItems = document.querySelector('#tablaItems tbody');
        const btnUpdateCreditoSeparado = document.querySelector('#btnUpdateCreditoSeparado') as HTMLButtonElement;

        interface i_itemDetalle {
            id:string, //id del registro de la tabla productosseparados
            idcredito:string,
            fk_producto: string,
            idproducto?:string,
            idunidadmedida:string,
            tipoproducto:string,
            tipoproduccion:string,
            rendimientoestandar?:string,
            factor?:number,
            nombreproducto:string,
            unidadmedida:string,
            preciopersonalizado:string,
            sku:string,
            stockminimo?:string,
            costo:number,
            valorunidad:number,
            descuento:string,  //se calcula para productos nuevos agregados
            cantidad:number,   //se calcula para productos nuevos agregados
            base:number,       //se calcula para productos nuevos agregados
            impuesto:string,
            valorimp:number,   //se calcula para productos nuevos agregados
            subtotal:number,   //se calcula para productos nuevos agregados
            total:number,      //se calcula para productos nuevos agregados
        }

        interface i_allProducts {
            id:string,  //id del producto
            idunidadmedida:string, 
            nombre:string,
            impuesto:string,
            tipoproducto:string, 
            tipoproduccion:string, 
            sku:string, 
            unidadmedida:string, 
            preciopersonalizado:string,
            rendimientoestandar:string, 
            stockminimo:string,
            precio_compra:number,
            precio_venta:number
            habilitarventa:string, 
            visible:string,
        }

        let carrito:i_itemDetalle[]=[];
        let allproducts:i_allProducts[] = [];
        let filteredData: {id:string, text:string, tipo:string, tipoproducto:string, tipoproduccion:string, sku:string, unidadmedida:string}[];   //tipoproducto = 0 es producto simple,  1 = compuesto,  si no viene es subproducto, tipo=0 es producto(simple o compuesto), tipo=1 es subproducto

        const constImp: {[key:string]: number} = {};
        constImp['excluido'] = 0;
        constImp['0'] = 0;  //exento de iva, tarifa 0%
        constImp['5'] = 0.0476190476190476; //iva, tarifa al 5%,  Bienes/servicios al 5
        constImp['8'] = 0.0740740740740741; //inc, tarifa al 8%,  impuesto nacional al consumo
        constImp['16'] = 0.1379310344827586; //iva, tarifa al 16%,  contratos firmados con el estado antes de ley 1819
        constImp['19'] = 0.1596638655462185; //iva, tarifa al 19%,  tarifa general

        (async ()=>{
            try {
                const url = "/admin/api/allproducts"; //llamado a la API REST en el controlador almacencontrolador para treaer todas los productos simples y compuestos
                const respuesta = await fetch(url);
                const resultado:i_allProducts[] = await respuesta.json();
                console.log(resultado);
                filteredData = resultado.filter(x=>x.habilitarventa=='1'&&x.visible=='1').map(item => ({ id: item.id, text: item.nombre, tipo:item.tipoproducto??'1', tipoproducto: item.tipoproducto, tipoproduccion: item.tipoproduccion, sku: item.sku, unidadmedida: item.unidadmedida }));
                activarselect2();
                allproducts = resultado.filter(x=>x.habilitarventa=='1'&&x.visible=='1');
            } catch (error) {
                console.log(error);
            }
        })();
        
        const parametrosURL = new URLSearchParams(window.location.search);
        const idcreditoURL = parametrosURL.get('id');
        if(idcreditoURL!=null && /^\d+$/.test(idcreditoURL) && Number(idcreditoURL) >= 1){
            (async ()=>{
                try {
                    const url = "/admin/api/detalleProductosCredito?id="+idcreditoURL; //llamado a la API REST y trae el detalle de los productos de credito/separado
                    const respuesta = await fetch(url); 
                    const resultado:i_itemDetalle[] = await respuesta.json();
                    console.log(resultado);
                    carrito = resultado.map(item =>{
                        
                        return {
                            id: item.id,
                            idcredito: item.idcredito,
                            fk_producto: item.idproducto!,
                            idproducto:item.idproducto,
                            idunidadmedida: item.idunidadmedida,
                            tipoproducto: item.tipoproducto, 
                            tipoproduccion: item.tipoproduccion,
                            rendimientoestandar: item.rendimientoestandar,
                            nombreproducto: item.nombreproducto, 
                            unidadmedida: item.unidadmedida,
                            preciopersonalizado: item.preciopersonalizado,
                            sku: item.sku,
                            costo: item.costo,
                            valorunidad: item.valorunidad,
                            descuento: item.descuento,
                            cantidad: item.cantidad,
                            base: item.base,
                            impuesto: item.impuesto,
                            valorimp: item.valorimp,
                            subtotal: item.subtotal,
                            total: item.total,
                            factor: 1
                        }
                    });
                    carrito.forEach(c =>printItemTable(c.fk_producto, c.unidadmedida, c.cantidad, c.nombreproducto));
                } catch (error) {
                    console.log(error);
                }
            })();
        }
        
        

        function activarselect2(){
            ($('#articulo') as any).select2({ 
                width: '100%',
                data: filteredData,
                placeholder: "Selecciona un item",
                maximumSelectionLength: 1,
            });  
        }

        $("#articulo").on('change', (e)=>{
            let datos = ($('#articulo') as any).select2('data')[0];
            if(datos)(document.querySelector('#unidadmedida') as HTMLInputElement).value = datos.unidadmedida;
        });

        btnAddItem.addEventListener('click', (e)=>{
            let cantidad = parseFloat((document.querySelector('#cantidad') as HTMLInputElement).value);
            let datos = ($('#articulo') as any).select2('data')[0];
            console.log(datos);
            if(datos){
                const index = carrito.findIndex(x=>x.idproducto==datos.id);
                if(index == -1){  //si el item seleccionado no existe en el carrito, agregarlo.
                    //const itemselected = filteredData.find(x=>x.id==datos.id&&x.tipo==datos.tipo)!;
                    const productSelected = allproducts.find(x=>x.id==datos.id)!;

                    const productototal = Number(productSelected.precio_venta)*cantidad;
                    const productovalorimp = productototal*constImp[productSelected.impuesto??'0']; //si producto.impuesto es null toma el valor de cero

                    const item:i_itemDetalle = {
                        id: '',
                        idcredito: idcreditoURL!,
                        fk_producto: productSelected.id, 
                        idproducto:productSelected.id,
                        idunidadmedida: productSelected.idunidadmedida,
                        //tipo: itemselected.tipo,  ////tipo = 0 es producto (simple o compuesto produccion),  1 = subproducto
                        tipoproducto: productSelected.tipoproducto, 
                        tipoproduccion: productSelected.tipoproduccion,
                        rendimientoestandar: productSelected.rendimientoestandar,
                        nombreproducto: productSelected.nombre, 
                        unidadmedida: productSelected.unidadmedida,
                        preciopersonalizado: productSelected.preciopersonalizado,
                        sku: productSelected.sku,
                        costo: productSelected.precio_compra,
                        valorunidad: productSelected.precio_venta,
                        descuento: '0',
                        cantidad: cantidad,
                        base: 0,
                        impuesto: productSelected.impuesto,
                        valorimp: 0,
                        subtotal: 0,
                        total: productototal,
                        factor: 1,
                    }
                    carrito = [...carrito, item];
                    printItemTable(productSelected.id, productSelected.unidadmedida, cantidad, productSelected.nombre);
                }else{
                    carrito[index].cantidad = cantidad;
                    //calcular valores
                    const tr = document.querySelector(`[data-id="${carrito[index].fk_producto}"]`)!;
                    tr.children[1].textContent = carrito[index].cantidad+'';
                }
            }
        });

        function printItemTable(id:string, unidadmedida:string, cantidad:number, nombre:string){
            //let options = `<option data-factor="1" value="" >${unidadmedida}</option>`;
            /*
            options = "";
            const productounidades = allConversionUnidades.filter(x => x.idproducto == id); 
            productounidades.forEach(u=>options+=`<option data-factor="${u.factorconversion}" value="${u.idproducto}" >${u.nombreunidaddestino}</option>`);
            */
            const tr = document.createElement('TR');
            tr.classList.add('itemselect');
            tr.dataset.id = `${id}`;
            tr.insertAdjacentHTML('afterbegin', 
                `<td class="p-4">${nombre}</td>
                <td class="p-4">${cantidad}</td>
                <td class="p-4">${unidadmedida}</td>
                <td class="p-4 flex items-center justify-center gap-2">
                    <button class="flex items-center gap-1 px-3 py-1 text-base text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                        👁 Ver
                    </button>
                    <button class="eliminarItem w-11 h-11 flex items-center justify-center text-rose-600 border border-rose-200 rounded-full hover:bg-rose-50 text-xl">❌</button>
                </td>`);
            tablaItems?.appendChild(tr);
        }



        //////////////////////////////////// evento a la tabla de los productos seleccionados  ///////////////////////////////////
        tablaItems?.addEventListener('click', (e:Event)=>{
            const elementItem = (e.target as HTMLElement)?.closest('.itemselect'); //seleccionamos el tr de la tabla
            const iditem = (elementItem as HTMLElement).dataset.id!;
            //const tipoitem = (elementItem as HTMLElement).dataset.tipo!;
        
            if((e.target as HTMLElement).classList.contains('eliminarItem')){ //se trae todoscon true menos el que coincida con iditem y tipoitem
                carrito = carrito.filter(x => x.fk_producto!==iditem);
                tablaItems?.querySelector(`TR[data-id="${iditem}"]`)?.remove();
            }
            //itemCarrito.cantidad = itemCarrito.cantidadcomprado*itemCarrito.factor;
        });


        btnUpdateCreditoSeparado.addEventListener('click', ()=>{
            Swal.fire({
                customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
                icon: 'question',
                title: 'Esta seguro de actualizar la orden?',
                text: "Se procesara la orden con todos los productos del separado",
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result:any) => {
                if (result.isConfirmed) {
                    (async ()=>{ 
                        const datos = new FormData();
                        datos.append('idcredito', idcreditoURL!);
                        datos.append('ids', JSON.stringify(carrito.map(x=>x.id)));
                        datos.append('nuevosproductos', JSON.stringify(carrito));
                        try {
                            const url = "/admin/api/editarOrdenCreditoSeparado";  //api llamada a trasladosinvcontrolador
                            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                            const resultado = await respuesta.json();  
                            if(resultado.exito !== undefined){
                                /*setTimeout(() => {
                                    window.location.href = `/admin/almacen/trasladarinventario`;
                                }, 1600);*/
                                Swal.fire(resultado.exito[0], '', 'success') 
                            }else{
                                Swal.fire(resultado.error[0], '', 'error')
                            }
                        } catch (error) {
                            console.log(error);
                        }
                    })();//cierre de async()
                }
            });
        });

    }
})();