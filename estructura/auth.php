<?php
require_once ('../php/database/grafidel_db.php');
require_once ('../php/objects/Usuario.php');
require_once '../php/objects/Empresa.php'; 

$user = new Usuario();
$empresa = new Empresa();
session_start();

if (!isset($_SESSION['user_Id'])){
	if (isset($_POST['user'])) {
		if($user->userAuth($_POST['user'], md5($_POST['pass']))){
			$check = $user->userAuth($_POST['user'], md5($_POST['pass']));
			$user->setUsuario($check['user_Id']);
			$empresa->setEmpresa($empresa->usuarioEmpresa($user->user_Id));
			$_SESSION['user_Id'] = $user->user_Id;
			$_SESSION['user'] = $user->user;
			$_SESSION['usertype'] = $user->usertype;
			$_SESSION['empresa_Id'] = $empresa->usuarioEmpresa($user->user_Id);
			$_SESSION['carrito']= '';
			
			}else {echo 'login failed'; header('Location: index.php');}
	} 
} else {
	$user->setUsuario($_SESSION['user_Id']);
	$empresa->setEmpresa($_SESSION['empresa_Id']);
}

?>
