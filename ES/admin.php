<?php
require_once '../php/objects/Usuario.php';
require_once '../estructura/auth.php';
if (!isset($_SESSION['user_Id'])){ header ('Location: index.php'); }
if ($_SESSION['usertype'] != 'Administrador' && $_SESSION['usertype'] != 'Editor'){ header ('Location: index.php'); } 
	
	
	

$user->visita($user->nombre);
$page = 0;
if (isset($_GET['page'])){$page = $_GET['page'];}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Menu de Administraci&oacute;n</title>
<link href="../css/grafidel.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
<?php include ('../js/fancybox/fancybox.php'); ?>
</head>
<body>
 <?php include '../estructura/cabecera_admin.php'; ?>      
<div id="mig">
	<div id="contenedor">
		<?php 
			if (isset($_GET['page'])){$page = $_GET['page']; } else { $page = 'comunicador'; }
			switch($page){
			case 'comunicador':  					include '../vista/comunicado/comunicado.php'; break;
			case 'ver_clientes':  					include '../vista/clientes/ver_clientes.php'; break;
			case 'vista_cliente':  					include '../vista/clientes/vista_cliente.php'; break;
			case 'ver_articulos':  					include '../vista/articulos/articulos_cliente.php'; break;
			case 'ver_presupuestos':  				include '../vista/presupuestos/ver_presupuestos.php'; break;
			case 'ver_detalle_presupuesto':  		include '../vista/presupuestos/ver_detalle_presupuesto.php'; break;
			case 'nuevo_presupuesto':  				include '../vista/presupuestos/etiqueta_impresa.php'; break;
			case 'nuevo_presupuesto_eti_impresa':	include '../vista/presupuestos/etiqueta_impresa.php'; break;
			default: 								include '../vista/comunicado/comunicado.php'; break;
		}?>
	</div>
</div>
<?php include '../estructura/pie.php'; ?>
</body>
</html>