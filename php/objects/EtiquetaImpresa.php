<?php
require_once dirname(__FILE__).'/../database/grafidel_db.php';

class EtiquetaImpresa
{
	public $eti_impresa_Id;
	public $cliente_Id;
	public $nombre;
	public $material;
	public $descripcion;
	public $ancho;				
	public $alto;
	public $impresiones;				
	public $cambios;			
	public $acabado;
	public $imagen;
	public $beneficio;			

	public function EtiquetaImpresa(){
		$this->eti_impresa_Id = '';
		$this->cliente_Id = '';
		$this->nombre = '';
		$this->material = 1;
		$this->descripcion = '';
		$this->ancho = 10;
		$this->alto = 18.33;
		$this->impresiones = 1;
		$this->cambios = 0;
		$this->acabado = 1;
		$this->imagen = 'noimage.png';
		$this->beneficio = 40;
	}
	
	public function setEtiImpresaId($eti_impresa_Id){
		$query = 'SELECT * FROM eti_impresas WHERE eti_impresa_Id = "'.$eti_impresa_Id.'"';
		$etiqueta = grafidelDB::getFromDB($query);
		$this->eti_impresa_Id = intval($etiqueta['eti_impresa_Id']);
		$this->cliente_Id = intval($etiqueta['cliente_Id']);
		$this->nombre = $etiqueta['nombre'];
		$this->material = intval($etiqueta['material']);
		$this->descripcion = $etiqueta['descripcion'];
		$this->ancho = floatval($etiqueta['ancho']);
		$this->alto = floatval($etiqueta['alto']);
		$this->impresiones = intval($etiqueta['impresiones']);
		$this->cambios = intval($etiqueta['cambios']);
		$this->acabado = intval($etiqueta['acabado']);
		$this->imagen = $etiqueta['imagen'];
		$this->beneficio = floatval($etiqueta['beneficio']);
	}
		public function setEtiImpresaPost($post){
		$this->nombre = $post['nombre'];
		$this->cliente_Id = $post['cliente_Id'];
		$this->material = $post['material'];
		$this->descripcion = $post['descripcion'];
		$this->ancho = $post['ancho'];
		$this->alto = $post['alto'];
		$this->cantidad = $post['cantidad'];
		$this->impresiones = $post['impresiones'];
		$this->cambios = $post['cambios'];
		$this->acabado = $post['acabado'];
		if (isset($post['imagen'])){$this->imagen = $post['imagen'];}
		$this->beneficio = $post['beneficio'];
	}
	
	public function getMaxEtiquetaImpresa(){
		$query = 'SELECT MAX(eti_impresa_Id) FROM eti_impresas';
		return grafidelDB::getFromDB($query);
	}
	
	public function getMaxEtiquetaImpresaRef(){
		$query = 'SELECT MAX(eti_impresa_ref_Id) as max FROM eti_impresas_ref';
		return grafidelDB::getFromDB($query);
	}
	
	public function getListMateriales(){
		$query = 'SELECT * FROM materiales WHERE tipo = "Textil"';
		return grafidelDB::getListFromDB($query);
	}
	
	public function getMaterial($material_Id){
		$query = 'SELECT * FROM materiales WHERE material_Id = "'.$material_Id.'"';
		return grafidelDB::getFromDB($query);
	}
	
	public function descripcionMaterial($material_Id){
		$query = 'SELECT * FROM materiales WHERE material_Id = "'.$material_Id.'"';
		$res = grafidelDB::getFromDB($query);
		return $res['material'];
	}
	
	public function getAnchos($material_Id){
		$query = 'SELECT * FROM anchos_material WHERE material_Id = "'.$material_Id.'" ORDER BY ancho ASC';
		return grafidelDB::getListFromDB($query);
	}
	
	public function getAltos(){
		$v = array();
		$query = 'SELECT * FROM desarrollos WHERE tipo = "Textil"';
		$res = grafidelDB::getListFromDB($query);
		$desarrollo = $res[0];
		for($i = $desarrollo['max_figuras']; $i>0 ; $i--){
			array_push($v, ''.floatval($desarrollo['medida'] / $i)); 
		}
		return $v;
	}
	
	public function getImpresiones(){
		$query = 'SELECT * FROM impresiones';
		return grafidelDB::getListFromDB($query);
	}
	
	public function getImpresion($impresion_Id){
		$query = 'SELECT * FROM impresiones WHERE impresion_Id = "'.$impresion_Id.'"';
		$res = grafidelDB::getFromDB($query);
		return $res['nImpresiones'];
	}
	
	public function descripcionImpresion($impresion_Id){
		$query = 'SELECT * FROM impresiones WHERE impresion_Id = "'.$impresion_Id.'"';
		$res = grafidelDB::getFromDB($query);
		return $res['descripcion']; 
	}
	
	public function getAcabados(){
		$query = 'SELECT * FROM acabados';
		return grafidelDB::getListFromDB($query);
	}
	
	public function descripcionAcabado($acabado_Id){
		$query = 'SELECT * FROM acabados WHERE acabado_Id = '.$acabado_Id; 
		$res = grafidelDB::getFromDB($query);
		return $res['descripcion']; 
	}
	
	public function getNumeroCliches(){
		return $res = $this->cambios + $this->getImpresion($this->impresiones);
	}
	
	function calculaCoste($cantidad){
		$material = $this->getMaterial($this->material);																// Obtiene las características del material de la etiqueta.														// Obtiene los acabados posibles.
		$metrosPedido = $cantidad / (1000 / $this->alto);																// Calcula los metros necesarios para la realización del pedido.
		$costeManoObra = $metrosPedido * $material['mano_obra'];														// Calcula el precio de mano de obra de todo el pedido.
		$recargos = ($material['recargoCambio'] * $this->cambios) + ($this->impresiones * $material['recargoColor']);	// Calcula los recargos a aplicar por etiqueta.
		$materialmm2 = $material['precio'] / 1000000;																	// Calcula el precio del milímetro cuadrado de material.
		$costeBase = $materialmm2 * $this->alto * $this->ancho;															// Calcula el coste base de una etiqueta sin procesar.
		$costeUnidad = $costeBase * (1 + $recargos);																	// Calcula el coste de una etiqueta impresa.
		$costeMinimo = $material['minimos'] + ($this->getNumeroCliches() * $material['precioCliche']);					// Calcula el coste de poner el pedido en marcha.
		$costePedido = ($costeUnidad * $cantidad) + $costeMinimo + $costeManoObra;										// Calcula el coste del pedido entero.
		$costeMillar = $costePedido / ($cantidad / 1000);																// Calcula el coste del millar de etiquetas.
		return $costeMillar;	
	}
	
	function calculaCosteTotal(){
		return $this->calculaCoste($this->cantidad) * $this->cantidad;
	}
	
	public function getEti_impresa_ref($eti_impresas_ref_Id){
		$query = 'SELECT * FROM eti_impresas_ref  WHERE eti_impresa_ref_Id = '.$eti_impresas_ref_Id;
		return grafidelDB::getFromDB($query);
	}
	
	public static function insertEtiqueta($query){
		return grafidelDB::insertDB($query);
	}
}
?>