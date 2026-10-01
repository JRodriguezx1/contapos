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
        $tasaDirecta = $this->tasaRepository->obtenerUltimaTasa($monedaOrigenId, $monedaDestinoId);

        if($tasaDirecta !== null)
            return bcmul($valor, $tasaDirecta->getTasa(), $decimales);  //bcmul = multiplicar

        /*
         * Si no existe tasa directa, buscamos la relación inversa:
         *
         * VES ← COP
         */
        $tasaInversa = $this->tasaRepository->obtenerUltimaTasa($monedaDestinoId, $monedaOrigenId);

        if($tasaInversa !== null){
            if(bccomp($tasaInversa->getTasa(), '0', 10) === 0) //bccomp = comparar
                throw new RuntimeException('La tasa de cambio no puede ser cero.');

            return bcdiv($valor, $tasaInversa->getTasa(), $decimales);  //bcdiv = dividir
        }

        throw new RuntimeException('No existe una tasa de cambio para las monedas solicitadas.');
    }

}