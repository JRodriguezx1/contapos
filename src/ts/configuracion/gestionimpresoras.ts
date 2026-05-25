(():void=>{

  if(document.querySelector('.gestionimpresoras')){
    const crearImpresora = document.querySelector('#crearImpresora') as HTMLButtonElement;
    const miDialogoIMpresora = document.querySelector('#miDialogoIMpresora') as any;

    let indiceFila=0, control=0, tablaImpresoras:HTMLElement;

    type printersApi = {
      id:string,
      nombre: string,
      nombrecompartido: string,
      estacion: string,
      estado: string,
      created_at: string
    };

    let impresoras:printersApi[]=[], unPrinter:printersApi|undefined;
    (async ()=>{
      try {
          const url = "/admin/api/allPrinters"; //llamado a la API REST y se trae todos las impresoras
          const respuesta = await fetch(url); 
          impresoras = await respuesta.json(); 
      } catch (error) {
          console.log(error);
      }
    })();

     //////////////////  TABLA //////////////////////
    tablaImpresoras = ($('#tablaImpresoras') as any).DataTable(configdatatables);

    crearImpresora.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalIMpresora')!.textContent = "Crear punto de impresora";
        (document.querySelector('#btnEditarCrearImpresora') as HTMLInputElement).value = "Crear";
        miDialogoIMpresora.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    document.querySelector('#tablaImpresoras')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if((e.target as HTMLElement)?.classList.contains("editarImpresora")||(e.target as HTMLElement).parentElement?.classList.contains("editarImpresora"))editarImpresora(e);
      if(target?.classList.contains("eliminarImpresora")||target.parentElement?.classList.contains("eliminarImpresora"))eliminarImpresora(e);
    });

    //////////////////// ventana modal al Actualizar/Editar impresora  //////////////////////
    function editarImpresora(e:Event){
      let idimpresora = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement)?.tagName === 'I')idimpresora = (e.target as HTMLElement).parentElement?.parentElement?.id;
      control = 1;
      document.querySelector('#modalIMpresora')!.textContent = "Actualizar punto de impresora";
      (document.querySelector('#btnEditarCrearImpresora') as HTMLInputElement)!.value = "Actualizar";
      
      unPrinter = impresoras.find(x => x.id==idimpresora); //me trae a lA impresora seleccionada
      (document.querySelector('#nombreImpresora')as HTMLInputElement).value = unPrinter?.nombre!;
      (document.querySelector('#nombreCompartido')as HTMLInputElement).value = unPrinter?.nombrecompartido!;
      (document.querySelector('#estacion')as HTMLInputElement).value = unPrinter?.estacion!;
      
      indiceFila = (tablaImpresoras as any).row((e.target as HTMLElement).closest('tr')).index();
      miDialogoIMpresora.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    ////////////////////  Actualizar/Editar impresora  //////////////////////
    document.querySelector('#formCrearUpdateIMpresora')?.addEventListener('submit', e=>{
      let urlApi = "crearImpresora";
      if(control)urlApi = "actualizarIMpresora";

        e.preventDefault();
        var info = (tablaImpresoras as any).page.info();
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', unPrinter?.id?unPrinter?.id:'');
          datos.append('nombre', $('#nombreIMpresora').val()as string);
          datos.append('nombrecompartido', $('#nombrecompartido').val()as string);
          datos.append('estacion', $('#estacion').val()as string);
          try {
              const url = "/admin/api/"+urlApi;
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                miDialogoIMpresora.close();
                document.removeEventListener("click", cerrarDialogoExterno);
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                if(!control){ //si es crear registro
                  /// actualizar el arregle de las impresoras ///
                  impresoras = [...impresoras, resultado.printer];
                  (tablaImpresoras as any).row.add([
                      (tablaImpresoras as any).rows().count() + 1,
                      resultado.printer.nombre,
                      resultado.printer.nombrecompartido,
                      resultado.printer.estacion,
                      resultado.printer.created_at,
                      `<div class="acciones-btns" id="${resultado.printer.id}">
                          <button class="btn-md btn-turquoise editarImpresora"><i class="fa-solid fa-pen-to-square"></i></button>
                          <button class="btn-md btn-red eliminarImpresora"><i class="fa-solid fa-trash-can"></i></button>
                      </div>`
                  ]).draw(false); // draw(false) evita recargar toda la tabla
                }else{ //si es actualizar
                  /// actualizar el arregle de impresoras ///
                  impresoras.forEach(a=>{if(a.id == unPrinter?.id)a = Object.assign(a, resultado.printer[0]);});
                  const datosActuales = (tablaImpresoras as any).row(indiceFila+=info.start).data();
                  /*NOMBRE*/      datosActuales[1] = resultado.printer[0].nombre;
                  /*NOMBRECOMPARTIDO*/ datosActuales[2] = resultado.printer[0].nombrecompartido;
                  /*ESTACION*/ datosActuales[3] = resultado.printer[0].estacion;
                  (tablaImpresoras as any).row(indiceFila).data(datosActuales).draw();
                  (tablaImpresoras as any).page(info.page).draw('page'); //me mantiene la pagina actual
                }
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
    });


    ////////////////////  Eliminar impresora  //////////////////////
    function eliminarImpresora(e:Event){
      let idimpresora = (e.target as HTMLElement).parentElement!.id, info = (tablaImpresoras as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idimpresora = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablaImpresoras as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar el impresora?',
          text: "El impresora sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idimpresora);
                  try {
                      const url = "/admin/api/eliminarImpresora";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        (tablaImpresoras as any).row(indiceFila+info.start).remove().draw(); 
                        (tablaImpresoras as any).page(info.page).draw('page'); 
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
      if (event.target === miDialogoIMpresora || (event.target as HTMLInputElement).value === 'Salir') {
          miDialogoIMpresora.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateIMpresora') as HTMLFormElement)?.reset();
    }

  }

})();