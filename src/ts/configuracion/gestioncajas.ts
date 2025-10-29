(():void=>{

  if(document.querySelector('.gestioncajas')){
    const crearCaja = document.querySelector('#crearCaja') as HTMLButtonElement;
    const miDialogoCaja = document.querySelector('#miDialogoCaja') as any;

    let indiceFila=0, control=0, tablaCajas:HTMLElement;

    type cajasapi = {
        id:string,
        idtipoconsecutivo: string,
        nombre: string,
        negocio: string
      };
  
      let cajas:cajasapi[]=[], unacaja:cajasapi|undefined;
      (async ()=>{
        try {
            const url = "/admin/api/allcajas"; //llamado a la API REST y se trae todos los productos
            const respuesta = await fetch(url); 
            cajas = await respuesta.json(); 
        } catch (error) {
            console.log(error);
        }
      })();

     //////////////////  TABLA //////////////////////
    tablaCajas = ($('#tablaCajas') as any).DataTable(configdatatables);

    crearCaja.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalCaja')!.textContent = "Crear caja";
        (document.querySelector('#btnEditarCrearCaja') as HTMLInputElement).value = "Crear";
        miDialogoCaja.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    document.querySelector('#tablaCajas')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if((e.target as HTMLElement)?.classList.contains("editarCaja")||(e.target as HTMLElement).parentElement?.classList.contains("editarCaja"))editarCaja(e);
      if(target?.classList.contains("eliminarCaja")||target.parentElement?.classList.contains("eliminarCaja"))eliminarCaja(e);
    });

    //////////////////// ventana modal al Actualizar/Editar caja  //////////////////////
    function editarCaja(e:Event){
      let idcaja = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement)?.tagName === 'I')idcaja = (e.target as HTMLElement).parentElement?.parentElement?.id;
      control = 1;
      document.querySelector('#modalCaja')!.textContent = "Actualizar caja";
      (document.querySelector('#btnEditarCrearCaja') as HTMLInputElement)!.value = "Actualizar";
      
      unacaja = cajas.find(x => x.id==idcaja); //me trae a la caja seleccionada
      (document.querySelector('#nombrecaja')as HTMLInputElement).value = unacaja?.nombre!;
      $('#idtipoconsecutivo').val(unacaja?.idtipoconsecutivo??'');
      $('#negociogestioncaja').val(1);
      
      indiceFila = (tablaCajas as any).row((e.target as HTMLElement).closest('tr')).index();
      miDialogoCaja.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    ////////////////////  Actualizar/Editar caja  //////////////////////
    document.querySelector('#formCrearUpdateCaja')?.addEventListener('submit', e=>{
      let urlApi = "crearCaja";
      if(control)urlApi = "actualizarCaja";

        e.preventDefault();
        var info = (tablaCajas as any).page.info();
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', unacaja?.id?unacaja?.id:'');
          datos.append('idtipoconsecutivo', $('#idtipoconsecutivo').val()as string);
          datos.append('nombre', $('#nombrecaja').val()as string);
          datos.append('negocio', $('#negociogestioncaja').val()as string);
          try {
              const url = "/admin/api/"+urlApi;
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                miDialogoCaja.close();
                document.removeEventListener("click", cerrarDialogoExterno);
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                if(!control){ //si es crear registro
                  /// actualizar el arregle de la caja ///
                  cajas = [...cajas, resultado.caja];
                  (tablaCajas as any).row.add([
                      (tablaCajas as any).rows().count() + 1,
                      resultado.caja.nombre,
                      resultado.caja.nombreconsecutivo.nombre,
                      resultado.caja.negocio,
                      `<div class="acciones-btns" id="${resultado.caja.id}" data-caja="${resultado.caja.nombre}">
                          <button class="btn-md btn-turquoise editarCaja"><i class="fa-solid fa-pen-to-square"></i></button>
                          <button class="btn-md btn-red eliminarCaja"><i class="fa-solid fa-trash-can"></i></button>
                      </div>`
                  ]).draw(false); // draw(false) evita recargar toda la tabla
                }else{ //si es actualizar
                  /// actualizar el arregle de cajas ///
                  cajas.forEach(a=>{if(a.id == unacaja?.id)a = Object.assign(a, resultado.caja[0]);});
                  const datosActuales = (tablaCajas as any).row(indiceFila+=info.start).data();
                  /*CAJA*/      datosActuales[1] = resultado.caja[0].nombre;
                  /*FACT AUTO*/ datosActuales[2] = $('#idtipoconsecutivo option:selected').text();
                  /*NEGOCIO*/   datosActuales[3] = $('#negociogestioncaja option:selected').text();
                  (tablaCajas as any).row(indiceFila).data(datosActuales).draw();
                  (tablaCajas as any).page(info.page).draw('page'); //me mantiene la pagina actual
                }
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
    });


    ////////////////////  Eliminar caja  //////////////////////
    function eliminarCaja(e:Event){
      let idcaja = (e.target as HTMLElement).parentElement!.id, info = (tablaCajas as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idcaja = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablaCajas as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar la caja?',
          text: "La caja sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idcaja);
                  try {
                      const url = "/admin/api/eliminarCaja";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        (tablaCajas as any).row(indiceFila+info.start).remove().draw(); 
                        (tablaCajas as any).page(info.page).draw('page'); 
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
      if (event.target === miDialogoCaja || (event.target as HTMLInputElement).value === 'Salir') {
          miDialogoCaja.close();
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