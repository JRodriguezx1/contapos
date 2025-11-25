<?php
namespace App\Models\configuraciones;

class consecutivosnc extends \App\Models\ActiveRecord {
    protected static $tabla = 'consecutivosnc';
    protected static $columnasDB = ['id', 'id_sucursalid', 'idcompania', 'type_document_id', 'prefix', 'resolution', 'resolution_date', 'technical_key', 'from', 'to', 'date_from', 'date_to', 'estado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_sucursalid = id_sucursal();
        $this->idcompania = $args['idcompania'] ?? null;
        $this->type_document_id = $args['type_document_id'] ?? 4;
        $this->prefix = $args['prefix'] ?? 1; 
        $this->resolution = $args['resolution'] ?? 1;
        $this->resolution_date = $args['resolution_date'] ?? '';  //fecha de expedicion de resolucion
        $this->technical_key = $args['technical_key'] ?? 1;
        $this->from = $args['from'] ?? 1;  //rango inicial del consecutivo
        $this->to = $args['to'] ?? '';    //rango final del consecutivo
        $this->date_from = $args['date_from'] ?? '';  //fecha incial de la resolucion
        $this->date_to = $args['date_to'] ?? '';      //fecha de vencimiento de la resolucion
        $this->estado = $args['estado'] ?? 1;
        $this->created_at = $args['created_at']??'';
    }
}