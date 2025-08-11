<?php

namespace Controllers;

use Classes\Email;
use Model\usuarios; //namespace\clase hija
use Model\productos;
use Model\subproductos;
use Model\productos_sub;
use Model\categorias;
Use Model\unidadesmedida;
use Model\conversionunidades;
use Model\caja;
use Model\gastos;
use Model\cierrescajas;
use Model\compras;
use Model\detallecompra;
use MVC\Router;  //namespace\clase
use stdClass;

class almacencontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $productosqw = productos::all();
    $subproductosqw = subproductos::all();
    $productos = productos::indicadoresAllProducts();
    $subproductos = subproductos::indicadoresAllSubProducts();
    $cantidadCategorias = categorias::numreg_where('visible', 1);

    $valorInv = $productos[0]->valorinv + $subproductos[0]->valorinv; //valor total del inventario
    $cantidadProductos = $productos[0]->cantidadproductos; //
    $cantidadReferencias = $productos[0]->cantidadreferencias + $subproductos[0]->cantidadreferencias; //
    $bajoStock = $productos[0]->bajostock + $subproductos[0]->bajostock; //
    $productosAgotados = $productos[0]->productosagotados + $subproductos[0]->productosagotados; //

    if((int)$valorInv >= 1000000 && (int)$valorInv < 1000000000)$valorInv = round((int)$valorInv / 1000000, 1) . 'M';
    if((int)$valorInv >= 1000000000 && (int)$valorInv < 1000000000000)$valorInv = round((int)$valorInv / 1000000000, 1) . 'MM';

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/index', ['titulo'=>'Almacen', 'productos'=>$productos, 'subproductos'=>$subproductos, 'valorInv'=>$valorInv, 'cantidadProductos'=>$cantidadProductos, 'cantidadReferencias'=>$cantidadReferencias, 'cantidadCategorias'=>$cantidadCategorias, 'bajoStock'=>$bajoStock, 'productosAgotados'=>$productosAgotados, 'alertas'=>$alertas, 'user'=>$_SESSION]);
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
    $unidadesmedida = unidadesmedida::all();
    $producto = new productos;
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/productos', ['titulo'=>'Almacen', 'productos'=>$productos, 'categorias'=>$categorias, 'unidadesmedida'=>$unidadesmedida, 'producto'=>$producto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function crear_producto(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $conversion = new conversionunidades;
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
        if($r[0]){
          $arrayequivalencias = $producto->equivalencias($r[1], $producto->idunidadmedida);
          $rc = $conversion->crear_varios_reg_arrayobj($arrayequivalencias);
          if($rc){
            $alertas['exito'][] = "Producto creado correctamente";
          }else{
            //**** eliminar subproducto
            $productodelete = productos::find('id', $r[1]);
            $productodelete->eliminar_registro();
            $alertas['error'][] = "Error, intentalo nuevamente";
          }
        }
      }
    }
    $categorias = categorias::all();
    $productos = productos::all();
    $router->render('admin/almacen/productos', ['titulo'=>'Almacen', 'productos'=>$productos, 'categorias'=>$categorias, 'producto'=>$producto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function subproductos(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    $subproductos = subproductos::all();
    $unidadesmedida = unidadesmedida::all();
    $subproducto = new subproductos;
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/subproductos', ['titulo'=>'Almacen', 'subproducto'=>$subproducto, 'subproductos'=>$subproductos, 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function crear_subproducto(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $conversion = new conversionunidades;
    $unidadmedida = unidadesmedida::find('id', $_POST['id_unidadmedida']); //unidad de medida base indicada para el subproducto
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $subproducto = new subproductos($_POST);
      $subproducto->unidadmedida = $unidadmedida->nombre;
      $alertas = $subproducto->validar_nuevo_subproducto();
      if(empty($alertas)){
        $r = $subproducto->crear_guardar();
        if($r[0]){
          $arrayequivalencias = $subproducto->equivalencias($r[1], $unidadmedida->id);
          $r1 = $conversion->crear_varios_reg_arrayobj($arrayequivalencias);
          if($r1){
            $alertas['exito'][] = "Producto creado correctamente";
          }else{
            //**** eliminar subproducto
            $subproductodelete = subproductos::find('id', $r[1]);
            $subproductodelete->eliminar_registro();
            $alertas['error'][] = "Error, intentalo nuevamente";
          }
        }else{
          $alertas['error'][] = "Error, intentalo nuevamente";
        }
      }
    }
    $unidadesmedida = unidadesmedida::all();
    $subproductos = subproductos::all();
    $router->render('admin/almacen/subproductos', ['titulo'=>'Almacen', 'subproductos'=>$subproductos, 'unidadesmedida'=>$unidadesmedida, 'subproducto'=>$subproducto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function componer(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    //$productos = productos::all();
    $producto = productos::find('id', $_GET['id']);
    $subproductos = subproductos::all();
                                      // segunda tabla,   ON t1.id_subproducto = t2.id
    $subproductosasociados = productos_sub::unJoinWhereArray(subproductos::class, "id_subproducto", "id", ['productos_sub.id_producto'=>$producto->id]);
    $subproductosenlazados = [];
    foreach($subproductosasociados as $value){
        $newobj = new stdClass();
        $newobj->ID = $value['ID'];
        $newobj->id_producto =  $value['id_producto'];
        $newobj->id_subproducto = $value['id_subproducto'];
        $newobj->cantidadsubproducto =  $value['cantidadsubproducto'];
        $newobj->nombresubproducto = $value['nombre'];
        $newobj->id_unidadmedida = $value['id_unidadmedida'];
        $newobj->unidadmedida =  $value['unidadmedida'];
        $subproductosenlazados[] = $newobj;
    }
    $router->render('admin/almacen/componer', ['titulo'=>'Almacen', 'producto'=>$producto, /*'productos'=>$productos,*/ 'subproductos'=>$subproductos, 'subproductosenlazados'=>$subproductosenlazados, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function ajustarcostos(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    $productos = [];
    $subproductos = [];
    //$categorias = categorias::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$categorias = categorias::all();
    $productos = productos::all();
    $subproductos = subproductos::all();
    
    
    $router->render('admin/almacen/ajustarcostos', ['titulo'=>'Almacen', 'productos'=>$productos, 'subproductos'=>$subproductos, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function compras(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    $categorias = categorias::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $cajas = caja::all();
    $productos = productos::all();
    $subproductos = subproductos::all();
    $totalitems = []; //array_merge($productos, $subproductos);
    $router->render('admin/almacen/compras', ['titulo'=>'Almacen', 'totalitems'=>$totalitems, 'categorias'=>$categorias, 'cajas'=>$cajas, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }
  

  public static function distribucion(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    $categorias = categorias::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/distribucion', ['titulo'=>'Almacen', 'categorias'=>$categorias, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function inventariar(Router $router){
    session_start();
    isadmin();
    $alertas = [];

    $categorias = categorias::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/inventariar', ['titulo'=>'Almacen', 'categorias'=>$categorias, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function unidadesmedida(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $unidadmedida = unidadesmedida::find('id', $_POST['id']);
      $r = $unidadmedida->eliminar_registro();
      if($r){
        $alertas['exito'][] = "Unidad de medida eliminada correctamente";
      }else{
        $alertas['error'][] = "Error en la eliminacion de la unidad de medida";
      }
    }
    //$alertas = usuarios::getAlertas();
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/unidadesmedida', ['titulo'=>'Almacen', 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function crear_unidadmedida(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $unidadmedida = new unidadesmedida($_POST);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $alertas = $unidadmedida->validar();
      if(empty($alertas)){
        $r = $unidadmedida->crear_guardar();
        if($r[0]){
          $alertas['exito'][] = "Unidad de medida creado correctamente";
        }else{
          $alertas['error'][] = "Error en la creacion de la unidad de medida";
        }
      }
    }

    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/unidadesmedida', ['titulo'=>'Almacen', 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function editarunidademedida(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    $unidadmedida = unidadesmedida::find('id', $_POST['idunidad']);
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $unidadmedida->compara_objetobd_post($_POST);
      $alertas = $unidadmedida->validar();
      if(empty($alertas)){
        $r = $unidadmedida->actualizar();
        if($r){
          $alertas['exito'][] = "Unidad de medida actualizada correctamente";
        }else{
          $alertas['error'][] = "Error de actualizacion en la unidad de medida";
        }
      }
    }
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/unidadesmedida', ['titulo'=>'Almacen', 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function downexcelproducts(Router $router){
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){ //para exportar a excel productos
      $excelproductos = productos::all();
      if(isset($_POST['downexcel'])){
        //debuguear(isset($_POST['downexcel']));
                if(!empty($excelproductos)){
                    $filename = "excelproductos.xls";
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);

                    $mostrar_columnas = false;

                    foreach($excelproductos as $value){
                        if(!$mostrar_columnas){
                            echo implode("\t", array_keys((array)$value)) . "\n";
                            $mostrar_columnas = true;
                        }
                        echo implode("\t", array_values((array)$value)) . "\n";
                    }
                }else{ echo 'No hay datos a exportar'; }
                exit;
            } 
    }
  }


  public static function downexcelinsumos(Router $router){
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){ //para exportar a excel productos
      $excelproductos = subproductos::all();
      if(isset($_POST['downexcel'])){
        //debuguear(isset($_POST['downexcel']));
                if(!empty($excelproductos)){
                    $filename = "excelinsumos.xls";
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);

                    $mostrar_columnas = false;

                    foreach($excelproductos as $value){
                        if(!$mostrar_columnas){
                            echo implode("\t", array_keys((array)$value)) . "\n";
                            $mostrar_columnas = true;
                        }
                        echo implode("\t", array_values((array)$value)) . "\n";
                    }
                }else{ echo 'No hay datos a exportar'; }
                exit;
            } 
    }
  }


  ////////////////////////////   API   //////////////////////////////
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
    $tipo = $producto->tipoproducto;  //0 = simple,  1 = compuesto
    $idunidadmedidaDB = $producto->idunidadmedida;  //obtener el id de unidad de medida actual del subproducto
    
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

            ///// si de simple paso a compuesto, validar que el producto existe en productos_sub
            ///// si producto existe en productos_sub, realizar sumatoria en la tabla productos_sub para el precio de compra
            ///// si no existe, establer valor de compra en 0
            if($tipo == 0 && $producto->tipoproducto == 1){
              $costo = productos_sub::sumcolum('id_producto', $producto->id, 'costo');
              if($costo){
                $producto->precio_compra = $costo;
              }else{
                $producto->precio_compra = 0;
              }
            }
      
            $r = $producto->actualizar();
            
            if($r){
              if($idunidadmedidaDB != $_POST['idunidadmedida']){ //validar si hubo cambio de unidad de medida
                $conversion = new conversionunidades;
                
                $cvdelete = conversionunidades::eliminar_idregistros('idproducto', [$producto->id]);
                
                if($cvdelete){
                  $arrayequivalencias = $producto->equivalencias($producto->id, $_POST['idunidadmedida']);
                  $cv = $conversion->crear_varios_reg_arrayobj($arrayequivalencias);
                  if($cv){
                    $alertas['exito'][] = "Datos del producto actualizados";
                  }else{
                    //revertir los datos de producto
                    //revertir las unidades de conversion equivalentes eliminadas, volviendo a crear las conversiones
                    $alertas['error'][] = "Error al intentar crear las nuevas conversiones base equivalentes de subproducto";
                  }
                }else{
                  //revertir los datos de subproducto
                  $alertas['error'][] = "Error al eliminar las conversiones base equivalentes del producto";
                }
              }else{
                $alertas['exito'][] = "Datos del producto actualizados";
              }
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


  public static function allsubproducts(){
    $subproductos = subproductos::all();  //arreglo de obj = [{},{},{}]
   echo json_encode($subproductos); 
  }


  public static function actualizarsubproducto(){ //actualizar editar sub-producto
    session_start();
    $alertas = [];
    //$unidadmedida = unidadesmedida::find('id', $_POST['id_unidadmedida']);
    $subproducto = subproductos::find('id', $_POST['id']);
    $idunidadmedidaDB = $subproducto->id_unidadmedida;  //obtener el id de unidad de medida actual del subproducto
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $subproducto->compara_objetobd_post($_POST);
        //$subproducto->unidadmedida = $unidadesmedida->nombre;
        $alertas = $subproducto->validar_nuevo_subproducto();
        if(empty($alertas)){
          $r = $subproducto->actualizar();
          if($r){
            if($idunidadmedidaDB != $_POST['id_unidadmedida']){ //validar si hubo cambio de unidad de medida
              $conversion = new conversionunidades;
              $cvdelete = conversionunidades::eliminar_idregistros('idsubproducto', [$subproducto->id]);
              if($cvdelete){
                $arrayequivalencias = $subproducto->equivalencias($subproducto->id, $_POST['id_unidadmedida']);
                $cv = $conversion->crear_varios_reg_arrayobj($arrayequivalencias);
                if($cv){
                  $alertas['exito'][] = "Datos del sub-producto actualizados";
                }else{
                  //revertir los datos de subproducto
                  //revertir las unidades de conversion equivalentes eliminadas, volviendo a crear las conversiones
                  $alertas['error'][] = "Error al intentar crear las nuevas conversiones base equivalentes de subproducto";
                }
              }else{
                //revertir los datos de subproducto
                $alertas['error'][] = "Error al eliminar las conversiones base equivalentes del subproducto";
              }
            }else{
              $alertas['exito'][] = "Datos del sub-producto actualizados";
            }
            
            //&& $subproducto->precio_compra!=$_POST['precio_compra']
            if(isset($alertas['exito'])){
              ///// actualizar costo en tabla emsanblaje productos_sub  //////
              $ubcostoEnsambla = productos_sub::actualizarLibre("UPDATE productos_sub SET costo = cantidadsubproducto*$subproducto->precio_compra WHERE id_subproducto = $subproducto->id;"); 
              ////// Obtener la suma de los subproductos que pertenece a un producto  //////
              $sql = "SELECT SUM(costo) AS precio_compra, id_producto AS id FROM productos_sub 
                      WHERE id_producto IN (SELECT id_producto FROM productos_sub WHERE id_subproducto = $subproducto->id) 
                      GROUP BY id_producto;";
              $costos = productos_sub::camposJoinObj($sql); //costos = [{id:1, valor: 44}, {}]
              //////// actualizar costo (precio de compra) de productos compuestos  /////
              if(!empty($costos))
              $costoproduct = productos::updatemultiregobj($costos, ['precio_compra']);
            }
          
          }else{
            $alertas['error'][] = "Error al actualizar el subproducto intentalo nuevamente";
          }
        }
    } 
    $alertas['subproducto'][] = $subproducto;
    echo json_encode($alertas);
  }


  public static function eliminarSubProducto(){
    session_start();
    $alertas = [];
    $subproducto = subproductos::find('id', $_POST['id']);
    ////// Obtener la suma de los subproductos menos el que se va a eliminar que pertenece a un producto  //////
    $sql = "SELECT SUM(costo) AS precio_compra, id_producto AS id FROM productos_sub 
    WHERE id_producto IN (SELECT id_producto FROM productos_sub WHERE id_subproducto = $subproducto->id) AND id_subproducto != $subproducto->id 
    GROUP BY id_producto;";
    $costos = productos_sub::camposJoinObj($sql); //costos = [{id:1, valor: 44}, {}]
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $r = $subproducto->eliminar_registro();
        if($r){
            //////// actualizar costo (precio de compra) de productos compuestos  /////
            if(!empty($costos)){
              $costoproduct = productos::updatemultiregobj($costos, ['precio_compra']);
              if($costoproduct){
                $alertas['exito'][] = "subproducto eliminado.";
              }else{
                $alertas['error'][] = "Alerta revisar costo de productos que contiene el subproducto eliminado.";
              }
            }else{
              $alertas['exito'][] = "subproducto eliminado.";
            }
        }else{
            $alertas['error'][] = "Error durante el proceso, intentalo nuevamnete.";
        }
    }
    echo json_encode($alertas);
  }

  //ESTABLECER RENDIMIENTO ESTANDAR DE LA FORMULA DE SALIDA
  public static function setrendimientoestandar(){
    session_start();
    $alertas = [];
    /*$tipoelemento = $_POST['tipoelemento'];
    if($tipoelemento == 1){  // 1 = subproducto
      $element = subproductos::find('id', $_POST['idelemento']);
    }else{   //0 = producto
      $element = productos::find('id', $_POST['idelemento']);
    }*/
    $element = productos::find('id', $_POST['id']);
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(!empty($element)){
        $element->rendimientoestandar = $_POST['rendimientoestandar'];
        $r = $element->actualizar();
        if($r){
          $alertas['exito'][] = 1;
        }else{
          $alertas['error'][] = "Error al establecer el rendimiento de la formula";
        }
      }else{
        $alertas['error'][] = "Error, intenta nuevamente";
      }
    }
    echo json_encode($alertas);
  }


  public static function ensamblar(){  //asociar un o unos subproductos a un producto principal
    session_start();
    $alertas = [];
    $ensamblar = new productos_sub($_POST);
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $alertas = $ensamblar->validar();
      if(empty($alertas)){
        $existe = productos_sub::uniquewhereArray(['id_producto'=>$_POST['id_producto'], 'id_subproducto'=>$_POST['id_subproducto']]);
        if($existe){//actualizar
          $existe->compara_objetobd_post($_POST);
          $ra = $existe->actualizar();
          if($ra){
            $alertas['exito'][] = "subproducto asociado y actualizado al producto principal.";
          }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
          }
        }else{//crear
          $r = $ensamblar->crear_guardar();
          if($r[0]){
            $alertas['exito'][] = "subproducto asociado al producto principal.";
          }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
          }
        }
      }
      ///////   actualizar costo (precio de compra) del producto compuesto   ////////
      if(isset($alertas['exito'])){
        $producto = productos::find('id', $ensamblar->id_producto);
        $costo = productos_sub::sumcolum('id_producto', $producto->id, 'costo');
        $producto->precio_compra = $costo;
        $rap = $producto->actualizar();
      }
    }
    echo json_encode($alertas);
  }


  public static function desasociarsubproducto(){  //desasociar subproducto de un producto principal
    session_start();
    $alertas = [];
    $idproducto = $_GET['idproducto'];
    $idsubproducto = $_GET['idsubproducto'];
    if(!is_numeric($idproducto)||!is_numeric($idsubproducto)){
      $alertas['error'][] = "Hubo un error, intentalo nuevamente";
    }else{
      $r = productos_sub::eliminar_wherearray(['id_producto'=>$idproducto, 'id_subproducto'=>$idsubproducto]);
      if($r){
        $alertas['exito'][] = "subproducto asociado al producto principal.";
      }else{
        $alertas['error'][] = "Hubo un error, intentalo nuevamente";
      }
    }
    echo json_encode($alertas);
  }


  public static function allConversionesUnidades(){  //Envia todas las equivalencias o conversiones de unidades
    $conversionUnidades = conversionunidades::all();
    echo json_encode($conversionUnidades);
  }


  public static function actualizarcostos(){  //asociar un o unos subproductos a un producto principal
    session_start();
    $alertas = [];
    $tipoelemento = $_POST['tipoelemento'];
    if($tipoelemento == 1){  // 1 = subproducto
      $element = subproductos::find('id', $_POST['idelemento']);
    }else{   //0 = producto
      $element = productos::find('id', $_POST['idelemento']);
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(!empty($element)){
        $element->precio_compra = $_POST['precio_compra'];
        $r = $element->actualizar();   //se actualiza el precio de compra de subproducto o producto simple
        if($r){
          $alertas['exito'][] = 1;
          if($tipoelemento == 1){
            ///// actualizar costo en tabla emsanblaje productos_sub  //////
            $ubcostoEnsambla = productos_sub::actualizarLibre("UPDATE productos_sub SET costo = cantidadsubproducto*$element->precio_compra WHERE id_subproducto = $element->id;");
            
            ////// Obtener la suma de los subproductos que pertenece a un producto  //////
            $sql = "SELECT SUM(costo) AS precio_compra, id_producto AS id FROM productos_sub 
                    WHERE id_producto IN (SELECT id_producto FROM productos_sub WHERE id_subproducto = $element->id) 
                    GROUP BY id_producto;";
            $costos = productos_sub::camposJoinObj($sql); //costos = [{id:1, valor: 44}, {}]

            //////// actualizar costo (precio de compra) de productos compuestos  /////
            if(!empty($costos))
            $costoproduct = productos::updatemultiregobj($costos, ['precio_compra']);
          }
        }else{
          $alertas['error'][] = "Error, intenta nuevamente";
        }
      }else{
        $alertas['error'][] = "Error, intenta nuevamente";
      }
    }
    echo json_encode($alertas);
  }


  public static function totalitems(){  //Envia los productos simples y subproductos en un solo arreglo de objetos
    $productos = productos::idregistros('tipoproducto', 0);
    $subproductos = subproductos::all();
    $totalitems = array_merge($productos, $subproductos);
    echo json_encode($totalitems);
  }


  public static function registrarCompra(){  //asociar un o unos subproductos a un producto principal
    session_start();
    $in = '';
    $alertas = [];
    $invpx = true;
    $invsx = true;
    $compra = new compras($_POST);
    $detallecompra = new detallecompra();
    $carrito = json_decode($_POST['carrito']);
    //////////  SEPARAR LOS ITEMS EN PRODUCTOS Y SUBPRODUCTOS  ////////////
    $resultArray = array_reduce($carrito, function($acumulador, $objeto){
      $objeto->id = $objeto->iditem;
      //unset($objeto->iditem);
      if($objeto->tipo == 0){
        $acumulador['productos'][] = $objeto;
      }
      else{
        $acumulador['subproductos'][] = $objeto;
      }
      return $acumulador;
    }, ['productos'=>[], 'subproductos'=>[]]);
    ////// Obtengo los registros de la tabla productos_sub a actualizar su costo de compra segun id_subproducto
    $itemsProSub = productos_sub::paginarwhere('', '', 'id_subproducto', json_decode($_POST['subID']));
    ////////  mapeo Optimizado de tipo O(A+B)
    $mapCostoSub = array_column($resultArray['subproductos'], 'precio_compra', 'id');
    foreach($itemsProSub as $index => $value){
      $value->costo = $mapCostoSub[$value->id_subproducto];
      if(array_key_last($itemsProSub) == $index){
        $in .= $value->id_producto;
      }else{
        $in .= $value->id_producto.', ';
      }
    }
    if(!empty($itemsProSub)){
        ////// Actualizo el costo de compra de los subproductos en la tabla productos_sub
        $costosprosub = productos_sub::actualizar_costos_de_prosub($itemsProSub, ['costo']);
        ////// Obtener la suma de los subproductos que pertenece a un producto  //////
        $sql = "SELECT SUM(costo) AS precio_compra, id_producto AS id FROM productos_sub 
        WHERE id_producto IN ($in) GROUP BY id_producto;";
        $costos = productos_sub::camposJoinObj($sql); //costos = [{id:1, valor: 44}, {}]
        //////// actualizar costo (precio de compra) de productos compuestos  /////
        if(!empty($costos))
        $costoproduct = productos::updatemultiregobj($costos, ['precio_compra']);//  Actualizar el o precio de compra de los productos compuestos
    }


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $compra->idusuario = $_SESSION['id'];
      $compra->nombreusuario = $_SESSION['nombre'];
      $alertas = $compra->validar();
      if(empty($alertas)){
        $r = $compra->crear_guardar();
        if($r[0]){
          foreach($carrito as $obj){
            $obj->idcompra = $r[1];
          }
          $r1 = $detallecompra->crear_varios_reg_arrayobj($carrito);  //crear los items de la factura de compra en tabla detallecompra
          if($r1){
            /// ACTUALIZAR EL STOCK Y PRECIO DE COMPRA (COSTO) DE LOS PRODUCTOS Y/O SUBPRODUCTOS DEL INVENTARIO ////
              //UPDATE nombretabla SET stock = CASE WHEN id = 1 THEN stock + 2 WHEN id = 3 THEN stock + 1 ELSE stock END, valor = CASE WHEN id = 1 THEN '800' WHEN id = 3 THEN '100' ELSE valor END WHERE id IN (1, 3, 5);
              
              if(!empty($resultArray['productos']))$invpx = productos::camposaddinv($resultArray['productos'], ['stock', 'precio_compra']);  //$resultArray[0] = [{id: "1", idcategoria: "3", nombre: "xxx", cantidad: "4"}, {}]
              if(!empty($resultArray['subproductos']) && $invpx)$invsx = subproductos::camposaddinv($resultArray['subproductos'], ['stock', 'precio_compra']);
            
              if($invpx){  
                if($invsx){
                  $alertas['exito'][] = "Compra realizada con exito.";


        //*****/////////// registrarlo en tabla gastos, operacion compra /////////////
                  $ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1);
                  if($ultimocierre->estado == 0){
                    $ingresoGasto = new gastos();
                    $ingresoGasto->idg_usuario = $compra->idusuario;
                    $ingresoGasto->id_compra = $r[1];
                    $ingresoGasto->idg_caja =  $compra->idorigenpago;
                    $ingresoGasto->idg_cierrecaja = $ultimocierre->id;
                    $ingresoGasto->idcategoriagastos = 1;
                    $ingresoGasto->operacion = "compra";
                    $ingresoGasto->valor = $compra->valortotal;
                    $ultimocierre->gastoscaja = $ultimocierre->gastoscaja + $ingresoGasto->valor;
                    ///// validar gastos de la caja en el modelo
                    $alertas = $ingresoGasto->validar();
                    if(empty($alertas)){
                      $r = $ingresoGasto->crear_guardar();
                      if($r[0]){
                        $r1 = $ultimocierre->actualizar();
                        if($r1){
                          $alertas['exito'][] = "Gasto de compra registrado correctamente";
                        }else{
                          $alertas['error'][] = "error al actualizar los gastos de compra en el cierre de caja actual";
                          /// borrar ultimo registro guardado de $ingresocaja
                          $ingresoGasto->eliminar_idregistros('id', [$r[1]]);
                        }
                      }else{
                        $alertas['error'][] = "Error al guardar el gasto de compra";
                      }
                    }
                  }
      /*****////////////////////////*****************///////////////////////////


                }else{
                  $alertas['error'][] = "Hubo un error, intentalo nuevamente";
                  $compradelete = compras::find('id', $r[1]);
                  $compradelete->eliminar_registro();
                  //*****$invpx = productos::updatereduceinv($resultArray['productos'], 'stock');
                }
              }else{
                $alertas['error'][] = "Hubo un error, intentalo nuevamente";
                $compradelete = compras::find('id', $r[1]);
                $compradelete->eliminar_registro();
              }

          }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
            $compradelete = compras::find('id', $r[1]);
            $compradelete->eliminar_registro();
          }
        }else{
          $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }
    }
    echo json_encode($alertas);
  }


  public static function descontarstock(){  //descontar cantidad a inventario
    session_start();
    $alertas = [];
    $iditem = $_POST['iditem'];
    $cantidad = $_POST['cantidad'];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if($_POST['tipoitem'] == 0){ //si es producto
        $producto = productos::find('id', $iditem);
        $producto->stock =$producto->stock-$cantidad;
        $ra = $producto->actualizar();
        if($ra){
            $alertas['exito'][] = "Stock del producto actualizado con exito";
            $alertas['item'][] = $producto;
        }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }else{  // si es insumo subproducto
        $insumo = subproductos::find('id', $iditem);
        $insumo->stock =  $insumo->stock-$cantidad;
         $ra = $insumo->actualizar();
        if($ra){
            $alertas['exito'][] = "Stock del insumo - subproducto actualizado con exito";
            $alertas['item'][] = $insumo;
        }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }
    }
    echo json_encode($alertas);
  }

  public static function aumentarstock(){  //sumar o ingresar cantidad o produccion a inventario
    session_start();
    $alertas = [];
    $iditem = $_POST['iditem'];
    $cantidad = $_POST['cantidad'];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if($_POST['tipoitem'] == 0){ //si es producto
        $producto = productos::find('id', $iditem);
        $producto->stock =  $producto->stock+$cantidad;
        $ra = $producto->actualizar();
        
        //procesar el descuento de los insumos del produco compuesto y de produccion tipo contruccion
        //validar si el producto compuesto tiene insumos asociados y si es de tipo construccion
        if(isset($_POST['construccion']) && $_POST['construccion'] == 1){
          //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
          $producto->cantidad = $cantidad/$producto->rendimientoestandar;
          $descontarSubproductos = productos_sub::cantidadSubproductosXventa([$producto]);
          $soloIdSubProduct = [];
          foreach($descontarSubproductos as $index => $value){
            $value->id = $value->id_subproducto;
            $soloIdSubProduct[] = $value->id;
          }

          
          if(!empty($descontarSubproductos)){
            $invSub = subproductos::updatereduceinv($descontarSubproductos, 'stock');
            $returnInsumos = subproductos::paginarwhere('', '', 'id', $soloIdSubProduct);
            if($invSub){
                $alertas['exito'][] = "Se realizo produccion con exito";
                $alertas['item'][] = $producto;
                $alertas['insumos'][] = $returnInsumos;  //se retorna solo para produccion
            }else{
                $alertas['error'][] = "Error al descontar los insumos";
                
                ///*revertir el inventario del producto compuesto
            }
          }else{
            $alertas['exito'][] = "Se realizo produccion, sin embargo no hay insumos asociados a descontar";
            $alertas['item'][] = $producto;
          }
        }elseif($ra){
          $alertas['exito'][] = "Stock del producto actualizado con exito";
          $alertas['item'][] = $producto;
        }else{
          $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }

      }else{  // si es insumo subproducto
        $insumo = subproductos::find('id', $iditem);
        $insumo->stock = $insumo->stock+$cantidad;
         $ra = $insumo->actualizar();
        if($ra){
            $alertas['exito'][] = "Stock del insumo - subproducto actualizado con exito";
            $alertas['item'][] = $insumo;
        }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }
    }
    echo json_encode($alertas);
  }


  public static function ajustarstock(){  //ajustar o reiniciar inventario
    session_start();
    $alertas = [];
    $iditem = $_POST['iditem'];
    $cantidad = $_POST['cantidad'];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if($_POST['tipoitem'] == 0){ //si es producto
        $producto = productos::find('id', $iditem);
        $producto->stock = $cantidad;
        $ra = $producto->actualizar();
        if($ra){
            $alertas['exito'][] = "Stock del producto actualizado con exito";
            $alertas['item'][] = $producto;
        }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }else{  // si es insumo subproducto
        $insumo = subproductos::find('id', $iditem);
        $insumo->stock = $cantidad;
         $ra = $insumo->actualizar();
        if($ra){
            $alertas['exito'][] = "Stock del insumo - subproducto actualizado con exito";
            $alertas['item'][] = $insumo;
          }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }
    }
    echo json_encode($alertas);
  }


  public static function reiniciarinv(){
    echo json_encode("reiniciando");
  }


  public static function cambiarestadoproducto(){
    $producto = productos::find('id', $_POST['id']);
    $alertas=[];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $producto->estado == 1?$producto->estado=0:$producto->estado=1;
      $r = $producto->actualizar();
      if($r){
        $alertas['exito'][] = "Estado del producto actualizado";
        $alertas['estado'][] = $producto->estado;
        $alertas['tipoproducto'][] = $producto->tipoproducto;
      }else{
        $alertas['error'][] = "Hubo un error, intentalo nuevamente";
      }
    }
    echo json_encode($alertas);
  }


}