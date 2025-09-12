(function(){
  if(document.querySelector('.configcaja')){
    document.querySelector('.configcaja')?.addEventListener('click', (e)=>{

      const grupos = ["imprimirfactura", "cierre-sin-facturar"];

      grupos.forEach(name => {
        const seleccionado = document.querySelector(`input[name="${name}"]:checked`) as HTMLInputElement;
        if (seleccionado) {
          console.log(`Grupo ${name}: ${seleccionado.value}`);
        } else {
          console.log(`Grupo ${name}: no se seleccionó nada`);
        }
      });
    });
  }
})();