(()=>{
  if(document.querySelector('.creditos')){

    const POS = (window as any).POS;
     
    const btnCrearCredito = document.querySelector('#btnCrearCredito');
    const miDialogoCredito = document.querySelector('#miDialogoCredito') as any;
    
    let indiceFila=0, control=0, tablaProductos:HTMLElement;
    
    interface Item {
      id_impuesto: number,
      facturaid: number,
      basegravable: number,
      valorimpuesto: number
    }
    let factimpuestos:Item[] = [];

    let products:productsapi[]=[], unproducto:productsapi;
    const mapMediospago = new Map();

    //btn para crear producto
    btnCrearCredito?.addEventListener('click', (e):void=>{
      miDialogoCredito.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });

    


  }

})();