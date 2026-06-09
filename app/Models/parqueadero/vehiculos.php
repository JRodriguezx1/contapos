<?php

namespace App\Models\parqueadero;

class vehiculos
{
    public ?int $id;
    public string $placa;
    public int $tipoVehiculoId;
    public ?string $propietario;
    public ?string $telefono;

    public function __construct(array $datos = []) 
    {
        $this->id = $datos['id'] ?? null;
        // Limpiamos y estandarizamos la placa (ej: "aaa-123" -> "AAA123")
        $this->placa = strtoupper(str_replace([' ', '-'], '', $datos['placa'] ?? ''));
        $this->tipoVehiculoId = $datos['tipo_vehiculo_id'] ?? 0;
        $this->propietario = $datos['propietario'] ?? null;
        $this->telefono = $datos['telefono'] ?? null;
    }
}