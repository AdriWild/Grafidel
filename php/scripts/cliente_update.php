<?php 
require_once '../../php/objects/Empresa.php';

session_start();
$empresa = new Empresa();
if (isset($_POST)){
if (isset($_POST['activo'])){$_POST['activo'] = '1';} else {$_POST['activo'] = '0';}
if ($_POST['user_Id'] == $_SESSION['user_Id']){
	$empresa->updateEmpresa($_POST);
}}
header ('Location: ../../ES/admin.php?page=ver_clientes');
?>