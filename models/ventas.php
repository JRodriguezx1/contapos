<?php
namespace Model;

class ventas extends ActiveRecord {
    protected static $tabla = 'ventas';
    protected static $columnasDB = ['id', 'idfactura', 'idproducto', 'tipoproducto', 'nombreproducto', 'valorunidad', 'cantidad', 'subtotal', 'impuesto', 'descuento', 'total', 'dato1', 'dato2'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idfactura = $args['idfactura'] ?? '';
        $this->idproducto = $args['idproducto'] ?? '';
        $this->tipoproducto = $args['tipoproducto'] ?? '';
        $this->nombreproducto = $args['nombreproducto'] ?? '';
        $this->valorunidad = $args['valorunidad'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->subtotal = $args['subtotal'] ?? 0;
        $this->impuesto = $args['impuesto'] ?? '0';
        $this->descuento = $args['descuento'] ?? '';
        $this->total = $args['total'] ?? '';
        $this->dato1 = $args['dato1 '] ?? '';
        $this->dato2 = $args['dato2'] ?? '';
    }

    // Validación para venta nueva
    public function validar_nueva_venta():array {
        if(!$this->idfactura)self::$alertas['error'][] = 'La factura es obligatoria';
        
        if(!$this->idproducto)self::$alertas['error'][] = 'El producto es obligatorio';
        
        if(!$this->cantidad)self::$alertas['error'][] = 'La cantidad es obligatoria';

        if(strlen($this->cantidad)>9999)self::$alertas['error'][] = 'Maxima cantidad 9999';

        return self::$alertas;
    }
}