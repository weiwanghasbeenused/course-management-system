<?
	if(isset($_POST['action']) &&  $_POST['action'] == 'search'){
		var_dump($_POST);
		$search_keyword = $_POST['keyword'];
		$search_table = $_POST['table'][0];
		$results = array();
		if($search_table == 'All' && isset($search_keyword))
		{
			foreach($tables as $key => $table){
				$this_columns = $table['columns'];
				$concat_temp = array();
				$sql_concat = 'CONCAT_WS(';
				foreach($this_columns as $ckey => $column)
					$concat_temp[] = $ckey;
				$sql_concat .= implode(',', $concat_temp) . ')';
				$sql = 'SELECT * FROM ' . $key . ' WHERE ' . $sql_concat . " LIKE '%" . $search_keyword . "%'";
				// var_dump($sql);
				$pdoStmt = $pdo->prepare($sql);
				try
				{
					if($pdoStmt->execute())
					{
						echo 'kk';
						while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC)){
							$results[$key][] = $item;
						}
					}
					
				}
				catch(Exception $err)
				{
					echo 'error in search.php';
					echo $err;
				}
			}
		}
		else{
			$this_columns = $tables[$search_table]['columns'];
			$sql = 'SELECT * FROM ' . $search_table;
			$sql_where_arr = array();
			$sql_where_extra_fields = array();
			if($search_keyword)
			{
				$concat_temp = array();
				$sql_concat = 'CONCAT_WS(';
				foreach($this_columns as $ckey => $column)
					$concat_temp[] = $ckey;
				$sql_concat .= implode(',', $concat_temp) . ')';
				$sql_where_arr[] = $sql_concat . " = '%" . $search_keyword . "%'";
			}
			$extra_fields = array();
			foreach($_POST as $key => $post)
			{
				if( substr($key, 0, 6) == 'extra-' && !empty($post))
				{
					$this_key = substr($key, 6);
					$extra_fields[$this_key] = $post;
				}
			}
			if(!empty($extra_fields))
			{
				foreach($extra_fields as $key => $value){
					if(strpos($key , 'date') === false )
					{
						$sql_where_extra_fields[] = $key . " = '" . $field . "'";
					}
					else
					{
						$date_min = $value[0];
						$date_max = $value[1];
						if($date_min && $date_max)
							$sql_where_extra_fields[] = '(' . $key . " BETWEEN '" . $date_min . "' AND '". $date_max ."')";
						else if($date_min)
							$sql_where_extra_fields[] = $key . " >= '" . $date_min . "'";
						else if($date_max)
							$sql_where_extra_fields[] = $key . " <= '" . $date_max . "'";
					}
				}

				$sql_where_extra = implode(' AND ', $sql_where_extra_fields);

				$sql_where_arr[] = $sql_where_extra;
			}
			if(!empty($sql_where_arr))
				$sql .= ' WHERE ' . implode(',', $sql_where_arr);
			// var_dump($sql);
			// die();
			$pdoStmt = $pdo->prepare($sql);
			try
			{
				if($pdoStmt->execute())
				{
					echo 'kk';
					while($item = $pdoStmt->fetch(PDO::FETCH_ASSOC)){
						$results[$search_table][] = $item;
					}
				}
				
			}
			catch(Exception $err)
			{
				echo 'error in search.php';
				echo $err;
			}
		}
		
		
	}
?>
<div id="search-container" class="container">
	<div id ="filter-container">
		<form id="search-form" 
		  enctype="multipart/form-data"
		  action=""
		  method="POST">
			<input type = "hidden" name = "action" value = "search">
			<div class="search-form-section">
				<input type = "text" name = "keyword" value="<?= isset($search_keyword) ? $search_keyword : ''; ?>">
			</div>
			<div class="search-form-section form-checkbox-section">
				<p>Search in certain table:</p>
				<? $isChecked = (!isset($search_table) || $search_table == 'All') ? 'checked' : ''; ?>
				<div class="search-table-option"><div class="tablename">all</div><label for="search-table-all">All</label><input id ="search-table-all" class="form-checkbox" type = "radio" name="table[]" value="All" <?= $isChecked; ?> ></div>
				<? foreach($tables as $key => $table){
					$isChecked = (isset($search_table) && $search_table == $key) ? 'checked' : '';
					?><div class="search-table-option"><div class="tablename"><?= $key; ?></div><label for="search-table-<?= $table['url']; ?>"><?= $table['display_name']; ?></label><input id ="search-table-<?= $table['url']; ?>" class="form-checkbox" type = "radio" name="table[]" value="<?= $key; ?>" <?= $isChecked; ?> ></div><?
				} ?>
			</div>
			<div id="search-form-extra-fields"></div>
		</form>
		<button id='submit-btn' class="btn" form="search-form">Search</button>
	</div>
	<? if(!isset($_POST['action'])){
		?>

		<?
	}elseif($_POST['action'] == 'search'){
		?>
		<div id = "result-container">
			<? if(count($results) > 0){
				foreach($results as $tablename => $table_results){
					?><div><?= $tablename; ?></div><?
					$this_display_column = $tables[$tablename]['display_column'];
					foreach($table_results as $result)
					{
						?><div><?= $result['id'] . ' ' . $result[$this_display_column] ?></div><?
					}
				}
			} ?>
		</div>
		<?
	} ?>
</div>
<script>
	var sForm_checkbox = document.getElementsByClassName('form-checkbox');
	var sSearch_form_extra_fields = document.getElementById('search-form-extra-fields');
	var tables = <?= json_encode($tables); ?>;
	var table_name = '';
	var requestUrl_fk = "/views/ajax-foreign-item-list.php";
	[].forEach.call(sForm_checkbox, function(el, i){
		el.addEventListener('click', function(){
			console.log('click');
			var thisTable = el.parentNode.querySelector('.tablename').innerText;
			table_name = thisTable;
			sSearch_form_extra_fields.innerHTML = '';
			if(thisTable != 'all')
			{
				var thisColumns = tables[thisTable]['columns'];
				var thisHtml = '';
				var thisHtml_temp = '';
				for(const prop in thisColumns)
				{
					if( prop.indexOf('_date') != -1 )
					{
						if(thisHtml_temp == '')
							thisHtml_temp += '<div class="search-form-section">';
						thisHtml_temp += '<label for="search-extra-' + prop + '">' + thisColumns[prop]['display_name'] + '</label><input id = "search-extra-' + prop + '_start" type = "text" name = "extra-'+prop+'[]">&mdash;<input id = "search-extra-' + prop + '_end" type = "text" name = "extra-'+prop+'[]">';
					}
					
				}
				if(thisHtml_temp != ''){
					thisHtml_temp += '</div>';
					sSearch_form_extra_fields.innerHTML += thisHtml_temp;
					thisHtml_temp = '';
				}
				for(const prop in thisColumns)
				{
					if( prop.indexOf('fk_') != -1 )
					{
						var thisForeign_tablename = prop.substr(3);
						var request_parameter = table_name + "," + thisForeign_tablename;
						sendAjax_foreignItemList(requestUrl_fk, thisForeign_tablename, request_parameter, sSearch_form_extra_fields);
					}
				}
			}

		});
	});

	function sendAjax_foreignItemList(request_url = false, foreign_tablename, request_parameter = '', element = false)
	{
		console.log('sendAjax_foreignItemList');
		if(request_url)
		{
			var thisHtml_temp = '';
			if(window.XMLHttpRequest)
				var xmlhttp = new XMLHttpRequest();
			else
				var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			xmlhttp.onreadystatechange = function() 
			{
				if(xmlhttp.readyState < 4) 
					console.log("waiting");
				else if(xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
					if(xmlhttp.responseText)
					{
						var response = JSON.parse(xmlhttp.responseText);
						if(response.length != 0)
						{
							if(thisHtml_temp == '')
								thisHtml_temp += '<div class="search-form-section"><select name="extra-fk_'+foreign_tablename+'">';
							response.forEach(function(item, i){
								thisHtml_temp += '<option value="' + item['id'] + '">' + item['name'] + '</option>';
							});
							if(thisHtml_temp != ''){
								thisHtml_temp += '</select></div>';
								element.innerHTML += thisHtml_temp;
								thisHtml_temp = '';
							}
						}
					}
					else
					{
						// no more posts to load
						// 'done' animation
						// animate(68);
					}
				}
			}
			xmlhttp.open("POST", request_url, true);
			xmlhttp.setRequestHeader( "Content-Type", "application/json" );
			xmlhttp.send(request_parameter);
		}
		else
			return false;
		
	}
</script>