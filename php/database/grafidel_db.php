<?php 
class grafidelDB{
	private static $hostname = 'localhost'; 
	private static $database = 'grafidel';
	private static $username = 'adsilmar';        /* root */ /* */
	private static $password = 'Kalashnikov1+';
	
	public static function getFromDB($query){
		$mysqli = new MySQLi(self::$hostname, self::$username, self::$password, self::$database) or die ("ERROR: No se estableció la conexión. ". mysqli_connect_error());
		$result = $mysqli->query($query);
		return $result->fetch_assoc();
	}
	
	public static function getListFromDB($query){
		$mysqli = new MySQLi(self::$hostname, self::$username, self::$password, self::$database); if($mysqli->connect_error) {die ($mysqli->connect_error);}
		$result = $mysqli->query($query);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	public static function updateFromDB($query){
		$mysqli = new MySQLi(self::$hostname, self::$username, self::$password, self::$database); if($mysqli->connect_error) {die ($mysqli->connect_error);}
		$result = $mysqli->query($query);
		return $result;
	}
	
	public static function insertDB($query){
		$mysqli = new MySQLi(self::$hostname, self::$username, self::$password, self::$database) or die ("ERROR: No se insertó el elemento en la base de datos. ". mysqli_connect_error('error'));
		return $mysqli->query($query);
	}
}
?>

