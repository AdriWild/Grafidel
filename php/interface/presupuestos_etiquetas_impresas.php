<?php
require_once('../php/consults/consultasBD.php');
require_once('../php/library/calculaPrecio.php');

function verPresupuestoEtiquetaImpresa(){
	$etiqueta = $_POST;
	if(!isset($etiqueta['beneficio'])) {$beneficio = precioPorCliente($etiqueta['cliente']);}
	else {$beneficio = $etiqueta['beneficio'];}
	if(!isset($etiqueta['comision'])) {$comision = 0.10;}
	else {$comision = $etiqueta['comision'];}
	var_dump($etiqueta);
	
?>
<table width="60%">
	<tr>
    	<td>Cliente: </td><td colspan="3"><?php   $cliente = verCliente($etiqueta['cliente']);
												  echo  $cliente['empresa'];
							  			 ?>
                          </td>
    </tr>
    <tr>
    	<td>Descripci&oacute;n: </td><td colspan="3">
										<?php echo 'Etiqueta impresa en ';  
										$material = getMaterial($etiqueta['material']);
										echo $material['material'].' '.'de '.'';
										echo $etiqueta['ancho'].' x '.$etiqueta['alto'].' mm.';?>
                                      </td>
    </tr>
        <tr>
    	<td>Acabado: </td><td><?php $acabado=getAcabado($etiqueta['acabado']); 
									echo $acabado['tipo_acabado'];
							  ?></td><td>Cambios: </td><td><?php echo $etiqueta['cambios']; ?></td>
    </tr>
        <tr>
    	<td>Cantidad: </td><td><?php echo $etiqueta['cantidad']; ?></td><td>Colores: </td><td><?php echo $etiqueta['colores'];?></td>
    </tr>
    <tr>
   	  <td colspan="4"><form action="admin.php?page=1"><input type="submit" value="&lt; Editar etiqueta" /></form></td>
    </tr>
    <tr>
    	<td colspan="2"><table>
        	<form action="admin.php?page=29" method="post">
            <?php
			foreach($etiqueta as $key=>$v){
				echo ('<input name="').$key.('" value="').$v.('" type="hidden" />');
			}
			?>
    		<tr>
    			<td>Beneficio:</td><td><input name="beneficio" type="text" value="<?php echo $beneficio;?>" size="1" align="center"/>%</td>
    		</tr>
            <tr>
            	<td>Comisión Representante:</td><td ><input name="comision" type="text" value="<?php echo $comision; ?>" size="1" align="center"/>%</td>
            </tr>
            <tr>
            	<td colspan="2"><input name="Crear Presupuesto" type="submit"/></td>
            </tr>

            </form>
            <tr>
            	<td colspan="2"><br /></td>
            </tr>
    		<tr align="center">
    			<td colspan="2">Precio por millar</td>
    		</tr>
            <tr>
            	<td colspan="2" class="tp"><?php $precioMillar = calculaPrecio($etiqueta);
											echo number_format($precioMillar,2,',','.').'€';?></td>
            </tr>
    		<tr>
                <td colspan="2" align="center">Precio total</td>
            </tr>
            <tr>
            	<td colspan="2" class="tp"><?php echo number_format(calculaCosteTotal($precioMillar, $etiqueta['cantidad']),2,',','.').'€';?></td>
            </tr>
        </table></td>
      	<td colspan="2"><table width="30%">
			    <tr align="center">
			    	<th>Cantidad</th><th>Precio</th><th>Total</th>
			    </tr>
			<?php
				global $escalados;
				foreach($escalados as $v){
					$precioMillar =  ((1 + $beneficio) * calculaCoste($etiqueta, $v)) * (1 + $comision);
			    	echo '<tr align="center"><td>'.$v.'</td><td>'.number_format($precioMillar,2,',','.').'€'.'</td><td>'.number_format(calculaCosteTotal($precioMillar, $v),2,',','.').'€'.'</td></tr>';
				}
			?>
			<tr>
				<td colspan="3" align="center">Precios orientativos según cantidades.</td>
			</tr>
		</table></td>
	</tr>
</table>	
<?php	
//-------------- Muestra de la Etiqueta------------------------------//
	//----- Cambia la etiqueta de orientación según el tamaño -------//
	$ancho=$etiqueta['ancho']; 
	$alto=$etiqueta['alto'];
	if($alto > 70){
		$aux = $ancho;
		$ancho = $alto;
		$alto = $aux;
	}
	//----- Cantos redondeados si la etiqueta es Troquelada ---------//
	$radio = 0;
	if($etiqueta['acabado'] == 4){$radio = 10;}
	?>
	<table>    
		<tr>
			<td rowspan=4">
			<div style="padding:20px; background-color:#FFF; overflow: auto;">
			<div style="position: absolute; border-radius:<?php echo $radio;?>px; background-color:#FFF; border-style: solid; border-color:#666; border-width: 1px; width: <?php echo $ancho; echo('mm; height:'); echo $alto; echo('mm; z-index: 2;');?>"></div>
			<div style="position: relative; border-radius:<?php echo $radio;?>px; background-color: #333; width: <?php echo $ancho; echo('mm; height:'); echo $alto; echo('mm; top: 4px; left: 4px; z-index: 1">'); ?> </div></div>
			</td>
		</tr>
    </table>
    <table>
        <tr>
        	<td>
        	</td>
        </tr>
	</table>
	<?php
}
?>