<?php
require_once ('../database/grafidel_db.php');
$hecho = $_GET['hecho'];
$com = $_GET['com'];
$db = new grafidelDB;
$query = 'UPDATE comunicados SET hecho = "'.$hecho.'" WHERE com_Id = "'.$com.'"';
$db->updateFromDB($query);
header ('Location: ../../ES/admin.php');
?>