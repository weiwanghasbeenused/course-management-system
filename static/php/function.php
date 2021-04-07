<?

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
function get_item($id, $tablename, $fields = array())
{
	global $pdo;

	if( empty($fields) )
		$sql = 'SELECT * ';
	else
		$sql = 'SELECT ' . implode($fields, ',') . ' ';
	$sql .= 'FROM ' . $tablename . " WHERE active = '1' AND id = '".$id."'";

	$pdoStmt = $pdo->prepare($sql);
	if($pdoStmt->execute()){
		$items = array();
		while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC))
			$items[] = $item;
		if(count($items) == 0)
			return NULL;
		else
			return $items[0];
	}
	else
		return false;
}

/*
	Get items whose foreign key is your id	
*/
function get_accosiated_item($id, $tablename, $fields = array())
{
	global $pdo;
	global $tables;

	$notEmpty = false;
	$associated_tables = array();
	$output = array();
	$output['all'] = array();
	$fk_name = 'fk_' . $tablename;
	foreach($tables as $key => $table)
	{
		$this_columns = $table['columns'];
		foreach($this_columns as $ckey => $column)
		{
			// var_dump($ckey);
			if($ckey == $fk_name)
			{
				$this_associated_table = array(
					'tablename' => $key,
					'display_column' => $table['display_column']
				);
				$associated_tables[] = $this_associated_table;
				break;
			}
		}
	}

	if( empty($fields) )
		$sql_temp = 'SELECT * ';
	else
		$sql_temp = 'SELECT ' . implode($fields, ',') . ' ';
	foreach($associated_tables as $table){
		$this_tablename = $table['tablename'];
		$sql = $sql_temp . 'FROM ' . $this_tablename . " WHERE active = '1' AND " . $fk_name . " = '".$id."'";
		$pdoStmt = $pdo->prepare($sql);
		try{
			if($pdoStmt->execute()){
				$items = array();
				while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC)){
					$items[] = $item;
					$item['display_column'] = $table['display_column'];
					$output['all'][] = $item;
				}
				if(!empty($items))
					$notEmpty = true;
				$output[$this_tablename] = $items;
					
			}
			else
				return false;
		}
		catch(Exception $err)
		{
			echo "Exception in get_accosiated_item()";
			echo $err;
		}
	}
	
	if($notEmpty)
		return $output;
	else
		return NULL;
	
	
	
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
function update($tablename, $id, $values = array())
{
	global $pdo;
	global $tables;

	if(!empty($values))
	{
		$this_columns = $tables[$tablename]['columns'];
		$syntax_set_arr = array();
		foreach($this_columns as $key => $column)
		{
			$this_column = $key;
			if( isset($values[$this_column]) && $values[$this_column]){
				$syntax_set_arr[] = $this_column . " = " . $values[$this_column];
			}
		}

		$syntax_set = implode($syntax_set_arr, ',');
		$sql = 'UPDATE ' . $tablename . ' SET ' . $syntax_set . " WHERE id = '" . $id . "'";

		$pdoStmt = $pdo->prepare($sql);
		try
		{
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
		catch(Exception $err)
		{
			echo 'error in update()';
		}
			
	}
	else{
		echo '<p class="error-msg">Empty $values in insert(). </p>';
		return false;
	}

}
function delete($tablename, $id, $values = array())
{
	global $pdo;
	global $tables;

	if(!empty($values))
	{
		$associated_items = array();
		foreach($tables as $key => $table)
		{
			$columns = $table['columns'];
			$display_column = $table['display_column'];
			foreach($columns as $ckey => $column)
			{
				if($ckey == 'fk_' . $tablename)
				{
					$associated_updated = $update($key, $columns['id'], array('fk_' . $tablename=>0));
					if(!$associated_updated)
						return false;
				}
			}
		}

		$this_columns = $tables[$tablename]['columns'];
		$syntax_set_arr = array();
		foreach($this_columns as $key => $column)
		{
			$this_column = $key;
			if( isset($values[$this_column]) && $values[$this_column]){
				$syntax_set_arr[] = $this_column . " = " . $values[$this_column];
			}
		}

		$syntax_set = implode($syntax_set_arr, ',');
		$sql = 'UPDATE ' . $tablename . ' SET ' . $syntax_set . " WHERE id = '" . $id . "'";

		$pdoStmt = $pdo->prepare($sql);
		try
		{
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
		catch(Exception $err)
		{
			echo 'error in update()';
		}
			
	}
	else{
		echo '<p class="error-msg">Empty $values in insert(). </p>';
		return false;
	}

}
?>