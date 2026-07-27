///////////////////// OBJETO DE CONFIGURACION DEL PLUGIN DATATABLES /////////////////////
const configdatatables = {
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  language: {
      search: 'Busqueda',
      emptyTable: 'No Hay datos disponibles',
      zeroRecords:    "No se encontraron registros coincidentes",
      lengthMenu: '_MENU_ Entradas por pagina',
      info: 'Mostrando pagina _PAGE_ de _PAGES_',
      infoEmpty: 'No hay entradas a mostrar',
      infoFiltered: ' (filtrado desde _MAX_ registros)',
      paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
  }
}

///////////////////// OBJETO DE CONFIGURACION DEL PLUGIN DATATABLES PARA 25 REGISTROS /////////////////////
const configdatatables25reg = {
  pageLength: 25,
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  language: {
      search: 'Busqueda',
      emptyTable: 'No Hay datos disponibles',
      zeroRecords:    "No se encontraron registros coincidentes",
      lengthMenu: '_MENU_ Entradas por pagina',
      info: 'Mostrando pagina _PAGE_ de _PAGES_',
      infoEmpty: 'No hay entradas a mostrar',
      infoFiltered: ' (filtrado desde _MAX_ registros)',
      paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
  }
}

///////////////////// OBJETO DE CONFIGURACION DEL PLUGIN DATATABLES PARA GENERAL /////////////////////
const configdatatablesgenerico = {
  layout: {
        topStart: {
            buttons: [
              {extend: 'copyHtml5', text: 'Copia'}, 
              {extend: 'excelHtml5', title: 'informe'}, 
              {extend: 'csvHtml5', title: 'informe'}, 
              {extend: 'pdfHtml5', title: 'informe'}, 
              {extend: 'print', title: 'informe', text: 'Imprimir'},
              'colvis'
            ],
            pageLength: 'pageLength'
        }
  },
  pageLength: 25,
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  language: {
      search: 'Busqueda',
      emptyTable: 'No Hay datos disponibles',
      zeroRecords:    "No se encontraron registros coincidentes",
      lengthMenu: '_MENU_ Entradas por pagina',
      info: 'Mostrando pagina _PAGE_ de _PAGES_',
      infoEmpty: 'No hay entradas a mostrar',
      infoFiltered: ' (filtrado desde _MAX_ registros)',
      paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
  }
}

///////////////////// OBJETO DE CONFIGURACION DEL PLUGIN DATATABLES PARA STOCK RAPIDO /////////////////////
const configdatatablesstockrapido = {
  layout: {
        topStart: {
            buttons: [
              {extend: 'copyHtml5', text: 'Copia'}, 
              {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4, 5]}, title: 'Stock-inventario'}, 
              {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4, 5]}, title: 'Stock-inventario'}, 
              {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4, 5]}, title: 'Stock-inventario'}, 
              {extend: 'print', exportOptions: {columns: [1, 3, 4]}, title: 'Stock-inventario', text: 'Imprimir'},
              'colvis'
            ],
            pageLength: 'pageLength'
        }
  },
  pageLength: 25,
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  language: {
      search: 'Busqueda',
      emptyTable: 'No Hay datos disponibles',
      zeroRecords:    "No se encontraron registros coincidentes",
      lengthMenu: '_MENU_ Entradas por pagina',
      info: 'Mostrando pagina _PAGE_ de _PAGES_',
      infoEmpty: 'No hay entradas a mostrar',
      infoFiltered: ' (filtrado desde _MAX_ registros)',
      paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
  }
}

///////////////////// OBJETO DE CONFIGURACION DEL PLUGIN DATATABLES PARA AJUSTAR COSTOS /////////////////////
const configdatatablesajustarcostos = {
  layout: {
        topStart: {
            buttons: [
              {extend: 'copyHtml5', text: 'Copia'}, 
              {extend: 'excelHtml5', exportOptions: {columns: [1, 3, 4, 5, 6]}, title: 'costo por producto'}, 
              {extend: 'csvHtml5', exportOptions: {columns: [1, 3, 4, 5, 6]}, title: 'costo por producto'}, 
              {extend: 'pdfHtml5', exportOptions: {columns: [1, 3, 4, 5, 6]}, title: 'costo por producto'}, 
              {extend: 'print', exportOptions: {columns: [1, 3, 4, 5, 6]}, title: 'costo por producto', text: 'Imprimir'},
              'colvis'
            ],
            pageLength: 'pageLength'
        }
  },
  pageLength: 25,
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  language: {
      search: 'Busqueda',
      emptyTable: 'No Hay datos disponibles',
      zeroRecords:    "No se encontraron registros coincidentes",
      lengthMenu: '_MENU_ Entradas por pagina',
      info: 'Mostrando pagina _PAGE_ de _PAGES_',
      infoEmpty: 'No hay entradas a mostrar',
      infoFiltered: ' (filtrado desde _MAX_ registros)',
      paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
  }
}

///////////////////// CONFIGURACION DEL PLUGIN DATATABLES PARA CAJA/////////////////////
const configdatatablescaja = {
  "paging": false,
  "order": [[ 4, 'desc' ]],
  "searching": false,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  language: {
      search: 'Busqueda',
      emptyTable: 'No Hay datos disponibles',
      zeroRecords:    "No se encontraron registros coincidentes",
      lengthMenu: '_MENU_ Entradas por pagina',
      info: 'Mostrando 1 de _MAX_ registros',
      infoEmpty: 'No hay entradas a mostrar',
      infoFiltered: ' (filtrado desde _MAX_ registros)',
      paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
  }
}


///////////////////// CONFIGURACION DEL PLUGIN DATATABLES PARA STOCK BAJO/////////////////////
const configdatatablesstockbajo = {
  destroy: true,
  lengthChange: false,
  pageLength: 25,
  //responsive: true,
  order: [[ 3, 'asc' ]],
  language: {
      search: 'Busqueda',
      emptyTable: 'No Hay datos disponibles',
      zeroRecords:    "No se encontraron registros coincidentes",
      info: 'Mostrando pagina _PAGE_ de _PAGES_',
      infoEmpty: 'No hay entradas a mostrar',
      infoFiltered: ' (filtrado desde _MAX_ registros)',
      paginate: {"first": "<<", "last": ">>", "next": ">", "previous": "<"}
  },
  layout: {
      topStart: {
          buttons: [
              {extend: 'excelHtml5', title: 'Stock bajo'},  
              {extend: 'pdfHtml5', title: 'Stock bajo'}, 
              {extend: 'print', title: 'Stock bajo', text: 'Imprimir'},
              'colvis'
          ],
          pageLength: 'pageLength'
      }
  }
}


const configdatatablesToolbar = {
  ...configdatatables,
  dom: 'rtip'
}

function modernizarToolbarDataTable(selectorTabla:string):void{
  const montarToolbar = ():void => {
    const idTabla = selectorTabla.replace('#', '');
    const wrapper = document.querySelector(`#${idTabla}_wrapper`) as HTMLElement|null;
    const tabla = document.querySelector(selectorTabla) as HTMLTableElement|null;
    const card = wrapper?.closest('.config-table-card') as HTMLElement|null;
    const ocultarControlesNativos = ():void => {
      card?.querySelectorAll('.dataTables_length, .dataTables_filter').forEach((control)=>{
        (control as HTMLElement).remove();
      });
    };

    if(!wrapper || !tabla || !card)return;
    if(card.querySelector('.config-datatable-custom-toolbar')){
      ocultarControlesNativos();
      return;
    }

    const dataTable = ($(selectorTabla) as any).DataTable();

    const toolbar = document.createElement('div');
    toolbar.className = 'config-datatable-custom-toolbar';
    toolbar.innerHTML = `
      <div class="config-datatable-custom-field config-datatable-custom-field--length">
        <span class="config-datatable-custom-icon"><i class="fa-solid fa-list"></i></span>
        <span class="config-datatable-custom-label">Mostrar</span>
        <div class="config-datatable-length-select">
          <button id="${idTabla}CustomLength" type="button" class="config-datatable-length-select__button" aria-label="Entradas por pagina" aria-expanded="false">
            <span>10</span>
            <i class="fa-solid fa-chevron-down"></i>
          </button>
          <div class="config-datatable-length-select__menu" role="listbox">
            <button type="button" data-value="10" role="option">10</button>
            <button type="button" data-value="25" role="option">25</button>
            <button type="button" data-value="50" role="option">50</button>
            <button type="button" data-value="100" role="option">100</button>
          </div>
        </div>
        <span>entradas por pagina</span>
      </div>
      <div class="config-datatable-custom-field config-datatable-custom-field--search">
        <span class="config-datatable-custom-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
        <label for="${idTabla}CustomSearch">Busqueda</label>
        <input id="${idTabla}CustomSearch" type="search" placeholder="Buscar registro" aria-label="Buscar registro">
      </div>
    `;

    card.insertBefore(toolbar, wrapper);
    card.classList.add('has-custom-datatable-toolbar');

    ocultarControlesNativos();

    const selectLength = toolbar.querySelector(`#${idTabla}CustomLength`) as HTMLButtonElement|null;
    const selectLengthText = selectLength?.querySelector('span') as HTMLSpanElement|null;
    const selectLengthMenu = toolbar.querySelector('.config-datatable-length-select__menu') as HTMLElement|null;
    const inputSearch = toolbar.querySelector(`#${idTabla}CustomSearch`) as HTMLInputElement|null;

    if(selectLength){
      const pageLength = dataTable.page.len();
      if(selectLengthText)selectLengthText.textContent = String(pageLength > 0 ? pageLength : 10);

      selectLength.addEventListener('click', (event)=>{
        event.stopPropagation();
        const abierto = toolbar.classList.toggle('is-length-open');
        selectLength.setAttribute('aria-expanded', abierto ? 'true' : 'false');
      });

      selectLengthMenu?.querySelectorAll('button').forEach((opcion)=>{
        opcion.addEventListener('click', (event)=>{
          event.stopPropagation();
          const valor = Number((opcion as HTMLButtonElement).dataset.value);
          if(selectLengthText)selectLengthText.textContent = String(valor);
          dataTable.page.len(valor).draw();
          toolbar.classList.remove('is-length-open');
          selectLength.setAttribute('aria-expanded', 'false');
        });
      });

      document.addEventListener('click', ()=>{
        toolbar.classList.remove('is-length-open');
        selectLength.setAttribute('aria-expanded', 'false');
      });
    }

    inputSearch?.addEventListener('input', ()=> dataTable.search(inputSearch.value).draw());
    ($(selectorTabla) as any).on('draw.dt', ocultarControlesNativos);
  };

  montarToolbar();
  window.requestAnimationFrame(montarToolbar);
  window.setTimeout(montarToolbar, 100);
  window.setTimeout(montarToolbar, 300);
  window.setTimeout(montarToolbar, 700);
}