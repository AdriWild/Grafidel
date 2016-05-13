<?php
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/database/grafidel_db.php');
require_once('/var/www/vhosts/grafidel.com/httpdocs/php/globals/globals.php');

function getFromDB($query){
	global $database;
	global $conexion;
	$array = array();
	mysql_select_db($database, $conexion);
	$result = mysql_query($query) or die (mysql_error());
	$resultset = mysql_fetch_assoc($result);
	do{array_push($array, $resultset);} while($resultset = mysql_fetch_assoc($result));
	return $array;}	

// -> USUARIOS

function verNombreUsuario($usuario){
	$query = sprintf('SELECT nombre FROM usuarios WHERE userId=%d', $usuario);
	$nombre = getFromDB($query);
	return $nombre;
}
function verEmpresaUsuario($usuario){
	$query = sprintf('SELECT empresa FROM usuarios WHERE userId=%d', $usuario);
	$empresa = getFromDB($query);
	return $empresa;
}
// -> CLIENTES
function verClientes(){
	$query = ('SELECT * FROM usuarios u, perfiles p, clientes c WHERE u.userId=p.userId AND u.userId=c.userId ORDER BY empresa ASC');
	return getFromDB($query);}// Devuelve un array de clientes con todos sus datos.
	
function verClienteActual(){ 
	$query = sprintf("SELECT * FROM usuarios WHERE userId=%d",$_SESSION['userId']);
	return getFromDB($query);}// Devuelve los datos del usuario actual en la sesión.
	
function verCliente($userId){
	$query = sprintf('SELECT * FROM usuarios WHERE userId = %d', $userId);
	$cliente = getFromDB($query);
	return $cliente[0];}
	
function isMayorista($cliente){
	$query = sprintf('SELECT usertype FROM usuarios u, clientes c WHERE u.userId = c.userId AND u.userId=%s',$cliente);
	$result = getFromDB($query);
	if ($result == 'Mayorista'){return true;}
	else {return false;}
}
// -> PROVEEDORES
function verProveedores(){
	$query = ('SELECT * FROM usuarios WHERE usertype="Proveedor"');
	return getFromDB($query);
}
	
// -> ADMINISTRADORES
function verAdmins(){
	$query = 'SELECT * FROM usuarios WHERE usertype="Administrador" OR usertype="Editor"';
	return getFromDB($query);}

// -> ARTICULOS	
function articulosList(){
	$query = "SELECT * FROM articulos ORDER BY categoria";
	return getFromDB($query);}
	
function getCosteArticulo($articuloId){
	$query = sprintf('SELECT coste FROM articulos WHERE articuloId = %d', $articuloId);
	$coste = getFromDB($query);
	return (float)$coste[0];}

function getArticulo($articuloId){
	$query = sprintf("SELECT * FROM articulos WHERE articuloId=%d", $articuloId);
	$articulo = getFromDB($query);
	return $articulo[0];}

function getUltimoArticulo(){
	$query = sprintf('SELECT MAX(articuloId) FROM articulos');
	$ultimo = getFromDB($query);
	return $ultimo[0]['MAX(articuloId)'];
}
// -> PRESUPUESTOS
function verPresuCliente(){
	$query = sprintf("SELECT * FROM etiq_impresas e, articulos a WHERE a.articuloId = e.articuloId AND userId=%d", GetSQLValueString($_SESSION['userId'],"int"));
	return getFromDB($query);}

function verPresupuestosPorClientes(){
	$query = sprintf('SELECT * FROM presupuestos WHERE activo=1 GROUP BY clienteId');
	return getFromDB($query);
	}
function verPresupuestosAgrupados($clienteId){
	$query = sprintf('SELECT a.grupo FROM presupuestos p, articulos a WHERE a.articuloId=p.articuloId AND p.activo=1 AND p.clienteId = %s GROUP BY a.grupo', $clienteId);
	return getFromDB($query);
}

function verPresupuestosPorGrupoCliente($cliente, $grupo){
	$grupo = '"'.$grupo.'"';
	$query = sprintf('SELECT * FROM presupuestos p, articulos a WHERE a.articuloId = p.articuloId AND p.activo=1 AND p.clienteId = %s AND a.grupo = %s', $cliente, $grupo);
	return getFromDB($query);
}
// -> PRECIOS

function verPreciosPedidosClientes(){
	$query = sprintf('SELECT * FROM pedidos_c GROUP BY clienteId');
	return getFromDB($query);
}

function verPreciosAgrupados($cliente){
	$query = sprintf('SELECT * FROM pedidos_c p, articulos a WHERE a.articuloId = p.articuloId AND clienteId=%s GROUP BY a.grupo', $cliente);
	return getFromDB($query);
}

function verPreciosAgrupadosArticulos($cliente, $grupo){
	$query = sprintf('SELECT * FROM pedidos_c p, articulos a WHERE a.articuloId = p.articuloId AND clienteId=%s AND a.grupo=%s', $cliente, $grupo);
	return getFromDB($query);
}

// -> CATEGORIAS	
function verNomCatId($categoriaId){
	$query = sprintf("SELECT * FROM categorias WHERE categoriaId=%d", GetSQLValueString($categoriaId,"int"));
	$categoria = getFromDB($query);
	return $categoria[0];}

function verCategorias(){
	$query = sprintf("SELECT * FROM categorias WHERE mostrar=1");
	return getFromDB($query);}

function verCategoriasEsp(){
	$query = sprintf("SELECT * FROM categorias WHERE mostrar=1 AND especial=0");
	return getFromDB($query);}
	
function verFormatosPrecio(){
	$query = ("SELECT * FROM formatoprecios");
	return getFromDB($query);}
	
function tiposRibbon(){
	$query = ("SELECT * FROM ribbon");
	return getFromDB($query);}

// PEDIDOS //
	
function pedidosCliente($userId){
	$query = sprintf('SELECT * FROM pedidos_c WHERE clienteId = %d', $userId);
	return getFromDB($query);}
	
function pedidosClienteNpedido($userId){
	$query = sprintf('SELECT * FROM pedidos_c WHERE clienteId = %d GROUP BY npedido', $userId);
	return getFromDB($query);}
	
function verDetallePedido($userId, $npedido){
	$query = sprintf('SELECT * FROM pedidos_c WHERE clienteId = %d AND npedido = %d', $userId, $npedido);
	return getFromDB($query);}
	
function verPedidos(){
	$query = sprintf('SELECT * FROM pedidos_c GROUP BY npedido');
	return getFromDB($query);}

// PRESUPUESTOS //
	
function verPresupuestosCliente($clienteId){
	$query = sprintf('SELECT * FROM presupuestos WHERE clienteId=%d', $clienteId);
	return getFromDB($query);}

// COMUNICADOS //

function getGrupoComunicados($destinatario){
	$query = sprintf('SELECT * FROM comunicados WHERE destinatario= "%s" AND eliminado="0" GROUP BY userId ORDER BY  hecho ASC, prioridad DESC, time ASC ', $destinatario);
	return getFromDB($query);}
	
function getComunicados($destinatario, $userId){
	$query = sprintf('SELECT * FROM comunicados WHERE destinatario="%s" AND eliminado="0" AND userId= %d ORDER BY  hecho ASC, prioridad DESC, time ASC', $destinatario, $userId);
	return getFromDB($query);}
	
function getPedidosPorCliente($estado){
	$query = sprintf('SELECT * FROM pedidos_c WHERE estado = "%s" GROUP BY clienteId ORDER BY npedido DESC', $estado);
	return getFromDB($query);}
	
function getArticulosPorPedido($clienteId, $estado){
	$query = sprintf('SELECT * FROM pedidos_c WHERE estado = "%s" AND clienteId = %d GROUP BY npedido ORDER BY fecha DESC', $estado, $clienteId);
	return getFromDB($query);}
	
function getPedidosPendientes($npedido, $estado){
	$query = sprintf('SELECT * FROM pedidos_c WHERE estado = "%s" AND npedido = %d ORDER BY fecha DESC', $estado, $npedido);
	return getFromDB($query);}
	
function getTroqueles(){
	$query = sprintf('SELECT * FROM troqueles');
	return getFromDB($query);}

function getTroquelById($troquel_id){
	$query = sprintf('SELECT * FROM troqueles WHERE troquel_id=%d', $troquel_id);
	return getFromDB($query);}
	
function getAcabado($acabado_Id){
	$query = sprintf('SELECT * FROM acabado where acabadoId=%d', $acabado_Id);
	$acabado = getFromDB($query);
	return $acabado[0];}

function getAcabados(){
	$query = sprintf('SELECT * FROM acabado');
	return getFromDB($query);
	}
	
function getMaterial($material_Id){
	$query = sprintf('SELECT * FROM material WHERE material_Id=%d', $material_Id);
	$material = getFromDB($query);
	return $material[0];}
	
function getMateriales(){
	$query = sprintf('SELECT * FROM material');
	return getFromDB($query);}
	
function getTinta($tintaId){
	$query = sprintf('SELECT ntintas FROM tintas WHERE tintaId=%d', $tintaId);
	return getFromDB($query);}

function getTextTinta($tintaId){
	$query = sprintf('SELECT descripcion FROM tintas WHERE tintaId=%d', $tintaId);
	$tinta = getFromDB($query);
	return $tinta[0]['descripcion'];}

function getTintas(){
	$query = sprintf ('SELECT * FROM tintas');
	$tintas = getFromDB($query);
	return $tintas;}

function getAgenteCliente($cliente){
	$query = sprintf ('SELECT agente FROM clientes WHERE userId = %d', $cliente);
	$agente = getFromDB($query);
	return $agente[0]['agente'];
}

function comisionAgente($cliente){
	global $comisionAgente;
	$query = sprintf ('SELECT a.comision FROM agentes a, clientes c WHERE a.userId = c.agente AND c.userId = %d',$cliente);
	$comision = getFromDB($query);
	$comision = $comision[0]['comision'];
	if(empty($comision)){$comision = 0;}
	return $comision; 
}
function getSellos(){
	$query = sprintf('SELECT * FROM  sellos ORDER BY sellos_Id ASC');
	$sellos = getFromDB($query);
	return $sellos;}

function getSello($sello){
	$query = sprintf('SELECT * FROM sellos WHERE sellos_Id=%s', $sello);
	$result = getFromDB($query);
	return $result[0];
}
?>