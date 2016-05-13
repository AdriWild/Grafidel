<?php 
require_once('../php/database/grafidel_db.php');
require_once('../php/consults/consultasBD.php');
require_once('../php/objects/Articulo.php');
require_once('precios_if.php');

//----------------- Funcions Autentificació i control de accés -------------------------- 

	
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
function salir(){session_destroy(); header('Location: ../ES/index.php');} // Logout.

//---------------- Funcions de la página principal --------------------------------------

	 


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
				echo('<div id="foto_categoria">');echo ('<a href="index.php?page=8&cat=').$v['categoriaId'].('"><img  src="../img/categorias/'.$v['imagen'].'" width="120" height="96" border="0"/></a>');echo('</div>');				
			echo('</div>');
			echo('<div id="caixodreta"></div>');       	
			echo('<div id="caixobaix"></div>');       		
		echo('</div>');
	}} // Pagina de inici #Page=1
	
function altaUsuario(){regUser();} // Formulari per donar de alta un usuari.

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
				echo ('<div id="descOferta">'); echo $row_ofertas['grupo'].(' '); echo $row_ofertas['descripcion']; echo('</div>');
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
	verCabecera($categorias);
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
		echo ('<form action="../php/insert/insertCarrito.php" method="post">');
		echo ('<input type="hidden" name="articuloId" id="articuloId" value="').$s->articuloId.('" />');		echo ('Cantidad: ');
		echo ('<input type="text" size="3" name="cantidad" id="cantidad" value="1" />');
		echo ('<input type="hidden" name="precio" id="precio" value="').$s->calculaPrecio().('" />');
		echo ('<button type="submit" style= "margin: 10px 20px;"><img src="../img/base/iconos/carrito.png" width="15" height="15" /></button></form>');
		echo ('</div>');
	}}} // Crea una llista de productes.

//---------------- Funcions del panell de administració ----------------------------------
			
// --------------- Funcions -> Mi Espacio ----------------------------------------------
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
?>