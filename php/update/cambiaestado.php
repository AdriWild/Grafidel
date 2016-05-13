<?php
require_once('../../php/database/grafidel_db.php');
if(isset($_GET)){
	$db = new grafidelDB;
	$estado = '"'.$_GET['estado'].'"';
	$item = $_GET['item'];


	$query = sprintf("UPDATE pedidos_c SET estado = %s WHERE pedidoId = %d ", $estado, $item);
	$db->updateFromDB($query);

header('Location: http://grafidel.com/ES/admin.php?page=27&estado='.$_GET['estado']);
}
?>