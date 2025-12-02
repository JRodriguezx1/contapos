<!-- CONTENEDOR GENERAL -->
<div class="space-y-10 bg-white p-8 mb-20  rounded-xl">

    <!-- ENCABEZADO -->
    <div class="bg-white shadow rounded-xl p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-8 mb-5">

        <!-- Izquierda -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">
                Factura Electrónica #FE-000123
            </h2>
            <p class="text-gray-500 text-base">28 Nov 2025 - 3:45 PM</p>

            <!-- Badge Estado DIAN -->
            <span class="inline-block mt-4 px-4 py-1.5 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
                Pendiente DIAN
            </span>
        </div>

        <!-- Acciones -->
        <div class="w-full grid grid-cols-2 gap-3 
            md:flex md:flex-row md:justify-end md:w-auto">

            <!-- ENVIAR A DIAN -->
            <button class="flex items-center justify-center gap-2 w-full md:w-auto md:px-4 px-5 py-3 bg-indigo-600 text-white rounded-lg text-lg font-medium hover:bg-indigo-700 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Enviar a DIAN
            </button>
        
            <!-- ENVIAR CORREO -->
            <button id="btnEnviarCorreo" class="flex items-center justify-center gap-2 w-full md:w-auto md:px-4 px-5 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg text-lg font-medium hover:bg-gray-50 hover:border-gray-400 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 12H8m0 0l4-4m-4 4l4 4m9-4a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Enviar por correo
            </button>


            <!-- NOTA CRÉDITO -->
            <button id="btnNotaCredito" class="flex items-center justify-center gap-2 w-full md:w-auto md:px-4 px-5 py-3 bg-red-600 text-white rounded-lg text-lg font-medium hover:bg-red-700 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 9l-6 6m0-6l6 6M19 12a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Nota crédito
            </button>

            <!-- NUEVA FACTURA -->
            <button id="btnNuevaFactura" class="flex items-center justify-center gap-2 w-full md:w-auto md:px-4 px-5 py-3 bg-white border border-indigo-500 text-indigo-600 rounded-lg text-lg font-medium hover:bg-indigo-50 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 6v12m6-6H6" />
                </svg>
                Nueva factura
            </button>
        </div>
    </div>

    <!-- DATOS DEL ADQUIRIENTE -->
    <div class="bg-white rounded-xl shadow border border-gray-100 p-8 mb-5">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4"/>
                    <path d="M20 21v-2a4 4 0 00-3-3.87M4 21v-2a4 4 0 013-3.87"/>
                </svg>
                Datos del adquiriente
            </h3>

            <span class="bg-red-50 text-red-600 text-sm font-semibold px-3 py-1 rounded-full border border-red-200">
                No asignado
            </span>
        </div>

        <!-- Campos -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-gray-700 text-lg">
            <div>
                <p class="font-bold text-gray-900">Nombre</p>
                <p>Consumidor Final</p>
            </div>
            <div>
                <p class="font-bold text-gray-900">Identificación</p>
                <p>No informado</p>
            </div>
            <div>
                <p class="font-bold text-gray-900">Correo</p>
                <p>No informado</p>
            </div>
        </div>

        <!-- Acción derecha -->
        <div class="flex justify-end mt-6">
            <button class="px-6 py-3.5 bg-indigo-600 text-white rounded-lg text-xl font-medium hover:bg-indigo-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Asignar / actualizar cliente
            </button>
        </div>
    </div>

    <!-- DETALLE DE PRODUCTOS -->
    <div class="bg-white rounded-xl shadow p-8 overflow-x-auto mb-5">
        <h3 class="text-2xl font-semibold text-gray-900 mb-6">Detalle de productos</h3>

        <table class="w-full text-lg">
            <thead class="bg-gray-100 text-gray-600 font-semibold">
                <tr>
                    <th class="py-3 px-4 text-left">Producto</th>
                    <th class="py-3 px-4 text-center">Cant.</th>
                    <th class="py-3 px-4 text-right">Precio</th>
                    <th class="py-3 px-4 text-center">% IVA</th>
                    <th class="py-3 px-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <tr>
                    <td class="py-3 px-4">Café x 500gr</td>
                    <td class="text-center">2</td>
                    <td class="text-right">$14.280</td>
                    <td class="text-center">19%</td>
                    <td class="text-right font-bold">$28.560</td>
                </tr>

                <tr>
                    <td class="py-3 px-4">Pan integral</td>
                    <td class="text-center">1</td>
                    <td class="text-right">$5.950</td>
                    <td class="text-center">19%</td>
                    <td class="text-right font-bold">$5.950</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- RESUMEN -->
    <div class="bg-white rounded-xl shadow p-8 max-w-xs ml-auto border border-gray-100">
        <div class="flex justify-between text-lg text-gray-700 mb-2">
            <span>Subtotal</span><span>$29.000</span>
        </div>
        <div class="flex justify-between text-lg text-gray-700 mb-2">
            <span>IVA 19%</span><span>$5.510</span>
        </div>
        <div class="border-t border-gray-200 my-4"></div>
        <div class="flex justify-between text-xl font-extrabold text-gray-900">
            <span>Total</span><span>$34.510</span>
        </div>
    </div>

    <!-- MODAL ENVIAR POR CORREO -->
    <dialog id="modalEnviarCorreo"
        class="rounded-2xl border border-gray-200 w-[95%] max-w-2xl p-10 bg-white backdrop:bg-black/40 shadow-2xl
            transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out
            backdrop:backdrop-blur-sm">

        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h4 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">
                📧 Enviar factura por correo
            </h4>

            <button id="btnCerrarEnviarCorreo"
                class="p-2 rounded-lg hover:bg-gray-100 transition"
                onclick="document.getElementById('modalEnviarCorreo').close()">
                <i class="fa-solid fa-xmark text-gray-600 text-2xl"></i>
            </button>
        </div>

        <form method="dialog" class="grid grid-cols-1 gap-6">

            <!-- Correo del cliente -->
            <div>
                <label class="font-medium text-gray-800">Correo del cliente</label>
                <input type="email" id="correoCliente"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 h-14 text-lg focus:outline-none focus:ring-1"
                    placeholder="cliente@ejemplo.com" required>
            </div>

            <!-- Asunto -->
            <div>
                <label class="font-medium text-gray-800">Asunto del correo</label>
                <input type="text" id="asuntoCorreo"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 h-14 text-lg focus:outline-none focus:ring-1"
                    value="Factura electrónica FE-000123" required>
            </div>

            <!-- Mensaje -->
            <div>
                <label class="font-medium text-gray-800">Mensaje</label>
                <textarea id="mensajeCorreo"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-3 h-40 text-lg focus:outline-none focus:ring-1"
                >Estimado cliente, adjuntamos su factura electrónica.</textarea>
            </div>

            <!-- Adjuntar archivos -->
            <div class="flex items-center gap-3 text-lg">
                <input type="checkbox" id="adjuntarArchivos" class="scale-125" checked>
                <label for="adjuntarArchivos" class="text-gray-700">Adjuntar PDF y XML</label>
            </div>

            <!-- Botones -->
            <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" id="btnCancelarModal"
                    class="btn-md bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg !py-4 !px-6 !w-[135px]"
                    onclick="document.getElementById('modalEnviarCorreo').close()">
                    Cancelar
                </button>

                <button id="btnConfirmarEnviarCorreo"
                    class="btn-md bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg !py-4 !px-6 !w-[135px]">
                    Enviar
                </button>
            </div>
        </form>
    </dialog>

    <!-- MODAL NOTA CRÉDITO -->
    <dialog id="modalNotaCredito"
        class="rounded-2xl border border-gray-200 w-[95%] max-w-2xl p-10 bg-white backdrop:bg-black/40 shadow-2xl
        transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out
        backdrop:backdrop-blur-sm">

        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h4 class="text-2xl font-bold text-red-700 flex items-center gap-2">
                🧾 Generar Nota Crédito
            </h4>

            <button id="btnCerrarNotaCredito"
                class="p-2 rounded-lg hover:bg-gray-100 transition"
                onclick="document.getElementById('modalNotaCredito').close()">
                <i class="fa-solid fa-xmark text-gray-600 text-2xl"></i>
            </button>
        </div>

        <form method="dialog" class="grid grid-cols-1 gap-6">

            <!-- MOTIVO -->
            <div>
                <label class="font-medium text-gray-800">Motivo de la nota crédito</label>
                <select id="motivoNota"
                    class="mt-1 w-full px-4 py-3 border rounded-lg bg-gray-50 focus:border-indigo-600 focus:ring-1 text-lg">
                    <option value="devolucion">Devolución de productos</option>
                    <option value="descuento">Aplicación de descuento</option>
                    <option value="anulacion">Anulación de factura</option>
                    <option value="otros">Otros</option>
                </select>
            </div>

            <!-- DESCRIPCIÓN -->
            <div>
                <label class="font-medium text-gray-800">Descripción</label>
                <textarea id="descripcionNota" rows="4"
                    class="mt-1 w-full px-4 py-3 bg-gray-50 border text-gray-700 rounded-lg focus:border-indigo-600 focus:ring-1 text-lg"
                    placeholder="Escribe una breve descripción..."></textarea>
            </div>

            <!-- VALOR -->
            <div>
                <label class="font-medium text-gray-800">Valor a retornar</label>
                <input type="number" id="valorNota"
                    class="mt-1 w-full px-4 py-3 bg-gray-50 border rounded-lg focus:border-indigo-600 focus:ring-1 text-lg"
                    placeholder="$0" min="0" required>
            </div>

            <!-- Botones -->
            <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" id="btnCancelarNota"
                    class="btn-md bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg !py-4 !px-6 !w-[135px]">
                    Cancelar
                </button>

                <button id="btnConfirmarNota"
                    class="btn-md bg-red-600 hover:bg-red-700 text-white rounded-lg !py-4 !px-6 !w-[135px]">
                    Generar
                </button>
            </div>
        </form>
    </dialog>

    <!-- MODAL NUEVA FACTURA -->
    <dialog id="modalNuevaFactura"
        class="rounded-2xl border border-gray-200 w-[95%] max-w-2xl p-10 bg-white backdrop:bg-black/40 shadow-2xl
            transition-all scale-95 opacity-0 open:scale-100 open:opacity-100 duration-300 ease-out
            backdrop:backdrop-blur-sm">

        <!-- Encabezado -->
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h4 class="text-2xl font-bold text-indigo-700 flex items-center gap-3">
                <i class="fa-solid fa-file-invoice-dollar text-indigo-700 text-3xl"></i>
                Generar Nueva Factura
            </h4>

            <button id="btnCerrarNuevaFactura"
                class="p-2 rounded-lg hover:bg-gray-100 transition"
                onclick="document.getElementById('modalNuevaFactura').close()">
                <i class="fa-solid fa-xmark text-gray-600 text-2xl"></i>
            </button>
        </div>

        <form id="formNuevaFactura" method="POST" class="grid grid-cols-1 gap-6">

            <!-- Seleccionar Resolución -->
            <div>
                <label class="font-medium text-gray-800">Resolución en uso</label>
                <select id="selectResolucion"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 
                    block w-full p-3 h-14 text-lg focus:outline-none focus:ring-1"
                    required>
                    <option value="" selected disabled>- Seleccionar -</option>
                    <?php foreach($resoluciones as $value): ?>
                    <option value="<?= $value->id ?>"
                            data-prefijo="<?= $value->prefijo ?>"
                            data-actual="<?= $value->consecutivo_actual ?>">
                        <?= $value->prefijo ?> (Actual: <?= $value->consecutivo_actual ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipo de consecutivo -->
            <div>
                <label class="font-medium text-gray-800 block">Tipo de consecutivo</label>

                <div class="space-y-3 mt-2">

                    <label class="flex items-center gap-3 bg-gray-50 border border-gray-300 p-3 rounded-lg cursor-pointer hover:border-indigo-600 transition">
                        <input type="radio" name="tipoConsecutivo" value="automatico" checked class="scale-125">
                        <span class="text-gray-800 text-lg">Siguiente consecutivo automático</span>
                    </label>

                    <label class="flex items-center gap-3 bg-gray-50 border border-gray-300 p-3 rounded-lg cursor-pointer hover:border-indigo-600 transition">
                        <input type="radio" name="tipoConsecutivo" value="manual" class="scale-125">
                        <span class="text-gray-800 text-lg">Ingresar consecutivo manual</span>
                    </label>

                    <input type="number" id="consecutivoManual"
                        class="hidden w-full p-3 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 focus:ring-1"
                        placeholder="Ej: 125">
                </div>
            </div>

            <!-- Vista previa -->
            <div class="text-center py-5 bg-indigo-50 border border-indigo-200 rounded-xl shadow-sm">
                <p class="text-lg font-medium text-indigo-700">Factura resultante</p>
                <p id="previewFactura"
                class="text-3xl font-black text-indigo-900 tracking-wide mt-1">
                ---
                </p>
            </div>

            <!-- Botones -->
            <div class="text-right pt-6 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" id="btnCancelarNuevaFactura"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg px-6 py-4 font-medium"
                    onclick="document.getElementById('modalNuevaFactura').close()">
                    Cancelar
                </button>

                <button id="btnGenerarNuevaFactura"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-6 py-4 font-semibold shadow-md">
                    Generar
                </button>
            </div>

        </form>
    </dialog>

</div>


<script>
// Elementos
const modalCorreo = document.getElementById('modalEnviarCorreo');
const btnAbrirModal = document.getElementById('btnEnviarCorreo');
const btnCancelarModal = document.getElementById('btnCancelarModal');
const btnConfirmarEnviarCorreo = document.getElementById('btnConfirmarEnviarCorreo');

// Abrir modal
btnAbrirModal?.addEventListener('click', () => {
    modalCorreo.showModal();
}); 

// Cerrar modal
btnCancelarModal?.addEventListener('click', () => {
    modalCorreo.close();
});

// Simulación de envío
btnConfirmarEnviarCorreo?.addEventListener('click', (e) => {
    e.preventDefault();

    const correo = document.getElementById('correoCliente').value;
    const asunto = document.getElementById('asuntoCorreo').value;
    const mensaje = document.getElementById('mensajeCorreo').value;
    const adjuntos = document.getElementById('adjuntarArchivos').checked;

    console.log({ correo, asunto, mensaje, adjuntos });

    alert("📧 Correo enviado correctamente (Simulado)");

    modalCorreo.close();
});

// --- MODAL NOTA CRÉDITO ---
const modalNotaCredito = document.getElementById("modalNotaCredito");
const btnNotaCredito = document.querySelector("button:has(svg path[d='M15 9l-6 6m0-6l6 6M19 12a7 7 0 11-14 0 7 7 0 0114 0z'])"); // Selecciona el botón por ícono
const btnCancelarNota = document.getElementById("btnCancelarNota");
const btnCerrarNotaCredito = document.getElementById("btnCerrarNotaCredito");

// Abrir modal
btnNotaCredito?.addEventListener("click", () => {
    modalNotaCredito.showModal();
});

// Cerrar modal (2 botones)
btnCancelarNota?.addEventListener("click", () => modalNotaCredito.close());
btnCerrarNotaCredito?.addEventListener("click", () => modalNotaCredito.close());

// Confirmar acción
document.getElementById("btnConfirmarNota").addEventListener("click", (e) => {
    e.preventDefault();
    modalNotaCredito.close();
    alert("Nota crédito generada correctamente ✔");
});


</script>

<!-- JS Nueva Factura  -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Elementos principales
  const btnNuevaFactura = document.getElementById('btnNuevaFactura');
  const modalNuevaFactura = document.getElementById('modalNuevaFactura');
  const selectResolucion = document.getElementById('selectResolucion');
  const inputManual = document.getElementById('consecutivoManual');
  const btnCancelarNuevaFactura = document.getElementById('btnCancelarNuevaFactura');
  const btnGenerarNuevaFactura = document.getElementById('btnGenerarNuevaFactura');
  const previewFactura = document.getElementById('previewFactura');

  if (!btnNuevaFactura) { console.warn('btnNuevaFactura no encontrado.'); return; }
  if (!modalNuevaFactura) { console.warn('modalNuevaFactura no encontrado.'); return; }

  // Asegura que el botón no sea submit (evita recargas)
  btnNuevaFactura.setAttribute('type', 'button');

  // Abrir modal
  btnNuevaFactura.addEventListener('click', () => {
    // reset previo (opcional)
    if (selectResolucion) selectResolucion.value = '';
    if (inputManual) { inputManual.value = ''; inputManual.classList.add('hidden'); }
    if (previewFactura) previewFactura.textContent = '---';
    modalNuevaFactura.showModal();
  });

  // Cancelar / cerrar
  btnCancelarNuevaFactura?.addEventListener('click', () => modalNuevaFactura.close());

  // Manejo de input manual + preview (por si no tienes el otro script cargado)
  const actualizarVista = () => {
    if (!selectResolucion || !previewFactura) return;
    const opcion = selectResolucion.selectedOptions[0];
    if (!opcion) { previewFactura.textContent = '---'; return; }
    const prefijo = opcion.dataset.prefijo || '';
    const actualNum = parseInt(opcion.dataset.actual||'0', 10) + 1;
    const tipo = document.querySelector('input[name="tipoConsecutivo"]:checked')?.value || 'automatico';
    let numero = tipo === 'manual' ? (inputManual?.value || '---') : actualNum;
    previewFactura.textContent = `${prefijo}-${numero}`;
  };

  // Listeners para preview (siempre seguros de existencia)
  selectResolucion?.addEventListener('change', actualizarVista);
  inputManual?.addEventListener('input', actualizarVista);
  document.querySelectorAll('input[name="tipoConsecutivo"]').forEach(r => 
    r.addEventListener('change', () => {
      if (inputManual) inputManual.classList.toggle('hidden', r.value !== 'manual');
      actualizarVista();
    })
  );

  // Generar nueva factura (validación mínima)
  btnGenerarNuevaFactura?.addEventListener('click', (e) => {
    e.preventDefault();

    // Validaciones
    if (!selectResolucion || !selectResolucion.value) {
      alert('Selecciona una resolución.');
      return;
    }

    const tipo = document.querySelector('input[name="tipoConsecutivo"]:checked')?.value || 'automatico';
    if (tipo === 'manual' && (!inputManual || !inputManual.value)) {
      alert('Ingresa el consecutivo manual.');
      return;
    }

    // Construir datos para enviar al backend
    const opcion = selectResolucion.selectedOptions[0];
    const payload = {
      id_resolucion: selectResolucion.value,
      prefijo: opcion.dataset.prefijo || '',
      consecutivo: tipo === 'manual' ? inputManual.value : (parseInt(opcion.dataset.actual||'0',10) + 1),
      factura_origen: '<?= $factura_id ?? "FE-000123" ?>' // ajusta si tienes variable PHP real
    };

    // Aquí puedes: 1) enviar por fetch a tu endpoint PHP, o 2) rellenar inputs hidden y submit del form.
    // Ejemplo con fetch (descomenta y ajusta URL si quieres):
    /*
    btnGenerarNuevaFactura.disabled = true;
    btnGenerarNuevaFactura.textContent = 'Generando...';

    fetch('/ruta/generar_nueva_factura.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
      if (data.ok) {
        alert('Nueva factura generada: ' + data.nuevo_numero);
        modalNuevaFactura.close();
        // opcional: recargar o redirigir a la nueva factura
        // location.href = '/factura/ver/' + data.id;
      } else {
        alert('Error: ' + (data.error || 'Desconocido'));
      }
    })
    .catch(err => {
      console.error(err);
      alert('Error en la petición.');
    })
    .finally(() => {
      btnGenerarNuevaFactura.disabled = false;
      btnGenerarNuevaFactura.textContent = 'Generar';
    });
    */

    // Si prefieres submit clásico: crea hidden inputs y submit form:
    // const form = document.getElementById('formNuevaFactura');
    // add/create hidden inputs for payload, then form.submit();

    // Por ahora solo demo:
    alert('Generando nueva factura: ' + payload.prefijo + '-' + payload.consecutivo);
    modalNuevaFactura.close();
  });

});
</script>


