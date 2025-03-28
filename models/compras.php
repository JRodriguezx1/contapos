<?php

namespace Model;

class compras extends ActiveRecord{
    protected static $tabla = 'compras';
    protected static $columnasDB = ['id', 'idusuario', 'idproveedor', 'idorigenpago', 'idformapago', 'nombreusuario', 'nombreproveedor', 'nombreorigenpago', 'formapago', 'nfactura', 'impuesto', 'cantidaditems', 'observacion', 'subtotal', 'valortotal', 'estado', 'fechacompra'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->idusuario = $args['idusuario']??'';
        $this->idproveedor = $args['idproveedor']??1;
        $this->idorigenpago = $args['idorigenpago']??1;
        $this->idformapago = $args['idformapago']??1;
        $this->nombreusuario = $args['nombreusuario']??'';
        $this->nombreproveedor = $args['nombreproveedor']??'';
        $this->nombreorigenpago = $args['nombreorigenpago']??'';
        $this->formapago = $args['formapago']??'';
        $this->nfactura = $args['nfactura']??'';
        $this->impuesto = $args['impuesto']??0;
        $this->cantidaditems = $args['cantidaditems']??'';
        $this->observacion = $args['observacion']??'';
        $this->subtotal = $args['subtotal']??0;
        $this->valortotal = $args['valortotal']??0;
        $this->estado = $args['estado']??'';
        $this->fechacompra = $args['fechacompra']??date('Y-m-d H:i:s');
    }


    public function validar():array
    {
        if(!is_numeric($this->impuesto))self::$alertas['error'][] = 'Error en valor del impuesto.';
        if(!is_numeric($this->cantidaditems))self::$alertas['error'][] = 'La cantidad debe ser tipo numero.';
        if(is_numeric($this->cantidaditems)){
            if((int)$this->cantidaditems==0)self::$alertas['error'][] = 'Debe de haber minimo un item para comprar.';
        }
        if(!is_numeric($this->valortotal))self::$alertas['error'][] = 'Error en el valor total de la compra.';
        if(is_numeric($this->valortotal)){
            if((int)$this->valortotal==0)self::$alertas['error'][] = 'Error en el valor total de la compra.';
        }
        return self::$alertas;
    }

}

?>