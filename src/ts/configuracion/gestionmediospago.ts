(():void=>{

  if(document.querySelector('.mediosPagos')){
    const crearMedioPago = document.querySelector('#crearMedioPago') as HTMLButtonElement;
    const miDialogoMedioPago = document.querySelector('#miDialogoMedioPago') as any;

    let indiceFila=0, control=0, tablamediosPagos:HTMLElement;

    type mediospagoapi = {
        id:string,
        mediopago: string,
        estado: string,
        nick: string
      };
  
      let mediospagos:mediospagoapi[]=[], unmediopago:mediospagoapi|undefined;
      (async ()=>{
        try {
            const url = "/admin/api/allmediospago"; //llamado a la API REST y se trae todos las medios de pago
            const respuesta = await fetch(url); 
            mediospagos = await respuesta.json(); 
        } catch (error) {
            console.log(error);
        }
      })();

     //////////////////  TABLA //////////////////////
    tablamediosPagos = ($('#tablamediosPagos') as any).DataTable(configdatatables);

    crearMedioPago.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalMedioPago')!.textContent = "Crear medio de pago";
        (document.querySelector('#btnEditarCrearMedioPago') as HTMLInputElement).value = "Crear";
        miDialogoMedioPago.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    document.querySelector('#tablamediosPagos')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if((e.target as HTMLElement)?.classList.contains("statemediopago"))changeState(e);
      if((e.target as HTMLElement)?.classList.contains("editarMedioPago")||(e.target as HTMLElement).parentElement?.classList.contains("editarMedioPago"))editarMedioPago(e);
      if(target?.classList.contains("eliminarMedioPago")||target.parentElement?.classList.contains("eliminarMedioPago"))eliminarMedioPago(e);
    });


    ///////////////  Cambiar estado del medio de pago  ////////////////
    function changeState(e:Event){
      const button=(e.target as HTMLButtonElement), info = (tablamediosPagos as any).page.info();
      indiceFila =  (tablamediosPagos as any).row(button.closest('tr')).index();
      (async ()=>{ 
        const datos = new FormData();
        datos.append('id', button.id);
        datos.append('estado', button.dataset.state=='0'?'1':'0');
        try {
            const url = "/admin/api/updateStateMedioPago";
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();  
            if(resultado.exito !== undefined){
              const s1 = `<button id="${button.id}" data-state="${button.dataset.state=='0'?'1':'0'}" class="statemediopago btn-xs ${button.dataset.state=='0'?'btn-lima':'btn-red'}">${button.dataset.state=='0'?'Activo':'Inactivo'}</button>`;
              (tablamediosPagos as any).cell((tablamediosPagos as any).row(indiceFila+=info.start), 2).data(s1).draw(); //se modifica solo la columna con la fila correspondiente, y destruye la que habai antes
              (tablamediosPagos as any).page(info.page).draw('page'); //me mantiene la pagina actual
            }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
        } catch (error) {
            console.log(error);
        }
      })();//cierre de async()
    }

    //////////////////// ventana modal al Actualizar/Editar medio de pago  //////////////////////
    function editarMedioPago(e:Event){
      let idmediopago = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement)?.tagName === 'I')idmediopago = (e.target as HTMLElement).parentElement?.parentElement?.id;
      control = 1;
      document.querySelector('#modalMedioPago')!.textContent = "Actualizar medio de pago";
      (document.querySelector('#btnEditarCrearMedioPago') as HTMLInputElement)!.value = "Actualizar";
      
      unmediopago = mediospagos.find(x => x.id==idmediopago); //me trae el emdio de pago seleccionado
      (document.querySelector('#nombreMedioPago')as HTMLInputElement).value = unmediopago?.mediopago!;
      
      indiceFila = (tablamediosPagos as any).row((e.target as HTMLElement).closest('tr')).index();
      miDialogoMedioPago.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    ////////////////////  Actualizar/Editar medio de pago  //////////////////////
    document.querySelector('#formCrearUpdateMedioPago')?.addEventListener('submit', e=>{
      let urlApi = "crearMedioPago";
      if(control)urlApi = "actualizarMedioPago";

        e.preventDefault();
        var info = (tablamediosPagos as any).page.info();
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', unmediopago?.id?unmediopago?.id:'');
          datos.append('mediopago', $('#nombreMedioPago').val()as string);
          try {
              const url = "/admin/api/"+urlApi;
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                miDialogoMedioPago.close();
                document.removeEventListener("click", cerrarDialogoExterno);
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                if(!control){ //si es crear registro
                  /// actualizar el arregle de los medios de pagos ///
                  mediospagos = [...mediospagos, resultado.mediopago];
                  (tablamediosPagos as any).row.add([
                      (tablamediosPagos as any).rows().count() + 1,
                      resultado.mediopago.mediopago,
                      resultado.mediopago.estado == '1'?'Activo':'Inactivo',
                      `<div class="acciones-btns" id="${resultado.mediopago.id}" data-mediopago="${resultado.mediopago.nombre}">
                          <button class="btn-md btn-turquoise editarMedioPago"><i class="fa-solid fa-pen-to-square"></i></button>
                          <button class="btn-md btn-red eliminarMedioPago"><i class="fa-solid fa-trash-can"></i></button>
                      </div>`
                  ]).draw(false); // draw(false) evita recargar toda la tabla
                }else{ //si es actualizar
                  /// actualizar el arregle de medios de pagos ///
                  mediospagos.forEach(a=>{if(a.id == unmediopago?.id)a = Object.assign(a, resultado.mediopago[0]);});
                  const datosActuales = (tablamediosPagos as any).row(indiceFila+=info.start).data();
                  /*MEDIO DE PAGO*/ datosActuales[1] = resultado.mediopago.mediopago;
                  /*ESTADO*/        datosActuales[2] = resultado.mediopago.estado == '1'?'Activo':'Inactivo';
                  (tablamediosPagos as any).row(indiceFila).data(datosActuales).draw();
                  (tablamediosPagos as any).page(info.page).draw('page'); //me mantiene la pagina actual
                }
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
    });


    ////////////////////  Eliminar medio de pago  //////////////////////
    function eliminarMedioPago(e:Event){
      let idmediopago = (e.target as HTMLElement).parentElement!.id, info = (tablamediosPagos as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idmediopago = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablamediosPagos as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar el medio de pago?',
          text: "El medio de pago sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idmediopago);
                  try {
                      const url = "/admin/api/eliminarMedioPago";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        (tablamediosPagos as any).row(indiceFila+info.start).remove().draw(); 
                        (tablamediosPagos as any).page(info.page).draw('page'); 
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

    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoMedioPago || (event.target as HTMLInputElement).value === 'Salir') {
          miDialogoMedioPago.close();
          document.removeEventListener("click", cerrarDialogoExterno);
          /*if((event.target as HTMLElement).closest('.finCerrarcaja')){  //Cuando se hace el cierre de caja
            confirmarcierre();
          }*/
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateCaja') as HTMLFormElement)?.reset();
    }
  }
})();