<?php
require_once('../php/globals/globals.php');
require_once('../php/consults/consultasBD.php');

function calculaCoste($etiqueta, $cantidad){
	global $precioCliche; 
	global $rColor;
	global $rCambio;
	if(!isset($cantidad)){
		$cantidad = $etiqueta['cantidad'];
	}
	$material = getMaterial($etiqueta->material);						// Obtiene las características del material de la etiqueta.
	$acabado = getAcabado($etiqueta->acabado);							// Obtiene los acabados posibles.
	$metrosPedido = $cantidad / 1000 / $etiqueta->alto;					// Calcula los metros necesarios para la realización del pedido.
	$costeManoObra = $metrosPedido * (1 + $material['mano_obra']);			// Calcula el precio de mano de obra para realizar el pedido.
	$recargos = $acabado['recargo'] + ($rCambio * $etiqueta->cambios) + ($etiqueta->colores * $rColor);
	$materialmm2 = $material['precio'] / 1000000;							// Calcula el precio del milímetro cuadrado de material.
	$costeBase = $materialmm2 * $etiqueta->alto * $etiqueta->ancho;		// Calcula el coste base de una etiqueta sin procesar.
	$costeUnidad = $costeBase * (1 + $recargos);							// Calcula el coste de una etiqueta impresa.
	$costeMinimo = $material['minimos'] + ($etiqueta->cliches * $precioCliche);	// Calcula el coste de poner el pedido en marcha.
	$costePedido = ($costeUnidad * $cantidad) + $costeMinimo;				// Calcula el coste del pedido entero.
	$costeMillar = $costePedido / ($cantidad / 1000);						// Calcula el coste del millar de etiquetas.
	return $costeMillar;	
}

function calculaCosteTotal($coste, $cantidad){
	return $coste * ($cantidad / 1000);
}
?>