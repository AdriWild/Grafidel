<?php

class Figura{
	public static $alto = 3;
	public static $ancho = 4;


static function area(){
	$res = self::$alto * self::$ancho;
	return $res;

}


}

echo Figura::area();
?>