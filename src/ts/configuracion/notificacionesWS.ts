(():void=>{
  if(document.querySelector('.configNotificationWS')){

    const nombreWS = document.querySelector('#nombreWS') as HTMLInputElement;
    const movilWS = document.querySelector('#movilWS') as HTMLInputElement;
    const tipoWS = document.querySelector('#tipoWS') as HTMLInputElement;
    const tablaNumbersWS = document.querySelector('#tablaNumbersWS tbody') as HTMLTableElement;
    let indiceFila=0, control=0;

    tablaNumbersWS?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("test"))sendTest(target.closest('tr')?.id);//console.log(target.closest('tr'));
      if(target?.classList.contains("eliminarContacto")||target.parentElement?.classList.contains("eliminarContacto"))deleteContactNotificationWS(e);
    });
    

    async function sendTest(id:string|undefined){
      try {
          const url = "/admin/api/ws/notificacionWS/sendTest?id="+id;
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          if(resultado && resultado.code === 200 && !resultado.error){
            msjalertToast('success', '¡Éxito!', 'Mensaje de prueba enviado');
          }else{
              msjalertToast('error', '¡Error!', 'Error al enviar el test');
          }
      } catch (error) {
          console.log(error)
      }
    }


    ////////////////////  Eliminar contacto de notificacion de whatsapp  //////////////////////
    function deleteContactNotificationWS(e:Event){
      const fila = (e.target as HTMLTableRowElement).closest('tr');
      if(!fila)return;

      indiceFila = Number(fila.id);
      if(!Number.isInteger(indiceFila))return;

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
                  datos.append('id', indiceFila+'');
                  try {
                      const url = "/admin/api/ws/notificacionWS/eliminarContacto?id="+indiceFila;
                      const respuesta = await fetch(url); 
                      const resultado = await respuesta.json(); 
                      if(resultado.exito !== undefined){
                        fila.remove();
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

    ////////////////////  Crear contacto para notificacion de whatsapp  //////////////////////
    document.querySelector('#formCreateContactNotifcationWs')?.addEventListener('submit', e=>{
        e.preventDefault();
        
        (async ()=>{ 
          const datos = new FormData();
          //datos.append('id', unacaja?.id?unacaja?.id:'');
          datos.append('nombre', nombreWS.value);
          datos.append('movil', movilWS.value);
          datos.append('tipo', tipoWS.value);
          try {
              const url = "/admin/api/ws/notificacionWS/crearContacto";
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                const tr = document.createElement('tr');
                tr.id = resultado.data[1];
                tr.insertAdjacentHTML('afterbegin', `
                  <td class="">${nombreWS.value}</td>
                  <td>${movilWS.value}</td>
                  <td>${ tipoWS.value}</td>
                  <td class=""><button class="test btn-xs btn-blueintense">Test</button></td>
                  <td><button id="" data-state="" class="btn-xs btn-lima">Activo</button></td>
                  <td class=""><button class="btn-md btn-red eliminarContacto" title="Eliminar contacto"><i class="fa-solid fa-trash-can"></i></button></td>`);
                tablaNumbersWS?.appendChild(tr);
                (document.querySelector('#formCreateContactNotifcationWs') as HTMLFormElement)?.reset();
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
    });



  }

})();