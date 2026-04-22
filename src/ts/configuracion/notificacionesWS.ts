(():void=>{
  if(document.querySelector('.configNotificationWS')){

    const nombreWS = document.querySelector('#nombreWS') as HTMLInputElement;
    const movilWS = document.querySelector('#movilWS') as HTMLInputElement;
    const tipoWS = document.querySelector('#tipoWS') as HTMLInputElement;
    let indiceFila=0, control=0, tablaNmbersWS:HTMLElement;

    document.querySelector('#tablaNmbersWS')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("deleteContactNotificationWS")||target.parentElement?.classList.contains("deleteContactNotificationWS"))deleteContactNotificationWS(e);
    });
    

    ////////////////////  Crear contacto para notificacion de whatsapp  //////////////////////
    document.querySelector('#createContactNotifcationWs')?.addEventListener('submit', e=>{

        e.preventDefault();
        
        (async ()=>{ 
          const datos = new FormData();
          //datos.append('id', unacaja?.id?unacaja?.id:'');
          datos.append('nombre', nombreWS.value);
          datos.append('movil', movilWS.value);
          datos.append('tipo', tipoWS.value);
          try {
              const url = "/admin/api/notificacionWS/crearContacto";
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                
                      /*`<div class="acciones-btns" id="${resultado.caja.id}" data-caja="${resultado.caja.nombre}">
                          <button class="btn-md btn-turquoise editarCaja"><i class="fa-solid fa-pen-to-square"></i></button>
                          <button class="btn-md btn-red deleteContactNotificationWS"><i class="fa-solid fa-trash-can"></i></button>
                      </div>`*/
                
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
    });


    ////////////////////  Eliminar contacto de notificacion de whatsapp  //////////////////////
    function deleteContactNotificationWS(e:Event){
      let idcontact = (e.target as HTMLElement).parentElement!.id, info = (tablaNmbersWS as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idcontact = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablaNmbersWS as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar contacto?',
          text: "El contacto de notificacion de whatsapp sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idcontact);
                  try {
                      const url = "/admin/api/notificacionWS/eliminarContacto?id="+idcontact;
                      const respuesta = await fetch(url); 
                      const resultado = await respuesta.json(); 
                      if(resultado.exito !== undefined){
                        (tablaNmbersWS as any).row(indiceFila+info.start).remove().draw(); 
                        (tablaNmbersWS as any).page(info.page).draw('page'); 
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
      (document.querySelector('#createContactNotifcationWs') as HTMLFormElement)?.reset();
    }

  }

})();