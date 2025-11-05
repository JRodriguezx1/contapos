<?php

namespace Classes\Traits;

use Model\felectronicas\facturas_electronicas;
use Model\ventas\facturas;
use stdClass;

trait DocumentTrait
{

    protected static function createInvoiceElectronic(array $carrito, stdClass $datosAdquiriente):void
    {

        $invoice_lines = [];
        $tax_summary = []; // para agrupar impuestos
        $line_extension_total = 0;
        $tax_inclusive_total = 0;
        $tax_total = 0;

        foreach($carrito as $index => $value){
            $invoice_lines[] = [
                "type_item_identification_id" => "4", // tipo estándar
                "code" => $value->idproducto,
                "description" => $value->nombreproducto,
                "invoiced_quantity" => strval($value->cantidad),
                "unit_measure_id" => "70", // unidad por defecto: unidad
                "line_extension_amount" => number_format($value->base, 2, '.', ''),
                "free_of_charge_indicator" => false,
            ];

        }
        debuguear($carrito);
        debuguear($datosAdquiriente);
    }
}