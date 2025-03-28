(():void=>{
    if(document.querySelector('.ordenresumen')){

      const miDialogoFacturar:any = document.querySelector("#miDialogoFacturar");
      const miDialogoEliminarOrden = document.querySelector('#miDialogoEliminarOrden') as any;
      const btnfacturar = document.querySelector<HTMLButtonElement>("#btnfacturar");
      const btneliminarorden = document.querySelector('#btneliminarorden') as HTMLButtonElement;
      const btnCaja = document.querySelector('#caja') as HTMLSelectElement;
      const btnTipoFacturador = document.querySelector('#facturador') as HTMLSelectElement;
      const mediospago = document.querySelectorAll('.mediopago');
      const btnsdevolverinv = document.querySelectorAll<HTMLInputElement>('input[name="devolverinventario"]'); //radio buttom
      const inputsInv = document.querySelectorAll<HTMLInputElement>('.inputInv');
      const printcarta = document.querySelector('#printcarta');

      const valorTotal = {subtotal: 0, impuesto: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
      const mapMediospago = new Map();
  
      valorTotal.subtotal = Number(document.querySelector('#subTotal')?.textContent);
      valorTotal.total = Number(document.querySelector('#total')?.textContent?.replace(/[^\d]/g, ''));
      
      

      printcarta?.addEventListener('click', ()=>{
        const ventana = window.open('/printfacturacarta?id=1', '_blank');
        ventana?.focus();
        ventana?.print();
        setTimeout(() => { ventana?.close(); }, 90); // Cerrar la ventana después de unos segundos
      });

      btnfacturar?.addEventListener('click', ()=>{
        /*if(modalidadEntrega.textContent === ": Domicilio" && (selectCliente.value =='1' || selectCliente.value =='2' || !dirEntrega.value)){
          msjAlert('error', 'Cliente o direccion no seleccionado', (document.querySelector('#divmsjalerta1') as HTMLElement));
          return;
        }*/
        /*if(carrito.length){*/
          subirModalPagar();
          miDialogoFacturar.showModal();
          document.addEventListener("click", cerrarDialogoExterno);
        //}
      });
      

      btneliminarorden?.addEventListener('click', ()=>{
          miDialogoEliminarOrden.showModal();
          document.addEventListener("click", cerrarDialogoExterno);
      });

      ///////////////////// Logica botones devolver inventario ////////////////////////
      btnsdevolverinv.forEach(inv=>{ //evento a los radiobutton
        inv.addEventListener('change', (e:Event)=>{
          document.querySelector('#productsInv')?.classList.toggle('hidden');
          if((e.target as HTMLInputElement).value === "1"){
            document.querySelectorAll('.inputInv').forEach(x=>x.setAttribute('required', ''));
          }else{
            document.querySelectorAll('.inputInv').forEach(x=>x.removeAttribute('required'));
          }
        });
      });

      inputsInv.forEach(inputinv =>{
        inputinv.addEventListener('input', e=>{
          const qty = (e.target as HTMLInputElement);
          if(qty.value != qty.parentElement?.dataset.qty){
            qty.classList.add('border-2', 'border-rose-600');
            if(!document.querySelector('.alerta'))
              msjAlert('error', 'Cantidad diferente a devolver a inventario', (document.querySelector('#divmsjalerta1') as HTMLElement));
          }else{
            qty.classList.remove('border-2', 'border-rose-600');
            document.querySelector('.alerta')?.remove();
          }
        });
      });

      /////////////////////  logica del modal de pago  //////////////////////////
      function subirModalPagar(){
        document.querySelector('#totalPagar')!.textContent = `${valorTotal.total.toLocaleString()}`;
        //como se puede cerrar el modal y aumentar los productos, hay calcular los inputs
        let totalotrosmedios = 0;
        mediospago.forEach((item, index)=>{
          if(index>0)totalotrosmedios += parseInt((item as HTMLInputElement).value.replace(/[,.]/g, ''));
        });

        if(valorTotal.total<totalotrosmedios){
          totalotrosmedios = 0;
          mapMediospago.clear();
          $('.mediopago').val(0);
        }
        (document.querySelector('.Efectivo')! as HTMLInputElement).value =  `${valorTotal.total-totalotrosmedios}`;
        mapMediospago.set('1', valorTotal.total-totalotrosmedios);
        if(valorTotal.total-totalotrosmedios == 0 && mapMediospago.has('1'))mapMediospago.delete('1');
        calcularCambio(document.querySelector<HTMLInputElement>('#recibio')!.value);
      }
  
      //eventos a los inputs medios de pago
      mediospago.forEach(m=>{m.addEventListener('input', (e)=>{ calcularmediospago(e);});}); 

      function calcularmediospago(e:Event){
        let totalotrosmedios = 0;
        mediospago.forEach((item, index)=>{ //sumar todos los medios de pago menos el efectivo
          if(index>0)totalotrosmedios += parseInt((item as HTMLInputElement).value.replace(/[,.]/g, ''));
        });
        if(totalotrosmedios<=valorTotal.total){
          mapMediospago.set('1', valorTotal.total-totalotrosmedios);
          if(valorTotal.total-totalotrosmedios == 0 && mapMediospago.has('1'))mapMediospago.delete('1');
          mapMediospago.set((e.target as HTMLInputElement).id, parseInt((e.target as HTMLInputElement).value.replace(/[,.]/g, '')));
          if((e.target as HTMLInputElement).value == '0' && mapMediospago.has((e.target as HTMLInputElement).id))mapMediospago.delete((e.target as HTMLInputElement).id);
        }else{ //si la suma de los medios de pago superan el valor total, toma el ultimo input digitado y lo reestablece a su ultimo valor
          if(mapMediospago.has((e.target as HTMLInputElement).id)){
            (e.target as HTMLInputElement).value = mapMediospago.get((e.target as HTMLInputElement).id).toLocaleString();
          }else{
            (e.target as HTMLInputElement).value = '0';
          }
        }
        (mediospago[0] as HTMLInputElement).value = mapMediospago.get('1')??0;
        calcularCambio(document.querySelector<HTMLInputElement>('#recibio')!.value);
      }

      /////////////////////  evento al input recibido  //////////////////////////
      document.querySelector<HTMLInputElement>('#recibio')?.addEventListener('input', (e)=>{
        calcularCambio((e.target as HTMLInputElement).value);
      });
      function calcularCambio(recibido:string):void{
        recibido = recibido.replace(/[,.]/g, '');
        if(Number(recibido)>mapMediospago.get('1')){
          (document.querySelector('#cambio') as HTMLElement).textContent = (Number(recibido)-mapMediospago.get('1')).toLocaleString()+'';
          return;
        }
        (document.querySelector('#cambio') as HTMLElement).textContent = '0';
      }


      ////////////////// evento al bton pagar del modal facturar //////////////////////
      document.querySelector('#formfacturar')?.addEventListener('submit', e=>{
        e.preventDefault();
        procesarpedido('Paga');
      });

      async function procesarpedido(estado:string){ //////PROCESAR PAGO DE COTIZACION//////
        const datos = new FormData();
        datos.append('id', (document.querySelector('#idorden') as HTMLElement).dataset.idorden!);
        //datos.append('idcliente', (document.querySelector('#selectCliente') as HTMLSelectElement).value);
        //datos.append('idvendedor', (document.querySelector('#vendedor') as HTMLInputElement).dataset.idvendedor!);
        datos.append('idcaja', btnCaja.value);
        datos.append('idconsecutivo', btnTipoFacturador.value);
        //datos.append('iddireccion', dirEntrega.value);
        //datos.append('idtarifazona', valorTotal.idtarifa+'');
        //datos.append('cliente', selectCliente.options[selectCliente.selectedIndex].textContent!);
        //datos.append('vendedor', (document.querySelector('#vendedor') as HTMLInputElement).value);
        datos.append('caja', (document.querySelector('#caja option:checked') as HTMLSelectElement).textContent!);
        datos.append('tipofacturador', btnTipoFacturador.options[btnTipoFacturador.selectedIndex].textContent!);
        //datos.append('direccion', dirEntrega.options[dirEntrega.selectedIndex].text);
        //datos.append('tarifazona', nombretarifa||'');
        //datos.append('carrito', JSON.stringify(carrito));
        //datos.append('totalunidades', totalunidades.textContent!);
        //datos.append('mediosPago', JSON.stringify(Object.fromEntries(mapMediospago)));
        datos.append('mediosPago', JSON.stringify(Array.from(mapMediospago, ([idmediopago, valor])=>({idmediopago, id_factura:0, valor}))));
        datos.append('recibido', document.querySelector<HTMLInputElement>('#recibio')!.value);
        datos.append('transaccion', '');
        datos.append('estado', estado);
        datos.append('cambioaventa', '1');  //cambioaventa por defecto es 0
        //datos.append('subtotal', valorTotal.subtotal+'');
        //datos.append('impuesto', valorTotal.impuesto+'');
        //datos.append('dctox100',valorTotal.dctox100+'');
        //datos.append('descuento',valorTotal.descuento+'');
        //datos.append('total', valorTotal.total.toString());
        datos.append('observacion', document.querySelector<HTMLTextAreaElement>('#observacion')!.value);
        //datos.append('departamento', '');
        //datos.append('ciudad', (document.querySelector('#ciudadEntrega') as HTMLInputElement).value);
        //datos.append('entrega', modalidadEntrega.textContent!.replace(': ', ''));
        //datos.append('valortarifa', valorTotal.valortarifa+'');
        //datos.append('opc1', '');
        //datos.append('opc2', '');
        try {
            const url = "/admin/api/facturarCotizacion";  //va al controlador ventascontrolador
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            console.log(resultado);
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              /////// reinciar modulo de ventas
              ordenpagada();
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
        miDialogoFacturar.close();
        document.removeEventListener("click", cerrarDialogoExterno);
      }
  

      function ordenpagada(){
        if(btnfacturar)btnfacturar.style.display = "none";
        (document.querySelector('#abrirOrden') as HTMLElement).style.display = "none";
        (document.querySelector('#estadoOrden') as HTMLElement).textContent = "Paga";
      }
  
      function cerrarDialogoExterno(event:Event) {
        const f = event.target;
        if (event.target === miDialogoFacturar || event.target === miDialogoEliminarOrden || (event.target as HTMLInputElement).value === 'cancelar' || (f as HTMLInputElement).closest('.noeliminar') || (f as HTMLInputElement).closest('.sieliminar')) {
            miDialogoFacturar.close();
            miDialogoEliminarOrden.close();
            if((f as HTMLInputElement).closest('.sieliminar'))eliminarorden();
            document.removeEventListener("click", cerrarDialogoExterno);
        }
      }


      function eliminarorden():void{
        ///////*** crear arreglo de obj de los productos y sus cantidades ***///////
        type producto = {id:string, idproducto:string, tipoproducto:string, cantidad: string };
        var products:producto[] = [];

        inputsInv.forEach(inputinv =>{
          const v = inputinv as HTMLInputElement;
          products = [...products, {id: v.id, idproducto: v.id, tipoproducto: v.dataset.tipoproducto!, cantidad: v.value}];
        });

        (async ()=>{
          const datos = new FormData();
          datos.append('id', (document.querySelector('#idorden') as HTMLElement).dataset.idorden!); //id de la factura
          datos.append('inv', JSON.stringify(products));
          datos.append('devolverinv', (document.querySelector('input[name="devolverinventario"]:checked') as HTMLInputElement).value);
          //datos.append('domicilio', 0);
          try {
              const url = "/admin/api/eliminarOrden";  //api llamada en cajacontrolador.php
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();
              if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                btneliminarorden.style.display = "none";
                (document.querySelector('#estadoOrden') as HTMLElement).textContent = "Eliminada";
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