(function(){
  if(document.querySelector('.empleado')){
    const crearempleado = document.querySelector('#crearempleado') as HTMLElement;
    const dialogo:any = document.getElementById("miDialogoEmpleado");
    const dialogoSkills = document.getElementById("miDialogoSkills");
    const btnupImage = document.querySelector('#upImage') as HTMLInputElement;
    const btncustomUpImage = document.querySelector('#customUpImage') as HTMLButtonElement;
    const imginputfile = document.querySelector('#imginputfile') as HTMLImageElement;  //img

    const inputNombre = document.querySelector('#nombre') as HTMLInputElement;
    const inputApellido = document.querySelector('#apellido') as HTMLInputElement;
    const inputMovil = document.querySelector('#movil ') as HTMLInputElement;
    const inputEmail = document.querySelector('#email') as HTMLInputElement;
    const inputDepartamento = document.querySelector('#departamento') as HTMLInputElement;
    const inputCiudad = document.querySelector('#ciudad') as HTMLInputElement;
    const inputDireccion = document.querySelector('#direccion') as HTMLInputElement;
    const inputPerfil = document.querySelector('#perfil') as HTMLInputElement;

    let indiceFila=0, control=0, tablaempleados:HTMLElement;
    let empleadosapi: {
      id:string, 
      nombre: string,
      apellido: string,
      movil: string,
      email: string,
      departamento: string,
      ciudad: string,
      direccion: string,
      perfil: string,
      img:string,
      idservicios:{idempleado:string, idservicio:string}[]
    }[] =[];
      
    let unempleado:{
      id:string,
      nombre: string,
      apellido: string,
      movil: string,
      email: string,
      departamento: string,
      ciudad: string,
      direccion: string,
      perfil: string, 
      img:string,
      idservicios:{idempleado:string, idservicio:string}[]
    }|undefined;

    /////////////////  traer todos los empleados con sus skills  ///////////////////
    /*(async ()=>{
      try {
          const url = "/admin/api/getAllemployee"; //llamado a la API REST
          const respuesta = await fetch(url); 
          empleadosapi = await respuesta.json(); 
          console.log(empleadosapi);
      } catch (error) {
          console.log(error);
      }
    })();*/

    //////////////////  TABLA //////////////////////
    tablaempleados = ($('#tablaempleados') as any).DataTable(configdatatables);

    //////////////////// ventana modal al crear empleado  //////////////////////
    crearempleado.addEventListener('click', (e)=>{
      control = 0;
      limpiarformdialog();
      document.querySelector('#modalEmpleado')!.textContent = "Crear empleado";
      (document.querySelector('#btnEditarCrearEmpleado') as HTMLInputElement).value = "Crear";
      dialogo.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    });

     //////////////////// Cargar imagen como preview  //////////////////////
    btncustomUpImage.addEventListener('click', ()=>btnupImage.click());
    btnupImage.addEventListener('change', function(){
      const file = this.files?.[0];
      if(file){
        const reader = new FileReader();
        reader.onload = function(){
          const resrult:(string | ArrayBuffer | null) = reader.result;
          if(typeof resrult == "string")imginputfile.src = resrult;
        } 
        reader.readAsDataURL(file);
      }
    });


    document.querySelector('#tablaempleados')?.addEventListener("click", (e)=>{ //evento click sobre toda la tabla
      const target = e.target as HTMLElement;
      if((e.target as HTMLElement)?.classList.contains("editarEmpleado")||(e.target as HTMLElement).parentElement?.classList.contains("editarEmpleado"))editarEmpleado(e);
      if((e.target as HTMLElement)?.classList.contains("empleadoSkills")||(e.target as HTMLElement).parentElement?.classList.contains("empleadoSkills"))empleadoSkills(e);
      if(target?.classList.contains("eliminarEmpleado")||target.parentElement?.classList.contains("eliminarEmpleado"))eliminarEmpleado(e);
    });

    //////////////////// ventana modal al Actualizar/Editar empleado  //////////////////////
    function editarEmpleado(e:Event){
      let idempleado = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement)?.tagName === 'I')idempleado = (e.target as HTMLElement).parentElement?.parentElement?.id;
      control = 1;
      document.querySelector('#modalEmpleado')!.textContent = "Actualizar Empleado";
      (document.querySelector('#btnEditarCrearEmpleado') as HTMLInputElement)!.value = "Actualizar";
      unempleado = empleadosapi.find(x => x.id==idempleado); //me trae al empleado seleccionado
      imginputfile.src = "/build/img/"+unempleado?.img;
      inputNombre.value = unempleado?.nombre??'';
      inputApellido.value = unempleado?.apellido??'';
      inputMovil.value = unempleado?.movil??'';
      inputEmail.value = unempleado?.email??'';
      inputDepartamento.value = unempleado?.departamento??'';
      inputCiudad.value = unempleado?.ciudad??'';
      inputDireccion.value = unempleado?.direccion??'';
      $('#perfil').val(unempleado?.perfil??'');
      indiceFila = (tablaempleados as any).row((e.target as HTMLElement).closest('tr')).index();
      dialogo.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    ////////////////////  Actualizar/Editar empleado  //////////////////////
    document.querySelector('#formCrearUpdateEmpleado')?.addEventListener('submit', e=>{
      if(control){
        e.preventDefault();
        var imgFile:(string|File), info = (tablaempleados as any).page.info();
        imgFile=unempleado!.img;
        if(!imginputfile.src.includes(unempleado!.img)){ //cambio de imagen
          imgFile = ((e.target as HTMLFormElement).elements.namedItem("upImage") as HTMLInputElement).files?.[0]!; //obtengo el archivo
          if(imgFile){
            if(imgFile.type!=="image/png"&&imgFile.type!=="image/jpeg"){
              msjAlert('error', 'No es un formato valido para la foto', (document.querySelector('#divmsjalerta1') as HTMLElement));
              return;
            }
            if(imgFile.size>550000){ //si es mayor a 550KB
              msjAlert('error', 'La imagen no debe superar los 500KB', document.querySelector('#divmsjalerta1')!);
              return;
            }
          }
        }
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('idempleado', unempleado!.id);
          datos.append('img', imgFile); //en el backend no se lee con $_POST, se lee con $_FILES
          datos.append('nombre', inputNombre.value);
          datos.append('apellido', inputApellido.value);
          datos.append('movil', inputMovil.value);
          datos.append('email', inputEmail.value);
          datos.append('departamento', inputDepartamento.value);
          datos.append('ciudad', inputCiudad.value);
          datos.append('direccion', inputDireccion.value);
          datos.append('perfil', inputPerfil.value);
          try {
              const url = "/admin/api/actualizarEmpleado";
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                /// actualizar el arregle del empleado ///
                //
                ///////// cambiar la fila completa, su contenido //////////
                const datosActuales = (tablaempleados as any).row(indiceFila+=info.start).data();
                /*NOMBRE*/datosActuales[1] = inputNombre.value +' '+inputApellido.value;
                /*img*/datosActuales[2] = `<div class="text-center"><img style="width: 40px;" src="/build/img/${resultado.rutaimg[0]}" alt=""></div>`;
                /*MOVIL*/datosActuales[3] = inputMovil.value;
                /*EMAIL*/datosActuales[4] = inputEmail.value;
                /*CEDULA*/datosActuales[5] = ' ';
                /*PERFIL*/datosActuales[6] = inputPerfil.value==='1'?'Empleado':inputPerfil.value=='2'?'Admin':'Propietario';
                
                (tablaempleados as any).row(indiceFila).data(datosActuales).draw();
                (tablaempleados as any).page(info.page).draw('page'); //me mantiene la pagina actual
              }else{
                msjalertToast('error', '¡Error!', resultado.exito[0]);
              }
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
      } //fin if(control)
    });


    ////////////////////  Actualizar skills del empleado  //////////////////////
    function empleadoSkills(e:Event){
      let idempleado = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement).tagName === 'I')idempleado = (e.target as HTMLElement).parentElement?.parentElement?.id;
      document.querySelectorAll<HTMLInputElement>('.inputskills input[type="checkbox"]').forEach(checkbox=>{checkbox.checked=false}); //limpia los checkbox
      unempleado = empleadosapi.find(x => x.id==idempleado);
      var idservicios = unempleado?.idservicios; //servicios es el arreglo con solo los skills
      idservicios?.forEach(s =>{
        const inputskill:HTMLInputElement = document.querySelector(`input[data-skillid="${s.idservicio}"]`)!;
        inputskill.checked = true;
      });
      (dialogoSkills as any)?.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    document.querySelector('#formSkills')?.addEventListener('submit', e=>{
      e.preventDefault();
      var arrayservicios:string[]=[];
      document.querySelectorAll<HTMLInputElement>('.inputskills input[type="checkbox"]').forEach(x=>{if(x.checked)arrayservicios = [...arrayservicios, x.value];});
      (async ()=>{
        const datos = new FormData();
        datos.append('idempleado', unempleado!.id);
        datos.append('idservicio', arrayservicios.toString());
        try {
            const url = "/admin/api/actualizarSkillsEmpleado";
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
              /// actualizar el arregle de los skills "empleadosapi" ///
              empleadosapi.forEach(elemento => {
                if(elemento.id == unempleado!.id)
                  for(let a:number=0; a<arrayservicios.length; a++)
                    elemento.idservicios = [...elemento.idservicios, {idempleado: unempleado!.id, idservicio: arrayservicios[a]}];
              });

            }else{
              msjalertToast('error', '¡Error!', resultado.exito[0]);
            }
        } catch (error) {
            console.log(error);
        }
      })();
    });


    ////////////////////  Eliminar el empleado  //////////////////////
    function eliminarEmpleado(e:Event){
      let idempleado = (e.target as HTMLElement).parentElement!.id, info = (tablaempleados as any).page.info();
      if((e.target as HTMLElement).tagName === 'I')idempleado = (e.target as HTMLElement).parentElement!.parentElement!.id;
      indiceFila = (tablaempleados as any).row((e.target as HTMLElement).closest('tr')).index();
      Swal.fire({
          customClass: {confirmButton: 'sweetbtnconfirm', cancelButton: 'sweetbtncancel'},
          icon: 'question',
          title: 'Desea eliminar el empleado?',
          text: "El empleado sera eliminado definitivamente.",
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No',
      }).then((result:any) => {
          if (result.isConfirmed) {
              (async ()=>{ 
                  const datos = new FormData();
                  datos.append('id', idempleado);
                  try {
                      const url = "/admin/api/eliminarEmpleado";
                      const respuesta = await fetch(url, {method: 'POST', body: datos}); 
                      const resultado = await respuesta.json();  
                      if(resultado.exito !== undefined){
                        Swal.fire(resultado.exito[0], '', 'success')
                        (tablaempleados as any).row(indiceFila+info.start).remove().draw(); 
                        (tablaempleados as any).page(info.page).draw('page'); 
                      }else{
                          Swal.fire(resultado.error[0], '', 'error')
                      }
                  } catch (error) {
                      console.log(error);
                  }
              })();//cierre de async()
          }
      });
    }


    function cerrarDialogoExterno(event:Event) {
      if (event.target === dialogo || event.target === dialogoSkills || (event.target as HTMLInputElement).value === 'cancelar' || (event.target as HTMLInputElement).value === 'Actualizar') {
          dialogo.close();
          (dialogoSkills as any)?.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      imginputfile.src = ' ';
      (document.querySelector('#formCrearUpdateEmpleado') as HTMLFormElement)?.reset();
    }

  }
})();