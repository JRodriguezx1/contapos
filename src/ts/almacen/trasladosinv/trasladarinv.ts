(()=>{
  if(document.querySelector('.trasladoinventario')){
    const miDialogoDetalleTrasladoSolicitud = document.querySelector('#miDialogoDetalleTrasladoSolicitud') as any;
    const btnXCerrarDetalleTrasladoSolicitud = document.querySelector('#btnXCerrarDetalleTrasladoSolicitud') as HTMLButtonElement;
    const parrafoSedeorigen = document.querySelector('#sedeorigen') as HTMLParagraphElement;
    const parrafoSededestino = document.querySelector('#sededestino') as HTMLParagraphElement;
    const parrafotipo = document.querySelector('#tipo') as HTMLParagraphElement;
    const tbodydetalleorden = document.querySelector('#tabladetalleorden tbody') as HTMLTableElement;

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


    function enviar(e:Event){
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
              Swal.fire('orden procesada', '', 'success') 
              /*const idsucursalorigen = document.querySelector('#sucursalorigen') as HTMLSelectElement;
              const sucursaldestino = document.querySelector('#sucursaldestino') as HTMLSelectElement;
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('idsucursalorigen', idsucursalorigen.value);
                  datos.append('idsucursaldestino', sucursaldestino.value);
                  datos.append('productos', JSON.stringify(carrito));
                  try {
                      const url = "/admin/api/apinuevotrasladoinv";  //api llamada a trasladosinvcontrolador
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                          setTimeout(() => {
                              window.location.href = `/admin/almacen/trasladarinventario`;
                          }, 1100);
                          Swal.fire(resultado.exito[0], '', 'success') 
                      }else{
                          Swal.fire(resultado.error[0], '', 'error')
                      }
                  } catch (error) {
                      console.log(error);
                  }
              })();//cierre de async()
              */
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
              Swal.fire('orden procesada', '', 'success') 
              /*const idsucursalorigen = document.querySelector('#sucursalorigen') as HTMLSelectElement;
              const sucursaldestino = document.querySelector('#sucursaldestino') as HTMLSelectElement;
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('idsucursalorigen', idsucursalorigen.value);
                  datos.append('idsucursaldestino', sucursaldestino.value);
                  datos.append('productos', JSON.stringify(carrito));
                  try {
                      const url = "/admin/api/apinuevotrasladoinv";  //api llamada a trasladosinvcontrolador
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                          setTimeout(() => {
                              window.location.href = `/admin/almacen/trasladarinventario`;
                          }, 1100);
                          Swal.fire(resultado.exito[0], '', 'success') 
                      }else{
                          Swal.fire(resultado.error[0], '', 'error')
                      }
                  } catch (error) {
                      console.log(error);
                  }
              })();//cierre de async()
              */
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