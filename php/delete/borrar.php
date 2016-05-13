<?php 
// BORRAR ELEMENTO DEL CARRITO //
include_once('../objects/Carrito.php');
if(isset($_GET['carritoId'])){
	session_start();
	$_SESSION['carrito']->borraItem($_GET['carritoId']);
	header ('Location: ../../ES/index.php?page=4');
}else {echo ('El artículo no se ha podido borrar');}
?>