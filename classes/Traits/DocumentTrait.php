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
            $invoice_lines[$index] = [
                "type_item_identification_id" => "4", // tipo estándar
                "code" => $value->idproducto,
                "description" => $value->nombreproducto,
                "invoiced_quantity" => strval($value->cantidad),
                "unit_measure_id" => "70", // unidad por defecto: unidad
                "line_extension_amount" => number_format($value->base*$value->cantidad, 2, '.', ''),
                "free_of_charge_indicator" => false,
                "price_amount" => number_format($value->base, 2, '.', ''),
                "base_quantity" => strval($value->cantidad)
            ];

            if(is_numeric($value->impuesto)&&$value->impuesto>=0){
                $invoice_lines[$index]["tax_totals"] = [
                    [
                        "tax_id" => 1, // IVA
                        "tax_amount" => number_format($value->valorimp, 2, '.', ''),
                        "taxable_amount" => number_format($value->base, 2, '.', ''),
                        "percent" => $value->impuesto
                    ],
                ];

                // Agrupar impuestos por porcentaje
                $percent = $value->impuesto;
                if (!isset($tax_summary[$percent])) {
                    $tax_summary[$percent] = [
                        "tax_id" => 1, //IVA
                        "percent" => $percent,
                        "taxable_amount" => 0,
                        "tax_amount" => 0
                    ];
                }
                $tax_summary[$percent]["taxable_amount"] += $value->base;
                $tax_summary[$percent]["tax_amount"] += $value->valorimp;
            }   


            // Acumulados
            $line_extension_total += $value->base;
            $tax_total += $value->valorimp;
            $tax_inclusive_total += $value->total;
        }

        //debuguear($tax_summary);

        // Convertir el resumen de impuestos en arreglo
        $tax_totals = array_values(array_map(function($t) {  //tax_summary = ["8" =>[], "19"=>[],...]
            return [
                "tax_id" => $t["tax_id"],
                "tax_amount" => number_format($t["tax_amount"], 2, '.', ''),
                "percent" => $t["percent"],
                "taxable_amount" => number_format($t["taxable_amount"], 2, '.', '')
            ];
        }, $tax_summary));

        //debuguear($tax_totals);

        // Totales monetarios
        $legal_monetary_totals = [
            "line_extension_amount" => number_format($line_extension_total, 2, '.', ''),  //sin impuesto
            "tax_exclusive_amount" => number_format($line_extension_total, 2, '.', ''),  //sin impuesto
            "tax_inclusive_amount" => number_format($tax_inclusive_total, 2, '.', ''),  //con impuesto
            "allowance_total_amount" => "0.00",
            "charge_total_amount" => "0.00",
            "payable_amount" => number_format($tax_inclusive_total, 2, '.', '')
        ];

        // Armar la factura final
        $factura = [
            "invoice_lines" => $invoice_lines,
            "tax_totals" => $tax_totals,
            "legal_monetary_totals" => $legal_monetary_totals
        ];

        echo json_encode($factura, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return;


        debuguear($factura);
        debuguear($datosAdquiriente);
    }
}