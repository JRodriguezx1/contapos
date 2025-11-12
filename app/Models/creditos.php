<?php

namespace Model;

class creditos extends ActiveRecord{
    protected static $tabla = 'creditos';
    protected static $columnasDB = ['id', 'id_fksucursal', 'factura_id', 'cliente_id', 'nombrecliente', 'montototal', 'saldopendiente', 'cantidadcuotas', 'montocuota', 'frecuenciapago', 'fechainicio', 'tasainteres', 'estado'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->id_fksucursal = $args['id_fksucursal']??'';
        $this->factura_id = $args['factura_id']??'';
        $this->cliente_id = $args['cliente_id']??'';
        $this->nombrecliente = $args['nombrecliente']??'';
        $this->montototal = $args['montototal']??0;
        $this->saldopendiente = $args['saldopendiente']??0;
        $this->cantidadcuotas = $args['cantidadcuotas']??0;
        $this->montocuota = $args['montocuota']??0;
        $this->frecuenciapago = $args['frecuenciapago']??'';
        $this->fechainicio = $args['fechainicio']??'';
        $this->tasainteres = $args['tasainteres']??0;
        $this->estado = $args['estado']??0;
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!$this->nombrecliente)self::$alertas['error'][] = "Nombre del proveedor no especificado.";
        if($this->montototal<=0)self::$alertas['error'][] = "el valor del credito total no es valido.";
        if($this->cantidadcuotas<=0)self::$alertas['error'][] = "Numero de cuotas no es valido, verifica nuevamente.";
        if($this->montocuota<=0)self::$alertas['error'][] = "Valor de la cuota no es valido.";
        if($this->tasainteres<0)self::$alertas['error'][] = "Tasa de interes no puede ser un valor negativo";
        return self::$alertas;
    }

}