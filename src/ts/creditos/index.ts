(()=>{
  if(document.querySelector('.creditos')){

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

    let printerBT:string = getParam.impresora_principal_de_CAJA_para_Android_por_BT.valor_final;
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
    let tablaCreditos = ($('#tablaCreditos') as any).DataTable({
      ...configdatatablesgenerico,
      dom: 'Brtip',
      buttons: [
        {extend: 'copyHtml5', className: 'creditos-export-button creditos-export-button--copy', text: '<span class="creditos-export-button__icon"><i class="fa-regular fa-copy"></i></span><span>Copiar</span>', title: 'creditos-y-separados'},
        {extend: 'excelHtml5', className: 'creditos-export-button creditos-export-button--excel', text: '<span class="creditos-export-button__icon"><i class="fa-regular fa-file-excel"></i></span><span>Excel</span>', title: 'creditos-y-separados'},
        {extend: 'csvHtml5', className: 'creditos-export-button creditos-export-button--csv', text: '<span class="creditos-export-button__icon"><i class="fa-solid fa-file-csv"></i></span><span>CSV</span>', title: 'creditos-y-separados'},
        {extend: 'pdfHtml5', className: 'creditos-export-button creditos-export-button--pdf', text: '<span class="creditos-export-button__icon"><i class="fa-regular fa-file-pdf"></i></span><span>PDF</span>', title: 'creditos-y-separados'},
        {extend: 'print', className: 'creditos-export-button creditos-export-button--print', text: '<span class="creditos-export-button__icon"><i class="fa-solid fa-print"></i></span><span>Imprimir</span>', title: 'creditos-y-separados'},
        {extend: 'colvis', className: 'creditos-export-button creditos-export-button--columns', text: '<span class="creditos-export-button__icon"><i class="fa-solid fa-table-columns"></i></span><span>Columnas</span>'}
      ],
      order: [[ 0, 'desc' ]]
    });
    modernizarToolbarDataTable('#tablaCreditos');
    modernizarBotonesExportacionCreditos(tablaCreditos);
    ocultarToolbarNativoCreditos();
    ($('#tablaCreditos') as any).on('draw.dt', ocultarToolbarNativoCreditos);


    //evento a la tabla
    document.querySelector('#tablaCreditos tbody')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if(target?.classList.contains("anularCredito")||(e.target as HTMLElement).parentElement?.classList.contains("anularCredito"))anularCredito(e);
      if(target?.classList.contains("printPOSSeparado"))printPOSSeparado(target.id);
    });


    function anularCredito(e:Event){
      let idcredito = (e.target as HTMLElement).parentElement?.id!, info = (tablaCreditos as any).page.info();
      if((e.target as HTMLElement)?.tagName === 'I')idcredito = (e.target as HTMLElement).parentElement?.parentElement?.id!;
      indiceFila = (tablaCreditos as any).row((e.target as HTMLElement).closest('tr')).index();
      
      Swal.fire({
          customClass: {
            popup: 'j2-confirm j2-confirm--danger',
            icon: 'j2-confirm__icon',
            title: 'j2-confirm__title',
            htmlContainer: 'j2-confirm__text',
            actions: 'j2-confirm__actions',
            confirmButton: 'j2-confirm__button j2-confirm__button--danger',
            cancelButton: 'j2-confirm__button j2-confirm__button--cancel'
          },
          buttonsStyling: false,
          icon: 'question',
          title: 'Desea anular el credito?',
          text: "El credito sera anulado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si, anular',
          cancelButtonText: 'Cancelar',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idcredito);
                  try {
                      const url = "/admin/api/anularSeparado";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();
                      if(resultado.exito !== undefined){
                        const datosActuales = (tablaCreditos as any).row(indiceFila).data();
                        datosActuales[9] = '<span class="creditos-status creditos-status--danger">Anulado</span>';
                        datosActuales[10] = `<div class="acciones-btns" id="${idcredito}"><a class="creditos-action creditos-action--detail" href="/admin/creditos/detallecredito?id=${idcredito}" title="Ver detalle del credito"><i class="fa-solid fa-chart-simple"></i></a></div>`;
                        (tablaCreditos as any).row(indiceFila).data(datosActuales).draw();
                        (tablaCreditos as any).page(info.page).draw('page'); 
                        Swal.fire({
                          customClass: {
                            popup: 'j2-confirm j2-confirm--success',
                            icon: 'j2-confirm__icon',
                            title: 'j2-confirm__title',
                            htmlContainer: 'j2-confirm__text',
                            actions: 'j2-confirm__actions j2-confirm__actions--single',
                            confirmButton: 'j2-confirm__button j2-confirm__button--confirm'
                          },
                          buttonsStyling: false,
                          icon: 'success',
                          title: 'Credito anulado',
                          text: resultado.exito[0],
                          confirmButtonText: 'OK'
                        });
                      }else{
                          Swal.fire({
                            customClass: {
                              popup: 'j2-confirm j2-confirm--danger',
                              icon: 'j2-confirm__icon',
                              title: 'j2-confirm__title',
                              htmlContainer: 'j2-confirm__text',
                              actions: 'j2-confirm__actions j2-confirm__actions--single',
                              confirmButton: 'j2-confirm__button j2-confirm__button--danger'
                            },
                            buttonsStyling: false,
                            icon: 'error',
                            title: 'No se pudo anular',
                            text: resultado.error[0],
                            confirmButtonText: 'OK'
                          });
                      }
                  } catch (error) {
                      console.log(error);
                      Swal.fire({
                        customClass: {
                          popup: 'j2-confirm j2-confirm--danger',
                          icon: 'j2-confirm__icon',
                          title: 'j2-confirm__title',
                          htmlContainer: 'j2-confirm__text',
                          actions: 'j2-confirm__actions j2-confirm__actions--single',
                          confirmButton: 'j2-confirm__button j2-confirm__button--danger'
                        },
                        buttonsStyling: false,
                        icon: 'error',
                        title: 'No se pudo anular',
                        text: 'Intenta nuevamente o revisa la conexion.',
                        confirmButtonText: 'OK'
                      });
                  }
              })();//cierre de async()
          }
      });
    }

    function ocultarToolbarNativoCreditos():void{
      const wrapper = document.querySelector('#tablaCreditos_wrapper');
      wrapper?.querySelectorAll('.dataTables_length, .dataTables_filter').forEach((control)=>{
        (control as HTMLElement).remove();
      });
    }

    function modernizarBotonesExportacionCreditos(dataTable:any):void{
      const wrapper = document.querySelector('#tablaCreditos_wrapper') as HTMLElement|null;
      const botonesNativos = wrapper?.querySelector('.dt-buttons') as HTMLElement|null;
      if(!wrapper || !botonesNativos || wrapper.querySelector('.creditos-export-toolbar'))return;

      botonesNativos.classList.add('creditos-native-export-buttons');
      botonesNativos.style.display = 'none';
      botonesNativos.setAttribute('aria-hidden', 'true');

      const acciones = [
        {indice: 0, clase: 'copy', icono: 'fa-regular fa-copy', texto: 'Copiar'},
        {indice: 1, clase: 'excel', icono: 'fa-regular fa-file-excel', texto: 'Excel'},
        {indice: 2, clase: 'csv', icono: 'fa-solid fa-file-csv', texto: 'CSV'},
        {indice: 3, clase: 'pdf', icono: 'fa-regular fa-file-pdf', texto: 'PDF'},
        {indice: 4, clase: 'print', icono: 'fa-solid fa-print', texto: 'Imprimir'},
        {indice: 5, clase: 'columns', icono: 'fa-solid fa-table-columns', texto: 'Columnas'}
      ];

      const toolbar = document.createElement('div');
      toolbar.className = 'creditos-export-toolbar';
      toolbar.innerHTML = `
        <div class="creditos-export-menu">
          <button type="button" class="creditos-export-trigger" aria-expanded="false">
            <span><i class="fa-solid fa-download"></i></span>
            Exportar
            <i class="fa-solid fa-chevron-down"></i>
          </button>
          <div class="creditos-export-menu__list">
          ${acciones.map((accion)=>`
            <button type="button" class="creditos-export-chip creditos-export-chip--${accion.clase}" data-export-index="${accion.indice}">
              <span class="creditos-export-chip__icon"><i class="${accion.icono}"></i></span>
              <span>${accion.texto}</span>
            </button>
          `).join('')}
          </div>
        </div>
      `;

      botonesNativos.insertAdjacentElement('beforebegin', toolbar);
      const trigger = toolbar.querySelector('.creditos-export-trigger') as HTMLButtonElement|null;
      const menu = toolbar.querySelector('.creditos-export-menu') as HTMLElement|null;

      trigger?.addEventListener('click', (event)=>{
        event.stopPropagation();
        const abierto = menu?.classList.toggle('is-open') ?? false;
        trigger.setAttribute('aria-expanded', abierto ? 'true' : 'false');
      });

      document.addEventListener('click', ()=>{
        menu?.classList.remove('is-open');
        trigger?.setAttribute('aria-expanded', 'false');
      });

      toolbar.querySelectorAll('[data-export-index]').forEach((boton)=>{
        boton.addEventListener('click', (event)=>{
          event.stopPropagation();
          dataTable.button(Number((boton as HTMLElement).dataset.exportIndex)).trigger();
          menu?.classList.remove('is-open');
          trigger?.setAttribute('aria-expanded', 'false');
        });
      });
    }


    async function printPOSSeparado(idcredito:string){
      //printTicketPOS(resultado.idfactura, resultado.dataInvoice);

      try{
        const url = "/admin/api/getCreditoSeparado?id="+idcredito; //llamado a la API REST - creditocontrolador 
        const respuesta = await fetch(url); 
        const resultado = await respuesta.json();
        const isAndroid = /Android/i.test(navigator.userAgent);
        if(printerBT === '1'){
          const builder = new ticketCreditoSeparadoBuilder(resultado);
          const ticket = await builder.generate(true); //true para version buffer bytes
          const base64 = bytesToBase64(ticket);
          if(isAndroid)window.location.href = `rawbt:base64,${base64}`;
          //descargar .bin a equipo
          /*const blob = new Blob([ticket], { type: 'application/octet-stream' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'ticket.bin';
          a.click();
          URL.revokeObjectURL(url);*/
        }
        //window.open("/admin/printPDFPOS?id=" + idfactura, "_blank");  //controlador printcontrolador
      }catch(error){
        console.log(error);
      }

      if(!isNaN(Number(idcredito)))
        window.open("/admin/printPDFPOSSeparado?id=" + idcredito, "_blank"); //controlador printcontrolador
    }

    
    async function printTicketPOS(idfactura:string, datainvoice:DataInvoice){
      
      /*try {
        const url = "http://localhost:3100/api/printPOS/ticket1/CAJA"; //llamado a la API REST apidiancontrolador.php
        const respuesta = await fetch(url, {
          method: 'POST',
          headers: { "Accept": "application/json", "Content-Type": "application/json" },
          body: JSON.stringify(datainvoice)
        });
        const resultado = await respuesta.json();
        console.log(resultado);
      } catch (error) {
        console.log(error);
      }*/
    }

  }

})();
