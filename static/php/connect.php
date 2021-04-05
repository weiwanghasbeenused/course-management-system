<?
$hostname_conn = "localhost";
$database_conn = "course_management_system_local";
$username_conn = "root";
$password_conn = "f3f4p4ax";
try {
	$pdo = new PDO('mysql:host='.$hostname_conn.'; port=3306; dbname='.$database_conn.'; charset=utf8', $username_conn, $password_conn,
			array(PDO::ATTR_EMULATE_PREPARES=>false,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_PERSISTENT => true
			)
	);
	//$pdo->exec("set names utf8");   // PHP 5.3.6 以前的版本 charset=utf8是無效的，必須使欲用此敘述
	//echo "成功建立連線(PDO)<br>";
}
catch(PDOException $ex){
	echo 'Error on database: ' . $ex->getMessage() . "\n";
	echo 'Line: ' . $ex->getLine() . "\n";
	echo 'Trace: ' . $ex->getTraceAsString() . "\n";
}

?>