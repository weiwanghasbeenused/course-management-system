<?

class Model
{
	const MYSQL_DATE_FMT = "Y-m-d H:i:s";

	public static function get($id)
	{
		global $pdo;
		if(!is_numeric($id))
			throw new Exception('id not numeric.');
		$sql = 'SELECT * FROM ' . static::table_name .  
				'WHERE id = ' . $id . 
				'LIMIT 1';
		$pdoStmt = $pdo->prepare($query_product);
		$pdoStmt->execute(array($producID));
		if(!$pdoStmt)
			throw new Exception("I can't read German: " . $db->error);
		if($res->rowCount == 0)
			return NULL;
		$item = $pdoStmt->fetch(PDO::FETCH_ASSOC);
		// $res->close();
		return $item;
	}
}

?>