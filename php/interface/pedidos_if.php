<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/consults/consultasBD.php');

function verPedidosClientes(){ 
	echo '<div class="link1"><a href="admin.php?page=27&estado=Pendiente">Pendientes</a> | <a href="admin.php?page=27&estado=Produccion">Producción</a> | <a href="admin.php?page=27&estado=Enviado">Enviado</a></div>';
	echo '<br/><br/>';
	if (isset($_GET['estado'])){$estado = $_GET['estado'];} else{$estado = 'Pendiente';}
	verPedidosPendientes($estado);} // Selecciona el cliente para ver sus pedidos
	
function verPedidosPendientes($estado){
	echo '<table>';
	$clientes = getPedidosPorCliente($estado);
	foreach($clientes as $v){
		$cliente = verCliente($v['clienteId']);
		echo '<tr><td colspan="5"><h3>'.$cliente['empresa'].'</h3></td></tr>';
		$pedidos = getArticulosPorPedido($v['clienteId'], $estado);
		
		foreach($pedidos as $s){
			echo '<tr class="pedidos"><td colspan="3" align="left">'.'Nº Pedido: '.$s['npedido'];
			if($estado == 'Pendiente'){$ped_titulo='<td align="center">Producción</td><td align="center">Enviados</td>';}
			if($estado == 'Produccion'){$ped_titulo='<td>Pendientes</td><td align="center">Enviados</td>';}
			if($estado == 'Enviado'){$ped_titulo='<td align="center">Pendientes</td><td align="center">Producción</td>';}
			echo '</td><td width="55px" align="center">Cantidad</td><td width="55px" align="center">Precio</td><td width="20px"></td>'.$ped_titulo.'</tr>';
			$pedidos_pendientes = getPedidosPendientes($s['npedido'], $estado);
			$total=0;
			foreach($pedidos_pendientes as $r){
				$articulo = getArticulo($r['articuloId']);
				$total = $total + ($r['precio'] * $r['cantidad']);
				if($estado == 'Pendiente'){$botones='<td></td><td align="center"><a href="../php/update/cambiaestado.php?item='.$r['pedidoId'].'&estado=Produccion"><img src="../img/base/iconos/engine.png" height="15" /></a></td><td align="center"><a href="../php/update/cambiaestado.php?item='.$r['pedidoId'].'&estado=Enviado"><img src="../img/base/iconos/transport.png" height="15" /></a></td>';}
				if($estado == 'Produccion'){$botones='<td></td><td align="center"><a href="../php/update/cambiaestado.php?item='.$r['pedidoId'].'&estado=Pendiente"><img src="../img/base/iconos/clock.png" height="15" /></a></td><td align="center"><a href="../php/update/cambiaestado.php?item='.$r['pedidoId'].'&estado=Enviado"><img src="../img/base/iconos/transport.png" height="15" /></a></td>';}
				if($estado == 'Enviado'){$botones='<td></td><td align="center"><a href="../php/update/cambiaestado.php?item='.$r['pedidoId'].'&estado=Pendiente"><img src="../img/base/iconos/clock.png" height="15" /></a></td><td align="center"><a href="../php/update/cambiaestado.php?item='.$r['pedidoId'].'&estado=Produccion"><img src="../img/base/iconos/engine.png" height="15" /></a></td>';}
				echo '<tr>
				      	<td align="center" width="40px">
							<img src="../img/articulos/'.$articulo['imagen'].'" height="20px" />
						</td>
						<td align="center" width="40px">'
							.$r['articuloId'].'
						</td>
						<td>
							'.$articulo['nombre'].' '.$articulo['grupo'].' '.$articulo['descripcion'].'
						</td>
						<td align="center">
							'.$r['cantidad'].'
						</td>
						<td align="right">
							'.number_format($r['precio'], 2,",",".").'€
						</td>
						'.$botones.'
					</tr>';
			}
		}	
	}
	echo '</table>';	}
?>
