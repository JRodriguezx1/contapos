<?php

namespace App\Models\creditos;

class creditos extends \App\Models\ActiveRecord{
    protected static $tabla = 'creditos';
    protected static $columnasDB = ['id', 'id_fksucursal', 'idtipofinanciacion', 'factura_id', 'cliente_id', 'nombrecliente', 'capital', 'abonoinicial', 'saldopendiente', 'numcuota', 'cantidadcuotas', 'montocuota', 'frecuenciapago', 'fechainicio', 'interes', 'interesxcuota', 'interestotal', 'valorinteresxcuota', 'valorinterestotal', 'montototal', 'fechavencimiento', 'productoentregado', 'estado'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->id_fksucursal = $args['id_fksucursal']??id_sucursal();
        $this->idtipofinanciacion = $args['idtipofinanciacion']??'';
        $this->factura_id = $args['factura_id']??'';
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
        if(!$this->cliente_id)self::$alertas['error'][] = "Debe seleccionar un cliente";
        if($this->capital<=0)self::$alertas['error'][] = "el valor del credito total no es valido.";
        if($this->cantidadcuotas<=0)self::$alertas['error'][] = "Numero de cuotas no es valido, verifica nuevamente.";
        if($this->montocuota<=0)self::$alertas['error'][] = "Valor de la cuota no es valido.";
        if($this->montototal<0)self::$alertas['error'][] = "El capital + interes no es valido";
        if(!$this->frecuenciapago)self::$alertas['error'][] = "Seleccionar dia de pago de la cuota";
        return self::$alertas;
    }

}