<?php
require_once '../estructura/auth.php'; 
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<?php include '../estructura/meta.php'; ?>
	<title>Grafidel  -  Etiquetas y Complementos</title>
	<link href="../css/grafidel.css" rel="stylesheet" type="text/css">
	<?php include '../js/fancybox/fancybox.php'; ?>
</head>
<body>
<?php 
	include '../estructura/cabecera.php'; ?>
<div id="mig">
	<div id="contenedor">
	<?php 
	if (isset($_GET['page'])){$page = $_GET['page']; } else { $page = 'catagorias'; }
		switch($page){
			case 'categorias': 							include '../vista/categorias/categorias.php'; break;
			case 'miespacio': 							include '../vista/miespacio/miespacio.php'; break;
			case 'ver_presupuestos_cliente':  			include '../vista/miespacio/ver_presupuestos_cliente.php'; break;
			case 'ver_detalle_presupuesto_cliente':  	include '../vista/presupuestos/ver_detalle_presupuesto.php'; break; 
			case 'chart':								include '../vista/miespacio/chart.php'; break;
			case 'empresa':								include '../vista/miespacio/empresa.php'; break;
			case 'perfil':								include '../vista/miespacio/perfil.php'; break;
			case 'pass':								include '../vista/miespacio/pass.php'; break;
			case 'contacto': 							include '../vista/contacto/contacto.php'; break;
			default: 									include '../vista/categorias/categorias.php'; break;
		}?>
	
	</div>
</div>
<?php	include '../estructura/pie.php'; ?> 
</body>
</html>