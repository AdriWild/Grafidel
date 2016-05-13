<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/objects/Articulo.php');
require_once('../php/consults/consultasBD.php');
class carrito{
	var $carrito = array();
	function __construct($articuloId, $precio, $cantidad)
	{
		$articulos = array('articuloId' => $articuloId, 'cantidad' => $cantidad, 'precio' => $precio);	
		array_push($this->carrito, $articulos);	
	} // Inserta el artículo en el carrito
	
	function putArticulo($articuloId, $precio, $cantidad)
	{
		$articulos = array('articuloId' => $articuloId, 'cantidad' => $cantidad, 'precio' => $precio);	
		array_push($this->carrito, $articulos);	
	}
	 
	function insertPedido()
	{
		global $conexion;
		global $database;
		mysql_select_db($database, $conexion);
		$query = ("SELECT MAX(npedido) FROM pedidos_c");
		$result = mysql_query($query) or die ('No se ha podido obtener el último número de pedido');
		$resultset = mysql_fetch_assoc($result);
		$npedido = $resultset['MAX(npedido)'] +  1;
		foreach($_SESSION['carrito']->carrito as $v){
			$query = sprintf("INSERT INTO pedidos_c (npedido, clienteId, articuloId, cantidad, precio) 
						  VALUES(%d, %d, %d, %d, %f)",
						  GetSQLValueString($npedido, "int"),
						  GetSQLValueString($_SESSION['userId'], "int"),
						  GetSQLValueString($v['articuloId'], "int"),
						  GetSQLValueString($v['cantidad'], "double"),
						  GetSQLValueString($v['precio'], "double"));
			insertDB($query);
		}
		
	}
	function borraItem($carritoId){
			foreach($this->carrito as  $v){
					unset($this->carrito[$carritoId]);
					setcookie ("carrito", "", time() - 3600,"/");
			}
		}
	function vaciarCarrito()
	{
		setcookie("carrito", "", time() - 3600);
		unset($_COOKIE['carrito']);
		unset($this->carrito);
		$this->carrito = array();
	}
}
?>