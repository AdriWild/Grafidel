<?php 
require_once '../../vista/php/objects/Presupuesto.php';
require_once '../../vista/php/objects/Articulo.php';
require_once '../../vista/php/objects/EtiquetaImpresa.php';
require_once '../../vista/php/objects/Categoria.php';

$presupuesto = new Presupuesto();
$articulo = new Articulo();
$etiqueta_impresa = new EtiquetaImpresa();
$categoria = new Categoria();

if(isset($_GET['presupuesto_Id'])){ $presupuesto->setPresupuesto($presupuesto->getPresupuesto($_GET['presupuesto_Id']));}
$articulo->getArticulo($presupuesto->articulo_Id);
$etiqueta_impresa->setEtiImpresaId($articulo->item_Id);
$categoria->getCategoria($presupuesto->categoria);
$material = $etiqueta_impresa->getMaterial($etiqueta_impresa->material);
?>
<h1>Presupuesto de <?php echo $categoria->nomCategoria; ?></h1>
<table>
	<tr>
    	<td>Etiqueta: </td><td colspan="3"><?php  echo $etiqueta_impresa->nombre; ?></td><td rowspan="14" style="padding-left:160px"></td><td rowspan="10">
        	<table>
				<tr>
    				<td>Precio por millar: </td>
   				 </tr>
    			<tr>
    				<td class="tp"><?php echo number_format($presupuesto->precioMillar,2,',','.').'€'; ?></td>
    			</tr>
    			<tr>
    				<td>Precio total: </td>
    			</tr>
    			<tr>
       				 <td class="tp"><?php echo number_format($presupuesto->precioTotal,2,',','.').'€'; ?></td>
    			</tr>
			</table>
    </td>
	</tr>
   	<tr>
    	<td>Material: </td><td colspan="3"><?php  echo $material['material']; ?></td>
	</tr>
    <tr>
    	<td>Impresión : </td><td colspan="3"><?php  echo $etiqueta_impresa->descripcionImpresion($etiqueta_impresa->impresiones); ?></td>
	</tr>
    
    <tr>
    	<td>Presentaci&oacute;n : </td><td colspan="3"><?php  echo $etiqueta_impresa->descripcionAcabado($etiqueta_impresa->acabado); ?></td>
	</tr>
    <tr>
    	<td>Ancho: </td><td colspan="3"><?php  echo number_format($etiqueta_impresa->ancho,2,',','.'); ?> mm.</td>
    </tr>
    <tr>
    	<td>Alto: </td><td colspan="3"><?php  echo number_format($etiqueta_impresa->alto,2,',','.'); ?> mm.</td>
    </tr>
<?php 	if($etiqueta_impresa->cambios == 0){ echo '<tr><td>Cambios: </td><td>'.$etiqueta_impresa->cambios.'</td></tr>';} 
		else {
				echo '<td></td><td colspan="2">Referencia: </td><td>Cantidad: </td>';
				foreach ($presupuesto->getPresupuestos_ref() as $v){
					$ref = $etiqueta_impresa->getEti_impresa_ref($v['item_ref_Id']);
					echo '<tr><td><img src="../img/web/sublinea.png"/></td><td colspan="2">'.$ref['nombre'].'</td><td>'.number_format($v['cantidad'],0,',','.').'</td></tr>';
				}
		}
?>
	<tr>
    	<td colspan="2">Cantidad pedido:</td><td colspan="2"><?php echo number_format($presupuesto->cantidad,0,',','.'); ?></td>
    </tr>
    <tr>
    	<td colspan="2">Descargar presupuesto:</td><td colspan="2"><a href="/../../gen_pdf/presupuesto/gen_presupuesto.php?presupuesto_Id=<?php echo $presupuesto->presupuesto_Id; ?>" target="_blank"><img src="/../img/iconos/pdf_icon.png" width="18" height="18" alt=""/></a></td>
    </tr>
</table>