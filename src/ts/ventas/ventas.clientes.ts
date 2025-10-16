(()=>{
  if(!document.querySelector('.ventas'))return;

    const POS = (window as any).POS;

    const btnAddCliente = document.querySelector('#addcliente') as HTMLElement;
    const btnAddDir = document.querySelector('#adddir') as HTMLElement;
    const miDialogoAddCliente = document.querySelector('#miDialogoAddCliente') as any;
    const miDialogoAddDir = document.querySelector('#miDialogoAddDir') as any;
    const selectCliente = document.querySelector('#selectCliente') as HTMLSelectElement;
    const dirEntrega = document.querySelector('#direccionEntrega')! as HTMLSelectElement;

  const gestionClientes = {

    clientes(){
        
        //////////// evento al boton añadir cliente nuevo //////////////
        btnAddCliente?.addEventListener('click', (e)=>{
        miDialogoAddCliente.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
        });
        //////////// evento al boton añadir nueva direccion //////////////
        btnAddDir?.addEventListener('click', (e)=>{
        miDialogoAddDir.showModal();
        document.addEventListener("click", cerrarDialogoExterno);
        });
        //////////// evento al btn submit del formulario add nuevo cliente //////////////
        document.querySelector('#formAddCliente')?.addEventListener('submit', e=>{
        e.preventDefault();
        (async ()=>{
            const datos = new FormData();
            datos.append('nombre', (document.querySelector('#nombreclientenuevo') as HTMLInputElement).value);
            datos.append('apellido', (document.querySelector('#clientenuevoapellido') as HTMLInputElement).value);
            datos.append('tipodocumento', (document.querySelector('#tipodocumento') as HTMLInputElement).value);
            datos.append('identificacion', (document.querySelector('#identificacion') as HTMLInputElement).value);
            datos.append('telefono', (document.querySelector('#telefono') as HTMLInputElement).value);
            datos.append('email', (document.querySelector('#clientenuevoemail') as HTMLInputElement).value);
            datos.append('idtarifa', (document.querySelector('#clientenuevotarifa') as HTMLSelectElement).value);
            datos.append('direccion', (document.querySelector('#clientenuevodireccion') as HTMLInputElement).value);
            datos.append('departamento', (document.querySelector('#departamento') as HTMLInputElement).value);
            datos.append('ciudad', (document.querySelector('#ciudad') as HTMLInputElement).value);
            try {
                const url = "/admin/api/apiCrearCliente";
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                addClienteSelect(resultado.nextID);
                POS.limpiarformdialog();
                }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
                }
            } catch (error) {
                console.log(error);
            }
        })();
        miDialogoAddCliente.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        });
        /////////////// añadir cliente al select despues de crearse ///////////////////
        function addClienteSelect(clienteID:string): void{
        const option = document.createElement('option');
        option.textContent = (document.querySelector('#nombreclientenuevo') as HTMLInputElement).value + " " + (document.querySelector('#clientenuevoapellido') as HTMLInputElement).value;
        option.value = clienteID;
        option.dataset.tipodocumento = (document.querySelector('#tipodocumento') as HTMLInputElement).value;
        option.dataset.identidad = (document.querySelector('#identificacion') as HTMLInputElement).value;
        selectCliente?.appendChild(option);
        $('#selectCliente').val(clienteID).trigger('change'); // seleccionar el cliente nuevo, en el select y dispara evento
        }
        //evento 'cambio' al selecionar cliente, tambien se ejecuta cuando se crea cliente nuevo//
        $("#selectCliente").on('change', (e)=>{
        const idcli = (e.target as HTMLInputElement).value;
        (async ()=>{
            try {
            const url = "/admin/api/direccionesXcliente?id="+idcli; //llamado a la API REST y se trae las direcciones segun cliente elegido
            const respuesta = await fetch(url); 
            const resultado = await respuesta.json(); 
            addDireccionSelect(resultado);
            } catch (error) {
                console.log(error);
            }
        })();
        const select = (e.target as HTMLSelectElement);
        const x:string = select.options[select.selectedIndex].dataset.identidad||'';
        (document.querySelector('#documento') as HTMLInputElement).value = x;
        });
        ////// añade direccion al select de direcciones, cuando se selecciona o se agrega un cliente o si se agrega un nueva direccion/////
        function addDireccionSelect<T extends {id:string, idcliente:string, idtarifa:string, tarifa:{id:string, idcliente:string, nombre:string, valor:string}, direccion:string, ciudad:string}>(addrs: T[]):void{
        while(dirEntrega?.firstChild)dirEntrega.removeChild(dirEntrega?.firstChild);
        const setTarifas = new Set();
        tarifas.length = 0;
        console.log(addrs);
        addrs.forEach(dir =>{
            const option = document.createElement('option');
            option.textContent = dir.direccion;
            option.value = dir.id;
            option.dataset.idcliente = dir.idcliente;
            option.dataset.idtarifa = dir.idtarifa;
            option.dataset.ciudad = dir.ciudad;
            dirEntrega.appendChild(option);
            dir.tarifa.idcliente = dir.idcliente;
            if(!setTarifas.has(dir.tarifa.id)){
            tarifas = [...tarifas, dir.tarifa];
            setTarifas.add(dir.tarifa.id);
            }
        });
        setTarifas.clear();
        printTarifaEnvio();
        valorCarritoTotal();
        (document.querySelector('#ciudadEntrega') as HTMLInputElement).value = addrs[0]?.ciudad??'No especificado';
        }
        ///////// Evento al select de direcciones ////////////
        dirEntrega?.addEventListener('change', (e)=>{
        const select = (e.target as HTMLSelectElement);
        const x:string = select.options[select.selectedIndex].dataset.ciudad||'';
        (document.querySelector('#ciudadEntrega') as HTMLInputElement).value = x;
        printTarifaEnvio();
        valorCarritoTotal();
        });

        ////////////////// evento al btn submit del formulario add direccion //////////////////////
        document.querySelector('#formAddDir')?.addEventListener('submit', e=>{
        e.preventDefault();
        (async ()=>{
            const datos = new FormData();
            datos.append('idcliente', selectCliente.value);
            datos.append('departamento', (document.querySelector('#adddepartamento') as HTMLInputElement).value);
            datos.append('ciudad', (document.querySelector('#addciudad') as HTMLInputElement).value);
            datos.append('direccion', (document.querySelector('#adddireccion') as HTMLInputElement).value);
            datos.append('idtarifa', (document.querySelector('#tarifa') as HTMLSelectElement).value);
            try {
                const url = "/admin/api/addDireccionCliente";  //direccionescontrolador
                const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                const resultado = await respuesta.json();
                if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                addDireccionSelect(resultado.direcciones);
                }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
                }
            } catch (error) {
                console.log(error);
            }
        })();
        miDialogoAddDir.close();
        document.removeEventListener("click", cerrarDialogoExterno);
        });
        
    }
    
  };

  (window as any).POS.gestionClientes = gestionClientes;


})();