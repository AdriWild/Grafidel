<?php
require_once ('../database/grafidel_db.php');
$db = new grafidelDB();
session_start();

if (isset($_POST)){
	if ($_POST['mensaje'] == '') { echo 'Mensaje vacío';}
	else {
	$destinatario = $_POST['destinatario'];
	$mensaje = '"'.$_POST['mensaje'].'"';
	$tipo = '"'.$_POST['tipo'].'"';
	$prioridad = $_POST['prioridad'];

	$query = 'INSERT INTO comunicados (user_Id, destinatario, texto, tipo, prioridad) VALUES ("'.$_SESSION['user_Id'].'", "'.$destinatario.'", '.$mensaje.', '.$tipo.', "'.$prioridad.'")';
	$db->insertDB($query);
	header ('Location: ../../ES/admin.php');
	}
}
else {echo 'Error al insertar comunicado.';}
?>