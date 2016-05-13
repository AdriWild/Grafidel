<?php
require_once '../objects/EtiquetaImpresa.php';
require_once '../objects/Articulo.php';
require_once '../objects/Presupuesto.php';
require_once '../objects/Comunicado.php';
require_once '../objects/Empresa.php';
var_dump($_POST);
session_start();
$etiqueta = new EtiquetaImpresa();
$max = $etiqueta->getMaxEtiquetaImpresa();

//################################### ETIQUETA IMPESA ##########################################

$_POST['eti_impresa_Id'] = $max['MAX(eti_impresa_Id)'] + 1;
$query = 'INSERT INTO eti_impresas (eti_impresa_Id, cliente_Id, nombre, material, descripcion, ancho, alto, impresiones, cambios, acabado, imagen, beneficio) values ("'.$_POST['eti_impresa_Id'].'","'.$_POST['cliente_Id'].'","'.$_POST['nombre'].'","'.$_POST['material'].'","'.$_POST['descripcion'].'","'.$_POST['ancho'].'","'.$_POST['alto'].'","'.$_POST['impresiones'].'","'.$_POST['cambios'].'","'.$_POST['acabado'].'","'.$_POST['imagen'].'","'.$_POST['beneficio'].'")';
if($etiqueta::insertEtiqueta($query)){
	if(isset($_POST['r1'])){
		$a = array();
		$ref_max = $etiqueta->getMaxEtiquetaImpresaRef();
		if($ref_max['max'] == NULL){$ref_max = 0;} else {$ref_max = $ref_max['max'];}
		$query = 'INSERT INTO eti_impresas_ref (eti_impresa_ref_Id, eti_impresa_Id, nombre) values '; 
		for ($i=intval($_POST['cambios']); $i>0; $i--){ 
			$query = $query.'("'.($ref_max + $i).'","'.$_POST['eti_impresa_Id'].'","'.$_POST['r'.$i].'")'; 
			if ($i>1){$query = $query.',';}
			array_push($a,$ref_max + $i);
		}
		if ($etiqueta::insertEtiqueta($query)){
		} else {echo  'Error insertando referencias en etiqueta impresa = '.$_POST['eti_impresa_Id'];}
	} 
} else {echo  'Error insertando etiqueta impresa = '.$_POST['eti_impresa_Id'];}	
//####################################### ARTICULO #############################################

$articulo = new Articulo();
$articulo->setArticulo($_POST['eti_impresa_Id'], $categoria = 1);
if(!$articulo->insertArticulo()){echo 'Error insertando Artículo';}
//##################################### PRESUPUESTO ############################################
$presupuesto = new Presupuesto();

$presupuesto->presupuesto_Id = intval($presupuesto->getUltimoPresupuesto() + 1);
$presupuesto->articulo_Id = $articulo->articulo_Id;
$presupuesto->cliente_Id = $_POST['cliente_Id'];
$presupuesto->categoria = 1;
$presupuesto->cantidad = $_POST['cantidad'];
$presupuesto->precioMillar = $_POST['precioMillar'];
$presupuesto->precioTotal = $_POST['precioTotal'];
$presupuesto->observaciones = $_POST['observaciones'];
$presupuesto->contacto = $_POST['contacto'];

if(!$presupuesto->insertPresupuesto()){echo 'Error insertando el presupuesto';}
else{
if(isset($_POST['r1'])){
		$query = 'INSERT INTO presupuestos_ref (presupuesto_Id, item_ref_Id, cantidad) values '; 
		for ($i=intval($_POST['cambios']), $n=0; $i>0; $i--){ 
			$query = $query.'("'.$presupuesto->presupuesto_Id.'","'.$a[$n].'","'.$_POST['c'.$i].'")'; 
			$n++;
			if ($i>1){$query = $query.',';}
		}
		if ($etiqueta::insertEtiqueta($query)){
		} else {echo  'Error insertando presupuestos ref = '.$_POST['eti_impresa_Id'];}
	} 
}
//##################################### COMUNICADOS #############################################
$comunicado = new Comunicado();
$query = 'INSERT INTO comunicados (user_Id, texto, tipo, prioridad) values ("'.$_SESSION['user_Id'].'", "Nuevo presupuesto para '..'</a>", "Presupuesto", 1)';
if(!$comunicado->insertDB($query)){echo 'Error al insertar el comunicado'; }
var_dump($query);
//header ('Location: ../../ES/admin.php?page=ver_presupuestos');
?>