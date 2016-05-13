<?php
require_once('../php/globals/globals.php');

function precioCaucho($alto, $ancho){
	global $minCaucho;
	global $mm2Caucho;
	return ($ancho * $alto * $mm2Caucho) + $minCaucho;
}
?>