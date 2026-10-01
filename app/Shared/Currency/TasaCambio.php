<?php

namespace App\Shared\Currency;

use DateTimeImmutable;

final class TasaCambio{

    public function __construct(
        private int $id,
        private int $monedaOrigenId,
        private int $monedaDestinoId,
        private string $tasa,
        private DateTimeImmutable $fechaHora,
        private ?string $fuente = null
    ) {}

    public function getId(): int{
        return $this->id;
    }

    public function getMonedaOrigenId(): int{
        return $this->monedaOrigenId;
    }

    public function getMonedaDestinoId(): int{
        return $this->monedaDestinoId;
    }

    public function getTasa(): string{
        return $this->tasa;
    }

    public function getFechaHora(): DateTimeImmutable{
        return $this->fechaHora;
    }

    public function getFuente(): ?string{
        return $this->fuente;
    }
    
}