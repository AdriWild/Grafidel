<?php 
require_once '../objects/Perfil.php';
require_once '../objects/Usuario.php';
session_start();

$perfil = new Perfil();
$usuario = new Usuario();

if (isset($_POST)){
if ($_POST['user_Id'] == $_SESSION['user_Id']){
	$perfil->updatePerfil($_POST);
	$usuario->updateUsuario($_POST);
}}
header ('Location: ../../ES/index.php?page=perfil');
?>