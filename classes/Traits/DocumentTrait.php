<?php

namespace Classes\Traits;

use Model\configuraciones\consecutivos;
use Model\felectronicas\diancompanias;
use Model\felectronicas\facturas_electronicas;
use Model\ventas\facturas;
use stdClass;

trait DocumentTrait
{

    protected static function createInvoiceElectronic(array $carrito, stdClass $datosAdquiriente, $idconsecutivo):bool
    {
        $invoice_lines = [];
        $tax_summary = []; // para agrupar impuestos
        $line_extension_total = 0;
        $tax_inclusive_total = 0;
        $tax_total = 0;

        $consecutivo = consecutivos::find('id', $idconsecutivo);
        $compañia = diancompanias::find('id', $consecutivo->idcompania);

        if($consecutivo->estado && $consecutivo->idtipofacturador == 1){
            $customer = [
                "identification_number" => $datosAdquiriente->identification_number??"222222222222",  //obligatorio
                "dv" => $datosAdquiriente->dv??null,
                "name" => $datosAdquiriente->business_name??"Consumidor Final",  //obligatorio
                "phone" => $datosAdquiriente->phone??null,
                "address" => $datosAdquiriente->address??null,
                "email" => $datosAdquiriente->email??null,
                "type_document_identification_id" => $datosAdquiriente->type_document_identification_id??3,
                "type_organization_id" => $datosAdquiriente->type_organization_id??null,
                "tax_id" => $datosAdquiriente->tax_id??null,
                "type_liability_id" => $datosAdquiriente->type_liability_id??null,
                "type_regime_id" => $datosAdquiriente->type_regime_id??null,
                "municipality_id" => $datosAdquiriente->municipality_id??null
            ];

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

            // Convertir el resumen de impuestos en arreglo
            $tax_totals = array_values(array_map(function($t) {  //tax_summary = ["8" =>[], "19"=>[],...]
                return [
                    "tax_id" => $t["tax_id"],
                    "tax_amount" => number_format($t["tax_amount"], 2, '.', ''),
                    "percent" => $t["percent"],
                    "taxable_amount" => number_format($t["taxable_amount"], 2, '.', '')
                ];
            }, $tax_summary));

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
                "prefix" => $consecutivo->prefijo,
                "number" => $consecutivo->siguientevalor, 
                "type_document_id" => "1",
                "date" => date('Y-m-d'),
                "time" => date('H:i:s'),
                "resolution_number" => $consecutivo->resolucion,
                "sendmail" => false,
                "notes" => "Factura Electroncia de venta",
                "payment_form" => [
                    "payment_form_id" => "1",
                    "payment_method_id" => "10",
                    "payment_due_date" => date('Y-m-d'),
                    "duration_measure" => "0"
                ],
                "customer" => $customer,
                "invoice_lines" => $invoice_lines,
                "tax_totals" => $tax_totals,
                "legal_monetary_totals" => $legal_monetary_totals
            ];

            // generar json de la factura Dian
            $jsonDian = json_encode($factura, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            //guardar en tabla facturas_electronicas
            $facturasElectronicas = new facturas_electronicas([
                'id_sucursalidfk'=>id_sucursal(),
                'id_estadoelectronica'=>1,
                'consecutivo_id'=>$consecutivo->id,
                'id_facturaid'=>33,  //id del pedido o orden generado en la tabla factura
                'id_adquiriente'=>1,
                'id_estadonota'=>1,
                'numero'=>$consecutivo->siguientevalor,
                'num_factura'=>$consecutivo->prefijo.'-'.$consecutivo->siguientevalor,
                'prefijo'=>$consecutivo->prefijo,
                'resolucion'=>$consecutivo->resolucion,
                'token_electronica'=>$compañia->token,  //token de la compañia
                'cufe'=>'',
                'qr'=>'',
                'fecha_factura'=>date('Y-m-d H:i:s'),
                'identificacion'=>$customer['identification_number'],
                'nombre'=>$customer['name'],
                'email'=>$customer['email'],
                'link'=>'',
                'nota_credito'=>'',
                'num_nota'=>'',
                'cufe_nota'=>'',
                'fecha_nota'=>'',
                'is_auto'=>1,   //cuando se envia de manera automatica es 1, si la factua se envia de manera manual es 0.
                'json_envio'=>$jsonDian,
                'respuesta_factura'=>'',
                'respuesta_nota'=>'',
                'intentos_de_envio'=>1,
                'fecha_ultimo_intento'=>date('Y-m-d H:i:s')
            ]);

            $r = $facturasElectronicas->crear_guardar();
            return $r[0];
        }else{  //resolucion desactivada en sistema
            return false;
        }
    } //fin metodo crear factura electronica


    protected static function createNcElectronic(array $carrito, stdClass $datosAdquiriente, $idconsecutivo):void
    {


    }
    

     protected static function sendInvoiceDian(array $carrito, stdClass $datosAdquiriente, $idconsecutivo):void
    {

        
    }

}