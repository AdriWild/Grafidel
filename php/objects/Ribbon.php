<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/objects/Articulo.php');

class Ribbon extends articulo
{
	var $tipo;
	var $altura;
	var $longitud;
	var $preciom2;
	var $anchos = array(35, 45, 55, 65, 75, 95, 110);
	var $longitudes = array(100, 300, 600);
	function __construct($ribbon_Id, $nombre, $marca, $descripcion, $altura, $longitud)
	{
		global $conexion;
		global $database;
		mysql_select_db($database, $conexion);
		$query = sprintf("SELECT * FROM ribbon WHERE ribbon_Id=%d", $ribbon_Id);
		$result = mysql_query($query) or die (mysql_error());
		$resultset = mysql_fetch_assoc($result);
		$this->altura = $altura;
		$this->longitud = $longitud;
		$this->preciom2 = $resultset['preciom2'];
		$this->nombre = $nombre;
		$this->marca = $marca;
		$this->descripcion = $descripcion;
		$this->tipo = $resultset['ribbon_Id'];
		$this->formatoprecio = 4;
		$this->categoria = 8;
		$this->preciobase = $this->altura * $this->longitud * ($this->preciom2/1000000);
	}
	
	function calculaPreu()
	{
		return $preciobase;
	}
}
?>