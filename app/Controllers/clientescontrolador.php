<?php

namespace App\Controllers;

use App\Models\ActiveRecord;
use MVC\Router;  //namespace\clase
use App\Models\configuraciones\usuarios;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\clientes\preciosporcliente;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\mediospago;
use App\Models\configuraciones\tarifas;
use App\Models\inventario\productos;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Repositories\creditos\creditosRepository;
use App\services\clientesService;
use stdClass;

class clientescontrolador{
    

    public static function index(Router $router){
        //session_start();
        isadmin();
        $alertas = [];
        $buscar = '';
        $clientes = clientes::all();
        $tarifas = tarifas::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
        }
        $router->render('admin/clientes/index', ['titulo'=>'Clientes', 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'alertas'=>$alertas, 'buscar'=>$buscar, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }

    public static function crear(Router $router){
        /*$alertas = $usuario->validarEmail();    
        $usuarioexiste = $usuario->validar_registro();//retorna 1 si existe usuario(email), 0 si no existe
        $usuariotelexiste = $usuario->find('movil', $_POST['movil']);*/
        //session_start();
        isadmin();
        $cliente = new clientes($_POST);
        $direccion = new direcciones(['idtarifa'=>1, 'iddepartamento'=>1, 'idciudad'=>1, 'departamento'=>'No definido', 'ciudad'=>'No definido', 'direccion'=>'Tienda']);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $cliente->validar_nuevo_cliente();
            $documentID = $cliente->validar_regDinamic('identificacion');
            //$alertas = $direccion->validarDireccion();
            if(empty($alertas) && !$documentID){ //si los campos cumplen los criterios y cliente no existe por documento 
                try {
                    $cli = $cliente->crear_guardar();
                    $direccion->idcliente = $cli[1];
                    $direccion->crear_guardar();
                    $alertas['exito'][] = 'Cliente creado con exito.';
                } catch (\Throwable $th) {
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente >>'.$th->getMessage();
                }
            }else{
                if($documentID)$cliente::setAlerta('error', 'El cliente ya esta registrado');
                $alertas = $cliente::getAlertas();
            }
        }
        $clientes = clientes::all();
        $tarifas = tarifas::all();
        $router->render('admin/clientes/index', ['titulo'=>'Clientes', 'clientes'=>$clientes, 'tarifas'=>$tarifas, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function actualizar(Router $router){
        //session_start();
        isadmin();
        $alertas = [];  
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $cliente = usuarios::find('id', $_POST['id']);
            $cliente->compara_objetobd_post($_POST);
            $cliente->password2 = $cliente->password;
            $alertas = $cliente->validar_nueva_cuenta();
            $alertas = $cliente->validarEmail();
            if(empty($alertas)){
                $r = $cliente->actualizar();
                if($r)$alertas['exito'][] = 'Datos de cliente actualizados';
            }
        }
        $clientes = usuarios::whereArray(['confirmado'=>1, 'admin'=>0]);
        $router->render('admin/clientes/index', ['titulo'=>'Clientes', 'clientes'=>$clientes, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function hab_desh(Router $router){
        //session_start();
        isadmin();
        $alertas = [];  
        $id = $_GET['id'];
        if(!is_numeric($id))return;

        $cliente = usuarios::find('id', $id);
        if($cliente){
            if($cliente->habilitar){
                $cliente->habilitar = 0;
                $alertas['exito'][] = 'Cliente bloqueado de la base de datos';
            }else{
                $cliente->habilitar = 1;
                $alertas['exito'][] = 'Cliente habilitado de la base de datos';
            }
            $r = $cliente->actualizar();
        }else{
            header('Location: /admin/clientes');
        }

        if(!$r)$alertas['exito'][] = 'hubo un error';
        
        $clientes = usuarios::whereArray(['confirmado'=>1, 'admin'=>0]);
        $router->render('admin/clientes/index', ['titulo'=>'Clientes', 'clientes'=>$clientes, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }

    public static function marketing(Router $router){
        //session_start();
        isadmin(); 
        $alertas = [];
        $router->render('admin/clientes/marketing', ['titulo'=>'Clientes/marketing', 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }

    public static function crearcampania(Router $router){
        //session_start();
        isadmin(); 
        $alertas = [];
        $router->render('admin/clientes/crearcampania', ['titulo'=>'Clientes/crearcampania', 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }

    public static function detalle(Router $router){
        //session_start();
        isadmin(); 
        $id = $_GET['id'];
        if(!is_numeric($id))return;
        $alertas = [];
        $conflocal = config_local::getParamGlobal();
        $cliente = clientes::find('id', $id);
        $indicadores = clientes::indicadoresVentasXcliente($cliente->id, id_sucursal());
        $creditos = new creditosRepository;
        //$creditos = $creditos->findAll('cliente_id', $cliente->id, 'DESC');
        $creditos = $creditos->creditosXclienteXemisor('cliente_id', $cliente->id, 'DESC');
        $cajas = caja::whereArray(['idsucursalid'=>id_sucursal(), 'estado'=>1]);
        $mediospago = mediospago::whereArray(['estado'=>1]);
        $router->render('admin/clientes/detalle', ['titulo'=>'Clientes', 'conflocal'=>$conflocal, 'cliente'=>$cliente, 'indicadores'=>$indicadores, 'cajas'=>$cajas, 'mediospago'=>$mediospago, 'creditos'=>$creditos, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    public static function preciosXCliente(Router $router){
        //session_start();
        isadmin(); 
        $id = $_GET['id'];
        if(!is_numeric($id))return;
        $alertas = [];
        $conflocal = config_local::getParamGlobal();
        $cliente = clientes::find('id', $id);
        $productos = productos::whereArray(['visible'=>1]);
        $arrayPreciosPorCliente = preciosporcliente::unJoinWhereArrayObj(productos::class, "idproducto", "id", ['preciosporcliente.idcliente'=>$cliente->id]);
        $router->render('admin/clientes/preciosXCliente', ['titulo'=>'Clientes', 'conflocal'=>$conflocal, 'cliente'=>$cliente, 'productos'=>$productos, 'arrayPreciosPorCliente'=>$arrayPreciosPorCliente, 'alertas'=>$alertas, 'sucursales'=>sucursales::all(), 'user'=>$_SESSION]);
    }


    ///////////////////////////////////  Apis ////////////////////////////////////
    public static function allclientes(){  //api llamado desde citas.js
        $clientes = clientes::all();
        echo json_encode($clientes);
    }
    

    ///////////////////////////////////  Apis ////////////////////////////////////
    public static function direccionesXcliente(){  //api llamado desde ventas.js me trae todas las direcciones segun cliente elegido
        isadmin(); 
        $id = $_GET['id'];
        if(!is_numeric($id))return;
        $cliente = clientes::find('id', $id);
        $cliente->direcciones = clientes::direccionesANDTarifas($id);
        //precios personalizados segun el cliente
        $cliente->preciospersonalizados = preciosporcliente::idregistros("idcliente", $id);
        echo json_encode($cliente);
    }


    public static function apiCrearCliente(){ //api llamada desde el modulo de ventas.ts cuando se crea un cliente
        //session_start();
        isadmin();
        $cliente = new clientes($_POST);
        $direccion = new direcciones($_POST);
        $alertas = [];
       
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $cliente->validar_nuevo_cliente();
            $documentID = $cliente->validar_regDinamic('identificacion');
            $alertas = $direccion->validarDireccion();
            if(empty($alertas) && !$documentID){ //si los campos cumplen los criterios y cliente no existe por documento   
                //guardar cliente recien creado en bd
                try {
                    $resultado = $cliente->crear_guardar();
                    if(strlen($direccion->direccion)>3){
                        $direccion->idcliente =  $resultado[1];
                        $r1 = $direccion->crear_guardar();
                        $alertas['exito'][] = 'Cliente Registrado correctamente';
                    }
                    $alertas['nextID'] = $resultado[1];
                } catch (\Throwable $th) {
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente'.$th->getMessage();
                }
            }else{
                if($documentID)$cliente::setAlerta('error', 'El cliente ya esta registrado');
                $alertas = $cliente::getAlertas();
            }
        }
        echo json_encode($alertas);
    }


    public static function apiActualizarcliente(){
        //session_start();
        $alertas = [];
        $cliente = clientes::find('id', $_POST['idcliente']);
        if(isset($_POST['iddireccion']))$direccion = direcciones::uniquewhereArray(['id'=>$_POST['iddireccion'], 'idcliente'=>$cliente->id]);

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $cliente->compara_objetobd_post($_POST);
            $alertas = $cliente->validar_nuevo_cliente();
            $getDB = clientes::getDB();
            if(empty($alertas)){
                $getDB->begin_transaction();
                try {
                    $r = $cliente->actualizar();
                    if(isset($_POST['direccion']) && strlen($_POST['direccion'])>3){
                        if($direccion){  //actualizar direccion
                            $direccion->compara_objetobd_post($_POST);
                            $alertas = $direccion->validarDireccion();
                            if(!empty($alertas)){
                                $getDB->rollback();
                                $alertas['error'][] = "Error al actualizar cliente";
                                $alertas['cliente'][] = $cliente;
                                echo json_encode($alertas);
                                return;
                            }
                            $direccion->actualizar();
                        }
                        if(is_null($direccion)){ //crear direccion para el cliente a actualizar
                            $direccion = new direcciones($_POST);
                            $alertas = $direccion->validarDireccion();
                            if(!empty($alertas)){
                                $getDB->rollback();
                                $alertas['error'][] = "Error al actualizar cliente";
                                $alertas['cliente'][] = $cliente;
                                echo json_encode($alertas);
                                return;
                            }
                            $direccion->crear_guardar();
                        }
                    }
                    $getDB->commit();
                    $alertas['exito'][] = "Datos del cliente actualizados";
                } catch (\Throwable $th) {
                    $getDB->rollback();
                    $alerta['error'][] = "Error al actualizar el cliente >>".$th->getMessage();
                    //throw $th;
                }
            }
        }
        $alertas['cliente'][] = $cliente;
        $alertas['nextID'] = $cliente->id;
        echo json_encode($alertas);  
    }


    public static function apiEliminarCliente(){
        //session_start();
        $cliente = clientes::find('id', $_POST['id']);
        $creditos = new creditosRepository;
        $creditocliente = $creditos->where(['cliente_id'=>$cliente->id, 'idestadocreditos'=>2]);
        if(count($creditocliente)>0){
            $alertas['error'][] = "Cliente tiene credito pendiente";
            echo json_encode($alertas);
            return;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($cliente)){
                $r = $cliente->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'Cliente eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'Cliente no encontrado');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }


    public static function comprasXMesXCliente(){
        //session_start();
        isadmin();
        $id = $_GET['id'];
        if(!is_numeric($id))return;
        $comprasXMesXCliente = clientes::comprasXMesXCliente($id, id_sucursal());
        echo json_encode($comprasXMesXCliente);
    }


    public static function ventasXCategoriasXCliente(){
        //session_start();
        isadmin();
        $id = $_GET['id'];
        if(!is_numeric($id))return;
        $ventasXCategoriasXCliente = clientes::ventasXCategoriasXCliente($id, id_sucursal());
        echo json_encode($ventasXCategoriasXCliente);
    }


    public static function preciospersonalizados():void{
         isadmin();
        $clienteService = new clientesService();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST')$alertas = $clienteService->preciospersonalizados($_POST);
        echo json_encode($alertas);
        return;
    }


    public static function eliminarPrecioPersonalizado():void{
        isadmin();
        $idcliente = $_GET['idcliente'];
        $idproducto = $_GET['idproducto'];
        if(!is_numeric($idcliente)||!is_numeric($idproducto)){
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
            echo json_encode($alertas);
            return;
        }
        $clienteService = new clientesService();
        $alertas = $clienteService->eliminarPrecioPersonalizado($idcliente, $idproducto);
        echo json_encode($alertas);
        return;
    }
}