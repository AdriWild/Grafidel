<?php 
require_once '../../paginas/php/objects/Perfil.php'; 
require_once '../../paginas/php/objects/Empresa.php'; 

$perfil = new Perfil();
$perfil->setPerfil($user->user_Id);
?>

<div>

<form action="../../paginas/php/scripts/perfil_update.php" method="post">
<table>
	<tr>
    	<td colspan="2"><h1><?php echo $empresa->nombre; ?></h1></td>
    </tr>
	<tr>
    	<td colspan="2">Usuario:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="user" type="text" id="user" value="<?php echo $perfil->user; ?>"></td>
    </tr>
	<tr>
    	<td>Nombre:</td><td>Apellidos:</td>
    </tr>
    <tr>
    	<td><input name="nombre" type="text" id="nombre" value="<?php echo $perfil->nombre; ?>"></td><td><input name="apellidos" type="text" id="apellidos" value="<?php echo $perfil->apellidos; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">Dirección:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="direccion" type="text" id="direccion" value="<?php echo $perfil->direccion; ?>" size="45"></td>
    </tr>
    <tr>
    	<td>C&oacute;digo Postal:</td><td>Localidad:</td>
    </tr>
    <tr>
    	<td><input name="cp" type="text" id="cp" value="<?php echo $perfil->cp; ?>"></td><td><input name="localidad" type="text" id="localidad" value="<?php echo $perfil->localidad; ?>"></td>
    </tr>
    <tr>
    	<td>Provincia:</td><td>País:</td>
    </tr>
    <tr>
    	<td><input name="provincia" type="text" id="provincia" value="<?php echo $perfil->provincia; ?>"></td><td><input name="pais" type="text" id="pais" value="<?php echo $perfil->pais; ?>"></td>
    </tr>
    <tr>
    	<td>E-mail:</td><td>Teléfono:</td>
    </tr>
    <tr>
    	<td><input name="email" type="text" id="email" value="<?php echo $perfil->email; ?>"></td><td><input name="telefono" type="text" id="fax" value="<?php echo $perfil->telefono; ?>"></td>
    </tr>
    <tr>
    	<td colspan="2">Web:</td>
    </tr>
    <tr>
    	<td colspan="2"><input name="web" type="text" id="web" value="<?php echo $perfil->web; ?>"></td><input name="user_Id" type="hidden" value="<?php echo $perfil->user_Id; ?>">
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
</br>
