<?php

namespace Model\felectronicas;

class facturas_electronicas extends \Model\ActiveRecord{
    protected static $tabla = 'facturas_electronicas';
    protected static $columnasDB = ['id', 'id_estadoelectronica', 'consecutivo_id', 'id_facturaid', 'id_adquiriente', 'id_estadonota', 'numero', 'num_factura', 'prefijo', 'resolucion', 'token_electronica', 'cufe', 'qr', 'fecha_factura', 'identificacion', 'nombre', 'email', 'link', 'nota_credito', 'num_nota', 'cufe_nota', 'fecha_nota', 'is_auto', 'json_envio', 'respuesta_factura', 'respuesta_nota', 'intentos_de_envio', 'fecha_ultimo_intento'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->id_estadoelectronica = $args['id_estadoelectronica']??'';
        $this->consecutivo_id = $args['consecutivo_id']??'';
        $this->id_facturaid = $args['id_facturaid']??'';
        $this->id_adquiriente = $args['id_adquiriente']??'';
        $this->id_estadonota = $args['id_estadonota']??'';
        $this->numero = $args['numero']??'';
        $this->num_factura = $args['num_factura']??'';
        $this->prefijo = $args['prefijo']??'';
        $this->resolucion = $args['resolucion']??'';
        $this->token_electronica = $args['token_electronica']??'';
        $this->cufe = $args['cufe']??'';
        $this->qr = $args['qr']??'';
        $this->fecha_factura = $args['fecha_factura']??'';
        $this->identificacion = $args['identificacion']??'';
        $this->nombre = $args['nombre']??'';
        $this->email = $args['email']??'';
        $this->link = $args['link']??'';
        $this->nota_credito = $args['nota_credito']??'';
        $this->num_nota = $args['num_nota']??'';
        $this->cufe_nota = $args['cufe_nota']??'';
        $this->fecha_nota = $args['fecha_nota']??'';
        $this->is_auto = $args['is_auto']??'';
        $this->json_envio = $args['json_envio']??'';
        $this->respuesta_factura = $args['respuesta_factura']??'';
        $this->respuesta_nota = $args['respuesta_nota']??'';
        $this->intentos_de_envio = $args['intentos_de_envio']??'';
        $this->fecha_ultimo_intento = $args['fecha_ultimo_intento']??'';
        $this->created_at = $args['created_at']??'';
    }


}