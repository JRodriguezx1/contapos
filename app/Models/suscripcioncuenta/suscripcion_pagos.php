<?php

namespace App\Models\suscripcioncuenta;

class suscripcion_pagos {
    
    public function __construct($args = [])
    {
        $this->id = $args['id']??null;
        $this->idsucursalid_fk = $args['idsucursalid_fk']??id_sucursal();
        $this->idplan = $args['idplan']??'';
        $this->fk_transaccion = $args['fk_transaccion']??'';
        $this->nombrecuenta = $args['nombrecuenta']??'';
        $this->valor_pagado = $args['valor_pagado']??0;
        $this->fecha_corte = $args['fecha_corte']??date('Y-m-d');
        $this->fecha_pago = $args['fecha_pago']??date('Y-m-d');
        $this->cantidad_plan = $args['cantidad_plan']??1;
        $this->medio_pago = $args['medio_pago']??'';
        $this->descuento = $args['descuento']??0;
        $this->detalle_descuento = $args['detalle_descuento']?? '';
        $this->cargo = $args['cargo']??0;
        $this->detalle_cargo = $args['detalle_cargo']??'';
        $this->descripcion = $args['descripcion']??'';
        $this->estado = $args['estado']??1;  //1 activo, 0 inactivo.
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        $alertas = [];
        if(!$this->valor_pagado || $this->medio_pago<0)$alertas['error'][] = "Valor pagado no es valido, verificar nuevamente.";
        if($this->cantidad_plan<=0)$alertas['error'][] = "Cantidad del plan no es valido, verificar nuevamente.";
        if(!$this->medio_pago || strlen($this->medio_pago)<2)$alertas['error'][] = "Medio de pago no es valido, verificar nuevamente.";
        return $alertas;
    }

    public function toArray():array {
        return [
            //'id' => $this->id, 
            'idsucursalid_fk' => $this->idsucursalid_fk,
            'idplan' => $this->idplan,
            'fk_transaccion' => $this->fk_transaccion,
            'nombrecuenta' => $this->nombrecuenta,
            'valor_pagado' => $this->valor_pagado,
            'fecha_corte' => $this->fecha_corte,
            'fecha_pago' => $this->fecha_pago,
            'cantidad_plan' => $this->cantidad_plan, 
            'medio_pago' => $this->medio_pago, 
            'descuento' => $this->descuento, 
            'detalle_descuento' => $this->detalle_descuento, 
            'cargo' => $this->cargo,
            'detalle_cargo' => $this->detalle_cargo,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            //'created_at' => $this->created_at
        ];
    }

}