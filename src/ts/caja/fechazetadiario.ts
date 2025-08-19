(():void=>{

  if(document.querySelector('.fechazetadiario')){

    const btnsmultiselect = document.querySelectorAll<HTMLElement>('.btnmultiselect');
    const items = document.querySelectorAll<HTMLLIElement>('.item');
    const consultarZDiario = document.querySelector('#consultarZDiario') as HTMLButtonElement;
    let fechainicio:string = "", fechafin = "";

    //evento a los select drop dawn para abrir y cerrar
    btnsmultiselect.forEach((btnmultiselect, index) =>{
      btnmultiselect.addEventListener('click', (e:Event)=>{
        cerrarlosmultiselect(index);
        btnmultiselect.classList.toggle('open');
      });
    });
    function cerrarlosmultiselect(index:number){
      btnsmultiselect.forEach((element, i) =>{
        if(i != index || !element.classList.contains('open'))element.classList.remove('open');
      });
    }
    document.querySelector('.fechazetadiario')?.addEventListener('click', (e:Event)=>{
      if(!(e.target as HTMLElement).closest('.btnmultiselect')&&!(e.target as HTMLElement).closest('.list-items')){
        const btnmultiselect = document.querySelector('.open');
        if(btnmultiselect)btnmultiselect.classList.toggle('open');
      }
    });



    // SELECTOR DE FECHAS DEL CALENDARIO
    ($('input[name="datetimes"]')as any).daterangepicker({
      timePicker: true,
      //startDate: moment().startOf('hour'),
      //endDate: moment().startOf('hour').add(32, 'hour'),
      endDate: moment().set({ hour: 23, minute: 59, second: 59 }),
      locale: {
        format: 'M/DD hh:mm A'
      }
    });

    $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
        var endDate = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
        /*objDateRange.inicio = startDate;
        objDateRange.fin = endDate;*/
        console.log(startDate);
        console.log(endDate);
        fechainicio = startDate;
        fechafin = endDate;
    });

    consultarZDiario.addEventListener('click', ()=>{
      const cajas = document.querySelectorAll<HTMLInputElement>('input.caja[type="checkbox"]:checked');
      const facturadores = document.querySelectorAll<HTMLInputElement>('input.facturador[type="checkbox"]:checked');
      
      const valuecajas:string[] = Array.from(cajas).map(c=>c.value);
      const valuefacturadores:string[] = Array.from(facturadores).map(f=>f.value);

      (async ()=>{
        const datos = new FormData();
        datos.append('cajas', JSON.stringify(valuecajas));
        datos.append('facturadores', JSON.stringify(valuefacturadores));
        try {
            const url = "/admin/api/consultafechazetadiario";
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            console.log(resultado);
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              imprimirIngresos();
            }else{
              msjalertToast('error', '¡Error!', resultado.error[0]);
            }
        } catch (error) {
            console.log(error);
        }
      })();

    });


    function imprimirIngresos(){
      
    }

  }

})();