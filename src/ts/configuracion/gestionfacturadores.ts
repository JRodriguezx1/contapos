(():void=>{

  if(document.querySelector('.gestionfacturadores')){
    const POS = (window as any).POS;
    const crearFacturador = document.querySelector('#crearFacturador') as HTMLButtonElement;
    const miDialogoFacturador = document.querySelector('#miDialogoFacturador') as any;

    let indiceFila=0, control=0, tablaFacturadores:HTMLElement;

    type facturadoresapi = {
        id:string,
        id_sucursalid: string,
        idtipofacturador: string,
        idnegocio: string,
        nombre: string
        rangoinicial:string,
        rangofinal: string,
        siguientevalor: string,
        fechainicio: string
        fechafin:string,
        resolucion: string,
        consecutivoremplazo: string,
        prefijo: string,
        mostrarresolucion:string,
        mostrarimpuestodiscriminado: string,
        tokenfacturaelectronica: string,
        electronica: string,
        estado: string
      };
  
      let facturadores:facturadoresapi[]=[], unfacturador:facturadoresapi|undefined;

      function escapeHtmlFacturador(valor:any):string{
        return String(valor ?? '').replace(/[&<>"']/g, (caracter:string) => ({
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#039;'
        }[caracter] as string));
      }

      function nombreTipoFacturador(facturador:any):string{
        const tipo = facturador?.nombretipofacturador;
        return escapeHtmlFacturador(typeof tipo === 'object' ? tipo?.nombre : tipo);
      }

      function renderNombreFacturador(nombre:any):string{
        return `<span class="config-facturador-name">
          <span class="config-facturador-name__icon"><i class="fa-solid fa-receipt"></i></span>
          <span>${escapeHtmlFacturador(nombre)}</span>
        </span>`;
      }

      function renderPillFacturador(valor:any, modificador:string):string{
        return `<span class="config-table-pill config-table-pill--${modificador}">${escapeHtmlFacturador(valor)}</span>`;
      }

      function renderEstadoFacturador(estado:any):string{
        const activo = Number(estado) === 1;
        return `<span class="config-table-status ${activo ? 'config-table-status--active' : 'config-table-status--expired'}">${activo ? 'Activo' : 'Expirada'}</span>`;
      }

      function filaFacturador(numero:number, facturador:any):any[]{
        return [
          numero,
          renderNombreFacturador(facturador?.nombre),
          renderPillFacturador(nombreTipoFacturador(facturador), 'type'),
          renderPillFacturador(`${facturador?.rangoinicial ?? ''} - ${facturador?.rangofinal ?? ''}`, 'range'),
          renderPillFacturador(facturador?.siguientevalor, 'next'),
          renderPillFacturador(facturador?.fechafin, 'date'),
          renderEstadoFacturador(facturador?.estado),
          `<div class="acciones-btns" id="${escapeHtmlFacturador(facturador?.id)}" data-facturador="${escapeHtmlFacturador(facturador?.nombre)}">
              <button class="btn-md btn-turquoise editarFacturador"><i class="fa-solid fa-pen-to-square"></i></button>
              ${Number(facturador?.id) > 1 ? '<button class="btn-md btn-red eliminarFacturador"><i class="fa-solid fa-trash-can"></i></button>' : ''}
          </div>`
        ];
      }

      (async ()=>{
        try {
            const url = "/admin/api/allfacturadores"; //llamado a la API REST y se trae todos los consecutivos
            const respuesta = await fetch(url); 
            facturadores = await respuesta.json();
            POS.facturadores = facturadores;  //se expone globalmente para procesar en gestiondian.ts
        } catch (error) {
            console.log(error);
        }
      })();

    //////////////////  TABLA //////////////////////
  tablaFacturadores = ($('#tablaFacturadores') as any).DataTable(configdatatablesToolbar);
   modernizarToolbarDataTable('#tablaFacturadores');

    crearFacturador.addEventListener('click', ()=>{
        control = 0;
        limpiarformdialog();
        document.querySelector('#modalFacturador')!.textContent = "Crear facturador";
        (document.querySelector('#btnEditarCrearFacturador') as HTMLInputElement).value = "Crear";
        miDialogoFacturador.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
    });


    document.querySelector('#tablaFacturadores')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if((e.target as HTMLElement)?.classList.contains("editarFacturador")||(e.target as HTMLElement).parentElement?.classList.contains("editarFacturador"))editarFacturador(e);
      if(target?.classList.contains("eliminarFacturador")||target.parentElement?.classList.contains("eliminarFacturador"))eliminarFacturador(e);
    });

    //////////////////// ventana modal al Actualizar/Editar facturador  //////////////////////
    function editarFacturador(e:Event){
      let idfacturador = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement)?.tagName === 'I')idfacturador = (e.target as HTMLElement).parentElement?.parentElement?.id;
      control = 1;
      document.querySelector('#modalFacturador')!.textContent = "Actualizar facturador";
      (document.querySelector('#btnEditarCrearFacturador') as HTMLInputElement)!.value = "Actualizar";
      
      unfacturador = facturadores.find(x => x.id==idfacturador); //me trae el facturador seleccionado
      (document.querySelector('#nombrefacturador')as HTMLInputElement).value = unfacturador?.nombre!;
      $('#idtipofacturador').val(unfacturador?.idtipofacturador??'');
      $('#rangoinicial').val(unfacturador?.rangoinicial??'');
      $('#rangofinal').val(unfacturador?.rangofinal??'');
      $('#siguientevalor').val(unfacturador?.siguientevalor??'');
      $('#fechainicio').val(unfacturador?.fechainicio??'');
      $('#fechafin').val(unfacturador?.fechafin??'');
      $('#resolucion').val(unfacturador?.resolucion??'');
      $('#prefijo').val(unfacturador?.prefijo??'');
      $('#negociofacturador').val(1);
      
      indiceFila = (tablaFacturadores as any).row((e.target as HTMLElement).closest('tr')).index();
      miDialogoFacturador.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    ////////////////////  Actualizar/Editar facturador  //////////////////////
    document.querySelector('#formCrearUpdateFacturador')?.addEventListener('submit', e=>{
      let urlApi = "crearFacturador";
      if(control)urlApi = "actualizarFacturador";

        e.preventDefault();
        var info = (tablaFacturadores as any).page.info();
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', unfacturador?.id?unfacturador?.id:'');
          datos.append('idtipofacturador', $('#idtipofacturador').val()as string);
          datos.append('idnegocio', $('#negociofacturador').val()as string);
          datos.append('nombre', $('#nombrefacturador').val()as string);
          datos.append('rangoinicial', $('#rangoinicial').val()as string);
          datos.append('rangofinal', $('#rangofinal').val()as string);
          datos.append('siguientevalor', $('#siguientevalor').val()as string);
          datos.append('fechainicio', $('#fechainicio').val()as string);
          datos.append('fechafin', $('#fechafin').val()as string);
          datos.append('resolucion', $('#resolucion').val()as string);
          //datos.append('consecutivoremplazo', $('#negociofacturador').val()as string);
          datos.append('prefijo', $('#prefijo').val()as string);
          /*datos.append('mostrarresolucion', $('#negociofacturador').val()as string);
          datos.append('mostrarimpuestodiscriminado', $('#nombrefacturador').val()as string);
          datos.append('tokenfacturaelectronica', $('#negociofacturador').val()as string);
          datos.append('electronica', $('#negociofacturador').val()as string);
          datos.append('estado', $('#nombrefacturador').val()as string);*/
          try {
              const url = "/admin/api/"+urlApi;
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                miDialogoFacturador.close();
                document.removeEventListener("click", cerrarDialogoExterno);
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                if(!control){ //si es crear registro
                  /// actualizar el arregle del facturador///
                  facturadores = [...facturadores, resultado.facturador];
                  (tablaFacturadores as any).row.add(filaFacturador((tablaFacturadores as any).rows().count() + 1, resultado.facturador)).draw(false); // draw(false) evita recargar toda la tabla
                  crearConsecutivoGestionCaja(resultado.facturador.id, resultado.facturador.nombre);
                }else{ //si es actualizar
                  /// actualizar el arregle de facturadores ///
                  facturadores.forEach(a=>{if(a.id == unfacturador?.id)a = Object.assign(a, resultado.facturador[0]);});
                  indiceFila += info.start;
                  const datosActuales = (tablaFacturadores as any).row(indiceFila).data();
                  const filaActualizada = filaFacturador(datosActuales[0], resultado.facturador[0]);
                  (tablaFacturadores as any).row(indiceFila).data(filaActualizada).draw();
                  (tablaFacturadores as any).page(info.page).draw('page'); //me mantiene la pagina actual
                  actualizarConsecutivoGestionCaja(unfacturador!.id, resultado.facturador[0].nombre);
                }
              }else{
                miDialogoFacturador.close();
                document.removeEventListener("click", cerrarDialogoExterno);
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
    });


    ////////////////////  Eliminar facturador  //////////////////////
    function eliminarFacturador(e:Event){
      let idfacturador = (e.target as HTMLElement).parentElement!.id, info = (tablaFacturadores as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idfacturador = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablaFacturadores as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar el facturador?',
          text: "El facturador sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idfacturador);
                  try {
                      const url = "/admin/api/eliminarFacturador";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        (tablaFacturadores as any).row(indiceFila+info.start).remove().draw(); 
                        (tablaFacturadores as any).page(info.page).draw('page');
                        eliminardegestioncaja(idfacturador);
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

    function crearConsecutivoGestionCaja(idfacturador:string, nombre:string){
      const selectConsecutivoCaja = document.querySelector('#idtipoconsecutivo') as HTMLSelectElement;
      const option = document.createElement('option');
      option.value = idfacturador;
      option.textContent = nombre;
      selectConsecutivoCaja.appendChild(option);
    }

    function actualizarConsecutivoGestionCaja(idfacturador:string, nombre:string){
      const selectConsecutivoCaja = document.querySelector('#idtipoconsecutivo') as HTMLSelectElement;
      const opcionconsecutivo = selectConsecutivoCaja.querySelector(`option[value="${idfacturador}"]`) as HTMLOptionElement;
      opcionconsecutivo.textContent = nombre;
    }

    function eliminardegestioncaja(idfacturador:string){
      const selectConsecutivoCaja = document.querySelector('#idtipoconsecutivo') as HTMLSelectElement;
      const opcionconsecutivo = selectConsecutivoCaja.querySelector(`option[value="${idfacturador}"]`);
      opcionconsecutivo?.remove();
    }

    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoFacturador || (event.target as HTMLInputElement).value === 'Salir') {
          miDialogoFacturador.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      (document.querySelector('#formCrearUpdateFacturador') as HTMLFormElement)?.reset();
    }
  }
  
})();
