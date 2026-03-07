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
            const detalleSuscrip = {
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
                const url = "/admin/api/suscripcion/detalleSuscripcion"; //llamado a la API REST suscripcioncontrolador.php actualiza la sucursal
                const respuesta = await fetch(url, {
                                            method: 'POST', 
                                            headers: { "Accept": "application/json", "Content-Type": "application/json" },
                                            body: JSON.stringify(detalleSuscrip) 
                                        });
                const resultado = await respuesta.json();
                console.log(resultado);
                if(resultado.exito != undefined){
                    msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                    actualizarDetalleSuscripcion(detalleSuscrip);
                }else{
                    msjalertToast('error', '¡Error!', resultado.error[0]);
                }

            } catch (error) {
                console.log(error);
            }
           miDialogoDetalleSuscripcion.close();
        });


        function actualizarDetalleSuscripcion(detalleSuscrip:{idplan: FormDataEntryValue, valorplan: number, fecha_corte: FormDataEntryValue, estado: FormDataEntryValue, descuento: number, detalle_descuento: FormDataEntryValue, cargo: number, detalle_cargo: FormDataEntryValue}){
            (document.querySelector('#fecha_corteText') as HTMLParagraphElement).textContent = detalleSuscrip.fecha_corte as string;
            (document.querySelector('#valorplanText') as HTMLParagraphElement).textContent = detalleSuscrip.valorplan.toLocaleString();
            (document.querySelector('#valorplanResumen') as HTMLParagraphElement).textContent = '$'+detalleSuscrip.valorplan.toLocaleString();
        }


        document.querySelector('#formRegistrarPago')?.addEventListener('submit', async(e:Event)=>{
            e.preventDefault();
            const form = e.target as HTMLFormElement;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            const pago = {
                cantidad_plan: data.cantidad_plan,
                valor_pagado: Number(data.valor_pagado)||0,
                medio_pago: data.medio_pago,
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
            if (f=== miDialogoRegistrarPago || f === miDialogoDetalleSuscripcion || (f as HTMLInputElement).value === 'Cancelar' || (f as HTMLButtonElement).closest('.btnXCerrarRegistroPago') ) {
                miDialogoRegistrarPago.close();
                miDialogoDetalleSuscripcion.close();
            }
        }
        
    }


})();