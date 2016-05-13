<?php
require_once ('../database/grafidel_db.php');
$prioridad = $_GET['prioridad'];
$com = $_GET['com'];
$db = new grafidelDB;

switch($prioridad){
case 3: $prioridad = '0'; break;
case 2: $prioridad = '3'; break;
case 1: $prioridad = '2'; break;
case 0: $prioridad = '1'; break;
}


$query = 'UPDATE comunicados SET prioridad = '.$prioridad.' WHERE com_Id='.$com;
$db->updateFromDB($query);
header ('Location: ../../ES/admin.php');
?>