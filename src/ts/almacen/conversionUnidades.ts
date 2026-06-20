(()=>{
    if(document.querySelector('.conversionUnidades')){

      const miDialogoConversionUnidad = document.querySelector('#miDialogoConversionUnidad') as any;
      const unidadesMedidas = document.querySelector('#unidadesMedidas') as HTMLSelectElement;
      const contenedor = document.querySelector('#contenedor') as HTMLDivElement;
      const factor = document.querySelector('#equivalente') as HTMLInputElement;
      let indiceFila=0, tablaSubProductos:HTMLElement;

      document.addEventListener("click", cerrarDialogoExterno);
      
      type subproductsapi = {
        id:string,
        id_unidadmedida: string,
        unidadmedida: string,
        nombre: string,
        sku: string,
        proveedor: string,
        descripcion: string,
        medidas: string,
        color: string,
        uso:string,
        stock: string,
        stockminimo: string,
        precio_compra: string,
        fecha_ingreso: string,
      };

      interface IunidadesMedida {
        id:string,
        nombre:string
      }
  
      type conversionunidadesapi = {
        id:string,
        idproducto: string,
        idsubproducto: string,
        idunidadmedidabase: string,
        idunidadmedidadestino: string,
        nombreunidadbase: string,
        nombreunidaddestino: string,
        factorconversion: string,
      };

      let subproducts:subproductsapi[]=[], unsubproducto:subproductsapi, allUnidadesMedida:IunidadesMedida[]=[], allConversionUnidades:conversionunidadesapi[] = [];
  
      (async ()=>{
        try {
            const url = "/admin/api/allsubproducts"; //llamado a la API REST
            const respuesta = await fetch(url); 
            subproducts = await respuesta.json(); 
            //console.log(subproducts);
        } catch (error) {
            console.log(error);
        }
      })();


      (async ()=>{
        try {
            const url = "/admin/api/almacen/allUnidadesMedida"; //llamado a la API REST
            const respuesta = await fetch(url); 
            allUnidadesMedida = await respuesta.json(); 
            //console.log(allUnidadesMedida);
        } catch (error) {
            console.log(error);
        }
      })();


      (async ()=>{
        try {
            const url = "/admin/api/allConversionesUnidades";
            const respuesta = await fetch(url); 
            allConversionUnidades = await respuesta.json(); 
            console.log(allConversionUnidades);
        } catch (error) {
            console.log(error);
        }
      })();
  
      //////////////////  TABLA //////////////////////
      tablaSubProductos = ($('#tablaSubProductos') as any).DataTable(configdatatables);
  
  
      ///////////// EVENTOS A LA TABLA SUBPRODUCTOS /////////////
      document.querySelector('#tablaSubProductos')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
        const target = e.target as HTMLElement;
        if(target?.classList.contains("editarUnidadMedida")||target.parentElement?.classList.contains("editarUnidadMedida"))editarUnidadMedida(e);
      });
  
      function editarUnidadMedida(e:Event){
        while(unidadesMedidas.firstChild)unidadesMedidas.removeChild(unidadesMedidas.firstChild);
        let idsubproducto = (e.target as HTMLElement).parentElement?.id!;
        if((e.target as HTMLElement)?.tagName === 'I')idsubproducto = (e.target as HTMLElement).parentElement?.parentElement?.id!;
        unsubproducto = subproducts.find(x=>x.id === idsubproducto)!;
  
        $('#nombreInsumo').text(unsubproducto?.nombre??'');
        $('#unidadMedidaBase').text(unsubproducto?.unidadmedida??'');
        $('#unidadMedidaBase2').val(unsubproducto?.unidadmedida??'');

        const unidadesDestino = allConversionUnidades.filter(c => c.idsubproducto === unsubproducto.id).map(c => c.idunidadmedidadestino);

        allUnidadesMedida.forEach(u=>{
          if(!unidadesDestino.includes(u.id)){
            const option = document.createElement('option');
            option.value = u.id;
            option.textContent = u.nombre;
            unidadesMedidas.appendChild(option);
          }
        });

        imprimirConversionesUnidades(allConversionUnidades);
        
        //indiceFila = (tablaSubProductos as any).row((e.target as HTMLElement).closest('tr')).index();
        miDialogoConversionUnidad.showModal();
      }


      function imprimirConversionesUnidades(allConversionUnidades:conversionunidadesapi[]){
        const subAllUnidades = allConversionUnidades.filter(z=>z.idsubproducto===unsubproducto.id);
        console.log(subAllUnidades);
        contenedor.innerHTML = '';
        subAllUnidades.forEach(conversion => {
            contenedor.innerHTML += `
                <div class="flex items-center justify-between p-3 mb-3 bg-white border border-slate-200 rounded-lg">
                    <div class="flex items-center gap-6 text-lg">
                        <span>
                            <span class="font-medium text-slate-500">Base:</span>
                            <span class="text-slate-900 font-medium">1 ${conversion.nombreunidadbase}</span>
                        </span>
                        <span>
                            <span class="font-medium text-slate-500">Destino:</span>
                            <span class="text-slate-900 font-medium">${conversion.nombreunidaddestino}</span>
                        </span>
                    </div>
                    <button
                        type="button"
                        data-id="${conversion.id}"
                        data-idunidadMedidaDestino="${conversion.idunidadmedidadestino}"
                        data-nombreunidaddestino="${conversion.nombreunidaddestino}"
                        class="btn-eliminar px-3 py-1.5 text-base font-medium text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 hover:border-red-300 transition-colors"
                    >
                        Eliminar
                    </button>
                </div>
            `;
        });
      }


      //ELIMINAR CONVERSION DE UNIDAD
      contenedor.addEventListener('click', (e) => {
          const target = e.target as HTMLElement;
          if(target.classList.contains('btn-eliminar')){
              const id = target.dataset.id; //id de la tabla conversionunidad
              const idunidadMedidaDestino = target.dataset.idunidadMedidaDestino;
              const nombreunidaddestino = target.dataset.nombreunidaddestino;
              console.log('Eliminar conversión:', id);
              allConversionUnidades = allConversionUnidades.filter(conversion => conversion.id != id);
              imprimirConversionesUnidades(allConversionUnidades);
              // Aquí llamas tu API o eliminas del arreglo
              //agregar la unidad de medida al select de unidades de medida
              
          }
      });
  
      ////////////////////  Actualizar conversion unidad de medida  //////////////////////
      document.querySelector('#formConversionUnidad')?.addEventListener('submit', e=>{
          e.preventDefault();
          (async ()=>{ 
            const datos = new FormData();
            datos.append('idsubproducto', unsubproducto.id);
            datos.append('idunidadmedidabase', unsubproducto.id_unidadmedida);
            datos.append('idunidadmedidadestino', $('#unidadesMedidas').val()as string);
            datos.append('nombreunidadbase', unsubproducto.unidadmedida);
            datos.append('nombreunidaddestino', $('#unidadesMedidas option:selected').text());
             datos.append('factorconversion', factor.value??'0');
            try {
                const url = "/admin/api/almacen/crearNuevaConversionUnidad";
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json(); 
                console.log(resultado); 
                if(resultado.exito !== undefined){
                  msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                  const nuevaConversion:conversionunidadesapi = resultado.newCv;
                  allConversionUnidades.push(nuevaConversion);
                  imprimirConversionesUnidades(allConversionUnidades);
                  //eliminar del select de unidades de medida el option
                  const option = unidadesMedidas.querySelector(`option[value="${nuevaConversion.idunidadmedidadestino}"]`);
                  option?.remove();
                }else{
                  msjalertToast('error', '¡Error!', resultado.error[0]);
                }
                
            } catch (error) {
                console.log(error);
            }
            //miDialogoConversionUnidad.close();
          })();//cierre de async()

      });
  
      function eliminarSubProductos(e:Event){
        let idsubproducto = (e.target as HTMLElement).parentElement!.id, info = (tablaSubProductos as any).page.info();
        if((e.target as HTMLElement).tagName === 'I')idsubproducto = (e.target as HTMLElement).parentElement!.parentElement!.id;
        indiceFila = (tablaSubProductos as any).row((e.target as HTMLElement).closest('tr')).index();
        Swal.fire({
            customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
            icon: 'question',
            title: 'Desea eliminar el sub prducto?',
            text: "El sub prducto sera eliminado definitivamente.",
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result:any) => {
            if (result.isConfirmed) {
                (async ()=>{ 
                    const datos = new FormData();
                    datos.append('id', idsubproducto);
                    try {
                        const url = "/admin/api/eliminarSubProducto";
                        const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                        const resultado = await respuesta.json();  
                        if(resultado.exito !== undefined){
                          (tablaSubProductos as any).row(indiceFila).remove().draw(); 
                          (tablaSubProductos as any).page(info.page).draw('page');
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
      }

  
      function limpiarformdialog(){
        (document.querySelector('#formCrearUpdateSubProducto') as HTMLFormElement)?.reset();
        (document.querySelector('#formCrearUpdateSubProducto') as HTMLFormElement).action = "/admin/almacen/crear_subproducto";
      }
      
      function cerrarDialogoExterno(event:Event) {
        if (event.target === miDialogoConversionUnidad || (event.target as HTMLInputElement).value === 'Salir' || (event.target as HTMLInputElement).value === 'Actualizar') {
            miDialogoConversionUnidad.close();
        }
      }
    }
  
  })();