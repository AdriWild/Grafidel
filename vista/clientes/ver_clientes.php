<div>
<div>Clientes frecuentes:</div>
<table>
<?php foreach ($empresa->verClientesActivos() as $v){?>
<tr>
	<td><?php echo $v['empresa_Id']; ?></td>
    <td><?php echo '<a href="admin.php?page=vista_cliente&cliente_Id='.$v['empresa_Id'].'">'.$v['nombre'].'</a>'; ?></td>
	<td><a href="mailto: <?php echo $v['email']; ?>"><?php echo $v['email']; ?></a></td>
	<td><?php echo $v['telefono']; ?></td>
    <td><a href="../php/scripts/empresas_activo.php?activo=1&cliente_Id=<?php echo $v['empresa_Id']; ?>"><img src="../img/iconos/ball_green.png" width="15" height="15" alt=""/></a></td>
</tr>
<?php	} ?>
</table>
</br></br>
<div>Clientes ocasionales:</div>
<table>
<?php foreach ($empresa->verClientesNoActivos() as $v){?>
<tr>
	<td><?php echo $v['empresa_Id']; ?></td>
	<td><?php echo '<a href="admin.php?page=vista_cliente&cliente_Id='.$v['empresa_Id'].'">'.$v['nombre'].'</a>'; ?></td>
	<td><a href="mailto: <?php echo $v['email']; ?>"><?php echo $v['email']; ?></a></td>
	<td><?php echo $v['telefono']; ?></td>    
    <td><a href="../php/scripts/empresas_activo.php?activo=0&cliente_Id=<?php echo $v['empresa_Id']; ?>"><img src="../img/iconos/ball_orange.png" width="15" height="15" alt=""/></a></td>
    <td><a href=""><img src="../img/web/borrar.png" width="10" alt=""/></a></td>
</tr>
<?php	} ?>
</table>
</div>