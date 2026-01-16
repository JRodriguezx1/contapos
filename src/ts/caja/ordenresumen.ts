(():void=>{
    if(document.querySelector('.ordenresumen')){
      const POS = (window as any).POS;
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
      const printcotizacion = document.querySelector('#printcotizacion');
      const numOrden = document.querySelector('#numOrden');
      const referenciaFactura = document.querySelector('#referenciaFactura');
      const enviarEmail = document.querySelector('#enviarEmail') as HTMLButtonElement;
      const miDialogoEnviarEmailCliente = document.querySelector('#miDialogoEnviarEmailCliente') as any;
      const inputEliminarClave = document.querySelector('#inputEliminarClave') as HTMLInputElement;

      const valorTotal = {subtotal: 0, impuesto: 0, dctox100: 0, descuento: 0, idtarifa: 0, valortarifa: 0, total: 0}; //datos global de la venta
      const mapMediospago = new Map();

      interface clavesApi {
      clave:string,
      valor_default:string|null,
      valor_final:string|null,
      valor_local:string|null
    };

    let claveEliminarOrden:clavesApi[];

    (async ()=>{
      try {
          const url = "/admin/api/getPasswords"; //llamado a la API REST
          const respuesta = await fetch(url); 
          const resultado = await respuesta.json(); 
          claveEliminarOrden = resultado;
      } catch (error) {
          console.log(error);
      }
    })();

  
      valorTotal.subtotal = Number(document.querySelector('#subTotal')?.textContent);
      valorTotal.total = Number(document.querySelector('#total')?.textContent?.replace(/[^\d]/g, ''));
      
      selectFacturadorSegunCaja(btnCaja);
    
      btnCaja.addEventListener('change', (e:Event)=>selectFacturadorSegunCaja(e.target as HTMLSelectElement));
    
      function selectFacturadorSegunCaja(z:HTMLSelectElement){
        $('#facturador').val(z.options[z.selectedIndex].dataset.idfacturador??'1');
      }

      printcarta?.addEventListener('click', ()=>{
        //leer parametros de url
        const parametrosURL = new URLSearchParams(window.location.search);
        const id = parametrosURL.get('id');
        const ventana = window.open('/printfacturacarta?id='+id, '_blank');
        if(ventana){
          ventana.onload = ()=>{
            ventana?.focus();
            ventana?.print();
            setTimeout(() => { ventana?.close(); }, 200); // Cerrar la ventana después de unos segundos
          };
        }
      });

      printcotizacion?.addEventListener('click', ()=>{
        //leer parametros de url
        const parametrosURL = new URLSearchParams(window.location.search);
        const id = parametrosURL.get('id');
        const ventana = window.open('/printcotizacion?id='+id, '_blank');
        if(ventana){
          ventana.onload = ()=>{
            ventana?.focus();
            ventana?.print();
            setTimeout(() => { ventana?.close(); }, 200); // Cerrar la ventana después de unos segundos
          };
        }
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


      enviarEmail?.addEventListener('click', ()=>{
        miDialogoEnviarEmailCliente.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
      });


      document.querySelector('#formEnviarEmailCliente')?.addEventListener('submit', (e:Event)=>{
        e.preventDefault();
        const idorden = (document.querySelector('#idorden') as HTMLElement).dataset.idorden;
        if(idorden!=null && Number(idorden)>0){
          const datos = new FormData();
          datos.append('id', idorden);
          datos.append('email', (document.querySelector('#inputEmail') as HTMLInputElement).value);
          miDialogoEnviarEmailCliente.close();
          document.removeEventListener("click", cerrarDialogoExterno);
          (async ()=>{
            try {
              const url = "/admin/api/sendOrdenEmailToCustemer";  //va al controlador cajacontrolador para enviar detalle de orden por email.
              const respuesta = await fetch(url, {method: 'POST', body: datos});
              const resultado = await respuesta.json();
              if(resultado.exito!=undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
            } catch (error) {
                console.log(error);
            }
          })();
        }
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
        (document.querySelector('.Efectivo')! as HTMLInputElement).value =  `${(valorTotal.total-totalotrosmedios).toLocaleString()}`;
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
        (mediospago[0] as HTMLInputElement).value = (mapMediospago.get('1')??0).toLocaleString();
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
      document.querySelector('#formfacturarCotizacion')?.addEventListener('submit', e=>{
        e.preventDefault();
        procesarpedido('Guardado');
      });

      async function procesarpedido(estado:string){ //////PROCESAR PAGO DE COTIZACION SiN CAMBIAR DATOS DE LOS PRODUCTOS//////
        const imprimir = document.querySelector('input[name="imprimir"]:checked') as HTMLInputElement;
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
        //datos.append('datosAdquiriente', JSON.stringify(POS.gestionarAdquiriente.datosAdquiriente));
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
              miDialogoFacturar.close();
              document.removeEventListener("click", cerrarDialogoExterno);
              if(resultado.idfactura && imprimir.value === '1')printTicketPOS(resultado.idfactura);
              if(btnTipoFacturador.options[btnTipoFacturador.selectedIndex].dataset.idtipofacturador == '1'){ 
                const resDian = await POS.sendInvoiceAPI.sendInvoice(resultado.idfactura); //llama a la funcion que esta en ts/ventas/ventas.sendinvoice.ts
                console.log(resDian);
              }
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
      }
  
      function printTicketPOS(idfactura:string){
      setTimeout(() => {
        window.open("/admin/printPDFPOS?id=" + idfactura, "_blank");
      }, 1200);
    }

      function ordenpagada(){
        if(btnfacturar)btnfacturar.style.display = "none";
        (document.querySelector('#abrirOrden') as HTMLElement).style.display = "none";
        (document.querySelector('#estadoOrden') as HTMLElement).textContent = "Paga";
      }
  
      function cerrarDialogoExterno(event:Event) {
        const f = event.target;
        if (event.target === miDialogoFacturar || event.target === miDialogoEliminarOrden || event.target === miDialogoEnviarEmailCliente || (f as HTMLInputElement).value === 'cancelar' || (f as HTMLInputElement).value === 'Salir' || (f as HTMLInputElement).closest('.noeliminar')) {
            miDialogoFacturar.close();
            miDialogoEliminarOrden.close();
            miDialogoEnviarEmailCliente.close();
            document.removeEventListener("click", cerrarDialogoExterno);
        }
      }

      //evento al boton confirmar para eliminar orden
      document.querySelector('.sieliminar')?.addEventListener('click', (event:Event)=>{
        const f = event.target;
        if((f as HTMLInputElement).closest('.sieliminar'))eliminarorden();
      });


      function eliminarorden():void{
        ///////*** crear arreglo de obj de los productos y sus cantidades ***///////
        type producto = {id:string, idproducto:string, tipoproducto:string, tipoproduccion:string, rendimientoestandar:string, cantidad: string };
        var products:producto[] = [];

        const v:number = validarPasswordDcto();
        if(!v)return;

        inputsInv.forEach(inputinv =>{
          const v = inputinv as HTMLInputElement;
          products = [...products, {id: v.id, idproducto: v.id, tipoproducto: v.dataset.tipoproducto!, tipoproduccion: v.dataset.tipoproduccion!, rendimientoestandar: v.dataset.rendimientoestandar!, cantidad: v.value}];
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
                miDialogoEliminarOrden.close();
                document.removeEventListener("click", cerrarDialogoExterno);
                btneliminarorden.style.display = "none";
                enviarEmail.style.display = "none";
                (document.querySelector('#estadoOrden') as HTMLElement).textContent = "Eliminada";
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();
      }


      function validarPasswordDcto():number{
      const clave = claveEliminarOrden.find(c => c.clave=='clave_para_eliminar_factura');
      if(clave?.valor_final!==null && inputEliminarClave.value !== clave?.valor_final){
        msjAlert('error', 'El password es invalido', (document.querySelector('#divmsjalerta1') as HTMLElement));
        return 0;
      }
      return 1;
    }

    }
  
})();