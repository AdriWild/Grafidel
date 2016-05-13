<?php
require_once('../php/consults/consultasBD.php');

function beneficioPorCliente($userId){
	$cliente = verCliente($userId);
	if($cliente['usertype'] == 'Mayorista'){$recargo = getRMayorista();}
	else {$recargo = getRPvp();}
	return $recargo;
}

function comisionPorCliente(){
	return 0;
}
?>