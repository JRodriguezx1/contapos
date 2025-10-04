<?php

	# Incluyendo librerias necesarias #
    require __DIR__ ."/code128.php";
    //require __DIR__ ."/../../public/build/img/logoj2blanco.png";

    class ticketPOS{
        
        private $pdf;

        public function __construct(){
            $this->pdf = new PDF_Code128('P','mm',array(80,258));
            $this->pdf->SetMargins(4,10,4);
            $this->pdf->AddPage();
        }


        public function generar($sucursal, $factura, $cliente, $direccion, $productos=[], $negocio=[]){
            $this->pdf->Image(__DIR__ . '/../../public/build/img/'.$negocio[0]->logo, 20, 5, 40, 28); // (ruta, x, y, ancho)
            $this->pdf->Ln(25);
            # Encabezado y datos de la empresa #
            $this->pdf->SetFont('Arial','B',10);
            $this->pdf->SetTextColor(0,0,0);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper($negocio[0]->nombre)),0,'C',false);
            $this->pdf->SetFont('Arial','',9);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","NIT: ".$negocio[0]->nit),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Direccion: ".$negocio[0]->direccion),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$negocio[0]->movil),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: ".$negocio[0]->email),0,'C',false);

            $this->pdf->Ln(1);
            $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(5);

            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".$factura->fechapago),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Caja: ".$factura->caja),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cajero: ".$factura->vendedor),0,'C',false);
            $this->pdf->SetFont('Arial','B',10);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Comprobante N°: ".$factura->num_orden)),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("FACTURA: ".$factura->prefijo.''.$factura->num_consecutivo)),0,'C',false);
            $this->pdf->SetFont('Arial','',9);

            $this->pdf->Ln(1);
            $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(5);

            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: ".$cliente->nombre),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Documento: ".$cliente->identificacion),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$cliente->telefono),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: ".$direccion->direccion.': '.$direccion->ciudad.' - '.$direccion->departamento),0,'C',false);

            $this->pdf->Ln(1);
            $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(3);

            # Tabla de productos #
            $this->pdf->SetFont('Arial','B',10);
            $this->pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
            $this->pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
            $this->pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1","Desc."),0,0,'C');
            $this->pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');
            $this->pdf->SetFont('Arial','',10);

            $this->pdf->Ln(3);
            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(3);



            /*----------  Detalles de la tabla  ----------*/
            foreach($productos as $value){
                $this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1", $value->nombreproducto),0,'C',false); //nombre producto
                $this->pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1", $value->cantidad),0,0,'C');  //cantidad
                $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($value->valorunidad, '0', ',', '.')),0,0,'C');  //precio unidad
                $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",$value->descuento),0,0,'C'); //descuento
                $this->pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($value->total, '0', ',', '.')),0,0,'C'); //precio total
                $this->pdf->Ln(4);
            }
            //$this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1","Garantía de fábrica: 2 Meses"),0,'C',false);
            $this->pdf->Ln(7);
            /*----------  Fin Detalles de la tabla  ----------*/



            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------------"),0,0,'C');

            $this->pdf->Ln(5);

            # Impuestos, descuentos & totales #
            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","+ $".number_format($factura->subtotal, '0', ',', '.')." COP"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","Impuesto"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","+ $".number_format($factura->valorimpuestototal, '0', ',', '.')." COP"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","Descuento"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","- $".number_format($factura->descuento, '0', ',', '.')." COP"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------------"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->SetFont('Arial','B',10);
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$".number_format($factura->total, '0', ',', '.')." COP"),0,0,'C');
            $this->pdf->SetFont('Arial','',10);

            $this->pdf->Ln(5);
            
            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL PAGADO"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$".number_format($factura->total, '0', ',', '.')." COP"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","CAMBIO"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$0.00 COP"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","USTED AHORRA"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$0.00 COP"),0,0,'C');

            $this->pdf->Ln(10);

            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);

            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su compra"),'',0,'C');

            $this->pdf->Ln(9);

            # Codigo de barras #
            $this->pdf->Code128(5,$this->pdf->GetY(),"COD000001V0001",70,20);
            $this->pdf->SetXY(0,$this->pdf->GetY()+21);
            $this->pdf->SetFont('Arial','',14);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","COD000001V0001"),0,'C',false);
            
            # Nombre del archivo PDF #
            $this->pdf->Output("I","Ticket_Nro_1.pdf",true);
        }
    }