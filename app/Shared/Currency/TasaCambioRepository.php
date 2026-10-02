<?php

namespace App\Shared\Currency;

use DateTimeImmutable;
use mysqli;

final class TasaCambioRepository{

    public function __construct(private mysqli $db)
    {}

    public function obtenerUltimaTasa(int $monedaOrigenId, int $monedaDestinoId): ?TasaCambio {
        $sql = "
            SELECT id, moneda_origen_id, moneda_destino_id, tasa, fecha_hora, fuente
            FROM tasas_cambio
            WHERE moneda_origen_id = ?
              AND moneda_destino_id = ?
              AND fecha_hora <= NOW()
            ORDER BY fecha_hora DESC
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $monedaOrigenId, $monedaDestinoId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if(!$row)return null;

        return new TasaCambio(
            (int) $row['id'],
            (int) $row['moneda_origen_id'],
            (int) $row['moneda_destino_id'],
            $row['tasa'],
            new DateTimeImmutable($row['fecha_hora']),
            $row['fuente']
        );
    }
}