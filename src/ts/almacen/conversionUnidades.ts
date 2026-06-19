(()=>{
    if(document.querySelector('.conversionUnidades')){

      const miDialogoConversionUnidad = document.querySelector('#miDialogoConversionUnidad') as any;
      const unidadesMedidas = document.querySelector('#unidadesMedidas') as HTMLSelectElement;
      let indiceFila=0, tablaSubProductos:HTMLElement;
      
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
  
      let subproducts:subproductsapi[]=[], unsubproducto:subproductsapi, allUnidadesMedida:IunidadesMedida[]=[];
  
      (async ()=>{
        try {
            const url = "/admin/api/allsubproducts"; //llamado a la API REST
            const respuesta = await fetch(url); 
            subproducts = await respuesta.json(); 
            console.log(subproducts);
        } catch (error) {
            console.log(error);
        }
      })();


      (async ()=>{
        try {
            const url = "/admin/api/almacen/allUnidadesMedida"; //llamado a la API REST
            const respuesta = await fetch(url); 
            allUnidadesMedida = await respuesta.json(); 
            console.log(allUnidadesMedida);
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

        allUnidadesMedida.forEach(u=>{
          if(u.id != unsubproducto.id_unidadmedida){
            const option = document.createElement('option');
            option.value = u.id;
            option.textContent = u.nombre;
            unidadesMedidas.appendChild(option);
          }
        });
        
        //indiceFila = (tablaSubProductos as any).row((e.target as HTMLElement).closest('tr')).index();
        miDialogoConversionUnidad.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
  
      ////////////////////  Actualizar conversion unidad de medida  //////////////////////
      document.querySelector('#formConversionUnidad')?.addEventListener('submit', e=>{
        
          e.preventDefault();
          var info = (tablaSubProductos as any).page.info();
          
          (async ()=>{ 
            const datos = new FormData();
            datos.append('id', unsubproducto!.id);
            datos.append('id_unidadmedida', $('#unidadmedida').val()as string);
            datos.append('unidadmedida', $('#unidadmedida').find('option:selected').text());
            datos.append('nombre', $('#nombre').val()as string);
            datos.append('sku', $('#sku').val()as string);
            datos.append('precio_compra', $('#preciocompra').val()as string);
             datos.append('stockminimo', $('#stockminimo').val()as string);
            try {
                const url = "/admin/api/actualizarsubproducto";
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json(); 
                console.log(resultado); 
                if(resultado.exito !== undefined){
                  msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                  /// actualizar el arregle del subproducto ///
                  subproducts.forEach(a=>{if(a.id == unsubproducto.id)a = Object.assign(a, resultado.subproducto[0]);});
                  ///////// cambiar la fila completa, su contenido //////////
                  const datosActuales = (tablaSubProductos as any).row(indiceFila+=info.start).data();
                  /*NOMBRE*/datosActuales[1] ='<div class="w-80 whitespace-normal">'+$('#nombre').val()+'</div>';
                  /*proveedor*/datosActuales[2] = '';
                  /*SKU*/datosActuales[3] = $('#sku').val();
                  /*UNIDADMEDIDA*/datosActuales[4] = $('#unidadmedida option:selected').text();
                  /*PRECIOCOMPRA*/datosActuales[5] = '$'+Number($('#preciocompra').val())?.toLocaleString();
                  (tablaSubProductos as any).row(indiceFila).data(datosActuales).draw();
                  (tablaSubProductos as any).page(info.page).draw('page'); //me mantiene la pagina actual
                }else{
                  msjalertToast('error', '¡Error!', resultado.error[0]);
                }
                document.addEventListener("click", cerrarDialogoExterno);
            } catch (error) {
                console.log(error);
            }
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
        if (event.target === miDialogoConversionUnidad || (event.target as HTMLInputElement).value === 'salir' || (event.target as HTMLInputElement).value === 'Actualizar') {
            miDialogoConversionUnidad.close();
          document.removeEventListener("click", cerrarDialogoExterno);
        }
      }
    }
  
  })();