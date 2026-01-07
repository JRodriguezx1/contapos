(()=>{
  if(document.querySelector('.creditos')){

    //const POS = (window as any).POS;
     
    //const btnCrearCredito = document.querySelector('#btnCrearCredito') as HTMLButtonElement;
    const btnXCerrarModalCredito = document.querySelector('#btnXCerrarModalCredito') as HTMLButtonElement;
    const miDialogoCredito = document.querySelector('#miDialogoCredito') as any;
    //let tablaCreditos = document.querySelector('#tablaCreditos tbody');

    type creditsapi = {
      id:string,
      id_fksucursal: string,
      factura_id: string,
      cliente_id: string,
      nombrecliente: string,
      capital: string,
      abonoinicial: string,
      saldopendiente: string,
      numcuota: string,
      cantidadcuotas: string,
      montocuota: string,
      frecuenciapago: string,
      fechainicio: string,
      interes: string,
      interesxcuota: string,
      interestotal: string,
      valorinteresxcuota: string,
      valorinterestotal: string,
      montototal: string,
      fechavencimiento: string,
      productoentregado: string,
      estado: string,
      created_at: string,
    };
    
    /*interface Item {
      id_impuesto: number,
      facturaid: number,
      basegravable: number,
      valorimpuesto: number
    }
    let factimpuestos:Item[] = [];*/

    let credits:creditsapi[]=[], uncredito:creditsapi;
    let indiceFila=0, control=0;


    /*(async ()=>{
      try {
          const url = "/admin/api/allcredits"; //llamado a la API REST y se trae todos los productos
          const respuesta = await fetch(url); 
          credits = await respuesta.json(); 
          console.log(credits);
      } catch (error) {
          console.log(error);
      }
    })();*/





    
    //////////////////  TABLA //////////////////////
    let tablaCreditos = ($('#tablaCreditos') as any).DataTable(configdatatablesgenerico);


    //evento a la tabla
    document.querySelector('#tablaCreditos tbody')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("anularCredito")||(e.target as HTMLElement).parentElement?.classList.contains("anularCredito"))anularCredito(e);
      //if(target?.classList.contains("bloquearProductos")||target.parentElement?.classList.contains("bloquearProductos"))bloquearProductos(e);
      //if(target?.classList.contains("eliminarProductos")||target.parentElement?.classList.contains("eliminarProductos"))eliminarProductos(e);
    });


    function anularCredito(e:Event){
      let idcredito = (e.target as HTMLElement).parentElement?.id!, info = (tablaCreditos as any).page.info();
      if((e.target as HTMLElement)?.tagName === 'I')idcredito = (e.target as HTMLElement).parentElement?.parentElement?.id!;
      indiceFila = (tablaCreditos as any).row((e.target as HTMLElement).closest('tr')).index();
      
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar el credito',
          text: "El credito, seran anulado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idcredito);
                  try {
                      const url = "/admin/api/anularCredito";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();
                      if(resultado.exito !== undefined){
                        const datosActuales = (tablaCreditos as any).row(indiceFila).data();
                        datosActuales[10] = 'Anulado';
                        datosActuales[11] = `<a class="btn-xs btn-bluedark" href="/admin/creditos/detallecredito?id=${idcredito}" title="Ver estadisticas del cliente"><i class="fa-solid fa-chart-simple"></i></a>`;
                        (tablaCreditos as any).row(indiceFila).data(datosActuales).draw();
                        (tablaCreditos as any).page(info.page).draw('page'); 
                        Swal.fire(resultado.exito[0], '', 'success');
                      }else{
                          Swal.fire(resultado.error[0], '', 'error');
                      }
                  } catch (error) {
                      console.log(error);
                  }
              })();//cierre de async()
          }
      });
    }


  }

})();