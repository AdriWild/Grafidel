<?php
$destino = '';
if(isset($_FILES["imagen"]))
{
	$tamanyo = $_FILES["imagen"]['size'];
	$tipo = $_FILES["imagen"]['type'];
	$nombreimg = $_FILES["imagen"]['name'];
	$ntemporal = $_FILES["imagen"]['tmp_name']; 
	
	$destino = $nombreimg;
	copy($_FILES["imagen"]['tmp_name'],$destino); // SUBE LA IMAGEN AL SERVIDOR
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<link href="../css/grafidel.css" rel="stylesheet" type="text/css">
<?php include ('../js/fancybox/fancybox.php'); ?>
</head>
<body>
<div style="background-color: white; width:400px; margin: 20px auto;">
	<form method="post" action="prueba.php" enctype="multipart/form-data">
	<input name="imagen" type="file">
    <input type="submit">
	</form>
<?php if($destino != ''){ ?>
<a class="fancybox-effects-d" title="Archivo = <?php echo $destino; ?>" href="<?php echo $destino; ?>"/><img width="100" src="<?php echo $destino; ?>" /></a>
<?php } ?>
</div>
<div style="background-color: white;"><a class="fancybox-effects-d" title="Archivo = noimage1.svg" href="<?php echo $destino; ?>"/><img width="100" src="noimage1.svg" /></a></div>
<div style="background-color: white;"><a class="fancybox-effects-d" title="Archivo = adrian.svg" href="<?php echo $destino; ?>"/><img width="100" src="adrian.svg" /></a></div>
</body>
