(()=>{

    if(document.querySelector('.configsuscripcion')){
        const btnRegistrarPago = document.getElementById('btnRegistrarPago');
        const miDialogoRegistrarPago:any = document.querySelector("#miDialogoRegistrarPago");

        btnRegistrarPago?.addEventListener('click',()=>{
            miDialogoRegistrarPago.showModal();
        });
    }

})();