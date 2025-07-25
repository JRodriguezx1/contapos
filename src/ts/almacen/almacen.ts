(()=>{
    if(document.querySelector('.almacen')){
        //const btncrearCliente = document.querySelector('#crearCliente');
        //const btncrearDireccion = document.querySelector('#crearDireccion');
        const miDialogoStock = document.querySelector('#miDialogoStock') as any;
        const miDialogoIngresarProduccion = document.querySelector('#miDialogoIngresarProduccion') as any;
        const selectitemAproducir = document.querySelector('#itemAproducir') as HTMLSelectElement;
        const ingresarProduccion = document.querySelector('#ingresarProduccion') as HTMLButtonElement;
        const descontarCantidad = document.querySelector('#descontarCantidad') as HTMLButtonElement
        const selectidunidadmedida = document.querySelector('#selectidunidadmedida') as HTMLSelectElement;
        let indiceFila=0, control=0;
    

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



        //////////////////  TABLA //////////////////////
        ($('#tablaStockRapido') as any).DataTable(configdatatables);


        document.querySelector('#tablaStockRapido')?.addEventListener("click", (e:Event)=>{ //evento click sobre toda la tabla
            let tipoelemento:string = '', idelemento:string = '';
            const selectidunidadmedida = document.querySelector('#idunidadmedida');
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
                const subproductounidades = allConversionUnidades.filter(x => x.idsubproducto == idelemento); 
                subproductounidades.forEach(u=>options+=`<option data-factor="${u.factorconversion}" value="${u.idsubproducto}" >${u.nombreunidaddestino}</option>`);
                console.log(subproductounidades);
            }
            
            document.querySelector('#nombreItemstockrapido')!.textContent = trx.children[1].textContent;

            if((e.target as HTMLElement)?.classList.contains("editarStock")||(e.target as HTMLElement).parentElement?.classList.contains("editarStock"))editarStock(e);
        });

        //EDITAR STOCK
        function editarStock(e:Event){
            miDialogoStock.showModal();
            document.addEventListener("click", cerrarDialogoExterno);
        }


        //////////// INGRESAR ORDEN DE PRODUCCION ///////////////
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