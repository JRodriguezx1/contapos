(()=>{
  if(document.querySelector('.trasladoinventario')){
    const crearProducto = document.querySelector('#crearProducto');
    const miDialogoDetalleTrasladoSolicitud = document.querySelector('#miDialogoDetalleTrasladoSolicitud') as any;
    const btnXCerrarModalproducto = document.querySelector('#btnXCerrarModalproducto') as HTMLButtonElement;
    const inputupImage = document.querySelector('#upImage') as HTMLInputElement;  //input para cargar el archivo imagen
    const btncustomUpImage = document.querySelector('#customUpImage');
    const imginputfile = document.querySelector('#imginputfile') as HTMLImageElement;  //img
    const tipoproducto = document.querySelector('#tipoproducto') as HTMLSelectElement;
    const contentnuevosprecios = document.querySelector('#contentnuevosprecios') as HTMLElement;
    

    type ordenestrasladosinv = {
      id:string,
      id_sucursalorigen: string,
      id_sucursaldestino: string,
      fkusuario: string,
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
      if(target?.classList.contains("detalle")||target.parentElement?.classList.contains("detalle"))detalle(e);
    });

    function detalle(e:Event){
      let idorden = (e.target as HTMLElement).parentElement?.id!;
      if((e.target as HTMLElement)?.tagName === 'I')idorden = (e.target as HTMLElement).parentElement?.parentElement?.id!;
      
      (async ()=>{
        try {
          const url = "/admin/api/idOrdenTrasladoSolicitudInv?id="+idorden; //llamado a la API REST y trae la orden trasladar/solicitud trasladarinvcontrolador.php
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          console.log(resultado);
        } catch (error) {
            console.log(error);
        }
      })();

      //unaorden = ordenes.find(x=>x.id === idorden)!; //obtengo el producto.
      miDialogoDetalleTrasladoSolicitud.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    

    

    
    function cerrarDialogoExterno(event:Event) {
      if (event.target === miDialogoDetalleTrasladoSolicitud || (event.target as HTMLInputElement).value === 'salir') {
        miDialogoDetalleTrasladoSolicitud.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
    }
  }

})();