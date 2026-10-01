<?php

namespace App\Shared\Currency;

final class Moneda{
    public function __construct(private int $id, private string $codigo, private string $nombre, private string $simbolo, private bool $activo = true)
    {}

    public function getId(): int{
        return $this->id;
    }

    public function getCodigo(): string{
        return $this->codigo;
    }

    public function getNombre(): string{
        return $this->nombre;
    }

    public function getSimbolo(): string{
        return $this->simbolo;
    }

    public function isActivo(): bool{
        return $this->activo;
    }
    
}