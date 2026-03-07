(()=>{

    if(document.querySelector('.configsuscripcion')){
        const btnDetalleSuscriptor = document.getElementById('btnDetalleSuscriptor') as HTMLButtonElement;
        const btnRegistrarPago = document.getElementById('btnRegistrarPago') as HTMLButtonElement;
        const miDialogoRegistrarPago:any = document.querySelector("#miDialogoRegistrarPago");
        const miDialogoDetalleSuscripcion:any = document.querySelector("#miDialogoDetalleSuscripcion");

        document.addEventListener("click", cerrarDialogoExterno);

        btnDetalleSuscriptor?.addEventListener('click',()=>{
            miDialogoDetalleSuscripcion.showModal();
        });
        btnRegistrarPago?.addEventListener('click',()=>{
            miDialogoRegistrarPago.showModal();
        });


        document.querySelector('#formDetalleSuscripcion')?.addEventListener('submit', async(e:Event)=>{
            e.preventDefault();
            const form = e.target as HTMLFormElement;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            const pago = {
                idplan: data.idplan,
                valorplan: Number(data.valorplan)||0,
                fecha_corte: data.fecha_corte,
                estado: data.estado,
                descuento: Number(data.descuento)||0,
                detalle_descuento: data.detalle_descuento,
                cargo: Number(data.cargo)||0,
                detalle_cargo: data.detalle_cargo,
            }
            try {
                const url = "/admin/api/suscripcion/DetalleSuscripcion"; //llamado a la API REST suscripcioncontrolador.php actualiza la sucursal
                const respuesta = await fetch(url, {
                                            method: 'POST', 
                                            headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                            body: JSON.stringify(pago) 
                                        });
                const resultado = await respuesta.json();
                console.log(resultado);
            } catch (error) {
                console.log(error);
            }
           
        });


        document.querySelector('#formRegistrarPago')?.addEventListener('submit', async(e:Event)=>{
            e.preventDefault();
            const form = e.target as HTMLFormElement;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            const pago = {
                estado: data.estado,
                fecha_corte: data.fecha_corte,
                valor_pagado: Number(data.valor_pagado)||0,
                medio_pago: data.medio_pago,
                descuento: Number(data.descuento)||0,
                detalle_descuento: data.detalle_descuento,
                cargo: Number(data.cargo)||0,
                detalle_cargo: data.detalle_cargo,
                descripcion: data.descripcion,
            }
            try {
                const url = "/admin/api/suscripcion/registrarPago"; //llamado a la API REST suscripcioncontrolador.php
                const respuesta = await fetch(url, {
                                            method: 'POST', 
                                            headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                            body: JSON.stringify(pago) 
                                        });
                const resultado = await respuesta.json();
                console.log(resultado);
            } catch (error) {
                console.log(error);
            }
           
        });


        function cerrarDialogoExterno(event:Event) {
            const f = event.target;
            if (f=== miDialogoRegistrarPago || (f as HTMLInputElement).value === 'Cancelar' || (f as HTMLButtonElement).closest('.btnXCerrarRegistroPago') ) {
                miDialogoRegistrarPago.close();
            }
        }
        
    }


})();