<?php

namespace App\Models\creditos;

class creditos {
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->id_fksucursal = $args['id_fksucursal']??id_sucursal();
        $this->idtipofinanciacion = $args['idtipofinanciacion']??'';
        $this->factura_id = $args['factura_id']??NULL;
        $this->cliente_id = $args['cliente_id']??'';
        $this->nombrecliente = $args['nombrecliente']??'cliente';
        $this->capital = $args['capital']??0;
        $this->abonoinicial = $args['abonoinicial']??0;
        $this->saldopendiente = $args['saldopendiente']??0;
        $this->numcuota = $args['numcuota']??0;
        $this->cantidadcuotas = $args['cantidadcuotas']??0;
        $this->montocuota = $args['montocuota']??0;
        $this->frecuenciapago = $args['frecuenciapago']??'';
        $this->fechainicio = $args['fechainicio']??date('Y-m-d');
        $this->interes = $args['interes']??'';
        $this->interesxcuota = $args['interesxcuota']??0;
        $this->interestotal = $args['interestotal']??0;
        $this->valorinteresxcuota = $args['valorinteresxcuota']??0;
        $this->valorinterestotal = $args['valorinterestotal']??0;
        $this->montototal = $args['montototal']??0;
        $this->fechavencimiento = $args['fechavencimiento']??'';
        $this->productoentregado = $args['productoentregado']??0;
        $this->estado = $args['estado']??0; //1 = credito finalizado
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        $alertas = [];
        if(!$this->cliente_id)$alertas['error'][] = "Debe seleccionar un cliente";
        if($this->capital<=0)$alertas['error'][] = "el valor del credito total no es valido.";
        if($this->cantidadcuotas<=0)$alertas['error'][] = "Numero de cuotas no es valido, verifica nuevamente.";
        if($this->montocuota<=0)$alertas['error'][] = "Valor de la cuota no es valido.";
        if($this->montototal<0)$alertas['error'][] = "El capital + interes no es valido";
        if(!$this->frecuenciapago)$alertas['error'][] = "Seleccionar dia de pago de la cuota";
        return $alertas;
    }

    public function toArray():array {
        return [
            //'id' => $this->id, 
            'id_fksucursal' => $this->id_fksucursal, 
            'idtipofinanciacion' => $this->idtipofinanciacion, 
            'factura_id' => $this->factura_id, 
            'cliente_id' => $this->cliente_id, 
            'nombrecliente' => $this->nombrecliente, 
            'capital' => $this->capital, 
            'abonoinicial' => $this->abonoinicial, 
            'saldopendiente' => $this->saldopendiente, 
            'numcuota' => $this->numcuota, 
            'cantidadcuotas' => $this->cantidadcuotas, 
            'montocuota' => $this->montocuota,
            'frecuenciapago' => $this->frecuenciapago, 
            'fechainicio' => $this->fechainicio, 
            'interes' => $this->interes, 
            'interesxcuota' => $this->interesxcuota, 
            'interestotal' => $this->interestotal, 
            'valorinteresxcuota' => $this->valorinteresxcuota,
            'valorinterestotal' => $this->valorinterestotal, 
            'montototal' => $this->montototal, 
            'fechavencimiento' => $this->fechavencimiento, 
            'productoentregado' => $this->productoentregado, 
            'estado' => $this->estado, 
            //'created_at' => $this->created_at
        ];
    }

    public function actualizarCredito($valorpagadoCuota) {
        $this->numcuota += 1;
        $this->saldopendiente -= $valorpagadoCuota;
        if($this->saldopendiente<=0){
            $this->estado = 1;  //credito cerrado
            $this->productoentregado = 1;  //producto entregado
        }
    }

}