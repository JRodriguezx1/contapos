<?php
namespace App\Models\caja;

class cierrescajas extends \App\Models\ActiveRecord {
    protected static $tabla = 'cierrescajas';
    protected static $columnasDB = ['id', 'idsucursal_id', 'idcaja', 'id_usuario', 'nombrecaja', 'nombreusuario', 'fechainicio', 'fechacierre', 'ncambiosaventa', 'totalcotizaciones', 'totalfacturaseliminadas', 'facturaselectronicaselimnadas', 'facturasposeliminadas', 'valorfeeliminado', 'valorposeliminado', 'totalfacturas', 'facturaselectronicas', 'facturaspos', 'valorfe', 'valorpos', 'descuentofe', 'descuentopos', 'basecaja', 'ventasenefectivo', 'creditocapital', 'creditos', 'abonostotales', 'abonosenefectivo', 'abonoscreditos', 'abonosseparados', 'gastoscaja', 'gastosbanco', 'dineroencaja', 'domicilios', 'ndomicilios', 'realencaja', 'ingresoventas', 'totaldescuentos', 'realventas', 'valorimpuestototal', 'basegravable', 'estado', 'dato1', 'dato2'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idsucursal_id = $args['idsucursal_id'] ?? '';
        $this->idcaja = $args['idcaja'] ?? 1;
        $this->id_usuario = $args['id_usuario']??1;
        $this->nombrecaja = $args['nombrecaja']??'';
        $this->nombreusuario = $args['nombreusuario']??'';
        $this->fechainicio = $args['fechainicio'] ?? date('Y-m-d H:i:s');
        $this->fechacierre = $args['fechacierre'] ?? date('Y-m-d H:i:s');
        $this->ncambiosaventa = $args['ncambiosaventa'] ?? 0;
        $this->totalcotizaciones = $args['totalcotizaciones'] ?? 0;
        $this->totalfacturaseliminadas = $args['totalfacturaseliminadas'] ?? 0;
        $this->facturaselectronicaselimnadas = $args['facturaselectronicaselimnadas'] ?? 0;
        $this->facturasposeliminadas = $args['facturasposeliminadas'] ?? 0;
        $this->valorfeeliminado = $args['valorfeeliminado'] ?? 0;
        $this->valorposeliminado = $args['valorposeliminado'] ?? 0;
        $this->totalfacturas = $args['totalfacturas'] ?? 0;
        $this->facturaselectronicas = $args['facturaselectronicas'] ?? 0;
        $this->facturaspos = $args['facturaspos'] ?? 0;
        $this->valorfe = $args['valorfe'] ?? 0;
        $this->valorpos = $args['valorpos'] ?? 0;
        $this->descuentofe = $args['descuentofe'] ?? 0;
        $this->descuentopos = $args['descuentopos'] ?? 0;
        $this->basecaja = $args['basecaja'] ?? 0;
        $this->ventasenefectivo = $args['ventasenefectivo'] ?? 0;
        $this->creditocapital = $args['creditocapital'] ?? 0;
        $this->creditos = $args['creditos'] ?? 0;
        $this->abonostotales = $args['abonostotales'] ?? 0;
        $this->abonosenefectivo = $args['abonosenefectivo'] ?? 0;
        $this->abonoscreditos = $args['abonoscreditos'] ?? 0;
        $this->abonosseparados = $args['abonosseparados'] ?? 0;
        $this->gastoscaja = $args['gastoscaja'] ?? 0;
        $this->gastosbanco = $args['gastosbanco']??0;
        $this->dineroencaja = $args['dineroencaja'] ?? 0; 
        $this->domicilios = $args['domicilios'] ?? 0;
        $this->ndomicilios = $args['ndomicilios'] ?? 0;
        $this->realencaja = $args['realencaja'] ?? 0;
        $this->ingresoventas = $args['ingresoventas'] ?? 0;  //total ingreso de ventas
        $this->totaldescuentos = $args['totaldescuentos'] ?? 0;  //descuentos
        $this->realventas = $args['realventas'] ?? 0;  //ingreso real = total ingreso - descuentos
        $this->valorimpuestototal = $args['valorimpuestototal'] ?? 0;
        $this->basegravable = $args['basegravable'] ?? 0;
        $this->estado = $args['estado'] ?? 0;  // 0 = abierto, 1 = cerrado
        $this->dato1 = $args['dato1'] ?? '';
        $this->dato2 = $args['dato2'] ?? '';
    }

    // 
    public function validar_nueva_cierrecaja():array {
        if(!$this->idcaja)self::$alertas['error'][] = 'Id de caja no encontrado';
        if(!$this->fechacierre)self::$alertas['error'][] = 'Fecha de cierre no encontrada';
        return self::$alertas;
    }

    //discriminar medios de pago de un solo cierre de caja
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

     public static function discriminarmediospagoscajas(array $id): array
    {
        $id = join(', ', $id);
        $sql = "SELECT mediospago.id AS idmediopago, mediospago.mediopago, SUM(factmediospago.valor) AS valor FROM mediospago 
        JOIN factmediospago ON mediospago.id = factmediospago.idmediopago 
        JOIN facturas ON factmediospago.id_factura = facturas.id 
        WHERE facturas.idcierrecaja IN($id) AND facturas.estado = 'Paga' GROUP BY mediospago.mediopago;";
        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }

    public static function ventasXusuario(string $id): array{
        $sql = "SELECT CONCAT(usuarios.nombre, ' ', usuarios.apellido) as Nombre, COUNT(facturas.idvendedor) as N_ventas, SUM(facturas.subtotal) as ventas FROM usuarios 
        JOIN facturas ON usuarios.id = facturas.idvendedor
        WHERE facturas.idcierrecaja = $id AND facturas.estado = 'Paga' GROUP BY facturas.idvendedor;";

        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;  
    }


    //discriminar impuesto de un solo cierre de caja
    public static function discriminarimpuesto(string $id)
    {
        $sql = "SELECT impuestos.nombre AS impuestos, impuestos.porcentaje AS tarifa, 
                SUM(factimpuestos.basegravable) AS basegravable, SUM(factimpuestos.valorimpuesto) AS valorimpuesto 
                FROM impuestos JOIN factimpuestos ON factimpuestos.id_impuesto = impuestos.id
                JOIN facturas ON facturas.id = factimpuestos.facturaid
                WHERE facturas.idcierrecaja = $id AND facturas.estado = 'Paga' GROUP BY impuestos, tarifa;";

        $resultado = self::$db->query($sql);
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }

    public static function discriminarimpuestocaja(array $id): array
    {
        $id = join(', ', $id);
        $sql = "SELECT impuestos.nombre AS impuestos, impuestos.porcentaje AS tarifa, 
                SUM(factimpuestos.basegravable) AS basegravable, SUM(factimpuestos.valorimpuesto) AS valorimpuesto 
                FROM impuestos JOIN factimpuestos ON factimpuestos.id_impuesto = impuestos.id
                JOIN facturas ON facturas.id = factimpuestos.facturaid
                WHERE facturas.idcierrecaja IN($id) AND facturas.estado = 'Paga' GROUP BY tarifa;";

        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }


    //discriminar gastos de un solo cierre de caja
    public static function discriminargastos(string $idcierrecaja, $idcaja, $idsucursal)
    {
        $sql="SELECT SUM(g.valor) AS valorgasto, g.idg_caja, cg.nombre, cg.id 
        FROM gastos g JOIN categoriagastos cg ON g.idcategoriagastos = cg.id 
        WHERE g.idg_cierrecaja = $idcierrecaja AND g.idg_caja = $idcaja AND g.id_sucursalfk = $idsucursal GROUP BY cg.id;";
        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }

}