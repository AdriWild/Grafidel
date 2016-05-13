<?php
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/database/grafidel_db.php');

$presupuesto = $_GET['presupuesto'];
$cliente = $_GET['cliente'];
$grupo = $_GET['grupo'];
$query = sprintf('DELETE FROM presupuestos WHERE presupuesto_id=%s', $presupuesto);
query($query);
header('Location: ../../ES/admin.php?page=30&cliente='.$cliente.'&grupo='.$grupo');
?>