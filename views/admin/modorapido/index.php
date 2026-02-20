<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>POS Supermercado</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen">

<div class="h-full flex bg-gray-100 overflow-hidden">

  <!-- ================= COLUMNA IZQUIERDA ================= -->
  <div class="flex-1 flex flex-col overflow-hidden">

    <!-- HEADER -->
    <header class="bg-indigo-600 text-white px-6 py-3 flex justify-between items-center flex-none rounded">
      <h1 class="text-xl font-semibold">Venta Rápida · Supermercado</h1>
      <div class="text-base">
        Cajero: <strong>Julian Rodriguez</strong>
      </div>
    </header>

    <!-- INPUT -->
    <section class="bg-white px-6 py-3 border-b flex-none">
      <input
        id="inputScanner"
        type="text"
        placeholder="Escanee código de barras o escriba SKU"
        class="w-full h-14 text-2xl px-4 border-2 border-indigo-600 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-indigo-300"
        autofocus
      >
    </section>

    <!-- TABLA -->
    <section class="flex-1 min-h-0 bg-white overflow-hidden">
      <div class="h-full px-6 overflow-y-auto">
        <table class="w-full border-collapse text-xl">
          <thead class="sticky top-0 bg-gray-200 z-10">
            <tr>
              <th class="py-3 pl-4 text-left rounded-tl-lg">Producto</th>
              <th class="py-3 w-24 text-center">Cant</th>
              <th class="py-3 w-32 text-right">Precio</th>
              <th class="py-3 w-32 text-right">Total</th>
              <th class="py-3 w-16 text-center rounded-tr-lg">✖</th>
            </tr>
          </thead>
          <tbody id="tablaVenta"></tbody>
        </table>
      </div>
    </section>
  </div>

  <!-- ================= RESUMEN ================= -->
  <aside class="w-[28rem] bg-white m-3 rounded shadow flex flex-col flex-none">

    <div class="border-b px-4 py-2 font-semibold">Resumen</div>

    <div class="flex-1 px-4 py-4 space-y-3 text-lg">
      <div class="flex justify-between">
        <span>Subtotal</span>
        <span id="subtotal">$0</span>
      </div>
      <div class="flex justify-between">
        <span>IVA (19%)</span>
        <span id="iva">$0</span>
      </div>
      <div class="flex justify-between">
        <span>Unidades</span>
        <span id="totalUnidades">0</span>
      </div>
    </div>

    <div class="border-t px-4 py-4 space-y-3">
      <div class="flex justify-between text-2xl font-bold">
        <span>TOTAL</span>
        <span id="totalVenta">$0</span>
      </div>
      <button
        id="btnCobrar"
        class="w-full btn-lima black-white py-3 rounded text-[20px] font-semibold hover:btn-lima"
      >
        F8 · COBRAR
      </button>
    </div>
  </aside>
</div>

<!-- ================= MODAL COBRO ================= -->
<div id="modalCobro" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-md md:max-w-2xl rounded-xl shadow-lg p-6">

    <h2 class="text-2xl font-bold mb-4 text-center">Cobro de Venta</h2>

    <div class="text-center mb-4">
      <p class="text-gray-500">TOTAL A PAGAR</p>
      <p id="modalTotal" class="text-[#02db02] text-4xl font-bold">$0</p>
    </div>

    <!-- MEDIO DE PAGO -->
    <div class="mb-4">
      <label class="block text-sm text-gray-600 mb-1">Medio de pago</label>
      <select id="medioPago" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 h-14 text-xl 
focus:outline-none focus:ring-1">
        <option value="efectivo">Efectivo</option>
        <option value="tarjeta">Tarjeta</option>
        <option value="transferencia">Transferencia</option>
        <option value="mixto">Pago mixto</option>
      </select>
    </div>

    <!-- EFECTIVO -->
    <div id="bloqueEfectivo">
      <div class="mb-3">
        <label class="block text-sm text-gray-600 mb-1">Efectivo recibido</label>
        <input id="inputEfectivo" type="number"
          class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg 
block w-full p-2.5 h-14 text-xl 
focus:outline-none focus:ring-1">
      </div>
      <div class="flex justify-between mb-4">
        <span>Cambio</span>
        <span id="modalCambio" class="text-2xl font-bold">$0</span>
      </div>
    </div>

    <!-- MIXTO -->
    <div id="bloqueMixto" class="hidden space-y-3">
      <div>
        <label class="text-sm text-gray-600">Efectivo</label>
        <input id="mixtoEfectivo" type="number"
          class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
      </div>
      <div>
        <label class="text-sm text-gray-600">Tarjeta / Transferencia</label>
        <input id="mixtoElectronico" type="number"
          class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 h-14 text-xl focus:outline-none focus:ring-1">
      </div>
      <div class="flex justify-between">
        <span>Cambio</span>
        <span id="cambioMixto" class="text-2xl font-bold">$0</span>
      </div>
    </div>

    <div class="flex gap-4 mt-5">
      <button id="btnCancelarCobro"
        class="flex-1 bg-gray-300 hover:bg-gray-400 py-3 rounded-lg">
        ESC · Cancelar
      </button>
      <button id="btnConfirmarCobro"
        class="flex-1 btn-lima hover:btn-lima text-white py-3 rounded-lg font-semibold">
        ENTER · Confirmar
      </button>
    </div>

  </div>
</div>

<!-- ================= JS ================= -->
<script>

let audioCtx;

function beep(frecuencia = 800, duracion = 60) {
  if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
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

// 🔺 subir cantidad
function beepUp() {
  beep(900, 50);
}

// 🔻 bajar cantidad
function beepDown() {
  beep(450, 60);
}

// ❌ eliminar producto
function beepDelete() {
  beep(200, 120); // más grave y más largo
}


const input = document.getElementById('inputScanner');
const tabla = document.getElementById('tablaVenta');
const subtotalEl = document.getElementById('subtotal');
const ivaEl = document.getElementById('iva');
const totalEl = document.getElementById('totalVenta');
const unidadesEl = document.getElementById('totalUnidades');

const modal = document.getElementById('modalCobro');
const modalTotal = document.getElementById('modalTotal');
const inputEfectivo = document.getElementById('inputEfectivo');
const modalCambio = document.getElementById('modalCambio');
const medioPago = document.getElementById('medioPago');

const bloqueEfectivo = document.getElementById('bloqueEfectivo');
const bloqueMixto = document.getElementById('bloqueMixto');
const mixtoEfectivo = document.getElementById('mixtoEfectivo');
const mixtoElectronico = document.getElementById('mixtoElectronico');
const cambioMixto = document.getElementById('cambioMixto');

const btnCobrar = document.getElementById('btnCobrar');
const btnCancelarCobro = document.getElementById('btnCancelarCobro');
const btnConfirmarCobro = document.getElementById('btnConfirmarCobro');

let subtotal = 0;
let unidades = 0;

/* ===== DOBLE ENTER ===== */
let ultimoEnterTiempo = 0;
const DOBLE_ENTER_MS = 400;

/* ========================= */

function recalcularTotales() {
  subtotal = 0;
  unidades = 0;

  tabla.querySelectorAll('tr').forEach(tr => {
    const cant = Number(tr.dataset.cantidad);
    const precio = Number(tr.dataset.precio);
    subtotal += cant * precio;
    unidades += cant;

    tr.querySelector('.cantidad').textContent = cant;
    tr.querySelector('.totalFila').textContent =
      '$' + (cant * precio).toLocaleString();
  });

  const iva = Math.round(subtotal * 0.19);
  subtotalEl.textContent = '$' + subtotal.toLocaleString();
  ivaEl.textContent = '$' + iva.toLocaleString();
  totalEl.textContent = '$' + (subtotal + iva).toLocaleString();
  unidadesEl.textContent = unidades;
}

function flashCantidad(td, color) {
  const clase = color === 'up'
    ? 'bg-green-200'
    : 'bg-red-200';

  td.classList.add(clase);
  setTimeout(() => td.classList.remove(clase), 120);
}


/* ===== EDITAR CANTIDAD ===== */
function activarEdicionCantidad(td, tr) {
  const valorActual = tr.dataset.cantidad;

  td.innerHTML = `
    <input type="number"
      min="1"
      class="w-16 border rounded text-center text-xl focus:outline-none focus:ring-1"
      value="${valorActual}">
  `;

  const inputCant = td.querySelector('input');
  inputCant.focus();
  inputCant.select();

  inputCant.onkeydown = e => {
    if (e.key === 'Enter' || e.key === 'Tab') {
      e.preventDefault();
      tr.dataset.cantidad = inputCant.value || 1;
      td.textContent = tr.dataset.cantidad;
      td.tabIndex = 0;
      recalcularTotales();
      input.focus();
    }

    if (e.key === 'Escape') {
      td.textContent = valorActual;
      td.tabIndex = 0;
      input.focus();
    }
  };
}

/* ===== AGREGAR PRODUCTO ===== */
function agregarProducto(cod, nom, precio) {
  const ex = tabla.querySelector(`tr[data-codigo="${cod}"]`);
  if (ex) {
    ex.dataset.cantidad++;
    recalcularTotales();
    return;
  }

  const tr = document.createElement('tr');
  tr.dataset.codigo = cod;
  tr.dataset.precio = precio;
  tr.dataset.cantidad = 1;

  tr.innerHTML = `
    <td class="py-2 pl-4">${nom}</td>
    <td class="py-2 text-center cantidad" tabindex="0">1</td>
    <td class="py-2 text-right">$${precio.toLocaleString()}</td>
    <td class="py-2 text-right totalFila">$${precio.toLocaleString()}</td>
    <td class="text-center text-red-600 cursor-pointer">✖</td>
  `;

  const tdCantidad = tr.querySelector('.cantidad');
  tdCantidad.classList.add('cursor-pointer');

  /* ===== SOLO DOBLE ENTER ===== */
  tdCantidad.onkeydown = e => {
  const ahora = Date.now();

  // ⬆️ SUBIR
  if (e.key === 'ArrowUp') {
    e.preventDefault();
    tr.dataset.cantidad = Number(tr.dataset.cantidad) + 1;
    beep(900);
    flashCantidad(tdCantidad, 'up');
    recalcularTotales();
    return;
  }

  // ⬇️ BAJAR
  if (e.key === 'ArrowDown') {
    e.preventDefault();
    tr.dataset.cantidad = Math.max(1, Number(tr.dataset.cantidad) - 1);
    beep(500);
    flashCantidad(tdCantidad, 'down');
    recalcularTotales();
    return;
  }

  // ⏎ ENTER
  if (e.key === 'Enter') {
    e.preventDefault();

    if (ahora - ultimoEnterTiempo < DOBLE_ENTER_MS) {
      // 🔓 DOBLE ENTER → editar manual
      activarEdicionCantidad(tdCantidad, tr);
      ultimoEnterTiempo = 0;
    } else {
      // ➕ ENTER SIMPLE → sumar
      ultimoEnterTiempo = ahora;
      tr.dataset.cantidad = Number(tr.dataset.cantidad) + 1;
      beep(900);
      flashCantidad(tdCantidad, 'up');
      recalcularTotales();
    }
  }
};




  tr.querySelector('td:last-child').onclick = () => {
  beepDelete();               // 🔊 sonido grave
  tr.remove();
  recalcularTotales();
  input.focus();
};

  tabla.prepend(tr);
  recalcularTotales();
}

/* ===== MODAL ===== */
function abrirModalCobro() {
  if (subtotal <= 0) return;
  modalTotal.textContent = totalEl.textContent;
  modalCambio.textContent = '$0';
  inputEfectivo.value = '';
  medioPago.value = 'efectivo';
  bloqueEfectivo.style.display = 'block';
  bloqueMixto.classList.add('hidden');
  modal.classList.remove('hidden');
  inputEfectivo.focus();
}

function cerrarModalCobro() {
  modal.classList.add('hidden');
  input.focus();
}

medioPago.onchange = () => {
  bloqueEfectivo.style.display = medioPago.value === 'efectivo' ? 'block' : 'none';
  bloqueMixto.classList.toggle('hidden', medioPago.value !== 'mixto');
};

inputEfectivo.oninput = () => {
  const total = Number(modalTotal.textContent.replace(/\D/g,''));
  modalCambio.textContent =
    '$' + Math.max(0, inputEfectivo.value - total).toLocaleString();
};

/* ===== MIXTO ===== */
function totalVentaModal() {
  return Number(modalTotal.textContent.replace(/\D/g,''));
}

mixtoEfectivo.oninput = () => {
  const total = totalVentaModal();
  const efectivo = Number(mixtoEfectivo.value || 0);
  mixtoElectronico.value = Math.max(0, total - efectivo);
  cambioMixto.textContent =
    '$' + Math.max(0, efectivo + Number(mixtoElectronico.value) - total).toLocaleString();
};

mixtoElectronico.oninput = () => {
  const total = totalVentaModal();
  const elec = Number(mixtoElectronico.value || 0);
  mixtoEfectivo.value = Math.max(0, total - elec);
  cambioMixto.textContent =
    '$' + Math.max(0, elec + Number(mixtoEfectivo.value) - total).toLocaleString();
};

/* ===== CONFIRMAR ===== */
function confirmarCobro() {
  const total = Number(modalTotal.textContent.replace(/\D/g,''));

  if (medioPago.value === 'efectivo' && inputEfectivo.value < total) return;
  if (medioPago.value === 'mixto' &&
      Number(mixtoEfectivo.value||0) + Number(mixtoElectronico.value||0) < total) return;

  tabla.innerHTML = '';
  recalcularTotales();
  cerrarModalCobro();
}

/* ===== TECLADO GLOBAL ===== */
input.onkeydown = e => {
  if (e.key === 'Enter' && input.value) {
    agregarProducto(input.value, input.value, 50000);
    input.value = '';
  }
};

btnCobrar.onclick = abrirModalCobro;
btnCancelarCobro.onclick = cerrarModalCobro;
btnConfirmarCobro.onclick = confirmarCobro;

document.onkeydown = e => {
  if (!modal.classList.contains('hidden')) {
    if (e.key === 'Escape') cerrarModalCobro();
    if (e.key === 'Enter') confirmarCobro();
    return;
  }
  if (e.key === 'F8') abrirModalCobro();
};
</script>


</body>
</html>
