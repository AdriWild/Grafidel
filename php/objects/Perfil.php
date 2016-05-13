<?php
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class Perfil
{
	public $email;
	public $direccion;
	public $cp;
	public $localidad;
	public $provincia;
	public $pais;
	public $telefono;
	public $web;
	
	public function setPerfil($user_Id){ // Rellena los datos de un usuario dependiendo de su user_Id
		$query = 'SELECT * FROM usuarios u, perfiles p WHERE u.user_Id = p.user_Id AND u.user_Id='.$user_Id; 
		$perfil = grafidelDB::getFromDB($query);
		/* USUARIO */
		$this->user_Id = $perfil['user_Id'];
		$this->user = $perfil['user'];
		$this->nombre = $perfil['nombre'];
		$this->apellidos = $perfil['apellidos'];
		$this->pass = $perfil['pass'];
		$this->usertype = $perfil['usertype'];
		$this->fecha = $perfil['fecha'];
		/* PERFIL */
		$this->email = $perfil['email'];
		$this->direccion = $perfil['direccion'];
		$this->cp = $perfil['cp'];
		$this->localidad = $perfil['localidad'];
		$this->provincia = $perfil['provincia'];
		$this->pais = $perfil['pais'];
		$this->telefono = $perfil['telefono'];
		$this->web = $perfil['web'];
		}
		
	public function updatePerfil($post){
		$query = 'UPDATE perfiles SET email = "'.$post['email'].'", direccion = "'.$post['direccion'].'", cp = "'.$post['cp'].'", localidad = "'.$post['localidad'].'", provincia = "'.$post['provincia'].'", pais = "'.$post['pais'].'", telefono = "'.$post['telefono'].'", web = "'.$post['web'].'" WHERE user_Id = "'.$post['user_Id'].'"';
		return  grafidelDB::updateFromDB($query);
		}	
}
?>