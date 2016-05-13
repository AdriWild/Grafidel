<?php
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class Empresa
{
	public $empresa_Id;
	public $fiscal_Id;
	public $tipo;
	public $nombre;
	public $direccion;
	public $cp;
	public $localidad;
	public $provincia;
	public $pais;
	public $telefono;
	public $fax;
	public $email;
	public $web;
	public $activo;
	
	public function setEmpresa($empresa_Id){ // Rellena los datos de un usuario dependiendo de su user_Id
		$query = 'SELECT * FROM empresas WHERE empresa_Id = "'.$empresa_Id.'"';		  
		
		$empresa = grafidelDB::getFromDB($query);
		
		$this->empresa_Id = $empresa['empresa_Id'];
	 	$this->fiscal_Id = $empresa['fiscal_Id'];
	 	$this->tipo = $empresa['tipo'];
	 	$this->nombre = $empresa['nombre'];
	 	$this->direccion = $empresa['direccion'];
		$this->cp = $empresa['cp'];
	 	$this->localidad = $empresa['localidad'];
	 	$this->provincia = $empresa['provincia'];
	 	$this->pais = $empresa['pais'];
	 	$this->telefono = $empresa['telefono'];
	 	$this->fax = $empresa['fax'];
	 	$this->email = $empresa['email'];
	 	$this->web = $empresa['web'];
		$this->activo = $empresa['activo'];
		}
		
	public function usuarioEmpresa($user_Id){
		$query = 'SELECT e.empresa_Id
				  FROM empresas e, usuarios u, usuario_empresa ue 
				  WHERE e.empresa_Id = ue.empresa_Id AND u.user_Id = ue.user_Id AND u.user_Id = "'.$user_Id.'"';
		$res = grafidelDB::getFromDB($query);
		return  $res['empresa_Id'];
	}
	
	public static function verNombreEmpresa($empresa_Id){
		$query = 'SELECT nombre FROM empresas WHERE empresa_Id = '.$empresa_Id;
		$res = grafidelDB::getFromDB($query);
		return $res['nombre'];
	}
		
	public function updateEmpresa($post){
		$query = 'UPDATE empresas SET fiscal_Id = "'.$post['fiscal_Id'].'", tipo = "'.$post['tipo'].'", nombre = "'.$post['nombre'].'", direccion = "'.$post['direccion'].'", cp = "'.$post['cp'].'", localidad = "'.$post['localidad'].'", provincia = "'.$post['provincia'].'", pais = "'.$post['pais'].'", telefono = "'.$post['telefono'].'", fax = "'.$post['fax'].'", email = "'.$post['email'].'", web = "'.$post['web'].'", activo = "'.$post['activo'].'"
				  WHERE empresa_Id = "'.$post['empresa_Id'].'"';
		return  grafidelDB::updateFromDB($query);
		}
		
	public function verClientes(){
		$query = 'SELECT * FROM empresas WHERE tipo = "Cliente"';
		return grafidelDB::getListFromDB($query);
	}
	
		public function verClientesActivos(){
		$query = 'SELECT * FROM empresas WHERE tipo = "Cliente" AND activo = 1 ORDER BY nombre ASC';
		return grafidelDB::getListFromDB($query);
	}
	
		public function verClientesNoActivos(){
		$query = 'SELECT * FROM empresas WHERE tipo = "Cliente" AND activo = 0 ORDER BY nombre ASC';
		return grafidelDB::getListFromDB($query);
	}
	
		
}
?>