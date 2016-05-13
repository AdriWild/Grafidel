<?php
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class Presupuesto
{
	public $presupuesto_Id;
	public $articulo_Id;
	public $cliente_Id;
	public $contacto;
	public $proveedor_Id;
	public $categoria;
	public $cantidad;
	public $precioMillar;
	public $precioTotal;
	public $pedido;
	public $observaciones;
	public $fecha;
	public $activo;
	public $confirmado;
	
	public function setPresupuesto($presupuesto){
		$this->presupuesto_Id = intval($presupuesto['presupuesto_Id']);
		$this->articulo_Id = intval($presupuesto['articulo_Id']);
		$this->cliente_Id = intval($presupuesto['cliente_Id']);
		$this->contacto = $presupuesto['contacto'];
		$this->proveedor_Id = intval($presupuesto['proveedor_Id']);
		$this->categoria = intval($presupuesto['categoria']);
		$this->cantidad = intval($presupuesto['cantidad']);
		$this->precioMillar = floatval($presupuesto['precioMillar']);
		$this->precioTotal = floatval($presupuesto['precioTotal']);
		$this->pedido = intval($presupuesto['pedido']);
		$this->observaciones = $presupuesto['observaciones'];
		$this->fecha = $presupuesto['fecha'];
		$this->activo = intval($presupuesto['activo']);
		$this->confirmado = intval($presupuesto['confirmado']);
	}
	
	public function getPresupuesto($presupuesto_Id){
		$query = 'SELECT * FROM presupuestos WHERE presupuesto_Id = "'.$presupuesto_Id.'"';
		return grafidelDB::getFromDB($query);
	}
	
	public function getPresupuestos(){
		$query = 'SELECT * FROM presupuestos';
		return grafidelDB::getListFromDB($query);
	}
	
	public function getPresupuestosCliente($cliente_Id){
		$query = 'SELECT * FROM presupuestos WHERE cliente_Id = "'.$cliente_Id.'"';
		return grafidelDB::getListFromDB($query);
	}
	
	public function insertPresupuesto(){
		$query = 'INSERT INTO presupuestos (presupuesto_Id, articulo_Id, cliente_Id, contacto, proveedor_Id, categoria, cantidad, precioMillar, precioTotal, observaciones) VALUES ("'.$this->presupuesto_Id.'", "'.$this->articulo_Id.'", "'.$this->cliente_Id.'", "'.$this->contacto.'", "'.$this->proveedor_Id.'", "'.$this->categoria.'", "'.$this->cantidad.'", "'.$this->precioMillar.'", "'.$this->precioTotal.'", "'.$this->observaciones.'")';
		return grafidelDB::insertDB($query);
	}
	
	public function insertPresupuesto_ref(){
		$query = 'INSET INTO presupuestos_ref () VALUES ()';
		return grafidelDB::insertDB($query);
	}
	
	public function getUltimoPresupuesto(){
		$query = 'SELECT MAX(presupuesto_Id) FROM presupuestos';
		$res = grafidelDB::getFromDB($query);
		return $res['MAX(presupuesto_Id)'];
	}
	
	public function getPresupuestos_ref(){
		$query = 'SELECT * FROM presupuestos_ref WHERE presupuesto_Id = '.$this->presupuesto_Id;
		return grafidelDB::getListFromDB($query);
	}
}
?>