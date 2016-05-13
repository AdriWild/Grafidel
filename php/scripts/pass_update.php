<?php
session_start();
require_once ('../database/grafidel_db.php');
$pass = md5($_POST['pass']);
$db = new grafidelDB;
$query = 'UPDATE usuarios SET pass = "'.$pass.'" WHERE user_Id='.$_SESSION['user_Id'];
$db->updateFromDB($query);
header ('Location: ../../php/scripts/salir.php');
?>