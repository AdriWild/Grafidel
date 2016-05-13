<?php 
require_once '../../paginas/php/objects/Presupuesto.php';
require_once '../../paginas/php/objects/Articulo.php';
require_once '../../paginas/php/objects/EtiquetaImpresa.php';
require_once '../../paginas/php/globals/globals.php';

$presupuesto = new Presupuesto();
$articulo = new Articulo();
$etiqueta_impresa = new EtiquetaImpresa();

?>

<table>
<?php foreach($presupuesto->getPresupuestosCliente($_SESSION['empresa_Id']) as $v){ 
$articulo->getArticulo($v['articulo_Id']);

$etiqueta_impresa->setEtiImpresaId($articulo->item_Id);
//if ($etiqueta_impresa->getReferencias())
?>

<tr>
	<td colspan="6"><?php echo '<a href="index.php?page=ver_detalle_presupuesto_cliente&presupuesto_Id='.$v['presupuesto_Id'].'">'.$etiqueta_impresa->nombre.'</a>'; ?></td>
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

