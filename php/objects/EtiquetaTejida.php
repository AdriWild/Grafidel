<?php
require_once('../php/objects/Articulo.php');

class etiquetaTejida extends Articulo
{
	var $nombre;
	var $material;
	var $descripcion;
	var $ancho;				
	var $alto;
	var $cantidad;
	var $colores;				
	var $cambios;
	var $cliches;			
	var $acabado;
	var $coste;
	var $imagen;			

	
	function __construct(){
		
		// Variables de EtiquetaImpresa //
		$this->nombre = '';
		$this->material = '';
		$this->descripcion = '';
		$this->ancho = 15;
		$this->alto = 27.50;
		$this->cantidad = 1000;
		$this->colores = 1;
		$this->cambios = 1;
		$this->cliches = 1;
		$this->acabado = 2;
		$this->imagen = '';
		
		// Variables de Artículo //
		$this->categoria = '1';
		$this->grupo = '';
		$this->formatoprecio = 1;
		$this->oferta = 0;
		$this->coste = 0;
		$this->visible = 0;
		$this->stock = 0;
		
	}
}
?>