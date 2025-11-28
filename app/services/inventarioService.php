<?php 

namespace App\services;

use App\Models\ActiveRecord;
use App\Models\inventario\productos;
use PhpOffice\PhpSpreadsheet\IOFactory;
use stdClass;

class inventarioService {
    
    public static function importarExcel($excel_temp){
        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($excel_temp);
            $worksheet = $spreadsheet->getActiveSheet();
            // Convertir a array
            $filas = $worksheet->toArray();
            
            // Remover encabezados (primera fila)
            $encabezados = array_shift($filas);
            $productos_procesados = 0;
            $errores = [];
            
            // Procesar cada fila
            foreach($filas as $index => $fila){
                // Saltar encabezado
                if ($index == 1) continue;
                
                $codigo = trim($fila['A']);
                $idcategoria = trim($fila['B']);
                $idunidadmedida = floatval($fila['C']);
                $nombre  = intval($fila['D']);
                $impuesto = trim($fila['E']);
                $marca = floatval($fila['F']);
                $tipoproducto  = intval($fila['G']);
                $tipoproduccion = trim($fila['H']);
                $sku = floatval($fila['I']);
                $unidadmedida  = intval($fila['J']);
                $preciopersonalizado = trim($fila['K']);
                $precio_compra = floatval($fila['L']);
                $precio_venta  = intval($fila['M']);

                $rows[] = "($idcategoria, $idunidadmedida, $nombre, $impuesto, $marca, $tipoproducto, $tipoproduccion, $sku, $unidadmedida, $preciopersonalizado, $precio_compra, $precio_venta)";

            }

            if (!empty($rows)) {
                $values = implode(",", $rows);
                $sql = "INSERT INTO productos (id, idcategoria, idunidadmedida, nombre, impuesto, marca, tipoproducto, tipoproduccion, sku, unidadmedida, preciopersonalizado, precio_compra, precio_venta)
                        VALUES $values
                        ON DUPLICATE KEY UPDATE
                            idcategoria = VALUES(idcategoria),
                            idunidadmedida = VALUES(idunidadmedida),
                            nombre = VALUES(nombre)
                            impuesto = VALUES(impuesto),
                            marca = VALUES(marca),
                            tipoproducto = VALUES(tipoproducto)
                            tipoproduccion = VALUES(tipoproduccion),
                            sku = VALUES(sku),
                            unidadmedida = VALUES(unidadmedida)
                            preciopersonalizado = VALUES(preciopersonalizado),
                            precio_compra = VALUES(precio_compra),
                            precio_venta = VALUES(precio_venta)
                        ";
                        debuguear($sql);
                $r = productos::actualizarLibre($sql);
                
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}