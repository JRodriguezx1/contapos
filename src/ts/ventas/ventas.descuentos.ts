(()=>{
  if(!document.querySelector('.ventas'))return;

    const POS = (window as any).POS;

    const btndescuento = document.querySelector('#btndescuento') as HTMLButtonElement;
    const miDialogoDescuento = document.querySelector('#miDialogoDescuento') as any;
    const tipoDescts = document.querySelectorAll<HTMLInputElement>('input[name="tipodescuento"]'); //radio buttom
    const inputDescuento = document.querySelector('#inputDescuento') as HTMLInputElement;
    let valorMax = 0;
    
    btndescuento?.addEventListener('click', ()=>{
      if(POS.carrito.length){
        valorMax = POS.valorTotal.subtotal;
        //validar que si al reducir los productos o aumentar recalcular el porcentaje
        miDialogoDescuento.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      }
    });

    /////////////////////  logica del descuento  //////////////////////////
    tipoDescts.forEach(desc=>{ //evento a los radiobutton
      desc.addEventListener('change', (e:Event)=>{
        if((e.target as HTMLInputElement).value === "porcentaje"){
          valorMax = 100;
          inputDescuento.value = '';
        }
        if((e.target as HTMLInputElement).value === "valor"){
          inputDescuento.value = '';
          valorMax = POS.valorTotal.subtotal;
        }
      });
    });

    inputDescuento?.addEventListener('input', (e)=>{
      var valorInput:number = Number((e.target as HTMLInputElement).value);
      if(valorInput > valorMax){
        inputDescuento.value = valorMax+'';
        valorInput = valorMax; 
      }
    });

    document.querySelector('#formDescuento')?.addEventListener('submit', e=>{
      e.preventDefault();
      const valorInput:number = Number(inputDescuento.value);
      if(tipoDescts[0].checked){  //tipo valor
        POS.valorTotal.dctox100 = Math.round((valorInput*100)/POS.valorTotal.subtotal);  // valor en porcentaje
        POS.valorTotal.descuento = valorInput;  //valor del dcto
      }
      if(tipoDescts[1].checked){ //tipo porcentaje
        POS.valorTotal.descuento = (POS.valorTotal.subtotal*valorInput)/100;  //valor descontado
        POS.valorTotal.dctox100 = valorInput;  //valor en porcentaje
      }
      POS.valorTotal.total = POS.valorTotal.subtotal - POS.valorTotal.descuento + POS.valorTotal.valortarifa;
      document.querySelector('#total')!.textContent = '$ '+POS.valorTotal.total.toLocaleString();
      (document.querySelector('#descuento') as HTMLElement).textContent = '$'+POS.valorTotal.descuento.toLocaleString();
      miDialogoDescuento.close();
      document.removeEventListener("click", cerrarDialogoExterno);
    });
    
    
    const gestionarDescuentos = {
      miDialogoDescuento
    }

    POS.gestionarDescuentos = gestionarDescuentos;
    

})();