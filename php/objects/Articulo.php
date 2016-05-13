<?php 
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class Articulo
{
	public $articulo_Id;
	public $item_Id;
	public $categoria;
	public $imagen;
	public $oferta;
	public $visible;
	public $stock;
	
	public function setArticulo($item_Id, $categoria){ 
		$this->articulo_Id = intval($this->getUltimoArticulo() + 1);
		$this->item_Id = intval($item_Id);
		$this->categoria = intval($categoria);
	}

/*	public function setArticulo($articulo){
		$this->articulo_Id = $articulo['articulo_Id'];
		$this->item_Id = $articulo['item_Id'];
		$this->categoria = $articulo['categoria'];
		$this->imagen = $articulo['imagen'];
		$this->oferta = $articulo['oferta'];
		$this->visible = $articulo['visible'];
		$this->stock = $articulo['stock'];
	}*/
	
	public function getArticulo($articulo_Id){
		$articulo = grafidelDB::getFromDB('SELECT * FROM articulos WHERE articulo_Id = "'.$articulo_Id.'"');
		$this->articulo_Id = intval($articulo['articulo_Id']);
		$this->item_Id = intval($articulo['item_Id']);
		$this->categoria = intval($articulo['categoria']);
		$this->imagen = $articulo['imagen'];
		$this->oferta = intval($articulo['oferta']);
		$this->visible = intval($articulo['visible']);
		$this->stock = intval($articulo['stock']);
	}
	
	public function insertArticulo(){
		$query =  'INSERT INTO articulos (articulo_Id, item_Id, categoria) VALUES ("'.$this->articulo_Id.'","'.$this->item_Id.'", "'.$this->categoria.'")';
		return grafidelDB::insertDB($query);
	}
	
	public function getUltimoArticulo(){
		$query = 'SELECT MAX(articulo_Id) FROM articulos';
		$ultimo = grafidelDB::getFromDB($query);
		return $ultimo['MAX(articulo_Id)'];
	}
}
?>