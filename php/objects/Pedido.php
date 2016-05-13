<?php 
require_once 'D:\wamp\www\Grafidel\php/database/grafidel_db.php';
$db = new grafidelDB;

class Pedido{
	var $pedidoId;
	var $npedido;
	var $clienteId;
	var $articuloId;
	var $precio;
	var $cantidad;
	var $fecha;
	var $estado;

	function __construct($pedido){
		
		$this->pedidoId = intval($this->getUltimoPedidoId())+1;
		$this->npedido = intval($this->getUltimoNpedido())+1; 
		$this->clienteId = $pedido['clienteId']; 
		$this->articuloId = $pedido['articuloId']; 
		$this->precio = $pedido['precio']; 
		$this->cantidad = $pedido['cantidad']; 
		$this->fecha = $pedido['fecha']; 
		$this->estado = $pedido['estado']; 
	}
	
	function insertPedido(){
		global $db;
		$query = 'INSERT INTO pedidos_c (npedido, clienteId, articuloId, precio, cantidad, fecha, estado) 
					VALUES ("'.$this->npedido.'", "'.$this->clienteId.'", "'.$this->articuloId.'", "'.$this->precio.'", "'.$this->cantidad.'", "'.$this->fecha.'", "'.$this->estado.'")';
		$db->insertDB($query);	
	}
	
	function borrarPedido(){}
	
	function getUltimoNpedido(){
		global $db;
		$query = 'SELECT (MAX(npedido)) FROM pedidos_c';
		return $db->getFromDB($query);
	}
	
	function getUltimoPedidoId(){
		global $db;
		$query = 'SELECT (MAX(pedidoId)) FROM pedidos_c';
		var_dump($db->getFromDB($query));
		return $db->getFromDB($query);
	}
}
?>