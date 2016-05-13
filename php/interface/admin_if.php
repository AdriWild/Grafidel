<?php 
require_once('/php/database/grafidel_db.php');
require_once('/php/objects/Articulo.php');
require_once('/php/consults/consultasBD.php');

//----------------- Funcions Autentificació i control de accés -------------------------- 

function userAuth() {
if (!isset($_SESSION)) { session_start(); userAcces();}}// Comprobar sesión
function userAcces() {
	global $database;
	global $conexion;
	if (isset($_POST['user'])) {
		$loginUsername = $_POST['user'];
		$password = md5($_POST['pass']);
  
		mysql_select_db($database, $conexion); 
		$Login_query = sprintf("SELECT * FROM usuarios, perfiles WHERE user=%s AND pass=%s", GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
		$LoginRS = mysql_query($Login_query, $conexion) or die(mysql_error());
		$row_LoginRS = mysql_fetch_assoc($LoginRS);
		if(empty($row_LoginRS)){header('Location: index.php?page=fail_login');}
 
		if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
		$_SESSION['Username'] = $loginUsername;
		$_SESSION['userId'] = $row_LoginRS['userId'];
		$_SESSION['usertype'] = $row_LoginRS['usertype'];
		$_SESSION['email'] = $row_LoginRS['email'];
		$_SESSION['empresa'] = $row_LoginRS['empresa'];
		$_SESSION['carrito'] = array();
  	}}// Validar Usuario
function regUser(){
echo ('<p class="titulo">Alta de usuario.</p>');
echo ('<div style="width:320px;"');
echo ('<div id="formulario">');
echo ('<form id="new_user" name="new_user" method="post" action="../php/insertUser.php">');
  echo ('<table border="0" cellspacing="0" cellpadding="0">');
    echo ('<tr><td width="150px">Usuario:</td><td width="170px"><input type="text" name="user" id="user" /> *</td></tr>');
    echo ('<tr><td>Persona de contacto:</td><td><input type="text" name="nombre" id="nombre" /> *</td></tr>');
    echo ('<tr><td>Empresa:</td><td><input type="text" name="empresa" id="empresa" /> *</td></tr>');
    echo ('<tr><td>Email:</td><td><input type="text" name="email" id="email" /> *</td></tr>');
    echo ('<tr><td colspan="2">&nbsp;</td></tr>');
    echo ('<tr><td>Dirección:</td><td><input type="text" name="direccion" id="direccion" /></td></tr>');
    echo ('<tr><td>Código Postal:</td><td><input type="text" name="cp" id="cp" /></td></tr>');
    echo ('<tr><td>Localidad:</td><td><input type="text" name="localidad" id="localidad" /></td></tr>');
    echo ('<tr><td>Provincia:</td><td><input type="text" name="provincia" id="provincia" /></td></tr>');
    echo ('<tr><td>País:</td><td><input type="text" name="pais" id="pais" /></td></tr>');
    echo ('<tr><td>Teléfono:</td><td><input type="text" name="telefono" id="telefono" /> *</td></tr>');
    echo ('<tr><td>Fax:</td><td><input type="text" name="fax" id="fax" /></td></tr>');
    echo ('<tr><td>Web:</td><td><input type="text" name="web" id="web" /></td></tr>');
    echo ('<tr><td colspan="2">&nbsp;</td></tr>');
    echo ('<tr><td>Contraseña:</td><td><input type="password" name="pass" id="pass" /> *</td></tr>');
    echo ('<tr><td>Reescribe la contraseña:</td><td><input type="password" name="pass2" id="pass2" /> *</td></tr>');
	echo ('<input type="hidden" name="session" value"').session_id().('"/>');
    echo ('<tr><td colspan="2"><input type="submit" name="button" id="button" value="Enviar" /></td></tr>');
  echo ('</table>');
echo ('</form>');
echo ('</div>');
echo ('</div>');	} // Formulari per registrar un nou usuari.
function salir(){session_destroy(); header('Location: index.php');} // Logout.

//---------------- Funcions de la página principal --------------------------------------

function metaInfo(){
	global $conexion;
	global $database;
	mysql_select_db($database, $conexion);
	$info_query = "SELECT descripcion, tags FROM categorias";
	$info = mysql_query($info_query, $conexion) or die(mysql_error());
	return mysql_fetch_assoc($info);
	 } // Afegeix la meta informació depenent de la categoría, descripció i tags. 
function menu($usertype){
	function admin(){
		echo ('<div id="menu" class="link1">');
 		echo ('<a href="index.php?page=0">Inicio</a> | ');
 		echo ('<a href="miespacio.php">Mi espacio</a> | ');
 		echo ('<a href="index.php?page=3">Localización y Contacto</a> | ');
 		echo ('<a href="index.php?page=4">Mi Carrito</a> | ');
 		echo ('<a href="admin.php">Administrar</a> | ');
		echo ('<div id="loginBox" class="login">');
		echo ('<span class="loginName">');
		echo $_SESSION['empresa'];
		echo ('</span>');
		echo ('<a href="../php/scripts/salir.php"><img src="../img/base/iconos/eixir.png" border="0px"/></a>');
		echo ('</div>');
		echo ('</div>');
	}
	function editor(){
		echo ('<div id="menu" class="link1">');
 		echo ('<a href="index.php?page=0">Inicio</a> | ');
 		echo ('<a href="index.php?page=2">Mi espacio</a> | ');
 		echo ('<a href="index.php?page=3">Localización y Contacto</a> | ');
 		echo ('<a href="index.php?page=4">Mi Carrito</a> | ');
 		echo ('<a href="admin.php">Administrar</a> | ');
		echo ('<div id="loginBox" class="login">');
		echo ('<span class="loginName">');
		echo $_SESSION['empresa'];
		echo ('</span>');
		echo ('<a href="../php/salir.php"><img src="../img/base/iconos/eixir.png" border="0px"/></a>');
		echo ('</div>');
		echo ('</div>');
	}
	function mayorista(){
		echo ('<div id="menu" class="link1">');
 		echo ('<a href="index.php?page=0">Inicio</a> | ');
 		echo ('<a href="index.php?page=2">Mi espacio</a> | ');
 		echo ('<a href="index.php?page=3">Localización y Contacto</a> | ');
 		echo ('<a href="index.php?page=4">Mi Carrito</a> | ');
		echo ('<span class="pMayoristas">¡Precios para mayoristas!</span>');
		echo ('<div id="loginBox" class="login">');
		echo ('<span class="loginName">');
		echo $_SESSION['empresa'];
		echo ('</span>');		
		echo ('<a href="../php/salir.php"><img src="../img/base/iconos/eixir.png"/></a>');
		echo ('</div>');
		echo ('</div>');
	}
	function registrado(){
	echo ('<div id="menu" class="link1">');
 	echo ('<a href="index.php?page=0">Inicio</a> | ');
 	echo ('<a href="index.php?page=2">Mi espacio</a> | ');
 	echo ('<a href="index.php?page=3">Localización y Contacto</a> | ');
 	echo ('<a href="index.php?page=4">Mi Carrito</a> | Precios P.V.P, I.V.A no incluído');
	echo ('<div id="loginBox" class="login">');
	echo ('<span class="loginName">');
	echo $_SESSION['empresa'];
	echo ('</span>');		
	echo ('<a href="../php/salir.php"><img src="../img/base/iconos/eixir.png"/></a>');
	echo ('</div>');
	echo ('</div>');
	}
	function anonimo(){
		echo ('<div id="menu" class="link1">');
		echo ('<a href="index.php?page=0">Inicio</a> | ');
		echo ('<a href="index.php?page=1">Registrarse</a> | ');
		echo ('<a href="index.php?page=3">Localización y Contacto</a> | ');
 		echo ('<a href="index.php?page=4">Mi Carrito</a> | ');
 		echo ('Precios P.V.P, I.V.A no incluído');	
		echo ('<div id="loginBox" class="login">');
		echo ('<form id="login" name="login" method="POST" action="index.php">');
		echo ('Usuario: ');
		echo ('<input name="user" type="text" class="login" size="15"/>');
		echo ('Contraseña: '); 
		echo ('<input name="pass" type="password" class="login" size="15"/>');
		echo ('<input type="submit" name="entrar" value="entrar" class="login"/>'); 	
       	echo ('</form>');
		if (isset($_GET['page']) && $_GET['page']=='fail_login'){ echo '<span class="fail_login">nombre de usuario o contraseña incorrectos</span>'; };
		echo ('</div>');
		echo ('</div>');
	}
	switch ($usertype) {
		case 'Administrador': admin(); break;
		case 'Editor': editor(); break;
		case 'Mayorista': mayorista(); break;
		case 'Registrado': registrado(); break;
		default: anonimo(); break;
		}} // Crea la botonera del menu navegable depenent del tipus de usuari.
function inici(){
	$categorias = verCategorias();
	foreach($categorias as $v){
		echo('<div id="categoria">');		
			echo('<div id="caixodalt"></div>');			
			echo('<div id="caixoesquerra"></div>');        	
			echo('<div id="caixomig">');
				echo('<div id="cont_categoria">');
					echo('<div id="titulo_categoria">');echo $v['nomCategoria'];echo('</div>');
					echo('<div id="desc_categoria">');echo $v['descripcion'];echo('</div>');
				echo('</div>');
				echo('<div id="foto_categoria">');echo ('<a href="index.php?page=8&cat=').$v["categoriaId"].('"><img  src="../img/categorias/'.$v["imagen"].'" width="120" height="96" border="0"/></a>');echo('</div>');				
			echo('</div>');
			echo('<div id="caixodreta"></div>');       	
			echo('<div id="caixobaix"></div>');       		
		echo('</div>');
	}} // Pagina de inici #Page=1
function altaUsuario(){regUser();} // Formulari per donar de alta un usuari.
function contacto(){echo ('<br /><br /><table border="0" cellspacing="0" cellpadding="0">');
echo ('<tr><td>Grafidel, Etiquetas y Complementos<br />C/Vereda, 2 03469 Camp de Mirra<br />Telf. 96 582 05 61 · Fax. 96 582 05 76</td></tr><br /><br />');
echo ('<tr><td><iframe width="700" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.es/?ie=UTF8&amp;ll=38.688324,-0.783463&amp;spn=0.036379,0.084543&amp;t=m&amp;z=14&amp;iwloc=lyrftr:starred_items:108564199557846939444:,14904471637555426204,38.687821,-0.783098&amp;output=embed"></iframe><br /><small><a href="https://maps.google.es/?ie=UTF8&amp;ll=38.688324,-0.783463&amp;spn=0.036379,0.084543&amp;t=m&amp;z=14&amp;iwloc=lyrftr:starred_items:108564199557846939444:,14904471637555426204,38.687821,-0.783098&amp;source=embed" style="color:#0000FF;text-align:left">Ver mapa más grande</a></small></td>');
echo ('</tr></table>');} // Página de contacte i localització.
function verCarrito(){
	$totalCarrito=0;
	if (isset($_COOKIE['carrito'])){$_SESSION['carrito']=unserialize($_COOKIE['carrito']);}
	if (!empty($_SESSION['carrito']) && !empty($_SESSION['carrito']->carrito)){
		echo ('<table>');
		echo ('<tr>');
		echo ('<th colspan="2">Artículo</th><th>Cantidad</th><th>Precio</th><th>Total</th><th></th>');
		echo ('</tr>');
		echo ('<tr>');
		echo ('<td colspan="5"><hr /></td>');
		echo ('</tr>');
		foreach($_SESSION['carrito']->carrito as $clave => $s){
				echo ('<tr>');
				echo ('<td>');
				echo ('<img src="../img/articulos/').$s['imagen'].('" with="30px" height="30px"/>');
				echo ('</td>');
				echo ('<td>');
		 		echo $s['nombre'].(' ');
				echo $s['marca'].(' ');
				echo $s['descripcion'].(' ');
				echo ('</td>');
				echo ('<td>');
				echo number_format($s['cantidad'],2,",",".");
				echo ('</td>');
				echo ('<td>');
				echo number_format($s['precio'],2,",","."); echo ('€.');
				echo ('</td>');
				echo ('<td>');
				echo number_format($s['precio'] * $s['cantidad'], 2,",","."); echo ('€.');
				echo ('</td>');
				echo ('<td>');
				echo ('<a href="../php/borrar.php?carritoId='); echo $clave; echo ('">'); echo ('<img src="../img/base/iconos/borrar.png"/></a>');
				echo ('</td>');
				echo ('</tr>'); 
				$totalCarrito=$totalCarrito + $s['precio'] * $s['cantidad'];
		}
			echo ('<tr>');
			echo ('<td colspan="5"><hr /></td>');
			echo ('</tr>');
			echo ('<tr>'); 
			echo ('<td colspan="3">'); 
			echo ('Total pedido'); 
			echo ('</td>'); 
			echo ('<td colspan:"2">'); 
			echo number_format($totalCarrito, 2,",","."); echo ('€.');
			echo ('</td>');
			echo ('</tr>');
			echo ('<tr><td colspan="5"><a href="../php/insertPedido.php">Realizar Pedido</a></td></tr>');
			echo ('</table>');	
	}else {echo 'El carrito de la compra está vacío';}} // Vore carret de la compra.
function verOfertas(){
	global $conexion;
	global $database;
	if (isset($_SESSION['userId'])){$userId=$_SESSION['userId'];} else {$userId=0;}
	mysql_select_db($database, $conexion);
	$ofertas_query = "SELECT * FROM articulos WHERE oferta=1";
	$ofertas = mysql_query($ofertas_query, $conexion) or die(mysql_error());
	for($i=0;$i<4;$i++){
	$row_ofertas = mysql_fetch_assoc($ofertas);
		echo ('<div id="oferta">');
			echo ('<div id="textOferta">Oferta Especial</div>');
			echo ('<div id="titulOferta">'); echo $row_ofertas['nombre']; echo ('</div>');
			echo ('<div id="contOferta">');
				echo ('<div id="descOferta">'); echo $row_ofertas['marca'].(' '); echo $row_ofertas['descripcion']; echo('</div>');
				echo ('<div id="textPreuOferta">Precio: <span class="preuOferta">');
				echo calcPreu($userId, $row_ofertas['articuloId']);
				echo ('€</span></div>');
			echo ('</div>');
			echo ('<div id="fotoOferta"><img src="../img/articulos/');
			echo $row_ofertas['imagen']; 
			echo ('" width="50" height="50" /></div>');
		echo ('</div>');
	}
	mysql_free_result($ofertas);} // Publica els articuls en oferta.
function verArticulos($categoria){
	verCabecera($categoria);
	global $conexion;
	global $database;
	$articulos = array();
	mysql_select_db($database, $conexion);
	$sql=sprintf("SELECT articuloId FROM articulos WHERE categoria=%d", GetSQLValueString($categoria,"int"));
	$query=mysql_query($sql);
	$result=mysql_fetch_assoc($query);
	do{
		$item = new Articulo($result['articuloId']);
		array_push($articulos, $item);
	}while($result=mysql_fetch_assoc($query));
	if($articulos[0]->articuloId == NULL){echo ("Categoría vacía");}else{
	foreach($articulos as $s){
		echo ('<div id="articulo">');
		echo ('<img id="img_list" src="../img/articulos/').$s->imagen.('"height="120" /><br>');
		echo ('<p class="particulo"><strong>');
		echo $s->nombre.("</strong><br>");
		echo $s->marca.(" ");
		echo $s->descripcion.("<strong><br>");
		if(isset ($_SESSION['usertype']))
		{
			if(!($_SESSION['usertype']=='Mayorista' || $_SESSION['usertype']=='Administrador' || $_SESSION['usertype']=='Editor')){echo 'PVP ';}
		}
		else {echo 'PVP ';}
		echo number_format($s->calculaPrecio(),2,',','.').('€</strong></p>');
		echo ('<form action="../php/insertCarrito.php" method="post">');
		echo ('<input type="hidden" name="articuloId" id="articuloId" value="').$s->articuloId.('" />');		echo ('Cantidad: ');
		echo ('<input type="text" size="3" name="cantidad" id="cantidad" value="1" />');
		echo ('<input type="hidden" name="precio" id="precio" value="').$s->calculaPrecio().('" />');
		echo ('<button type="submit" style= "margin: 10px 20px;"><img src="../img/base/iconos/carrito.png" width="15" height="15" /></button></form>');
		echo ('</div>');
	}}} // Crea una llista de productes.
function verCabecera($categoria){
	$cat = verNomCatId($categoria);
	echo ('<div class="cabeceraArt">');
    echo ('<div><h1>').$cat['nomCategoria'].('</h1></div>
		   <div style="width:350px; float:left;"><img src="../img/categorias/cabecera/').$cat['imgdesc'].('"height="117"></div>
		   <div style="width:350px; margin-left:350px; overflow:visible;">
		   <p style="position:absolute; margin-top: 10px; width:350px;">').$cat['desclarga'].('</p>
		   </div>');
	echo ('</div>');}

//---------------- Funcions del panell de administració ----------------------------------

function calcPreu($userId, $articuloId){
	global $conexion;
	global $database;
	mysql_select_db($database, $conexion);
	$precio_articulo = sprintf("SELECT preciobase, rmayorista, rpvp FROM articulos WHERE articuloId=%s", GetSQLValueString($articuloId,"int"));
	$precio = mysql_query($precio_articulo, $conexion) or die(mysql_error());
	$row_precio = mysql_fetch_assoc($precio);
	
	$pxc_query = sprintf("SELECT * FROM pxc WHERE userId=%s AND articuloId=%s", GetSQLValueString($userId,"int"), GetSQLValueString($articuloId,"int"));
	$pxc = mysql_query($pxc_query, $conexion) or die(mysql_error());
	$row_pxc = mysql_fetch_assoc($pxc);
	
	$user_query = sprintf("SELECT usertype FROM usuarios WHERE userId=%s", GetSQLValueString($userId,"int"));
	$user = mysql_query($user_query, $conexion) or die(mysql_error());
	$row_user = mysql_fetch_assoc($user);
		
	if(!empty($row_pxc)){ $precioFinal = $row_precio['preciobase']*(1 + $row_pxc['preciopersonal']);} // Devolver si tiene un precio personalizado.
	else {
			if ($row_user['usertype']=='Mayorista' || $row_user['usertype']=='Administrador' || $row_user['usertype']=='Editor'){
				$precioFinal = $row_precio['preciobase']*( 1 + $row_precio['rmayorista']);} // Devolver si es cliente mayorista.
			else{ $precioFinal = $row_precio['preciobase']*(1 + $row_precio['rpvp']);} // Devolver si es cliente PVP o anónimo.
	}
	mysql_free_result($precio);
	mysql_free_result($pxc);
	mysql_free_result($user);
	echo number_format($precioFinal,2);}// Calcula el preu del producte depenent del client.
function verPxc(){
	if (isset($_POST['clientes'])){$userId = $_POST['clientes'];} else{$userId = 1;}
	echo ('<form id="pxc" method="post" action="admin.php?page=13"><table><tr><td>Selecciona el cliente: </td><td><select id="clientes" name="clientes">');
    $clientes = verClientes();
	foreach($clientes as $clave => $v){
		echo ('<option value="').$v['userId'].('"');
		if($v['userId']==$userId){echo ('selected="selected"');}
		echo ('>').$v['empresa'].('</option>');
	}
    echo('</select></td><td><button type="submit">Ver precios</button></td></tr></table></form><br /><br />');
	$pxc = pxc($userId);
	if($pxc[0]!=false){
		echo ('<form><table width="80%"><tr><th>Artículo</th><th align="center">Cantidad</th><th align="center">Precio base</th><th align="center">Mayorista</th><th align="center">PVP</th><th align="center">Precio Personalizado</th></tr>');
		foreach($pxc as $v){
			$articulo = verArticulo($v['articuloId']);
			echo ('<tr><td>').$articulo['nombre'].(' ').$articulo['marca'].(' ').$articulo['descripcion'].(' ').('</td>');
			echo ('<td align="center">').$articulo['cantidad'].('</td>');
			echo ('<td align="center">');
			echo number_format($articulo['preciobase'], 2,",",".").('€');
			echo ('</td><td align="center">');
			echo number_format($articulo['preciobase'] * (1 + $articulo['rmayorista']), 2,",",".").('€');
			echo ('</td><td align="center">');
			echo number_format($articulo['preciobase'] * (1 + $articulo['rpvp']), 2,",",".").('€');
			echo ('</td><td align="center">');
			echo number_format($articulo['preciobase'] * (1 + $v['preciopersonal']), 2,",",".").('€');
			echo ('</td></tr>');
		}
	echo ('</table></form><br /><br /><br /><br />');
	}
	else { echo ('El cliente seleccionado no tiene precios personalizados.<br /><br /><br /><br />');}
	} // Muestra los precios según el cliente.
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
			
// --------------- Funcions -> Mi Espacio ----------------------------------------------
function verPerfil(){}
function verPresupuestos(){
	$presu = verPresuCliente();
		echo ('<table><tr>');
		echo ('<th colspan="2">Etiqueta</th><th>Cantidad</th><th>Precio por millar</th><th>Total</th><th></th></tr>');
		foreach($presu as $v){
			echo ('<tr><td>').('<img src="').('../img/articulos/').$v['imagen'].('" width="30px" height="30px"/></td>');
			echo ('<td>').$v['nombre'].(' ').$v['marca'].(' ').$v['descripcion'].(' de ').$v['ancho'].(' x ').$v['alto'].(' mm.</td>');
			echo ('<td>').$v['cantidad'].('</td>');
			echo ('<td>').$v['preciobase'].('</td>');
			echo ('<td>');
			$res = ($v['cantidad']/1000) * $v['preciobase'];
			echo $res;
			echo ('</td>');
			echo ('<form action="../php/insertCarrito.php" method="post">');
			echo ('<input type="hidden" name="articuloId" id="articuloId" value="').$v['articuloId'].('" />');
			$cantidad = ($v['cantidad']/1000);
			echo ('<input type="hidden" name="cantidad" id="cantidad" value="').$cantidad.('" />');
			echo ('<input type="hidden" name="precio" id="precio" value="').$v['preciobase'].('" />');
			echo ('<td><button type="submit"><img src="../img/base/iconos/carrito.png" width="15" height="15" /></button><button type="submit" style= "margin: 10px 20px;"><img src="../img/base/iconos/borrar.png" width="15" height="15" /></button></td></tr>');
			echo ('</form>');
		}
		echo ('</table>');}
function showPedidosCliente(){
	$pedidos = verPedidosCliente($_SESSION['userId']);
	echo ('<table>');
	foreach($pedidos as $v){
		$detalle = verDetallePedido($_SESSION['userId'], $v['npedido']);
		echo ('<tr bgcolor="#FFFF99">');
		echo ('<th>').$v['fecha'].('</th>').('<th colspan="3">').('Artículo').('</th>').('<th>Cantidad</th>').('<th>Precio</th>');
		echo ('</tr>');
		$total = 0;
		foreach ($detalle as $s){
			$articulo = verArticulo($s['articuloId']);
			$precio = $articulo['preciobase'];
			echo ('<tr>');
			echo ('<td><img src="../img/articulos/').$articulo['imagen'].('"height="30px" /></td>').('<td>').$articulo['nombre'].('</td>').('<td>').$articulo['marca'].('</td>').('<td>').$articulo['descripcion'].('</td>').('<td>').$articulo['cantidad'].('</td>').('<td>').$articulo['preciobase'].('</td>');
			echo ('</tr>');
			$total = $total + $precio;
		}
		echo ('<tr bgcolor="#FF9900"><td colspan="6"><a href="#"><img src="../img/iconos/pdf_icon.png" width="18" height="18" /></a><a href="#"><img src="../img/iconos/printer.png" width="18" height="18" /></a></td><td>').$total.('</td></tr>');
		echo ('<tr height="45px"></tr>');
	}echo ('</table>');}
function verPagos(){}
function enviarSugerencia(){}
?>