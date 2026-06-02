(():void=>{

  if(document.querySelector('.pendienteDespacho')){

    Object.assign(configdatatables25reg, { order: [[ 1, 'desc' ]] });
    ($('#tabladespachosPendientes') as any).DataTable(configdatatables25reg);

  }

})();