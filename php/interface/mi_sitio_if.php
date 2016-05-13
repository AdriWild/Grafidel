<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/consults/consultasBD.php');
require_once('../php/globals/globals.php');

function miEspacio(){
	echo '<p class="titulo_seccion">Mi Sitio</p>';
	echo '<div class="link1"><a href="index.php?page=13">Presupuestos</a> | <a href="index.php?page=12">Pedidos</a> | <a href="index.php?page=14">Pedidos anteriores</a> | <a href="index.php?page=10">Perfil</a></div>';
}

function miPerfil(){}
function misPresupuestos($cliente){
	miEspacio();
	$db = new grafidelDB;
	$query = 'SELECT p.presupuesto_id, p.fecha, p.articuloId, p.clienteId, p.descripcion, p.cantidad, p.categoria, p.precio, p.activo, a.formatoPrecio, a.imagen, a.oferta, p.proveedorId FROM presupuestos p, articulos a WHERE a.articuloId = p.articuloId AND p.activo=1 AND p.pedido = 0 AND p.clienteId ='.$cliente;
	$presupuestos = $db->getListFromDB($query);
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
		$total=$v['precio'] * ($v['cantidad'] / 1000);
       	echo '<form>';
	    echo '<tr align="center">
			  	<td>'.$v['presupuesto_id'].'<br>'.fecha($v['fecha']).'</td>
				<td><a class="fancybox-effects-d" href="../img/articulos/'.$v['imagen'].'" title="'.$v['descripcion'].'"/><img class="borde-foto" src="../img/articulos/'.$v['imagen'].'" height="35"/></a></td>
				<td align="left">'.$v['categoria'].$v['descripcion'].'</td>
				<td>'.miles($v['cantidad']).'</td>
				<td>'.euros($v['precio']).'</td>
				<td>'.euros($total).'</td>
				<td><a href="../php/insert/insertPedido.php?clienteId='.$v['clienteId'].'&articuloId='.$v['articuloId'].'&precio='.$v['precio'].'&cantidad='.$v['cantidad'].'&fecha='.$v['fecha'].'&presupuesto_id='.$v['presupuesto_id'].'&estado=pendiente"><img src="../img/iconos/cart.png"/></a></td>
				<td><a href="../php/delete/borrar_presupuesto.php?presupuesto='.$v['presupuesto_id'].'"><img src="../img/web/borrar.png" width="10" height="10" /></a></td>
				</tr>
			  	<tr><td height="10px"></td>
				</tr>';
		}
		echo '</table>';
}

function misPedidos($cliente){
	miEspacio();
	$db = new grafidelDB;
	$query = 'SELECT p.pedidoId, p.fecha, p.npedido, p.clienteId, a.descripcion, p.cantidad, p.precio, a.imagen, p.estado FROM pedidos_c p, articulos a WHERE a.articuloId = p.articuloId AND p.estado <> "enviado" AND p.clienteId ='.$cliente;
	$pedidos = $db->getListFromDB($query);
	?>
		<table>
    	<tr class="pedidos">
        	<td width="9%">Nº Pedido</td><td>Foto</td><td width="60%">Descripción</td><td width="6%">Cantidad</td><td width="6%">Precio</td><td width="6%">Total</td><td width="6%">Estado</td>
        </tr>
        <tr>
        	<td height="10px"></td>
        </tr>
     <?php
		
		foreach($pedidos as $v){
		$total=$v['precio'] * ($v['cantidad'] / 1000);
       	echo '<form>';
	    echo '<tr align="center">
			  	<td>'.$v['pedidoId'].'<br>'.fecha($v['fecha']).'</td>
				<td><a class="fancybox-effects-d" href="../img/articulos/'.$v['imagen'].'" title="'.$v['descripcion'].'"/><img class="borde-foto" src="../img/articulos/'.$v['imagen'].'" height="35"/></a></td>
				<td align="left">'.$v['descripcion'].'</td>
				<td>'.miles($v['cantidad']).'</td>
				<td>'.euros($v['precio']).'</td>
				<td>'.euros($total).'</td>
				<td>'.$v['estado'].'</td>
				</tr>
			  	<tr><td height="10px"></td>
				</tr>';
		}
		echo '</table>';
}
function misPedidosAnteriores($cliente){
	miEspacio();
	$db = new grafidelDB;
	$query = 'SELECT p.pedidoId, p.fecha, p.npedido, p.clienteId, a.descripcion, p.cantidad, p.precio, a.imagen, p.estado FROM pedidos_c p, articulos a WHERE a.articuloId = p.articuloId AND p.estado = "enviado" AND p.clienteId ='.$cliente;
	$pedidos = $db->getListFromDB($query);
	?>
		<table>
    	<tr class="pedidos">
        	<td width="9%">Nº Pedido</td><td>Foto</td><td width="60%">Descripción</td><td width="6%">Cantidad</td><td width="6%">Precio</td><td width="6%">Total</td><td width="6%">Estado</td>
        </tr>
        <tr>
        	<td height="10px"></td>
        </tr>
     <?php
		
		foreach($pedidos as $v){
		$total=$v['precio'] * ($v['cantidad'] / 1000);
       	echo '<form>';
	    echo '<tr align="center">
			  	<td>'.$v['pedidoId'].'<br>'.fecha($v['fecha']).'</td>
				<td><a class="fancybox-effects-d" href="../img/articulos/'.$v['imagen'].'" title="'.$v['descripcion'].'"/><img class="borde-foto" src="../img/articulos/'.$v['imagen'].'" height="35"/></a></td>
				<td align="left">'.$v['descripcion'].'</td>
				<td>'.miles($v['cantidad']).'</td>
				<td>'.euros($v['precio']).'</td>
				<td>'.euros($total).'</td>
				<td>'.$v['estado'].'</td>
				</tr>
			  	<tr><td height="10px"></td>
				</tr>';
		}
		echo '</table>';	
}
?>