<?php
require_once ('../php/objects/Carrito.php');
function verCarrito(){
	$totalCarrito=0;
	if (isset($_COOKIE['carrito'])){$_SESSION['carrito']=unserialize($_COOKIE['carrito']);}
	if (!empty($_SESSION['carrito']) && !empty($_SESSION['carrito']->carrito)){
		echo ('<table width="90%">');
		echo ('<tr>');
		echo ('<th>Artículo</th><th>Descripción</th><th>Cantidad</th><th>Precio</th><th>Total</th><th></th>');
		echo ('</tr>');
		echo ('<tr>');
		echo ('<td colspan="5"><hr /></td>');
		echo ('</tr>');
		foreach($_SESSION['carrito']->carrito as $clave => $s){
			$articulo = getArticulo($s['articuloId']);
			if($articulo['formatoPrecio'] == 1) {$s['cantidad']= $s['cantidad']/1000;}
				echo ('<tr><td width="15%"><a class="fancybox-effects-d" href="../img/articulos/'.$articulo['imagen'].'" title="'.$articulo['descripcion'].'"/><img class="borde-foto" src="../img/articulos/'.$articulo['imagen'].'" height="35"/></a></td>');
				echo ('<td width="50%">');
				echo $articulo['descripcion'].(' ');
				echo ('</td>');
				echo ('<td>');
				echo number_format($s['cantidad'],0,",",".");
				echo ('</td>');
				echo ('<td>');
				echo number_format($s['precio'],2,",","."); echo ('€.');
				echo ('</td>');
				echo ('<td>');
				echo number_format($s['precio'] * $s['cantidad'], 2,",","."); echo ('€.');
				echo ('</td>');
				echo ('<td>');
				echo ('<a href="../php/delete/borrar.php?carritoId='); echo $clave; echo ('">'); echo ('<img src="../img/base/iconos/borrar.png"/></a>');
				echo ('</td>');
				echo ('</tr>');
				
				$totalCarrito=$totalCarrito + $s['precio'] * $s['cantidad'];
		}
			echo ('<tr>');
			echo ('<td colspan="5"><hr /></td>');
			echo ('</tr>');
			echo ('<tr>'); 
			echo ('<td colspan="3">'); 
			echo ('Total pedido'); 
			echo ('</td>'); 
			echo ('<td colspan:"2">'); 
			echo number_format($totalCarrito, 2,",","."); echo ('€.');
			echo ('</td>');
			echo ('</tr>');
			echo ('<tr><td colspan="5"><a href="../php/insert/insertPedido.php">Realizar Pedido</a></td></tr>');
			echo ('</table>');	
	}else {echo 'El carrito de la compra está vacío';}} // Vore carret de la compra.
?>