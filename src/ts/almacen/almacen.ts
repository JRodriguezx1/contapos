(()=>{
    if(document.querySelector('.almacen')){
        //const btncrearCliente = document.querySelector('#crearCliente');
        //const btncrearDireccion = document.querySelector('#crearDireccion');
        const miDialogoStock = document.querySelector('#miDialogoStock') as any;
        const modalStock = document.querySelector('#modalStock') as HTMLElement;
        let amount = document.querySelector('#cantidad') as HTMLInputElement; //input cantidad

        const miDialogoIngresarProduccion = document.querySelector('#miDialogoIngresarProduccion') as any;
        const selectitemAproducir = document.querySelector('#itemAproducir') as HTMLSelectElement;
        const ingresarProduccion = document.querySelector('#ingresarProduccion') as HTMLButtonElement;
        const descontarCantidad = document.querySelector('#descontarCantidad') as HTMLButtonElement
        const selectidunidadmedida = document.querySelector('#selectidunidadmedida') as HTMLSelectElement;
        let indiceFila=0, control=0, factorC = 0;
    

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

        let allConversionUnidades:conversionunidadesapi[] = [];
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



        /////////////////////////////////////  SOTCK RAPIDO ////////////////////////////////////////
        ($('#tablaStockRapido') as any).DataTable(configdatatables);


        document.querySelector('#tablaStockRapido')?.addEventListener("click", (e:Event)=>{ //evento click sobre toda la tabla
            let tipoelemento:string = '', idelemento:string = '';
            const selectStockRapidoUndmedida = document.querySelector('#selectStockRapidoUndmedida') as HTMLSelectElement;
            let options:string = '';
            const target = e.target as HTMLElement;

            var trx = target.closest('.fila') as HTMLElement;
            if(trx.classList.contains('producto')){
                    idelemento = trx.dataset.idproducto!;
                    tipoelemento = '0'; //si es producto
                }
            else{
                idelemento = trx.dataset.idsubproducto!;
                tipoelemento = '1';  // si es un subproducto
            }

            if(tipoelemento == '1'){
                while(selectStockRapidoUndmedida.firstChild)selectStockRapidoUndmedida.removeChild(selectStockRapidoUndmedida.firstChild);
                const subproductounidades = allConversionUnidades.filter(x => x.idsubproducto == idelemento); 
                subproductounidades.forEach(u=>options+=`<option data-factor="${u.factorconversion}" value="${u.idsubproducto}" >${u.nombreunidaddestino}</option>`);
                selectStockRapidoUndmedida.insertAdjacentHTML('afterbegin', options);
            }
            
            document.querySelector('#nombreItemstockrapido')!.textContent = trx.children[1].textContent;  //nombre del producto o subproducto
            if((e.target as HTMLElement)?.classList.contains("descontarStock")||(e.target as HTMLElement).parentElement?.classList.contains("descontarStock"))descontarStock(e);
            if((e.target as HTMLElement)?.classList.contains("aumentarStock")||(e.target as HTMLElement).parentElement?.classList.contains("aumentarStock"))aumentarStock(e);
            if((e.target as HTMLElement)?.classList.contains("ajustarStock")||(e.target as HTMLElement).parentElement?.classList.contains("ajustarStock"))ajustarStock(e);
        });

        //EDITAR STOCK
        function descontarStock(e:Event){
            modalStock.textContent = "Descontar cantidad a inventario"
            miDialogoStock.showModal();
            document.addEventListener("click", cerrarDialogoExterno);
        }

        function aumentarStock(e:Event){
            modalStock.textContent = "Ingreasar cantidad a inventario"
            miDialogoStock.showModal();
            document.addEventListener("click", cerrarDialogoExterno);
        }

        function ajustarStock(e:Event){
            modalStock.textContent = "Ajustar cantidad a inventario"
            miDialogoStock.showModal();
            document.addEventListener("click", cerrarDialogoExterno);
        }


        document.querySelector('#formStock')?.addEventListener('submit', (e)=>{
            e.preventDefault();
            const subproducto = $('#subproducto').find('option:selected');
            const unidadmedida:string = $('#unidadmedida').find('option:selected').text();
            let AmountSubpx:number = factorC*Number(amount.value);
            (async ()=>{
                const datos = new FormData();
                datos.append('id_producto', (document.querySelector('#idproducto') as HTMLInputElement).value);
                datos.append('id_subproducto', $('#subproducto').val()as string);
                datos.append('cantidadsubproducto', AmountSubpx.toString());
                datos.append('costo', (Number(subproducto.data('costo'))*AmountSubpx)+'');
                try {
                    const url = "/admin/api/ensamblar";  //asocia el producto con el sub producto en la tabla productos_sub
                    const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                    const resultado = await respuesta.json();
                    if(resultado.exito !== undefined){
                      msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                        /////validar si es el mismo subproducto, y actualizar 
                        //validarSubproducto($('#subproducto').val()as string, unidadmedida, subproducto.data('subproducto'));
                        ////// reset form ///////
                        ($('#subproducto') as any).val([]).trigger('change');
                        //$(`#subproducto option[value="${$('#subproducto').val()}"]`).remove();
                        (document.querySelector('#formAddSubproducto') as HTMLFormElement)?.reset();
                    }else{
                      msjalertToast('error', '¡Error!', resultado.error[0]);
                    }
                } catch (error) {
                    console.log(error);
                }
            })();//cierre de async()
        });

        ///////////////////////// INGRESAR ORDEN DE PRODUCCION /////////////////////////////////
        //SELECT2 DE itemAproducir
        ($('#itemAproducir') as any).select2({
            maximumSelectionLength: 1,
        });

        ingresarProduccion.addEventListener('click', (e)=>{
            if(selectitemAproducir.value){
                
                document.querySelector('#nombreItem')!.textContent = selectitemAproducir.options[selectitemAproducir.selectedIndex].textContent;
                const option = document.createElement('option');
                option.textContent = selectitemAproducir.options[selectitemAproducir.selectedIndex].dataset.nombreund!;
                option.value = selectitemAproducir.options[selectitemAproducir.selectedIndex].dataset.idund!;
                selectidunidadmedida.appendChild(option);
                miDialogoIngresarProduccion.showModal();
                document.addEventListener("click", cerrarDialogoExterno);
            }
        })



        function cerrarDialogoExterno(event:Event) {
            if (event.target === miDialogoStock || event.target === miDialogoIngresarProduccion || (event.target as HTMLInputElement).value === 'salir') {
                miDialogoStock.close();
                miDialogoIngresarProduccion.close();
            document.removeEventListener("click", cerrarDialogoExterno);
            }
        }



    }

})();