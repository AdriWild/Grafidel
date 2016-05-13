<?php
require_once ('../php/consults/consultasBD.php');
require_once ('../php/globals/globals.php');
require_once ('../php/objects/EtiquetaTejida.php');

function etiqTejida(){	
// VALORES POR DEFECTO //
$etiqueta = new etiquetaTejida();

if(!empty($_POST)){
	$etiqueta->nombre = $_POST['nombre'];
	$etiqueta->material = $_POST['material'];
	$etiqueta->descripcion = $_POST['descripcion'];
	$etiqueta->ancho = $_POST['ancho'];
	$etiqueta->alto = $_POST['alto'];
	$etiqueta->cantidad = $_POST['cantidad'];
	$etiqueta->colores = $_POST['colores'];;
	$etiqueta->acabado = $_POST['acabado'];
	$etiqueta->grupo = $_POST['nombre'];
	$etiqueta->coste = $_POST['coste'];
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
									echo $nombreagente;?></td>
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
    	<td>Ancho: </td><td><input name="ancho" type="text" value="<?php	if(!empty($etiqueta->ancho)){echo $etiqueta->ancho;}?>"></td>
        <td>Alto: </td><td><input name="alto" type="text" value="<?php	if(!empty($etiqueta->alto)){echo $etiqueta->alto;}?>"></td>
    </tr>
    <tr>
    	<td>Cantidad: </td><td><input name="cantidad" type="text" value="<?php if(!empty($etiqueta->cantidad)){echo $etiqueta->cantidad;}?>"></td>
        <td>Colores: </td><td><input name="colores" type="text" value="<?php if(!empty($etiqueta->colores)){echo $etiqueta->colores;}?>"></td>
    </tr>
    <tr>
    	<td>Coste:</td><td><input name="coste" type="text" value="<?php if(!empty($etiqueta->coste)){echo $etiqueta->coste;}?>"/></td>
        <td>Proveedor:</td>
        <td><select name="proveedor">
			<?php
				$proveedores = verProveedores();
				echo '<option value="0"></option>';
				foreach($proveedores as $v){
					
					$empresa = verEmpresaUsuario($v['userId']);
					echo '<option value="'.$v['userId'].'">'.$empresa[0]['empresa'].'</option>';
				}
		 	?>
         	</select></td>
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
        <td>Imagen: </td><td><input name="imagen" type="file" id="imagen" value=""></td>
    </tr>
    <tr>
    	<td></td><td></td><td></td><td></td>
    </tr>
    </table>
    <br />
    <br />
    <table width="60%">
    	<tr align="center">
    			<td>Beneficio:<input name="beneficio" type="text" value="<?php echo $beneficio;?>" size="1" align="center"/></td>
            	<td>Comisión Representante:<input name="comision" type="text" value="<?php echo $comision; ?>" size="1" align="center"/></td>
        </tr>
        <tr><td colspan="2"><br /></td></tr>
    	<tr align="center">
    			<td>Precio por millar</td><td>Precio total</td>
    	</tr>
        <tr class="tp">
            	<td>
				<?php 	$precioMillar = calculaPrecio($etiqueta->coste, $beneficio, $comision);
						echo number_format($precioMillar,2,',','.').'€';
						echo ('<input name="precio" type="hidden" value="');
						echo $precioMillar;
						echo ('">'); ?></td><td><?php echo number_format(calculaCosteTotal($precioMillar, $etiqueta->cantidad),2,',','.').'€';?></td>
        </tr>
        <tr>
            <td colspan="4" align="center"><button type="submit" action="admin.php?page=2">Calcular precio</button></td>
        </tr>
      	<td colspan="2"></td>
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
        	<td><input type="submit" formaction="../php/insert/insertEtiTejida.php" value="Enviar Presupuesto" enctype="multipart/form-data"/></td>
        </tr>
        </table>
    </table>
</form>
<?php
}
?>