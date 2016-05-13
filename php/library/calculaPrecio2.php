<?php
require_once('../php/library/calculaCosteEtiquetaImpresa.php');
require_once('../php/library/precioPorCliente.php');

function calculaPrecio($etiqueta, $cliente, $beneficio, $comision, $cantidad){
	$cliente = verCliente($cliente);	
	if(!isset($beneficio)){
		if($cliente['usertype'] == 'Mayorista'){$beneficio = getRMayorista();}
		else {$beneficio = getRPvp();}
	}
	else {$beneficio = $beneficio;}
	
	if(!isset($comision)){$comision = getCAgente();}
	else {$comision = $comision;}
	$coste = $etiqueta->coste;
	if ($etiqueta->categoria==1){
	$coste = calculaCoste($etiqueta, $cantidad);
	}
	
	return $coste * (1 + $beneficio) * (1 + $comision);
}
?>