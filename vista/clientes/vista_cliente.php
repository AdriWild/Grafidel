<?php  
if (isset($_GET['cliente_Id'])){
$cliente = new Empresa();
$cliente->setEmpresa($_GET['cliente_Id']);
?>
<div>

<form action="../php/scripts/cliente_update.php" method="post">
<table>
	<tr>
    	<td>Empresa:</td><td>Identificación fiscal:</td>
    </tr>
    <tr>
    	<td><input name="nombre" type="text" id="nombre" value="<?php echo $cliente->nombre; ?>"></td><td><input name="fiscal_Id" type="text" id="fiscal_Id" value="<?php echo $cliente->fiscal_Id; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">Tipo:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="tipo" type="text" id="tipo" value="<?php echo $cliente->tipo; ?>" size="45" readonly></td>
    </tr>
    <tr>
    	<td colspan="2">Direcci&oacute;n de facturación:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="direccion" type="text" id="direccion" value="<?php echo $cliente->direccion; ?>" size="45"></td>
    </tr>
    <tr>
    	<td>C&oacute;digo Postal:</td><td>Localidad:</td>
    </tr>
    <tr>
    	<td><input name="cp" type="text" id="cp" value="<?php echo $cliente->cp; ?>"></td><td><input name="localidad" type="text" id="localidad" value="<?php echo $cliente->localidad; ?>"></td>
    </tr>
    <tr>
    	<td>Provincia:</td><td>Pa&iacute;s:</td>
    </tr>
    <tr>
    	<td><input name="provincia" type="text" id="provincia" value="<?php echo $cliente->provincia; ?>"></td><td><input name="pais" type="text" id="pais" value="<?php echo $cliente->pais; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">E-mail:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="email" type="text" id="email" value="<?php echo $cliente->email; ?>" size="45"></td>
    </tr>
    <tr>
    	<td>Teléfono:</td><td>Fax:</td>
    </tr>
    <tr>
    	<td><input name="telefono" type="text" id="fax" value="<?php echo $cliente->telefono; ?>"></td><td><input name="fax" type="text" id="fax" value="<?php echo $cliente->fax; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">Web:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="web" type="text" id="web" value="<?php echo $cliente->web; ?>" size="45"></td>
    <tr>
    	<td colspan="2">Activo: <input name="activo" type="checkbox" id="activo" <?php if($cliente->activo == 1){echo 'checked';} ?>></td>
    </tr>
    <tr>
    	<td colspan="2">
    </tr>
    <input name="user_Id" type="hidden" value="<?php echo $user->user_Id; ?>"> 			<!-- Campo oculto user_Id -->
    <input name="empresa_Id" type="hidden" value="<?php echo $cliente->empresa_Id; ?>">	<!-- Campo oculto empresa_Id -->
    </tr>
    <tr>
    	<td colspan="2"></br><input type="submit" value="Actualizar datos"></td>
    </tr>
    
</table>
</form>
</div>
<?php } ?>
</br>
</br>
</br>

