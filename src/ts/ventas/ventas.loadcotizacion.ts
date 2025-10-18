(()=>{
  if(!document.querySelector('.ventas'))return;

    const POS = (window as any).POS;

    const mediospago = document.querySelectorAll('.mediopago');
    //let tipoventa:string="Contado";

    //eventos a los inputs medios de pago
    mediospago.forEach(m=>{m.addEventListener('input', (e)=>{ calcularmediospago(e);});});

    /////////////////////  evento al input recibido  //////////////////////////
    document.querySelector<HTMLInputElement>('#recibio')?.addEventListener('input', (e)=>{
      calcularCambio((e.target as HTMLInputElement).value);
    });
    
    const gestionSubirModalPagar = {
        
      subirModalPagar(){
        document.querySelector('#totalPagar')!.textContent = `${POS.valorTotal.total.toLocaleString()}`;
        //como se puede cerrar el modal y aumentar los productos, hay calcular los inputs
        let totalotrosmedios = 0;
        mediospago.forEach((item, index)=>{
            if(index>0)totalotrosmedios += parseInt((item as HTMLInputElement).value.replace(/[,.]/g, ''));
        });

        if(POS.valorTotal.total<totalotrosmedios){
            totalotrosmedios = 0;
            POS.mapMediospago.clear();
            $('.mediopago').val(0);
        }
        if(POS.tipoventa == "Contado"){
            (document.querySelector('.Efectivo')! as HTMLInputElement).value =  `${(POS.valorTotal.total-totalotrosmedios).toLocaleString()}`;
            POS.mapMediospago.set('1', POS.valorTotal.total-totalotrosmedios); //inicialmente el valor total se establece para efectivo
        }
        if(POS.valorTotal.total-totalotrosmedios == 0 && POS.mapMediospago.has('1'))POS.mapMediospago.delete('1');
        calcularCambio(document.querySelector<HTMLInputElement>('#recibio')!.value);
      },
      
    };

    function calcularmediospago(e:Event){
        let totalotrosmedios = 0;
        mediospago.forEach((item, index)=>{ //sumar todos los medios de pago menos el efectivo
          if(index>0)totalotrosmedios += parseInt((item as HTMLInputElement).value.replace(/[,.]/g, ''));
        });
        if(totalotrosmedios<=POS.valorTotal.total){
          if(POS.tipoventa == "Contado"){
            POS.mapMediospago.set('1', POS.valorTotal.total-totalotrosmedios);
            if(POS.valorTotal.total-totalotrosmedios == 0 && POS.mapMediospago.has('1'))POS.mapMediospago.delete('1'); //se elimina medio de pago efectivo
          }
          POS.mapMediospago.set((e.target as HTMLInputElement).id, parseInt((e.target as HTMLInputElement).value.replace(/[,.]/g, '')));
          if((e.target as HTMLInputElement).value == '0' && POS.mapMediospago.has((e.target as HTMLInputElement).id))POS.mapMediospago.delete((e.target as HTMLInputElement).id);
        }else{ //si la suma de los medios de pago superan el valor total, toma el ultimo input digitado y lo reestablece a su ultimo valor
          if(POS.mapMediospago.has((e.target as HTMLInputElement).id)){
            (e.target as HTMLInputElement).value = POS.mapMediospago.get((e.target as HTMLInputElement).id).toLocaleString();
          }else{
            (e.target as HTMLInputElement).value = '0';
          }
        }
        if(POS.tipoventa == "Contado"){
          (mediospago[0] as HTMLInputElement).value = (POS.mapMediospago.get('1')??0).toLocaleString();  //medio de pago en efectivo
        }
        calcularCambio(document.querySelector<HTMLInputElement>('#recibio')!.value);
    }

    function calcularCambio(recibido:string):void{
      recibido = recibido.replace(/[,.]/g, '');
      if(Number(recibido)>POS.mapMediospago.get('1')){
        (document.querySelector('#cambio') as HTMLElement).textContent = (Number(recibido)-POS.mapMediospago.get('1')).toLocaleString()+'';
        return;
      }
      (document.querySelector('#cambio') as HTMLElement).textContent = '0';
    }

    POS.gestionSubirModalPagar = gestionSubirModalPagar;

})();