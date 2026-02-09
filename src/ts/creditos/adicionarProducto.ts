(()=>{
    if(document.querySelector('.adicionarProducto')){
        // EDITAR LOS PRODUCTOS A TRASLADOR A OTRA SEDE
        const btnAddItem = document.querySelector('#btnAddItem') as HTMLButtonElement;
        const tablaItems = document.querySelector('#tablaItems tbody');
        const btnUpdateCreditoSeparado = document.querySelector('#btnUpdateCreditoSeparado') as HTMLButtonElement;
        let carrito:{id: string, idcredito:string, fk_producto:string, iditem:string, nombreitem:string, unidadmedida:string, tipoproducto:string, tipoproduccion:string, cantidad: number, factor: number}[]=[];
        let filteredData: {id:string, text:string, tipo:string, tipoproducto:string, tipoproduccion:string, sku:string, unidadmedida:string}[];   //tipoproducto = 0 es producto simple,  1 = compuesto,  si no viene es subproducto, tipo=0 es producto(simple o compuesto), tipo=1 es subproducto

        interface i_itemDetalle {
            id:string,
            idcredito:string,
            idproducto:string,
            idunidadmedida:string,
            tipoproducto:string,
            tipoproduccion:string,
            nombre:string,
            unidadmedida:string,
            simbolo:string,
            preciopersonalizado:string,
            sku:string,
            stockminimo:string,
            costo:string,
            valorunidad:string,
            descuento:string,
            cantidad:number,
            base:string,
            impuesto:string,
            valorimp:string,
            subtotal:string,
            total:string,
        }

        (async ()=>{
            try {
                const url = "/admin/api/allproducts"; //llamado a la API REST en el controlador almacencontrolador para treaer todas los productos simples y compuestos
                const respuesta = await fetch(url); 
                const resultado:{id:string, habilitarventa:string, visible:string, nombre:string, tipoproducto:string, tipoproduccion:string, sku:string, unidadmedida:string}[] = await respuesta.json();
                console.log(resultado);
                filteredData = resultado.filter(x=>x.habilitarventa=='1'&&x.visible=='1').map(item => ({ id: item.id, text: item.nombre, tipo:item.tipoproducto??'1', tipoproducto: item.tipoproducto, tipoproduccion: item.tipoproduccion, sku: item.sku, unidadmedida: item.unidadmedida }));
                activarselect2();
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
                            fk_producto: item.idproducto,
                            iditem: item.idproducto,
                            tipoproducto: item.tipoproducto, 
                            tipoproduccion: item.tipoproduccion,
                            nombreitem: item.nombre, 
                            unidadmedida:item.unidadmedida, 
                            cantidad: item.cantidad, 
                            factor: 1
                        }
                    });
                    carrito.forEach(c =>printItemTable(c.iditem, c.unidadmedida, c.cantidad, c.nombreitem));
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
                const index = carrito.findIndex(x=>x.iditem==datos.id);
                if(index == -1){  //si el item seleccionado no existe en el carrito, agregarlo.
                    const itemselected = filteredData.find(x=>x.id==datos.id&&x.tipo==datos.tipo)!; 
                    const item:{id:string, idcredito:string, fk_producto:string, iditem: string, nombreitem: string, /*tipo: string,*/tipoproducto:string, tipoproduccion:string, unidadmedida: string, cantidad: number, factor: number} = {
                        id: '',
                        idcredito: idcreditoURL!,
                        fk_producto: itemselected.id, 
                        iditem: itemselected.id,
                        nombreitem: itemselected.text,
                        //tipo: itemselected.tipo,  ////tipo = 0 es producto (simple o compuesto produccion),  1 = subproducto
                        tipoproducto: itemselected.tipoproducto, 
                        tipoproduccion: itemselected.tipoproduccion,
                        unidadmedida: itemselected.unidadmedida,
                        cantidad: cantidad,
                        factor: 1,
                    }
                    carrito = [...carrito, item];
                    printItemTable(itemselected.id, itemselected.unidadmedida, cantidad, itemselected.text);
                }else{
                    carrito[index].cantidad = cantidad;
                    const tr = document.querySelector(`[data-id="${carrito[index].iditem}"]`)!;
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
                carrito = carrito.filter(x => x.iditem!==iditem);
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