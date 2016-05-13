<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/objects/Articulo.php');
class etiquetaAdhesivaBlanca extends articulo
{
	//------------------- Variables del formulario ----------//
	var $alto;
	var $ancho;
	var $cambios;
	var $troqueladas;
	var $cantidad;
	//------------------- Constantes ------------------------//
	var $muestras;
	var $anchos;
	var $figuras;
	var $altos;
	//------------------- Variables de la base de datos -----//	
	var $material;
	var $desarrollo;	
	var $manObra;
	var $minimos;
	var $desperdicio;
	var $rmayorista;
	var $rpvp;
	var $comision;
	var $rTroqueladas;

	function __construct(){
		global $conexion;
		global $database;
		$tipo = 'poliester';
		mysql_select_db($database, $conexion);
		$query=sprintf("SELECT * FROM etiquetas WHERE tipo = %s", GetSQLValueString($tipo,"text"));
		$etiqueta=mysql_query($query, $conexion)or die(mysql_error());
		$resultset = mysql_fetch_assoc($etiqueta);
		
		if(isset($_POST['nombre_etiqueta'])){$this->nombre=$_POST['nombre_etiqueta'];}else{$this->nombre = '';}
		$this->categoria = 1;
		if(isset($_POST['marca'])){$this->marca=$_POST['marca'];}else{$this->marca = '';}
		if(isset($_POST['descripcion'])){$this->descripcion=$_POST['descripcion'];}else{$this->descripcion = '';}
		$this->formatoprecio = 1;
		$this->imagen = 'impresas/etitextil.png';
		$this->oferta = 0;
		$this->rmayorista = $resultset['rmayorista'];
		$this->rpvp = $resultset['rpvp'];
		$this->comision = $resultset['comision'];
		$this->visible = 1;
	
		//-------- Variables del formulario -------------------//
		if(!isset($_POST['alto']) || $_POST['alto']==0){$this->alto=36.67;} else {$this->alto=$_POST['alto'];}
		if(!isset($_POST['ancho']) || $_POST['ancho']==0){$this->ancho=20.00;} else {$this->ancho=$_POST['ancho'];}
		if(isset($_POST['troqueladas']) && $_POST['troqueladas']=='on'){$this->troqueladas=1; $this->rTroqueladas = $resultset['recargo_troqueladas'];} else {$this->troqueladas=0; $this->rTroqueladas=0;}
		if(isset($_POST['cantidad'])){$this->cantidad = $_POST['cantidad'];}else{$this->cantidad=1000;}
		
		//-------- Constantes ----------------------------------//
		
		$this->muestras = array(1000, 2500, 5000, 10000, 25000, 50000, 100000, 250000, 500000); //Precios orientativos dependiendo de cantidades.
		$this->anchos = array(10,12,15,20,25,30,35,40,50,60,70,80,100,110);// Anchos del material estándar.
		$this->figuras = array(1,2,3,4,5,6,8,10,12); // Figuras según los rodillos de corte.
		
		//-------- Variables de la base de datos ---------------//
			
		$this->material = $resultset['preciomaterial'];
		$this->desarrollo = $resultset['desarrollo'];	
		$this->manObra = $resultset['mano_obra'];
		$this->minimos = $resultset['minimos'];
		$this->desperdicio = $resultset['desperdicio'];
		$this->comision = $resultset['comision'];
		$this->cliche = $resultset['cliche'];	
		$this->rColor = $resultset['recargo_color'];
		$this->rCambios = $resultset['recargo_cambios'];
		
		//--------- Variables generadas por otras variables------//
		
		$this->altos = array(); 
	}

	function calculaPrecio($cantidad, $userId, $pxc){		
		$materialmm2 = $this->material / 1000000; // Coste de 1000 mm2 de tela.
		$PrecioEtiqBlanco = $materialmm2 * ($this->alto * $this->ancho); // Coste de mil etiquetas en blanco.
		$metros = $cantidad / (1000 / $this->alto); // Cantidad de metros del pedido		
		$CosteManoObra = $this->manObra * $metros;
		$recargos = 1 + $this->rTroqueladas;
		$costeUnidad = ($PrecioEtiqBlanco * $recargos);
		$costePedido = ($costeUnidad * $cantidad) + $CosteManoObra + $this->minimos;
		$precioMillar = ($costePedido / $cantidad) * 1000;
		$precioMillar = $precioMillar * (1 + $this->pxc($userId, $pxc)); 
		return $precioMillar;}	
	function calculaPrecioTotal($precioMillar, $cantidad){
			return round($precioMillar * ($cantidad / 1000), 2);} // Función calcula precio total.	
	function pxc($cliente, $preciopersonalizado){
		if($preciopersonalizado != NULL){$recargo=$preciopersonalizado;}
		else{
			global $database;
			global $conexion;
			mysql_select_db($database, $conexion);
			$pxc_query = sprintf("SELECT * FROM pxc WHERE userId=%d AND articuloId=%d", GetSQLValueString($cliente,"int"), GetSQLValueString($this->articuloId,"int"));
			$pxc = mysql_query($pxc_query, $conexion) or die(mysql_error());
			$row_pxc = mysql_fetch_assoc($pxc);
			
			$query = sprintf("SELECT usertype FROM usuarios WHERE userId=%d", GetSQLValueString($cliente,"int"));
			$result = mysql_query($query) or die(mysql_error());
			$resultset = mysql_fetch_assoc($result);
		
			if(!empty($row_pxc)){$recargo=$row_pxc['preciopersonal'];}
			else{
				if($resultset['usertype']=='Administrador' || $resultset['usertype']=='Editor') {$recargo=0;}
				if($resultset['usertype']=='Mayorista') {$recargo=$this->rmayorista;}
				else {$recargo=$this->rpvp;}
			}
		} return $recargo;
	} // Devuelve el recargo a aplicar según cliente.

}
?>