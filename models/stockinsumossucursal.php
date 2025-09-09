<?php

namespace Model;

class stockinsumossucursal extends ActiveRecord{
    protected static $tabla = 'stockinsumossucursal';
    protected static $columnasDB = ['id', 'subproductoid', 'sucursalid', 'stock', 'stockminimo'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->subproductoid = $args['subproductoid']??'';
        $this->sucursalid = $args['sucursalid']??'';
        $this->stock = $args['stock']??0;
        $this->stockminimo = $args['stockminimo']??0;
        $this->created_at = $args['created_at']??'';
    }

    public static function indicadoresAllSubproductsXSucursal(int $idsucursal = 1):array|NULL{
      $query="SELECT sp.nombre, sis.stock, sis.stockminimo, sp.precio_compra, sp.unidadmedida, sp.fecha_ingreso, 
      SUM(sis.stock*sp.precio_compra) OVER () AS valorinv, 
      COUNT(sp.id) OVER () AS cantidadreferencias, 
      SUM(sis.stock) OVER () AS cantidadproductos,
      SUM(CASE WHEN sis.stock < 10 THEN 1 ELSE 0 END) OVER () AS bajostock,
      SUM(CASE WHEN sis.stock = 0 THEN 1 ELSE 0 END) OVER () AS productosagotados
      FROM ".self::$tabla." sis JOIN subproductos sp ON sis.subproductoid = sp.id WHERE sis.sucursalid = $idsucursal;";
      $array = self::camposJoinObj($query);
      return $array;
    }

}