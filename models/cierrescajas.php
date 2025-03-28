<?php
namespace Model;

class cierrescajas extends ActiveRecord {
    protected static $tabla = 'cierrescajas';
    protected static $columnasDB = ['id', 'idcaja', 'id_usuario', 'nombrecaja', 'nombreusuario', 'fechainicio', 'fechacierre', 'ncambiosaventa', 'totalcotizaciones', 'totalfacturas', 'facturaselectronicas', 'facturaspos', 'basecaja', 'ventasenefectivo', 'gastoscaja', 'dineroencaja', 'domicilios', 'ndomicilios', 'realencaja', 'ingresoventas', 'totaldescuentos', 'realventas', 'impuesto', 'totalbruto', 'estado', 'dato1', 'dato2'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idcaja = $args['idcaja'] ?? 1;
        $this->id_usuario = $args['id_usuario']??1;
        $this->nombrecaja = $args['nombrecaja']??'';
        $this->nombreusuario = $args['nombreusuario']??'';
        $this->fechainicio = $args['fechainicio'] ?? date('Y-m-d H:i:s');
        $this->fechacierre = $args['fechacierre'] ?? date('Y-m-d H:i:s');
        $this->ncambiosaventa = $args['ncambiosaventa'] ?? 0;
        $this->totalcotizaciones = $args['totalcotizaciones'] ?? 0;
        $this->totalfacturas = $args['totalfacturas'] ?? 0;
        $this->facturaselectronicas = $args['facturaselectronicas'] ?? 0;
        $this->facturaspos = $args['facturaspos'] ?? 0;
        $this->basecaja = $args['basecaja'] ?? 0;
        $this->ventasenefectivo = $args['ventasenefectivo'] ?? 0;
        $this->gastoscaja = $args['gastoscaja'] ?? 0;
        $this->dineroencaja = $args['dineroencaja'] ?? 0; 
        $this->domicilios = $args['domicilios'] ?? 0;
        $this->ndomicilios = $args['ndomicilios'] ?? 0;
        $this->realencaja = $args['realencaja'] ?? 0;
        $this->ingresoventas = $args['ingresoventas'] ?? 0;
        $this->totaldescuentos = $args['totaldescuentos'] ?? 0;
        $this->realventas = $args['realventas'] ?? 0;
        $this->impuesto = $args['impuesto'] ?? 0;
        $this->totalbruto = $args['totalbruto'] ?? 0;
        $this->estado = $args['estado'] ?? 0;
        $this->dato1 = $args['dato1'] ?? '';
        $this->dato2 = $args['dato2'] ?? '';
    }

    // 
    public function validar_nueva_cierrecaja():array {
        if(!$this->idcaja)self::$alertas['error'][] = 'Id de caja no encontrado';
        if(!$this->fechacierre)self::$alertas['error'][] = 'Fecha de cierre no encontrada';
        return self::$alertas;
    }

    public static function discriminarmediospagos(string $id)
    {
        static::all();
        self::all();
        $sql = "SELECT mediospago.id AS idmediopago, mediospago.mediopago, SUM(factmediospago.valor) AS valor FROM mediospago 
        JOIN factmediospago ON mediospago.id = factmediospago.idmediopago 
        JOIN facturas ON factmediospago.id_factura = facturas.id 
        WHERE facturas.idcierrecaja = $id AND facturas.estado = 'Paga' GROUP BY mediospago.mediopago;";

        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }
}