<?php
namespace App\Models\clientes;

class clientes extends \App\Models\ActiveRecord {
    protected static $tabla = 'clientes';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'tipodocumento', 'identificacion', 'telefono', 'email', 'fecha_nacimiento', 'total_compras', 'ultima_compra', 'data1'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->tipodocumento = $args['tipodocumento'] ?? '';
        $this->identificacion = $args['identificacion'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->fecha_nacimiento = $args['fecha_nacimiento'] ?? '';
        $this->total_compras = $args['total_compras '] ?? '';
        $this->ultima_compra = $args['ultima_compra'] ?? '';
        $this->data1 = $args['data1'] ?? '';
    }

    // Validación para clientes nuevos
    public function validar_nuevo_cliente():array {
        if(!$this->nombre)self::$alertas['error'][] = 'El Nombre del cliente es Obligatorio';
        
        if(strlen($this->nombre)>32)self::$alertas['error'][] = 'Has excecido el limite de caracteres';
        
        if(!$this->apellido || strlen($this->apellido)>32)self::$alertas['error'][] = 'El apellido del cliente no debe ir vacio o ser mayor a 32 digitos';
        
        if(!$this->identificacion)self::$alertas['error'][] = 'La identificacion del cliente es Obligatorio';

        if(strlen($this->identificacion)<7 || strlen($this->identificacion)>11)self::$alertas['error'][] = 'La identificacion no debe ser menor a 7 digitos o mayor a 11 digitos';
        
        if(!$this->telefono)self::$alertas['error'][] = 'El telefono del cliente es Obligatorio';

        if(!is_numeric($this->telefono) || strlen($this->telefono) >10)self::$alertas['error'][] = 'El telefono es incorrecto o debe ser de 10 digitos';

        if($this->email)if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) self::$alertas['error'][] = 'Email no válido';

       // if(strlen($this->direccion)>74)self::$alertas['error'][] = 'Direccion muy larga';

        return self::$alertas;
    }
    

    public static function indicadoresVentasXcliente(int $idcliente, int $idsucursal = 1):object|NULL{
        $query = "SELECT
                    SUM(f.total) AS total_ventas_cliente,
                    COUNT(f.id) AS cantidad_ventas,
                    AVG(f.total) AS ticket_promedio,
                    SUM(v.cantidad) AS total_productos_comprados
                FROM facturas f
                LEFT JOIN ventas v ON v.idfactura = f.id
                WHERE f.fechapago >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND f.id_sucursal = $idsucursal AND f.idcliente = $idcliente AND f.estado = 'Paga';";
        $array = self::camposJoinObj($query);
        return array_shift($array);
    }

    public static function comprasXMesXCliente(int $idcliente, int $idsucursal = 1):array|NULL{
        $query = "SELECT
                    DATE_FORMAT(f.fechapago, '%Y-%m') as periodo,
                    SUM(f.total) AS ventas_totales
                FROM facturas f
                WHERE f.fechapago >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND f.id_sucursal = $idsucursal AND f.idcliente = $idcliente AND f.estado = 'Paga'
                GROUP BY YEAR(f.fechapago), MONTH(f.fechapago)
                ORDER BY YEAR(f.fechapago), MONTH(f.fechapago);";
        $array = self::camposJoinObj($query);
        return $array;
    }

    public static function ventasXCategoriasXCliente(int $idcliente, int $idsucursal = 1):array|NULL{
        $query = "SELECT
                    p.idcategoria,
                    c.nombre AS categoria,
                    SUM(v.cantidad) AS unidades_vendidas,
                    SUM(v.total) AS venta_total_categoria
                FROM facturas f
                JOIN ventas v ON v.idfactura = f.id
                JOIN productos p ON p.id = v.idproducto
                LEFT JOIN categorias c ON c.id = p.idcategoria
                WHERE f.id_sucursal = $idsucursal AND f.idcliente = $idcliente AND f.estado = 'Paga'
                GROUP BY p.idcategoria, c.nombre
                ORDER BY venta_total_categoria DESC;";
        $array = self::camposJoinObj($query);
        return $array;
    }
    
}