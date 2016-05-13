<?php
require_once('../php/database/grafidel_db.php');
require_once('../php/consults/consultasBD.php');
function insertArticulo(){
$categorias = verCategoriasEsp();
$formatos = verFormatosPrecio();
echo ('<div id="formulario" style="width:50%;">');
echo ('<form action="../php/insertArticulo.php" method="post" enctype="multipart/form-data" name="form1" id="form1">');
echo ('<table border="0" cellspacing="0" cellpadding="0">');
echo ('<tr><td>Nombre:</td><td><input type="text" name="nombre" id="nombre" /></td></tr>');
echo ('<tr><td>Categoría:</td><td><select name="cat" id="cat">');
foreach($categorias as $v){
	echo ('<option value="').$v['categoriaId'].('">').$v['nomCategoria'].('</option>');
}
echo ('</select></td></tr>');
echo ('<tr><td>Marca:</td><td><input type="text" name="marca" id="marca" /></td></tr>');
echo ('<tr><td>Descripción:</td><td><input name="descripcion" type="text" id="descripcion" size="40" /></td></tr>');
echo ('<tr><td>Formato precio:</td><td><select name="fprecio" id="fprecio">');
foreach($formatos as $s){
	echo ('<option value="').$s['id'].('">').$s['nombre'].('</option>');
}
echo ('</select></td></tr>');
echo ('<tr><td>Imagen:</td><td><input type="file" name="imagen" id="imagen" /></td></tr>');
echo ('<tr><td>Precio base:</td><td><input type="text" name="preciobase" id="preciobase" /></td></tr>');
echo ('<tr><td>Recargo mayorista:</td><td><input type="text" name="rmayorista" id="rmayorista" /></td></tr>');
echo ('<tr><td>Recargo pvp:</td><td><input type="text" name="rpvp" id="rpvp" /></td></tr>');
echo ('<tr><td>Poner en oferta:</td><td><input type="checkbox" name="ofert" id="ofert" /></td></tr>');
echo ('<tr><td>Visible:</td><td><input type="checkbox" name="visible" id="visible" /></td></tr>');
echo ('<tr><td colspan="2"><input type="submit" name="button" id="button" value="Enviar" /></td></tr>');
echo ('</table></form></div>');}
function selModArticulo(){
	$articulos = articulosList();
	echo ('<table><tr><th>Editar</th><th>Nombre</th><th>Marca</th><th>Descripcion</th></tr>');
	foreach($articulos as $v){
		echo ('<tr><td>').('<a href="admin.php?page=16&articuloId=').$v['articuloId'].('">Editar</a>').('</td><td>').$v['nombre'].('</td><td>').$v['marca'].('</td><td>').$v['descripcion'].('</td><td></tr>');
	}
	echo ('</table>');}
function ModArticulo(){
$articulo = new Articulo($_GET['articuloId']);
$categorias = verCategoriasEsp();
$formatos = verFormatosPrecio();
echo ('<div id="formulario" style="width:65%;">');
echo ('<form action="../php/modArticulo.php" method="post" enctype="multipart/form-data" name="form1" id="form1">');
echo ('<table border="0" cellspacing="0" cellpadding="0">');
echo ('articuloId=').$articulo->articuloId;
echo ('<input type="hidden" id="articuloId" name="articuloId" value="').$articulo->articuloId.('">');
echo ('<tr><td>Nombre:</td><td><input type="text" name="nombre" id="nombre" value="').$articulo->nombre.('" /></td></tr>');
echo ('<tr><td>Categoría:</td><td><select name="cat" id="cat">');
foreach($categorias as $v){
	echo ('<option value="').$v['categoriaId'].('"');
	if ($v['categoriaId'] == $articulo->categoria){echo ('selected="selected"');}
	echo ('>').$v['nomCategoria'].('</option>');
}
echo ('</select></td></tr>');
echo ('<tr><td>Marca:</td><td><input type="text" name="marca" id="marca" value="').$articulo->marca.('"/></td></tr>');
echo ('<tr><td>Descripción:</td><td><input name="descripcion" type="text" id="descripcion" size="65" value="').$articulo->descripcion.('"/></td></tr>');
echo ('<tr><td>Formato precio:</td><td><select name="fprecio" id="fprecio">');
foreach($formatos as $s){
	echo ('<option value="').$s['id'].('"');
	if ($s['id'] == $articulo->formatoprecio){echo (' selected="selected"');}
	echo ('>').$s['nombre'].('</option>');
	
}
echo ('</select></td></tr>');
echo ('<tr><td>Imagen:</td><td><input type="file" name="imagen" id="imagen" /></td></tr>');
echo ('<tr><td>Precio base:</td><td><input type="text" name="preciobase" id="preciobase" value="').$articulo->preciobase.('"/></td></tr>');
echo ('<tr><td>Recargo mayorista:</td><td><input type="text" name="rmayorista" id="rmayorista" value="').$articulo->rmayorista.('"/></td></tr>');
echo ('<tr><td>Recargo pvp:</td><td><input type="text" name="rpvp" id="rpvp" value="').$articulo->rpvp.('"/></td></tr>');
echo ('<tr><td>Poner en oferta:</td><td><input type="checkbox" name="ofert" id="ofert" /></td></tr>');
echo ('<tr><td>Visible:</td><td><input type="checkbox" name="visible" id="visible" checked="checked"/></td></tr>');
echo ('<tr><td colspan="2"><input type="submit" name="button" id="button" value="Enviar" /></td></tr>');
echo ('</table></form></div>');}
?>