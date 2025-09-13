<?php

namespace Controllers;

use Classes\Email;
use Model\ActiveRecord;
use Model\negocio;
use Model\ventas\ventas;
use Model\tarifas;
use MVC\Router;  //namespace\clase

class parametroscontrolador{
    
  public static function parametrosSistemaCaja():void{
    session_start();
    isadmin();
    
  }
}