(()=>{
  if(!document.querySelector('.ventas'))return;

    const POS = (window as any).POS;

    const btnotros = document.querySelector('#btnotros') as HTMLButtonElement;  //btn de otros
    const miDialogoOtrosProductos = document.querySelector('#miDialogoOtrosProductos') as any;
    let otrosproductos:{id:number, nombre:string, cantidad:number, valorunidad:number, total:number}={
      id: 0,
      nombre: '',
      cantidad: 0,
      valorunidad: 0,
      total: 0
    }
    ///////////////////// Evento al btn Otros /////////////////////////
    btnotros.addEventListener('click', (e:Event)=>{
      miDialogoOtrosProductos.showModal();
      document.addEventListener("click", POS.cerrarDialogoExterno);
    });

    const gestionOtrosProductos = {
      miDialogoOtrosProductos,  
      otrosproductos(){

        /////////////////////Evento al formulario de agregar otros productos //////////////////////
        document.querySelector('#formOtrosProductos')?.addEventListener('submit', (e:Event)=>{
            e.preventDefault();
            const formelements = (e.target as HTMLFormElement).elements;
            const cantidadotros = Number((formelements.namedItem('cantidadotros') as HTMLInputElement).value);
            const preciootros = Number((formelements.namedItem('preciootros') as HTMLInputElement).value);
            
            otrosproductos!.id += -1 ;
            otrosproductos!.nombre = (formelements.namedItem('nombreotros') as HTMLInputElement).value;
            otrosproductos!.cantidad = cantidadotros;
            otrosproductos!.valorunidad = preciootros/cantidadotros;
            otrosproductos!.total = preciootros;
            
            POS.products.push({
                id: otrosproductos!.id+'', 
                idcategoria: '-1',
                idunidadmedida: '1',
                nombre: otrosproductos!.nombre,
                foto: 'na',
                impuesto: '0', //impuesto en %
                marca: 'na',
                tipoproducto: '-1', // 0 = simple,  1 = compuesto
                tipoproduccion: '-1', //0 = inmediato, 1 = construccion
                codigo: '-1',
                unidadmedida: 'Unidad',
                descripcion: 'na',
                peso: 'na',
                medidas: 'na',
                color: 'na',
                funcion: 'na',
                uso: 'na',
                fabricante: 'na',
                garantia: 'na',
                stock: '0',
                stockminimo: '1',
                categoria: 'na',
                rendimientoestandar: '1',
                precio_compra: '0',
                precio_venta: otrosproductos!.valorunidad+'',
                fecha_ingreso: '',
                estado: '1',
                visible: '1'
            });

            POS.actualizarCarrito(otrosproductos.id+'', cantidadotros, false, false);
            miDialogoOtrosProductos.close();
            document.removeEventListener("click", POS.cerrarDialogoExterno);
        });

      }
    };

    (window as any).POS.gestionOtrosProductos = gestionOtrosProductos;

})();