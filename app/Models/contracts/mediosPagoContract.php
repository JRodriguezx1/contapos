<?php

namespace App\Models\contracts;

interface mediosPagoContract{
    public function crear_guardar();
    public function validar():array;
    public function pagoDestino(int $id): void;
}