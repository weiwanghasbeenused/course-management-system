<?

function get_all($tablename, $fields = array())
{
	global $pdo;

	$tablename = strtolower($tablename);
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

	$tablename = strtolower($tablename);
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

	$tablename = strtolower($tablename);
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

	$tablename = strtolower($tablename);
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

	$tablename = strtolower($tablename);
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
function delete($id, $tablename)
{
	global $pdo;
	global $tables;

	$tablename = strtolower($tablename);
	$associated_items = get_accosiated_item($id, $tablename);
	$fk_name = 'fk_' . $tablename;
	foreach($associated_items as $table => $items)
	{
		if($table != 'all')
		{
			$this_tablename = $table;
			$sql_temp = 'UPDATE ' . $this_tablename . ' SET ' . $fk_name . " = '0' WHERE id = '";

			foreach($items as $item)
			{
				$sql = $sql_temp . $item['id'] . "'";
				
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
					echo 'error in delete()';
				}
			}
		}
	}
	
	$sql = 'UPDATE ' . $tablename . " SET active = '0' WHERE id = '" . $id . "'";

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
		echo 'error in delete()';
	}		
}

function display_filter($filter_arr, $get_arr){
	global $pdo;
	global $tables;

	?>
	<div class="form-container">
	<form id="search-form" 
		  enctype="multipart/form-data"
		  action=""
		  method="GET"><?
	foreach ($filter_arr as $cname => $column){
			?><div class="search-form-section"><?
			if($column['filter-type'] == 'range')
			{
				if(isset($get_arr) && $get_arr[$cname . '_min'])
					$this_value_min = $get_arr[$cname . '_min'];
				else
					$this_value_min = '';
				if(isset($get_arr) && $get_arr[$cname . '_max'])
					$this_value_max = $get_arr[$cname . '_max'];
				else
					$this_value_max = '';
				?>
				<label for=""><?= $column['display_name']; ?></label><input id = "search-<?= $cname; ?>_min" type = "text" name = "<?= $cname; ?>_min" class="list-filter-field list-filter-field-range" value="<?= $this_value_min; ?>" placeholder="min">&nbsp;&mdash;&nbsp;<input id = "search-<?= $cname; ?>_max" type = "text" name = "<?= $cname; ?>_max" class="list-filter-field list-filter-field-range" value = '<?= $this_value_max; ?>' placeholder="max">
				<?
			}
			elseif($column['filter-type'] == 'select')
			{
				$foreign_tablename = substr($cname, 3);
				var_dump($column['tablename']);
				$foreign_display_column = $tables[$foreign_tablename]['display_column'];
				$sql = 'SELECT DISTINCT ' . $cname . ' FROM ' . $column['tablename'];
				$options = array();
				$pdoStmt = $pdo->prepare($sql);
				if($pdoStmt->execute())
				{
					while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC))
						$options[] = $item;
				}
				// var_dump($options);
				if(!empty($options))
				{
					if(isset($get_arr) && $get_arr[$cname])
						$this_value = $get_arr[$cname];
					else
						$this_value = '';

					?><label><?= $column['display_name']; ?></label><select class="list-filter-field" name="<?= $cname; ?>"><option>不限</option><?
					if( substr($cname, 0, 3) == 'fk_')
					{
						foreach($options as $option)
						{
							$id = $option[$cname];
							if($id === $this_value)
								$selected = 'selected';
							else
								$selected = '';
							$option_name = get_item($id, $foreign_tablename, array($foreign_display_column))[$foreign_display_column];
							?><option value="<?= $id; ?>" <?= $selected; ?>><?= $option_name; ?></option><?
						}
					}
					else
					{
						foreach($options as $option)
						{
							$option_value = $option[$cname];
							if($option_value == $this_value)
								$selected = 'selected';
							else
								$selected = '';
							$option_name = $option_value
							?><option value="<?= $id; ?>" <?= $selected; ?>><?= $option_name; ?></option><?
						}
					}
					
					?></select><?
				}
			}
			else
			{
				if(isset($get_arr) && $get_arr[$cname])
					$this_value = $get_arr[$cname];
				else
					$this_value = '';
				?><label><?= $column['display_name']; ?></label><input type = "text" name = "<?= $cname; ?>" value = "<?= $this_value; ?>" class="list-filter-field" ><?
			}
			?></div><?
		} ?>
		</form>
		<div class="btn-container">
			<button id='search-btn' class="btn" form="search-form">查詢</button><button id='reset-btn' class="btn alert-btn" >清除</button>
		</div>
	</div>
<?
}
?>