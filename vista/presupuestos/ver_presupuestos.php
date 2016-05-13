<?php 
require_once '/../../php/objects/Presupuesto.php';
require_once '/../../php/objects/Articulo.php';
require_once '/../../php/objects/EtiquetaImpresa.php';
require_once '/../../php/globals/globals.php';

$presupuesto = new Presupuesto();
$articulo = new Articulo();
$etiqueta_impresa = new EtiquetaImpresa();
?>
<table>
<?php foreach($presupuesto->getPresupuestos() as $v){ 
$articulo->getArticulo($v['articulo_Id']);
$etiqueta_impresa->setEtiImpresaId($articulo->item_Id);
?>

<tr>
	<td colspan="6"><?php echo '<a href="admin.php?page=ver_detalle_presupuesto&presupuesto_Id='.$v['presupuesto_Id'].'">'.$etiqueta_impresa->nombre.'</a>'; ?></td>
</tr>
<tr>
	<td colspan="6"><?php echo $etiqueta_impresa->descripcion; ?></td>
</tr>
<tr>
	<td>Precio: </td><td><?php echo euros($v['precioMillar']); ?></td><td>Fecha: </td><td><?php echo fecha($v['fecha']); ?></td><td>Cantidad: </td><td><?php echo miles($v['cantidad']); ?></td>    	
</tr>
<tr>
<td colspan="6">-> </td>
</tr>
<?php } ?>
</table>

