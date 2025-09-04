<?php

	# Incluyendo librerias necesarias #
    require __DIR__ ."/code128.php";
    require __DIR__ ."/../public/build/img/logoj2blanco.png";

    class ticketPOS{
        
        private $pdf;

        public function __construct(){
            $this->pdf = new PDF_Code128('P','mm',array(80,258));
            $this->pdf->SetMargins(4,10,4);
            $this->pdf->AddPage();
        }


        public function generar(){
            $this->pdf->Image(__DIR__ . '/../public/build/img/logoj2blanco.png', 20, 5, 40); // (ruta, x, y, ancho)
            $this->pdf->Ln(20);
            # Encabezado y datos de la empresa #
            $this->pdf->SetFont('Arial','B',10);
            $this->pdf->SetTextColor(0,0,0);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Nombre de empresa")),0,'C',false);
            $this->pdf->SetFont('Arial','',9);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","RUC: 0000000000"),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Direccion San Salvador, El Salvador"),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: 00000000"),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: correo@ejemplo.com"),0,'C',false);

            $this->pdf->Ln(1);
            $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(5);

            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".date("d/m/Y", strtotime("13-09-2022"))." ".date("h:s A")),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Caja Nro: 1"),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cajero: Carlos Alfaro"),0,'C',false);
            $this->pdf->SetFont('Arial','B',10);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Ticket Nro: 1")),0,'C',false);
            $this->pdf->SetFont('Arial','',9);

            $this->pdf->Ln(1);
            $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(5);

            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: Carlos Alfaro"),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Documento: DNI 00000000"),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: 00000000"),0,'C',false);
            $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: San Salvador, El Salvador, Centro America"),0,'C',false);

            $this->pdf->Ln(1);
            $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(3);

            # Tabla de productos #
            $this->pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
            $this->pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
            $this->pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1","Desc."),0,0,'C');
            $this->pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');

            $this->pdf->Ln(3);
            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(3);



            /*----------  Detalles de la tabla  ----------*/
            $this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1","Nombre de producto a vender"),0,'C',false);
            $this->pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1","7"),0,0,'C');
            $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1","$10 USD"),0,0,'C');
            $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1","$0.00 USD"),0,0,'C');
            $this->pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1","$70.00 USD"),0,0,'C');
            $this->pdf->Ln(4);
            $this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1","Garantía de fábrica: 2 Meses"),0,'C',false);
            $this->pdf->Ln(7);
            /*----------  Fin Detalles de la tabla  ----------*/



            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

                $this->pdf->Ln(5);

            # Impuestos & totales #
            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","+ $70.00 USD"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","IVA (13%)"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","+ $0.00 USD"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$70.00 USD"),0,0,'C');

            $this->pdf->Ln(5);
            
            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL PAGADO"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$100.00 USD"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","CAMBIO"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$30.00 USD"),0,0,'C');

            $this->pdf->Ln(5);

            $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
            $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","USTED AHORRA"),0,0,'C');
            $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$0.00 USD"),0,0,'C');

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