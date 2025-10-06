<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use Model\configuraciones\bancos;
use Model\configuraciones\usuarios; //namespace\clase hija
use Model\inventario\productos;
use Model\inventario\subproductos;
use Model\inventario\productos_sub;
use Model\inventario\categorias;
Use Model\inventario\unidadesmedida;
use Model\inventario\conversionunidades;
use Model\configuraciones\caja;
use Model\gastos;
use Model\caja\cierrescajas;
use Model\compras;
use Model\detallecompra;
use Model\inventario\precios_personalizados;
use Model\inventario\proveedores;
use Model\inventario\stockinsumossucursal;
use Model\inventario\stockproductossucursal;
use Model\parametrizacion\config_local;
use Model\sucursales;
use MVC\Router;  //namespace\clase
use stdClass;

class almacencontrolador{

  public static function index(Router $router){
    session_start();
    isadmin();
    $alertas = [];
    //$productosqw = productos::all();
    //$subproductosqw = subproductos::all();
    //$productos = productos::indicadoresAllProducts();
    //$subproductos = subproductos::indicadoresAllSubProducts();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    

    $proveedores = proveedores::all();
    $cantidadCategorias = categorias::numreg_where('visible', 1);
    $productos = stockproductossucursal::indicadoresAllProductsXSucursal(id_sucursal());
    $subproductos = stockinsumossucursal::indicadoresAllSubproductsXSucursal(id_sucursal());

    //el valor del inventario se calcula el costo * cantidad de los productos simples + productos compuestos, + costo de los insumos. 
    //(los productos compuesto de tipo produccion: instantanea no se tienen en cuenta para calcular el valor del invnetario.)

    //utlidad se calcula para los productos simples y compuestos tipo inmediato y construccion.

    //el stock se calcula para los productos simples, compuestos tipo construccion y subproductos.
    
    $valorInv = (($productos[0]??null)?->valorinv??0) + (($subproductos[0]??null)->valorinv??0); //valor total del inventario
    $cantidadProductos = $productos[0]->cantidadproductos??0; //
    $cantidadReferencias = ($productos[0]->cantidadreferencias??0) + ($subproductos[0]->cantidadreferencias??0); //
    $bajoStock = ($productos[0]->bajostock??0) + ($subproductos[0]->bajostock??0); //
    $productosAgotados = ($productos[0]->productosagotados??0) + ($subproductos[0]->productosagotados??0); //

    if((int)$valorInv >= 1000000 && (int)$valorInv < 1000000000)$valorInv = round((int)$valorInv / 1000000, 2) . 'M';
    if((int)$valorInv >= 1000000000 && (int)$valorInv < 1000000000000)$valorInv = round((int)$valorInv / 1000000000, 2) . 'MM';

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/index', ['titulo'=>'Almacen', 'proveedores'=>$proveedores, 'productos'=>$productos, 'subproductos'=>$subproductos, 'valorInv'=>$valorInv, 'cantidadProductos'=>$cantidadProductos, 'cantidadReferencias'=>$cantidadReferencias, 'cantidadCategorias'=>$cantidadCategorias, 'bajoStock'=>$bajoStock, 'productosAgotados'=>$productosAgotados, 'alertas'=>$alertas, 'user'=>$_SESSION]);
  }


  public static function categorias(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      $categoria = new categorias($_POST);
      $alertas = $categoria->validar_nueva_categoria();
      if(empty($alertas)){
        $r = $categoria->crear_guardar();
        if($r[0]){
          $alertas['exito'][] = "Categoria creado correctamente";
        }else{
          $alertas['error'][] = "Error, intenta nuevamente";
        }
      }
    }
    
    $categorias = categorias::all();
    $router->render('admin/almacen/categorias', ['titulo'=>'Almacen', 'categorias'=>$categorias, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function productos(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];

    $productos = productos::all();
    $categorias = categorias::all();
    $unidadesmedida = unidadesmedida::all();
    $producto = new productos;

    foreach($productos as $value)$value->nombrecategoria = categorias::find('id', $value->idcategoria)->nombre;

    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    //$alertas = usuarios::getAlertas();
    $router->render('admin/almacen/productos', ['titulo'=>'Almacen', 'productos'=>$productos, 'categorias'=>$categorias, 'unidadesmedida'=>$unidadesmedida, 'producto'=>$producto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function crear_producto(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    $conversion = new conversionunidades;
    $categoria = categorias::find('id', $_POST['idcategoria']);
    $sucursales = sucursales::all();
    $stockProductoSucursales = new stockproductossucursal;
    $addnewprecios = new precios_personalizados;
    $preciospersonalizados = [];

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
        
        if($r[0]){
          $r1 = $categoria->actualizar();
          //precios personalizados
          if(isset($_POST['nuevosprecios'])){
            foreach($_POST['nuevosprecios'] as $index =>$value){
              if($value>0){
                $preciospersonalizados[$index]['idproductoid'] = $r[1];
                $preciospersonalizados[$index]['precio'] = $value;
                $preciospersonalizados[$index]['estado'] = 1;
              }
            }
            $addnewprecios->crear_varios_reg($preciospersonalizados);
          }

          $arrayequivalencias = $producto->equivalencias($r[1], $producto->idunidadmedida);
          $rc = $conversion->crear_varios_reg_arrayobj($arrayequivalencias);
          if($rc){
            //crear el inventario para todas las sucursales...
            $stocksucursal = [];
            foreach($sucursales as $index => $value){
              $stocksucursal[$index]['productoid'] = $r[1];
              $stocksucursal[$index]['sucursalid'] = $value->id;
              if($value->id == id_sucursal()){
                $stocksucursal[$index]['stock'] = $producto->stock;
                $stocksucursal[$index]['stockminimo'] = $producto->stockminimo;
              }else{
                $stocksucursal[$index]['stock'] = 0;
                $stocksucursal[$index]['stockminimo'] = 0;
              }
              $stocksucursal[$index]['habilitarventa'] = 1;
            }
            $stockProductoSucursales->crear_varios_reg($stocksucursal);
            $alertas['exito'][] = "Producto creado correctamente";
            $producto = new stdClass();
            //$producto->idunidadmedida = 1;
          }else{
            //**** eliminar producto
            $productodelete = productos::find('id', $r[1]);
            $productodelete->eliminar_registro();
            $alertas['error'][] = "Error, intentalo nuevamente";
          }
        }
      }
    }
    $categorias = categorias::all();
    $productos = productos::all();
    $unidadesmedida = unidadesmedida::all();
    foreach($productos as $value)$value->nombrecategoria = categorias::find('id', $value->idcategoria)->nombre;
    $router->render('admin/almacen/productos', ['titulo'=>'Almacen', 'productos'=>$productos, 'categorias'=>$categorias, 'unidadesmedida'=>$unidadesmedida, 'producto'=>$producto, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function subproductos(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    $conversion = new conversionunidades;
    $unidadmedida = unidadesmedida::find('id', $_POST['id_unidadmedida']); //unidad de medida base indicada para el subproducto
    $sucursales = sucursales::all();
    $stockinsumossucursales = new stockinsumossucursal();

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
            //crear el inventario para todas las sucursales...
            $stocksucursal = [];
            foreach($sucursales as $index => $value){
              $stocksucursal[$index]['subproductoid'] = $r[1];
              $stocksucursal[$index]['sucursalid'] = $value->id;
              if($value->id == id_sucursal()){
                $stocksucursal[$index]['stock'] = $subproducto->stock;
                $stocksucursal[$index]['stockminimo'] = $subproducto->stockminimo;
              }else{
                $stocksucursal[$index]['stock'] = 0;
                $stocksucursal[$index]['stockminimo'] = 0;
              }
            }
            $stockinsumossucursales->crear_varios_reg($stocksucursal);
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];

    $categorias = categorias::all();
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            
    }
    $proveedores = proveedores::all();
    $cajas = caja::idregistros('idsucursalid', id_sucursal());
    $bancos = bancos::all();
    $productos = productos::all();
    $subproductos = subproductos::all();
    $totalitems = []; //array_merge($productos, $subproductos);
    $router->render('admin/almacen/compras', ['titulo'=>'Almacen', 'proveedores'=>$proveedores, 'totalitems'=>$totalitems, 'categorias'=>$categorias, 'cajas'=>$cajas, 'bancos'=>$bancos, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }
  

  public static function distribucion(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
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


  public static function solicitudesrecibidas(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/solicitudesrecibidas', ['titulo'=>'Almacen', 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }


  public static function trasladarinventario(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/trasladarinventario', ['titulo'=>'Almacen', 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
  }

  public static function solicitarinventario(Router $router){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de inventario')&&userPerfil()>3)return;
    $alertas = [];
    
    $unidadesmedida = unidadesmedida::all();
    $router->render('admin/almacen/solicitarinventario', ['titulo'=>'Almacen', 'unidadesmedida'=>$unidadesmedida, 'alertas'=>$alertas, 'user'=>$_SESSION/*'negocio'=>negocio::get(1)*/]);
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
    session_start();
    isadmin();
    $productos = productos::all(); 
    ////////////// calcular el impuesto como global o como discriminado por producto /////////////////////
    $conflocal = config_local::getParamGlobal();
    foreach($productos as $index=>$producto){
      //unset($productos[$index]->descripcion);
      if($conflocal['discriminar_impuesto_por_producto']->valor_final == 0){ //si es 0, es no, toma el impuesto global
        $producto->impuesto = $conflocal['porcentaje_de_impuesto']->valor_final;
      }
      $producto->categoria = categorias::uncampo('id', $producto->idcategoria, 'nombre');
      $producto->preciosadicionales = precios_personalizados::idregistros('idproductoid', $producto->id);
    }
   echo json_encode($productos);
  }


  public static function actualizarproducto(){ //actualizar editar producto
    session_start();
    $alertas = []; 
    $producto = productos::find('id', $_POST['id']);
    $addnewprecios = new precios_personalizados;
    $tipo = $producto->tipoproducto;  //0 = simple,  1 = compuesto
    $idunidadmedidaDB = $producto->idunidadmedida;  //obtener el id de unidad de medida actual del subproducto
    $preciosAdicionalesDB = precios_personalizados::idregistros('idproductoid', $producto->id);
    $idprecionsadicionales = json_decode($_POST['idprecionsadicionales']);
    $nuevosPreciosFront = json_decode($_POST['nuevosprecios']);


    /////// valiadar que es una nueva imagen o distinta
    if($producto->foto && isset($_FILES['foto']['name'])) { //remplazar imagen existente
        $existe_archivo = file_exists($_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);
        if($existe_archivo)unlink($_SERVER['DOCUMENT_ROOT']."/build/img/".$producto->foto);    
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

            //$stockproducto = stockproductossucursal::uniquewhereArray(['productoid'=>$producto->id, 'sucursalid'=>id_sucursal()]);
            //$stockproducto->stock = $_POST['stockminimo'];
            $r = $producto->actualizar();
            
            if($r){

              $arrayIdeliminar = []; $nuevosprecios = [];
              ///IDs a eliminar de la DB
              foreach($preciosAdicionalesDB as $key => $value)
                if(!in_array($value->id, $idprecionsadicionales))$arrayIdeliminar[] = $value->id;
              //registros a insertar
              foreach ($nuevosPreciosFront as $value)
                if (!isset($value->id)) $nuevosprecios[] = $value;
              
              if($arrayIdeliminar)$r1 = precios_personalizados::eliminar_idregistros('id', $arrayIdeliminar);
              if($nuevosprecios)$r2 = $addnewprecios->crear_varios_reg_arrayobj($nuevosprecios);
              if($nuevosPreciosFront) $r3 = precios_personalizados::updatemultiregobj($nuevosPreciosFront, ['precio']);

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
    $producto->preciosadicionales = precios_personalizados::idregistros('idproductoid', $producto->id);
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
            $categoria = categorias::find('id', $producto->idcategoria);
            $categoria->totalproductos -= 1;
            $c = $categoria->actualizar();
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
          if($tipoelemento == 1){ //si el item es subproducto
            ///// actualizar costo en tabla ensamblaje productos_sub  //////
            $ubcostoEnsambla = productos_sub::actualizarLibre("UPDATE productos_sub SET costo = cantidadsubproducto*$element->precio_compra WHERE id_subproducto = $element->id;");
            
            ////// Obtener la suma de los subproductos que pertenece a un producto  //////
            $sql = "SELECT SUM(costo)/productos.rendimientoestandar AS precio_compra, id_producto AS id FROM productos_sub JOIN productos ON productos_sub.id_producto = productos.id
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
    $invpxs = true;
    $invsx = true;
    $invsxs = true;
    $compra = new compras($_POST);
    $detallecompra = new detallecompra();
    $carrito = json_decode($_POST['carrito']);
    //////////  SEPARAR LOS ITEMS EN PRODUCTOS Y SUBPRODUCTOS  ////////////
    $resultArray = array_reduce($carrito, function($acumulador, $objeto){
      $objeto->id = $objeto->iditem;
      //unset($objeto->iditem);
      if($objeto->tipo == 0){
        $acumulador['productos'][] = $objeto; // puede ser producto compuesto o simple
      }
      else{
        $acumulador['subproductos'][] = $objeto;
      }
      return $acumulador;
    }, ['productos'=>[], 'subproductos'=>[]]);

    
    ////// Obtengo los registros de la tabla productos_sub a actualizar su costo de compra por su id_subproducto, si el subproducto se repite lo trae n veces
    $itemsProSub = productos_sub::paginarwhere('', '', 'id_subproducto', json_decode($_POST['subID'])); 
    
    ////////  mapeo Optimizado de tipo O(A+B)
    $mapCostoSub = array_column($resultArray['subproductos'], 'precio_compra', 'id');
    
    foreach($itemsProSub as $index => $value){
      $value->costo = $mapCostoSub[$value->id_subproducto];
      if(array_key_last($itemsProSub) == $index){
        $in .= $value->id_producto; //in, voy obteniendo el id del producto que le pertenece a cada subproducto de la formula
      }else{
        $in .= $value->id_producto.', ';
      }
    } //hasta aqui itemsProSub son todos los registros de la tabla productos_sub en donde aparece un subproducto a comprar, y el costo es = al valor de la unidad del subproducto comprado



    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $compra->idusuario = $_SESSION['id'];
      $compra->nombreusuario = $_SESSION['nombre'];
      $compra->id_sucursal_id = id_sucursal();
      $alertas = $compra->validar();
      if(empty($alertas)){
        
        if(!empty($itemsProSub)){
          ////// Actualizo el costo de compra de los subproductos en la tabla productos_sub, costo segun su formula, y equivalente a una unidad del producto compuesto
          $costosprosub = productos_sub::actualizar_costos_de_prosub($itemsProSub, ['costo']);
          ////// Obtener la suma de los subproductos que pertenece a un producto compuesto y se divide por su rendimiento estandar para obtener el valor individual //////
          $sql = "SELECT SUM(costo)/productos.rendimientoestandar AS precio_compra, id_producto AS id FROM productos_sub JOIN productos ON productos_sub.id_producto = productos.id 
          WHERE id_producto IN ($in) GROUP BY id_producto;";
          $costos = productos_sub::camposJoinObj($sql); //costos = [{id:2, valor: 35044}, {}]
          //////// actualizar costo (precio de compra) de productos compuestos  /////
          if(!empty($costos))
          $costoproduct = productos::updatemultiregobj($costos, ['precio_compra']);//  Actualizar el o precio de compra de los productos compuestos
        }

        $r = $compra->crear_guardar();
        if($r[0]){
          foreach($carrito as $obj){
            $obj->idcompra = $r[1];
          }
          $r1 = $detallecompra->crear_varios_reg_arrayobj($carrito);  //crear los items de la factura de compra en tabla detallecompra
          if($r1){
            /// ACTUALIZAR EL STOCK Y PRECIO DE COMPRA (COSTO) DE LOS PRODUCTOS Y/O SUBPRODUCTOS DEL INVENTARIO ////
              //UPDATE nombretabla SET stock = CASE WHEN id = 1 THEN stock + 2 WHEN id = 3 THEN stock + 1 ELSE stock END, valor = CASE WHEN id = 1 THEN '800' WHEN id = 3 THEN '100' ELSE valor END WHERE id IN (1, 3, 5);
              
              if(!empty($resultArray['productos'])){
                $invpx = productos::camposaddinv($resultArray['productos'], ['stock', 'precio_compra']);  //$resultArray[0] = [{id: "1", idcategoria: "3", nombre: "xxx", cantidad: "4"}, {}]
                $invpxs = stockproductossucursal::addinv1condicion($resultArray['productos'], 'stock', 'productoid', "sucursalid = ".id_sucursal()); //actualizando stock del inventario centralizado
              }
              if(!empty($resultArray['subproductos']) && $invpx && $invpxs){
                $invsx = subproductos::camposaddinv($resultArray['subproductos'], ['stock', 'precio_compra']);
                $invsxs = stockinsumossucursal::addinv1condicion($resultArray['subproductos'], 'stock', 'subproductoid', "sucursalid = ".id_sucursal());
              }
            
              if($invpx && $invpxs){  //productos
                if($invsx && $invsxs){  //subproductos
                  $alertas['exito'][] = "Compra realizada con exito.";

                  //*****/////////// registrarlo en tabla gastos, operacion compra /////////////

                  //$ultimocierre = cierrescajas::ordenarlimite('id', 'DESC', 1);
                  $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idorigencaja'], 'idsucursal_id'=>id_sucursal()]); //ultimo cierre por caja
                  if(!isset($ultimocierre)){ // si la caja esta cerrada, y se hace apertura con la venta
                    $ultimocierre = new cierrescajas(['idcaja'=>$_POST['idorigencaja'], 'nombrecaja'=>caja::find('id', $_POST['idorigencaja'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
                    $ruc = $ultimocierre->crear_guardar();
                    if(!$ruc[0])$ultimocierre->estado = 1;
                    $ultimocierre->id = $ruc[1];
                  }
                  if($ultimocierre->estado == 0){ //si el cierre de caja de la caja seleccionada existe y esta abierta
                    $ingresoGasto = new gastos();
                    $ingresoGasto->idg_usuario = $compra->idusuario;
                    $ingresoGasto->id_compra = $r[1];
                    $ingresoGasto->valor = $compra->valortotal;
                    if($compra->origenpago == 0){ // 0 = caja
                      $ingresoGasto->idg_caja = $compra->idorigencaja;
                      $ultimocierre->gastoscaja = $ultimocierre->gastoscaja + $ingresoGasto->valor;
                    }else{ //si el gasto de la compra sale de un banco
                      $ingresoGasto->idg_caja = $compra->idorigencaja;
                      $ingresoGasto->id_banco = $compra->idorigenbanco;
                      $ultimocierre->gastosbanco = $ultimocierre->gastosbanco + $ingresoGasto->valor;
                      $ingresoGasto->tipo_origen = 1; //1 = banco. origen del gasto es banco
                    }
                    $ingresoGasto->idg_cierrecaja = $ultimocierre->id;
                    $ingresoGasto->idcategoriagastos = 1;
                    $ingresoGasto->operacion = "compra";
                    ///// validar gastos de la caja en el modelo
                    $alertas = $ingresoGasto->validar();
                    if(empty($alertas)){
                      $rig = $ingresoGasto->crear_guardar();
                      if($rig[0]){
                        $ruc = $ultimocierre->actualizar();
                        if($ruc){
                          $alertas['exito'][] = "Gasto de compra registrado correctamente";
                        }else{
                          $alertas['error'][] = "error al actualizar los gastos de compra en el cierre de caja actual";
                          /// borrar ultimo registro guardado de $ingresocaja
                          $ingresoGasto->eliminar_idregistros('id', [$r[1]]);
                          //eliminar lo de invpx y invsx
                        }
                      }else{
                        $alertas['error'][] = "Error al guardar el gasto de compra";
                      }
                    }else{
                      //eliminar lo de costosprosub, costoproduct, compras, invpx y invsx
                    }
                  }else{
                    //si el cierre de la caja no esta disponible revertir: invpx y invsx
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
      } //fin validar compra
    } //fin POST[]
    echo json_encode($alertas);
  }


  public static function descontarstock(){  //descontar cantidad a inventario
    session_start();
    $alertas = [];
    $iditem = $_POST['iditem'];
    $cantidad = $_POST['cantidad'];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if($_POST['tipoitem'] == 0){ //si es producto
        //$producto = productos::find('id', $iditem);
        $producto = stockproductossucursal::uniquewhereArray(['productoid'=>$iditem, 'sucursalid'=>id_sucursal()]);
        $producto->stock =$producto->stock-$cantidad;
        $ra = $producto->actualizar();
        //$producto->id = $producto->productoid;
        if($ra){
            $alertas['exito'][] = "Stock del producto actualizado con exito";
            $alertas['item'][] = $producto;
        }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }else{  // si es insumo subproducto
        //$insumo = subproductos::find('id', $iditem);
        $insumo = stockinsumossucursal::uniquewhereArray(['subproductoid'=>$iditem, 'sucursalid'=>id_sucursal()]);
        $insumo->stock =  $insumo->stock-$cantidad;
        $ra = $insumo->actualizar();
        //$producto->id = $producto->subproductoid;
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
        $productostock = stockproductossucursal::uniquewhereArray(['productoid'=>$iditem, 'sucursalid'=>id_sucursal()]);
        $productostock->stock =  $productostock->stock+$cantidad;
        $ra = $productostock->actualizar();
        
        $producto = productos::find('id', $iditem);
        $producto->stock = $productostock->stock;
        //procesar el descuento de los insumos del producto compuesto y de produccion tipo contruccion
        //validar si el producto compuesto tiene insumos asociados y si es de tipo construccion
        if(isset($_POST['construccion']) && $_POST['construccion'] == 1){
          //////// Selecciona y trae la cantidad subproductos del producto compuesto a descontar del inventario
          $producto->porcion = $cantidad/$producto->rendimientoestandar;
          $descontarSubproductos = productos_sub::cantidadSubproductosXventa([$producto]);
          $soloIdSubProduct = [];
          foreach($descontarSubproductos as $index => $value){
            $value->id = $value->id_subproducto;
            $soloIdSubProduct[] = $value->id;
          }
          
          if(!empty($descontarSubproductos)){
            //$invSub = subproductos::updatereduceinv($descontarSubproductos, 'stock');
            $invSub = stockinsumossucursal::reduceinv1condicion($descontarSubproductos, 'stock', 'subproductoid', "sucursalid = ".id_sucursal());
            $query = "SELECT * FROM stockinsumossucursal WHERE subproductoid IN(".join(', ', $soloIdSubProduct).") AND sucursalid = 1;";
            $returnInsumos = stockinsumossucursal::camposJoinObj($query);
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
          $alertas['item'][] = $productostock;
        }else{
          $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }

      }else{  // si es insumo subproducto
        //$insumo = subproductos::find('id', $iditem);
        $insumo = stockinsumossucursal::uniquewhereArray(['subproductoid'=>$iditem, 'sucursalid'=>id_sucursal()]);
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
        //$producto = productos::find('id', $iditem);
        $producto = stockproductossucursal::uniquewhereArray(['productoid'=>$iditem, 'sucursalid'=>id_sucursal()]);
        $producto->stock = $cantidad;
        $ra = $producto->actualizar();
        if($ra){
            $alertas['exito'][] = "Stock del producto actualizado con exito";
            $alertas['item'][] = $producto;
        }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
      }else{  // si es insumo subproducto
        //$insumo = subproductos::find('id', $iditem);
        $insumo = stockinsumossucursal::uniquewhereArray(['subproductoid'=>$iditem, 'sucursalid'=>id_sucursal()]);
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


  public static function getStockproductosXsucursal(){
    $insumos = stockinsumossucursal::getStockinsumosXsucursal();
    $productos = stockproductossucursal::getStockproductosXsucursal();
    $newarray = array_merge($insumos, $productos);
    //debuguear($newarray);
    echo json_encode($newarray);
  }


  //////////////    GESTION DE PROVEEDORES    //////////////////

  ///////////// procesando la gestion de los proveedores ////////////////
    public static function allproveedores(){  //api llamado desde gestionproveedores.js
      $proveedores = proveedores::all();
      echo json_encode($proveedores);
    }

    public static function crearProveedor(){ //api llamada desde el modulo de gestionproveedores.ts cuando se crea un cliente
        session_start();
        isadmin();
        $alertas = [];
        $proveedor = new proveedores($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $alertas = $proveedor->validar();
            if(empty($alertas)){ //si los campos cumplen los criterios  
                $r = $proveedor->crear_guardar();
                if($r[0]){
                    $proveedor->id = $r[1];
                    $proveedor->created_at = date('Y-m-d H:i:s');
                    $alertas['exito'][] = 'proveedor creada correctamente';
                    $alertas['proveedor'] = $proveedor;
                }else{
                    $alertas['error'][] = 'Hubo un error en el proceso, intentalo nuevamente';
                }
            }
        }
        echo json_encode($alertas);
    }

    public static function actualizarProveedor(){
        session_start();
        $alertas = []; 
        $proveedor = proveedores::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $proveedor->compara_objetobd_post($_POST);
            $alertas = $proveedor->validar();
            if(empty($alertas)){
                $r = $proveedor->actualizar();
                if($r){
                    $alertas['exito'][] = "Datos del proveedor actualizados";
                    $alertas['proveedor'][] = $proveedor;
                }else{
                    $alertas['error'][] = "Error al actualizar proveedor";
                }
            }
        }
        echo json_encode($alertas);  
    }

    public static function eliminarProveedor(){
        session_start();
        $proveedor = proveedores::find('id', $_POST['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            if(!empty($proveedor)){
                $r = $proveedor->eliminar_registro();
                if($r){
                    ActiveRecord::setAlerta('exito', 'proveedor eliminado correctamente');
                }else{
                    ActiveRecord::setAlerta('error', 'error en el proceso de eliminacion');
                }
            }else{
                ActiveRecord::setAlerta('error', 'proveedor no encontrada');
            }
        }
        $alertas = ActiveRecord::getAlertas();
        echo json_encode($alertas); 
    }

}