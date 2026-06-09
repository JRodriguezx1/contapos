<?php

namespace App\Models\parqueadero;

class tipo_vehiculo 
{
    public ?int $id;
    public string $nombre;
    public float $tarifaHora;
    public ?float $tarifaDia;
    public int $estado;

    public function __construct(array $datos = []) 
    {
        $this->id = $datos['id'] ?? null;
        $this->nombre = $datos['nombre'] ?? '';
        $this->tarifaHora = isset($datos['tarifa_hora']) ? (float)$datos['tarifa_hora'] : 0.0;
        $this->tarifaDia = isset($datos['tarifa_dia']) ? (float)$datos['tarifa_dia'] : null;
        $this->estado = isset($datos['estado']) ? (int)$datos['estado'] : 1;
    }
}