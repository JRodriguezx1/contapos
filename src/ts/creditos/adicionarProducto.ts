(()=>{
    if(document.querySelector('.adicionarProducto')){
        
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

            capital?:number,            //DATOS DEL CREDITO
            abonoinicial?:number,      //abono inicial en el credito
            saldopendiente?:number,
            cantidadcuotas?:number,
            interes?:string,           // 1 = si interes en el credito, 0 = no interes en el credito
            interestotal?:number,      //interes total dlecredito en porcentaje
            valorinterestotal?:number, //valor del interes total de credito
            montototal?:number,
            descuentocredito?:number,  //descuneto general en el credito
            
            costo:number,
            valorunidad:number,
            descuento:number,  //se calcula para productos nuevos agregados
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

        interface Item {
            id_impuesto: number,
            facturaid: number,
            basegravable: number,
            valorimpuesto: number
            }


        let factimpuestos:Item[] = [];
        let carrito:i_itemDetalle[]=[];
        let allproducts:i_allProducts[] = [];
        let filteredData: {id:string, text:string, tipo:string, tipoproducto:string, tipoproduccion:string, sku:string, unidadmedida:string}[];   //tipoproducto = 0 es producto simple,  1 = compuesto,  si no viene es subproducto, tipo=0 es producto(simple o compuesto), tipo=1 es subproducto
        const valorTotal = {subtotal: 0, base: 0, valorimpuestototal: 0, dctox100: 0, descuento: 0, total: 0}; //datos global de la venta
        const dataCredit = {capital:0, abonoinicial:0, saldopendiente:0, cantidadcuotas:0, interes:'0', interestotal:0, valorinterestotal:0, montototal:0, descuentocredito: 0};

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
                            costo: Number(item.costo),
                            valorunidad: Number(item.valorunidad),
                            descuento: Number(item.descuento), //descuento del producto
                            cantidad: Number(item.cantidad),
                            base: Number(item.base),
                            impuesto: item.impuesto,
                            valorimp: Number(item.valorimp),
                            subtotal: Number(item.subtotal),
                            total: Number(item.total),
                            factor: 1
                        }
                    });
                    carrito.forEach(c =>printItemTable(c.fk_producto, c.unidadmedida, c.cantidad, c.nombreproducto, c.valorunidad, c.total));
                    //obtener datos del credito

                    dataCredit.capital = Number(resultado[0].capital);
                    dataCredit.abonoinicial = Number(resultado[0].abonoinicial!);
                    dataCredit.saldopendiente = Number(resultado[0].saldopendiente);
                    dataCredit.cantidadcuotas = Number(resultado[0].cantidadcuotas);
                    dataCredit.interes = resultado[0].interes!;
                    dataCredit.interestotal = resultado[0].interestotal!;
                    dataCredit.valorinterestotal = Number(resultado[0].valorinterestotal!);
                    dataCredit.montototal = Number(resultado[0].montototal);
                    dataCredit.descuentocredito = Number(resultado[0].descuentocredito!);
                    
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
                        costo: Number(productSelected.precio_compra),
                        valorunidad: Number(productSelected.precio_venta),
                        descuento: 0,
                        cantidad: cantidad,
                        base: productototal-productovalorimp,
                        impuesto: productSelected.impuesto,
                        valorimp: productovalorimp,
                        subtotal: productototal,
                        total: productototal,
                        factor: 1,
                    }
                    carrito = [...carrito, item];
                    printItemTable(productSelected.id, productSelected.unidadmedida, cantidad, productSelected.nombre, productSelected.precio_venta, item.total);
                    valorCarritoTotal();
                }else{
                    carrito[index].cantidad = cantidad;
                    carrito[index].subtotal = (carrito[index].valorunidad)*carrito[index].cantidad;
                    carrito[index].total = carrito[index].subtotal;
                    //calculo del impuesto y base por producto en el carrito deventas
                    carrito[index].valorimp = parseFloat((carrito[index].total*constImp[carrito[index].impuesto??0]).toFixed(3));
                    carrito[index].base = parseFloat((carrito[index].total-carrito[index].valorimp).toFixed(3));
                    //calcular valores
                    const tr = document.querySelector(`[data-id="${carrito[index].fk_producto}"]`)!;
                    tr.children[1].textContent = carrito[index].cantidad+'';
                    valorCarritoTotal();
                }

            }
        });

        function printItemTable(id:string, unidadmedida:string, cantidad:number, nombre:string, valorunidad:number, total:number){
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
                <td class="p-4">$ ${valorunidad.toLocaleString()}</td>
                <td class="p-4">$ ${total.toLocaleString()}</td>
                <td class="p-4 flex items-center justify-center gap-2">
                    <button class="flex items-center gap-1 px-3 py-1 text-base text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                        👁 Ver
                    </button>
                    <button class="eliminarItem w-11 h-11 flex items-center justify-center text-rose-600 border border-rose-200 rounded-full hover:bg-rose-50 text-xl">❌</button>
                </td>`);
            tablaItems?.appendChild(tr);
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
            valorTotal.total = valorTotal.subtotal+dataCredit.valorinterestotal-dataCredit.descuentocredito-dataCredit.abonoinicial;
            //console.log(valorTotal);
            //console.log(factimpuestos);
            document.querySelector('#subTotal')!.textContent = '$'+valorTotal.subtotal.toLocaleString();
            (document.querySelector('#impuesto') as HTMLElement).textContent = '$'+valorTotalImp.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.querySelector('#total')!.textContent = '$ '+(valorTotal.total).toLocaleString(); //+ interes - descuneto - abonoinicial
            
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
            valorCarritoTotal();
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
                        //validar que el montototal no sea menor a lo abonado hasta la fecha
                        if(valorTotal.total< (dataCredit.montototal-dataCredit.saldopendiente)){
                            alert('El valor del credito es inferior de lo que se ha abonado.');
                            return;
                        }
                        const datos = new FormData();
                        datos.append('idcredito', idcreditoURL!);
                        datos.append('ids', JSON.stringify(carrito.map(x=>x.id)));
                        datos.append('nuevosproductos', JSON.stringify(carrito));

                        datos.append('factimpuestos', JSON.stringify(factimpuestos));
                        datos.append('capital', valorTotal.subtotal+'');
                        datos.append('saldopendiente', (dataCredit.saldopendiente+valorTotal.total-dataCredit.montototal)+'');
                        datos.append('montocuota', (Math.ceil((valorTotal.total/dataCredit.cantidadcuotas)*100)/100)+'');
                        datos.append('montototal', valorTotal.total+'');
                        datos.append('totalunidades', carrito.reduce((total, x)=>x.cantidad+total, 0)+'');
                        
                        datos.append('base', valorTotal.base.toFixed(3));  //base global del credito
                        datos.append('valorimpuestototal', valorTotal.valorimpuestototal+''); //valor total del impuesto dle credito. 
                        datos.append('dctox100', valorTotal.dctox100+'');
                        datos.append('descuento', dataCredit.descuentocredito+''); //descuento global de credito
                    
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