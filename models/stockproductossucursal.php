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

    public static function indicadoresAllProductsXSucursal(int $idsucursal = 1):array|NULL{
      $query="SELECT p.nombre, p.impuesto, p.tipoproducto, p.tipoproduccion, p.categoria, sps.productoid, sps.stock, sps.stockminimo, p.precio_compra, p.precio_venta, p.idunidadmedida, p.unidadmedida, p.fecha_ingreso, p.visible, 
      SUM(sps.stock*p.precio_compra) OVER () AS valorinv, 
      COUNT(p.id) OVER () AS cantidadreferencias, 
      SUM(sps.stock) OVER () AS cantidadproductos,
      SUM(CASE WHEN sps.stock < 10 THEN 1 ELSE 0 END) OVER () AS bajostock,
      SUM(CASE WHEN sps.stock = 0 THEN 1 ELSE 0 END) OVER () AS productosagotados
      FROM ".self::$tabla." sps JOIN productos p ON sps.productoid = p.id WHERE sps.sucursalid = $idsucursal;";
      $array = self::camposJoinObj($query);
      return $array;
    }

    public static function getStockproductosXsucursal():array|NULL{
      $sql = "SELECT p.id AS productoid, p.nombre AS nombreproducto, s.id AS sucursalid, s.nombre AS sucursal, sps.stock
              FROM stockproductossucursal sps
              INNER JOIN productos p ON sps.productoid = p.id
              INNER JOIN sucursales s ON sps.sucursalid = s.id
              ORDER BY p.id, s.id;";
      $array = self::camposJoinObj($sql);
      return $array;
    }
}