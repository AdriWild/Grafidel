<?php
require_once '../database/grafidel_db.php';
$activo = $_GET['activo'];
$cliente_Id = $_GET['cliente_Id'];
$db = new grafidelDB;

switch($activo){
case 1: $activo = '0'; break;
case 0: $activo = '1'; break;
}
$query = 'UPDATE empresas SET activo = "'.$activo.'" WHERE empresa_Id= "'.$cliente_Id.'"';
$db->updateFromDB($query);
var_dump($query);
header ('Location: ../../ES/admin.php?page=ver_clientes');
?>