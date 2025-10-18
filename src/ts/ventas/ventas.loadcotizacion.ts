(()=>{
  if(!document.querySelector('.ventas'))return;

    const POS = (window as any).POS;

    const mediospago = document.querySelectorAll('.mediopago');
    //const mapMediospago = new Map();
    let tipoventa:string="Contado";
    //const valorTotal = {subtotal: 0, base: 0, valorimpuestototal: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
    
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
        if(tipoventa == "Contado"){
            (document.querySelector('.Efectivo')! as HTMLInputElement).value =  `${(POS.valorTotal.total-totalotrosmedios).toLocaleString()}`;
            POS.mapMediospago.set('1', POS.valorTotal.total-totalotrosmedios); //inicialmente el valor total se establece para efectivo
        }
        if(POS.valorTotal.total-totalotrosmedios == 0 && POS.mapMediospago.has('1'))POS.mapMediospago.delete('1');
        POS.calcularCambio(document.querySelector<HTMLInputElement>('#recibio')!.value);
    },

    

    
      
    };

    POS.gestionSubirModalPagar = gestionSubirModalPagar;

})();