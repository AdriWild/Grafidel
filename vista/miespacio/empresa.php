<div>

<form action="../../paginas/php/scripts/empresa_update.php" method="post">
<table>
	<tr>
    	<td>Empresa:</td><td>Identificación fiscal:</td>
    </tr>
    <tr>
    	<td><input name="nombre" type="text" id="nombre" value="<?php echo $empresa->nombre; ?>"></td><td><input name="fiscal_Id" type="text" id="fiscal_Id" value="<?php echo $empresa->fiscal_Id; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">Tipo:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="tipo" type="text" id="tipo" value="<?php echo $empresa->tipo; ?>" size="45" readonly></td>
    </tr>
    <tr>
    	<td colspan="2">Direcci&oacute;n de facturación:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="direccion" type="text" id="direccion" value="<?php echo $empresa->direccion; ?>" size="45"></td>
    </tr>
    <tr>
    	<td>C&oacute;digo Postal:</td><td>Localidad:</td>
    </tr>
    <tr>
    	<td><input name="cp" type="text" id="cp" value="<?php echo $empresa->cp; ?>"></td><td><input name="localidad" type="text" id="localidad" value="<?php echo $empresa->localidad; ?>"></td>
    </tr>
    <tr>
    	<td>Provincia:</td><td>Pa&iacute;s:</td>
    </tr>
    <tr>
    	<td><input name="provincia" type="text" id="provincia" value="<?php echo $empresa->provincia; ?>"></td><td><input name="pais" type="text" id="pais" value="<?php echo $empresa->pais; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">E-mail:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="email" type="text" id="email" value="<?php echo $empresa->email; ?>" size="45"></td>
    </tr>
    <tr>
    	<td>Teléfono:</td><td>Fax:</td>
    </tr>
    <tr>
    	<td><input name="telefono" type="text" id="fax" value="<?php echo $empresa->telefono; ?>"></td><td><input name="fax" type="text" id="fax" value="<?php echo $empresa->fax; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">Web:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="web" type="text" id="web" value="<?php echo $empresa->web; ?>" size="45"></td><input name="user_Id" type="hidden" value="<?php echo $user->user_Id; ?>"><input name="empresa_Id" type="hidden" value="<?php echo $empresa->empresa_Id; ?>"><input name="activo" id="activo" type="hidden" value="<?php echo $empresa->activo; ?>">
    </tr>
    <tr>
    	<td colspan="2"></br><input type="submit" value="Actualizar datos"></td>
    </tr>
    
</table>
</form>
</div>
</br>
</br>
</br>

