<?php 
require_once '/../../php/objects/Comunicado.php'; 
require_once '/../../php/objects/Empresa.php'; 

$comunicados = new Comunicado();
$list = $comunicados->getComunicados($user->user_Id);
$s = array();
foreach($list as $v){
array_push($s, $v['texto']);
}
?>
<script type="text/javascript">
	var comunicados = <?php echo json_encode($s) ?>;
</script>
<div id="prueba"></div>
<table id="messages" width=95% style="comunicados">
<?php	
		echo '<tr bgcolor="#CCCCCC"><td colspan="7">Grafidel</td></tr>';
		foreach($comunicados->getComunicados($user->user_Id) as $s)
		{
			if ($s['hecho']==1){$hecho = '<a href="../php/scripts/comunicados_hecho.php?hecho=0&com='.$s['com_Id'].'"><img src="../img/iconos/verified.png" width="15" height="15" /></a>';}
			else {$hecho = '<a href="../php/scripts/comunicados_hecho.php?hecho=1&com='.$s['com_Id'].'"><img src="../img/iconos/pendiente.png" width="15" height="15" /></a>';}
			if($s['prioridad']=='3'){$ball='<img src="../img/iconos/ball_red.png" width="15" height="15" />';}
			if($s['prioridad']=='2'){$ball='<img src="../img/iconos/ball_orange.png" width="15" height="15" />';}
			if($s['prioridad']=='1'){$ball='<img src="../img/iconos/ball_blue.png" width="15" height="15" />';}
			if($s['prioridad']=='0'){$ball='<img src="../img/iconos/ball_green.png" width="15" height="15" />';}
			
			$tiempo = new DateTime ($s['time']); $fecha = $tiempo->format('d-M H:i'); // Formato de la fecha
			echo ('<tr>');
				if($s['tipo'] == 'Presupuesto'){$s['texto'] = 'Pedido de '.Empresa::verNombreEmpresa($s['empresa_Id']).', número de pedido: '.'<a href="../../ES/admin.php?page=ver_detalle_presupuesto&presupuesto_Id='.$s['link'].'">'.$s['link'].'</a>';}
				if($s['tipo'] == 'Pedido'){$s['texto'];}
				echo '<td><a href="../php/scripts/comunicados_prioridad.php?com='.$s['com_Id'].'&prioridad='.$s['prioridad'].'">'.$ball.'</a></td><td>'.$hecho.'</td>'.'<td class="comunicados_fecha">'.$fecha.'</td>'.'<td class="comunicados_nombre">'.$user->getUserName($s['user_Id']).'</td>'.'<td class="comunicados_texto">'.$s['texto'].'</td><td class="comunicados_tipo">'.$s['tipo'].'</td>'.'<td class="comunicados_eliminar"><a href="../php/scripts/comunicados_borrar.php?com='.$s['com_Id'].'"><img src="../img/web/borrar.png" width="10" height="10" title="No se puede eliminar una tarea no finalizada"/></a></td>';
			echo ('</tr>');
		}
		echo '</table><table width=95% style="comunicados_table"></br></br>';
		echo '<tr bgcolor="#CCCCCC"><td colspan="7">'.$user->nombre.' '.$user->apellidos.'</td></tr>';
		foreach($comunicados->getComunicadosPropios($user->user_Id) as $s)
		{
			if ($s['hecho']==1){$hecho = '<a href="../php/scripts/comunicados_hecho.php?hecho=0&com='.$s['com_Id'].'"><img src="../img/iconos/verified.png" width="15" height="15" /></a>';}
			else {$hecho = '<a href="../php/scripts/comunicados_hecho.php?hecho=1&com='.$s['com_Id'].'"><img src="../img/iconos/pendiente.png" width="15" height="15" /></a>';}
			if($s['prioridad']=='3'){$ball='<img src="../img/iconos/ball_red.png" width="15" height="15" />';}
			if($s['prioridad']=='2'){$ball='<img src="../img/iconos/ball_orange.png" width="15" height="15" />';}
			if($s['prioridad']=='1'){$ball='<img src="../img/iconos/ball_blue.png" width="15" height="15" />';}
			if($s['prioridad']=='0'){$ball='<img src="../img/iconos/ball_green.png" width="15" height="15" />';}
			
			$tiempo = new DateTime ($s['time']); $fecha = $tiempo->format('d-M H:i'); // Formato de la fecha
			echo ('<tr>');
				echo '<td><a href="../php/scripts/comunicados_prioridad.php?com='.$s['com_Id'].'&prioridad='.$s['prioridad'].'">'.$ball.'</a></td><td>'.$hecho.'</td>'.'<td class="comunicados_fecha">'.$fecha.'</td>'.'<td class="comunicados_nombre_plus">'.$user->getUserName($s['user_Id']).' > '.$user->getUserName($s['destinatario']).'</td>'.'<td class="comunicados_texto">'.$s['texto'].'</td><td class="comunicados_tipo">'.$s['tipo'].'</td>'.'<td class="comunicados_eliminar"><a href="../php/scripts/comunicados_borrar.php?com='.$s['com_Id'].'"><img src="../img/web/borrar.png" width="10" height="10" title="No se puede eliminar una tarea no finalizada" /></a></td>';
			echo ('</tr>');
		}
		
?>
</table>
</br>
</br>
<form action="../php/scripts/comunicados_insert.php" method="post">
	<table width="70%">
		<tr><td>
        <select name="destinatario">
   	 	<?php
			
			foreach($user->verAdmins() as $v){
				echo '<option value="'.$v['user_Id'].'"';
				if($v['user_Id']=='0'){echo 'selected="selected"';}
				echo '>'.$v['nombre'].'</option>';
			} ?>
		</select>
        </td>
        <td>
		   <select name="tipo">
		   		<option value="Pedido">Pedido</option>
				<option value="Presupuesto">Presupuesto</option>
				<option value="Consulta">Consulta</option>
				<option value="Reclamación">Reclamaci&oacute;n</option>
				<option value="Contabilidad">Contabilidad</option>
				<option value="Diseño">Dise&ntilde;o</option>
		   </select>
         </td>
         <td><select name="prioridad">
		   		<option value="3">Urgent&iacute;simo</option>
				<option value="2">Urgente</option>
				<option value="1">Moderado</option>
				<option value="0" selected="selected">Sin prisa</option>
	   	  </select></td>
          <td colspan="4" align="center"><textarea name="mensaje" cols="68%" rows="1"></textarea></td><td><input name="enviar" type="submit" value="&gt;"></td>
      </tr>
	</table>
</form>
</br>
</br>