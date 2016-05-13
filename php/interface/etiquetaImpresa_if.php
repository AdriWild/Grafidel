<?php
require_once ('../php/consults/consultasBD.php');
require_once ('../php/globals/globals.php');
require_once ('../php/objects/EtiquetaImpresa.php');
require_once ('../php/library/calculaCosteEtiquetaImpresa.php');
require_once ('../php/library/precioPorCliente.php');
require_once ('../php/library/calculaPrecio.php');

function etiqTex(){	
// VALORES POR DEFECTO //
$etiqueta = new etiquetaImpresa();
if(!empty($_POST)){
	$etiqueta->nombre = $_POST['nombre'];
	$etiqueta->material = $_POST['material'];
	$etiqueta->descripcion = $_POST['descripcion'];
	$etiqueta->ancho = $_POST['ancho'];
	$etiqueta->alto = $_POST['alto'];
	$etiqueta->cantidad = $_POST['cantidad'];
	$etiqueta->colores = $_POST['colores'];
	$etiqueta->cambios = $_POST['cambios'];
	$etiqueta->cliches = $_POST['cliches'];
	$etiqueta->acabado = $_POST['acabado'];
	$etiqueta->grupo = $_POST['nombre'];
}
	if (!isset($_POST['cliente']) or $_POST['cliente']==''){$cliente = 0;}
	else{$cliente = $_POST['cliente'];}
	
	if (!isset($_POST['beneficio']) or $_POST['beneficio']==''){$beneficio = beneficioPorCliente($cliente);}
	else {$beneficio = $_POST['beneficio'];}
	
	if (!isset($_POST['comision']) or $_POST['comision']==''){$comision = comisionAgente($cliente);}
	else {$comision = $_POST['comision'];}
?>
<form id="calcprecio" name="calcprecio" method="post" enctype="multipart/form-data">
<input name="cliente" type="hidden" value="<?php echo $cliente; ?>" />
	<table width="80%">
    <tr>
    	<td>Cliente: </td><td><select name="cliente"> <?php 
								$lista=verClientes();
								foreach($lista as $key => $v){
									echo ('<option value="');
									echo $v['userId'];
									echo ('"');
									if(!empty($etiqueta) && $v['userId']==$cliente){
										echo ('selected="selected"');
									}
									echo ('>');
									echo $v['empresa'];
									echo ('</option>');
								}
							  ?></select></td>
        <td>Agente: </td><td><?php 	$agente = getAgenteCliente($cliente);
									$nombreagente = verNombreUsuario($agente);
									echo $nombreagente['nombre'];?></td>
    </tr>
    <tr>
    	<td>Nombre de etiqueta: </td><td><input name="nombre" type="text" value="<?php if(!empty($etiqueta->nombre)){echo $etiqueta->nombre;}?>"><input name="grupo" type="hidden" value="<?php if(!empty($etiqueta->grupo)){echo $etiqueta->grupo;}?>"></td><td>Material:</td>
        <td><select name="material">
        	<?php
				$materiales = getMateriales();
				foreach($materiales as $v){
					echo ('<option value="').$v['material_Id'].('"');
					if(!empty($etiqueta->material) && $etiqueta->material==$v['material_Id']){
						echo ('selected="selected"');
					}
					echo ('>').$v['material'].('</option>');
				}
			?>
            </select></td>
    </tr>    
    <tr>
    	<td>Descripci&oacute;n: </td><td colspan="3"><input name="descripcion" type="text" size="90" value="<?php if(!empty($etiqueta->descripcion)){echo $etiqueta->descripcion;}?>"></td>
    </tr>
    <tr>
    	<td>Ancho: </td><td><select name="ancho">
        						<?php
									$anchos = getAnchos();
									foreach($anchos as $v){
										echo ('<option value="').$v.('"');
										if(!empty($etiqueta->ancho) && $etiqueta->ancho==$v){
											echo ('selected="selected"');
										}
										echo ('>').number_format($v, 2,",",".").' mm.'.('</option>');
									}
								?>
       						</select></td>
        <td>Alto: </td><td> <select name="alto">
        						<?php
									$altos = getAltos();
									foreach($altos as $v){
										echo ('<option value="').$v.('"');
										if(!empty($etiqueta->alto) && $etiqueta->alto==$v){
											echo ('selected="selected"');
										}
										echo ('>'); 
										echo number_format($v, 2,",",".").' mm.'.('</option>');
									}
								?>
        					</select></td>
    </tr>
    <tr>
    	<td>Cantidad: </td><td><input name="cantidad" type="text" value="<?php 
			if(!empty($etiqueta->cantidad)){echo $etiqueta->cantidad;}
		?>"></td>
        <td>Colores: </td><td> <select name="colores"><?php
									$tintas = getTintas();
									foreach($tintas as $v){
										echo ('<option value="').$v['tintaId'].('"');
										if(!empty($etiqueta->colores) && $v['tintaId']==$etiqueta->colores){
											echo ('selected="selected"');
										}
										echo('>').$v['descripcion'].('</option>');
									}
								?></select></td>
    </tr>
    <tr>
    	<td>Cambios:</td><td><input name="cambios" type="text" value="<?php 
		if(!empty($etiqueta->cambios)){
			echo $etiqueta->cambios;
		}
		?>"></td><td>Clichés: </td>
        <td><input name="cliches" type="text" value="<?php 
		if(!empty($etiqueta->cliches)){
			echo $etiqueta->cliches;
		}
		?>" ></td>
    </tr>
    <tr>
    	<td>Acabado: </td>
        <td><select name="acabado">
        	<?php
			$acabados = getAcabados();
			foreach($acabados as $v){
				echo  ('<option value="').$v['acabadoId'].('"');
				if(!empty($etiqueta->acabado) && $etiqueta->acabado == $v['acabadoId']){
					echo ('selected="selected"');
				}
				echo('>').$v['tipo_acabado'].('</option>');
			}
			?>
        	</select></td>
        <td>Imagen: </td><td><input name="imagen" type="file"></td>
    </tr>
    <tr>
    	<td></td><td></td><td></td><td></td>
    </tr>
    </table>
    <table width="80%">
    <tr>
    	<td colspan="2"><table>
    		<tr>
    			<td>Beneficio:</td><td><input name="beneficio" type="text" value="<?php echo $beneficio;?>" size="1" align="center"/>%</td>
    		</tr>
            <tr>
            	<td>Comisión Representante:</td><td ><input name="comision" type="text" value="<?php echo $comision; ?>" size="1" align="center"/>%</td>
            </tr>
            <tr>
            	<td colspan="2"><br /></td>
            </tr>
    		<tr align="center">
    			<td colspan="2">Precio por millar</td>
    		</tr>
            <tr>
            	<td colspan="2" class="tp">
				<?php 	$coste = calculaCoste($etiqueta, $etiqueta->cantidad);
						$precioMillar = $coste * (1 + $beneficio);
						echo number_format($precioMillar,2,',','.').'€';
						echo ('<input name="precio" type="hidden" value="');
						echo $precioMillar;
						echo ('">'); ?></td>
            </tr>
    		<tr>
                <td colspan="2" align="center">Precio total</td>
            </tr>
            <tr>
            	<td colspan="2" class="tp"><?php $precioTotal = ($precioMillar * $etiqueta->cantidad) / 1000; echo number_format($precioTotal,2,',','.').'€'; ?></td>
            </tr>
            <tr>
            <td colspan="2" align="center"><button type="submit" action="admin.php?page=1">Calcular precio</button></td>
            </tr>
        </table></td>
      	<td colspan="2"><table width="60%">
			    <tr align="center">
			    	<th width="20%">Cantidad</th><th width="20%">Precio</th><th width="20%">Total</th>
			    </tr>
			<?php 
				global $escalados;
				foreach($escalados as $v){
					$coste = calculaCoste($etiqueta, $v);
					$precioMillar = $coste * (1 + $beneficio);
					$precioTotal = $precioMillar * $v / 1000;
			    	echo '<tr align="center"><td>'.$v.'</td><td>'.number_format($precioMillar,2,',','.').'€'.'</td><td>'.number_format($precioTotal,2,',','.').'€'.'</td></tr>';
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
	$ancho=$etiqueta->ancho; 
	$alto=$etiqueta->alto;
	if($alto > 70){
		$aux = $ancho;
		$ancho = $alto;
		$alto = $aux;
	}
	//----- Cantos redondeados si la etiqueta es Troquelada ---------//
	$radio = 0;
	if($etiqueta->acabado == 4){$radio = 10;}
	?>
	<table>    
		<tr>
			<td rowspan=4">
			<div style="padding:20px; background-color:#FFF; overflow: auto;">
			<div style="position: absolute; border-radius:<?php echo $radio;?>px; background-color:#FFF; border-style: solid; border-color:#666; border-width: 1px; width: <?php echo $ancho; echo('mm; height:'); echo $alto; echo('mm; z-index: 2;');?>"></div>
			<div style="position: relative; border-radius:<?php echo $radio;?>px; background-color: #333; width: <?php echo $ancho; echo('mm; height:'); echo $alto; echo('mm; top: 4px; left: 4px; z-index: 1">'); ?> </div></div>
			</td>
		</tr>
        <table>
        <tr>
        	<td><input name="enviar" type="submit" formaction="../php/insert/insertEtiImpresa.php"/></td>
        </tr>
        </table>
    </table>
</form>
<?php
}
?>