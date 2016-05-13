<?php 
require_once('../php/database/grafidel_db.php'); 
require_once('../php/consults/consultasBD.php');

function comunicador(){
	echo ('<form action="../php/insert/insertComunicado.php" method="post"><table width="80%">');
	echo ('<tr><td>Destinatario: </td><td>Tipo: </td><td>Prioridad: </td></tr>');
	echo('<tr><td><select name="destinatario">');
	$admins = verAdmins();
	var_dump($admins);
	foreach($admins as $v){
		echo '<option value="'.$v['userId'].'"';
		if($v['userId']=='0'){echo 'selected="selected"';}
		echo '>'.$v['nombre'].'</option>';
	}
	echo ('</select></td><td>
		   <select name="tipo">
		   		<option value="Pedido">Pedido</option>
				<option value="Presupuesto">Presupuesto</option>
				<option value="Consulta">Consulta</option>
				<option value="Reclamación">Reclamación</option>
				<option value="Reclamación">Contabilidad</option>
				<option value="Reclamación">Diseño</option>
		   </select></td><td><select name="prioridad">
		   		<option value="3">Urgentísimo</option>
				<option value="2">Urgente</option>
				<option value="1">Moderado</option>
				<option value="0">Sin prisa</option>
		   </select></td><td><input name="enviar" type="submit"></td></tr><tr><td colspan="4" align="center"><textarea name="mensaje" cols="90%" rows="4"></textarea><t7d></tr>');
	echo ('</table></form>');
	echo ('<table width="80%">');
	$grupo_comunicados = getGrupoComunicados(0);
	foreach($grupo_comunicados as $v)
	{
		$usuario = verCliente($v['userId']);
		echo ('<tr bgcolor="#CCCCCC"><td colspan="5">').$usuario['nombre'].('</td></tr>');
		$comunicados = getComunicados(0, $v['userId']);
		foreach($comunicados as $s)
		{
			if ($s['hecho']==1){$hecho = '<a href="../php/scripts/hecho.php?hecho=0&com='.$s['comId'].'"><img src="../img/iconos/verified.png" width="15" height="15" /></a>';}
			else {$hecho = '<a href="../php/scripts/hecho.php?hecho=1&com='.$s['comId'].'"><img src="../img/iconos/pendiente.png" width="15" height="15" /></a>';}
			if($s['prioridad']==3){$ball='<img src="../img/iconos/ball_red.png" width="15" height="15" />';}
			if($s['prioridad']==2){$ball='<img src="../img/iconos/ball_orange.png" width="15" height="15" />';}
			if($s['prioridad']==1){$ball='<img src="../img/iconos/ball_blue.png" width="15" height="15" />';}
			if($s['prioridad']==0){$ball='<img src="../img/iconos/ball_green.png" width="15" height="15" />';}

			echo ('<tr>');
			$tiempo = strftime('%e-%m %R', strtotime($s['time']));
				echo ('<td>').'<a href="../php/update/update_prioridad.php?com='.$s['comId'].'&prioridad='.$s['prioridad'].'">'.$ball.'</a>'.('</td>').('<td>').$hecho.('</td>').('<td class="mini_fecha" width="100px">').$tiempo.('</td>').('<td>').$s['texto'].('</td>').('<td>').$s['tipo'].('</td>').('<td><a href="../php/scripts/borra_com.php?eliminado=1&com=').$s['comId'].('"><img src="../img/web/borrar.png" width="10" height="10" /></a></td>');
			echo ('</tr>');
		}
	}
	echo ('</table></form>');
}

?>
