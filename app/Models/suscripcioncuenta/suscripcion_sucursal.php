<?php

namespace App\Models\suscripcioncuenta;

class suscripcion_sucursal {
    
    public function __construct($args = [])
    {
        $this->id = $args['id']??null;
        $this->sucursalfkid = $args['sucursalfkid']??id_sucursal();
        $this->id_plan = $args['id_plan']??'';
        $this->valor = $args['valor']??0;
        $this->fecha_corte = $args['fecha_corte']??date('Y-m-d');
        $this->estado = $args['estado']??1;  //1 activo, 0 inactivo.
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        $alertas = [];
        if(!$this->id_plan)$alertas['error'][] = "El plan es invalido, verificar nuevamente.";
        if(!$this->valor || $this->valor<0)$alertas['error'][] = "Valor de la suscripcion no es valido, verificar nuevamente.";
    }

    public function toArray():array {
        return [
            //'id' => $this->id, 
            'sucursalfkid' => $this->sucursalfkid,
            'id_plan' => $this->id_plan,
            'valor' => $this->valor,
            'fecha_corte' => $this->fecha_corte,
            'estado' => $this->estado,
            //'created_at' => $this->created_at
        ];
    }

}