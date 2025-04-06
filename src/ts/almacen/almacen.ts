(()=>{
    if(document.querySelector('.almacen')){
        //const btncrearCliente = document.querySelector('#crearCliente');
        //const btncrearDireccion = document.querySelector('#crearDireccion');
        const miDialogoStock = document.querySelector('#miDialogoStock') as any;
        let indiceFila=0, control=0;
    

        //////////////////  TABLA //////////////////////
        ($('#tablaStockRapido') as any).DataTable(configdatatables);


        document.querySelector('#tablaStockRapido')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
            const target = e.target as HTMLElement;
            if((e.target as HTMLElement)?.classList.contains("editarStock")||(e.target as HTMLElement).parentElement?.classList.contains("editarStock"))editarStock(e);
        });

        function editarStock(e:Event){
            miDialogoStock.showModal();
            document.addEventListener("click", cerrarDialogoExterno);
        }


        function cerrarDialogoExterno(event:Event) {
            if (event.target === miDialogoStock || (event.target as HTMLInputElement).value === 'salir') {
                miDialogoStock.close();
            document.removeEventListener("click", cerrarDialogoExterno);
            }
        }

    }

})();