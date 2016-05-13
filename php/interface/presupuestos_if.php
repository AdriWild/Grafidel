<?php
require_once ('../php/database/grafidel_db.php');
require_once ('../php/consults/consultasBD.php');
require_once ('../php/objects/EtiquetaImpresa.php');
require_once ('../php/objects/EtiquetaAdhesiva.php');
require_once ('../php/objects/Usuario.php');
require_once ('../php/objects/Ribbon.php'); 


/* VER PRESUPUESTOS PENDIENTES */
function verPresupuestosPendientes(){
	echo '<p class="titulo_seccion">Presupuestos pendientes</p>';
	if (isset($_GET['cliente']) && isset($_GET['grupo'])){verPresupuestos($_GET['cliente'], $_GET['grupo']);}
	if (isset($_GET['cliente']) && !isset($_GET['grupo'])){verPresuGrupos($_GET['cliente']);}
	if (!isset($_GET['cliente']) && !isset($_GET['grupo'])){verPresuPendientes();}
}

function verPresuPendientes(){
	$presupuestos = verPresupuestosPorClientes();
	foreach($presupuestos as $v){
	$cliente = verCliente($v['clienteId']);
		echo '<a href="admin.php?page=30&cliente='.$v['clienteId'].'">'.$cliente['empresa'].'</a><br />';
	}}
function verPresuGrupos($cliente){
	$grupos = verPresupuestosAgrupados($cliente);
	$nombre = verCliente($cliente);
	echo '<a href="admin.php?page=30">Clientes</a> > '.$nombre['empresa'].' ><br /><br />';
	foreach($grupos as $v){
		echo '<a href="admin.php?page=30&cliente='.$cliente.'&grupo='.$v['grupo'].'">'.$v['grupo'].'</a><br />';
	}}
function verPresupuestos($cliente, $grupo){?>
    	
    </table>
 <?php	
	
	$nombre = verCliente($cliente);
	$presupuestos = verPresupuestosPorGrupoCliente($cliente, $grupo);
	echo '<a href="admin.php?page=30">Clientes</a> > <a href="admin.php?page=30&cliente='.$cliente.'">'.$nombre['empresa'].'</a> > '.$grupo.'<br /><br />';
	?>	
		<table>
    	<tr class="pedidos">
        	<td width="9%">Nº Presupuesto</td><td>Foto</td><td width="60%">Descripción</td><td width="6%">Cantidad</td><td width="6%">Precio</td><td width="6%">Total</td><td width="6%">A Pedido</td><td>Eliminar</td>
        </tr>
        <tr>
        	<td height="10px"></td>
        </tr>
     <?php
		foreach($presupuestos as $v){
			var_dump($v);
		$articulo = getArticulo($v['articuloId']);
		$categoria = verNomCatId($articulo['categoria']);
		$total=$v['precio'] * ($v['cantidad'] / 1000);
       	echo '<form>';
	    echo '<tr align="center">
			  	<td>'.$v['presupuesto_id'].'<br>'.fecha($v['fecha']).'</td>
				<td><a class="fancybox-effects-d" href="../img/articulos/'.$articulo['imagen'].'" title="'.$v['descripcion'].'"/><img class="borde-foto" src="../img/articulos/'.$articulo['imagen'].'" height="35"/></a></td>
				<td align="left">'.$categoria['nomCategoria'].$v['descripcion'].'</td>
				<td>'.miles($v['cantidad']).'</td>
				<td>'.euros($v['precio']).'</td>
				<td>'.euros($total).'</td>
				<td><a href="../php/insert/insertPedidoAdmin.php?articuloId='.$v['articuloId'].'&cliente='.$cliente.'&precio='.$v['precio'].'&cantidad='.$v['cantidad'].'&presupuesto='.$v['presupuesto_id'].'"><img src="../img/iconos/cart.png"/></a></td>
				<td><a href="../php/delete/borrar_presupuesto.php?presupuesto='.$v['presupuesto_id'].'"><img src="../img/web/borrar.png" width="10" height="10" /></a></td>
				</tr>
			  	<tr><td height="10px"></td>
				</tr>';
		}
		echo '</table>';
}
?>