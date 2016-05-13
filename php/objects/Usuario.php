<?php
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class Usuario
{
	public $user_Id;
	public $user;
	public $nombre;
	public $apellidos;
	public $pass;
	public $usertype;
	public $fecha;
	
	public function setUsuario($user_Id){ // Rellena los datos de un usuario dependiendo de su user_Id
		$query = 'SELECT * FROM usuarios WHERE user_Id = "'.$user_Id.'"'; 
		$usuario = grafidelDB::getFromDB($query);
		
		$this->user_Id = $usuario['user_Id'];
		$this->user = $usuario['user'];
		$this->nombre = $usuario['nombre'];
		$this->apellidos = $usuario['apellidos'];
		$this->pass = $usuario['pass'];
		$this->usertype = $usuario['usertype'];
		$this->fecha = $usuario['fecha'];
		}
		
	public function updateUsuario($post){
		$query = 'UPDATE usuarios SET user = "'.$post['user'].'", nombre = "'.$post['nombre'].'", apellidos = "'.$post['apellidos'].'" WHERE user_Id = "'.$post['user_Id'].'"'; 
		return  grafidelDB::updateFromDB($query);
	}
		
	public function userAuth($login, $pass){
		$query = 'SELECT * FROM usuarios WHERE user = "'.$login.'" AND pass="'.$pass.'"'; 
		return  grafidelDB::getFromDB($query);
		}	
		
	public function verUsuarios(){ // Devuelve una tabla asociativa con los datos de los usuarios
		$query = 'SELECT * FROM usuarios';
		return  grafidelDB::getListFromDB($query);
		}
		
	public function verAdmins(){ // Devuelve una tabla asociativa con los datos de los usuarios que sean Administradores o Editores
		$query = 'SELECT * FROM usuarios WHERE usertype="Administrador" OR usertype="Editor"';
		return grafidelDB::getListFromDB($query);
		}
		
	public function getUserName($user_Id){
		$query = 'SELECT nombre FROM usuarios WHERE user_Id = "'.$user_Id.'"';
		$res = grafidelDB::getFromDB($query);
		return $res['nombre'];
		}
		
	public function visita($nombre){
		$query = 'INSERT INTO visitas (user_Id) VALUES ("'.$nombre.'")';
		grafidelDB::insertDB($query);
		} 
}
?>