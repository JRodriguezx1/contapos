<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function validar_string_url($path):bool{ //retorna bolean
    //return strpos($_SERVER['PATH_INFO']??'/', $path)?true:false;
    return strpos($_SERVER['REQUEST_URI']??'/', $path)?true:false;
}

function isauth():void  //valida si el usuario esta registrao
{
  if(!isset($_SESSION['login'])||$_SESSION['perfil']==null){
      header('Location: /');       //lo redirecciona a la pagina web
  }
}

function isadmin():void
{/*
    if($_SESSION['perfil']!=1){
        header('Location: /');
    }*/
    if($_SESSION['perfil']==NULL){
        header('Location: /');
    }
}