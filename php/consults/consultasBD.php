<?php
require_once ('../php/database/grafidel_db.php');
require_once ('../php/objects/Articulo.php');

$db = new grafidelDB;

// -> USUARIOS

function verNombreUsuario($usuario){
	global $db;
	$query = sprintf('SELECT nombre FROM usuarios WHERE userId=%d', $usuario);
	$nombre = $db->getFromDB($query);
	return $nombre;
}
function verEmpresaUsuario($usuario){
	global $db;
	$query = sprintf('SELECT empresa FROM usuarios WHERE userId=%d', $usuario);
	$empresa = $db->$db->getFromDB($query);
	return $empresa;
}
// -> CLIENTES
function verClientes(){
	global $db;
	$query = ('SELECT * FROM usuarios u, perfiles p, clientes c WHERE u.userId=p.userId AND u.userId=c.userId ORDER BY empresa ASC');
	return $db->getListFromDB($query);}// Devuelve un array de clientes con todos sus datos.
	
function verClienteActual(){
	global $db; 
	$query = sprintf("SELECT * FROM usuarios WHERE userId=%d",$_SESSION['userId']);
	return $db->$db->getFromDB($query);}// Devuelve los datos del usuario actual en la sesión.
	
function verCliente($userId){
	global $db;
	$query = sprintf('SELECT * FROM usuarios WHERE userId = %d', $userId);
	$cliente = $db->getFromDB($query);
	return $cliente;}
	
function isMayorista($cliente){
	global $db;
	$query = sprintf('SELECT usertype FROM usuarios u, clientes c WHERE u.userId = c.userId AND u.userId=%s',$cliente);
	$result = $db->getFromDB($query);
	if ($result == 'Mayorista'){return true;}
	else {return false;}
}
// -> PROVEEDORES
function verProveedores(){
	global $db;
	$query = ('SELECT * FROM usuarios WHERE usertype="Proveedor"');
	$result = $db->getListFromDB($query);
	return $result;
}

// -> ARTICULOS	
function articulosList(){
	global $db;
	$query = "SELECT * FROM articulos ORDER BY categoria";
	return $db->getListFromDB($query);}
	
function getCosteArticulo($articuloId){
	global $db;
	$query = sprintf('SELECT coste FROM articulos WHERE articuloId = %d', $articuloId);
	$coste = $db->getFromDB($query);
	return (float)$coste[0];}

function getArticulo($articuloId){
	global $db;
	$query = sprintf("SELECT * FROM articulos WHERE articuloId=%d", $articuloId);
	$articulo = $db->getFromDB($query);
	return $articulo;}
	
// -> PRESUPUESTOS
function verPresuCliente(){
	global $db;
	$query = sprintf("SELECT * FROM etiq_impresas e, articulos a WHERE a.articuloId = e.articuloId AND userId=%d", GetSQLValueString($_SESSION['userId'],"int"));
	return $db->getFromDB($query);}

function verPresupuestosPorClientes(){
	global $db;
	$query = sprintf('SELECT * FROM presupuestos WHERE activo=1 AND pedido = 0 GROUP BY clienteId');
	$res = $db->getListFromDB($query);
	return $res;
	}
function verPresupuestosAgrupados($clienteId){
	global $db;
	$query = sprintf('SELECT a.grupo FROM presupuestos p, articulos a WHERE a.articuloId=p.articuloId AND p.activo=1 AND p.pedido = 0 AND p.clienteId = %s GROUP BY a.grupo', $clienteId);
	return $db->getListFromDB($query);
}

function verPresupuestosPorGrupoCliente($cliente, $grupo){
	global $db;
	$grupo = '"'.$grupo.'"';
	$query = sprintf('SELECT p.presupuesto_id, p.fecha, p.articuloId, p.clienteId, p.descripcion, p.cantidad, p.categoria, p.precio, p.activo, a.formatoPrecio, a.imagen, a.oferta, p.proveedorId FROM presupuestos p, articulos a WHERE a.articuloId = p.articuloId AND p.activo=1 AND p.pedido = 0 AND p.clienteId = %s AND a.grupo = %s', $cliente, $grupo);
	return $db->getListFromDB($query);
}
// -> PRECIOS

function verPreciosPedidosClientes(){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c GROUP BY clienteId');
	return $db->getListFromDB($query);
}

function verPreciosAgrupados($cliente){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c p, articulos a WHERE a.articuloId = p.articuloId AND clienteId=%s GROUP BY a.grupo', $cliente);
	return $db->getListFromDB($query);
}

function verPreciosAgrupadosArticulos($cliente, $grupo){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c p, articulos a WHERE a.articuloId = p.articuloId AND clienteId=%s AND a.grupo=%s', $cliente, $grupo);
	return $db->getListFromDB($query);
}

// -> CATEGORIAS	
function verNomCatId($categoriaId){
	global $db;
	$query = 'SELECT * FROM categorias WHERE categoriaId='.$categoriaId;
	return  $db->getFromDB($query);}

function verCategorias(){
	global $db;
	$query = 'SELECT * FROM categorias WHERE mostrar=1';
	$res = $db->getListFromDB($query);
	return $res;}

function verCategoriasEsp(){
	global $db;
	$query = sprintf("SELECT * FROM categorias WHERE mostrar=1 AND especial=0");
	return $db->getListFromDB($query);}
	
function verFormatosPrecio(){
	global $db;
	$query = ("SELECT * FROM formatoprecios");
	return $db->getListFromDB($query);}
	
function tiposRibbon(){
	global $db;
	$query = ("SELECT * FROM ribbon");
	return $db->getListFromDB($query);}

// PEDIDOS //
	
function pedidosCliente($userId){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c WHERE clienteId = %d', $userId);
	return $db->getListFromDB($query);}
	
function pedidosClienteNpedido($userId){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c WHERE clienteId = %d GROUP BY npedido', $userId);
	return $db->getListFromDB($query);}
	
function verDetallePedido($userId, $npedido){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c WHERE clienteId = %d AND npedido = %d', $userId, $npedido);
	return $db->getFromDB($query);}
	
function verPedidos(){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c GROUP BY npedido');
	return $db->getListFromDB($query);}

// PRESUPUESTOS //
	
function verPresupuestosCliente($clienteId){
	global $db;
	$query = 'SELECT * FROM presupuestos WHERE clienteId='.$clienteId;
	return $db->getListFromDB($query);}

// COMUNICADOS //

function getGrupoComunicados($destinatario){
	global $db;
	$query = sprintf('SELECT * FROM comunicados WHERE destinatario= "%s" AND eliminado="0" GROUP BY userId ORDER BY  hecho ASC, prioridad DESC, time ASC ', $destinatario);
	return $db->getListFromDB($query);}
	
function getComunicados($destinatario, $userId){
	global $db;
	$query = sprintf('SELECT * FROM comunicados WHERE destinatario="%s" AND eliminado="0" AND userId= %d ORDER BY  hecho ASC, prioridad DESC, time ASC', $destinatario, $userId);
	return $db->getListFromDB($query);}
	
function getPedidosPorCliente($estado){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c WHERE estado = "%s" GROUP BY clienteId ORDER BY npedido DESC', $estado);
	return $db->getListFromDB($query);}
	
function getArticulosPorPedido($clienteId, $estado){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c WHERE estado = "%s" AND clienteId = %d GROUP BY npedido ORDER BY fecha DESC', $estado, $clienteId);
	return $db->getListFromDB($query);}
	
function getPedidosPendientes($npedido, $estado){
	global $db;
	$query = sprintf('SELECT * FROM pedidos_c WHERE estado = "%s" AND npedido = %d ORDER BY fecha DESC', $estado, $npedido);
	return $db->getListFromDB($query);}
	
function getTroqueles(){
	global $db;
	$query = sprintf('SELECT * FROM troqueles');
	return $db->getListFromDB($query);}

function getTroquelById($troquel_id){
	global $db;
	$query = sprintf('SELECT * FROM troqueles WHERE troquel_id=%d', $troquel_id);
	return $db->getFromDB($query);}
	
function getAcabado($acabado_Id){
	global $db;
	$query = sprintf('SELECT * FROM acabado where acabadoId=%d', $acabado_Id);
	$acabado = $db->getFromDB($query);
	return $acabado;}

function getAcabados(){
	global $db;
	$query = sprintf('SELECT * FROM acabado');
	return $db->getListFromDB($query);
	}
	
function getMaterial($material_Id){
	global $db;
	$query = sprintf('SELECT * FROM material WHERE material_Id=%d', $material_Id);
	$material = $db->getFromDB($query);
	return $material;}
	
function getMateriales(){
	global $db;
	$query = sprintf('SELECT * FROM material');
	return $db->getListFromDB($query);}
	
function getTinta($tintaId){
	global $db;
	$query = sprintf('SELECT ntintas FROM tintas WHERE tintaId=%d', $tintaId);
	return $db->getFromDB($query);}

function getTextTinta($tintaId){
	global $db;
	$query = sprintf('SELECT descripcion FROM tintas WHERE tintaId=%d', $tintaId);
	$tinta = $db->getFromDB($query);
	return $tinta[0]['descripcion'];}

function getTintas(){
	global $db;
	$query = sprintf ('SELECT * FROM tintas');
	$tintas = $db->getListFromDB($query);
	return $tintas;}

function getAgenteCliente($cliente){
	global $db;
	$query = sprintf ('SELECT agente FROM clientes WHERE userId = %d', $cliente);
	$agente = $db->getFromDB($query);
	return $agente;
}

function comisionAgente($cliente){
	global $db;
	global $comisionAgente;
	$query = sprintf ('SELECT a.comision FROM agentes a, clientes c WHERE a.userId = c.agente AND c.userId = %d',$cliente);
	$comision = $db->getFromDB($query);
	$comision = $comision;
	if(empty($comision)){$comision = 0;}
	return $comision; 
}
function getSellos(){
	global $db;
	$query = sprintf('SELECT * FROM  sellos ORDER BY sellos_Id ASC');
	$sellos = $db->getListFromDB($query);
	return $sellos;}

function getSello($sello){
	global $db;
	$query = sprintf('SELECT * FROM sellos WHERE sellos_Id=%s', $sello);
	$result = $db->getFromDB($query);
	return $result[0];
}
?>