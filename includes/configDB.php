<?php

$host = $_SERVER['HTTP_HOST'];  //app_barber.test, cliente1.app_barber.test, cliente2.app_barber.test
$cliente = explode('.', $host); // $cliente['cliente1', 'app_barber', 'test']

$configDB = [
    //'app_barber'=>['namedb'=>'intermix_limpio'],
    'cliente'=>['namedb'=>'j2softpos'],
    'cliente1'=>['namedb'=>'j2a1'],
    'cliente2'=>['namedb'=>'j2a2']
];

$selectDB = $configDB[$cliente[0]]??'';

if($selectDB == null){ ?>
    <meta http-equiv="refresh" content="0; url=https://innovatech-production.up.railway.app/">
<?php
    exit;
}
?>




