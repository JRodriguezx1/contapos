<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\caja\declaracionesdineros;
use App\Models\configuraciones\mediospago;
use App\Models\parametrizacion\config_local;
use App\Models\ventas\facturas;
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
    
}