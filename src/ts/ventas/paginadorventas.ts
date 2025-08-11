(() => {
  if (document.querySelector('.paginadorventas')) {
    const filtrocategorias = document.querySelectorAll('.filtrocategorias');

    let hackerList: any;

    const options = {
      valueNames: ['card-producto', { data: ['categoria'] }],
      page: 18,
      pagination: {
        innerWindow: 1,
        left: 1,
        right: 1,
        paginationClass: "pagination"
      },
    };

    hackerList = new List('hacker-list', options);

    // 👉 Botones ← y →
    function agregarFlechas() {
      const paginador = document.querySelector('.pagination');
      if (!paginador) return;

      const total = hackerList.size();
      const perPage = hackerList.page;
      const totalPages = Math.ceil(total / perPage);
      const currentPage = hackerList.i + 1;

      // Evita duplicados
      if (paginador.querySelector('.prev') || paginador.querySelector('.next')) return;

      // ← Anterior
      const btnPrev = document.createElement('li');
      btnPrev.innerHTML = `
        <a href="#" class="page prev ${currentPage === 1 ? 'disabled' : ''}" data-i="prev" aria-label="Anterior">←</a>
      `;
      paginador.insertBefore(btnPrev, paginador.firstChild);

      // → Siguiente
      const btnNext = document.createElement('li');
      btnNext.innerHTML = `
        <a href="#" class="page next ${currentPage === totalPages ? 'disabled' : ''}" data-i="next" aria-label="Siguiente">→</a>
      `;
      paginador.appendChild(btnNext);

      // Debug opcional
      console.log('🧪 Items:', total);
      console.log('🧪 Páginas totales:', totalPages);
      console.log('🧪 Página actual:', currentPage);
    }

    // ✅ Agrega flechas al iniciar
    setTimeout(() => agregarFlechas(), 0);

    // 🔁 Reagrega flechas en cada cambio de página
    hackerList.on('updated', () => {
      setTimeout(agregarFlechas, 0);
    });

    // ⬅️➡️ Manejo de clics en flechas
    document.addEventListener('click', function (e) {
      const target = e.target as HTMLElement;
      if (!target.classList.contains('page') || target.classList.contains('disabled')) return;

      e.preventDefault();

      const total = hackerList.size();
      const perPage = hackerList.page;
      const totalPages = Math.ceil(total / perPage);
      const currentPage = hackerList.i + 1;

      if (target.dataset.i === 'prev' && currentPage > 1) {
        hackerList.show((currentPage - 2) * perPage, perPage);
      }

      if (target.dataset.i === 'next' && currentPage < totalPages) {
        hackerList.show(currentPage * perPage, perPage);
      }
    });

    // 🎯 Filtro por categoría
    filtrocategorias.forEach((element) => {
      element.addEventListener('click', (e) => {
        const categoria: string = (e.target as HTMLElement).dataset.categoria!;
        hackerList.filter((item: any) => item.values().categoria === categoria);
      });
    });
  }
})();
