<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/consults/consultasBD.php');
session_start();
global $conexion;
global $database;
$tipo = $_POST['tipo'];
$nombre = $_POST['nombre'];
$categoria = 8;
$marca = $_POST['marca'];
$descripcion = $_POST['descripcion'];
$formato = 4;

if(isset($_POST['ofert'])){$oferta = 1;}else{$oferta = 0;}
if(isset($_POST['visible'])){$visible = 1;}else{$visible = 0;}

$preciobase = $_POST['preciobase'];
$rmayorista = $_POST['rmayorista'];
$rpvp = $_POST['rpvp'];

$tamanyo = $_FILES['imagen']['size'];
$tipo = $_FILES['imagen']['type'];
$nombreimg = $_FILES['imagen']['name'];

$ntemporal = $_FILES['imagen']['tmp_name'];

$destino='../img/articulos/'.'ribbon/'.$nombreimg;

copy($_FILES['imagen']['tmp_name'],$destino);
$nombreimg = 'ribbon/'.$nombreimg;
mysql_select_db($database, $conexion);
$query=sprintf("INSERT INTO articulos (nombre, categoria, marca, descripcion, formatoprecio, imagen, preciobase, rmayorista, rpvp, oferta, visible)
		   VALUES (%s, %d, %s, %s, %d, %s, %f, %f, %f, %d, %d)",
		   GetSQLValueString($nombre,"text"),
		   GetSQLValueString($categoria,"int"),
		   GetSQLValueString($marca,"text"),
		   GetSQLValueString($descripcion,"text"),
		   GetSQLValueString($formato,"int"),
		   GetSQLValueString($nombreimg,"text"),
		   GetSQLValueString($preciobase,"double"),
		   GetSQLValueString($rmayorista,"double"),
		   GetSQLValueString($rpvp,"double"),
		   GetSQLValueString($oferta,"int"),
		   GetSQLValueString($visible,"int"));
mysql_query($query) or die (mysql_error());
$query = 'SELECT MAX(articuloId) FROM articulos';
$result = mysql_query($query) or die (mysql_error());
$resultset = mysql_fetch_assoc($result);
$articuloId = $resultset['MAX(articuloId)'];
insLog($_SESSION['userId'], '"Insertar Artículo"', $articuloId, $cliente="0");
header('Location: ../ES/admin.php');
?>


