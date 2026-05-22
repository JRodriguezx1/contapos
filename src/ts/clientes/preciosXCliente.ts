(()=>{
    
    if(document.querySelector('.preciosXCliente')){
        const listaProductos = document.querySelector('.listaProductos');
        //const subproducto:HTMLSelectElement = document.querySelector('#subproducto')!;
        let precioPersonalizado = document.querySelector('#precioPersonalizado') as HTMLInputElement; //input cantidad

        

        
        ($('#productos') as any).select2({
            width: '100%',
            maximumSelectionLength: 1,
        });



        ///////////////// EVENTO AL FORMULARIO ASOCIAR PRODUCTO //////////////////
        document.querySelector('#formAddProducto')?.addEventListener('submit', (e)=>{
            e.preventDefault();
            const producto = $('#productos').find('option:selected');
            let valor:number = Number(precioPersonalizado.value);

            (async ()=>{ 
                const datos = new FormData();
                datos.append('idcliente', (document.querySelector('#idcliente') as HTMLInputElement).value);
                datos.append('idproducto', $('#productos').val()as string);
                datos.append('precioxcliente', valor.toString());
                try {
                    const url = "/admin/api/clientes/preciospersonalizados";  //asocia el precio personalizado al cliente
                    const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                    const resultado = await respuesta.json();
                    if(resultado.exito !== undefined){
                      msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                        /////validar si es el mismo subproducto, y actualizar 
                        validarProducto($('#productos').val()as string, producto.data('producto'));
                        ////// reset form ///////
                        ($('#productos') as any).val([]).trigger('change');
                        //$(`#subproducto option[value="${$('#subproducto').val()}"]`).remove();
                        (document.querySelector('#formAddProducto') as HTMLFormElement)?.reset();
                    }else{
                      msjalertToast('error', '¡Error!', resultado.error[0]);
                    }
                } catch (error) {
                    console.log(error);
                }
            })();//cierre de async()
        });


        function validarProducto(idproducto:string, producto:string){
            const pro = document.querySelector(`.listaProductos div[id="${idproducto}"]`);
            if(pro){
                pro.querySelector('strong')!.textContent = '$'+Number(precioPersonalizado.value).toLocaleString();
            }else{
                listaProductos?.insertAdjacentHTML('beforeend', `
                <div id="${idproducto}" class="mb-4 flex items-center justify-between p-4 text-blue-600 bg-blue-100 rounded-lg shadow-md shadow-blue-500/30" role="alert">
                    <p class="m-0"><strong>$${Number(precioPersonalizado.value).toLocaleString()}</strong>. - ${producto}</p>
                    <button type="button"><span id="${idproducto}" class="material-symbols-outlined">cancel</span></button>
                </div>`
                );
            }
        }


        listaProductos?.addEventListener('click', (e:Event)=>{
            const btn = (e.target as HTMLSpanElement); //contiene el id del producto
            if(btn.tagName == "SPAN")eliminarPrecioPersonalizado((document.querySelector('#idcliente') as HTMLInputElement).value, btn.id);
        });


        function eliminarPrecioPersonalizado(idcliente:string, idproducto:string){
            const pro = document.querySelector(`.listaProductos div[id="${idproducto}"]`);
            (async ()=>{
                try {
                  const url = "/admin/api/clientes/eliminarPrecioPersonalizado?idcliente="+idcliente+"&idproducto="+idproducto; //llamado a la API REST para eliminar precio personlizado a cliente
                  const respuesta = await fetch(url); 
                  const resultado = await respuesta.json();
                  if(resultado.exito !== undefined){
                    pro?.remove();
                    msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                  }else{
                    msjalertToast('error', '¡Error!', resultado.error[0]);
                  }
                } catch (error) {
                    console.log(error);
                }
            })();
        }


    }

})();