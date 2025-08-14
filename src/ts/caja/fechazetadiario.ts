(():void=>{

  if(document.querySelector('.fechazetadiario')){

    const btnmultiselect = document.querySelector('.btnmultiselect') as HTMLElement;
    const items = document.querySelectorAll<HTMLLIElement>('.item');

    //abrir el menu desplegable para seleccionar cajas
    btnmultiselect.addEventListener('click', ()=>{btnmultiselect.classList.toggle('open');});

    


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
  }

})();