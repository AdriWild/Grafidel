<?php
require_once '../objects/Articulo.php';
require_once '../objects/Presupuesto.php';
$etiqueta = array('nombre' 			=> $_POST['nombre'],
				  'categoria' 		=> 1,
				  'grupo'			=> 'Impresas',
				  'descripcion' 	=> ' '.$_POST['nombre'].' en '.$_POST['material'].' de '.$_POST['ancho'].' x '.$_POST['alto'].' '.$_POST['acabado'],
				  'formatoprecio'	=> 1,
				  'imagen'			=> $_FILES['imagen']['name'],
				  'coste'			=> $_POST['precio'],
				  'proveedor'		=> 0);



$articulo= new Articulo($etiqueta);
$articulo->insertArticulo();
$a_presupuesto = array ('articuloId'	=> $articulo->articuloId,
						'clienteId'		=> $_POST['cliente'],
						'proveedorId'	=> $articulo->proveedor,
						'descripcion'	=> $articulo->descripcion,
						'cantidad'		=> $_POST['cantidad'],
						'categoria'		=> $articulo->categoria,
						'precio'		=> $_POST['precio']);
$presupuesto = new Presupuesto($a_presupuesto);
$presupuesto->insertPresupuesto();
header ('Location: ../../ES/admin.php?page=30&cliente='.$_POST['cliente']);
?>