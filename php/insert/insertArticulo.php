<?php
require('../../php/database/grafidel_db.php');
global $conexion;
global $database;

$nombre=$_POST['nombre'];
$categoria=$_POST['cat'];
$marca=$_POST['marca'];
$descripcion=$_POST['descripcion']; 
$formato=$_POST['fprecio'];
$preciobase=$_POST['preciobase'];
$rmayorista=$_POST['rmayorista'];
$rpvp=$_POST['rpvp'];

if(isset($_POST['ofert'])){$oferta=1;}else{$oferta=0;}
if(isset($_POST['visible'])){$visible=1;}else{$visible=0;}

$tamanyo = $_FILES['imagen']['size'];
$tipo = $_FILES['imagen']['type'];
$nombreimg = $_FILES['imagen']['name'];
$ntemporal = $_FILES['imagen']['tmp_name']; 

$imgfolder = '';
switch($categoria){
	case 1:  $imgfolder = 'impresas/'; break;
	case 2:  $imgfolder = 'tejidas/'; break;
	case 3:  $imgfolder = 'adhesivas/'; break;
	case 4:  $imgfolder = 'adhesivasblanco/'; break;
	case 5:  $imgfolder = 'hojaslaser/'; break;
	case 6:  $imgfolder = 'sellos/'; break;
	case 7:  $imgfolder = 'sellosmanuales/'; break;
	case 8:  $imgfolder = 'ribbon/'; break;
	case 9:  $imgfolder = 'impresoras/'; break;
	case 10:  $imgfolder = 'poliamida/'; break;
	case 11:  $imgfolder = 'digital/'; break;
	case 12:  $imgfolder = 'web/'; break;
	case 13:  $imgfolder = 'rotulos/'; break;
	case 14:  $imgfolder = 'complementos/'; break;
}

$destino = '../img/articulos/'.$imgfolder.$nombreimg;

copy($_FILES['imagen']['tmp_name'],$destino);

mysql_select_db($database, $conexion);
$query=sprintf("INSERT INTO articulos (nombre, categoria, marca, descripcion, formatoprecio, imagen, preciobase, rmayorista, rpvp, oferta, visible)
		   VALUES (%s, %d, %s, %s, %d, %s, %f, %f, %f, %d, %d)",
		   GetSQLValueString($nombre,"text"),
		   GetSQLValueString($categoria,"int"),
		   GetSQLValueString($marca,"text"),
		   GetSQLValueString($descripcion,"text"),
		   GetSQLValueString($formato,"int"),
		   GetSQLValueString($imgfolder.$nombreimg,"text"),
		   GetSQLValueString($preciobase,"double"),
		   GetSQLValueString($rmayorista,"double"),
		   GetSQLValueString($rpvp,"double"),
		   GetSQLValueString($oferta,"int"),
		   GetSQLValueString($visible,"int"));
mysql_query($query) or die (mysql_error());

header('Location: ../ES/admin.php');
?>