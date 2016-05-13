<?php 
require_once('C:/wamp/www/Grafidel/php/database/grafidel_db.php');
require_once('C:/wamp/www/Grafidel/php/consults/consultasBD.php');

class SelloAuto{
	var $articuloId;
	var $nombre;
	var $categoria;
	var $grupo;
	var $descripcion;
	var $formatoprecio;
	var $imagen;
	var $oferta;
	var $coste;
	var $visible;
	var $cantidad;
	var $stock;

	function __construct($articuloId){
		
		$this->articuloId = 0;
		$this->nombre = '';
		$this->categoria = '';
		$this->grupo = '';
		$this->descripcion = '';
		$this->formatoprecio = 1;
		$this->cantidad = 0;
		$this->imagen = '';
		$this->oferta = 0;
		$this->coste = 0;
		$this->visible = 0;
		$this->stock = 0;
	}
}
?>