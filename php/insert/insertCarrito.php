<?php
require_once('../../php/objects/Carrito.php');
session_start();
$articuloId = $_GET['articuloId'];
$precio = $_GET['precio'];
$cantidad = $_GET['cantidad'];
if(empty($_SESSION['carrito'])){$_SESSION['carrito'] = new carrito($articuloId, $precio, $cantidad);}
else{$_SESSION['carrito'] -> putArticulo($articuloId, $precio, $cantidad);}
header ('Location: ../../ES/index.php?page=4');
?>