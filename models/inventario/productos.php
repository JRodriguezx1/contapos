<?php

namespace Model\inventario;

class productos extends \Model\ActiveRecord {
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'idcategoria', 'idunidadmedida', 'nombre', 'foto', 'impuesto', 'marca', 'tipoproducto', 'tipoproduccion', 'sku', 'unidadmedida', 'preciopersonalizado', 'descripcion', 'peso', 'medidas', 'color', 'funcion', 'uso', 'fabricante', 'garantia', 'stock', 'stockminimo', 'categoria', 'rendimientoestandar', 'precio_compra', 'precio_venta', 'fecha_ingreso', 'estado', 'visible'];
    
    //public $id;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idcategoria = $args['idcategoria'] ?? '';
        $this->idunidadmedida = $args['idunidadmedida']??1; //por defecto unidad
        $this->nombre = $args['nombre'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->impuesto = $args['impuesto'] ?? 0;
        $this->marca = $args['marca'] ?? '';
        $this->tipoproducto = $args['tipoproducto']??0;  // 0 = simple,  1 = compuesto
        $this->tipoproduccion = $args['tipoproduccion']??0; // 0 = inmediato,  1 = construccion solo aplica para productos compuesto
        $this->sku = $args['sku'] ?? '';
        $this->unidadmedida = $args['unidadmedida']??'Unidades';
        $this->preciopersonalizado = $args['preciopersonalizado']??0;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->peso = $args['peso'] ?? '';
        $this->medidas = $args['medidas'] ?? '';
        $this->color = $args['color '] ?? '';
        $this->funcion = $args['funcion'] ?? '';
        $this->uso = $args['uso'] ?? '';
        $this->fabricante = $args['fabricante'] ?? '';
        $this->garantia = $args['garantia'] ?? '';
        $this->stock = !empty($args['stock']) ? $args['stock']: 0;
        $this->stockminimo = !empty($args['stockminimo']) ? $args['stockminimo'] : 1;
        $this->categoria = $args['categoria'] ?? '';
        $this->rendimientoestandar = $args['rendimientoestandar'] ?? 1;
        $this->precio_compra = !empty($args['precio_compra']) ? $args['precio_compra']:  0;
        $this->precio_venta = $args['precio_venta'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? date('Y-m-d H:i:s');
        $this->estado = $args['estado']??1;  // 0 = inactivo,  1 = activo
        $this->visible = $args['visible']??1;  // 0 = no visible,  1 = visible
    }

    // Validación para productos nuevos
    public function validar_nuevo_producto():array {
        if(!$this->idcategoria || !is_numeric($this->idcategoria))self::$alertas['error'][] = 'La categoria del producto no seleccionada';
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


    public function equivalencias($idproducto, $idunidadbase):array {
      $arrayunidadesmedida = ['1'=>'unidad', '2'=>'gramos', '3'=>'libras', '4'=>'kilogramos', '5'=>'milimetros', '6'=>'centimetros', '7'=>'metros', '8'=>'mililitros', '9'=>'litros'];
      $equivalencias = [];
      // Factores de conversión
      $factores = [
          '1' => [ //1=unidad
              '1' => 1
          ],
          '2' => [ //2=gramos
              '2' => 1,
              '3' => 453.592,   //453.592 gramos equivale a 1 libra
              '4' => 1000  //1000 gramos equivale a 1 kilogramo
          ],
          '3' => [  //3=libras
              '3' => 1,
              '2' => 0.002,
              '4' => 2.204
          ],
          '4' => [ //4=kilogramos
              '4' => 1,
              '2' => 0.001,
              '3' => 0.453
          ],
          '5' => [ //5=milimetros
              '5' => 1,
              '6' => 10,      //10 milimetros = 1 centimetro 
              '7' => 1000    //1000 milimetros = 1 metro
          ],
          '6' => [  //6=centimetros
              '6' => 1,
              '5' => 0.1,    // 0.1 centimetro = 1 milimetro
              '7' => 100     // 100cm = 1mt
          ],
          '7' => [ //7=metros
              '7' => 1,
              '5' => 0.001,  //0.001 mt  =  1 mm
              '6' => 0.01    //0.01 mt  =  1 cm
          ],
          '8' => [ //8=mililitros
              '8' => 1,   
              '9' => 1000   //1000 ml = 1lt
          ],
          '9' => [  //9=litros
              '9' => 1,
              '8' => 0.001   //0.001lt = 1ml 
          ]
      ];

      // Verificar si la unidad base está en los factores de conversión
      if (array_key_exists($idunidadbase, $factores)) {
        // Generar conversiones para cada unidad destino
        foreach ($factores[$idunidadbase] as $unidaddestino => $factorconversion) {
          $equivalencias[] = (object) [
              'idproducto' => $idproducto,
              'idsubproducto' => 'NULL',
              'idunidadmedidabase' => $idunidadbase,
              'idunidadmedidadestino' => $unidaddestino,
              'nombreunidadbase' => $arrayunidadesmedida[$idunidadbase],
              'nombreunidaddestino' => $arrayunidadesmedida[$unidaddestino],
              'factorconversion' => $factorconversion
          ];
        }
      }
      return $equivalencias;
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