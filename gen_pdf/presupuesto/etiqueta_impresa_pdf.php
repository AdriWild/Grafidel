<?php
require_once '../tcpdf/tcpdf.php' ;
require_once '../../php/objects/Articulo.php';
require_once '../../php/objects/Usuario.php';
require_once '../../php/objects/Empresa.php';
require_once '../../php/objects/EtiquetaImpresa.php';
require_once '../../php/objects/Presupuesto.php';
require_once '../../php/globals/globals.php';

if (isset($_GET['presupuesto_Id']))
{
$presupuesto = new Presupuesto(); $presupuesto->setPresupuesto($presupuesto->getPresupuesto($_GET['presupuesto_Id']));
$articulo = new Articulo(); $articulo->getArticulo($presupuesto->articulo_Id);
$etiqueta_impresa = new EtiquetaImpresa(); $etiqueta_impresa->setEtiImpresaId($articulo->item_Id);
$empresa = new Empresa();
// Variables necesarias para generar el PDF 

$fecha = fecha($presupuesto->fecha);
$nom_empresa = $empresa->verNombreEmpresa($presupuesto->cliente_Id);
$contacto = $presupuesto->contacto;
$nombre_etiqueta = $etiqueta_impresa->nombre;
$material = utf8_encode($etiqueta_impresa->descripcionMaterial($etiqueta_impresa->material));
$medidas = number_format($etiqueta_impresa->ancho,2,',','.').' mm. x '.number_format($etiqueta_impresa->alto,2,',','.').' mm.';
$acabado = $etiqueta_impresa->descripcionAcabado($etiqueta_impresa->acabado);
$impresion = utf8_encode($etiqueta_impresa->descripcionImpresion($etiqueta_impresa->impresiones));
$cambios = $etiqueta_impresa->cambios;
$observaciones = $presupuesto->observaciones;
$cantidad = number_format($presupuesto->cantidad,0,',','.');
$precio = number_format($presupuesto->precioMillar,2,',','.').'€';
$total = number_format($presupuesto->precioTotal,2,',','.').'€';

// create new PDF document

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Grafidel');
$pdf->SetTitle('Presupuesto de Etiquetas Impresas');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);

$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

// set image scale factor

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage();

// NOTE: Uncomment the following line to rasterize SVG image using the ImageMagick library.
//$pdf->setRasterizeVectorImages(true);


$pdf->ImageSVG($file='../templates/logo_grafidel.svg', $x=8, $y=4, $w='', $h=40, $link='', $align='', $palign='', $border=0, $fitonpage=false);
$pdf->ImageSVG($file='titulo_presupuesto.svg', $x=75, $y=16, $w='', $h=23, $link='', $align='', $palign='', $border=0, $fitonpage=false);
$pdf->ImageSVG($file='cuerpo_presupuesto.svg', $x=6, $y=51, $w='', $h='', $link='', $align='', $palign='', $border=0, $fitonpage=false);

$pdf->SetFont('helvetica', '', 12);
$pdf->Text(169,52,$fecha);
$pdf->Text(50,61,$nom_empresa);
$pdf->Text(50,70,$contacto);
$pdf->Text(50,78,$nombre_etiqueta);
$pdf->Text(50,86,$material);
$pdf->Text(50,94,$medidas);
$pdf->Text(50,103,$acabado);
$pdf->Text(50,111,$impresion);
$pdf->Text(50,119,$cambios);
$pdf->SetFont('helvetica', '', 11);
$obsHTML = '<br><br><br><br><br><table><tr><td align="left">'.$observaciones.'</td></tr></table>';
$pdf->writeHTML($obsHTML, true, false, true, false, '');
$html = '<br><br><br><br><br><br><br><br>
<table>';
foreach($escalados as $v){
	$html = $html.'<tr><td align="right" width="130px" height="10px">'.number_format($v,0,',','.').'</td><td align="right" width="220px" height="10px">'.number_format($etiqueta_impresa->calculaCoste($v) * ( 1 + ($etiqueta_impresa->beneficio / 100)),2,',','.').'€'.'</td><td align="right" width="190px" height="10px">'.number_format($etiqueta_impresa->calculaCoste($v) * ( 1 + ($etiqueta_impresa->beneficio / 100)) * ($v / 1000),2,',','.').'€'.'</td></tr>';
}
$html = $html.'</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Text(39,240,$cantidad);
$pdf->Text(109,240,$precio);
$pdf->Text(174,240,$total);

$pdf->Output('D:\wamp\www\Grafidel\pdf/presupuestos/'.$presupuesto->presupuesto_Id.'.pdf', 'FI');


}


