<?php
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/objects/EtiquetaTejida.php');
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/objects/Articulo.php');
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/insert/insert.php');
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/insert/insertPresupuesto.php');
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/globals/globals.php');

$tamanyo = $_FILES["imagen"]['size'];
$tipo = $_FILES["imagen"]['type'];
$nombreimg = $_FILES["imagen"]['name'];
$ntemporal = $_FILES["imagen"]['tmp_name']; 
	
$destino = '/var/www/vhosts/grafidel.com/httpdocs/img/articulos/tejidas/'.$nombreimg;

copy($_FILES["imagen"]['tmp_name'],$destino); 

// SUBE LA IMAGEN AL SERVIDOR

function postToObject($presupuesto){

	$etiqueta = new etiquetaTejida();
	
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
    if(isset($_FILES)) {$etiqueta->imagen = $nombreimg;}
	else {$etiqueta->imagen = 'noimage.png';}
	
	return $etiqueta;} 		// Pasa de lo recibido en el POST a OBJETO Etiqueta
	
function insertArticulo($etiqueta){
	$nombreimg = $_FILES["imagen"]['name'];
	
	$articulo = new Articulo;
	$material = getMaterial($etiqueta->material);
	$acabado = getAcabado($etiqueta->acabado);
	
	$articulo->articuloId = getUltimoArticulo()+1;
	$articulo->nombre = $etiqueta->nombre;
	$articulo->categoria = 2;
	$articulo->grupo = $etiqueta->grupo;
	$articulo->descripcion = ' de '.$etiqueta->ancho.'mm. x '.$etiqueta->alto.'mm. en '.getTextTinta($etiqueta->colores).' con '.$etiqueta->cambios.' cambios, acabado: '.$acabado['tipo_acabado'].'. '.$etiqueta->nombre.' '.$etiqueta->descripcion.'.';;
	$articulo->formatoprecio = 1;
	$articulo->cantidad = $etiqueta->cantidad;
	$articulo->imagen = 'tejidas/'.$nombreimg;
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

$presupuesto = $_POST;
$etiqueta = postToObject($presupuesto);
$articuloId = insertArticulo($etiqueta);
insertPresupuesto($articuloId, $presupuesto['cliente'], $_POST['proveedor'], $etiqueta->precio);
header('Location: ../../ES/admin.php'); 
?>