<?php
include_once('Articulo.php');
include_once('../database/grafidel_db.php');
class EtiquetaTextil extends Articulo{
	function CalculaPreu($cambios, $cortadas, $troqueladas, $dobladas, $tintaId, $alto, $ancho, $cantidad){
	global $conexion;
	global $database;
	
	$muestras = array(1000, 2500, 5000, 10000, 25000, 50000, 100000, 250000, 500000); //Precios orientativos dependiendo de cantidades.
	$anchos = array(10,12,15,20,25,30,35,40,50,60,70,80,100,110);// Anchos del material estándar.
	$figuras = array(1,2,3,4,5,6,8,10,12); // Figuras según los rodillos de corte.
	$altos = array(); // Arrays Constantes.
	
	mysql_select_db($database, $conexion);
	$pEtiqPoliester_query = "SELECT * FROM petiqpoliester";
	$pEtiqPoliester = mysql_query($pEtiqPoliester_query, $conexion) or die(mysql_error());
	$row_pEtiqPoliester = mysql_fetch_assoc($pEtiqPoliester);  // Consulta SQL Etiquietas de poliester.
	$tintas_query = "SELECT * FROM tintas";
	$tintas = mysql_query($tintas_query, $conexion) or die(mysql_error());
	$row_tintas = mysql_fetch_assoc($tintas); // Consulta base de datos tipos de tinta.
	$material=$row_pEtiqPoliester['preciomaterial'];
	$desarrollo=$row_pEtiqPoliester['desarrollo'];

	for($i=0;$i<sizeof($figuras);$i++)
	{$altos[$i] = round($desarrollo/$figuras[$i],2);}

	$manObra=$row_pEtiqPoliester['mano_obra'];
	$minimos=$row_pEtiqPoliester['minimos'];
	$desperdicio=$row_pEtiqPoliester['desperdicio'];
	
	$rmayorista=$row_pEtiqPoliester['rmayorista'];
	$rpvp=$row_pEtiqPoliester['rpvp'];
	$comision=$row_pEtiqPoliester['comision'];
	
	$cliche=$row_pEtiqPoliester['cliche'];	
	
	$rColor=$row_pEtiqPoliester['recargo_color'];
	$rCambios=$row_pEtiqPoliester['recargo_cambios']; // Obtiene variables desde la base de datos.
	
	$color_query = sprintf("SELECT * FROM tintas WHERE tintaId=%s", GetSQLValueString($tintaId,"int"));
	$color = mysql_query($color_query, $conexion) or die(mysql_error());
	$row_color = mysql_fetch_assoc($color); 
	$ntintas = $row_color['ntintas']; // Consulta SQL tintas.
	$pxc_query = sprintf("SELECT * FROM pxc WHERE userId=%s AND articuloId=1", GetSQLValueString($userId,"int"));
	$pxc = mysql_query($pxc_query, $conexion) or die(mysql_error());
	$row_pxc = mysql_fetch_assoc($pxc); 
	
	if(!empty($row_pxc)){$beneficio=$row_pxc['preciopersonal'];}
	else{
		if($usertype=='Mayorista') {$beneficio=$rmayorista;}
		else {$beneficio=$rpvp;}
	} // Consulta SQL precios por cliente.
	function calculaPreuEtiqueta($material,$alto, $ancho, $cantidad, $manObra, $minimos, $ntintas, $rColor, $cambios, $rCambios, $rDobladas, $rTroqueladas, $rCortadas, $beneficio, $cliche){	
		if ($cantidad < 1000) {$cantidad=1000;}
		$materialmm2 = $material / 1000000; // Coste de 1000 mm2 de tela.
		$PrecioEtiqBlanco = $materialmm2 *($alto * $ancho); // Coste de mil etiquetas en blanco.
		$metros=$cantidad/(1000/$alto); // Cantidad de metros del pedido		
		$CosteManoObra = $manObra * $metros;
		$recargos = (1 + (($ntintas * $rColor) + ($cambios * $rCambios) + $rDobladas + $rTroqueladas + $rCortadas));
		$costeCliches = $ntintas * $cliche;
		$costeUnidad = ($PrecioEtiqBlanco * $recargos);
		$costePedido = ($costeUnidad * $cantidad) + $CosteManoObra + $minimos + $costeCliches;
		$precioMillar = ($costePedido * (1 + $beneficio)/$cantidad) * 1000;
		return $precioMillar;
	} // Función calcular precio base.			
	function calculaPrecioTotal($precioMillar, $cantidad){
			return round($precioMillar * ($cantidad / 1000), 2);} // Función calcula precio total.
	$precioMillar = calculaPreuEtiqueta($material,$alto, $ancho, $cantidad, $manObra, $minimos, $ntintas, $rColor, $cambios, $rCambios, $rDobladas, $rTroqueladas, $rCortadas, $beneficio, $cliche); // Cálculo del precio.
} 
?>