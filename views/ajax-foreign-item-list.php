<?
	date_default_timezone_set('Asia/Taipei');
	require_once('../static/php/connect.php');
	require_once('../static/php/tables.php');
	require_once('../static/php/function.php');
	$request_parameter = file_get_contents("php://input");
	$request_parameter = explode(',', $request_parameter);
	$tablename = $request_parameter[0];
	$foreign_tablename = $request_parameter[1];
	$foreign_display_column = $tables[$foreign_tablename]['display_column'];
	$fk_name = 'fk_' . $foreign_tablename;
	$sql = 'SELECT DISTINCT '. $foreign_tablename . '.* FROM '.$tablename.',' . $foreign_tablename . ' WHERE '. $tablename . '.' . $fk_name .' = '.$foreign_tablename.'.id AND ' . $foreign_tablename . ".active = '1'";
	$pdoStmt = $pdo->prepare($sql);
	$output = false;
	if($pdoStmt->execute()){
		$output = array();
		while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC)){
			$output[] = array(
				'id'   => $item['id'],
				'name' => $item[$foreign_display_column]
			);
		}
	}
	header('Content-Type: application/json');
	echo json_encode($output);
?>