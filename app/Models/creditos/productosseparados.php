<?php
namespace App\Models\creditos;

class productosseparados extends \App\Models\ActiveRecord {
    protected static $tabla = 'productosseparados';
    protected static $columnasDB = ['id', 'idcredito', 'fk_producto', 'tipoproducto', 'tipoproduccion', 'rendimientoestandar', 'nombreproducto', 'foto', 'costo', 'valorunidad', 'cantidad', 'subtotal', 'base', 'impuesto', 'valorimp', 'descuento', 'total'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idcredito = $args['idcredito'] ?? '';
        $this->fk_producto = $args['fk_producto'] ?? '';
        $this->tipoproducto = $args['tipoproducto'] ?? '';
        $this->tipoproduccion = $args['tipoproduccion']??0; // 0 = inmediato,  1 = construccion solo aplica para productos compuesto
        $this->rendimientoestandar = $args['rendimientoestandar']??1;
        $this->nombreproducto = $args['nombreproducto'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->costo = $args['costo'] ?? 0;
        $this->valorunidad = $args['valorunidad'] ?? 0;
        $this->cantidad = $args['cantidad'] ?? '';
        $this->subtotal = $args['subtotal'] ?? 0;
        $this->base = $args['base'] ?? 0;
        $this->impuesto = $args['impuesto'] ?? '0';
        $this->valorimp = $args['valorimp'] ?? '0';
        $this->descuento = $args['descuento'] ?? '';
        $this->total = $args['total'] ?? '';
        $this->created_at = $args['created_at']??'';
    }

    // Validación para venta nueva
    public function validar_nueva_venta():array {
        if(!$this->idcredito)self::$alertas['error'][] = 'La factura es obligatoria';
        
        if(!$this->fk_producto)self::$alertas['error'][] = 'El producto es obligatorio';
        
        if(!$this->cantidad)self::$alertas['error'][] = 'La cantidad es obligatoria';

        if(strlen($this->cantidad)>9999)self::$alertas['error'][] = 'Maxima cantidad 9999';

        return self::$alertas;
    }
}