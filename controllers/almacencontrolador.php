<?php

namespace Controllers;

use Classes\Email;
use Model\usuarios; //namespace\clase hija
use Model\productos;
use Model\categorias;
use MVC\Router;  //namespace\clase
 
class almacencontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $productos = productos::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/index', ['titulo'=>'Almacen', 'productos'=>$productos, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function categorias(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    $categorias = categorias::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/categorias', ['titulo'=>'Almacen', 'categorias'=>$categorias, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function crear_categoria(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $categoria = new categorias($_POST);
      $alertas = $categoria->validar_nueva_categoria();
      if(empty($alertas)){
        $r = $categoria->crear_guardar();
        if($r[0])$alertas['exito'][] = "Categoria creado correctamente";
      }
    }
    
    $categorias = categorias::all();
    $router->render('admin/almacen/categorias', ['titulo'=>'Almacen', 'categorias'=>$categorias, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function productos(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    $productos = productos::all();
    $categorias = categorias::all();
    $producto = new productos;
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/productos', ['titulo'=>'Almacen', 'productos'=>$productos, 'categorias'=>$categorias, 'producto'=>$producto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function crear_producto(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $categoria = categorias::find('id', $_POST['idcategoria']);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $producto = new productos($_POST);
      $alertas = $producto->validarimgproducto($_FILES);
      $alertas = $producto->validar_nuevo_producto();
      if(empty($alertas)){
        if($_FILES['foto']['name']){
          $producto->foto = 'cliente1/productos/'.uniqid().$_FILES['foto']['name'];
          $url_temp = $_FILES["foto"]["tmp_name"];
          move_uploaded_file($url_temp, $_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);
        }
        $producto->categoria = $categoria->nombre;//categorias::uncampo('id', $producto->idcategoria, 'nombre');
        $r = $producto->crear_guardar();
        $categoria->totalproductos = $producto->numreg_where('idcategoria', $categoria->id);//productos::numreg_where('idcategoria', $categoria->id);
        $r1 = $categoria->actualizar();
        if($r[0])$alertas['exito'][] = "Producto creado correctamente";
      }
    }
    $categorias = categorias::all();
    $productos = productos::all();
    $router->render('admin/almacen/productos', ['titulo'=>'Almacen', 'productos'=>$productos, 'categorias'=>$categorias, 'producto'=>$producto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  //////////////////////////API///////////////////////
  public static function actualizar_categoria(){ //actualizar editar categoria
    session_start();
    $alertas = []; 
    $categoria = categorias::find('id', $_POST['id']);
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $categoria->compara_objetobd_post($_POST);
        $alertas = $categoria->validar_nueva_categoria();
        if(empty($alertas)){
            $r = $categoria->actualizar();
            if($r){
              $alertas['exito'][] = "Nombre de la categoria actualizado";
            }else{
              $alertas['error'][] = "Error al realizar la solicitud";
            }
        }
    } //fin if(SERVER['REQUEST_METHOD])
    $alertas['categoria'][] = $categoria;
    echo json_encode($alertas);
  }

  public static function eliminarCategoria(){
    session_start();
    $alertas = []; 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $categoria = categorias::find('id', $_POST['id']);
        $r = $categoria->eliminar_registro();
        if($r){
            $alertas['exito'][] = "Categoria eliminada.";
        }else{
            $alertas['error'][] = "Error durante el proceso, intentalo nuevamnete.";
        }
    }
    echo json_encode($alertas);
  }

  public static function allproducts(){
    $productos = productos::all();  //arreglo de obj = [{},{},{}]
    /*$array = json_decode(json_encode($productos), true); // se convierte a arreglo de arreglos: [["id"=>"1", "nombre"="2"], ["id"=>"1", "nombre"="2"]]
    $string = "[".join(', ', array_map(function($subarray){
        return '["'.implode('", "', $subarray).'"]';
    }, $array));
    //echo $string."]";
   echo json_encode($string."]");*/ //se envia un string formateado asi: [["1", "nombre"], ["1", "nombre"]...]

   /////////////////////////*****************///////////////****************///////////////////
   foreach($productos as $index=>$producto){
       //unset($productos[$index]->descripcion);
       $producto->categoria = categorias::uncampo('id', $producto->idcategoria, 'nombre');
       //unset($productos[$index]->idcategoria);
       //unset($productos[$index]->fecha_ingreso);
       //$producto->acciones = "<div class='btn-group btn-group-sm'><button id='' class='btn btn-light' data-toggle='modal' data-target='#EditarProducto'><i class='fa fa-pen'></i></button>
       //                         <button id='' class='btneliminarproducto btn btn-danger' data-target='#EliminarProducto'><i class='fa fa-times'></i></button></div>";
   }
   echo json_encode($productos); 
  }


  public static function actualizarproducto(){ //actualizar editar producto
    session_start();
    $alertas = []; 
    $producto = productos::find('id', $_POST['id']);
    
    /////// valiadar que es una nueva imagen o distinta
    if(!$producto->foto && isset($_FILES['foto'])){
        //imagen puesta por pirmera vez
    }elseif($producto->foto && isset($_FILES['foto']['name'])) { //remplazar imagen existente
        //obtener nombre de la imagen
        //$x = explode('avatar/', $producto->foto);     //cliente1/productos/nombreimagen.png
                                                     //avatar/avatar2.png
        //if($x[0]){ //si img es diferente a avatar
            $existe_archivo = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);
            if($existe_archivo)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);
        //}
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $producto->compara_objetobd_post($_POST);
        if(isset($_FILES['foto']['name']))$alertas = $producto->validarimgproducto($_FILES); //VALIDAR ESTE METODO
        $alertas = $producto->validar_nuevo_producto();
        if(empty($alertas)){
            if(isset($_FILES['foto']['name'])){
                $producto->foto = 'cliente1/productos/'.uniqid().$_FILES['foto']['name'];
                $url_temp = $_FILES["foto"]["tmp_name"];
                move_uploaded_file($url_temp, $_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);
            }
            $r = $producto->actualizar();
            if($r){
              $alertas['exito'][] = "Datos del producto actualizados";
            }
        }
    } //fin if(SERVER['REQUEST_METHOD])
    $alertas['producto'][] = $producto;
    echo json_encode($alertas);  
  }

  public static function eliminarProducto(){
    session_start();
    $alertas = []; 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $producto = productos::find('id', $_POST['id']);
        $r = $producto->eliminar_registro();
        if($r){
            //eliminar la imagen asociada al prudcto
            $existe_archivo = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);
            if($existe_archivo && $producto->foto)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);
            $alertas['exito'][] = "producto eliminado.";
        }else{
            $alertas['error'][] = "Error durante el proceso, intentalo nuevamnete.";
        }
    }
    echo json_encode($alertas);
  }

}