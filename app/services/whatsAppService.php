<?php 

namespace App\services;

use App\Models\configuraciones\caja;
use App\Models\configuraciones\notificacionesWS;
use App\Models\configuraciones\usuarios;
use App\Models\inventario\detalletrasladoinv;
use App\Models\sucursales;
use GreenApi\RestApi\GreenApiClient;
use stdClass;

class whatsAppService{

    private GreenApiClient $client;
    private string $msg;
    
    public function __construct()
    {
        $this->client = new GreenApiClient(
                            $_ENV['GREEN_API_INSTANCE'],
                            $_ENV['GREEN_API_TOKEN']
                        );
    }

    public function crearContactoWS($array):array{
        $contactWS = notificacionesWS::whereArray(['sucursal_idfk'=>id_sucursal()]);
        if(count($contactWS)>0){
            $alertas['error'][] = "Solo un contacto por sucursal";
            return $alertas;
        }
        $ws = new notificacionesWS($array);
        $alertas = $ws->validar();
        if(!empty($alertas))return $alertas;
        $getDB = notificacionesWS::getDB();
        $getDB->begin_transaction();
        try {
            $r = $ws->crear_guardar();  //si falla no ejecuta el commit ni el return.
            $getDB->commit();
            return $r;
        } catch (\Throwable $th) {
            $getDB->rollback();
            throw $th;
        }
    }


    public function eliminarContacto($id):bool{
        $contactWS = notificacionesWS::find('id', $id);
        $getDB = notificacionesWS::getDB();
        $getDB->begin_transaction();
        try {
             $r = $contactWS->eliminar_registro();
            $getDB->commit();
            return $r;
        } catch (\Throwable $th) {
            $getDB->rollback();
            throw $th;
        }
    }


    public function sendMessage(string $number, string $text):stdClass{
        $result = $this->client->sending->sendMessage('573003520420@c.us', $text);
        return $result;
    }
    

    public function sendTextOrdenEliminada(object $factura, int $idcaja, $devolverInv, array $productos = []){
        $sucursal = sucursales::find('id', id_sucursal());
        $caja = caja::find('id', $idcaja);
        $usuario = usuarios::find('id', $_SESSION['id']);
        $fechaAnulacion = date('Y-m-d H:i:s');
        $this->msg = '';
        // 🔹 Encabezado
        $estado = $factura->tipoventa == 'Contado' ? 'VENTA DE CONTADO ANULADA' : 'VENTA DE CREDITO ANULADA';
        $this->msg .= "🔹*$estado*\n\n";
        $this->msg .= "Sucursal: " . (($sucursal ?? null)->nombre ?? '') . "\n";
        $this->msg .= "Caja: {$caja->nombre}\n";
        $this->msg .= "Usuario: $usuario->nombre.' '.$usuario->apellido\n";
        $this->msg .= "Fecha: ". ($factura->fechaEliminacion??$fechaAnulacion) ."\n\n";
        // 🔹 Cuadre de caja
        $this->msg .= "*ORDEN ANULADA*\n";
        $this->msg .= "ID de la orden: " . $factura->id . "\n";
        $this->msg .= "Numero de orden: " . $factura->num_orden . "\n";
        $this->msg .= "📌Numero de factura: " . $factura->prefijo.$factura->num_consecutivo . "\n";
        $this->msg .= "💰*Valor: $" . number_format($factura->total??0, 0, ',', '.') . "*\n\n";
        $this->msg .= "DEVOLUCION A INVENTARIO: " . ($devolverInv==true?'Si':'No') . "\n\n";

        foreach ($productos as $value) {
            $this->msg .= "id: {$value->id}, {$value->nombre}, Cant: " . number_format($value->cantidad??0, 0, ',', '.') . "\n";
        }

        $this->msg .= "\n*OBOSERVACION:*\n";
        $this->msg .= "{$factura->observacioneliminacion}\n";

        // 🔹 Pie de pagina
        $this->msg .= "\n*J2 SOFTWARE POS*\n";
        $this->msg .= "www.j2softwarepos.com\n";
        $this->sendMessage('', $this->msg);
    }


    public function productoBajoStock(object $factura, int $idcaja, $devolverInv, array $productos = []){
        $sucursal = sucursales::find('id', id_sucursal());
        $caja = caja::find('id', $idcaja);
        $usuario = usuarios::find('id', $_SESSION['id']);
        $fechaAnulacion = date('Y-m-d H:i:s');
        $this->msg = '';
        $this->msg .= "🔹*PRODUCTOS CON BAJO STOCK*\n";
        $this->msg .= "Sucursal: " . (($sucursal ?? null)->nombre ?? '') . "\n\n";
        $this->msg .= "*PRODUCTOS*\n";
        $this->msg .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        foreach ($productos as $value) {
            $this->msg .= "id: {$value->id}, {$value->nombre}, Cant: " . number_format($value->cantidad??0, 0, ',', '.') . "\n";
        }
        
        // 🔹 Pie de pagina
        $this->msg .= "\n*J2 SOFTWARE POS*\n";
        $this->msg .= "www.j2softwarepos.com\n";
        $this->sendMessage('', $this->msg);
    }

    public function sendMsgTrasladoInvDespachado(object $trasladoinv, array $listaproductos){
        
        $usuario = usuarios::find('id', $trasladoinv->fkusuario);
        $sucursales = sucursales::IN_Where('id', [$trasladoinv->id_sucursalorigen, $trasladoinv->id_sucursaldestino], ['estado', 1]);
        $indexado = [];
        foreach($sucursales as $value)$indexado[$value->id] = $value;
        $sucursalorigen = $indexado[$trasladoinv->id_sucursalorigen];
        $sucursaldestino = $indexado[$trasladoinv->id_sucursaldestino];

        $this->msg = '';
        // 🔹 Encabezado
   
        $this->msg .= "🔹*TRASLADO DE INVENTARIO*\n\n";
        $this->msg .= "Sucursal origen: " . ($sucursalorigen->nombre??'') . "\n";
        $this->msg .= "Sucursal destino: " . ($sucursaldestino->nombre??'') . "\n";
        $this->msg .= "Usuario: $usuario->nombre $usuario->apellido\n";
        $this->msg .= "Fecha: ".$trasladoinv->created_at."\n\n";
        // 🔹 Informacion del despacho de mercancia
        $this->msg .= "*Informacion del despacho*\n";
        $this->msg .= "ID orden de traslado: " . $trasladoinv->id . "\n";
        $this->msg .= "📌Numero de orden: " . $trasladoinv->id . "\n";
        //$this->msg .= "💰*Valor: $" . number_format($trasladoinv->total??0, 0, ',', '.') . "*\n\n";
        $this->msg .= "\nPRODUCTOS DESPACHADOS: " . "\n\n";


        //CONSULTA DETALLADA DE LOS PRODUCTOS TRASLADADOS
        $sql = "SELECT td.id, td.id_trasladoinv, td.fkproducto, td.idsubproducto_id,
                    COALESCE(pund.nombre, spund.nombre) as unidadmedida,
                    COALESCE(p.nombre, sp.nombre) AS nombre, td.cantidad
                    FROM detalletrasladoinv td
                    LEFT JOIN productos p ON td.fkproducto = p.id
                    LEFT JOIN subproductos sp ON td.idsubproducto_id = sp.id
                    LEFT JOIN unidadesmedida pund ON p.idunidadmedida = pund.id
                    LEFT JOIN unidadesmedida spund ON sp.id_unidadmedida = spund.id
                    WHERE td.id_trasladoinv = $trasladoinv->id;";
            $detalletrasladoinv = detalletrasladoinv::camposJoinObj($sql);

        foreach ($detalletrasladoinv as $value) {
            $id = $value->fkproducto == NULL ? $value->idsubproducto_id : $value->fkproducto;
            $this->msg .= "id: {$id}, {$value->nombre}, Cant: " . number_format($value->cantidad??0, 0, ',', '.') ." ". $value->unidadmedida . "\n";
        }

        $this->msg .= "\n*OBOSERVACION*\n";
        $this->msg .= "{$trasladoinv->observacion}\n";

        // 🔹 Pie de pagina
        $this->msg .= "\n*J2 SOFTWARE POS*\n";
        $this->msg .= "www.j2softwarepos.com\n";
        $this->sendMessage('', $this->msg);
    }
}