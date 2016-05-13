<?php
	$precioCliche = 6;
	$rColor = 0.025;
	$rCambio = 0.0;
	$anchos = array(10,12,15,20,25,30,35,40,50,60,70,80,100,110);// Anchos del material estándar.
	$escalados = array(1000, 2500, 5000, 10000, 25000, 50000, 100000, 250000, 500000); //Precios orientativos dependien de cantidades.
	$figuras = array(1,2,3,4,5,6,8,10,12); // Figuras según los rodillos de corte.
	$desarrollo = 220;
	$rmayorista = 0.40;
	$rpvp = 0.65;
	$comisionAgente = 0.1;
	$minCaucho = 5;
	$mm2Caucho = 0.003;
	
	function getRMayorista(){
		global $rmayorista;
		return $rmayorista;
	}
	
	function getRPvp(){
		global $rpvp;
		return $rpvp;
	}

// ----------- FORMATOS ---------------- //

	function fecha($fecha){
		return strftime("%d/%m/%y",strtotime($fecha));
	}
	
	function euros($precio){
		return number_format($precio, 2,",",".").'€';
	}
	
	function miles($cantidad){
		return number_format($cantidad, 0,",",".");
	}
?>