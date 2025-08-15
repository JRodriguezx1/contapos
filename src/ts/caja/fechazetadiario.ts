(():void=>{

  if(document.querySelector('.fechazetadiario')){

    const btnsmultiselect = document.querySelectorAll<HTMLElement>('.btnmultiselect');
    const items = document.querySelectorAll<HTMLLIElement>('.item');
    const consultarZDiario = document.querySelector('#consultarZDiario') as HTMLButtonElement;


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
    });

    consultarZDiario.addEventListener('click', ()=>{
      
    });

  }

})();