(():void=>{

  if(document.querySelector('.caja')){
    const modalGastosIngresos:any = document.querySelector("#gastosIngresos");
    const btnGastosingresos = document.querySelector<HTMLButtonElement>("#btnGastosingresos");
    const operacion = document.querySelector('#operacion') as HTMLSelectElement;


    //////// clic al btn gastos/ingresos
    btnGastosingresos?.addEventListener('click', ():void=>{
      modalGastosIngresos.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });


    ///////// cambio de tipo de operacion si ingreso o gasto, si es gasto habilita el select de los tipos de gastos
    operacion?.addEventListener('change', (e:Event)=>{
      const targetDom = e.target as HTMLSelectElement;
      const tipodegasto = document.querySelector('.tipodegasto') as HTMLElement;
      if(targetDom.value == '2'){
        tipodegasto.style.display = 'flex';
      }
      else{
        tipodegasto.style.display = 'none';
      }
    });


    function cerrarDialogoExterno(event:Event) {
      if (event.target === modalGastosIngresos || (event.target as HTMLInputElement).value === 'cancelar' || (event.target as HTMLInputElement).value === 'Aplicar') {
          modalGastosIngresos.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }
  }

})();