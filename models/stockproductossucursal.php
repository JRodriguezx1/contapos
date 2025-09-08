<?php

namespace Model;

class stockproductossucursal extends ActiveRecord{
    protected static $tabla = 'stockproductossucursal';
    protected static $columnasDB = ['id', 'productoid', 'sucursalid', 'stock', 'stockminimo', 'habilitarventa'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->productoid = $args['productoid']??'';
        $this->sucursalid = $args['sucursalid']??'';
        $this->stock = $args['stock']??0;
        $this->stockminimo = $args['stockminimo']??0;
        $this->habilitarventa = $args['habilitarventa']??1;
        $this->created_at = $args['created_at']??'';
    }

}