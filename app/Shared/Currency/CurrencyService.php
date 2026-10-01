<?php

namespace App\Shared\Currency;

use RuntimeException;

final class CurrencyService{
    
    public function __construct(private TasaCambioRepository $tasaRepository)
    {}

    public function convertir(string $valor, int $monedaOrigenId, int $monedaDestinoId, int $decimales = 2): string{

        // Misma moneda: no necesitamos conversión.
        if($monedaOrigenId === $monedaDestinoId)
            return bcadd($valor, '0', $decimales);  //bcadd = sumnar

        /*
         * Primero buscamos una tasa directa:
         *
         * COP → VES
         *
         * destino = origen × tasa
         */
        $tasa = $this->obtenerTasa($monedaOrigenId, $monedaDestinoId);

        return bcmul($valor, $tasa, $decimales);
    }


    public function obtenerTasa(int $monedaOrigenId, int $monedaDestinoId, int $precision = 10): string{
        if($monedaOrigenId === $monedaDestinoId)return '1';

        $directa = $this->tasaRepository->obtenerUltimaTasa($monedaOrigenId, $monedaDestinoId);

        if($directa !== null)return $directa->getTasa();

        $inversa = $this->tasaRepository->obtenerUltimaTasa($monedaDestinoId, $monedaOrigenId);

        if($inversa !== null){
            if (bccomp($inversa->getTasa(), '0', 10) === 0)
                throw new RuntimeException('La tasa de cambio no puede ser cero.');
            return bcdiv('1', $inversa->getTasa(), $precision);
        }

        throw new RuntimeException('No existe una tasa de cambio para las monedas solicitadas.');
    }

}