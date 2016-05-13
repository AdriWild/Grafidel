<?
require_once('/php/database/grafidel_db.php');
function insLog($usuario, $accion, $articulo, $cliente){
	global $database;
	global $conexion;
	mysql_select_db($database, $conexion);
	$query = sprintf('INSERT INTO log (usuario, accion, articulo, cliente) VALUES (%d, %s, %d, %d)', $usuario, $accion, $articulo, $cliente);
	mysql_query($query) or die (mysql_error());} // Inserta en la tabla log la acción.
?>