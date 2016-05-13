<?php
require_once '../objects/Empresa.php';
$empresa = new Empresa();
$handle = fopen('Clientes.csv', "r");
$linea = 0;

while($data = fgetcsv($handle, 500,";")){
		if ($data[0] == 'Listado de Clientes') { $linea = $linea -3;} 
		if ($linea == 0) {
			$query = 'INSERT INTO empresas (empresa_Id, fiscal_Id, nombre, direccion, cp, localidad, provincia, telefono, fax) VALUES ';
			$query = $query.'("'.$data[0].'", "'.$data[6].'", "'.$data[1].'", "'.$data[2].'", "'.$data[5].'", "'.$data[3].'", "'.$data[4].'", "'.$data[7].'", "'.$data[8].'");  '; 
			$empresa->insertDB($query);
			var_dump($query); 
		} 
	if($linea == 0){$linea = -2;}
	$linea++;
}


?>