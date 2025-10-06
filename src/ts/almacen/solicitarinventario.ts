(()=>{

    if(document.querySelector('.solicitarinvnetario')){
        // PROCESO SOLICITUD DE INVENTARIO A OTRAS SEDES
        const btnAnterior = document.getElementById("btnAnteriorSolicitudInv") as HTMLButtonElement;
        const btnSiguiente = document.getElementById("btnSiguienteSolicitudInv") as HTMLButtonElement;
        const steps = document.querySelectorAll<HTMLDivElement>(".step-circle");
        const stepSections = document.querySelectorAll<HTMLElement>(".step-section");
        const addItem = document.querySelector('#addItem') as HTMLInputElement;
        let filteredData: {id:string, text:string, tipo:string, sku:string, unidadmedida:string}[];   //tipo = 0 es producto simple,  1 = subproducto
        let currentStep = 1;
        const totalSteps = 3;

        (async ()=>{
            try {
                const url = "/admin/api/totalitems"; //llamado a la API REST en el controlador almacencontrolador para treaer todas los productos simples y subproductos
                const respuesta = await fetch(url); 
                const resultado:{id:string, nombre:string, tipoproducto:string, sku:string, unidadmedida:string}[] = await respuesta.json(); 
                filteredData = resultado.map(item => ({ id: item.id, text: item.nombre, tipo: item.tipoproducto??'1', sku: item.sku, unidadmedida: item.unidadmedida }));
                activarselect2(filteredData);
            } catch (error) {
                console.log(error);
            }
        })();


        //establecer fecha por defecto
        const inputFecha = document.getElementById('fecha') as HTMLInputElement;
            const hoy = new Date();
            const yyyy = hoy.getFullYear();
            const mm = String(hoy.getMonth() + 1).padStart(2, '0'); // Mes con 2 dígitos
            const dd = String(hoy.getDate()).padStart(2, '0');      // Día con 2 dígitos
            inputFecha.value = `${yyyy}-${mm}-${dd}`;

        function actualizarProgreso() {
        // Actualizar barra de progreso
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            if (stepNumber < currentStep) {
            step.className =
                "step-circle w-10 h-10 rounded-full bg-green-500 text-white font-semibold flex items-center justify-center";
            } else if (stepNumber === currentStep) {
            step.className =
                "step-circle w-10 h-10 rounded-full bg-indigo-600 text-white font-semibold flex items-center justify-center";
            } else {
            step.className =
                "step-circle w-10 h-10 rounded-full border-2 border-gray-300 text-gray-400 font-semibold flex items-center justify-center";
            }
        });

        // Mostrar solo la sección actual
        stepSections.forEach((section, index) => {
            if (index + 1 === currentStep) {
            section.style.display = "block";
            } else {
            section.style.display = "none";
            }
        });

        // Deshabilitar/activar botones si es necesario
        btnAnterior.disabled = currentStep === 1;
        btnSiguiente.disabled = currentStep === totalSteps;
        }

        // Inicializar vista
        actualizarProgreso();

        // Eventos de navegación
        btnSiguiente.addEventListener("click", () => {
        if (currentStep < totalSteps) {
            currentStep++;
            actualizarProgreso();
        }
        });

        btnAnterior.addEventListener("click", () => {
        if (currentStep > 1) {
            currentStep--;
            actualizarProgreso();
        }
        });


        function activarselect2(filteredData:{id:string, text:string, tipo:string, sku:string, unidadmedida:string}[]){
            ($('#articulo') as any).select2({ 
                width: '100%',
                data: filteredData,
                placeholder: "Selecciona un item",
                maximumSelectionLength: 1,
            });
           
        }


        addItem.addEventListener('click', (e)=>{
            console.log((document.querySelector('#articulo') as HTMLInputElement).value);
        });

    }
})();