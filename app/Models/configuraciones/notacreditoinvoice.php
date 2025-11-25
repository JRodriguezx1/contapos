<?php
namespace App\Models\configuraciones;

class notacreditoinvoice extends \App\Models\ActiveRecord {
    protected static $tabla = 'notacreditoinvoice';
    protected static $columnasDB = ['id', 'id_sucursalid', 'idcompania', 'type_document_id', 'prefix', 'resolution', 'nextnumber', 'resolution_date', 'technical_key', 'from', 'to', 'date_from', 'date_to', 'estado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_sucursalid = id_sucursal();
        $this->idcompania = $args['idcompania'] ?? null;
        $this->type_document_id = $args['type_document_id'] ?? 4;
        $this->prefix = $args['prefix'] ?? ''; 
        $this->resolution = $args['resolution'] ?? '';
        $this->nextnumber = $args['nextnumber'] ?? '';
        $this->resolution_date = $args['resolution_date'] ?? '';  //fecha de expedicion de resolucion
        $this->technical_key = $args['technical_key'] ?? '';
        $this->from = $args['from'] ?? 1;  //rango inicial del consecutivo
        $this->to = $args['to'] ?? 25000;    //rango final del consecutivo
        $this->date_from = $args['date_from'] ?? '';  //fecha incial de la resolucion
        $this->date_to = $args['date_to'] ?? '';      //fecha de vencimiento de la resolucion
        $this->estado = $args['estado'] ?? 1;
        $this->created_at = $args['created_at']??'';
    }
}