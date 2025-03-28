<?php
namespace Model;

class facturas extends ActiveRecord {
    protected static $tabla = 'facturas';
    protected static $columnasDB = ['id', 'idcliente', 'idvendedor', 'idcaja', 'idconsecutivo', 'iddireccion', 'idtarifazona', 'idcierrecaja', 'cliente', 'vendedor', 'caja', 'tipofacturador', 'direccion', 'tarifazona', 'totalunidades', 'recibido', 'transaccion', 'tipoventa', 'cotizacion', 'estado', 'cambioaventa', 'subtotal', 'impuesto', 'dctox100', 'descuento', 'total', 'observacion', 'departamento', 'ciudad', 'entrega', 'valortarifa', 'fechacreacion', 'fechapago', 'opc1', 'opc2'];
    private static $arrayMetodosPago = ['Efectivo', 'Daviplata', 'Nequi', 'TD', 'TC', 'QR', 'TB'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idcliente = $args['idcliente'] ?? 1;
        $this->idvendedor = $args['idvendedor'] ?? 1; //tabla usuarios
        $this->idcaja = $args['idcaja'] ?? 1;
        $this->idconsecutivo = $args['idconsecutivo'] ?? 1;
        $this->iddireccion = $args['iddireccion'] ?? 1;
        $this->idtarifazona = $args['idtarifazona'] ?? 1;
        $this->idcierrecaja = $args['idtarifazona'] ?? '';
        $this->cliente = $args['cliente'] ?? '';  //nombre del cliente
        $this->vendedor = $args['vendedor'] ?? '';  //nombre del vendedor
        $this->caja = $args['caja'] ?? '';   //nombre de la caja
        $this->tipofacturador = $args['tipofacturador'] ?? '';  //nombre del tipo de facturador
        $this->direccion = $args['direccion'] ?? '';  //nombre de la direccion
        $this->tarifazona = $args['tarifazona'] ?? '';  //nombre de la tarifa
        $this->totalunidades = $args['totalunidades'] ?? 0;
        $this->recibido = $args['recibido'] ?? 0;
        $this->transaccion = $args['transaccion'] ?? 0;
        $this->tipoventa = $args['tipoventa'] ?? 'Contado';
        $this->cotizacion = $args['cotizacion'] ?? 0; //1 = cotizacion
        $this->estado = $args['estado'] ?? 'paga';
        $this->cambioaventa = $args['cambioaventa']??0;  //1 = se pasa de cotizacion a venta
        $this->subtotal = $args['subtotal'] ?? 0;
        $this->impuesto = $args['impuesto'] ?? 0;
        $this->dctox100 = $args['dctox100'] ?? 0;
        $this->descuento = $args['descuento'] ?? 0;
        $this->total = $args['total'] ?? 0;
        $this->observacion = $args['observacion'] ?? '';
        $this->departamento = $args['departamento'] ?? '';
        $this->ciudad = $args['ciudad'] ?? '';
        $this->entrega = $args['entrega'] ?? 'Presencial';
        $this->valortarifa = $args['valortarifa'] ?? 0;
        $this->fechacreacion = $args['fechacreacion'] ?? date('Y-m-d H:i:s');
        $this->fechapago = $args['fechapago'] ?? date('Y-m-d H:i:s');
        $this->opc1 = $args['opc1'] ?? '';
        $this->opc2 = $args['opc2'] ?? '';
    }

    // Validación para clientes nuevos
    public function validar_nueva_factura():array {
        if(!$this->idcliente)self::$alertas['error'][] = 'El cliente es Obligatorio';
        if(!$this->idvendedor)self::$alertas['error'][] = 'El vendedor es obligatorio';
        return self::$alertas;
    }

    public static function rangoentre2R_Factura($fecha, $totalventa, $fechaini, $fechafin, $asc_desc="ASC"){
        $sql = "SELECT DATE($fecha) AS fecha, COUNT(*) AS numventasxdia, SUM($totalventa) AS totalventasxdia, ";
        foreach(self::$arrayMetodosPago as $key=>$value){
            if(array_key_last(self::$arrayMetodosPago) == $key){
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN 1 ELSE 0 END) AS ${value},";
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN totalventa ELSE 0 END) AS total_${value}";
            }else{
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN 1 ELSE 0 END) AS ${value},";
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN totalventa ELSE 0 END) AS total_${value},";
            }
        }
        $sql.= " FROM ".static::$tabla." WHERE $fecha BETWEEN '$fechaini' AND '$fechafin 23:59:59' GROUP BY DATE($fecha) ORDER BY '$fecha' $asc_desc;";
        
        /*SELECT DATE(fechapago) AS fecha, COUNT(*) AS numventas, SUM(totalventa) AS totalventas,
        SUM(CASE WHEN metodopago = 'Efectivo' THEN 1 ELSE 0 END) AS Efectivo,
        SUM(CASE WHEN metodopago = 'Efectivo' THEN totalventa ELSE 0 END) AS total_Efectivo,
        SUM(CASE WHEN metodopago = 'Daviplata' THEN 1 ELSE 0 END) AS Daviplata,
        SUM(CASE WHEN metodopago = 'Daviplata' THEN totalventa ELSE 0 END) AS total_Daviplata
        FROM facturas WHERE fechapago BETWEEN '2024-01-29' AND '2024-02-03 23:59:59'
        GROUP BY DATE(fechapago) ORDER BY 'fechapago' ASC;*/

        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }


    public static function rangoFechadeventas($fecha, $totalventa, $fechaini, $fechafin, $usuarios=[], $asc_desc="ASC"){
        $sql = "SELECT DATE($fecha) AS fecha, 
        ventasXfecha.numVentasXfecha,
        ventasXfecha.totalventasXdia,
        vtProduct.productsVendidosXdia,
        vtProduct.referenciasVendidasXdia,
        MaxProduct.idProductMxVendidoXdia,
        MaxProduct.cantidadproductMxVendidoXdia, 
        MaxProduct.nombreProductoXdia,

        totalProductos AS totalReferenciasVendidas,
        productosMasVendido.idProductoMxvendido,
        productosMasVendido.cantidadProductMxVen,
        productosMasVendido.nombreProductMxVen,

        ventasXfecha.Efectivo,
        ventasXfecha.totalEfectivo,
        ventasXfecha.Daviplata,
        ventasXfecha.totalDaviplata,
        ventasXfecha.Nequi,
        ventasXfecha.totalNequi,
        ventasXfecha.TD,
        ventasXfecha.totalTD,
        ventasXfecha.TC,
        ventasXfecha.totalTC,
        ventasXfecha.QR,
        ventasXfecha.totalQR,
        ventasXfecha.TB,
        ventasXfecha.totalTB,";
        foreach($usuarios as $key=>$value){
            if(array_key_last($usuarios) == $key){
                $sql.=" ventasXfecha.V_$value,";
                $sql.=" ventasXfecha.Vtotal$value";
            }else{
                $sql.=" ventasXfecha.V_$value,";
                $sql.=" ventasXfecha.Vtotal$value,";
            }
        }

        $sql.= " FROM facturas LEFT JOIN ventas ON facturas.id = ventas.idfactura";

        ///calcula el numero de ventas X dia y su total $ X dia ///
        $sql.= " LEFT JOIN (SELECT DATE($fecha) AS fecha, COUNT(*) AS numVentasXfecha, SUM($totalventa) AS totalventasXdia, ";
        foreach(self::$arrayMetodosPago as $key=>$value){
            if(array_key_last(self::$arrayMetodosPago) == $key){
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN 1 ELSE 0 END) AS ${value},";
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN $totalventa ELSE 0 END) AS total${value},";
            }else{
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN 1 ELSE 0 END) AS ${value},";
                $sql.=" SUM(CASE WHEN metodopago = '$value' THEN $totalventa ELSE 0 END) AS total${value},";
            }
        }
        foreach($usuarios as $key=>$value){
            if(array_key_last($usuarios) == $key){
                $sql.=" SUM(CASE WHEN idvendedor = '$key' THEN 1 ELSE 0 END) AS V_${value},";
                $sql.=" SUM(CASE WHEN idvendedor = '$key' THEN $totalventa ELSE 0 END) AS Vtotal${value}";
            }else{
                $sql.=" SUM(CASE WHEN idvendedor = '$key' THEN 1 ELSE 0 END) AS V_${value},";
                $sql.=" SUM(CASE WHEN idvendedor = '$key' THEN $totalventa ELSE 0 END) AS Vtotal${value},";
            }
        }
        $sql.= " FROM facturas WHERE ${fecha} BETWEEN '$fechaini' AND '$fechafin 23:59:59'
        GROUP BY DATE($fecha)) AS ventasXfecha ON DATE(facturas.$fecha) = ventasXfecha.fecha";
        ///calcula el idproducto mas vendido por dia y su cantidad y nombre ///
        $sql.= " LEFT JOIN (SELECT 
            DATE(facturas.${fecha}) AS fecha,
            idproducto AS idProductMxVendidoXdia, ventas.producto AS nombreProductoXdia,  SUM(cantidad) AS cantidadproductMxVendidoXdia
        FROM ventas JOIN facturas ON ventas.idfactura = facturas.id
        WHERE facturas.$fecha BETWEEN '$fechaini' AND '$fechafin 23:59:59'
        GROUP BY DATE(facturas.$fecha), idproducto
        ORDER BY SUM(cantidad) DESC) AS MaxProduct ON DATE(facturas.$fecha) = MaxProduct.fecha";
        ///calcula cuantos productos y cuantas referencias distintas en total X dia se vendieron en el rango ///
        $sql.= " LEFT JOIN (SELECT 
            DATE($fecha) AS fecha,
            SUM(cantidad) AS productsVendidosXdia,
            COUNT(DISTINCT ventas.idproducto) AS referenciasVendidasXdia
        FROM ventas JOIN facturas ON ventas.idfactura = facturas.id
        WHERE facturas.$fecha BETWEEN '$fechaini' AND '$fechafin 23:59:59'
        GROUP BY DATE(facturas.$fecha)) AS vtProduct ON DATE(facturas.$fecha) = vtProduct.fecha";
        /// calcula el total de idprodutos distintos vendidos de todo el rango ///
        $sql.= " CROSS JOIN (SELECT 
            COUNT(DISTINCT idproducto) AS totalProductos
        FROM ventas
        WHERE ventas.idfactura IN (
        SELECT id FROM facturas WHERE $fecha BETWEEN '$fechaini' AND '$fechafin 23:59:59')
        LIMIT 1) AS totalReferenciasVendidas";
        /// calcula el idproducto mas vendido de todo el rango y su cantidad y nombre ///
        $sql.= " LEFT JOIN (SELECT 
            idproducto AS idProductoMxvendido, 
            SUM(cantidad) AS cantidadProductMxVen,
            producto AS nombreProductMxVen
        FROM ventas
        WHERE idfactura IN (
        SELECT id FROM facturas WHERE $fecha BETWEEN '$fechaini' AND '$fechafin 23:59:59')
        GROUP BY idproducto ORDER BY cantidadProductMxVen DESC LIMIT 1) AS productosMasVendido ON 1=1";
 
        $sql.= " WHERE $fecha BETWEEN '$fechaini' AND '$fechafin 23:59:59'
        GROUP BY DATE($fecha) ORDER BY DATE($fecha) $asc_desc;";

        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }


    public static function rangoFechadeproductos($fecha, $fechaini, $fechafin, $asc_desc="ASC"){

        $sql = "SELECT productos.id, productos.nombre, SUM(ventas.cantidad) AS Total_Vendido FROM productos 
        JOIN ventas ON productos.id = ventas.idproducto 
        JOIN facturas ON ventas.idfactura = facturas.id 
        WHERE facturas.$fecha BETWEEN '$fechaini' AND '$fechafin 23:59:59' 
        GROUP BY productos.id, productos.nombre
        ORDER BY Total_Vendido $asc_desc LIMIT 10;";

        $resultado = self::$db->query($sql); //SHOW TABLE STATUS LIKE 'facturas';
        $array = [];
        while($row = $resultado->fetch_assoc())
        $array[] = $row;
        $resultado->free();
        return $array;
    }
    
}