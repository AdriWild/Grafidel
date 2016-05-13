<?php
include_once('../../php/objects/Carrito.php');
session_start();
if(isset($_SESSION['userId'])) //
{ 
	$_SESSION['carrito']->insertPedido();
	$_SESSION['carrito']->vaciarCarrito();
	setcookie('carrito','',time() - 3600,"/"); 
	header('Location: ../../ES/index.php?page=4');
}
/* else
{
	$galleta = serialize($_SESSION['carrito']);
	setcookie("carrito",$galleta,time()+60*60*24*7,"/");
	header('Location: ../../ES/index.php?page=1');
}
*/

?>