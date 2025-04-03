(()=>{
    if(document.querySelector('.clientes')){
      const crearCliente = document.querySelector('#crearCliente');
      const miDialogoCliente = document.querySelector('#miDialogoCliente') as any;
      let indiceFila=0, control=0, tablaClientes:HTMLElement;
      
  
      type clientesapi = {
        id:string,
        nombre: string,
        apellido: string,
        tipodocumento: string,
        identificacion: string,
        telefono: string,
        email: string,
        fecha_nacimiento: string,
        total_compras: string,
        ultima_compra: string;
        data1: string,
        //idservicios:{idempleado:string, idservicio:string}[]
      };
  
      let clientes:clientesapi[]=[], uncliente:clientesapi;
  
      (async ()=>{
        try {
            const url = "/admin/api/allclientes"; //llamado a la API REST y se trae todos los productos
            const respuesta = await fetch(url); 
            clientes = await respuesta.json(); 
            console.log(clientes);
        } catch (error) {
            console.log(error);
        }
      })();
  
  
      //////////////////  TABLA //////////////////////
      tablaClientes = ($('#tablaClientes') as any).DataTable(configdatatables);
  
      crearCliente?.addEventListener('click', (e):void=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalCliente')!.textContent = "Crear cliente";
        (document.querySelector('#btnEditarCrearCliente') as HTMLInputElement).value = "Crear";
        miDialogoCliente.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      });
  
      document.querySelector('#tablaClientes')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
        const target = e.target as HTMLElement;
        if((e.target as HTMLElement)?.classList.contains("editarClientes")||(e.target as HTMLElement).parentElement?.classList.contains("editarClientes"))editarClientes(e);
        if(target?.classList.contains("eliminarClientes")||target.parentElement?.classList.contains("eliminarClientes"))eliminarClientes(e);
      });
  
      function editarClientes(e:Event){
        let idcliente = (e.target as HTMLElement).parentElement?.id!;
        if((e.target as HTMLElement)?.tagName === 'I')idcliente = (e.target as HTMLElement).parentElement?.parentElement?.id!;
        control = 1;
        document.querySelector('#modalCliente')!.textContent = "Actualizar cliente";
        (document.querySelector('#btnEditarCrearCliente') as HTMLInputElement)!.value = "Actualizar";
        uncliente = clientes.find(x=>x.id === idcliente)!;
        (document.querySelector('#nombre')as HTMLInputElement).value = uncliente?.nombre!;
        (document.querySelector('#apellido')as HTMLInputElement).value = uncliente?.apellido!;
        $('#tipodocumento').val(uncliente?.tipodocumento??'');
        (document.querySelector('#identificacion')as HTMLInputElement).value = uncliente?.identificacion??'';
        (document.querySelector('#telefono')as HTMLInputElement).value = uncliente?.telefono??'';
        (document.querySelector('#email')as HTMLInputElement).value = uncliente?.email??'';
        (document.querySelector('#fecha_nacimiento')as HTMLInputElement).value = uncliente?.fecha_nacimiento??'';
        
        miDialogoCliente.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
  
      ////////////////////  Actualizar/Editar clientes  //////////////////////
      document.querySelector('#formCrearUpdateProducto')?.addEventListener('submit', e=>{
        if(control){
          e.preventDefault();
          var info = (tablaClientes as any).page.info();
          
          (async ()=>{ 
            const datos = new FormData();
            datos.append('id', uncliente!.id);
            datos.append('nombre', $('#nombre').val()as string);
            datos.append('apellido', $('#apellido').val()as string);
            datos.append('tipodocumento', $('#tipodocumento').val()as string);
            datos.append('identificacion', $('#identificacion').val()as string);
            datos.append('telefono', $('#telefono').val()as string);
            datos.append('email', $('#email').val()as string);
            datos.append('fecha_nacimiento', $('#fecha_nacimiento').val()as string);
            try {
                const url = "/admin/api/actualizarCliente";
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json(); 
                console.log(resultado); 
                if(resultado.exito !== undefined){
                  msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                  /// actualizar el arregle del producto ///
                  clientes.forEach(a=>{if(a.id == uncliente.id)a = Object.assign(a, resultado.cliente[0]);});
                  ///////// cambiar la fila completa, su contenido //////////
                  const datosActuales = (tablaClientes as any).row(indiceFila).data();
                  /*NOMBRE*/datosActuales[1] = $('#nombre').val();
                  /*APELLIDO*/datosActuales[2] = $('#apellido').val();
                  /*TELEFONO*/datosActuales[3] = $('#telefono').val();
                  /*EMAIL*/datosActuales[4] = $('#email').val();
                  
                  (tablaClientes as any).row(indiceFila).data(datosActuales).draw();
                  (tablaClientes as any).page(info.page).draw('page'); //me mantiene la pagina actual
                }else{
                  msjalertToast('error', '¡Error!', resultado.error[0]);
                }
                document.addEventListener("click", cerrarDialogoExterno);
            } catch (error) {
                console.log(error);
            }
          })();//cierre de async()
        } //fin if(control)
      });
  
      function eliminarClientes(e:Event){
        let idcliente = (e.target as HTMLElement).parentElement!.id, info = (tablaClientes as any).page.info();
        if((e.target as HTMLElement).tagName === 'I')idcliente = (e.target as HTMLElement).parentElement!.parentElement!.id;
        indiceFila = (tablaClientes as any).row((e.target as HTMLElement).closest('tr')).index();
        Swal.fire({
            customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
            icon: 'question',
            title: 'Desea eliminar el cliente?',
            text: "El cliente sera eliminado definitivamente.",
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result:any) => {
            if (result.isConfirmed) {
                (async ()=>{ 
                    const datos = new FormData();
                    datos.append('id', idcliente);
                    try {
                        const url = "/admin/api/eliminarCliente";
                        const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                        const resultado = await respuesta.json();  
                        if(resultado.exito !== undefined){
                          (tablaClientes as any).row(indiceFila+info.start).remove().draw(); 
                          (tablaClientes as any).page(info.page).draw('page');
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
        (document.querySelector('#formCrearUpdateCliente') as HTMLFormElement)?.reset();
      }
      function cerrarDialogoExterno(event:Event) {
        if (event.target === miDialogoCliente || (event.target as HTMLInputElement).value === 'salir' || (event.target as HTMLInputElement).value === 'Actualizar') {
          miDialogoCliente.close();
          document.removeEventListener("click", cerrarDialogoExterno);
        }
      }
    }
  
  })();