<?php
require_once '../objects/Pedido.php';
require_once '../database/grafidel_db.php';
$db = new grafidelDB;
$pedido = new Pedido($_GET);
$pedido->insertPedido();
$query = 'UPDATE presupuestos SET pedido = 1 WHERE presupuesto_id ='.$_GET['presupuesto_id'];
var_dump($_GET);
$db->updateFromDB($query); 
header ('Location: ../../ES/index.php?page=12');
?>