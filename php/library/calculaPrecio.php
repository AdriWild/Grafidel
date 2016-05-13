<?php
function calculaPrecio($coste, $beneficio, $comision){
	return $coste * (1 + $beneficio) * (1 + $comision);
}
?>