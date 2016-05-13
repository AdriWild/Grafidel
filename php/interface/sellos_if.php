<?php
require_once('../php/objects/Articulo.php');
require_once('../php/consults/consultasBD.php');
require_once('../php/library/calculaPrecioCaucho.php');

function sellosAuto(){
$sellos = getSellos();
$precioCaucho = precioCaucho();
if (isset($_POST['sello'])){$sello = getSello($_POST['sello']);} else {$sello = $sellos[0];}
if (isset($_POST['cliente'])){$cliente = $_POST['cliente'];} else{$cliente = 1;}
if (isset($_POST['beneficio'])){$beneficio = $_POST['beneficio'];} else{$beneficio = beneficioPorCliente($cliente);}
if (isset($_POST['comision'])){$comision = $_POST['comision'];} else{$comision = comisionPorCliente();}
$precioCaucho = precioCaucho($sello['ancho'], $sello['alto']);
$coste = $sello['coste'] + $precioCaucho;
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
									if(!empty($cliente) && $v['userId']==$cliente){
										echo ('selected="selected"');
									}
									echo ('>');
									echo $v['empresa'];
									echo ('</option>');
								}
							  ?></select></td>
        <td>Agente: <?php 	$agente = getAgenteCliente($cliente);
									$nombreagente = verNombreUsuario($agente);
									echo $nombreagente[0]['nombre'];?></td>
    </tr>
    <tr>
    	<td>Sello: </td><td colspan="2"><select name="sello">
        <?php
			foreach($sellos as $v){
				echo '<option value="'.$v['sellos_Id'].'"';
				if(isset($_POST['sello']) && $v['sellos_Id']==$_POST['sello']){echo 'selected="selected"';}
				echo '>'.$v['marca'].' '.$v['sellos_Id'].' '.$v['tipo'].'</option>';
			}
		?>
        </select></td><td></td>
        <td></td>
    </tr>    
    <tr>
    	<td>Descripci&oacute;n: </td><td colspan="2"><input name="descripcion" type="text" size="60" value="<?php ?>"></td>
    </tr>
    <tr>
    	<td>Cantidad: </td><td><input name="cantidad" type="text" value="<?php if (isset($_POST['cantidad'])){echo $_POST['cantidad'];} else {echo '1';}?>"></td>
        <td>Colores:  <select name="color">
        							<option>Azul</option>
                                    <option>Negro</option>
                                    <option>Rojo</option>
                                    <option>Especial</option>
        					   </select></td>
    </tr>
    <tr>
        <td>Muestra: </td><td colspan="3"><input name="imagen" type="file" id="imagen"></td>
    </tr>
    <tr>
    	<td></td><td></td><td></td><td></td>
    </tr>
    </table>
    <table width="80%">
    <tr>
    	<td colspan="2"><table>
    		<tr>
    			<td>Beneficio:</td><td><input name="beneficio" type="text" value="<?php echo $beneficio; ?>" size="1" align="center"/>%</td><td>Precio: </td><td class="tp"><?php echo number_format(calculaPrecio($coste, $beneficio, $comision),2,',','.').'€'; ?></td>
    		</tr>
            <tr>
            	<td>Comisión Representante:</td><td ><input name="comision" type="text" value="<?php echo $comision; ?>" size="1" align="center"/>%</td><td>Precio Total: </td><td></td>
            </tr>
            <tr>
            	<td colspan="4"><button formaction="admin.php?page=6">Calcula Precio</button></td>
            </tr>
        </table></td>
      	<td colspan="2"></td>
	</tr>
</table>	

        	<td><button type="submit" formaction="../php/insert/insertSello.php">Enviar Presupuesto</button></td>

</form>
	<?php	
}
?>