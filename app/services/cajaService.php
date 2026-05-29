<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\caja\declaracionesdineros;
use App\Models\clientes\clientes;
use App\Models\clientes\direcciones;
use App\Models\configuraciones\mediospago;
use App\Models\configuraciones\tarifas;
use App\Models\configuraciones\usuarios;
use App\Models\parametrizacion\config_local;
use App\Models\sucursales;
use App\Models\ventas\facturas;
use App\Models\ventas\ventas;
use App\Repositories\creditos\separadoMediopagoRepository;
use stdClass;

class cajaService {

    public static function printdetallecierre(int $id):?array{
        
        $discriminarmediospagos = [];
        $conflocal = config_local::getParamGlobal();
        $indicadorCaja = $conflocal['indicador_caja']->valor_final;

        $separadomediospagoRepo = new separadoMediopagoRepository();
        $ultimocierre = cierrescajas::find('id', $id);
        $facturas = facturas::idregistros('idcierrecaja', $ultimocierre->id);

        $factmediospagos = cierrescajas::discriminarmediospagos($ultimocierre->id);
        $sepMediosPago = $separadomediospagoRepo->allMediospagoXCierrecaja($ultimocierre->id);
        foreach (array_merge($factmediospagos, $sepMediosPago) as $item) {
            $id = $item['idmediopago'];
            if (!isset($discriminarmediospagos[$id])) {
                $discriminarmediospagos[$id] = $item;
                $discriminarmediospagos[$id]['valor'] = (float)$item['valor'];
            } else {
                $discriminarmediospagos[$id]['valor'] += (float)$item['valor'];
            }
        }

        $discriminarimpuesto = cierrescajas::discriminarimpuesto($ultimocierre->id);
        $ventasxusuarios = cierrescajas::ventasXusuario($ultimocierre->id);
        $mediospagos = mediospago::all();  //se usa para la declaracion de valores.
        $declaracion = declaracionesdineros::idregistros('idcierrecajaid', $ultimocierre->id);
        //////////// Indicador de caja //////////////////
        $diferencial = $indicadorCaja == 1?($ultimocierre->basecaja - $ultimocierre->gastoscaja):($indicadorCaja == 2?(-$ultimocierre->gastoscaja):($indicadorCaja == 3?($ultimocierre->basecaja - $ultimocierre->gastoscaja - $ultimocierre->domicilios):(- $ultimocierre->gastoscaja - $ultimocierre->domicilios)));
        //////////// mapeo de arreglo de valores declarados con el arreglo de los pagos discriminados /////////////
        $sobrantefaltante = $declaracion;
        foreach($discriminarmediospagos as $i => $dis){
            if($dis['idmediopago'] == 1)$dis['valor'] += $diferencial;
            $aux = 0;
            foreach($declaracion as $j => $dec){
                if($dis['idmediopago'] == $dec->id_mediopago){
                $sobrantefaltante[$j]->valorsistema = $dis['valor'];
                $aux = 1;
                break;
                }
            }
            if($aux == 0){
                $newobj = new stdClass();
                $newobj->id_mediopago = $dis['idmediopago'];
                $newobj->idcierrecajaid = $ultimocierre->id;
                $newobj->nombremediopago = $dis['mediopago'];
                $newobj->valordeclarado = 0;   // si no coincide el medio de pago del sistema con el declarado coloca 0
                $newobj->valorsistema = $dis['valor']; // si no coincide el medio de pago del sistema con el declarado coloca 0
                $sobrantefaltante[] = $newobj;
            }
        }

        return compact('sobrantefaltante', 'mediospagos', 'discriminarmediospagos', 'discriminarimpuesto', 'ultimocierre', 'facturas', 'ventasxusuarios');
        //return ['sobrantefaltante'=>$sobrantefaltante, 'mediospagos'=>$mediospagos, 'discriminarmediospagos'=>$discriminarmediospagos, 'discriminarimpuesto'=>$discriminarimpuesto, 'ultimocierre'=>$ultimocierre, 'facturas'=>$facturas, 'ventasxusuarios'=>$ventasxusuarios];

    }



    public static function detalleVenta(int $id):?array{
        $factura = facturas::find('id', $id);
        $productos = ventas::idregistros('idfactura', $id);
        $cliente = clientes::find('id', $factura->idcliente);
        $direccion = direcciones::uniquewhereArray(['id'=>$factura->iddireccion, 'idcliente'=>$factura->idcliente]);
        if(!$direccion)$direccion = direcciones::find('id', 1);
        $tarifa = tarifas::find('id', $direccion->idtarifa);
        $vendedor = usuarios::find('id', $factura->idvendedor);
        $sucursal = sucursales::find('id', id_sucursal());
        $lineasencabezado = explode("\n", $sucursal->datosencabezados??'');
        return compact('factura', 'productos', 'cliente', 'direccion', 'tarifa', 'vendedor', 'lineasencabezado', 'sucursal');
    }


    public static function despacharOrden(int $id):array{
        $alertas = [];
        $factura = facturas::find('id', $id);
        $getDB = facturas::getDB();
        if($factura->entregado == 0 && $factura->entrega == 'Domicilio'){
            $factura->entregado = 1;
            $getDB->begin_transaction();
            try {
                $factura->actualizar();
                $getDB->commit();
                $alertas['exito'][] = "Orden despachada.";
            } catch (\Throwable $th) {
                $getDB->rollback();
                $alerta['error'][] = "Error al procesar solicitud >>".$th->getMessage();
            }
        }else{
            $alerta['error'][] = "Error, verificar si ya se despacho como domicilio";
        }
        return $alertas;
        
    }
    
}