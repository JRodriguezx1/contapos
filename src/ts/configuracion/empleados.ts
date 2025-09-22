(function(){
  if(document.querySelector('.empleados')){
    const crearempleado = document.querySelector('#crearempleado') as HTMLElement;
    const dialogoEmpleado:any = document.getElementById("miDialogoEmpleado");
    const dialogoContraseña = document.getElementById("miDialogoContraseña");
    const btnupImage = document.querySelector('#upImage') as HTMLInputElement;
    const btncustomUpImage = document.querySelector('#customUpImage') as HTMLButtonElement;
    const imginputfile = document.querySelector('#imginputfile') as HTMLImageElement;  //img

    const inputNombre = document.querySelector('#nombreempleado') as HTMLInputElement;
    const inputApellido = document.querySelector('#apellidoempleado') as HTMLInputElement;
    const inputnickname = document.querySelector('#nicknameempleado') as HTMLInputElement;
    const inputcedula = document.querySelector('#cedulaempleado') as HTMLInputElement;
    const inputpassword = document.querySelector('#passwordempleado') as HTMLInputElement;
    const inputpassword2 = document.querySelector('#passwordempleado2 ') as HTMLInputElement;
    const inputMovil = document.querySelector('#movilempleado ') as HTMLInputElement;
    const inputEmail = document.querySelector('#emailempleado') as HTMLInputElement;
    const inputDepartamento = document.querySelector('#departamentoempleado') as HTMLInputElement;
    const inputCiudad = document.querySelector('#ciudadempleado') as HTMLInputElement;
    const inputDireccion = document.querySelector('#direccionempleado') as HTMLInputElement;
    const inputPerfil = document.querySelector('#perfilempleado') as HTMLInputElement;

    let indiceFila=0, control=0, tablaempleados:HTMLElement;
    let empleadosapi: {
      id:string, 
      nombre: string,
      apellido: string,
      nickname: string,
      cedula: string,
      movil: string,
      email: string,
      departamento: string,
      ciudad: string,
      direccion: string,
      perfil: string,
      img:string,
      idusuariospermisos:{id:string, usuarioid:string, permisoid:string}[]
      permisos:{id:string, nombre:string}[]
    }[] =[];
      
    let unempleado:{
      id:string,
      nombre: string,
      apellido: string,
      nickname: string,
      cedula: string,
      movil: string,
      email: string,
      departamento: string,
      ciudad: string,
      direccion: string,
      perfil: string, 
      img:string,
      idusuariospermisos:{id:string, usuarioid:string, permisoid:string}[]
      permisos:{id:string, nombre:string}[]
    }|undefined;

    /////////////////  traer todos los empleados con sus skills  ///////////////////
    (async ()=>{
      try {
          const url = "/admin/api/getAllemployee"; //llamado a la API REST
          const respuesta = await fetch(url); 
          empleadosapi = await respuesta.json(); 
      } catch (error) {
          console.log(error);
      }
    })();

    inputPerfil.addEventListener('change', (e)=>{
      if((e.target as HTMLSelectElement).value == '2'){
        (document.querySelector('#contentpermisos') as HTMLElement).style.display = "none";
        (document.querySelector('#contentpermisosadmin') as HTMLElement).style.display = "none";
      }
      if((e.target as HTMLSelectElement).value == '3'){
        (document.querySelector('#contentpermisos') as HTMLElement).style.display = "none";
        (document.querySelector('#contentpermisosadmin') as HTMLElement).style.display = "block";
      }
      if((e.target as HTMLSelectElement).value == '4'){
        (document.querySelector('#contentpermisos') as HTMLElement).style.display = "block";
        (document.querySelector('#contentpermisosadmin') as HTMLElement).style.display = "none";
      }
    });

    //////////////////  TABLA //////////////////////
    tablaempleados = ($('#tablaempleados') as any).DataTable(configdatatables);

    //////////////////// ventana modal al crear empleado  //////////////////////
    crearempleado.addEventListener('click', (e)=>{
      control = 0;
      limpiarformdialog();
      document.querySelector('#modalEmpleado')!.textContent = "Crear empleado";
      (document.querySelector('#btnEditarCrearEmpleado') as HTMLInputElement).value = "Crear";
      dialogoEmpleado.showModal();
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
      if((e.target as HTMLElement)?.classList.contains("updatePassword")||(e.target as HTMLElement).parentElement?.classList.contains("updatePassword"))updatePassword(e);
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
      inputnickname.value = unempleado?.nickname??'';
      inputcedula.value = unempleado?.cedula??'';
      inputMovil.value = unempleado?.movil??'';
      inputEmail.value = unempleado?.email??'';
      inputDepartamento.value = unempleado?.departamento??'';
      inputCiudad.value = unempleado?.ciudad??'';
      inputDireccion.value = unempleado?.direccion??'';
      $('#perfilempleado').val(unempleado?.perfil??'');
      if(unempleado?.perfil == '2'){
        (document.querySelector('#contentpermisos') as HTMLElement).style.display = "none";
        (document.querySelector('#contentpermisosadmin') as HTMLElement).style.display = "none";
      }
      if(unempleado?.perfil == '3'){
        (document.querySelector('#contentpermisos') as HTMLElement).style.display = "none";
        (document.querySelector('#contentpermisosadmin') as HTMLElement).style.display = "block";
      }
      if(unempleado?.perfil == '4'){
        (document.querySelector('#contentpermisos') as HTMLElement).style.display = "block";
        (document.querySelector('#contentpermisosadmin') as HTMLElement).style.display = "none";
      }
      printpermisos(unempleado?.permisos??[]);
      indiceFila = (tablaempleados as any).row((e.target as HTMLElement).closest('tr')).index();
      dialogoEmpleado.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    function printpermisos(leave:{id:string, nombre:string}[]){
      document.querySelectorAll<HTMLInputElement>('#contentpermisos input[type="checkbox"]').forEach(checkbox=>{checkbox.checked=false}); //limpia los checkbox
      leave.forEach(s =>{
        const inputpermiso = document.querySelector(`input[value="${s.id}"]`) as HTMLInputElement;
        inputpermiso.checked = true;
      });
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
              msjAlert('error', 'No es un formato valido para la foto', (document.querySelector('#divmsjalertaempleado1') as HTMLElement));
              return;
            }
            if(imgFile.size>550000){ //si es mayor a 550KB
              msjAlert('error', 'La imagen no debe superar los 500KB', document.querySelector('#divmsjalertaempleado1')!);
              return;
            }
          }
        }

        var arraypermisos:{id:string, nombre:string}[] = [];
        document.querySelectorAll<HTMLInputElement>('#contentpermisos input[type="checkbox"]').forEach(x=>{
          if(x.checked)arraypermisos = [...arraypermisos, {id:x.value, nombre: x.nextElementSibling?.textContent??'permiso'}];
        });
        
        (async ()=>{ 
          const datos = new FormData();
          datos.append('id', unempleado!.id);
          datos.append('img', imgFile); //en el backend no se lee con $_POST, se lee con $_FILES
          datos.append('nombre', inputNombre.value);
          datos.append('apellido', inputApellido.value);
          datos.append('nickname', inputnickname.value);
          datos.append('cedula', inputcedula.value);
          datos.append('password', inputpassword.value);
          datos.append('password2', inputpassword2.value);
          datos.append('movil', inputMovil.value);
          datos.append('email', inputEmail.value);
          datos.append('departamento', inputDepartamento.value);
          datos.append('ciudad', inputCiudad.value);
          datos.append('direccion', inputDireccion.value);
          datos.append('perfil', inputPerfil.value);
          datos.append('idpermisos', JSON.stringify(arraypermisos.map(v=>v.id)));
          try {
              const url = "/admin/api/actualizarEmpleado";
              const respuesta = await fetch(url, {method: 'POST', body: datos}); 
              const resultado = await respuesta.json();  
              if(resultado.exito !== undefined){
                msjalertToast('success', '¡Éxito!', resultado.exito[0]);
                ///////// cambiar la fila completa, su contenido //////////
                const datosActuales = (tablaempleados as any).row(indiceFila+=info.start).data();
                /*NOMBRE*/datosActuales[1] = inputNombre.value +' '+inputApellido.value;
                /*img*/datosActuales[2] = `<div class="text-center"><img style="width: 40px;" src="/build/img/${resultado.rutaimg}" alt=""></div>`;
                /*USER*/datosActuales[3] = inputnickname.value;
                /*PERFIL*/datosActuales[6] = inputPerfil.value==='1'?'Empleado':inputPerfil.value=='2'?'Admin':'Propietario';
                //actualizar arreglo de permisos
                empleadosapi.forEach(a=>{
                  if(a.id == unempleado?.id){
                    a.permisos = arraypermisos;
                    a.img = resultado.rutaimg;
                  }
                });
                (tablaempleados as any).row(indiceFila).data(datosActuales).draw();
                (tablaempleados as any).page(info.page).draw('page'); //me mantiene la pagina actual
              }else{
                msjalertToast('error', '¡Error!', resultado.error[0]);
              }
              dialogoEmpleado.close();
              document.removeEventListener("click", cerrarDialogoExterno);
          } catch (error) {
              console.log(error);
          }
        })();//cierre de async()
      } //fin if(control)
    });


    ////////////////////  Actualizar contraseña del empleado  //////////////////////
    function updatePassword(e:Event){
      let idempleado = (e.target as HTMLElement).parentElement?.id;
      if((e.target as HTMLElement).tagName === 'I')idempleado = (e.target as HTMLElement).parentElement?.parentElement?.id;
      unempleado = empleadosapi.find(x => x.id==idempleado);
      (document.querySelector('#nombreEmpleadoPass') as HTMLElement).textContent = unempleado?.nombre+" "+(unempleado?.apellido??'');
      (dialogoContraseña as any)?.showModal();
      document.addEventListener("click", cerrarDialogoExterno);
    }

    document.querySelector('#formContraseña')?.addEventListener('submit', e=>{
      e.preventDefault();
      (async ()=>{
        const datos = new FormData();
        datos.append('id', unempleado!.id);
        datos.append('password', (document.querySelector('#changePassword') as HTMLInputElement).value);
        try {
            const url = "/admin/api/updatepassword";
            const respuesta = await fetch(url, {method: 'POST', body: datos}); 
            const resultado = await respuesta.json();
            if(resultado.exito !== undefined){
              msjalertToast('success', '¡Éxito!', resultado.exito[0]);
            }else{
              msjalertToast('error', '¡Error!', resultado.exito[0]);
            }
            (dialogoContraseña as any)?.close();
            document.removeEventListener("click", cerrarDialogoExterno);
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
                        (tablaempleados as any).row(indiceFila+info.start).remove().draw(); 
                        (tablaempleados as any).page(info.page).draw('page');
                        empleadosapi = empleadosapi.filter(x=>x.id!=idempleado);
                        Swal.fire(resultado.exito[0], '', 'success')
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
      if (event.target === dialogoEmpleado || event.target === dialogoContraseña || (event.target as HTMLInputElement).value === 'Cancelar') {
          dialogoEmpleado.close();
          (dialogoContraseña as any)?.close();
          document.removeEventListener("click", cerrarDialogoExterno);
      }
    }

    function limpiarformdialog(){
      imginputfile.src = ' ';
      (document.querySelector('#formCrearUpdateEmpleado') as HTMLFormElement)?.reset();
    }

  }
})();