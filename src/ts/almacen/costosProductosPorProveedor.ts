(() => {
  if(!document.querySelector('.costosProductosPorProveedor'))return;

  type Proveedor = { id: number; name: string };
  type CostoProveedor = Proveedor & { cost: number; updated: string };

  type Articulo = {
    id: number;
    tipoelemento: 0 | 1;
    code: string;
    name: string;
    suppliers: CostoProveedor[];
  };
  
  type Respuesta = { products: Articulo[]; suppliers: Proveedor[] };

  let products: Articulo[] = [];
  let suppliers: Proveedor[] = [];
  const openRows = new Set<string>();

  const get = <T extends HTMLElement>(id: string): T => //funcion flecha que retorna tipo T, extends HTMLElement establece una restricción: T debe ser un tipo compatible con HTMLElement.
    document.getElementById(id) as T;  //esta funcion esperar un tipo de elemento compatible HTMLElement y devuelve al elemento encontrado

  const body = get<HTMLTableSectionElement>('productsBody');
  const search = get<HTMLInputElement>('search');
  const filter = get<HTMLSelectElement>('filter');
  const modal = get<HTMLDivElement>('modal');
  const productSelect = get<HTMLSelectElement>('productSelect');
  const supplierSelect = get<HTMLSelectElement>('supplierSelect');
  const costInput = get<HTMLInputElement>('costInput');
  const toast = get<HTMLDivElement>('toast');

  const key = (p:Articulo): string => `${p.tipoelemento}:${p.id}`;
  const tipo = (p:Articulo): string => p.tipoelemento===0?'Producto':'Insumo';

  const money = (value: number): string =>
    new Intl.NumberFormat('es-CO', {
      style: 'currency',
      currency: 'COP',
      maximumFractionDigits: 2
    }).format(value);

  const escapeHTML = (value: string | number): string =>
    String(value).replace(/[&<>"']/g, char => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;'
    }[char]!));


  function render(): void{
    const query = search.value.toLocaleLowerCase('es').trim();

    const visible = products.filter(p => {
      const text = `${p.name} ${p.code} ${tipo(p)} ${p.suppliers.map(s => s.name).join(' ')}`.toLocaleLowerCase('es');
      const count = p.suppliers.length;
      return text.includes(query) && (filter.value === 'all' || (filter.value === 'multiple' && count > 1) || (filter.value === 'single' && count === 1) || (filter.value === 'none' && count === 0)); 
    });

    get('statProducts').textContent = String(products.length);
    get('statMultiple').textContent = String(products.filter(p => p.suppliers.length > 1).length);
    get('statQuotes').textContent = String(products.reduce((total, p) => total + p.suppliers.length, 0));
    get('counter').textContent =`Mostrando ${visible.length} de ${products.length} artículos`;

    body.innerHTML = visible.map(p => {
      const articleKey = key(p);
      const sorted = [...p.suppliers].sort((a, b) => a.cost - b.cost);
      const best = sorted[0];
      const expanded = openRows.has(articleKey);

      return `
        <tr class="hover:bg-slate-50">
          <td>
            <p class="m-0 font-medium">${escapeHTML(p.name)}</p>
            <span class="table-badge table-badge--primary">${tipo(p)} · ${escapeHTML(p.code)}</span>
          </td>
          <td><span class="table-badge table-badge--neutral">${sorted.length}</span></td>
          <td>${best
            ? `<span class="table-badge table-badge--success">${escapeHTML(best.name)}</span>`
            : '<span class="text-slate-400">Sin proveedor</span>'}
          </td>`+
          /*<td>${best
            ? `<span class="table-amount">${money(best.cost)}</span>`
            : '<span class="text-slate-400">—</span>'}
          </td>*/
          `<td>
            <button type="button" data-toggle="${articleKey}"
              aria-expanded="${expanded}"
              aria-label="${expanded ? 'Ocultar' : 'Mostrar'} proveedores de ${escapeHTML(p.name)}"
              class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-indigo-600 font-semibold hover:bg-indigo-50"
            >
              <span class="text-lg">${expanded ? 'Ocultar' : 'Ver'}</span>
            </button>
          </td>
        </tr>
        ${expanded ? `
          <tr class="bg-indigo-50/40">
            <td colspan="5" class="px-5 pb-5">
              <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                <div class="px-4 py-4 font-medium text-xl">Proveedores de ${escapeHTML(p.name)}</div>
                <div class="overflow-x-auto">
                  <table class="w-full min-w-[550px] text-sm">
                    <thead>
                      <tr>
                        <th class="!text-center">Proveedor</th>
                        <th class="!text-center">Costo</th>
                        <th class="!text-center">Última actualización</th>
                        <th class="!text-center">Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      ${sorted.length ? sorted.map((s, index) => `
                        <tr class="border-t border-slate-100">
                          <td>
                            <span class="font-medium text-xl">${escapeHTML(s.name)}</span>
                            ${index === 0? '<span class="table-badge table-badge--success">Menor costo</span>' : ''}
                          </td>
                          <td>${money(s.cost)}</td>
                          <td><span class="font-medium"> ${escapeHTML(s.updated)}</span></td>
                          <td>
                            <button type="button" data-edit="${articleKey}"
                              data-supplier="${s.id}"
                              class="font-semibold text-indigo-600 text-xl">Editar</button>
                          </td>
                        </tr>
                      `).join('') : `
                        <tr><td>
                          Este artículo aún no tiene costos de proveedores.
                        </td></tr>
                      `}
                    </tbody>
                  </table>
                </div>
              </div>
            </td>
          </tr>
        ` : ''}
      `;
    }).join('') || `
      <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">
        No hay artículos que coincidan con la búsqueda.
      </td></tr>
    `;
  }

  function syncCost(): void {
    const article = products.find(p => key(p) === productSelect.value);
    const supplier = article?.suppliers.find(s => s.id === Number(supplierSelect.value));
    costInput.value = supplier ? String(supplier.cost) : '';
  }

  function showModal(articleKey?: string, supplierId?: number): void{
    if(!products.length || !suppliers.length)return;

    productSelect.innerHTML = products.map(p =>`<option value="${key(p)}">${tipo(p)} · ${escapeHTML(p.name)}</option>`).join('');
    supplierSelect.innerHTML = suppliers.map(s =>`<option value="${s.id}">${escapeHTML(s.name)}</option>`).join('');

    productSelect.value = articleKey ?? key(products[0]);
    supplierSelect.value = String(supplierId ?? suppliers[0].id);
    syncCost();
    modal.classList.replace('hidden', 'flex');
    costInput.focus();
  }


  const hideModal = ():void => { modal.classList.replace('flex', 'hidden') };

  (async ():Promise<void> => {
    body.innerHTML = `<tr><td colspan="5" class="px-5 py-12 text-center">Cargando artículos...</td></tr>`;

    try{
      const response = await fetch('/admin/api/almacen/costosProductosPorProveedor');
      if(!response.ok) throw new Error('No se pudieron consultar los costos.');

      const data = await response.json() as Respuesta;
      if(!Array.isArray(data.products) || !Array.isArray(data.suppliers))
        throw new Error('La respuesta del servidor no es válida.');

      products = data.products;
      suppliers = data.suppliers;
      render();
    }catch(error){
      console.error(error);
      body.innerHTML = `
        <tr><td colspan="5" class="px-5 py-12 text-center text-red-600">
          No se pudieron cargar los costos. Recarga la página.
        </td></tr>`;
    }
  })();

  body.addEventListener('click', event => {
    if(!(event.target instanceof Element))return;
    const toggle = event.target.closest<HTMLButtonElement>('[data-toggle]');
    if(toggle){
      const articleKey = toggle.dataset.toggle!;
      openRows.has(articleKey) ? openRows.delete(articleKey) : openRows.add(articleKey);
      render();
      return;
    }

    const edit = event.target.closest<HTMLButtonElement>('[data-edit]');
    if(edit)showModal(edit.dataset.edit, edit.dataset.supplier ? Number(edit.dataset.supplier) : undefined);
  });

  get('btnAdd').addEventListener('click', () => showModal());
  get('closeModal').addEventListener('click', hideModal);
  get('cancelModal').addEventListener('click', hideModal);

  modal.addEventListener('click', event => {
    if(event.target === modal)hideModal();
  });

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape')hideModal();
  });

  search.addEventListener('input', render);
  filter.addEventListener('change', render);
  productSelect.addEventListener('change', syncCost);
  supplierSelect.addEventListener('change', syncCost);

  // registrar costo
  const btnRegistrarCosto = document.querySelector('#registrarCosto') as HTMLButtonElement;
  get<HTMLFormElement>('costForm').addEventListener('submit', async event => {
    event.preventDefault();

    const article = products.find(p => key(p) === productSelect.value);
    const supplier = suppliers.find(s => s.id === Number(supplierSelect.value));
    const cost = Number(costInput.value);

    if(!article || !supplier || !Number.isFinite(cost) || cost<0 || costInput.value === '')return;

    const datos = new FormData();
    datos.set('proveedor_id', String(supplier.id));
    datos.set('idelemento', String(article.id));
    datos.set('tipoelemento', String(article.tipoelemento));
    datos.set('costo', costInput.value);

    btnRegistrarCosto.disabled = true;
    btnRegistrarCosto.textContent = 'Registrando...';
    try{
        const response = await fetch('/admin/api/almacen/guardarCostoProveedor', {
                                    method: 'POST',
                                    body: datos
                                });
        const result = await response.json() as {exito?:string[], error?:string[]};

        if(!response.ok || !result.exito?.length)
            throw new Error(result.error?.[0] ?? 'No fue posible guardar el costo.');
        // Actualiza la tabla en memoria únicamente después del éxito del servidor.
        const previous = article.suppliers.find(s => s.id === supplier.id);
        const updated = new Date().toLocaleDateString('sv-SE');
        if(previous){
            previous.cost = cost;
            previous.updated = updated;
        }else{
            article.suppliers.push({ ...supplier, cost, updated });
        }
        openRows.add(key(article));
        render();
        hideModal();
        msjalertToast('success', 'Exito!', result.exito[0]);
    }catch(error){
        msjalertToast('error', 'Error!', 'No fue posible registrar el costo. - '+error);
    }finally{
        btnRegistrarCosto.textContent = "Guardar costo";
        btnRegistrarCosto.disabled = false;
    }
  });

})();