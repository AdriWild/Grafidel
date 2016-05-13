<?php 
require_once '../php/database/grafidel_db.php' ;

session_start();

$db = new grafidelDB();
if (isset($_POST)){
if ($_POST['user_Id'] == $_SESSION['user_Id']){
	$db->updateEmpresa($_POST);
}}
header ('Location: ../../ES/index.php?page=empresa');
?>