<?php
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class Categoria
{
	public $categoria_Id;
	public $nomCategoria;
	public $descripcion;
	public $imagen;
	public $imgdesc;
	public $tags;
	public $mostrar;
	public $especial;
	
	function getCategoria($categoria_Id){
		$categoria = grafidelDB::getFromDB('SELECT * FROM categorias WHERE categoria_Id = "'.$categoria_Id.'"');
		$this->categoria_Id = $categoria_Id;
		$this->nomCategoria = $categoria['nomCategoria'];
		$this->descripcion=$categoria['descripcion'];
		$this->imagen=$categoria['imagen'];
		$this->imgdesc=$categoria['imgdesc'];
		$this->tags=$categoria['tags'];
		$this->mostrar=$categoria['mostrar'];
		$this->especial = $categoria['especial'];
	}
	
	public function getCategorias(){
		return grafidelDB::getListFromDB('SELECT * FROM categorias');
	}
}

?>