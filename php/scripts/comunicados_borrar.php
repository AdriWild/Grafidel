<?php
require_once ('../database/grafidel_db.php');
$com = $_GET['com'];
$db = new grafidelDB();
$query = 'UPDATE comunicados SET eliminado = 1 WHERE com_Id='.$com;
$db->updateFromDB($query);
header ('Location: ../../ES/admin.php');
?>