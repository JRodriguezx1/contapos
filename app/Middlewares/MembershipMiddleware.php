<?php 

namespace App\Middlewares;

use MVC\Router;

class MembershipMiddleware{

    protected Router $router;
    public function __construct(Router $routerApp) {
        $this->router = $routerApp;
    }
    
    public function validarSuscripcion():void{
        session_start();

        //debuguear($_SESSION);
        if(empty($_SESSION))return;

        //consultar la fecha de vencimiento en DB

        $host = $_SERVER['HTTP_HOST'];  //cliente.contapos.test/
        $subdominio = explode('.', $host)[0];
        if($subdominio == 'demo' || $subdominio == 'cliente'  || $subdominio == 'megatecho'){
            $this->router->set('Aviso_vencimiento', true);
            $this->router->set('msj_titulo_aviso_vencimiento', 'Aviso de vencimiento de suscripción');
            $this->router->set('msj_texto_aviso_vencimiento', 'Tu suscripción de j2 software POS esta próximo a vencer, te invitamos a renovarla oportunamente');
        }
    }
}
