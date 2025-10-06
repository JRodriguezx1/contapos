<?php

namespace Model;

class sucursales extends ActiveRecord{
    protected static $tabla = 'sucursales';
    protected static $columnasDB = ['id', 'negocio', 'nombre', 'nit', 'departamento', 'ciudad', 'direccion', 'telefono', 'movil', 'email', 'datosencabezados', 'www', 'ws', 'facebook', 'instagram', 'tiktok', 'youtube', 'logo', 'estado', 'timezone'];
    
    public function __construct($args = []){
        $this->id = $args['id']??null;
        $this->negocio = $args['negocio']??'';
        $this->nombre = $args['nombre']??'';
        $this->nit = $args['nit'] ?? '';
        $this->departamento = $args['departamento'] ?? '';
        $this->ciudad = $args['ciudad'] ?? '';
        $this->direccion = $args['direccion']??'';
        $this->telefono = $args['telefono']??'';
        $this->movil = $args['movil'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->datosencabezados = $args['datosencabezados'] ?? '';
        $this->www = $args['www'] ?? '';
        $this->ws = $args['ws'] ?? '';
        $this->facebook = $args['facebook'] ?? '';
        $this->instagram = $args['instagram'] ?? '';
        $this->tiktok = $args['tiktok'] ?? '';
        $this->youtube = $args['youtube'] ?? '';
        $this->logo = $args['logo'] ?? '';
        $this->estado = $args['estado']??1;
        $this->timezone = $args['timezone']??'America/Bogota';
        $this->created_at = $args['created_at']??'';
    }


    public function validar():array
    {
        if(!$this->negocio)self::$alertas['error'][] = "negocio no especificado";
        if(strlen($this->negocio)>20)self::$alertas['error'][] = "Has excecido el limite de caracteres del nombre del negocio";
        if(!$this->nombre)self::$alertas['error'][] = "Nombre de la sucursal no especificado";
        if(strlen($this->nombre)>20)self::$alertas['error'][] = "Has excecido el limite de caracteres del nombre de la sucursal";
        if(strlen($this->direccion)>60)self::$alertas['error'][] = "Has excecido el limite de caracteres para la direccion";
        if(strlen($this->telefono)>15)self::$alertas['error'][] = "Has excecido el limite de caracteres para el telefono";
        return self::$alertas;
    }

    // Validar los servicios
    public function validarnegocio() {
        if(!$this->nombre || strlen($this->nombre)>42) {
            self::$alertas['error'][] = 'Nombre del negocio no valido';  //['error] = ['string1', 'string2'...]
        }  //como el arreglo alertas es heredada de la clase padre activerecord self hace referencia a este arreglo de la clase padre
        if(!$this->ciudad || strlen($this->ciudad)>40) {
            self::$alertas['error'][] = 'Ciudad no valida';
        }
        if(!$this->direccion || strlen($this->direccion)>55) {
            self::$alertas['error'][] = 'Direccion no valida';
        }
        if(strlen($this->telefono)>13) {
            self::$alertas['error'][] = 'Telefono muy extenso';
        }
        if(!$this->movil || strlen($this->movil)>14) {
            self::$alertas['error'][] = 'Movil no valido';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->ws || strlen($this->ws)>15) {
            self::$alertas['error'][] = 'Whatsapp no valido';
        }
        if(strlen($this->facebook)>77) {
            self::$alertas['error'][] = 'Url de facebook muy extenso';
        }
        if(!$this->facebook){
            self::$alertas['error'][] = 'Url de facebook no valida';
        }
        if(strlen($this->instagram)>77) {
            self::$alertas['error'][] = 'URL de instagram muy extenso';
        }
        if(!$this->logo) {
            self::$alertas['error'][] = 'El logo es obligatorio';
        }
        return self::$alertas;
    }

}