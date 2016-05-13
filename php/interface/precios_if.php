<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/consults/consultasBD.php');

/* VER PRECIOS */
function verPxc(){
	echo '<p class="titulo_seccion">Precios</p>';
	if (isset($_GET['cliente']) && isset($_GET['grupo'])){verPreciosAgrupadosGrupo($_GET['cliente'], $_GET['grupo']);}
	if (isset($_GET['cliente']) && !isset($_GET['grupo'])){verPreciosAgrupadosCliente($_GET['cliente']);}
	if (!isset($_GET['cliente']) && !isset($_GET['grupo'])){verPreciosClientes();}
}

function verPreciosClientes(){
	$clientes = verPreciosPedidosClientes();
	foreach($clientes as $v){
		$nombre = verCliente($v['clienteId']);
		echo '<a href="admin.php?page=25&cliente='.$v['clienteId'].'">'.$nombre['empresa'].'</a><br />';
	}} /* Muestra los clientes que tienen al menos 1 artículo */ 
	
function verPreciosAgrupadosCliente($cliente){
	$grupos = verPreciosAgrupados($cliente);
	$nombre = verCliente($cliente);
	echo '<a href="admin.php?page=25">Clientes</a> > '.$nombre['empresa'].' ><br /><br />';
	foreach($grupos as $v){
		echo '<a href="admin.php?page=25&cliente='.$cliente.'&grupo='.$v['grupo'].'">'.$v['grupo'].'</a><br />';
	}}
	
function verPreciosAgrupadosGrupo($cliente, $grupo){
	$nombre = verCliente($cliente);
	$grupo = '"'.$grupo.'"';
	$articulos = verPreciosAgrupadosArticulos($cliente, $grupo);
		echo '<a href="admin.php?page=25">Clientes</a> > <a href="admin.php?page=25&cliente='.$cliente.'">'.$nombre['empresa'].'</a> > '.$grupo.'<br /><br />';
	
	?>	
		<table>
    	<tr class="pedidos">
        	<td width="9%">Fecha Pedido</td><td>Foto</td><td width="60%">Descripción</td><td width="6%">Cantidad</td><td width="6%">Precio</td><td width="6%">Total</td><td>Carrito</td><td>Eliminar</td>
        </tr>
        <tr>
        	<td height="10px"></td>
        </tr>
     <?php
	foreach($articulos as $v){
		$articulo = getArticulo($v['articuloId']);
		$categoria = verNomCatId($articulo['categoria']);
		$total=$v['precio'] * ($v['cantidad'] / 1000);
       	echo '<form>';
	    echo '<tr align="center">
				<form action="" method="post">
			  	<td>'.fecha($v['fecha']).'</td>
				<td><a class="fancybox-effects-d" href="../img/articulos/'.$articulo['imagen'].'" title="'.$v['descripcion'].'"/><img class="borde-foto" src="../img/articulos/'.$articulo['imagen'].'" height="35"/></a></td>
				<td align="left">'.$categoria['nomCategoria'].$v['descripcion'].'</td>
				<td>'.miles($v['cantidad']).'</td>
				<td>'.euros($v['precio']).'</td>
				<td>'.euros($total).'</td>
				<td><button><img src="../img/iconos/cart.png"/></button></td>
				<td><a href="../php/delete/borrar_presupuesto.php?presupuesto='.$v['pedidoId'].'&cliente='.$cliente.'&grupo='.$grupo.'"><img src="../img/web/borrar.png" width="10" height="10" /></a></td>
				</tr>
			  	<tr><td height="10px"></td>
				</tr>';
		echo '</form>';
	}
	echo '</table>';
}
?>