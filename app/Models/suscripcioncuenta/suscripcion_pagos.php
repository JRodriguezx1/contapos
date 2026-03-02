<?php

namespace App\Models\suscripcioncuenta;

class suscripcion_pagos {
    
    public function __construct($args = [])
    {
        $this->id = $args['id']??null;
        $this->idsucursalid_fk = $args['idsucursalid_fk']??id_sucursal();
        $this->fk_transaccion = $args['fk_transaccion']??'';
        $this->descripcion = $args['descripcion']??'';
        $this->valor = $args['valor']??'';
        $this->cantidad_meses = $args['cantidad_meses']??1;
        $this->medio_pago = $args['medio_pago']??0;
        $this->fecha = $args['fecha']??0;
        $this->precio_suscripcion = $args['precio_suscripcion']??0;
        $this->total_descuentos = $args['total_descuentos']??date('Y-m-d');
        $this->detalle_descuentos = $args['detalle_descuentos']?? date('Y-m-d H:i:s');
        $this->total_cargos = $args['total_cargos']??NULL;
        $this->detalle_cargos = $args['detalle_cargos']??0;
        $this->is_available = $args['is_available']??'1';  //1 = si registra en caja
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        $alertas = [];
        if(!$this->medio_pago || $this->medio_pago<=0)$alertas['error'][] = "Numero de cuotas es incorrecto, validar nuevamente";
        if($this->fecha<=0)$alertas['error'][] = "Monto de la cuota no es valido, verificar nuevamente.";
        if(!$this->precio_suscripcion || $this->precio_suscripcion<=0)$alertas['error'][] = "Valor de la cuota no es valido, verificar nuevamente.";
        return $alertas;
    }

    public function toArray():array {
        return [
            //'id' => $this->id, 
            'idsucursalid_fk' => $this->idsucursalid_fk, 
            'fk_transaccion' => $this->fk_transaccion,
            'descripcion' => $this->descripcion,
            'valor' => $this->valor, 
            'cantidad_meses' => $this->cantidad_meses, 
            'medio_pago' => $this->medio_pago, 
            'fecha' => $this->fecha, 
            'precio_suscripcion' => $this->precio_suscripcion, 
            'total_descuentos' => $this->total_descuentos, 
            'detalle_descuentos' => $this->detalle_descuentos, 
            'total_cargos' => $this->total_cargos,
            'is_available' => $this->is_available,
            'detalle_cargos' => $this->detalle_cargos,
            //'created_at' => $this->created_at
        ];
    }

}