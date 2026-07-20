const mobilemenu = document.querySelector('#mobile-menu');  //seleccion por id
const sidebar = document.querySelector('.sidebar') as HTMLElement|null;  //seleccion por calses
const btnmenux = document.querySelector('#mobile-menux');
const barra = document.querySelector('.barra-mobile') as HTMLElement|null;
const nametop:HTMLElement|null = document.querySelector('.nametop');
const selectSucursal = document.querySelector('#selectSucursal') as HTMLSelectElement;
const sucursalSeleccionada = document.querySelector('#sucursalSeleccionada') as HTMLElement|null;
const opcionesSucursal = document.querySelectorAll('.js-sucursal-option') as NodeListOf<HTMLElement>;
const toggleSucursalMenu = document.querySelector('#toggleSucursalMenu') as HTMLElement|null;
const sucursalMenuLista = document.querySelector('#sucursalMenuLista') as HTMLElement|null;
const iconSucursalMenu = document.querySelector('#iconSucursalMenu') as HTMLElement|null;
declare let Chart:any; //declare le indica a typescript que la variable chart viene de manera externa
declare const Swal: any;
declare var moment: any;
declare let List: any; 
declare let bwipjs: any;
declare const QRCode: any;
declare const mediosPagoDB: MedioPago[];  //mediosPagoDB inyectada por medio de json desde la vista ventas/index.php interfaz en ventas.type.ts
declare const clientesDB: Cliente[];
declare let comisionTotalEmpleadosDB: number;
declare let comisionTotalPagadaBusinessDB: number;
declare const getParam:any;  //getParam inyectada por medio de json desde la vista ventas/index.php interfaz en ventas.type.ts
declare const percentComisionUser:string;
declare let deudatotalCiente:string;

(window as any).POS = (window as any).POS || {};

 // SubmÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³dulos
  if (!(window as any).POS.gestionarDescuentos) {
    (window as any).POS.gestionarDescuentos = {};
  }

if(mobilemenu){
    mobilemenu.addEventListener('click', function(){
      if (sidebar && barra) {
        sidebar.classList.toggle('mostrar');
        barra.classList.toggle('ocultarmenu');
      }
    });
}
if(btnmenux){
    btnmenux.addEventListener('click', function(){
      if (sidebar && barra) {
        sidebar.classList.toggle('mostrar');
        barra.classList.toggle('ocultarmenu');
      }
    });
}
/////////////////////// animacion del sidebar toggle ///////////////////////////
document.querySelector('.sidebartoggle')!.addEventListener('click', (e)=>{
  if(sidebar)sidebar.classList.toggle('sidebar-fija');
});

//------------------------------------------------------------------------------------------------------------------//
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

///////////////////// FUNCION QUE IMPRIME MENSAJE TIPO ALERTA /////////////////////
function msjAlert(tipo:string, msj:string, divmsjalerta:HTMLElement):void{
  const esError = tipo === 'error';
  const titulo = esError ? 'Atencion requerida' : 'Operacion exitosa';
  const icono = esError ? 'fa-circle-exclamation' : 'fa-circle-check';
  divmsjalerta.insertAdjacentHTML('beforeend', `<div class="alerta alerta__${tipo}" role="alert">
      <span class="alerta__icono"><i class="fa-solid ${icono}"></i></span>
      <span class="alerta__contenido">
        <strong>${titulo}</strong>
        <span>${msj}</span>
      </span>
    </div>`
  );
  borrarMsjAlert(divmsjalerta);
}
//////////////////// BORRAR MENSAJES TIPO ALERTA /////////////////////
/*(borrarMsjAlert =()=>{  //se aplica de manera global
  const msj = document.querySelector('#divmsjalerta');
  if(document.querySelector('.alerta'))setTimeout(()=>{ while(msj.firstChild)msj.removeChild(msj.firstChild);}, 5000);
})();*/
function borrarMsjAlert(divmsj:HTMLElement):void{  //se aplica de manera global
  //const msj = document.querySelector('#divmsjalerta')!;
  if(document.querySelector('.alerta'))setTimeout(()=>{ while(divmsj.firstChild)divmsj.removeChild(divmsj.firstChild);}, 5000);
}
//////////////////// FUNCION QUE IMPRIME UN MENSAJE FORMATO TOAST ////////////////////
//msjalertToast('error', 'ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¡Error!', 'debe seleccionar una imagen')
function msjalertToast(icono:string, tipo:string, msj:string){
    Swal.fire({
    icon: icono,
    title: tipo,
    text: msj,
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3200,
    timerProgressBar: true,
    showClass: {
      popup: 'animate__animated animate__fadeInRight animate__faster'
    },
    hideClass: {
      popup: 'animate__animated animate__fadeOutRight animate__faster'
    },
    customClass: {
      popup: `j2-toast j2-toast--${icono}`,
      icon: 'j2-toast__icon',
      title: 'j2-toast__title',
      htmlContainer: 'j2-toast__text',
      timerProgressBar: 'j2-toast__progress'
    }
    });
}

/////////////////// FUNCION CONTADOR DE CARACTERES ////////////////////
(function countchars():void{
  const numinput = document.querySelectorAll('.count-charts') as NodeListOf<HTMLElement>;  
  numinput.forEach(element =>{ //element es cada label
      element.textContent = (parseInt(element.dataset.num!)-(element.previousElementSibling as HTMLInputElement).value.length).toString();
      element.previousElementSibling?.addEventListener('input', (e)=>{ //seleccionamos el input o el textarea en donde se escribe y se le da el evento de teclas
          element.textContent = parseInt(element.dataset.num!)-(e.target as HTMLInputElement).value.length+"";
            
          if(parseInt(element.dataset.num!)-(e.target as HTMLInputElement).value.length <= 0){
              let cadena = (e.target as HTMLInputElement).value.slice(0, parseInt(element.dataset.num!));
              (e.target as HTMLInputElement).value = cadena;
              element.textContent =`${0}`;
          }
      });
  });
})();

/////////////////// paginacion de negocio empleado, malla, config //////////////////
if(document.querySelector('#tabulacion')){ // view/admin/adminconfig/index.php
  const renderid = document.querySelector('#tabulacion input[type="radio"]:checked')!.nextElementSibling as HTMLElement; //se selecciona el input cheked y luego su span q contiene el id de la pagina a mostrar
  const mostrarPaginaConfiguracion = (idPagina:string):void => {
    const paginaActiva = document.querySelector<HTMLElement>(`.${idPagina}`);
    if(!paginaActiva)return;

    paginas.forEach(pagina => pagina.style.display = "none"); ////quitamos la class mostrarseccion a todas las secciones
    paginaActiva.style.display = "block"; //mostramos la seccion correspondiente

    window.setTimeout(()=>{
      try{
        (($.fn as any).dataTable)?.tables({ visible: true, api: true }).columns.adjust().responsive?.recalc();
      }catch(error){
        console.log(error);
      }
    }, 0);
  };
  const btns_navtabs = document.querySelectorAll('.tabs span');
  const paginas = document.querySelectorAll<HTMLElement>('.paginas'); //seleccionamos las secciones o paginas a mostrar
  mostrarPaginaConfiguracion(renderid.id);
  btns_navtabs.forEach(Element => {
      Element.addEventListener('click', (e)=>{ //cada btn o enlace
          const target = e.target as HTMLElement;
          const tab = target.closest('span[id^="pagina"]') as HTMLElement|null;
          if(!tab)return;
          mostrarPaginaConfiguracion(tab.id);
      });
  });
}

function mesyanoactual():[string, number]
{
  const fecha = new Date();
  const mesTexto:string = fecha.toLocaleString('es-CO', { month: 'long' });
  const ano:number = fecha.getFullYear();
  return [mesTexto, ano];
}

function getDgv(nit: number): number {
    const multiplicadores = [3, 7, 13, 17, 19, 23, 29, 37, 41, 43, 47, 53, 59, 67, 71];
    const digitos = nit.toString().trim().split('').map(Number);
    let suma = 0;
    digitos.forEach((digito, indice) => {
        const posicionMultiplicador = digitos.length - indice;
        suma += digito * multiplicadores[posicionMultiplicador - 1];
    }); 
    const modulo = suma%11;
    return modulo > 1 ?(11 - modulo):modulo;
}


let audioCtx: AudioContext;
function beep(frecuencia = 800, duracion = 60) {
  if (!audioCtx) audioCtx = new (window.AudioContext || (window as any).webkitAudioContext)();
  const osc = audioCtx.createOscillator();
  const gain = audioCtx.createGain();

  osc.frequency.value = frecuencia;
  osc.type = 'square';
  gain.gain.value = 0.08;

  osc.connect(gain);
  gain.connect(audioCtx.destination);

  osc.start();
  osc.stop(audioCtx.currentTime + duracion / 1000);
}


function flashCantidad(element:HTMLElement, color:string) {
    const clase = color === 'up'? 'bg-green-200': 'bg-red-200';
    element.classList.add(clase);
    setTimeout(() => element.classList.remove(clase), 120);
}


function bytesToBase64(data: string|Uint8Array) {
    if (typeof data === 'string')
      return btoa(data);

    let binary = '';
    if(data instanceof Uint8Array)
      for (let i = 0; i < data.length; i++) 
          binary += String.fromCharCode(data[i]);
    return btoa(binary);
}


function formatearMoneda(input: HTMLInputElement): void {
    let valor = input.value.replace(/[^\d,]/g, '');
    //const partes = valor.split(',');
    // Formatear parte entera
    //partes[0] = parseInt(partes[0] || '0').toLocaleString('es-CO');

    let [entera, ...decimales] = valor.split(',');
    entera= parseInt(entera || '0').toLocaleString('es-CO');
    /*if (partes.length > 2) {
      valor = partes[0] + ',' + partes.slice(1).join('');
    }*/
    // MÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¡ximo 2 decimales
    //if (partes[1])partes[1] = partes[1].substring(0, 2);
    //input.value = partes.join(',');
    input.value = entera+(decimales.length ? ',' + decimales.join('') : '');
}


function obtenerNumero(input: HTMLInputElement):number|null{
    const valor = input.value.replace(/\./g, '').replace(',', '.').trim();
    if (valor === '')return null;
    const numero = Number(valor);
    return Number.isNaN(numero) ? null : numero;
}


function filtrarInsumos(productoConfigurado:Partial<productsapi>|undefined):void{
  const insumos = productoConfigurado?.insumos;
  if(!insumos?.length) return;

  const insumosActivos = insumos.filter(insumoActual =>
    insumoActual.grupos_insumos === null || insumoActual.seleccionado === "1"
  );
  insumos.splice(0, insumos.length, ...insumosActivos);
}


function cerrarMenuSucursal():void{
  sucursalMenuLista?.classList.add('hidden');
  iconSucursalMenu?.classList.remove('rotate-180');
}

toggleSucursalMenu?.addEventListener('click', (event:MouseEvent)=>{
  event.stopPropagation();
  sucursalMenuLista?.classList.toggle('hidden');
  iconSucursalMenu?.classList.toggle('rotate-180');
});

opcionesSucursal.forEach((opcion)=>{
  opcion.addEventListener('click', ()=>{
    const value = opcion.dataset.sucursalValue || '';
    const label = opcion.dataset.sucursalLabel || opcion.textContent?.trim() || 'Cambiar de Sede';
    if(selectSucursal){
      selectSucursal.value = value;
      selectSucursal.dispatchEvent(new Event('change', {bubbles: true}));
      selectSucursal.dispatchEvent(new Event('click', {bubbles: true}));
    }
    if(sucursalSeleccionada){
      sucursalSeleccionada.textContent = label;
    }
    cerrarMenuSucursal();
  });

  opcion.addEventListener('keydown', (event:KeyboardEvent)=>{
    if(event.key === 'Enter' || event.key === ' '){
      event.preventDefault();
      opcion.click();
    }
  });
});

document.addEventListener('click', (event:MouseEvent)=>{
  const target = event.target as Node;
  if(sucursalMenuLista && toggleSucursalMenu && !sucursalMenuLista.contains(target) && !toggleSucursalMenu.contains(target)){
    cerrarMenuSucursal();
  }
});

function inicializarBuscadorParametrosSistema():void{
  const buscador = document.querySelector('#buscarParametroSistema') as HTMLInputElement|null;
  const limpiar = document.querySelector('#limpiarBusquedaParametroSistema') as HTMLButtonElement|null;
  const resultado = document.querySelector('#resultadoBusquedaParametroSistema') as HTMLElement|null;
  const contenedor = document.querySelector('.config-system-content') as HTMLElement|null;
  const barra = document.querySelector('.config-param-search') as HTMLElement|null;

  if(!buscador || !contenedor)return;

  const sistema = contenedor.closest('.config-system') as HTMLElement|null;
  const paneles = Array.from(contenedor.querySelectorAll('.accordion_tab_content')) as HTMLElement[];

  const normalizarTexto = (texto:string):string => texto
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .trim();

  const obtenerPanel = (elemento:Element):HTMLElement|null => elemento.closest('.accordion_tab_content') as HTMLElement|null;

  const obtenerNumeroPanel = (panel:HTMLElement|null):string|null => {
    if(!panel)return null;
    const claseContenido = Array.from(panel.classList).find((clase)=>/^contenido\d+$/.test(clase));
    return claseContenido ? claseContenido.replace('contenido', '') : null;
  };

  const camposPorContenedor = new Map<HTMLElement, {
    contenedorCampo: HTMLElement,
    panel: HTMLElement,
    numeroPanel: string,
    textos: string[]
  }>();

  Array.from(contenedor.querySelectorAll('label')).forEach((label)=>{
    const etiqueta = label as HTMLElement;
    const fieldId = etiqueta.getAttribute('for') || '';
    const input = fieldId ? document.getElementById(fieldId) as HTMLInputElement|null : null;
    const contenedorCampo = (etiqueta.closest('.formulario__campo') || etiqueta.parentElement) as HTMLElement|null;
    const panel = obtenerPanel(etiqueta);
    const numeroPanel = obtenerNumeroPanel(panel);

    if(!contenedorCampo || !panel || !numeroPanel)return;

    const textoBusqueda = [
      etiqueta.innerText,
      input?.placeholder || '',
      input?.name || '',
      input?.id || ''
    ].join(' ');

    const campoExistente = camposPorContenedor.get(contenedorCampo);
    if(campoExistente){
      campoExistente.textos.push(textoBusqueda);
      return;
    }

    camposPorContenedor.set(contenedorCampo, {
      contenedorCampo,
      panel,
      numeroPanel,
      textos: [textoBusqueda]
    });
  });

  const campos = Array.from(camposPorContenedor.values()).map((campo)=>({
    contenedorCampo: campo.contenedorCampo,
    panel: campo.panel,
    numeroPanel: campo.numeroPanel,
    textoBusqueda: normalizarTexto([
      campo.contenedorCampo.innerText,
      ...campo.textos
    ].join(' '))
  }));

  const limpiarFiltro = ():void => {
    barra?.classList.remove('has-query');
    sistema?.classList.remove('param-search-active');
    paneles.forEach((panel)=>panel.classList.remove('config-param-panel-match'));
    campos.forEach((campo)=>{
      campo.contenedorCampo?.classList.remove('config-param-hidden', 'config-param-match');
    });
    if(resultado)resultado.textContent = '';
  };

  const aplicarFiltro = ():void => {
    const termino = normalizarTexto(buscador.value);
    if(!termino){
      limpiarFiltro();
      return;
    }

    barra?.classList.add('has-query');
    sistema?.classList.add('param-search-active');
    const coincidencias = campos.filter((campo)=>campo.textoBusqueda.includes(termino));
    const panelesConCoincidencias = new Set(coincidencias.map((campo)=>campo.panel));

    paneles.forEach((panel)=>{
      panel.classList.toggle('config-param-panel-match', panelesConCoincidencias.has(panel));
    });

    campos.forEach((campo)=>{
      const coincide = campo.textoBusqueda.includes(termino);
      campo.contenedorCampo?.classList.toggle('config-param-hidden', !coincide);
      campo.contenedorCampo?.classList.toggle('config-param-match', coincide);
    });

    const primeraCoincidencia = coincidencias[0];
    if(!primeraCoincidencia || !primeraCoincidencia.numeroPanel){
      if(resultado)resultado.textContent = '0 resultados';
      return;
    }

    if(resultado){
      const totalResultados = coincidencias.length;
      resultado.textContent = totalResultados === 1 ? '1 resultado' : `${totalResultados} resultados`;
    }

    const radio = document.querySelector(`#btn${primeraCoincidencia.numeroPanel}`) as HTMLInputElement|null;
    if(radio && !radio.checked){
      radio.checked = true;
      radio.dispatchEvent(new Event('change', {bubbles: true}));
    }

    window.setTimeout(()=>{
      primeraCoincidencia.contenedorCampo?.scrollIntoView({behavior: 'smooth', block: 'center'});
    }, 80);
  };

  buscador.addEventListener('input', aplicarFiltro);
  sistema?.querySelectorAll('.config-system-nav .config-system-tab').forEach((tab)=>{
    tab.addEventListener('click', ()=>{
      if(!buscador.value)return;
      buscador.value = '';
      limpiarFiltro();
    });
  });
  limpiar?.addEventListener('click', ()=>{
    buscador.value = '';
    buscador.focus();
    limpiarFiltro();
  });
}

inicializarBuscadorParametrosSistema();
//evento para el cambio de sucursal
selectSucursal.addEventListener('click', async()=>{

  const datos = {
      idsucursal: "Juan",
      edad: 30,
      ciudad: "BogotÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¡"
  };

  const url = "/admin/api/changeSucursal/select";
                const respuesta = await fetch(url, {
                                            method: 'POST', 
                                            headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                            body: JSON.stringify(datos) 
                                        });

  
});
