(()=>{
  if(document.querySelector('.trasladoinventario')){
    const miDialogoDetalleTrasladoSolicitud = document.querySelector('#miDialogoDetalleTrasladoSolicitud') as any;
    const btnXCerrarDetalleTrasladoSolicitud = document.querySelector('#btnXCerrarDetalleTrasladoSolicitud') as HTMLButtonElement;
    const parrafoSedeorigen = document.querySelector('#sedeorigen') as HTMLParagraphElement;
    const parrafoSededestino = document.querySelector('#sededestino') as HTMLParagraphElement;
    const parrafotipo = document.querySelector('#tipo') as HTMLParagraphElement;
    const tbodydetalleorden = document.querySelector('#tabladetalleorden tbody') as HTMLTableElement;
    const filtroSucursal = document.getElementById('filtroSucursal') as HTMLSelectElement;
    const filtroEstado = document.getElementById('filtroEstados') as HTMLSelectElement;
    const filas = document.querySelectorAll<HTMLTableRowElement>('#tablaTraslados tbody tr');

    type ordenestrasladosinv = {
      id:string,
      id_sucursalorigen: string,
      id_sucursaldestino: string,
      fkusuario: string,
      sucursal_origen:string,
      sucursal_destino:string,
      nombreusuario:string,
      tipo: string,
      observacion: string,
      estado: string,
      created_at: string,
      detalletrasladoinv: {id:string, id_trasladoinv:string, fkproducto:string, idsubproducto_id:string, nombre:string, cantidad:string, cantidadrecibida:string, cantidadrechazada:string}[]
    };

    let ordenes:ordenestrasladosinv[]=[], unaorden:ordenestrasladosinv;

    /*(async ()=>{
      try {
          const url = "/admin/api/allordenestrasladoinv"; //llamado a la API REST y se trae todos los productos
          const respuesta = await fetch(url); 
          ordenes = await respuesta.json(); 
          console.log(ordenes);
      } catch (error) {
          console.log(error);
      }
    })();*/

    const divAlert = document.querySelector('.divmsjalerta0') as HTMLElement;
    if(divAlert)borrarMsjAlert(divAlert);


    //evento a la tabla
    document.querySelector('#tablaTraslados')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("enviar")||target.parentElement?.classList.contains("enviar"))enviar(e);
      if(target?.classList.contains("detalle")||target.parentElement?.classList.contains("detalle"))detalle(e);
      if(target?.classList.contains("cancelar")||target.parentElement?.classList.contains("cancelar"))cancelar(e);
    });


    ////// cuando se envia a pasa a estado en transito
    function enviar(e:Event){
      let idorden = (e.target as HTMLElement).parentElement?.id!;
      if((e.target as HTMLElement)?.tagName === 'I')idorden = (e.target as HTMLElement).parentElement?.parentElement?.id!;
      
      const tr = (e.target as HTMLElement).closest('tr') as HTMLTableRowElement;
      
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea confirmar el envio de mercancia?',
          text: "La orden entrara en estado: 'EN TRANSITO' y sera aceptada o rechazda por la sede de destino.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              //Swal.fire('orden procesada', '', 'success') 
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idorden);
                  try {
                      const url = "/admin/api/confirmarnuevotrasladoinv";  //api llamada a trasladosinvcontrolador para confirmar envio, pasa a estado en transito
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        tr.children[5].innerHTML = `<span class="px-3 py-1 text-base font-semibold rounded-full bg-yellow-100 text-yellow-700">entransito</span>`;
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

    function detalle(e:Event){
      let idorden = (e.target as HTMLElement).parentElement?.id!;
      if((e.target as HTMLElement)?.tagName === 'I')idorden = (e.target as HTMLElement).parentElement?.parentElement?.id!;  
      (async ()=>{
        try {
          const url = "/admin/api/idOrdenTrasladoSolicitudInv?id="+idorden; //llamado a la API REST y trae el detalle de la orden trasladar/solicitud desde trasladarinvcontrolador.php
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          imprimirdatos(resultado.orden[0]);
        } catch (error) {
            console.log(error);
        }
      })();

      //unaorden = ordenes.find(x=>x.id === idorden)!; //obtengo el producto.
      miDialogoDetalleTrasladoSolicitud.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }


    function cancelar(e:Event){
      let idorden = (e.target as HTMLElement).parentElement?.id!;
      if((e.target as HTMLElement)?.tagName === 'I')idorden = (e.target as HTMLElement).parentElement?.parentElement?.id!;
      const tr = (e.target as HTMLElement).closest('tr') as HTMLTableRowElement;
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea anular la orden de envio de mercancia?',
          text: "La orden y sus productos seran cancelados por completo y no se enviara.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idorden);
                  try {
                      const url = "/admin/api/anularnuevotrasladoinv";  //api llamada a trasladosinvcontrolador para anular envio, pasa a estado en transito
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                          tr.remove();
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

    function imprimirdatos(detalleorden:ordenestrasladosinv){
      parrafoSedeorigen.textContent = detalleorden.sucursal_origen;
      parrafoSededestino.textContent = detalleorden.sucursal_destino;
      parrafotipo.textContent = detalleorden.tipo;
      while(tbodydetalleorden.firstChild)tbodydetalleorden.removeChild(tbodydetalleorden.firstChild);
      detalleorden.detalletrasladoinv.forEach(x=>{
        const tr = document.createElement('tr');
        const tdproducto = document.createElement('td');
        tdproducto.classList.add('px-4', 'py-2', 'border');
        tdproducto.textContent = x.nombre;
        const tdcantidad = document.createElement('td');
        tdcantidad.classList.add('px-4', 'py-2', 'border');
        tdcantidad.textContent = x.cantidad;
        tr.appendChild(tdproducto);
        tr.appendChild(tdcantidad);
        tbodydetalleorden.appendChild(tr);
      });
    }

    filtroSucursal.addEventListener('change', filtrarTabla);
    filtroEstado.addEventListener('change', filtrarTabla);

    function filtrarTabla() {
      const sucursal:string = filtroSucursal.value.trim().toLowerCase();
      const estado:string = filtroEstado.value.trim().toLowerCase();
      
      filas.forEach(fila => {
        const textoSucursal:string = fila.cells[1].textContent!.trim().toLowerCase();
        const textoEstado:string = fila.cells[5].textContent!.trim().toLowerCase();
        const coincideSucursal = !sucursal || textoSucursal === sucursal;
        const coincideEstado = !estado || textoEstado === estado;
        fila.style.display = (coincideSucursal && coincideEstado) ? '' : 'none';
      });
    }

    
    function cerrarDialogoExterno(event:Event) {
      const target = event.target;
       const btnxcerrardetalleorden = (target as HTMLElement).parentElement?.id;
      if (target === miDialogoDetalleTrasladoSolicitud || (target as HTMLInputElement).value === 'salir' || btnxcerrardetalleorden == 'btnXCerrarDetalleTrasladoSolicitud' || target == btnXCerrarDetalleTrasladoSolicitud) {
        miDialogoDetalleTrasladoSolicitud.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }
  }

})();