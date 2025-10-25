<?php

namespace Controllers;

use Classes\Email;
use Model\configuraciones\caja;
use Model\configuraciones\consecutivos;
use Model\configuraciones\usuarios; //namespace\clase hija
use Model\configuraciones\negocio;
use Model\configuraciones\mediospago;
use Model\ActiveRecord;
use Model\configuraciones\bancos;
use Model\caja\cierrescajas;
use Model\parametrizacion\config_local;
use Model\configuraciones\permisos;
use Model\configuraciones\tarifas;
use Model\configuraciones\tipofacturador;
use Model\configuraciones\usuarios_permisos;
use Model\sucursales;
use MVC\Router;  //namespace\clase
 
class configcontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de configuracion')&&userPerfil()>=3)return;
    $alertas = [];
    $idsucursal = id_sucursal();
    $sucursal = sucursales::find('id', $idsucursal);
    $empleados = usuarios::whereArray(['idsucursal'=>$idsucursal, 'confirmado'=>1]);
    $mediospago = mediospago::all();
    $cajas = caja::idregistros('idsucursalid', $idsucursal);
    $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
    $tipofacturadores = tipofacturador::all();
    $bancos = bancos::all();
    $tarifas = tarifas::all();
    $companias = [];
    $empleado = new \stdClass();
    $empleado->perfil = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    foreach($cajas as $caja)$caja->nombreconsecutivo = consecutivos::find('id', $caja->idtipoconsecutivo);
    foreach($consecutivos as $consecutivo)$consecutivo->nombretipofacturador = tipofacturador::find('id', $consecutivo->idtipofacturador)->nombre;
    
    $conflocal = config_local::getParamGlobal();
    $router->render('admin/configuracion/index', ['titulo'=>'Configuracion', 'paginanegocio'=>'checked', 'negocio'=>$sucursal, 'empleado'=>$empleado, 'empleados'=>$empleados, 'cajas'=>$cajas, 'facturadores'=>$consecutivos, 'tipofacturadores'=>$tipofacturadores, 'bancos'=>$bancos, 'tarifas'=>$tarifas, 'companias'=>$companias, 'mediospago'=>$mediospago, 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'user'=>$_SESSION]);   //  'autenticacion/login' = carpeta/archivo
  }


  public static function editarnegocio(Router $router){ //metodo para el llenado y actualizacion de los datos del negocio
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de configuracion')&&userPerfil()>=3)return;
        $alertas = [];
        $idsucursal = id_sucursal();
        $sucursal = sucursales::find('id', $idsucursal);

        $subdominio = explode('.', $_SERVER['HTTP_HOST'])[0];
        $dirlogo = $_SERVER['DOCUMENT_ROOT']."/build/img/".$subdominio;
        if (!is_dir($dirlogo))mkdir($dirlogo, 0755, true);

        $alertas = $sucursal->validarimgnegocio($_FILES);

        if($sucursal){ //actualizar
            if($_SERVER['REQUEST_METHOD'] === 'POST' ){
                $sucursal->compara_objetobd_post($_POST);
                $alertas = $sucursal->validar();
                if(!$alertas){
                    if($_FILES['logo']['name']){
                        $rutaimg = $_SERVER['DOCUMENT_ROOT']."/build/img/".$sucursal->logo;
                        $existe_archivo = file_exists($rutaimg);
                        if($existe_archivo)unlink($rutaimg);
                        $url_temp = $_FILES["logo"]["tmp_name"];
                        $sucursal->logo = $subdominio.'/'.uniqid().$_FILES['logo']['name'];
                        $rutaimg = $_SERVER['DOCUMENT_ROOT']."/build/img/".$sucursal->logo;
                        if(move_uploaded_file($url_temp, $rutaimg)){
                            desactivarInterlacedPNG($rutaimg);
                        }
                    }
                    $r = $sucursal->actualizar();
                    if($r)$alertas['exito'][] = "Datos de la sucursal actualizado";
                }
            }
        }else{  //crear
            if($_SERVER['REQUEST_METHOD'] === 'POST' ){
                $sucursal = new sucursales($_POST);
                $sucursal->logo = $_FILES['logo']['name']; //solo se utiliza para validar los datos del sucursal
                $alertas = $sucursal->validar();
                if(!$alertas){
                    if($_FILES['logo']['name']){ //valida si se seleccion img en el form
                        $nombreimg = explode(".", $_FILES['logo']['name']);  // = "barberyeison.jpg"
                        $sucursal->logo = $subdominio.'/'.uniqid().$_FILES['logo']['name'];
                        $existe_archivo1 = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/$subdominio/$nombreimg[0].webp");
                        $existe_archivo2 = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/$subdominio/$nombreimg[0].png");
                        $existe_archivo3 = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/$subdominio/$nombreimg[0].jpg");
                        if($existe_archivo1)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/$subdominio/$nombreimg[0].webp");
                        if($existe_archivo2)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/$subdominio/$nombreimg[0].png");
                        if($existe_archivo3)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/$subdominio/$nombreimg[0].jpg");
                        
                        $url_temp = $_FILES["logo"]["tmp_name"];
                        if(move_uploaded_file($url_temp, $_SERVER['DOCUMENT_ROOT']."/build/img/".$sucursal->logo)){
                            desactivarInterlacedPNG($_SERVER['DOCUMENT_ROOT']."/build/img/".$sucursal->logo);
                        }
                    }  
                    
                    $r = $sucursal->crear_guardar();
                    if($r)$alertas['exito'][] = "Datos de la sucursal actualizado";
                    //if($r)header('Location: /admin/dashboard/entrada');
                }
            }
        }
        $mediospago = mediospago::all();
        $empleados = usuarios::whereArray(['idsucursal'=>$idsucursal, 'confirmado'=>1]);
        $cajas = caja::idregistros('idsucursalid', $idsucursal);
        $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
        $tipofacturadores = tipofacturador::all();
        $bancos = bancos::all();
        $tarifas = tarifas::all();
        $companias = [];
        $empleado = new \stdClass();
         $empleado->perfil = '';
        $conflocal = config_local::getParamGlobal();
        $router->render('admin/configuracion/index', ['titulo'=>'configuracion', 'paginanegocio'=>'checked', 'negocio'=>$sucursal, 'empleado'=>$empleado, 'empleados'=>$empleados, 'cajas'=>$cajas, 'facturadores'=>$consecutivos, 'tipofacturadores'=>$tipofacturadores, 'bancos'=>$bancos, 'tarifas'=>$tarifas, 'companias'=>$companias, 'mediospago'=>$mediospago, 'conflocal'=>$conflocal, 'alertas'=>$alertas, 'user'=>$_SESSION]);
    }


    public static function crear_empleado(Router $router){ //metodo para crear empleado
        session_start();
        isadmin();
        if(!tienePermiso('Habilitar modulo de configuracion')&&userPerfil()>=3)return;
        $alertas = [];
        $usuarios_permisos = new usuarios_permisos;
        $idsucursal = id_sucursal();
        $sucursal = sucursales::find('id', $idsucursal);
        $permisos = $_POST['permisos']??[];
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $empleado = new usuarios($_POST);
            $alertas = $empleado->validarimgempleado($_FILES);
            $alertas = $empleado->validarempleado();
        
            if(empty($alertas)){
                if($_FILES['img']['name']){
                    $empleado->img = 'cliente1/avatar/'.uniqid().$_FILES['img']['name'];
                    $url_temp = $_FILES["img"]["tmp_name"];
                    move_uploaded_file($url_temp, $_SERVER['DOCUMENT_ROOT']."/build/img/".$empleado->img);
                }
                $empleado->hashPassword();
                $empleado->confirmado = 1;
                try {
                    $r = $empleado->crear_guardar();
                    if($r[0]){
                        $r2 = true;
                        foreach($permisos as $index => $value)$crearpermisos[$index] = ['usuarioid' => $r[1], 'permisoid'=>$value];
                        if(isset($crearpermisos))$r2 = $usuarios_permisos->crear_varios_reg($crearpermisos);
                        if($r2)$alertas['exito'][] = "Usuario creado correctamente";
                    }
                } catch (\Throwable $th) {
                    $alertas['error'][] = "EL usuario ya existe en otra sucursal, colcoar otro usuario en esta sucursal.";
                }
                
                //unset($empleado);
                $empleado = new \stdClass();
                $empleado->perfil = '';
            }
        }
        $empleados = usuarios::whereArray(['idsucursal'=>$idsucursal, 'confirmado'=>1]);
        $cajas = caja::idregistros('idsucursalid', $idsucursal);
        $consecutivos = consecutivos::whereArray(['id_sucursalid'=>$idsucursal, 'estado'=>1]);
        $tipofacturadores = tipofacturador::all();
        $bancos = bancos::all();
        $companias = [];
        $mediospago = mediospago::all();
        $conflocal = config_local::getParamGlobal();
        $router->render('admin/configuracion/index', ['titulo'=>'Administracion', 'paginaempleado'=>'checked', 'negocio'=>$sucursal, 'empleado'=>$empleado??'', 'empleados'=>$empleados, 'cajas'=>$cajas, 'facturadores'=>$consecutivos, 'tipofacturadores'=>$tipofacturadores, 'bancos'=>$bancos, 'companias'=>$companias, 'mediospago'=>$mediospago, 'alertas'=>$alertas, 'conflocal'=>$conflocal, 'user'=>$_SESSION]);
    }

  ///////////////////////////////////  Apis ////////////////////////////////////
    public static function getAllemployee(){ //api llamada desde empleados.ts entrega todos los empleados con sus permisos
        session_start();
        $empleados = usuarios::whereArray(['idsucursal'=>id_sucursal(), 'confirmado'=>1]);
        foreach($empleados as $empleado){
            $empleado->idusuariospermisos = usuarios_permisos::idregistros('usuarioid', $empleado->id);
            foreach($empleado->idusuariospermisos as $value)$empleado->permisos[] = permisos::find('id', $value->permisoid);
        }
        echo json_encode($empleados);
    }

    public static function actualizarEmpleado(){ //actualizar editar empleado
        session_start();
        $alertas = []; 
        $empleado = usuarios::find('id', $_POST['id']);
       
        $permisosactualesDB = usuarios_permisos::idregistros('usuarioid', $_POST['id']);  //permisos actuales en DB
        $idpermisosFront = json_decode($_POST['idpermisos']);  //permisos que viene del front
        
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $usuarios_permisos = new usuarios_permisos;
            $empleado->compara_objetobd_post($_POST);

            if(isset($_FILES['img']['name']))$alertas = $empleado->validarimgempleado($_FILES);
            $alertas = $empleado->validarempleadoexistente();
            $empleado->hashPassword();
            if(empty($alertas)){
                if(isset($_FILES['img']['name'])){
                    if($empleado->img){ //si la imagen ya existe DB, eliminarla
                        $existe_archivo = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/".$empleado->img);
                        if($existe_archivo)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/".$empleado->img);
                    }
                    $empleado->img = 'cliente1/avatar/'.uniqid().$_FILES['img']['name'];
                    $url_temp = $_FILES["img"]["tmp_name"];
                    move_uploaded_file($url_temp, $_SERVER['DOCUMENT_ROOT']."/build/img/".$empleado->img);
                }
                $r = $empleado->actualizar();
                if($r){
                    $arrayIdeliminar = []; $arrayIdnew = []; $r1=true; $r2[0]=true;
                    
                    foreach($permisosactualesDB as $key => $value) //calculo de los id de los permisos a eliminar
                        if(!in_array($value->permisoid, $idpermisosFront))$arrayIdeliminar[] = $value->id;

                    /////traerme los nuevos id de los permisos para agregarlo como nuevo////
                    foreach($idpermisosFront as $index => $front){
                        $x = true;
                        foreach($permisosactualesDB as $key => $value)
                            if($value->permisoid == $front){
                                $x = false;
                                break;
                            }
                        if($x)$arrayIdnew[$index] = ['usuarioid' => $_POST['id'], 'permisoid' => $front];
                    }
                    
                    if($arrayIdeliminar)$r1 = usuarios_permisos::eliminar_idregistros('id', $arrayIdeliminar);
                    if($arrayIdnew)$r2 = $usuarios_permisos->crear_varios_reg($arrayIdnew); 
                    if($r1==false || $r2[0]==false || $r1==true&&$r2[0]==false || $r1==false&&$r2[0]==true){
                        $alertas['error'][] = "Error en el proceso, intentalo nuevamente...";
                    }else{
                        $alertas['exito'][] = "permisos del empleado actualizadas";
                    }
                }else{
                    $alertas['error'][] = "Error en el proceso, intentalo nuevamente...";
                }
            }
        } //fin if(SERVER['REQUEST_METHOD])  
        $alertas['rutaimg'] = $empleado->img;
        echo json_encode($alertas);  
    }  //fin funcion public


    public static function eliminarEmpleado(){ //api llamada desde empleados.ts 
        session_start();
        $alertas = [];
        $empleado = usuarios::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($empleado)){
                if($empleado->img){ //si la imagen ya existe DB, eliminarla
                    $existe_archivo = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/".$empleado->img);
                    if($existe_archivo)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/".$empleado->img);
                }
                $r = $empleado->eliminar_registro();
                if($r){
                    $alertas['exito'][] = "Empleado eliminado correctamente";
                }else{
                    $alertas['error'][] = "Error en el proceso, intentalo nuevamente...";
                }
            }else{
                $alertas['error'][] = "Error en el proceso, intentalo nuevamente...";
            }
        }
        echo json_encode($alertas);
    }


    public static function updatepassword(){ //api llamada desde empleados.ts 
        session_start();
        $alertas = [];
        $empleado = usuarios::find('id', $_POST['id']);
        $empleado->password = $_POST['password'];
        if(strlen($empleado->password)>60){
            $alertas['error'][] = "El password no puede superar los 60 caracteres de longitud";
        }elseif(strlen($empleado->password)<3){
            $alertas['error'][] = 'El password es muy corto';
        }else{
            $empleado->hashPassword();
            $r = $empleado->actualizar();
            if($r){
                $alertas['exito'][] = "Password cambiado correctamente";
            }else{
                $alertas['error'][] = 'Error durante el cambio de password, intentalo nuevamente';
            }
        }
        echo json_encode($alertas);
    }
  
  ///////////// procesando la gestion de la caja ////////////////
    public static function allcajas(){  //api llamado desde citas.js
      session_start();
      $cajas = caja::all();
      foreach($cajas as $caja)$caja->nombreconsecutivo = consecutivos::find('id', $caja->idtipoconsecutivo);
      echo json_encode($cajas);
    }
  
    public static function crearCaja(){ //api llamada desde el modulo de gestioncajas.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $caja = new caja($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
          $caja->negocio = sucursales::find('id', $caja->idsucursalid)->nombre;
            $alertas = $caja->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $caja->crear_guardar();
                if($r[0]){
                    //crear cierre de caja para la caja recien creada
                    $crearcierrecaja = new cierrescajas(['idcaja'=>$r[1], 'nombrecaja'=>$caja->nombre]);
                    $rcc = $crearcierrecaja->crear_guardar();
                    if($rcc[0]){
                        $caja->nombreconsecutivo = consecutivos::find('id', $caja->idtipoconsecutivo);
                        $caja->id = $r[1];
                        $alertas['exito'][] = 'Caja creada correctamente';
                        $alertas['caja'] = $caja;
                    }else{
                        $ultimacaja = caja::find('id', $r[1]);
                        $ultimacaja->eliminar_registro();
                        $alertas['error'][] = "Error durante la creacion de la caja.";
                    }
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarCaja(){
        session_start();
        $alertas = []; 
        $caja = caja::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $caja->compara_objetobd_post($_POST);
            $caja->negocio = sucursales::find('id', $caja->idsucursalid)->nombre;
            $alertas = $caja->validar();
            if(empty($alertas)){
                $r = $caja->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos de la caja actualizados";
                    $alertas['caja'][] = $caja;
                }else{
                    $alertas['error'][] = "Error al actualizar caja";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarCaja(){
        session_start();
        $caja = caja::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($caja)){
                try {
                    $r = $caja->eliminar_registro();
                    if($r){
                        ActiveRecord::setAlerta('exito', 'Caja eliminado correctamente');
                    }else{
                        ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                    $caja->estado = 0;
                    $ra = $caja->actualizar();
                    if($ra){
                        ActiveRecord::setAlerta('exito', 'Caja eliminado correctamente');
                    }else{
                        ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                    }
                }
            }else{
                ActiveRecord::setAlerta('error', 'Caja no encontrada');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }

    
///////////////////procesando la gestion de los facturadores //////////////////////
    public static function allfacturadores(){  //api llamado desde gestionfacturadores.js
      session_start();
      $consecutivos = consecutivos::all();
      foreach($consecutivos as $consecutivo)$consecutivo->nombretipofacturador = tipofacturador::find('id', $consecutivo->idtipofacturador)->nombre;
      echo json_encode($consecutivos);
    }
  
    public static function crearFacturador(){ //api llamada desde el modulo de gestionfacturadoes.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $consecutivo = new consecutivos($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $consecutivo->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $consecutivo->crear_guardar();
                if($r[0]){
                    $consecutivo->nombretipofacturador = tipofacturador::find('id', $consecutivo->idtipofacturador);
                    $consecutivo->id = $r[1];
                    $alertas['exito'][] = 'Facturador creado correctamente';
                    $alertas['facturador'] = $consecutivo;
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarFacturador(){
        session_start();
        $alertas = []; 
        $consecutivo = consecutivos::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $consecutivo->compara_objetobd_post($_POST);
            $consecutivo->negocio = sucursales::find('id', $consecutivo->id_sucursalid)->nombre;
            $consecutivo->nombretipofacturador = tipofacturador::find('id', $consecutivo->idtipofacturador)->nombre;
            $alertas = $consecutivo->validar();
            if(empty($alertas)){
                $r = $consecutivo->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos del facturador actualizados";
                    $alertas['facturador'][] = $consecutivo;
                }else{
                    $alertas['error'][] = "Error al actualizar facturador";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarFacturador(){
        session_start();
        //$alertas['error'][] = "No es posible eliminar facturador";
        //echo json_encode($alertas); 
        //return;
        $consecutivo = consecutivos::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($consecutivo)){
                try{
                    $r = $consecutivo->eliminar_registro();
                    if($r){
                        ActiveRecord::setAlerta('exito', 'Consecutivo eliminado correctamente');
                    }else{
                        ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion del consecutivo');
                    }
                }catch (\Throwable $th){
                    $mensaje = $th->getMessage();
                    if(preg_match('/fails \(`[^`]+`\.`([^`]+)`/', $mensaje, $coincidencias)){
                        if($coincidencias[1] == "caja"){
                            ActiveRecord::setAlerta('error', '⚠️ Facturador usado en caja, desasociar de caja para eliminar.');
                        }else{
                            $consecutivo->estado = 0;
                            $ra = $consecutivo->actualizar();
                            if($ra){
                                ActiveRecord::setAlerta('exito', 'Consecutivo eliminado correctamente');
                            }else{
                                ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion del consecutivo');
                            }
                        }
                    }else{
                        ActiveRecord::setAlerta('error', '⚠️ No se pudo determinar la entidad relacionada.');
                    }  
                }

            }else{
                ActiveRecord::setAlerta('error', 'Consecutivo no encontrado');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }


///////////// procesando la gestion de los bancos ////////////////
    public static function allbancos(){  //api llamado desde gestionbancos.js
      $bancos = bancos::all();
      echo json_encode($bancos);
    }

    public static function crearBanco(){ //api llamada desde el modulo de gestionbancos.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $banco = new bancos($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $banco->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $banco->crear_guardar();
                if($r[0]){
                    $banco->id = $r[1];
                    $banco->created_at = date('Y-m-d H:i:s');
                    $alertas['exito'][] = 'banco creada correctamente';
                    $alertas['banco'] = $banco;
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarBanco(){
        session_start();
        $alertas = []; 
        $banco = bancos::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $banco->compara_objetobd_post($_POST);
            $alertas = $banco->validar();
            if(empty($alertas)){
                $r = $banco->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos del banco actualizados";
                    $alertas['banco'][] = $banco;
                }else{
                    $alertas['error'][] = "Error al actualizar banco";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarBanco(){
        session_start();
        $banco = bancos::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($banco)){
                $r = $banco->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'banco eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'banco no encontrada');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }


///////////// procesando la gestion de las tarifas ////////////////
    public static function alltarifas(){  //api llamado desde gestiontarifas.js
      $tarifas = tarifas::all();
      echo json_encode($tarifas);
    }

    public static function crearTarifa(){ //api llamada desde el modulo de gestiontarifas.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $tarifa = new tarifas($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $tarifa->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $tarifa->crear_guardar();
                if($r[0]){
                    $tarifa->id = $r[1];
                    $alertas['exito'][] = 'Tarifa creada correctamente';
                    $alertas['tarifa'] = $tarifa;
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarTarifa(){
        session_start();
        $alertas = []; 
        $tarifa = tarifas::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $tarifa->compara_objetobd_post($_POST);
            $alertas = $tarifa->validar();
            if(empty($alertas)){
                $r = $tarifa->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos del tarifa actualizados";
                    $alertas['tarifa'][] = $tarifa;
                }else{
                    $alertas['error'][] = "Error al actualizar tarifa";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarTarifa(){
        session_start();
        $tarifa = tarifas::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($tarifa)){
                $r = $tarifa->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'Tarifa eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'Tarifa no encontrada');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }


}