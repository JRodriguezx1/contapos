(():void=>{

  if(document.querySelector('.pedidosguardados')){

    let indiceFila=0, control=0, tablaPedidosGuardados:HTMLElement;
/*
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
            console.log(cajas);
        } catch (error) {
            console.log(error);
        }
      })();*/

     //////////////////  TABLA //////////////////////
    tablaPedidosGuardados = ($('#tablaPedidosGuardados') as any).DataTable(configdatatables);

    document.querySelector('#tablaPedidosGuardados')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("eliminarPedidoGuardado")||target.parentElement?.classList.contains("eliminarPedidoGuardado"))eliminarPedidoGuardado(e);
    });


    ////////////////////  Eliminar cotizacion por completo del sistema  //////////////////////
    function eliminarPedidoGuardado(e:Event){
      let idpedidoguardado = (e.target as HTMLElement).parentElement!.id, info = (tablaPedidosGuardados as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idpedidoguardado = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablaPedidosGuardados as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: `Desea eliminar la orden guardado #${idpedidoguardado}?`,
          text: "La orden/cotizacion guardado sera eliminado definitivamente del sistema.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idpedidoguardado);
                  try {
                      const url = "/admin/api/eliminarPedidoGuardado"; // llama controlador cajacontrolador.php
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        (tablaPedidosGuardados as any).row(indiceFila).remove().draw(); 
                        (tablaPedidosGuardados as any).page(info.page).draw('page'); 
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
      (document.querySelector('#formCrearUpdateCaja') as HTMLFormElement)?.reset();
    }

  }

})();