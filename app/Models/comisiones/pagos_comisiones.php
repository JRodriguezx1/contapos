<?php

namespace App\Models\comisiones;

class pagos_comisiones {
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->fkusuarioid = $args['fkusuarioid']??'';
        $this->idmediopagoid = $args['idmediopagoid']??'';
        $this->valor = $args['valor']??0;
        $this->mediopago = $args['mediopago']??'';
        $this->fecha = $args['fecha']??date('Y-m-d H:i:s');
        $this->tipo = $args['tipo']??'pago';  //anticipo, pago
        $this->referencia = $args['referencia']??'';
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        $alertas = [];
        if(!$this->fkusuarioid)$alertas['error'][] = "Debe seleccionar el empleado";
         if(!$this->idmediopagoid)$alertas['error'][] = "Debe seleccionar el medio de pago";
        if($this->valor<0)$alertas['error'][] = "el valor de la comision a pagar no es valido.";
        return $alertas;
    }

    public function toArray():array {
        return [
            //'id' => $this->id, 
            'fkusuarioid' => $this->fkusuarioid,
            'idmediopagoid' => $this->idmediopagoid,
            'valor' => $this->valor,
            'mediopago' => $this->mediopago,
            'fecha' => $this->fecha, 
            'tipo' => $this->tipo,
            'referencia' => $this->referencia,
        ];
    }

    

}