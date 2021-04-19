<?
foreach($tables as $key => $table)
{
	if($table['url'] == $uri[2])
		$table_name = $key;
}

$this_columns = $tables[$table_name]['columns'];
$filter_arr = array();
$filter_arr['keyword']['filter-type'] = 'input';
$filter_arr['keyword']['display_name'] = 'Keyword';
$filter_arr['keyword']['tablename'] = $table_name;
foreach($this_columns as $cname => $column)
{
	if(strpos($cname , 'date') !== false ){
		$filter_arr[$cname] = $column;
		$filter_arr[$cname]['filter-type'] = 'range';
		$filter_arr[$cname]['tablename'] = $table_name;
	}
	elseif(substr($cname , 0, 3) == 'fk_' ){
		$filter_arr[$cname] = $column;
		$filter_arr[$cname]['filter-type'] = 'select';
		$filter_arr[$cname]['tablename'] = $table_name;
	}
	
}


if(empty($_GET))
	$items = get_all($table_name);
else{
	$sql = 'SELECT * FROM '.$table_name." WHERE active = '1' AND ";
	$where = array();
	foreach ($filter_arr as $cname => $column)
	{
		if( isset($_GET[$cname])){
			$this_value = $_GET[$cname];
			if($filter_arr[$cname]['filter-type'] == 'input')
			{
				$this_columns = $tables[$table_name]['columns'];
				$concat_temp = array();
				$sql_concat = 'CONCAT_WS(';
				foreach($this_columns as $ckey => $column)
					$concat_temp[] = $ckey;
				$sql_concat .= implode(',', $concat_temp) . ')';
				$sql_concat .= " LIKE '%" . $this_value . "%'";
				$where[] = $sql_concat;
			}
			else{
				$where[] = $cname . " = '" . $this_value . "'"; 
			}
		}
		else if($filter_arr[$cname]['filter-type'] == 'range')
		{
			$this_value_min = $_GET[$cname . '_min'];
			$this_value_max = $_GET[$cname . '_max'];
			if($this_value_min && $this_value_max){
				$where[] = $cname . " BETWEEN " . $this_value_min . " AND " . $this_value_max;
			}
			elseif($this_value_min)
				$where[] = $cname . " >= " . $this_value_min;
			elseif($this_value_max)
				$where[] = $cname . " <= " . $this_value_max;
		}
			
	}

	$sql .= implode($where, ' AND ');
	$items = array();
	$pdoStmt = $pdo->prepare($sql);
	if($pdoStmt->execute()){
		$items = array();
		while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC))
			$items[] = $item;
	}
	
}
$no_item_msg = 'Currently there are no available records.';
?>
<section id="<?= isset($table_name) && $table_name ? strtolower($table_name). '-container' : ''; ?>" class="container list-container">
	<!-- 
	<form id="search-form" 
		  enctype="multipart/form-data"
		  action=""
		  method="GET">
		<? foreach ($filter_arr as $cname => $column){
			?><div class="search-form-section"><?
			if($column['filter-type'] == 'range')
			{
				if(isset($_GET) && $_GET[$cname . '_min'])
					$this_value_min = $_GET[$cname . '_min'];
				else
					$this_value_min = '';
				if(isset($_GET) && $_GET[$cname . '_max'])
					$this_value_max = $_GET[$cname . '_max'];
				else
					$this_value_max = '';

				?>
				<label for=""><?= $column['display_name']; ?></label><input id = "search-<?= $cname; ?>_min" type = "text" name = "<?= $cname; ?>_min" class="list-filter-field list-filter-field-range" value="<?= $this_value_min; ?>" placeholder="min">&nbsp;&mdash;&nbsp;<input id = "search-<?= $cname; ?>_max" type = "text" name = "<?= $cname; ?>_max" class="list-filter-field list-filter-field-range" value = '<?= $this_value_max; ?>' placeholder="max">
				<?
			}
			elseif($column['filter-type'] == 'select')
			{
				$foreign_tablename = substr($cname, 3);
				$foreign_display_column = $tables[$foreign_tablename]['display_column'];
				$sql = 'SELECT DISTINCT ' . $cname . ' FROM ' . $table_name;
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
					if(isset($_GET) && $_GET[$cname])
						$this_value = $_GET[$cname];
					else
						$this_value = '';

					?><select class="list-filter-field" name="<?= $cname; ?>"><option>不限</option><?
					foreach($options as $option)
					{
						$id = $option[$cname];
						if($id == $this_value)
							$selected = 'selected';
						else
							$selected = '';
						$option_name = get_item($id, $foreign_tablename, array($foreign_display_column))[$foreign_display_column];
						?><option value="<?= $id; ?>" <?= $selected; ?>><?= $option_name; ?></option><?
					}
					?></select><?
				}
			}
			else
			{
				if(isset($_GET) && $_GET[$cname])
					$this_value = $_GET[$cname];
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
	 -->
<?
display_filter($filter_arr, $_GET, $table_name);
if($items){
		?><div class="list-container">
		<div class="list-row list-title-row">
			<? foreach($this_columns as $key => $column){
				?><span class='list-cell cell-<?= $key; ?>'><?= $column['display_name']; ?></span><?
			} ?>
			<span class='list-cell' ></span>
		</div><?
		foreach($items as $item){
			?><div class="list-row">
				<? foreach($this_columns as $key => $column){
					if(substr($key, 0, 3) == 'fk_'){
						$foreign_table = substr($key, 3);
						$foreign_display_column = $tables[$foreign_table]['display_column'];
						$foreign_id = $item[$key];
						$foreign_item = get_item($foreign_id, $foreign_table);
						?><span class='list-cell cell-<?= $key; ?>'><?= $foreign_item[$foreign_display_column]; ?></span><?
					}
					else{
						?><span class='list-cell cell-<?= $key; ?>'><?= $item[$key]; ?></span><?
					}
					
				} ?>
				<span class='list-cell action-cell btn-container' ><a class="btn edit-btn" href="/edit/<?= $uri[2]; ?>?id=<?= $item['id']; ?>">編輯</a><a class="btn delete-btn alert-btn" href="/delete/<?= $uri[2]; ?>?id=<?= $item['id']; ?>">刪除</a></span>
			</div><?
		}
		?></div><?
}
else
{
	?><p class="error-msg"><?= $no_item_msg; ?></p><?
}
?>
</section>
<script src = '/static/js/after_list.js'></script>