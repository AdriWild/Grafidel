<?php
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Grafidel');
$pdf->SetTitle('Parte de pedido');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);

$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage();

// NOTE: Uncomment the following line to rasterize SVG image using the ImageMagick library.
// $pdf->setRasterizeVectorImages(true);


$pdf->ImageSVG($file='templates/logo_grafidel.svg', $x=8, $y=4, $w='', $h=40, $link='', $align='', $palign='', $border=0, $fitonpage=false);
$pdf->ImageSVG($file='templates/titulo_parte.svg', $x=75, $y=16, $w='', $h=23, $link='', $align='', $palign='', $border=0, $fitonpage=false);

$pdf->SetFont('helvetica', '', 8);

$pdf->Output('D:\wamp\www\Grafidel\pdf/test/test.pdf', 'FI');



