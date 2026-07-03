<?php 

namespace App\services;

use App\Models\ActiveRecord;
use App\Models\inventario\conversionunidades;
use App\Models\inventario\productos;
use App\Models\inventario\stockinsumossucursal;
use App\Models\inventario\stockproductossucursal;
use App\Models\inventario\subproductos;
use App\Models\sucursales;
use PhpOffice\PhpSpreadsheet\IOFactory;
use stdClass;

class inventarioService {
    
    


    public static function exportproducts(array $date):array{
        
    }

    public static function eliminarConversionUnidad(int $id):array{
        $alertas = [];
        $getDB = conversionunidades::getDB();
        $cv = conversionunidades::find('id', $id);
        $getDB->begin_transaction();
        try {
            $cv->eliminar_registro();
            $getDB->commit();
            $alertas['exito'][] = "Conversion de unidad eliminada exitosamente";
        } catch (\Throwable $th) {
            $getDB->rollback();
            $alertas['error'][] = "Error, intenta nuevamente. {$th->getMessage()}";
        }
        return $alertas;
    }


}