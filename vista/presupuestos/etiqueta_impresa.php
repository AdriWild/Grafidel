<?php
require_once '/../../php/objects/Empresa.php';
require_once '/../../php/objects/EtiquetaImpresa.php';
require_once '/../../php/globals/globals.php';
$empresa = new Empresa();
$clientes = $empresa->verClientesActivos();
$etiqueta = new EtiquetaImpresa();
$cantidad = 1000;
if(isset($_POST['beneficio'])){ $beneficio = $_POST['beneficio']; } else { $beneficio = 0; }
$escalados = array(1000, 2500, 5000, 10000, 25000, 50000, 100000, 250000, 500000);
if(isset($_POST['cantidad'])){$cantidad = $_POST['cantidad'];}
if(isset($_POST['r1']) && $_POST['cambios'] > 0){
	$cantidad = 0;
	for($i=$_POST['cambios']; $i>0; $i--){
		$cantidad = $cantidad + $_POST['c'.$i]; 
	}$_POST['cantidad'] = $cantidad;	
} else {if(!isset($_POST['cantidad'])){$_POST['cantidad'] = 1000;}}
if(isset($_POST['nombre'])){$etiqueta->setEtiImpresaPost($_POST);}
?>
<script type="text/javascript"> 
	function envia() { document.eti_impresa.submit() }	
</script>
<form id="eti_impresa" name="eti_impresa" action="admin.php?page=nuevo_presupuesto_eti_impresa" method="post">
		<table width="80%">
   			<tr>
    			<td>Cliente: </td>
                <td><select name="cliente_Id" onChange="envia()"> 
						<?php foreach($clientes as $v){ 
								echo '<option value="'.$v['empresa_Id'].'"';
								if(isset($_POST['cliente_Id']) && $_POST['cliente_Id'] == $v['empresa_Id']){echo 'selected="selected"';}
								echo '>'.$v['nombre'].'</option>';
							  } 
						?>
					</select>
                </td>
   			    <td>Contacto:</td>
       			<td><input name="contacto" type="text" value="<?php if(isset($_POST['contacto'])){echo $_POST['contacto'];}?>" onChange="envia()"/></td>
            </tr>
    		<tr>
    			<td>Nombre: </td>
                <td><input name="nombre" type="text" value="<?php echo $etiqueta->nombre; ?>"/><input name="imagen" type="hidden" value=""></td>
				<td>Material: </td><td><select name="material" onChange="envia()">
        			<?php
							foreach($etiqueta->getListMateriales() as $v){
									echo ('<option value="').$v['material_Id'].('"');
									if(!empty($etiqueta->material) && $etiqueta->material==$v['material_Id'])
									{	echo ('selected="selected"'); }	
									echo ('>').$v['material'].('</option>');
							}?>
            		</select></td>
    		</tr>    
    		<tr>
    			<td>Ancho: </td>
                <td><select name="ancho" onChange="envia()">
        						<?php
									foreach($etiqueta->getAnchos($etiqueta->material) as $v){
										echo '<option value="'.$v['ancho'].'"';
										if(!empty($etiqueta->ancho) && $etiqueta->ancho == $v['ancho']){echo 'selected="selected"';}
										echo ('>').number_format(floatval($v['ancho']), 2,",",".").' mm.'.'</option>';
									}
								?>
       						</select></td>
        		<td>Alto: </td>
                <td> <select name="alto"  onChange="envia()">
        						<?php
								$etiqueta->getAltos();
									foreach($etiqueta->getAltos() as $v){
										echo '<option value="'.$v.'"';
										if($etiqueta->alto == $v){echo 'selected="selected"'; }
										echo '>'; 
										echo number_format(floatval($v), 2,",",".").' mm.'.'</option>';
									}
								?>
        					</select>
                        </td>
    			</tr>
    			<tr>
    				<td>Presentación: </td>
        			<td><select name="acabado"  onChange="envia()">
        				<?php 
							foreach($etiqueta->getAcabados() as $v){
								echo '<option value="'.$v['acabado_Id'].'"';
								if($etiqueta->acabado == $v['acabado_Id']){echo 'selected="selected"'; }
								echo '>'.$v['descripcion'].'</option>';
							}
						?>
      					</select>
                      </td>
                      <td>Impresiones: </td>
                    	<td><select name="impresiones"  onChange="envia()">
        				<?php foreach($etiqueta->getImpresiones() as $v){
							  	if($etiqueta->impresiones == $v['impresion_Id']){$selected = 'selected = "selected"';} else {$selected = '';}
							   echo '<option value="'.$v['impresion_Id'].'"'.$selected.'>'.$v['descripcion'].'</option>';} ?>
        				</select></td>
    			</tr>

                <tr>
    				<td>Descripci&oacute;n: </td>
        			<td colspan="3">
        			<textarea name="descripcion" cols="75" rows="2" type="text"><?php if($etiqueta->nombre != ''){echo 'Etiquetas '.$etiqueta->nombre.' de '.number_format(floatval($etiqueta->alto), 2,",",".").' x '.$etiqueta->ancho.' mm. impresas en '.$etiqueta->descripcionImpresion($etiqueta->impresiones).' Presentación: '.$etiqueta->descripcionAcabado($etiqueta->acabado).'. ';} ?></textarea>
     				 </td>
    			</tr>
   				 <tr>
						<td>Cambios:</td>
						<td><input id="cambios" name="cambios" type="text" value="<?php echo $etiqueta->cambios;?>" onChange="envia()"></td>                 
						<td>Clich&eacute;s:</td>
						<td><input name="cliches" type="text" value="<?php echo $etiqueta->getNumeroCliches();?>" readonly ></td>                 
				</tr>
                <?php if ($etiqueta->cambios == 0){;?>
   				 <tr>
                        <td>Cantidad: </td>
                        <td><input name="cantidad" type="text" value="<?php echo $cantidad; ?>" onChange="envia()"></td>
    			</tr> 	
				<?php } ?> 
<tr><td>Observaciones: </td><td colspan="3"><textarea name="observaciones" cols="75" rows="2" type="text" onChange="envia()"><?php if (isset($_POST['observaciones'])){echo $_POST['observaciones'];}?></textarea></td></tr>
</table>
<br>
<table>                
                <?php	if ($etiqueta->cambios > 0){
							for($i = $etiqueta->cambios; $i>0; $i--){
								echo '<tr><td><img src="../img/web/sublinea.png"/></td>';
								echo '<td>Referencia: </td>';
								echo '<td><input name="r'.$i.'" type="text" value="';
								if(isset($_POST['r'.$i])){ echo $_POST['r'.$i];}
								echo '"></td>';
								echo '<td>Cantidad: </td>';
								echo '<td><input name="c'.$i.'" type="text" value="';
								if(isset($_POST['c'.$i])){ echo $_POST['c'.$i];}
								echo '" onChange="envia()"></td></tr>';
							}
					}
				?>               

</table>    		
<br><br>            
<script type="text/javascript"> 
            	function cambiaBeneficio(precioCoste) { 
					res = (((document.getElementById("precio").value / precioCoste)-1)*100);
					document.getElementById("beneficio").value = res; 
					}
 </script>
    <table width="80%">
    <tr>
    	<td colspan="2"><table>
        	<?php if(isset($_POST['r1'])){?>
            <tr><td>Cantidad total: </td><td><input name="cantidad" id="cantidad" value="<?php echo $etiqueta->cantidad; ?>"readonly></td></tr>
			<?php }?>
    		<tr>
    			<td>Beneficio:</td><td><input id="beneficio" name="beneficio" type="text" value="<?php echo round($beneficio, 2); ?>" size="5" align="center"  onChange="envia()"/>%</td>
    		</tr>
			<?php 	
				$precioCoste = $etiqueta->calculaCoste($cantidad);
				$precioMillar = $etiqueta->calculaCoste($cantidad) * (1 + ($beneficio / 100));
			?>
            <tr>
    			<td>Precio:</td><td><input id="precio" onChange="cambiaBeneficio(<?php echo $precioCoste; ?>)" type="text" size="5" align="center"/></td>
    		</tr>
            <tr>
            	<td colspan="2"><br /></td>
            </tr>
    		<tr align="center">
    			<td colspan="2">Precio por millar</td>
    		</tr>
            <tr>
            	<td colspan="2" class="tp">
				<?php 	echo number_format($precioMillar,2,',','.').'€';
						echo ('<input name="coste" type="hidden" value="');
						echo $precioMillar;
						echo ('">'); ?></td>
            </tr>
    		<tr>
                <td colspan="2" align="center">Precio total</td>
            </tr>           
            <tr>
            	<td colspan="2" class="tp"><?php $precioTotal = ($precioMillar * ($cantidad / 1000)); echo number_format($precioTotal,2,',','.').'€'; ?></td>
			<input name="precioMillar" type="hidden" value="<?php echo $precioMillar; ?>" />
            <input name="precioTotal" type="hidden" value="<?php echo $precioTotal; ?>" />                
            </tr>
            <tr>
            <td colspan="2" align="center"><button type="submit" action="admin.php?page=nuevo_presupuesto_eti_impresa">Calcular precio</button></td>
            </tr>
        </table></td>
      	<td colspan="2"><table width="60%">
			    <tr align="center">
			    	<th width="20%">Cantidad</th><th width="20%">Precio millar:</th><th width="20%">Total</th>
			    </tr>
			<?php 
				global $escalados;
				foreach($escalados as $v){
					$precioMillar = $etiqueta->calculaCoste($v) * (1 + $beneficio / 100);
					$precioTotal = $precioMillar * ($v / 1000);
			    	echo '<tr align="center"><td>'.$v.'</td><td>'.number_format($precioMillar,2,',','.').'€'.'</td><td>'.number_format($precioTotal,2,',','.').'€'.'</td></tr>';
				}
			 ?>
			<tr>
				<td colspan="3" align="center">Precios orientativos seg&uacute;n cantidades.</td>
			</tr>
		</table></td>
	</tr>
</table>	
<?php	
//-------------- Muestra de la Etiqueta------------------------------//
	//----- Cambia la etiqueta de orientación según el tamaño -------//
	$ancho = floatval($etiqueta->ancho); 
	$alto = floatval($etiqueta->alto);
	?>
	<table>    
		<tr>
			<td rowspan="4">
				<div style="padding:20px; background-color:#FFF; overflow: auto;">
					<div style="position: absolute;  background-color:#FFF; border-style: solid; border-color:#666; border-width: 1px; width: <?php echo $ancho; echo('mm; height:'); echo $alto; echo('mm; z-index: 2;');?>"></div>
					<div style="position: relative;  background-color: #333; width: <?php echo $ancho; echo('mm; height:'); echo $alto; echo('mm; top: 4px; left: 4px; z-index: 1">'); ?>"> </div>
            	</div>
			</td>
		</tr>
        <table>
        <tr>
        	<td><input name="enviar" type="submit" formaction="../php/scripts/insert_etiqueta_impresa.php"/></td>
        </tr>
        </table>
</form>