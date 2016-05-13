<?php
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class Comunicado extends grafidelDB
{	
	public function getComunicadosTodos(){
		return grafidelDB::getListFromDB('SELECT * FROM comunicados WHERE eliminado = 0');
	}
	
	public function getComunicados(){
		return grafidelDB::getListFromDB('SELECT * FROM comunicados WHERE eliminado = 0 AND  destinatario = 0 ORDER BY prioridad DESC, time ASC');
	}
	
	public function getComunicadosPropios($user_Id){
		return grafidelDB::getListFromDB('SELECT * FROM comunicados WHERE eliminado = 0 AND (destinatario = '.$user_Id.' OR user_Id = '.$user_Id.' AND destinatario != 0) ORDER BY prioridad DESC, time ASC');
	}
	
	public function getComunicadosAntiguos(){
		return grafidelDB::getListFromDB('SELECT * FROM categorias');
	}
	public function insertComunicado($query){
		return grafidelDB::insertDB($query);
	}
	public function updatePrioridad(){
	
	}
}

?>