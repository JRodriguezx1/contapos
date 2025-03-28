<?php

namespace Model;

class productos extends ActiveRecord {
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'idcategoria', 'idunidadmedida', 'nombre', 'foto', 'impuesto', 'marca', 'tipoproducto', 'sku', 'unidadmedida', 'descripcion', 'peso', 'medidas', 'color', 'funcion', 'uso', 'fabricante', 'garantia', 'stock', 'stockminimo', 'categoria', 'precio_compra', 'precio_venta', 'fecha_ingreso'];
    
    //public $id;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idcategoria = $args['idcategoria'] ?? '';
        $this->idunidadmedida = $args['idunidadmedida']??1;
        $this->nombre = $args['nombre'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->impuesto = $args['impuesto'] ?? 0;
        $this->marca = $args['marca'] ?? '';
        $this->tipoproducto = $args['tipoproducto']??0;  // 0 = simple,  1 = compuesto
        $this->sku = $args['sku'] ?? '';
        $this->unidadmedida = $args['unidadmedida']??'Unidades';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->peso = $args['peso'] ?? '';
        $this->medidas = $args['medidas'] ?? '';
        $this->color = $args['color '] ?? '';
        $this->funcion = $args['funcion'] ?? '';
        $this->uso = $args['uso'] ?? '';
        $this->fabricante = $args['fabricante'] ?? '';
        $this->garantia = $args['garantia'] ?? '';
        $this->stock = $args['stock'] ?? 0;
        $this->stockminimo = $args['stockminimo']??100;
        $this->categoria = $args['categoria'] ?? '';
        $this->precio_compra = $args['precio_compra'] ?? 0;
        $this->precio_venta = $args['precio_venta'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? date('Y-m-d H:i:s');
    }

    // Validación para productos nuevos
    public function validar_nuevo_producto():array {
        if(!$this->nombre)self::$alertas['error'][] = 'El Nombre del producto es Obligatorio';
        
        if(strlen($this->nombre)>51)self::$alertas['error'][] = 'El Nombre del producto no debe superar los 52 caracteres';
        
        if($this->sku)
          if(strlen($this->sku)>15)self::$alertas['error'][] = 'El codigo del producto no debe ser mayor a 15 digitos';
        
        if($this->descripcion)
          if(strlen($this->descripcion)>249)self::$alertas['error'][] = 'La descripcion no debe supear los 249 caracteres';
        
        //if(!$this->stock)self::$alertas['error'][] = 'Colocar el stock inicial del producto';

        //if(!$this->precio_compra)self::$alertas['error'][] = 'Colocar el precio de compra del producto';

        if(!$this->precio_venta)self::$alertas['error'][] = 'Colocar el precio de venta del producto';
        return self::$alertas;
    }

    public function validarimgproducto($FILE) {
      if($FILE['foto']['name'] && $FILE['foto']['size']>530000) {
          self::$alertas['error'][] = 'La foto no puede pasar los 500KB';
      }
      if($FILE['foto']['name'] && $FILE['foto']['type']!="image/jpeg" && $FILE['foto']['type']!="image/png") {
          self::$alertas['error'][] = 'Seleccione una imagen en formato jpeg o png';
      }
      return self::$alertas;
    }


    public static function indicadoresAllProducts():array|NULL{
      $query="SELECT *, SUM(stock*precio_compra) OVER () AS valorinv, 
      COUNT(id) OVER () AS cantidadreferencias, 
      SUM(stock) OVER () AS cantidadproductos,
      SUM(CASE WHEN stock < 10 THEN 1 ELSE 0 END) OVER () AS bajostock,
      SUM(CASE WHEN stock = 0 THEN 1 ELSE 0 END) OVER () AS productosagotados
      FROM ".self::$tabla.";";
      $array = self::camposJoinObj($query);
      return $array;
    }
    
}