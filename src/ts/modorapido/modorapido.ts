(()=>{
    if(document.querySelector('.modorapido')){

        interface i_itemDetalle {
            id:string, //id del registro de la tabla productosseparados
            idproducto: string,
            tipoproducto:string,
            tipoproduccion:string,
            idcategoria:string,
            foto:string,
            nombreproducto?:string,
            rendimientoestandar?:number,
            costo:string,
            valorunidad:string,
            cantidad:number,
            subtotal:number,
            base:number,
            impuesto:string,
            valorimp:number,
            descuento:number,
            total:number,
        }

        interface i_allProducts {
            id:string,  //id del producto
            idunidadmedida:string, 
            nombre:string,
            impuesto:string,
            tipoproducto:string, 
            tipoproduccion:string, 
            sku:string,
            stock:string,
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


        const tablaMR = document.getElementById('tablaVenta') as HTMLBodyElement;

        let factimpuestos:Item[] = [];
        let carrito:CarritoItem[]=[];
        let allproducts:productsapi[] = [];
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
                const resultado:productsapi[] = await respuesta.json();
                //console.log(resultado);
                filteredData = resultado.filter(x=>x.habilitarventa=='1'&&x.visible=='1').map(item => ({ id: item.id, text: item.nombre, tipo:item.tipoproducto??'1', tipoproducto: item.tipoproducto, tipoproduccion: item.tipoproduccion, sku: item.sku, unidadmedida: item.unidadmedida }));
                activarselect2();
                allproducts = resultado.filter(x=>x.habilitarventa=='1'&&x.visible=='1');
            } catch (error) {
                console.log(error);
            }
        })();

        activarselect2();
        function activarselect2(){
            ($('#articulo') as any).select2({ 
                width: '100%',
                data: filteredData,
                placeholder: "Selecciona un item",
                maximumSelectionLength: 1,
            });  
        }

        ////// EVENTO AL SELECT ARTICULOS O ITEMS PARA SELECCIONAR EL ITEM Y AÑADIR AL CARRITO ////// 
        $("#articulo").on('change', (e)=>{
            let datos = ($('#articulo') as any).select2('data')[0];
            //console.log(datos);
            if(datos){
            let cantidad = 1, itemselected = carrito.find(x=>x.idproducto==datos.id);
            if(itemselected != undefined)cantidad += itemselected.cantidad;
            agregarProducto(datos.id, datos.text, cantidad);
            $("#articulo").val('null').trigger('change');
            }
        });



        function agregarProducto(id:string, nombre:string, cantidad:number) {
            /*const ex = tabla.querySelector(`tr[data-codigo="${cod}"]`);
            if (ex) {
            ex.dataset.cantidad++;
            recalcularTotales();
            return;
            }*/

            const index = carrito.findIndex(x=>x.idproducto==id);
            if(index == -1){  //si el item seleccionado no existe en el carrito, agregarlo.
                const cantidad = 1;
                const itemselected = allproducts.find(x=>x.id==id)!;
                const productototal = Number(itemselected.precio_venta)*cantidad;
                const productovalorimp = productototal*constImp[itemselected.impuesto??'0']; //si producto.impuesto es null toma el valor de cero
                const item:{id: string, idproducto:string, tipoproducto:string, tipoproduccion:string, idcategoria: string, nombreproducto: string, rendimientoestandar:string, foto:string, costo:string, valorunidad: number, cantidad: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total:number} = {
                    id: '',
                    idproducto: itemselected?.id!,
                    tipoproducto: itemselected.tipoproducto,
                    tipoproduccion: itemselected.tipoproduccion,
                    idcategoria: itemselected.idcategoria,
                    nombreproducto: itemselected.nombre,
                    rendimientoestandar: itemselected.rendimientoestandar,
                    foto: itemselected.foto,
                    costo: itemselected.precio_compra,
                    valorunidad: Number(itemselected.precio_venta),
                    cantidad: cantidad,
                    subtotal: productototal, //este es el subtotal del producto
                    base: productototal-productovalorimp,
                    impuesto: itemselected.impuesto, //porcentaje de impuesto, es null si es excluido de iva
                    valorimp: productovalorimp,
                    descuento: 0,
                    total: productototal //valorunidad x cantidad
                }
                carrito = [...carrito, item];
            }else{
                if(cantidad <= 0){
                    cantidad = 0;
                    carrito[index].total = 0;
                    //carrito = carrito.filter(x=>x.iditem != id);
                }
                    
                    carrito[index].cantidad = cantidad;
                    /*const total:number = carrito[index].cantidad*carrito[index].precio_venta;
                    carrito[index].subtotal = total;
                    carrito[index].total = total;*/
                    carrito[index].subtotal = (carrito[index].valorunidad)*carrito[index].cantidad;
                    carrito[index].total = carrito[index].subtotal;
                    //calculo del impuesto y base por producto en el carrito deventas
                    carrito[index].valorimp = parseFloat((carrito[index].total*constImp[carrito[index].impuesto??0]).toFixed(3));
                    carrito[index].base = parseFloat((carrito[index].total-carrito[index].valorimp).toFixed(3));
            }
            

            /*tr.dataset.codigo = cod;
            tr.dataset.precio = precio;tabindex="0"
            tr.dataset.cantidad = 1;*/
            while(tablaMR.firstChild)tablaMR.removeChild(tablaMR.firstChild);

            carrito.forEach(item=>{
                const tr = document.createElement('tr') as HTMLTableRowElement;
                tr.classList.add('productselect');
                tr.dataset.id = `${item.id}`;
                tr.innerHTML = `
                    <td class="py-2 pl-4">${item.nombreproducto}</td>
                    <td class="py-2 text-center cursor-pointer cantidad"><input type="text" class="inputcantidad w-20 p-2 text-center" value="${item.cantidad}"></td>
                    <td class="py-2 text-right">${item.valorunidad}</td>
                    <td class="py-2 text-right totalFila">${item.total}</td>
                    <td class="text-center text-red-600 cursor-pointer">✖</td>`;
                tablaMR.prepend(tr);
                
            });

        }


        tablaMR?.addEventListener('input', e=>{
            const input = e.target as HTMLInputElement;
            if (!input.classList.contains('inputcantidad')) return;
            const fila = input?.closest('.productselect') as HTMLTableRowElement;
            const idProduct = fila.dataset.id!;
            const productoCarrito = carrito.find(x=>x.idproducto==idProduct);
            if(productoCarrito==undefined)return;
            
                //if((e.target as HTMLElement).dataset.event != "eventInput"){
                
            let val = input.value;
            val = val.replace(/[^0-9.]/g, '');
            const partes = val.split('.');
            if(partes.length > 2)val = partes[0]+'.'+partes.slice(1).join('');
            if (val.startsWith('.'))val = '1';
            if (val === '' || isNaN(parseFloat(val))) val = '';

            input.value = val;
            //actualizarCarrito(idProduct, Number(input.value), false, false,  productoCarrito?.valorunidad);
        
                //(e.target as HTMLElement).dataset.event = "eventInput"; //se marca al input que ya tiene evento añadido
                //}

            let cantidad = Number(val);
            
            if(cantidad <= 0){
                cantidad = 0;
                productoCarrito.total = 0;
                //carrito = carrito.filter(x=>x.iditem != id);
            }
                
            productoCarrito.cantidad = cantidad;
            /*const total:number = carrito[index].cantidad*carrito[index].precio_venta;
            carrito[index].subtotal = total;
            carrito[index].total = total;*/
            productoCarrito.subtotal = (productoCarrito.valorunidad)*productoCarrito.cantidad;
            productoCarrito.total = productoCarrito.subtotal;
            //calculo del impuesto y base por producto en el carrito deventas
            productoCarrito.valorimp = parseFloat((productoCarrito.total*constImp[productoCarrito.impuesto??0]).toFixed(3));
            productoCarrito.base = parseFloat((productoCarrito.total-productoCarrito.valorimp).toFixed(3));

        });



            /*const tdCantidad = tr.querySelector('.cantidad');
            tdCantidad.classList.add('cursor-pointer');*/

            /* ===== SOLO DOBLE ENTER ===== */
            /*tdCantidad.onkeydown = e => {
                const ahora = Date.now();

                // ⬆️ SUBIR
                if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    tr.dataset.cantidad = Number(tr.dataset.cantidad) + 1;
                    beep(900);
                    flashCantidad(tdCantidad, 'up');
                    recalcularTotales();
                    return;
                }

                // ⬇️ BAJAR
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    tr.dataset.cantidad = Math.max(1, Number(tr.dataset.cantidad) - 1);
                    beep(500);
                    flashCantidad(tdCantidad, 'down');
                    recalcularTotales();
                    return;
                }

                // ⏎ ENTER
                if (e.key === 'Enter') {
                    e.preventDefault();

                    if (ahora - ultimoEnterTiempo < DOBLE_ENTER_MS) {
                        // 🔓 DOBLE ENTER → editar manual
                        activarEdicionCantidad(tdCantidad, tr);
                        ultimoEnterTiempo = 0;
                    } else {
                        // ➕ ENTER SIMPLE → sumar
                        ultimoEnterTiempo = ahora;
                        tr.dataset.cantidad = Number(tr.dataset.cantidad) + 1;
                        beep(900);
                        flashCantidad(tdCantidad, 'up');
                        recalcularTotales();
                    }
                }
            };*/
        

    }

})();