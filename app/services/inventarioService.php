<?php 

namespace App\services;

use App\Models\ActiveRecord;
use App\Models\inventario\productos;
use PhpOffice\PhpSpreadsheet\IOFactory;
use stdClass;

class inventarioService {
    
    public static function importarExcel($excel_temp){
        $alertas = [];
        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($excel_temp);
            $worksheet = $spreadsheet->getActiveSheet();
            // Convertir a array
            $filas = $worksheet->toArray();
            
            // Procesar cada fila
            foreach($filas as $index => $fila){
                // Saltar encabezado
                if ($index == 0) continue;

                $v = self::filaVacia($fila);
                if($v['status']==false){
                    $alertas['error'][] = "error en fila $index ".$v['columna'];
                }
                
                $id = $fila[0];
                $idcategoria = $fila[1];
                $idunidadmedida = $fila[2];
                $nombre  = $fila[3];
                $impuesto = $fila[4];
                $marca = $fila[5];
                $tipoproducto  = $fila[6];
                $tipoproduccion = $fila[7];
                $sku = $fila[8];
                $unidadmedida  = $fila[9];
                $preciopersonalizado = $fila[10];   //  0 = no,  1 = si
                $precio_compra = $fila[11];
                $precio_venta  = $fila[12];

                $rows[] = "($idcategoria, $idunidadmedida, $nombre, $impuesto, $marca, $tipoproducto, $tipoproduccion, $sku, $unidadmedida, $preciopersonalizado, $precio_compra, $precio_venta)";
            }

            if (!empty($rows) && empty($alertas)) {
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
                if($r){
                    $alertas['exito'][] = "productos subidos a sistema.";
                    //actualizar cantidades en stocksucursal por sucursal
                }
                
            }
            return $alertas;

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private static function filaVacia($fila) {
        $s = "";
        $status = true;
        foreach($fila as $index => $celda) {
            if((!isset($celda) || trim($celda)=='') && $index>0 ) {
                $s .= "col: $index, ";
                $status = false;
            }
        }
        if(!$status)return ['status'=>false, 'columna'=>$s];
        return ['status'=>true];
    }

}