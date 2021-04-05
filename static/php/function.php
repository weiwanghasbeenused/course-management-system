<?

function print_list_item($item, $table){
	global $tables;
}
function get_all($tablename, $fields = array())
{
	global $pdo;

	if( empty($fields) )
		$sql = 'SELECT * ';
	else
		$sql = 'SELECT ' . implode($fields, ',') . ' ';
	$sql .= 'FROM ' . $tablename . " WHERE active = '1'";

	$pdoStmt = $pdo->prepare($sql);
	if($pdoStmt->execute()){
		$items = array();
		while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC))
			$items[] = $item;
		if(count($items) == 0)
			return NULL;
		else
			return $items;
	}
	else
		return false;
}
function get_accosiated_item($foreign_key, $foreign_table, $foreign_id_name = false, $fields = array())
{
	global $pdo;

	if( empty($fields) )
		$sql = 'SELECT * ';
	else
		$sql = 'SELECT ' . implode($fields, ',') . ' ';
	$sql .= 'FROM ' . $tablename . " WHERE active = '1' AND ".$foreign_id_name." = '".$FK."'";

	$pdoStmt = $pdo->prepare($sql);
	if($pdoStmt->execute()){
		$items = array();
		while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC))
			$items[] = $item;
		if(count($items) == 0)
			return NULL;
		else
			return $items;
	}
	else
		return false;
	
}
function insert($tablename, $values = array())
{
	global $pdo;
	global $tables;

	if(!empty($values))
	{
		$this_columns = $tables[$tablename]['columns'];
		$columns_to_insert_arr = array();
		$values_to_insert_arr = array();
		foreach($this_columns as $key => $column)
		{
			$this_column = $key;
			if( isset($values[$this_column]) && $values[$this_column]){
				$columns_to_insert_arr[] = '`' . $this_column . '`';
				$values_to_insert_arr[] = $values[$this_column];
			}
		}

		$columns_to_insert = '(' . implode($columns_to_insert_arr, ',') . ')';
		$values_to_insert = '(' . implode($values_to_insert_arr, ',') . ')';
		$sql = 'INSERT INTO ' . $tablename . $columns_to_insert . ' VALUES' . $values_to_insert;

		$pdoStmt = $pdo->prepare($sql);
		if($pdoStmt->execute())
		{
			return true;
		}
		else
		{
			echo $pdoStmt->errorCode();
			return false;
		}		
	}
	else{
		echo '<p class="error-msg">Empty $values in insert(). </p>';
		return false;
	}
}
?>