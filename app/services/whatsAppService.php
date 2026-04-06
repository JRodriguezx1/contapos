<?php 

namespace App\services;

use App\Models\configuraciones\caja;
use App\Models\configuraciones\usuarios;
use App\Models\sucursales;
use GreenApi\RestApi\GreenApiClient;

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

    public function sendMessage(string $number, string $text){
        $result = $this->client->sending->sendMessage('573003520420@c.us', $text);
        debuguear($result);
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
        $this->msg .= "DEVOLUCION A INVENTARIO: " . $devolverInv==true?'Si':'No' . "\n\n";

        foreach ($productos as $value) {
            $this->msg .= "id: {$value->id}, {$value->nombre}: Cant: " . number_format($value->cantidad??0, 0, ',', '.') . "\n";
        }

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
        
        // 🔹 Pie de pagina
        $this->msg .= "\n*J2 SOFTWARE POS*\n";
        $this->msg .= "www.j2softwarepos.com\n";
        $this->sendMessage('', $this->msg);
    }
}