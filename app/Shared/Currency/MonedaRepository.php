<?php

namespace App\Shared\Currency;

use mysqli;

final class MonedaRepository{

    public function __construct(private mysqli $db)
    {}

    public function buscarPorId(int $id): ?Moneda{
        $sql = "SELECT id, codigo, nombre, simbolo, activo FROM monedas WHERE id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if(!$row)return null;

        return new Moneda(
            (int) $row['id'],
            $row['codigo'],
            $row['nombre'],
            $row['simbolo'],
            (bool) $row['activo']
        );
    }
    
}