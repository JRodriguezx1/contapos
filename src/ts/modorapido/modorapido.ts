(()=>{
    if(document.querySelector('.modorapido')){

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
            let cantidad = 1, itemselected = carrito.find(x=>x.fk_producto==datos.id);
            if(itemselected != undefined)cantidad += itemselected.cantidad;
            agregarProducto(datos.id, datos.text, datos.precio_venta);
            $("#articulo").val('null').trigger('change');
            }
        });



        function agregarProducto(id:string, nombre:string, precio:number) {
            /*const ex = tabla.querySelector(`tr[data-codigo="${cod}"]`);
            if (ex) {
            ex.dataset.cantidad++;
            recalcularTotales();
            return;
            }*/

            const index = carrito.findIndex(x=>x.fk_producto==id);
            if(index == -1){  //si el item seleccionado no existe en el carrito, agregarlo.
                const cantidad = 1;
                const itemselected = allproducts.find(x=>x.id==id)!;
                const productototal = Number(itemselected.precio_venta)*cantidad;
                const productovalorimp = productototal*constImp[itemselected.impuesto??'0']; //si producto.impuesto es null toma el valor de cero
                const item:{id: string, fk_producto: string, tipoproducto: string, tipoproduccion:string, foto:string, costo:number, valorunidad:number, nombreproducto: string, rendimientoestandar:string, unidad: string, cantidad: number, factor: number, precio_venta: number, subtotal: number, base:number, impuesto:string, valorimp:number, descuento:number, total: number, precio_compra:number} = {
                    id: '',
                    idproducto: itemselected?.id!,
                    tipoproducto: itemselected.tipoproducto,
                    tipoproduccion: itemselected.tipoproduccion,
                    foto: '',
                    costo: Number(itemselected.precio_compra),
                    valorunidad: itemselected.precio_venta,
                    nombreproducto: itemselected.nombre,
                    rendimientoestandar: itemselected.rendimientoestandar,
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
                    precio_compra: Number(itemselected.precio_compra),
                }
                carrito = [...carrito, item];
            }

            const tr = document.createElement('tr');
            /*tr.dataset.codigo = cod;
            tr.dataset.precio = precio;
            tr.dataset.cantidad = 1;*/

            tr.innerHTML = `
            <td class="py-2 pl-4">${nombre}</td>
            <td class="py-2 text-center cantidad" tabindex="0">1</td>
            <td class="py-2 text-right">$${precio.toLocaleString()}</td>
            <td class="py-2 text-right totalFila">$${precio.toLocaleString()}</td>
            <td class="text-center text-red-600 cursor-pointer">✖</td>
            `;

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
            tablaMR.prepend(tr);
        }

    }

})();