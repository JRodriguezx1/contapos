<?php

namespace App\Models\creditos;

class cuotas {
    
    public function __construct($args = [])
    {
        $this->id = $args['id']??null;
        $this->id_sucursal_idfk = $args['id_sucursal_idfk']??id_sucursal();
        $this->id_credito = $args['id_credito']??'';
        $this->cajaid = $args['cajaid']??'';
        $this->mediopagoid = $args['mediopagoid']??1;
        $this->numerocuota = $args['numerocuota']??0;
        $this->montocuota = $args['montocuota']??0;
        $this->valorpagado = $args['valorpagado']??0;
        $this->fechavencimiento = $args['fechavencimiento']??date('Y-m-d');
        $this->fechapagado = $args['fechapagado']?? date('Y-m-d H:i:s');
        $this->estado = $args['estado']??0;
        $this->cuotascreditos = $args['cuotascreditos']??NULL;
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        $alertas = [];
        if(!$this->numerocuota || $this->numerocuota<=0)$alertas['error'][] = "Numero de cuotas es incorrecto, validar nuevamente";
        if($this->montocuota<=0)$alertas['error'][] = "Monto de la cuota no es valido, verificar nuevamente.";
        if(!$this->valorpagado || $this->valorpagado<=0)$alertas['error'][] = "Valor de la cuota no es valido, verificar nuevamente.";
        return $alertas;
    }

    public function toArray():array {
        return [
            //'id' => $this->id, 
            'id_sucursal_idfk' => $this->id_sucursal_idfk, 
            'id_credito' => $this->id_credito, 
            'cajaid' => $this->cajaid, 
            'mediopagoid' => $this->mediopagoid, 
            'numerocuota' => $this->numerocuota, 
            'montocuota' => $this->montocuota, 
            'valorpagado' => $this->valorpagado, 
            'fechavencimiento' => $this->fechavencimiento, 
            'fechapagado' => $this->fechapagado, 
            'estado' => $this->estado, 
            'cuotascreditos' => $this->cuotascreditos, 
            //'created_at' => $this->created_at
        ];
    }


    public function prepararSegunCredito($credito) {
        $this->numerocuota = $credito->numcuota + 1;
        $this->montocuota = $credito->montocuota;
    }

}