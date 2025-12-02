<?php

namespace App\Controllers;

use App\classes\Traits\DocumentTrait;
use App\Models\configuraciones\consecutivos;
use App\Models\configuraciones\usuarios; //namespace\clase hija
use App\Models\ActiveRecord;
use App\Models\clientes\departments;
use App\Models\clientes\municipalities;
use App\Models\configuraciones\notacreditoinvoice;
use App\Models\parametrizacion\config_local;
use App\Models\configuraciones\tipofacturador;
use App\Models\felectronicas\adquirientes;
use App\Models\felectronicas\diancompanias;
use App\Models\felectronicas\facturas_electronicas;
use App\Models\sucursales;
use App\Models\ventas\facturas;
use MVC\Router;  //namespace\clase
 
class apidiancontrolador{

  use DocumentTrait;

  //////////////---------   API   ----------///////////////////
  public static function citiesXdepartments(){
    session_start();
    isadmin();
    if(!tienePermiso('Habilitar modulo de configuracion')&&userPerfil()>=3)return;
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id)){
        $alertas['error'][] = "Hubo un error el id del departamento no es valido";
        echo json_encode($alertas);
        return;
    }
    $idsucursal = id_sucursal();
    $dapartments = departments::all();
    $conflocal = config_local::getParamGlobal();

    $municipios = municipalities::idregistros('department_id', $id);
    echo json_encode($municipios);
  }


  public static function crearCompanyJ2(){
    session_start();
    isadmin();
    $alertas = [];
    if(userPerfil()>1){
      $alertas['error'][] = "No tienes permisos";
      return;
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }

    $compañia = json_decode(file_get_contents('php://input'), true);
    $identification_number = $compañia['identification_number'];
    $companyExist = diancompanias::find('identification_number', $identification_number);
    if($companyExist){
      $companyExist->compara_objetobd_post($compañia);
      $c = $companyExist->actualizar();
      if($c){
        $alertas['exito'][] = "Compañia guardada localmente";
        $alertas['id'] = $companyExist->id;
      }else{
        $alertas['error'][] = "No se guardo la configuracion de la compañia";
      }
    }else{
      $diancompanias = new diancompanias($compañia);
      $diancompanias->estado = 1;
      $r = $diancompanias->crear_guardar();
      if($r[0]){
        $alertas['exito'][] = "Compañia guardada localmente";
        $alertas['id'] = $r[1];
      }else{
        $alertas['error'][] = "No se guardo la configuracion de la compañia";
      }
    }
    echo json_encode($alertas);
  }


  public static function getCompaniesAll(){
    session_start();
    isadmin();
    $alertas = [];
    $compañias = diancompanias::all();
    echo json_encode($compañias);
  }

  public static function eliminarCompanyLocal(){
    session_start();
    isadmin();
    $alertas = [];
    $id = $_GET['id'];
    if(!is_numeric($id)){
        $alertas['error'][] = "Hubo un error, el id de la compañia no es valido";
        echo json_encode($alertas);
        return;
    }
    $compañia = diancompanias::find('identification_number', $id);
    if($compañia){
      $r = $compañia->eliminar_registro();
      if($r){
        $alertas['exito'][] = "Compañia eliminada";
      }else{
        $alertas['error'][] = "No fue posible eliminar compañia";
      }
    }
    echo json_encode($alertas);
  }


  //guardar resolucion invoice cuando se consulta o decarga de la Dian, de forma local.
  public static function guardarResolutionJ2(){
    session_start();
    isadmin();
    $alertas = [];
    
    if(userPerfil()>1){
      $alertas['error'][] = "No tienes permisos";
      return $alertas;
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }

    $resolution = json_decode(file_get_contents('php://input'), true);
    $existeResolution = consecutivos::uniquewhereArray(['resolucion'=>$resolution['ResolutionNumber'], 'prefijo'=>$resolution['Prefix']]);
    if($existeResolution){
      $existeResolution->estado = 1;
      $alertas['exito'][] = "Resolucion descargada en sistema.";
      $existeResolution->nombretipofacturador = tipofacturador::find('id', $existeResolution->idtipofacturador);
      $alertas['facturador'] = $existeResolution;
    }else{
      $facturador = new consecutivos([
                                      'id_sucursalid'=>id_sucursal(), 
                                      'idcompania' => $resolution['idcompany'],
                                      'idtipofacturador'=>1, 
                                      'nombre'=>'Electronica '.$resolution['Prefix'], 
                                      'rangoinicial'=>$resolution['FromNumber'],
                                      'rangofinal'=>$resolution['ToNumber'],
                                      'siguientevalor'=>1,
                                      'fechainicio'=>$resolution['ValidDateFrom'],
                                      'fechafin'=>$resolution['ValidDateTo'],
                                      'resolucion'=>$resolution['ResolutionNumber'],
                                      'prefijo'=>$resolution['Prefix'],
                                      'mostrarresolucion'=>1,
                                      'mostrarimpuestodiscriminado'=>0,
                                      'electronica'=>1,
                                      'estado'=>1
                                    ]);
      //debuguear($facturador);
      $r = $facturador->crear_guardar();
      if($r[0]){
        $alertas['exito'][] = "Resolucion descargada en sistema.";
        $facturador->nombretipofacturador = tipofacturador::find('id', $facturador->idtipofacturador);
        $facturador->id = $r[1];
        $alertas['facturador'] = $facturador;
      }else{
        $alertas['error'][] = "Error al descargar resolucion, intentalo de nuevo";
      }
    }

    echo json_encode($alertas);
  }


  //guardar resolucion de nota credito invoice, de forma local.
  public static function guardarNCInvoiceJ2(){
    session_start();
    isadmin();
    $alertas = [];

    if(userPerfil()>1){
      $alertas['error'][] = "No tienes permisos";
      return $alertas;
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }

    $resolution = json_decode(file_get_contents('php://input'), true);
    $existeResolution = notacreditoinvoice::uniquewhereArray(['id_compania'=>$resolution['idcompany'], 'prefix'=>$resolution['Prefix']]);
    if($existeResolution){
      $existeResolution->estado = 1;
      $alertas['exito'][] = "Resolucion de NC ya disponible en sistema.";
    }else{
      $facturadornc = new notacreditoinvoice([
                                      'idsucursal_id_fk'=>id_sucursal(), 
                                      'id_compania' => $resolution['idcompany'],
                                      'type_document_id'=>$resolution['type_document_id'], 
                                      'prefix'=>'Electronica '.$resolution['Prefix'], 
                                      'resolution'=>'',
                                      'nextnumber'=>1,
                                      'resolution_date'=>date('Y-m-d'),
                                      'technical_key'=>$resolution['technical_key'], //identification_number
                                      'from'=>$resolution['from'],
                                      'to'=>$resolution['to'],
                                      'date_from'=>'',
                                      'date_to'=>'',
                                      'estado'=>1
                                    ]);
      //debuguear($facturadornc);
      $r = $facturadornc->crear_guardar();
      if($r[0]){
        $alertas['exito'][] = "Resolucion descargada en sistema.";
      }else{
        $alertas['error'][] = "Error al descargar resolucion, intentalo de nuevo";
      }
    }
    echo json_encode($alertas);
  }


  public static function filterAdquirientes(){
    session_start();
    isadmin();
    $alertas = [];
    $adquirientes = adquirientes::all();
    echo json_encode($adquirientes);
  }

  public static function guardarAdquiriente(){
    session_start();
    isadmin();
    $alertas = [];
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }
    $datosadquiriente = json_decode(file_get_contents('php://input'), true);
    $existeAdquiriente = adquirientes::find('identification_number', $datosadquiriente['identification_number']);
    if($existeAdquiriente){
      $existeAdquiriente->compara_objetobd_post($datosadquiriente);
      $r = $existeAdquiriente->actualizar();
      $r = "actualizar";
      $alertas['response'] = $r;
      $alertas['obj'] = $existeAdquiriente;
    }else{
      $adquiriente = new adquirientes($datosadquiriente);
      $r = $adquiriente->crear_guardar();
      $r = "crear";
      $alertas['response'] = $r;
      $alertas['obj'] = $adquiriente;
    }
    echo json_encode($alertas);
  }


  //Metodo usado en ventas.sendinvoice.ts para enviar una factura electronica desde ventas.ts
  public static function sendInvoice(){
    session_start();
    isadmin();
    $alertas = [];
    
    $url = "https://apidianj2.com/api/ubl2.1/invoice"; 
    ///////////    enviar FE     /////////////
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }
    $idfactura = json_decode(file_get_contents('php://input'), true);
    $factura = facturas::find('id', $idfactura['id']);
    $facturaDian = facturas_electronicas::find('id_facturaid', $idfactura['id']);
    if($facturaDian && $factura->estado == 'Paga' && $facturaDian->id_estadoelectronica != 2)
      $res = self::sendInvoiceDian($facturaDian->json_envio, $url, $facturaDian->token_electronica);

    if(!$res['success']){
      $alertas['error'][] = $res['error'];
      echo json_encode($alertas);
      return;
    }
   
    //actualizar respuesta de la dian en la tabla facturas_electronicas
    if($res['success'] && buscarClaveArray($res, 'IsValid')=='true'){
      $arrayFile = explode('.', buscarClaveArray($res, 'urlinvoicexml'));
      $facturaDian->id_estadoelectronica = 2; //aceptada
      $facturaDian->cufe = buscarClaveArray($res, 'cufe');
      $facturaDian->qr = buscarClaveArray($res, 'QRStr');
      $facturaDian->filename = "$facturaDian->nitcompany/$arrayFile[0]";
      $facturaDian->link =  $facturaDian->qr;
      $mensaje = $res["response"]["ResponseDian"]["Envelope"]["Body"]["SendBillSyncResponse"]["SendBillSyncResult"];
      $facturaDian->respuesta_factura = join(' // ', $mensaje["ErrorMessage"]["string"]).', IsValid = '.$mensaje["IsValid"].', StatusDescription = '.$mensaje["StatusDescription"].', StatusMessage = '.$mensaje["StatusMessage"];
      $facturaDian->fecha_ultimo_intento = date('Y-m-d H:i:s');
      $r = $facturaDian->actualizar();
      $alertas['exito'][] = "Factura electronica procesadamente exitosamente.";
      echo json_encode($alertas);
    }else{
      $facturaDian->id_estadoelectronica = 3; //error
      $facturaDian->cufe = '';
      $facturaDian->qr = '';
      $facturaDian->link =  '';
      $mensaje = $res["response"]["ResponseDian"]["Envelope"]["Body"]["SendBillSyncResponse"]["SendBillSyncResult"];
      $facturaDian->respuesta_factura = join(' // ', $mensaje["ErrorMessage"]["string"]).', IsValid = '.$mensaje["IsValid"].', StatusDescription = '.$mensaje["StatusDescription"].', StatusMessage = '.$mensaje["StatusMessage"];
      $facturaDian->fecha_ultimo_intento = date('Y-m-d H:i:s');
      $r = $facturaDian->actualizar();
      $alertas['error'][] = "Error al enviar la factura electronica. $facturaDian->respuesta_factura";
      echo json_encode($alertas);
    }
  }
  
  
  public static function sendNc(){
    session_start();
    isadmin();
    $alertas = [];
    $getDB = facturas_electronicas::getDB();
    $url = "https://apidianj2.com/api/ubl2.1/credit-note";
    
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      http_response_code(405); // Método no permitido
      echo json_encode(['error' => 'Método no permitido']);
      exit;
    }
    $datos = json_decode(file_get_contents('php://input'), true);
    $facturaDian = facturas_electronicas::find('id', $datos['id']);
    $companyExist = diancompanias::find('identification_number', $facturaDian->nitcompany);
    if($companyExist){
      //obtener resolucion de NC de la factura electronica, esta en la api y proximamente local
      $resolInvoiceNc = notacreditoinvoice::find('id_compania', $companyExist->id);
      
      if($datos['consecutivo']!=''&&is_numeric($datos['consecutivo'])) //consecutivo personalizado
        $resolInvoiceNc->nextnumber = $datos['consecutivo'];
     
      if($facturaDian&&$facturaDian->id_estadoelectronica == 2&&$facturaDian->nota_credito==0){ //la factura electronica debe estar en estado aceptado por la Dian 
        $jsonenvio = json_decode($facturaDian->json_envio);
        //debuguear($jsonenvio);
        $jsonNcDian = self::createNcElectronic($jsonenvio, $facturaDian->numero, $facturaDian->prefijo, $facturaDian->cufe, $facturaDian->fecha_factura, $resolInvoiceNc);
        $res = self::sendInvoiceDian($jsonNcDian, $url, $facturaDian->token_electronica);
        debuguear($res);
        if(!$res['success']){
          $alertas['error'][] = $res['error'];
          //...
          echo json_encode($alertas);
          return;
        }

        if($res['success'] && buscarClaveArray($res, 'IsValid')=='true'){
          // actualizar consecutivo en la tabla de notacreditoinvoice
          $getDB->begin_transaction();
          try {
            $arrayFile = explode('.', buscarClaveArray($res, 'urlinvoicexml'));
            $facturaDian->id_estadonota = 2;
            $facturaDian->nota_credito = 1; //que es nc
            $facturaDian->prefixnc = $resolInvoiceNc->prefix;
            $facturaDian->num_nota = $resolInvoiceNc->nextnumber;
            $facturaDian->cufe_nota = buscarClaveArray($res, 'cude');
            $facturaDian->qrnc = buscarClaveArray($res, 'QRStr');
            $facturaDian->linknc =  $facturaDian->qrnc;
            $facturaDian->filenamenc = "$facturaDian->nitcompany/$arrayFile[0]";
            $facturaDian->fecha_nota = date('Y-m-d H:i:s');
            $facturaDian->json_envionc = $jsonNcDian;
            $mensaje = $res["response"]["ResponseDian"]["Envelope"]["Body"]["SendBillSyncResponse"]["SendBillSyncResult"];
            $facturaDian->respuesta_nota = join(' // ', $mensaje["ErrorMessage"]["string"]).', IsValid = '.$mensaje["IsValid"].', StatusDescription = '.$mensaje["StatusDescription"].', StatusMessage = '.$mensaje["StatusMessage"];
            $r = $facturaDian->actualizar();
            $resolInvoiceNc->nextnumber += 1;
            if($datos['consecutivo']!=''&&is_numeric($datos['consecutivo'])) //consecutivo personalizado
            $resolInvoiceNc->nextnumber = $datos['consecutivo'];
            $resolInvoiceNc->actualizar();
            $alertas['exito'][] = "Nota credito procesadamente exitosamente.";
            $getDB->commit();
            echo json_encode($alertas);
          } catch (\Throwable $th) {
            $getDB->rollback();
            $alerta['error'][] = "Error en base de datos al generar la nota credito.";
            $alerta['error'][] = $th->getMessage();
            echo json_encode($alertas);
          }
        }else{
          $facturaDian->id_estadonota = 3; //error
          $facturaDian->nota_credito = 1; //que es nc
          $facturaDian->prefixnc = $resolInvoiceNc->prefix;
          $facturaDian->num_nota = $resolInvoiceNc->nextnumber;
          $facturaDian->fecha_nota = date('Y-m-d H:i:s');
          $facturaDian->json_envionc = $jsonNcDian;
          $mensaje = $res["response"]["ResponseDian"]["Envelope"]["Body"]["SendBillSyncResponse"]["SendBillSyncResult"];
          debuguear($mensaje);
          $facturaDian->respuesta_nota = join(' // ', $mensaje["ErrorMessage"]["string"]).', IsValid = '.$mensaje["IsValid"].', StatusDescription = '.$mensaje["StatusDescription"].', StatusMessage = '.$mensaje["StatusMessage"];
          $r = $facturaDian->actualizar();
          $resolInvoiceNc->nextnumber += 1;
          if($datos['consecutivo']!=''&&is_numeric($datos['consecutivo'])) //consecutivo personalizado
          $resolInvoiceNc->nextnumber = $datos['consecutivo'];
          $resolInvoiceNc->actualizar();
          $alertas['error'][] = "Error al generar nota credito. $facturaDian->respuesta_factura";
          echo json_encode($alertas);
        }
      }
    }else{
      $alertas['error'][] = "Error, no se puede generar nota credito, compañia no existe";
      echo json_encode($alertas);
    }
  }


}
