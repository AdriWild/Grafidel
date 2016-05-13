<?php
require_once ('../consults/consultasBD.php');
require_once('../objects/EtiquetaImpresa.php');
require_once('../objects/Articulo.php');
require_once('../insert/insertPresupuesto.php');
require_once('../globals/globals.php');

var_dump($_FILES);
var_dump($_POST);

$tamanyo = $_FILES["imagen"]['size'];
$tipo = $_FILES["imagen"]['type'];
$nombreimg = $_FILES["imagen"]['name'];
$ntemporal = $_FILES["imagen"]['tmp_name']; 
	
$destino = '../../img/articulos/impresas/'.$nombreimg;

copy($_FILES["imagen"]['tmp_name'],$destino); // SUBE LA IMAGEN AL SERVIDOR

function postToObject($presupuesto){

	$etiqueta = new etiquetaImpresa();
	
	$etiqueta->nombre = $presupuesto['nombre'];
	$etiqueta->grupo = $presupuesto['grupo'];
	$etiqueta->material = $presupuesto['material'];
	$etiqueta->descripcion = $presupuesto['descripcion'];
	$etiqueta->ancho = $presupuesto['ancho'];
	$etiqueta->alto = $presupuesto['alto'];
	$etiqueta->cantidad = $presupuesto['cantidad'];
	$etiqueta->colores = $presupuesto['colores'];
	$etiqueta->cambios = $presupuesto['cambios'];
	$etiqueta->cliches = $presupuesto['cliches'];
	$etiqueta->acabado = $presupuesto['acabado'];
	$etiqueta->precio = $presupuesto['precio'];
    if(isset($_FILES)) {$etiqueta->imagen = $_FILES["imagen"]['name'];}
	else {$etiqueta->imagen = 'noimage.png';}
	
	return $etiqueta;} 		// Pasa de lo recibido en el POST a OBJETO Etiqueta
function insertEtiquetaImpresa($etiqueta){
		
	$query = sprintf('INSERT INTO etiq_impresas(etiq_impresas_id, nombre, grupo, material, descripcion, ancho, alto, cantidad, colores, cambios, cliches, acabado, coste) VALUES (%d, "%s", "%s", %d, "%s", %f, %f, %d, %d, %d, %d, %d, %f)',
	getUltimoArticulo()+1,
	$etiqueta->nombre,
	$etiqueta->grupo,
	$etiqueta->material,
	$etiqueta->descripcion,
	$etiqueta->ancho,
	$etiqueta->alto,
	$etiqueta->cantidad,
	$etiqueta->colores,
	$etiqueta->cambios,
	$etiqueta->cliches,
	$etiqueta->acabado,
	$etiqueta->coste);
	insert_db($query);
	}	// Inserta la etiqueta en la tabla EtiquetaImpresa
function insertArticulo($etiqueta){
	$nombreimg = $_FILES["imagen"]['name'];
	
	$articulo = new Articulo;
	$material = getMaterial($etiqueta->material);
	$acabado = getAcabado($etiqueta->acabado);
	
	$articulo->articuloId = getUltimoArticulo()+1;
	$articulo->nombre = $etiqueta->nombre;
	$articulo->categoria = 1;
	$articulo->grupo = $etiqueta->grupo;
	$articulo->descripcion = ' sobre '.$material['material'].', de '.$etiqueta->ancho.'mm. x '.$etiqueta->alto.'mm. impresa en '.getTextTinta($etiqueta->colores).' con '.$etiqueta->cambios.' cambios, acabado: '.$acabado['tipo_acabado'].'. '.$etiqueta->nombre.' '.$etiqueta->descripcion.'.';;
	$articulo->formatoprecio = 1;
	$articulo->cantidad = $etiqueta->cantidad;
	$articulo->imagen = 'impresas/'.$nombreimg;
	$articulo->oferta = 0;
	$articulo->coste = $etiqueta->coste;
	$articulo->visible = 1;
	$articulo->stock = 0;
	
	$query = sprintf('INSERT INTO articulos
	(articuloId, nombre, categoria, grupo, descripcion, formatoPrecio, cantidad, imagen, oferta, coste, visible, stock)
	VALUES (%d, "%s", %d, "%s", "%s", %d, %d, "%s", %d, %f, %d, %d)',
	$articulo->articuloId,
	$articulo->nombre,
	$articulo->categoria,
	$articulo->grupo,
	$articulo->descripcion,
	$articulo->formatoprecio,
	$articulo->cantidad,
	$articulo->imagen,
	$articulo->oferta,
	$articulo->coste,
	$articulo->visible,
	$articulo->stock);
		
insert_db($query);
return $articulo->articuloId;} 			// Inserta el presupuesto.
function insertPrecioPersonalizado($cliente, $articulo, $beneficio){
	global $rpvp;
	global $rmayorista;
	if(isMayorista($cliente) && $beneficio != $rmayorista){}
}

$presupuesto = $_POST;
$etiqueta = postToObject($presupuesto);
insertEtiquetaImpresa($etiqueta);
$articuloId = insertArticulo($etiqueta);
insertPresupuesto($articuloId, $presupuesto['cliente'], 1, $etiqueta->precio);
header('Location: ../../ES/admin.php'); 
?>