<?php
require_once('../interface/interface.php');
// Obtener variables desde el post y comprobar
mysql_select_db($database, $conexion);
$sql=sprintf("SELECT user, email FROM usuarios WHERE user=%s OR email=%s", GetSQLValueString($_POST['user'],"text"), 
																		   GetSQLValueString($_POST['email'],"text"));
$result=mysql_query($sql, $conexion)or die(mysql_error());
$result=mysql_fetch_assoc($result);
if(empty($result)){ // Compara si existe el usuario o el email
	if(isset($_POST['pass']) && isset($_POST['pass2'])&& $_POST['pass']==$_POST['pass2']){$pass=$_POST['pass'];} else{echo "Las contraseña no coinciden";}
	if(isset($_POST['user'])){$user=$_POST['user'];} else{echo "El usuario no puede estar vacío";}
	if(isset($_POST['empresa'])){$empresa=$_POST['empresa'];} else{echo "El nombre de empresa no puede estar vacío";}
	if(isset($_POST['nombre'])){$nombre=$_POST['nombre'];} else{echo "El nombre de usuario no puede estar vacío";}
	if(isset($_POST['email'])){$email=$_POST['email'];} else{echo "El email no puede estar vacío";}
	if(isset($_POST['direccion'])){$direccion=$_POST['direccion'];} else{$direccion="";}
	if(isset($_POST['cp'])){$cp=$_POST['cp'];} else{$cp="";}
	if(isset($_POST['localidad'])){$localidad=$_POST['localidad'];} else{$localidad="";}
	if(isset($_POST['provincia'])){$provincia=$_POST['provincia'];} else{$provincia="";}
	if(isset($_POST['pais'])){$pais=$_POST['pais'];} else{$pais="";}
	if(isset($_POST['telefono'])){$telefono=$_POST['telefono'];} else{echo "El teléfono no puede estar vacío";}
	if(isset($_POST['fax'])){$fax=$_POST['fax'];} else{$fax="";}
	if(isset($_POST['web'])){$web=$_POST['web'];} else{$web="";}
	$usertype="Registrado";

	$sql=sprintf("INSERT INTO usuarios (user, empresa, nombre, pass, usertype, email, direccion, cp, localidad, provincia ,pais, telefono, fax, web) 
			 	 VALUES (%s,%s,%s,%s,%s,%s,%s,%d,%s,%s,%s,%d,%d,%s)", 
			  										GetSQLValueString($user,"text"),
			  										GetSQLValueString($empresa,"text"),
													GetSQLValueString($nombre,"text"),
													GetSQLValueString(md5($pass),"text"),
													GetSQLValueString($usertype,"text"),
													GetSQLValueString($email,"text"),
													GetSQLValueString($direccion,"text"),
													GetSQLValueString($cp,"int"),
													GetSQLValueString($localidad,"text"),
													GetSQLValueString($provincia,"text"),
													GetSQLValueString($pais, "text"),
													GetSQLValueString($telefono, "int"),
													GetSQLValueString($fax, "int"),
													GetSQLValueString($web,"text"));
	$insert_user=mysql_query($sql, $conexion)or die(mysql_error());
} else{echo "error usuario o email existente" /* error usuario o email existente */;}
	
 header("Location: ../ES/index.php");
?>