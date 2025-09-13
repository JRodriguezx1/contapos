<?php

namespace Model;

class gastos extends ActiveRecord {
    protected static $tabla = 'gastos';
    protected static $columnasDB = ['id', 'id_sucursalfk', 'idg_usuario', 'id_compra', 'id_banco', 'idg_caja', 'idg_cierrecaja', 'idcategoriagastos', 'tipo_origen', 'operacion', 'valor', 'descripcion', 'fecha'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_sucursalfk = id_sucursal();
        $this->idg_usuario = $args['idg_usuario'] ?? 1;
        $this->id_compra = $args['id_compra']??NULL;
        $this->id_banco = $args['id_banco'] ??'';
        $this->idg_caja = $args['idg_caja'] ??'';
        $this->idg_cierrecaja = $args['idg_cierrecaja'] ?? '';
        $this->idcategoriagastos = $args['idcategoriagastos'] ?? 1;
        $this->tipo_origen = $args['tipo_origen'] ??0;  //0 = origen es caja,   1 = origen es banco
        $this->operacion = $args['operacion'] ?? 'gasto';
        $this->valor = $args['valor'] ?? 0;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
    }


    public function validar():array
    {
        if(!$this->idg_usuario)self::$alertas['error'][] = "Error con usuario de sistema";
        //if(!$this->idg_caja)self::$alertas['error'][] = "Caja no seleccionada";
        if(!$this->idg_cierrecaja)self::$alertas['error'][] = "Error con la apertura del dia de caja";
        if(!$this->operacion)self::$alertas['error'][] = "Error con la operacion gasto de la caja";
        if(!$this->valor)self::$alertas['error'][] = "Valor gasto no ingresado";
        if(strlen($this->descripcion)>244)self::$alertas['error'][] = "Has excecido el limite de caracteres de la descripcion";
        return self::$alertas;
    }
}