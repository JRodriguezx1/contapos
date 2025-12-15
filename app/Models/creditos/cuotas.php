<?php

namespace App\Models\creditos;

class cuotas extends \App\Models\ActiveRecord{
    protected static $tabla = 'cuotas';
    protected static $columnasDB = ['id', 'id_credito', 'mediopagoid', 'numerocuota', 'montocuota', 'valorpagado', 'fechavencimiento', 'fechapagado', 'cuotascreditos', 'estado'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->id_credito = $args['id_credito']??'';
        $this->mediopagoid = $args['mediopagoid']??'';
        $this->numerocuota = $args['numerocuota']??1;
        $this->montocuota = $args['montocuota']??0;
        $this->valorpagado = $args['valorpagado']??0;
        $this->fechavencimiento = $args['fechavencimiento']??date('Y-m-d');
        $this->fechapagado = $args['fechapagado']?? date('Y-m-d');
        $this->estado = $args['estado']??0;
        $this->cuotascreditos = $args['cuotascreditos']??'';
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!$this->numerocuota || $this->numerocuota<=0)self::$alertas['error'][] = "Numero de cuotas es incorrecto, validar nuevamente";
        if($this->montocuota<=0)self::$alertas['error'][] = "Monto de la cuota no es valido, verificar nuevamente.";
        if(!$this->valorpagado || $this->valorpagado<=0)self::$alertas['error'][] = "Valor de la cuota no es valido, verificar nuevamente.";
        return self::$alertas;
    }

}