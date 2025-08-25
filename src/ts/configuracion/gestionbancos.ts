(():void=>{

  if(document.querySelector('.gestionbancos')){
    const crearBanco = document.querySelector('#crearBanco') as HTMLButtonElement;
    const miDialogoBanco = document.querySelector('#miDialogoBanco') as any;

    let indiceFila=0, control=0, tablaBancos:HTMLElement;

    type bancosapi = {
        id:string,
        nombre: string,
        numerocuenta: string,
        saldo: string,
        estado: string,
        created_at: string
      };
  
      let bancos:bancosapi[]=[], unbanco:bancosapi|undefined;
      (async ()=>{
        try {
            const url = "/admin/api/allbancos"; //llamado a la API REST y se trae todos los bancos
            const respuesta = await fetch(url); 
            bancos = await respuesta.json(); 
            console.log(bancos);
        } catch (error) {
            console.log(error);
        }
      })();

     //////////////////  TABLA //////////////////////
    tablaBancos = ($('#tablaBancos') as any).DataTable(configdatatables);

    crearBanco.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalBanco')!.textContent = "Crear banco";
        (document.querySelector('#btnEditarCrearBanco') as HTMLInputElement).value = "Crear";
        miDialogoBanco.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    document.querySelector('#tablaBancos')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if((e.target as HTMLElement)?.classList.contains("editarBanco")||(e.target as HTMLElement).parentElement?.classList.contains("editarBanco"))editarBanco(e);
      if(target?.classList.contains("eliminarBanco")||target.parentElement?.classList.contains("eliminarBanco"))eliminarBanco(e);
    });

    //////////////////// ventana modal al Actualizar/Editar banco  //////////////////////
    function editarBanco(e:Event){
      let idbanco = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement)?.tagName === 'I')idbanco = (e.target as HTMLElement).parentElement?.parentElement?.id;
      control = 1;
      document.querySelector('#modalBanco')!.textContent = "Actualizar banco";
      (document.querySelector('#btnEditarCrearBanco') as HTMLInputElement)!.value = "Actualizar";
      
      unbanco = bancos.find(x => x.id==idbanco); //me trae a la banco seleccionada
      (document.querySelector('#nombreBanco')as HTMLInputElement).value = unbanco?.nombre!;
      (document.querySelector('#numeroCuenta')as HTMLInputElement).value = unbanco?.numerocuenta!;
      
      indiceFila = (tablaBancos as any).row((e.target as HTMLElement).closest('tr')).index();
      miDialogoBanco.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    ////////////////////  Actualizar/Editar banco  //////////////////////
    document.querySelector('#formCrearUpdateBanco')?.addEventListener('submit', e=>{
      let urlApi = "crearBanco";
      if(control)urlApi = "actualizarBanco";

        e.preventDefault();
        var info = (tablaBancos as any).page.info();
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', unbanco?.id?unbanco?.id:'');
          datos.append('nombre', $('#nombreBanco').val()as string);
          datos.append('numerocuenta', $('#numeroCuenta').val()as string);
          try {
              const url = "/admin/api/"+urlApi;
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                miDialogoBanco.close();
                document.removeEventListener("click", cerrarDialogoExterno);
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                if(!control){ //si es crear registro
                  /// actualizar el arregle de la banco ///
                  bancos = [...bancos, resultado.banco];
                  (tablaBancos as any).row.add([
                      (tablaBancos as any).rows().count() + 1,
                      resultado.banco.nombre,
                      resultado.banco.numerocuenta,
                      resultado.banco.created_at,
                      `<div class="acciones-btns" id="${resultado.banco.id}" data-banco="${resultado.banco.nombre}">
                          <button class="btn-md btn-turquoise editarBanco"><i class="fa-solid fa-pen-to-square"></i></button>
                          <button class="btn-md btn-red eliminarBanco"><i class="fa-solid fa-trash-can"></i></button>
                      </div>`
                  ]).draw(false); // draw(false) evita recargar toda la tabla
                }else{ //si es actualizar
                  /// actualizar el arregle de bancos ///
                  bancos.forEach(a=>{if(a.id == unbanco?.id)a = Object.assign(a, resultado.banco[0]);});
                  const datosActuales = (tablaBancos as any).row(indiceFila+=info.start).data();
                  /*BANCO*/      datosActuales[1] = resultado.banco[0].nombre;
                  /*NUM CUENTA*/ datosActuales[2] = resultado.banco[0].numerocuenta;
                  (tablaBancos as any).row(indiceFila).data(datosActuales).draw();
                  (tablaBancos as any).page(info.page).draw('page'); //me mantiene la pagina actual
                }
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
    });


    ////////////////////  Eliminar banco  //////////////////////
    function eliminarBanco(e:Event){
      let idbanco = (e.target as HTMLElement).parentElement!.id, info = (tablaBancos as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idbanco = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablaBancos as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar la banco?',
          text: "La banco sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idbanco);
                  try {
                      const url = "/admin/api/eliminarBanco";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        (tablaBancos as any).row(indiceFila+info.start).remove().draw(); 
                        (tablaBancos as any).page(info.page).draw('page'); 
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
      if (event.target === miDialogoBanco || (event.target as HTMLInputElement).value === 'Salir') {
          miDialogoBanco.close();
          document.removeEventListener("click", cerrarDialogoExterno);
          /*if((event.target as HTMLElement).closest('.finCerrarbanco')){  //Cuando se hace el cierre de banco
            confirmarcierre();
          }*/
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateBanco') as HTMLFormElement)?.reset();
    }

  }

})();