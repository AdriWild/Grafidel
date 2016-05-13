<?php
require_once('../php/database/grafidel_db.php');
$nombre=$_POST['nombre_etiqueta'];
$cantidad=$_POST['cantidad2'];
$alto=$_POST['alto'];
$ancho=$_POST['ancho'];
$tintaId=$_POST['tintaId'];
$cambios=$_POST['cambios'];
$precioMillar=$_POST['preciomillar'];
$userId=$_POST['userId'];

if(isset($_POST['cortadas']) && $_POST['cortadas']==1){$cortadas=", cortadas";} else {$cortadas="";}
if(isset($_POST['troqueladas']) && $_POST['troqueladas']==1){$troqueladas=", troqueladas";} else {$troqueladas="";}
if(isset($_POST['dobladas']) && $_POST['dobladas']==1){$dobladas=", dobladas";} else {$dobladas="";}

mysql_select_db($database, $conexion);
$colores_query=sprintf("SELECT descripcion FROM tintas WHERE tintaId=%d",GetSQLValueString($tintaId,"int"));
$colores=mysql_query($colores_query)or die(mysql_error());
$row_colores=mysql_fetch_assoc($colores);

$descripcion=$alto.("mm. x ").$ancho.("mm. ").$row_colores['descripcion']." con ".$cambios." cambios".$cortadas.$dobladas.$troqueladas;
$formatoPrecio=1;
$categoria=1;
$marca='impresas';
$imagen='impresas/etitextil.png';

$sql=sprintf("INSERT INTO articulos (nombre, categoria, marca, descripcion, imagen, formatoPrecio, preciobase) 
			  VALUES (%s,%d,%s,%s,%s,%d,%.2f)", GetSQLValueString($nombre,"text"),
			  										GetSQLValueString($categoria,"int"),
													GetSQLValueString($marca,"text"),
													GetSQLValueString($descripcion,"text"),
													GetSQLValueString($imagen,"text"),
													GetSQLValueString($formatoPrecio, "int"),
													GetSQLValueString($precioMillar,"text"));
$insert_articulo=mysql_query($sql, $conexion)or die(mysql_error());
$last_articulo="SELECT MAX(articuloId)FROM articulos";
$last=mysql_query($last_articulo)or die (mysql_error());
$row_last=mysql_fetch_assoc($last);
$carrito=sprintf("INSERT INTO carrito (articuloId, usuarioId, precio, cantidad)
				 VALUES (%d, %s, %.2f, %.3f)", GetSQLValueString($row_last['MAX(articuloId)'],"int"), 
				                   GetSQLValueString($userId,"text"),
								   GetSQLValueString($precioMillar,"double"), 
								   GetSQLValueString($cantidad,"double"));
$insert_carrito=mysql_query($carrito, $conexion)or die(mysql_error());
header('Location: ../ES/index.php?page=4');
?>