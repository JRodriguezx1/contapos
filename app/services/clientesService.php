<?php 

namespace App\services;

use App\Models\caja\cierrescajas;
use App\Models\clientes\preciosporcliente;
use App\Models\comisiones\comisiones;
use App\Models\comisiones\pagos_comisiones;
use App\Models\configuraciones\caja;
use App\Models\configuraciones\usuarios;
use App\Models\gastos;
use App\Models\sucursales;
use App\Repositories\comisiones\comisionesRepository;
use App\Repositories\comisiones\pagosComisionesRepository;
use stdClass;

class clientesService{

    private $repoComisiones;
    private $repoPagosComisiones;

    
    public function __construct()
    {
        $this->repoComisiones = new comisionesRepository();
        $this->repoPagosComisiones = new pagosComisionesRepository();
    }


    public function preciospersonalizados(array $data):array{
        $alertas = [];
        $asociar = new preciosporcliente($data);
        $alertas = $asociar->validar();
        if(empty($alertas)){
            $existe = preciosporcliente::uniquewhereArray(['idcliente'=>$_POST['idcliente'], 'idproducto'=>$_POST['idproducto']]);
            if($existe){//actualizar
                $existe->compara_objetobd_post($_POST);
                $ra = $existe->actualizar();
                if($ra){
                    $alertas['exito'][] = "Precio personalizado actualizado.";
                }else{
                    $alertas['error'][] = "Hubo un error, intentalo nuevamente";
                }
            }else{//crear
                $r = $asociar->crear_guardar();
                if($r[0]){
                    $alertas['exito'][] = "Precio relacionado al cliente.";
                }else{
                    $alertas['error'][] = "Hubo un error, intentalo nuevamente";
                }
            }
        }
        return $alertas;
    }


    public function eliminarPrecioPersonalizado(int $idcliente, int $idproducto):array{
        $alertas = [];
        $r = preciosporcliente::eliminar_wherearray(['idcliente'=>$idcliente, 'idproducto'=>$idproducto]);
        if($r){
            $alertas['exito'][] = "Precio personalizado eliminado correctamente.";
        }else{
            $alertas['error'][] = "Hubo un error, intentalo nuevamente";
        }
        return $alertas;
    }



    //////////////////////////////****NO****///////////////////////////////


    public function crearComision(int $idfacturaid, int $idusuariofk, float $valorfactura, float $percentcomision, float $valorcomision):void{
        $this->repoComisiones->insert(new comisiones(['idfacturaid'=>$idfacturaid, 'idusuariofk'=>$idusuariofk, 'valorfactura'=>$valorfactura, 'percentcomision'=>$percentcomision, 'valorcomision'=>$valorcomision]));
    
    }
    

    public function liquidarComision(array $data):array{
        $alertas = [];
        $getDB = $this->repoPagosComisiones->getConexion();
        $liquidar = new pagos_comisiones($data);

        $alertas = $liquidar->validar();
        if(!empty($alertas))return $alertas;

        $ultimocierre = cierrescajas::uniquewhereArray(['estado'=>0, 'idcaja'=>$_POST['idcaja'], 'idsucursal_id'=>id_sucursal()]); //ultimo cierre por caja
        if(!isset($ultimocierre)){ // si la caja esta cerrada y luego aqui se hace apertura
            $ultimocierre = new cierrescajas(['idcaja'=>$_POST['idcaja'], 'nombrecaja'=>caja::find('id', $_POST['idcaja'])->nombre, 'estado'=>0, 'idsucursal_id'=>id_sucursal()]);
            $r = $ultimocierre->crear_guardar();
            if(!$r[0])$ultimocierre->estado = 1; //si no secrea el nuevo cierre de caja, estse nuevo se coloca en 1 el estado
            $ultimocierre->id = $r[1];
        }

        if($ultimocierre->estado == 0){ 
            $liquidar->fkcierrecaja = $ultimocierre->id;
            $ingresoGasto = new gastos($_POST);
            $ingresoGasto->idg_usuario = $_SESSION['id'];
            $ingresoGasto->idg_cierrecaja = $ultimocierre->id;
            $ingresoGasto->idcategoriagastos = 11;
            if($_POST['origengasto'] == 'gastocaja'){
                $ingresoGasto->idg_caja = $_POST['idcaja'];
                $ultimocierre->gastoscaja = $ultimocierre->gastoscaja + $ingresoGasto->valor;
            }else{ //si el gasto sale de un banco
                $ingresoGasto->idg_caja = $_POST['idcaja'];
                $ingresoGasto->id_banco = $_POST['idbanco'];
                $ultimocierre->gastosbanco = $ultimocierre->gastosbanco + $ingresoGasto->valor;
                $ingresoGasto->tipo_origen = 1; //1 = banco. origen del gasto es banco
            }
            ///// validar gastos en el modelo
            $alertas = $ingresoGasto->validar();
            if(empty($alertas)){
                $rig = $ingresoGasto->crear_guardar();
                if($rig[0]){
                    $ruc = $ultimocierre->actualizar();
                    if(!$ruc){
                        $alertas['error'][] = "error al actualizar los gastos en el cierre de caja actual";
                        /// borrar ultimo registro guardado de $ingresocaja
                        $ingresoGasto->eliminar_idregistros('id', [$rig[1]]);
                        return $alertas;
                    }
                }else{
                    $alertas['error'][] = "Error al guardar el gasto de dinero";
                    return $alertas;
                }
            }
        }

        $getDB->begin_transaction();
        try {
            $rpc = $this->repoPagosComisiones->insert($liquidar);
            $getDB->commit();
            //actualizar el gasto creado con el id de pagos_comisiones
            $gastoComision = gastos::find('id', $rig[1]);
            $gastoComision->idpagos_comisiones = $rpc[1];
            $gastoComision->actualizar();
            return $rpc;
        } catch (\Throwable $th) {
            $getDB->rollback();
            throw $th;
        }
    }

    
}